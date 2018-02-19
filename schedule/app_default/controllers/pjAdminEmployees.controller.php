<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjAdminEmployees extends pjAdmin
{
	public function pjActionCheckEmail()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			if (!isset($_GET['email']) || empty($_GET['email']))
			{
				echo 'false';
				exit;
			}
			$pjEmployeeModel = pjEmployeeModel::factory()->where('t1.email', $_GET['email']);
			if ($this->isEmployee())
			{
				$pjEmployeeModel->where('t1.id !=', $this->getUserId());
			} elseif (isset($_GET['id']) && (int) $_GET['id'] > 0) {
				$pjEmployeeModel->where('t1.id !=', $_GET['id']);
			}

			echo $pjEmployeeModel->findCount()->getData() == 0 ? 'true' : 'false';
		}
		exit;
	}
	
	public function pjActionCreate()
	{
		$this->checkLogin();
		
		if ($this->isAdmin())
		{
			$post_max_size = pjUtil::getPostMaxSize();
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['CONTENT_LENGTH']) && (int) $_SERVER['CONTENT_LENGTH'] > $post_max_size)
			{
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminEmployees&action=pjActionIndex&err=AE12");
			}
			
			if (isset($_POST['employee_create']))
			{
				$err = 'AE03';
				$data = array();
				$data['calendar_id'] = $this->getForeignId();
				$id = pjEmployeeModel::factory(array_merge($_POST, $data))->insert()->getInsertId();
				if ($id !== false && (int) $id > 0)
				{
					if (isset($_FILES['avatar']))
					{
						if($_FILES['avatar']['error'] == 0)
						{
							$size = getimagesize($_FILES['avatar']['tmp_name']);
							if($size == true)
							{
								$pjImage = new pjImage();
								$pjImage->setAllowedExt($this->extensions)->setAllowedTypes($this->mimeTypes);
								if ($pjImage->load($_FILES['avatar']))
								{
									$dst = PJ_UPLOAD_PATH . md5($id . PJ_SALT) . ".jpg";
									$pjImage
										->loadImage()
										->resizeSmart(150, 170)
										->saveImage($dst);
										
									pjEmployeeModel::factory()->set('id', $id)->modify(array('avatar' => $dst));
								}
							}else{
								$err = 'AE14';
							}
						}else if($_FILES['avatar']['error'] != 4){
							$err = 'AE13';
						}
					}
					
					if (isset($_POST['service_id']) && !empty($_POST['service_id']))
					{
						$pjEmployeeServiceModel = pjEmployeeServiceModel::factory()->setBatchFields(array('employee_id', 'service_id'));
						foreach ($_POST['service_id'] as $service_id)
						{
							$pjEmployeeServiceModel->addBatchRow(array($id, $service_id));
						}
						$pjEmployeeServiceModel->insertBatch();
					}
					pjWorkingTimeModel::factory()->initFrom($this->getForeignId(), $id);
					
					if (isset($_POST['i18n']))
					{
						pjMultiLangModel::factory()->saveMultiLang($_POST['i18n'], $id, 'pjEmployee');
					}
				} else {
					$err = 'AE04';
				}
				if($err == 'AE03' || $err == 'AE04')
				{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminEmployees&action=pjActionIndex&err=$err");
				}else{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminEmployees&action=pjActionUpdate&id=$id&err=$err");
				}
			} else {
				$locale_arr = pjLocaleModel::factory()->select('t1.*, t2.file')
					->join('pjLocaleLanguage', 't2.iso=t1.language_iso', 'left')
					->where('t2.file IS NOT NULL')
					->orderBy('t1.sort ASC')->findAll()->getData();
						
				$lp_arr = array();
				foreach ($locale_arr as $item)
				{
					$lp_arr[$item['id']."_"] = $item['file'];
				}
				$this->set('lp_arr', $locale_arr);
				
				$this->set('service_arr', pjServiceModel::factory()
					->select('t1.*, t2.content AS `name`')
					->join('pjMultiLang', "t2.model='pjService' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
					->orderBy('`name` ASC')
					->findAll()
					->getData()
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
				$this->appendJs('pjAdminEmployees.js');
			}
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjActionDeleteAvatar()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			$id = NULL;
			if ($this->isEmployee())
			{
				$id = $this->getUserId();
			} elseif (isset($_POST['id']) && (int) $_POST['id'] > 0) {
				$id = $_POST['id'];
			}
			
			if (!is_null($id))
			{
				$pjEmployeeModel = pjEmployeeModel::factory();
				$arr = $pjEmployeeModel->find($id)->getData();
				if (!empty($arr))
				{
					$pjEmployeeModel->modify(array('avatar' => ':NULL'));
					
					@clearstatcache();
					if (!empty($arr['avatar']) && is_file($arr['avatar']))
					{
						@unlink($arr['avatar']);
					}
					
					pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => ''));
				}
			}
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => ''));
		}
		exit;
	}
	
	public function pjActionDeleteEmployee()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			if (isset($_GET['id']) && (int) $_GET['id'] > 0)
			{
				$pjEmployeeModel = pjEmployeeModel::factory();
				$arr = $pjEmployeeModel->find($_GET['id'])->getData();
				if (!empty($arr) && $pjEmployeeModel->set('id', $arr['id'])->erase()->getAffectedRows() == 1)
				{
					pjMultiLangModel::factory()->where('model', 'pjEmployee')->where('foreign_id', $arr['id'])->eraseAll();
					pjEmployeeServiceModel::factory()->where('employee_id', $arr['id'])->eraseAll();
					pjWorkingTimeModel::factory()->where('foreign_id', $arr['id'])->where('`type`', 'employee')->limit(1)->eraseAll();
					pjDateModel::factory()->where('foreign_id', $arr['id'])->where('`type`', 'employee')->eraseAll();
					if (!empty($arr['avatar']) && is_file($arr['avatar']))
					{
						@unlink($arr['avatar']);
					}
					pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Employee have been deleted.'));
				}
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'Employee not found.'));
			}
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing, empty or invalid parameters.'));
		}
		exit;
	}
	
	public function pjActionDeleteEmployeeBulk()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			if (isset($_POST['record']) && !empty($_POST['record']))
			{
				$pjEmployeeModel = pjEmployeeModel::factory();
				$arr = pjEmployeeModel::factory()->whereIn('id', $_POST['record'])->findAll()->getData();
				if (!empty($arr))
				{
					$pjEmployeeModel->reset()->whereIn('id', $_POST['record'])->eraseAll();
					pjMultiLangModel::factory()->where('model', 'pjEmployee')->whereIn('foreign_id', $_POST['record'])->eraseAll();
					pjEmployeeServiceModel::factory()->whereIn('employee_id', $_POST['record'])->eraseAll();
					pjWorkingTimeModel::factory()->whereIn('foreign_id', $_POST['record'])->where('`type`', 'employee')->eraseAll();
					pjDateModel::factory()->whereIn('foreign_id', $_POST['record'])->where('`type`', 'employee')->eraseAll();
					foreach ($arr as $employee)
					{
						if (!empty($employee['avatar']) && is_file($employee['avatar']))
						{
							@unlink($employee['avatar']);
						}
					}
					pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Employee(s) have been deleted.'));
				}
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Employee(s) not found.'));
			}
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing, empty or invalid parameters.'));
		}
		exit;
	}
	
	public function pjActionGetEmployee()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			$pjEmployeeModel = pjEmployeeModel::factory()
				->join('pjMultiLang', "t2.model='pjEmployee' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
				->where('t1.calendar_id', $this->getForeignId());
			
			if (isset($_GET['q']) && !empty($_GET['q']))
			{
				$q = str_replace(array('_', '%'), array('\_', '\%'), trim($_GET['q']));
				$pjEmployeeModel->where('t2.content LIKE', "%$q%");
				$pjEmployeeModel->orWhere('t1.email LIKE', "%$q%");
				$pjEmployeeModel->orWhere('t1.phone LIKE', "%$q%");
				$pjEmployeeModel->orWhere('t1.notes LIKE', "%$q%");
			}

			if (isset($_GET['is_active']) && strlen($_GET['is_active']) > 0 && in_array($_GET['is_active'], array(1, 0)))
			{
				$pjEmployeeModel->where('t1.is_active', $_GET['is_active']);
			}

			$column = 'name';
			$direction = 'ASC';
			if (isset($_GET['direction']) && isset($_GET['column']) && in_array(strtoupper($_GET['direction']), array('ASC', 'DESC')))
			{
				$column = $_GET['column'];
				$direction = strtoupper($_GET['direction']);
			}

			$total = $pjEmployeeModel->findCount()->getData();
			$rowCount = isset($_GET['rowCount']) && (int) $_GET['rowCount'] > 0 ? (int) $_GET['rowCount'] : 10;
			$pages = ceil($total / $rowCount);
			$page = isset($_GET['page']) && (int) $_GET['page'] > 0 ? intval($_GET['page']) : 1;
			$offset = ((int) $page - 1) * $rowCount;
			if ($page > $pages)
			{
				$page = $pages;
			}

			$data = $pjEmployeeModel
				->select(sprintf("t1.*, AES_DECRYPT(t1.password, '%3\$s') AS `password`, t2.content AS `name`,
					(SELECT COUNT(es.id)
						FROM `%1\$s` AS `es`
						INNER JOIN `%2\$s` AS `s` ON `s`.`id` = `es`.`service_id`
						WHERE `es`.`employee_id` = `t1`.`id` AND `s`.`is_active`='1'
						LIMIT 1) AS `services`
					", pjEmployeeServiceModel::factory()->getTable(), pjServiceModel::factory()->getTable(), PJ_SALT))
				->orderBy("$column $direction")->limit($rowCount, $offset)->findAll()->getData();
				
			pjAppController::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
		}
		exit;
	}
	
	public function pjActionIndex()
	{
		$this->checkLogin();
		
		if ($this->isAdmin())
		{
			$this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
			$this->appendJs('pjAdminEmployees.js');
			$this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true);
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjActionSaveEmployee()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			$pjEmployeeModel = pjEmployeeModel::factory();
			if (!in_array($_POST['column'], $pjEmployeeModel->getI18n()))
			{
				$pjEmployeeModel->set('id', $_GET['id'])->modify(array($_POST['column'] => $_POST['value']));
			} else {
				pjMultiLangModel::factory()->updateMultiLang(array($this->getLocaleId() => array($_POST['column'] => $_POST['value'])), $_GET['id'], 'pjEmployee', 'data');
			}
		}
		exit;
	}
	
	public function pjActionUpdate()
	{
		$this->checkLogin();
		
		if ($this->isAdmin())
		{
			$post_max_size = pjUtil::getPostMaxSize();
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['CONTENT_LENGTH']) && (int) $_SERVER['CONTENT_LENGTH'] > $post_max_size)
			{
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminEmployees&action=pjActionIndex&err=AE15");
			}
			
			if (isset($_POST['employee_update']) && isset($_POST['id']) && (int) $_POST['id'] > 0)
			{
				$err = 'AE01';
				$data = array();
				if (isset($_FILES['avatar']))
				{
					if($_FILES['avatar']['error'] == 0)
					{
						$size = getimagesize($_FILES['avatar']['tmp_name']);
						
						if($size == true)
						{
							$pjEmployeeModel = pjEmployeeModel::factory();
							$arr = $pjEmployeeModel->find($_POST['id'])->getData();
							if (!empty($arr))
							{
								@clearstatcache();
								if (!empty($arr['avatar']) && is_file($arr['avatar']))
								{
									@unlink($arr['avatar']);
								}
							}
							
							$pjImage = new pjImage();
							$pjImage->setAllowedExt($this->extensions)->setAllowedTypes($this->mimeTypes);
							if ($pjImage->load($_FILES['avatar']))
							{
								$data['avatar'] = PJ_UPLOAD_PATH . md5($_POST['id'] . PJ_SALT) . ".jpg";
								$pjImage
									->loadImage()
									->resizeSmart(150, 170)
									->saveImage($data['avatar']);
							}
						}else{
							$err = 'AE17';
						}
					}else if($_FILES['avatar']['error'] != 4){
						$err = 'AE16';
					}
				}
				$data['is_subscribed'] = isset($_POST['is_subscribed']) ? 1 : 0;
				$data['is_subscribed_sms'] = isset($_POST['is_subscribed_sms']) ? 1 : 0;
				
				if (isset($_POST['password']) && $_POST['password'] == 'password')
				{
					unset($_POST['password']);
				}
				
				pjEmployeeModel::factory()->set('id', $_POST['id'])->modify(array_merge($_POST, $data));
				if (isset($_POST['i18n']))
				{
					pjMultiLangModel::factory()->updateMultiLang($_POST['i18n'], $_POST['id'], 'pjEmployee', 'data');
				}
				
				$pjEmployeeServiceModel = pjEmployeeServiceModel::factory();
				$pjEmployeeServiceModel->where('employee_id', $_POST['id'])->eraseAll();
				if (isset($_POST['service_id']) && !empty($_POST['service_id']))
				{
					$pjEmployeeServiceModel->reset()->setBatchFields(array('employee_id', 'service_id'));
					foreach ($_POST['service_id'] as $service_id)
					{
						$pjEmployeeServiceModel->addBatchRow(array($_POST['id'], $service_id));
					}
					$pjEmployeeServiceModel->insertBatch();
				}
				if($err == 'AE01')
				{
					pjUtil::redirect(PJ_INSTALL_URL . "index.php?controller=pjAdminEmployees&action=pjActionIndex&err=AE01");
				}else{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminEmployees&action=pjActionUpdate&id=".$_POST['id']."&err=$err");
				}
			} else {
				$arr = pjEmployeeModel::factory()->find($_GET['id'])->getData();
				if (count($arr) === 0)
				{
					pjUtil::redirect(PJ_INSTALL_URL. "index.php?controller=pjAdminEmployees&action=pjActionIndex&err=AE08");
				}
				$arr['i18n'] = pjMultiLangModel::factory()->getMultiLang($arr['id'], 'pjEmployee');
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
				)->set('es_arr', pjEmployeeServiceModel::factory()
					->where('t1.employee_id', $arr['id'])
					->findAll()
					->getDataPair('id', 'service_id'));
				
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
				$this->appendJs('pjAdminEmployees.js');
				$this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true);
			}
		} else {
			$this->set('status', 2);
		}
	}
}
?>