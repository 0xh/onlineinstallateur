<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjAdmin extends pjAppController
{
	protected $extensions = array('gif', 'png', 'jpg', 'jpeg');
	
	protected $mimeTypes = array('image/gif', 'image/png', 'image/jpg', 'image/jpeg', 'image/pjpeg');
	
	public $defaultUser = 'admin_user';
	
	public $requireLogin = true;
	
	public function __construct($requireLogin=null)
	{
		$this->setLayout('pjActionAdmin');
		
		if (!is_null($requireLogin) && is_bool($requireLogin))
		{
			$this->requireLogin = $requireLogin;
		}
		
		if ($this->requireLogin)
		{
			if (!$this->isLoged() && !in_array(@$_GET['action'], array('pjActionLogin', 'pjActionForgot', 'pjActionValidate', 'pjActionExportFeed')))
			{
				if (!$this->isXHR())
				{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionLogin");
				} else {
					pjAppController::jsonResponse(array('redirect' => PJ_INSTALL_URL . "index.php?controller=pjAdmin&action=pjActionLogin"));
				}
			}
		}
	}
	
	public function afterFilter()
	{
		parent::afterFilter();
		
		foreach ($this->getJs() as $js)
		{
			if (strpos($js['file'], 'jquery.validate.') === 0)
			{
				$this->appendJs('index.php?controller=pjAdmin&action=pjActionValidate', PJ_INSTALL_URL, true);
				break;
			}
		}
	}
	
	public function beforeRender()
	{
		
	}
		
	public function pjActionIndex()
	{
		$this->checkLogin();
		
		if ($this->isAdmin() || $this->isEmployee())
		{
			$isoDate = isset($_GET['date']) && !empty($_GET['date']) ? $_GET['date'] : date("Y-m-d");
			$result = $this->pjActionGetDashboard($isoDate);

			$this->set('bs_arr', $result['bs_arr'])
				->set('t_arr', $result['t_arr'])
				->set('employee_arr', $result['employee_arr'])
				->set('service_arr', $result['service_arr']);
			
			$this->appendJs('pjAdmin.js');
			if ($this->isEmployee())
			{
				$this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true);
				$this->appendJs('pjEmployeeBookings.js');
			}
		} else {
			$this->set('status', 2);
		}
	}
	
	private function pjActionGetDashboard($isoDate)
	{
		$service_arr = pjServiceModel::factory()
			->select('t1.*, t2.content AS `name`')
			->join('pjMultiLang', sprintf("t2.model='pjService' AND t2.foreign_id=t1.id AND t2.locale='%u' AND t2.field='name'", $this->getLocaleId()), 'left outer')
			->findAll()
			->getData();
		$employee_arr = pjEmployeeModel::factory()
			->select("t1.*, t2.content AS `name`, (SELECT GROUP_CONCAT(CONCAT_WS('|', TS.id,TS.quantity) SEPARATOR '~:~') FROM `".pjServiceModel::factory()->getTable()."` AS TS WHERE TS.id IN (SELECT TMS.service_id FROM `".pjEmployeeServiceModel::factory()->getTable()."` AS TMS WHERE TMS.employee_id = t1.id ) ) AS services")
			->join('pjMultiLang', sprintf("t2.model='pjEmployee' AND t2.foreign_id=t1.id AND t2.locale='%u' AND t2.field='name'", $this->getLocaleId()), 'left outer')
			->findAll()
			->toArray('services', '~:~')
			->getData();

		$t_arr = FALSE;
		// Find out if given day is regular working day or not
		$range_arr = pjAppController::getDatesInRange($this->getForeignId(), $isoDate, $isoDate);
		if (isset($range_arr[0][$isoDate]) && $range_arr[0][$isoDate] == 'ON')
		{
			// Find out working time range for that day
			$t_arr = pjAppController::getSingleDateSlots($this->getForeignId(), $isoDate);
		}

		// Legacy code
		# $t_arr = pjAppController::getRawSlots($this->getForeignId(), $isoDate, 'calendar', $this->option_arr);
		
		$bs_arr = pjBookingServiceModel::factory()
			->select('t1.*, t2.c_name, t4.content AS `employee_name`, t5.content as `service_name`')
			->join('pjBooking', 't2.id=t1.booking_id', 'inner')
			->join('pjEmployee', 't3.id=t1.employee_id', 'inner')
			->join('pjMultiLang', "t4.model='pjEmployee' AND t4.foreign_id=t1.employee_id AND t4.locale=t2.locale_id AND t4.field='name'", 'left outer')
			->join('pjMultiLang', "t5.model='pjService' AND t5.foreign_id=t1.service_id AND t5.locale=t2.locale_id AND t5.field='name'", 'left outer')
			->where('t2.calendar_id', $this->getForeignId())
			->where('t2.booking_status', 'confirmed')
			->where('t1.date', $isoDate)
			->where($this->isEmployee() ? sprintf("t1.employee_id='%u'", $this->getUserId()) : "1=1")
			->findAll()
			->getData();
		
		return compact('bs_arr', 't_arr', 'service_arr', 'date', 'employee_arr');
	}
	
	public function pjActionPrint()
	{
		$this->checkLogin();
		
		$this->setLayout('pjActionPrint');
		
		$isoDate = isset($_GET['date']) && !empty($_GET['date']) ? $_GET['date'] : date("Y-m-d");
		$result = $this->pjActionGetDashboard($isoDate);
		
		$this->set('bs_arr', $result['bs_arr'])
			->set('t_arr', $result['t_arr'])
			->set('employee_arr', $result['employee_arr'])
			->set('service_arr', $result['service_arr']);
	}
	
	public function pjActionForgot()
	{
		$this->setLayout('pjActionAdminLogin');
		
		if (isset($_POST['forgot_user']))
		{
			if (!isset($_POST['forgot_email']) || !pjValidation::pjActionNotEmpty($_POST['forgot_email']) || !pjValidation::pjActionEmail($_POST['forgot_email']))
			{
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionForgot&err=AA10");
			}
			$pjUserModel = pjUserModel::factory();
			$user = $pjUserModel
				->where('t1.email', $_POST['forgot_email'])
				->limit(1)
				->findAll()
				->getData();
				
			if (count($user) != 1)
			{
				$pjEmployeeModel = pjEmployeeModel::factory();
				$employee = $pjEmployeeModel
					->select('t1.*, t2.content as name')
					->join('pjMultiLang', "t2.model='pjEmployee' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
					->where('t1.calendar_id', $this->getForeignId())
					->where('t1.email', $_POST['forgot_email'])
					->limit(1)
					->findAll()
					->getData();
				if (count($employee) != 1)
				{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionForgot&err=AA10");
				}else{
					$employee = $employee[0];
					
					$Email = new pjEmail();
					$Email
						->setTo($employee['email'])
						->setFrom($this->getFromEmail())
						->setSubject(__('emailForgotSubject', true));
					
					if ($this->option_arr['o_send_email'] == 'smtp')
					{
						$Email
							->setTransport('smtp')
							->setSmtpHost($this->option_arr['o_smtp_host'])
							->setSmtpPort($this->option_arr['o_smtp_port'])
							->setSmtpUser($this->option_arr['o_smtp_user'])
							->setSmtpPass($this->option_arr['o_smtp_pass'])
						;
					}
					
					$body = str_replace(
							array('{Name}', '{Password}'),
							array($employee['name'], $employee['password']),
							__('emailForgotBody', true)
					);
					
					if ($Email->send($body))
					{
						$err = "AA11";
					} else {
						$err = "AA12";
					}
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionForgot&err=$err");
				}
			} else {
				$user = $user[0];
				
				$Email = new pjEmail();
				$Email
					->setTo($user['email'])
					->setFrom($this->getFromEmail())
					->setSubject(__('emailForgotSubject', true));
				
				if ($this->option_arr['o_send_email'] == 'smtp')
				{
					$Email
						->setTransport('smtp')
						->setSmtpHost($this->option_arr['o_smtp_host'])
						->setSmtpPort($this->option_arr['o_smtp_port'])
						->setSmtpUser($this->option_arr['o_smtp_user'])
						->setSmtpPass($this->option_arr['o_smtp_pass'])
					;
				}
				
				$body = str_replace(
					array('{Name}', '{Password}'),
					array($user['name'], $user['password']),
					__('emailForgotBody', true)
				);

				if ($Email->send($body))
				{
					$err = "AA11";
				} else {
					$err = "AA12";
				}
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionForgot&err=$err");
			}
		} else {
			$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
			$this->appendJs('pjAdmin.js');
		}
	}
	
	public function pjActionMessages()
	{
		$this->setAjax(true);
		header("Content-Type: text/javascript; charset=utf-8");
	}
	
	public function pjActionValidate()
	{
		$this->setAjax(true);
		header("Content-Type: text/javascript; charset=utf-8");
	}
	
	public function pjActionGetBookings()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			$pjBookingModel = pjBookingModel::factory();
			
			$date_from = $date_to = $date_sql = NULL;
			if (isset($_GET['date_from']) && !empty($_GET['date_from']) && isset($_GET['date_to']) && !empty($_GET['date_to']))
			{
				$date_from = pjUtil::formatDate($_GET['date_from'], $this->option_arr['o_date_format']);
				$date_to = pjUtil::formatDate($_GET['date_to'], $this->option_arr['o_date_format']);
				$date_sql = sprintf(" AND `id` IN (SELECT `booking_id` FROM `%s` WHERE `date` BETWEEN :date_from AND :date_to)", pjBookingServiceModel::factory()->getTable());
			} else {
				if (isset($_GET['date_from']) && !empty($_GET['date_from']))
				{
					$date_from = pjUtil::formatDate($_GET['date_from'], $this->option_arr['o_date_format']);
					$date_sql = sprintf(" AND `id` IN (SELECT `booking_id` FROM `%s` WHERE `date` >= :date_from)", pjBookingServiceModel::factory()->getTable());
				} elseif (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
					$date_to = pjUtil::formatDate($_GET['date_to'], $this->option_arr['o_date_format']);
					$date_sql = sprintf(" AND `id` IN (SELECT `booking_id` FROM `%s` WHERE `date` <= :date_to)", pjBookingServiceModel::factory()->getTable());
				}
			}

			$statement = sprintf("SELECT 1,
				(SELECT COUNT(*) FROM `%1\$s` WHERE 1 %2\$s LIMIT 1) AS `total`,
				(SELECT COUNT(*) FROM `%1\$s` WHERE `booking_status` = :confirmed %2\$s LIMIT 1) AS `confirmed`,
				(SELECT COUNT(*) FROM `%1\$s` WHERE `booking_status` = :pending %2\$s LIMIT 1) AS `pending`,
				(SELECT COUNT(*) FROM `%1\$s` WHERE `booking_status` = :cancelled %2\$s LIMIT 1) AS `cancelled`
				LIMIT 1", $pjBookingModel->getTable(), $date_sql);
			
			$arr = $pjBookingModel->prepare($statement)->exec(array(
				'confirmed' => 'confirmed',
				'pending' => 'pending',
				'cancelled' => 'cancelled',
				'date_from' => $date_from,
				'date_to' => $date_to
			))->getData();
			
			pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => '', 'items' => $arr));
		}
		exit;
	}
	
	public function pjActionGetEmployees()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			$pjEmployeeModel = pjEmployeeModel::factory();
			
			$statement = sprintf("SELECT 1,
				(SELECT COUNT(*) FROM `%1\$s` WHERE 1 LIMIT 1) AS `total`,
				(SELECT COUNT(*) FROM `%1\$s`  LIMIT 1) AS `active`,
				(SELECT COUNT(*) FROM `%1\$s`  LIMIT 1) AS `inactive`
				LIMIT 1", $pjEmployeeModel->getTable());
			
			$arr = $pjEmployeeModel->prepare($statement)->exec()->getData();
			
			pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => '', 'items' => $arr));
		}
		exit;
	}

	public function pjActionGetInvoices()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			$pjInvoiceModel = pjInvoiceModel::factory();

			$date_from = $date_to = $date_sql = NULL;
			if (isset($_GET['date_from']) && !empty($_GET['date_from']) && isset($_GET['date_to']) && !empty($_GET['date_to']))
			{
				$date_from = pjUtil::formatDate($_GET['date_from'], $this->option_arr['o_date_format']);
				$date_to = pjUtil::formatDate($_GET['date_to'], $this->option_arr['o_date_format']);
				$date_sql = " AND `issue_date` BETWEEN :date_from AND :date_to";
			} else {
				if (isset($_GET['date_from']) && !empty($_GET['date_from']))
				{
					$date_from = pjUtil::formatDate($_GET['date_from'], $this->option_arr['o_date_format']);
					$date_sql = " AND `issue_date` >= :date_from";
				} elseif (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
					$date_to = pjUtil::formatDate($_GET['date_to'], $this->option_arr['o_date_format']);
					$date_sql = " AND `issue_date` <= :date_to";
				}
			}
			
			$statement = sprintf("SELECT 1,
				(SELECT COUNT(*) FROM `%1\$s` WHERE 1 %2\$s LIMIT 1) AS `total`,
				(SELECT COUNT(*) FROM `%1\$s` WHERE `status` = :paid %2\$s LIMIT 1) AS `paid`,
				(SELECT COUNT(*) FROM `%1\$s` WHERE `status` = :not_paid %2\$s LIMIT 1) AS `not_paid`,
				(SELECT COUNT(*) FROM `%1\$s` WHERE `status` = :cancelled %2\$s LIMIT 1) AS `cancelled`
				LIMIT 1", $pjInvoiceModel->getTable(), $date_sql);

			$arr = $pjInvoiceModel->prepare($statement)->exec(array(
				'paid' => 'paid',
				'not_paid' => 'not_paid',
				'cancelled' => 'cancelled',
				'date_from' => $date_from,
				'date_to' => $date_to
			))->getData();

			pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => '', 'items' => $arr));
		}
		exit;
	}

	public function pjActionGetServices()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			$pjServiceModel = pjServiceModel::factory();
			
			$statement = sprintf("SELECT 1,
				(SELECT COUNT(*) FROM `%1\$s` WHERE 1 LIMIT 1) AS `total`,
				(SELECT COUNT(*) FROM `%1\$s` LIMIT 1) AS `active`,
				(SELECT COUNT(*) FROM `%1\$s` LIMIT 1) AS `inactive`
				LIMIT 1", $pjServiceModel->getTable());
			
			$arr = $pjServiceModel->prepare($statement)->exec()->getData();
			
			pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => '', 'items' => $arr));
		}
		exit;
	}
	
	private function pjActionAdminLogin($email, $password)
	{
		$pjUserModel = pjUserModel::factory();
		
		$user = $pjUserModel
			->where('t1.email', $email)
			//->where(sprintf("t1.password = AES_ENCRYPT('%s', '%s')", $pjUserModel->escapeString($password), PJ_SALT))
            //->where(sprintf("t1.password = AES_ENCRYPT('%s', '%s')", $pjUserModel->escapeString($password), PJ_SALT))
			->limit(1)
			->findAll()
			->getData();
		
		if (empty($user))
		{
			return 1;
		} else {
			$user = $user[0];
			unset($user['password']);
			
			if (!in_array($user['role_id'], array(1)))
			{
				return 2;
			}
			if ($user['status'] != 'T')
			{
				return 3;
			}
			# Login succeed
    		$_SESSION[$this->defaultUser] = $user;
    			
    		# Update
    		$pjUserModel->reset()->set('id', $user['id'])->modify(array('last_login' => ':NOW()'));
    		
   			return 200;
		}
	}
	
	private function pjActionEmployeeLogin($email, $password)
	{
		$pjEmployeeModel = pjEmployeeModel::factory();
		
		$employee = $pjEmployeeModel
			->where('t1.email', $email)
			->where(sprintf("t1.password = AES_ENCRYPT('%s', '%s')", $pjEmployeeModel->escapeString($password), PJ_SALT))
			->limit(1)
			->findAll()
			->getData();
			
		if (empty($employee))
		{
			return 1;
		} else {
			$employee = $employee[0];
			$employee['role_id'] = 2;
			unset($employee['password']);
			
			if ((int) $employee['is_active'] !== 1)
			{
				return 3;
			}
			# Login succeed
    		$_SESSION[$this->defaultUser] = $employee;
    			
    		# Update
    		$pjEmployeeModel->reset()->set('id', $employee['id'])->modify(array('last_login' => ':NOW()'));
    		
   			return 200;
		}
	}
	
	public function pjActionLogin()
	{
		$this->setLayout('pjActionAdminLogin');
		
		if (isset($_POST['login_user']))
		{
			if (!isset($_POST['login_email']) || !isset($_POST['login_password']) ||
				!pjValidation::pjActionNotEmpty($_POST['login_email']) ||
				!pjValidation::pjActionNotEmpty($_POST['login_password']) ||
				!pjValidation::pjActionEmail($_POST['login_email']))
			{
				// Data not validate
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionLogin&err=4");
			}
			
			$result = $this->pjActionAdminLogin($_POST['login_email'], $_POST['login_password']);
			if ($result !== 200)
			{
				$result = $this->pjActionEmployeeLogin($_POST['login_email'], $_POST['login_password']);
				if ($result !== 200)
				{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionLogin&err=" . $result);
				}
			}
			
			if ($result === 200)
			{
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionIndex");
			}
		
		} else {
			$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
			$this->appendJs('pjAdmin.js');
		}
	}
	
	public function pjActionLogout()
	{
		if ($this->isLoged())
        {
        	unset($_SESSION[$this->defaultUser]);
        }
       	pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionLogin");
	}
	
	public function pjActionProfile()
	{
		$this->checkLogin();
		
		if ($this->isEmployee())
		{
			if (isset($_POST['profile_update']))
			{
				$pjEmployeeModel = pjEmployeeModel::factory();
				$arr = $pjEmployeeModel->find($this->getUserId())->getData();
				
				$data = array();
				$data['is_active'] = $arr['is_active'];
				$data['calendar_id'] = $arr['calendar_id'];
				
				if (isset($_FILES['avatar']))
				{
					$pjImage = new pjImage();
					$pjImage->setAllowedExt($this->extensions)->setAllowedTypes($this->mimeTypes);
					if ($pjImage->load($_FILES['avatar']))
					{
						$data['avatar'] = PJ_UPLOAD_PATH . md5($this->getUserId() . PJ_SALT) . ".jpg";
						$pjImage
							->loadImage()
							->resizeSmart(100, 100)
							->saveImage($data['avatar']);
					}
				}
				
				$post = array_merge($_POST, $data);
				if (!$pjEmployeeModel->validates($post))
				{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionProfile&err=AA14");
				}
				if (isset($post['password']) && $post['password'] == 'password')
				{
					unset($post['password']);
				}
				$pjEmployeeModel->set('id', $this->getUserId())->modify($post);
				if (isset($_POST['i18n']))
				{
					pjMultiLangModel::factory()->updateMultiLang($_POST['i18n'], $this->getUserId(), 'pjEmployee', 'data');
				}
				
				$pjEmployeeServiceModel = pjEmployeeServiceModel::factory();
				$pjEmployeeServiceModel->where('employee_id', $this->getUserId())->eraseAll();
				if (isset($_POST['service_id']) && !empty($_POST['service_id']))
				{
					$pjEmployeeServiceModel->reset()->setBatchFields(array('employee_id', 'service_id'));
					foreach ($_POST['service_id'] as $service_id)
					{
						$pjEmployeeServiceModel->addBatchRow(array($this->getUserId(), $service_id));
					}
					$pjEmployeeServiceModel->insertBatch();
				}
				
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionProfile&err=AA13");
			} else {
				$arr = pjEmployeeModel::factory()->find($this->getUserId())->getData();
				$arr['i18n'] = pjMultiLangModel::factory()->getMultiLang($this->getUserId(), 'pjEmployee');
				$this->set('arr', $arr);
				
				$locale_arr = pjLocaleModel::factory()->select('t1.*, t2.file')
					->join('pjLocaleLanguage', 't2.iso=t1.language_iso', 'left')
					->where('t2.file IS NOT NULL')
					->orderBy('t1.sort ASC')->findAll()->getData();
				
				$lp_arr = array();
				foreach ($locale_arr as $item)
				{
					$lp_arr[$item['id']."_"] = $item['file']; //Hack for jquery $.extend, to prevent (re)order of numeric keys in object
				}
				$this->set('lp_arr', $locale_arr);
				
				$this->set('service_arr', pjServiceModel::factory()
					->select('t1.*, t2.content AS `name`')
					->join('pjMultiLang', "t2.model='pjService' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
					->orderBy('`name` ASC')
					->findAll()
					->getData()
				);
				$this->set('es_arr', pjEmployeeServiceModel::factory()
					->where('t1.employee_id', $arr['id'])
					->findAll()
					->getDataPair('id', 'service_id')
				);
				
				$this->appendJs('jquery.multiselect.min.js', PJ_THIRD_PARTY_PATH . 'multiselect/');
				$this->appendCss('jquery.multiselect.css', PJ_THIRD_PARTY_PATH . 'multiselect/');
				
				$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
				if ((int) $this->option_arr['o_multi_lang'] === 1)
				{
					$this->set('locale_str', pjAppController::jsonEncode($lp_arr));
					$this->appendJs('jquery.multilang.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
					$this->appendJs('jquery.tipsy.js', PJ_THIRD_PARTY_PATH . 'tipsy/');
					$this->appendCss('jquery.tipsy.css', PJ_THIRD_PARTY_PATH . 'tipsy/');
				}
				$this->appendJs('pjAdmin.js');
			}
		} else {
			$this->set('status', 2);
		}
	}
}
?>