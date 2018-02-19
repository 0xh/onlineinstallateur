<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjFrontEnd extends pjFront
{
	public function __construct()
	{
		parent::__construct();
		
		$this->setAjax(true);
		
		$this->setLayout('pjActionEmpty');
	}
	
	public function pjActionAddToCart()
	{
		if ($this->isXHR())
		{
			
			if (isset($_GET['cid']) && isset($_POST['date']) && isset($_POST['start_ts']) && isset($_POST['end_ts']) && isset($_POST['service_id']) && isset($_POST['employee_id']))
			{
				
				$date = pjUtil::formatDate($_POST['date'], $this->option_arr['o_date_format']);
                
				$key = sprintf("%u|%s|%u|%s|%s|%u", $_GET['cid'], $date, $_POST['service_id'], $_POST['start_ts'], $_POST['end_ts'], $_POST['employee_id']);
				
				# Remove services at same date
				$cart = $this->cart->getAll();
				foreach ($cart as $cart_key => $whatever)
				{
					$pattern = sprintf('/^%u\|%s\|%u/', $_GET['cid'], $date, $_POST['service_id']);
					if (preg_match($pattern, $cart_key))
					{
						$this->cart->remove($cart_key);
					}
				}
				# --
				
				$this->cart->update($key, 1);
				pjAppController::jsonResponse(array('status' => 'OK', 'code' => 206, 'text' => __('system_206', true)));
			}
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 105, 'text' => __('system_105', true)));
		}
		exit;
	}
	
	public function pjActionRemoveFromCart()
	{
		if ($this->isXHR())
		{
			if (isset($_GET['cid']) && isset($_POST['date']) && isset($_POST['start_ts']) && isset($_POST['end_ts']) && isset($_POST['service_id']) && isset($_POST['employee_id']) && !$this->cart->isEmpty())
			{
				$date = $_POST['date'];
				$key = sprintf("%u|%s|%u|%s|%s|%u", $_GET['cid'], $date, $_POST['service_id'], $_POST['start_ts'], $_POST['end_ts'], $_POST['employee_id']);
				$this->cart->remove($key);
				pjAppController::jsonResponse(array('status' => 'OK', 'cnt' => $this->cart->getCount(), 'code' => 207, 'text' => __('system_207', true)));
			}
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 106, 'text' => __('system_106', true)));
		}
		exit;
	}

	public function pjActionValidateCart()
	{
		if ($this->isXHR())
		{
			$is_valid = $this->getValidate($this->getSummary());
			die($is_valid ? 'true' : 'false');
		}
		die('false');
	}
	
	public function pjActionProcessOrder()
	{
		$this->setAjax(true);
		
		if ($this->isXHR())
		{
			if (!isset($_POST['as_preview']) || !isset($_SESSION[$this->defaultForm]) || empty($_SESSION[$this->defaultForm]))
			{
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 109, 'text' => __('system_109', true)));
			}
			
			if ((int) $this->option_arr['o_bf_captcha'] === 3 && (!isset($_SESSION[$this->defaultForm]['captcha']) || @$_SESSION[$this->defaultCaptcha] != strtoupper($_SESSION[$this->defaultForm]['captcha'])))
			{
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 110, 'text' => __('system_110', true)));
			}
			
			$summary = $this->getSummary();
			if (!$this->getValidate($summary))
			{
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 111, 'text' => __('system_111', true)));
			}
			
			$dates = array();
			foreach ($summary['services'] as $service)
			{
				$dates[] = $service['date'];
			}
			if (!empty($dates))
			{
				$bs_arr = pjBookingServiceModel::factory()
					->select('t1.*')
					->join('pjBooking', "t2.id=t1.booking_id AND t2.booking_status='confirmed'", 'inner')
					->whereIn('t1.date', $dates)
					->findAll()
					->getData();
					
				foreach ($bs_arr as $item)
				{
					foreach ($summary['services'] as $service)
					{
						if ($service['date'] == $item['date']
							&& $service['id'] == $item['service_id']
							&& $service['employee_id'] == $item['employee_id']
							&& $service['start_ts'] == $item['start_ts']
						)
						{
							pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 115, 'text' => __('system_115', true)));
							break;
						}
					}
				}
			}
			
			$data = array();
			
			$data['calendar_id'] = $this->getForeignId();
			$data['booking_status'] = $this->option_arr['o_status_if_not_paid'];
			$data['uuid'] = pjUtil::uuid();
			$data['ip'] = $_SERVER['REMOTE_ADDR'];
			$data['locale_id'] = $this->getLocaleId();
			
			$data = array_merge($_SESSION[$this->defaultForm], $data);
			
			if (isset($data['payment_method']) && $data['payment_method'] != 'creditcard')
			{
				unset($data['cc_type']);
				unset($data['cc_num']);
				unset($data['cc_exp_month']);
				unset($data['cc_exp_year']);
				unset($data['cc_code']);
			}
			
			$data['booking_price'] = $summary['price'];
			$data['booking_deposit'] = $summary['deposit'];
			$data['booking_tax'] = $summary['tax'];
			$data['booking_total'] = $summary['total'];
			
			$pjBookingModel = pjBookingModel::factory();
			if (!$pjBookingModel->validates($data))
			{
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 114, 'text' => __('system_114', true)));
			}
			
			$booking_id = $pjBookingModel->setAttributes($data)->insert()->getInsertId();
			if ($booking_id !== false && (int) $booking_id > 0)
			{
				$pjBookingServiceModel = pjBookingServiceModel::factory()->setBatchFields(array(
					'booking_id', 'service_id', 'employee_id', 'date', 'start', 'start_ts', 'total', 'price', 'reminder_email', 'reminder_sms'
				));
				foreach ($summary['services'] as $service)
				{
					$pjBookingServiceModel->addBatchRow(array(
						$booking_id, $service['id'], $service['employee_id'],
						$service['date'], @$service['start'], $service['start_ts'],
						$service['duration'], $service['price'], 0, 0
					));
				}
				$pjBookingServiceModel->insertBatch();
				
				$invoice_arr = $this->pjActionGenerateInvoice($booking_id);
				
				# Confirmation email(s)
				$booking_arr = $pjBookingModel
					->reset()
					->select('t1.*, t1.id AS `booking_id`, t3.email AS `admin_email`, t4.content AS `country_name`,
						t5.content AS `confirm_subject_client`, t6.content AS `confirm_tokens_client`,
						t7.content AS `confirm_subject_admin`, t8.content AS `confirm_tokens_admin`,
						t9.content AS `confirm_subject_employee`, t10.content AS `confirm_tokens_employee`')
					->join('pjCalendar', 't2.id=t1.calendar_id', 'left outer')
					->join('pjUser', 't3.id=t2.user_id', 'left outer')
					->join('pjMultiLang', "t4.model='pjCountry' AND t4.foreign_id=t1.c_country_id AND t4.locale=t1.locale_id AND t4.field='name'", 'left outer')
					->join('pjMultiLang', "t5.model='pjCalendar' AND t5.foreign_id=t1.calendar_id AND t5.locale=t1.locale_id AND t5.field='confirm_subject_client'", 'left outer')
					->join('pjMultiLang', "t6.model='pjCalendar' AND t6.foreign_id=t1.calendar_id AND t6.locale=t1.locale_id AND t6.field='confirm_tokens_client'", 'left outer')
					->join('pjMultiLang', "t7.model='pjCalendar' AND t7.foreign_id=t1.calendar_id AND t7.locale=t1.locale_id AND t7.field='confirm_subject_admin'", 'left outer')
					->join('pjMultiLang', "t8.model='pjCalendar' AND t8.foreign_id=t1.calendar_id AND t8.locale=t1.locale_id AND t8.field='confirm_tokens_admin'", 'left outer')
					->join('pjMultiLang', "t9.model='pjCalendar' AND t9.foreign_id=t1.calendar_id AND t9.locale=t1.locale_id AND t9.field='confirm_subject_employee'", 'left outer')
					->join('pjMultiLang', "t10.model='pjCalendar' AND t10.foreign_id=t1.calendar_id AND t10.locale=t1.locale_id AND t10.field='confirm_tokens_employee'", 'left outer')
					->find($booking_id)
					->getData();
					
				$booking_arr['bs_arr'] = $pjBookingServiceModel
					->reset()
					->select('t1.*, t3.before, t3.length, t4.content AS `service_name`, t5.content AS `employee_name`,
						t6.phone AS `employee_phone`, t6.email AS `employee_email`, t6.is_subscribed, t6.is_subscribed_sms')
					->join('pjBooking', 't2.id=t1.booking_id', 'inner')
					->join('pjService', 't3.id=t1.service_id', 'inner')
					->join('pjMultiLang', "t4.model='pjService' AND t4.foreign_id=t1.service_id AND t4.field='name' AND t4.locale=t2.locale_id", 'left outer')
					->join('pjMultiLang', "t5.model='pjEmployee' AND t5.foreign_id=t1.employee_id AND t5.field='name' AND t5.locale=t2.locale_id", 'left outer')
					->join('pjEmployee', 't6.id=t1.employee_id', 'left outer')
					->where('t1.booking_id', $booking_id)
					->findAll()
					->getData();

				$bs_ids = $pjBookingServiceModel->getDataPair('id', null);
					
				pjFrontEnd::pjActionConfirmSend($this->option_arr, $booking_arr, 'confirm');
				# Confirmation email(s)

				# Sms
				if (pjObject::getPlugin('pjSms') !== NULL && !empty($bs_ids))
				{
					$tmp_booking = $booking_arr;
					unset($tmp_booking['bs_arr']);
					
					$params = array(
						'key' => md5($this->option_arr['private_key'] . PJ_SALT)
					);
					
					foreach ($booking_arr['bs_arr'] as $item)
					{
						if ((int) $item['is_subscribed_sms'] === 1 && !empty($item['employee_phone']))
						{
							$tmp = array_merge($tmp_booking, $item);

							$tokens = pjAppController::getTokens($tmp, $this->option_arr);
							$message = str_replace($tokens['search'], $tokens['replace'], str_replace(array('\r\n', '\n'), ' ', $this->option_arr['o_reminder_sms_message']));
							$message = stripslashes($message);
							
							$params['text'] = $message;
							$params['type'] = 'unicode';
							$params['number'] = $item['employee_phone'];
							$result = $this->requestAction(array(
								'controller' => 'pjSms',
								'action' => 'pjActionSend',
								'params' => $params
							), array('return'));
						}
					}
				}
				# Sms
				
				// Reset SESSION vars
				$this->cart->clear();
				
				$_SESSION[$this->defaultForm] = NULL;
				unset($_SESSION[$this->defaultForm]);
				
				$_SESSION[$this->defaultCaptcha] = NULL;
				unset($_SESSION[$this->defaultCaptcha]);
				
				pjAppController::jsonResponse(array(
					'status' => 'OK',
					'code' => 210,
					'text' => __('system_210', true),
					'booking_id' => $booking_id,
					'booking_uuid' => $booking_arr['uuid'],
					'invoice_id' => @$invoice_arr['data']['id'],
					'payment_method' => ((int) $this->option_arr['o_disable_payments'] === 0 && isset($data['payment_method']) ?
						$data['payment_method'] : 'none')
				));
			} else {
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 119, 'text' => __('system_119', true)));
			}
		}
		exit;
	}
	
	public function pjActionLoad()
	{
		$this->setAjax(false);
		$this->setLayout('pjActionFront');
		
		ob_start();
		header("Content-Type: text/javascript; charset=utf-8");
		
		if(isset($_GET['tab']))
		{
			$_SESSION[$this->defaultView] = $_GET['tab'];
		}else{
			$_SESSION[$this->defaultView] = 'both';
		}
		
		$days_off = $dates_off = $dates_on = array();
		$w_arr = pjWorkingTimeModel::factory()->where('t1.foreign_id', $this->getForeignId())->where('t1.type', 'calendar')->findAll()->getData();
		if (!empty($w_arr))
		{
			$w_arr = $w_arr[0];
			
			if ($w_arr['monday_dayoff'] == 'T')
			{
				$days_off[] = 1;
			}
			if ($w_arr['tuesday_dayoff'] == 'T')
			{
				$days_off[] = 2;
			}
			if ($w_arr['wednesday_dayoff'] == 'T')
			{
				$days_off[] = 3;
			}
			if ($w_arr['thursday_dayoff'] == 'T')
			{
				$days_off[] = 4;
			}
			if ($w_arr['friday_dayoff'] == 'T')
			{
				$days_off[] = 5;
			}
			if ($w_arr['saturday_dayoff'] == 'T')
			{
				$days_off[] = 6;
			}
			if ($w_arr['sunday_dayoff'] == 'T')
			{
				$days_off[] = 0;
			}
		}
		
		$d_arr = pjDateModel::factory()
			->where('t1.foreign_id', $this->getForeignId())
			->where('t1.type', 'calendar')
			->where('t1.date >= CURDATE()')
			->findAll()
			->getData();

		foreach ($d_arr as $date)
		{
			if ($date['is_dayoff'] == 'T')
			{
				$dates_off[] = $date['date'];
			} else {
				$dates_on[] = $date['date'];
			}
		}

		$this->set('days_off', $days_off);
		$this->set('dates_off', $dates_off);
		$this->set('dates_on', $dates_on);
				
		# Find first working day starting from tomorrow
		$first_working_date = NULL;
		list($y, $m, $d, $w) = explode("-", date("Y-n-j-w", time()));
		foreach (range(0, 365) as $i)
		{
			$timestamp = mktime(0, 0, 0, $m, $d + $i, $y);
			list($date, $wday) = explode("|", date("Y-m-d|w", $timestamp));
			
			if (!in_array($wday, $days_off) && !in_array($date, $dates_off))
			{
				$first_working_date = $date;
				break;
			}
			
			if (in_array($wday, $days_off) && in_array($date, $dates_on))
			{
				$first_working_date = $date;
				break;
			}
		}
		
        $_SESSION['service_bla'] = $_GET['service_bla'];
        //$this->set('service_bla', $_GET['service_bla']);
		$this->set('first_working_date', $first_working_date);
	}
	
	public function pjActionLoadCss()
	{
		$theme = isset($_GET['theme']) ? $_GET['theme'] : $this->option_arr['o_theme'];
		if((int) $theme > 0)
		{
			$theme = 'theme' . $theme;
		}
		$arr = array(
			array('file' => 'jquery-ui-1.9.2.custom.min.css', 'path' => PJ_LIBS_PATH . 'pjQ/css/'),
			array('file' => 'pj-calendar.css', 'path' => PJ_FRAMEWORK_LIBS_PATH . 'pj/css/'),
			array('file' => 'ASCalendar.css', 'path' => PJ_CSS_PATH),				
			array('file' => 'font-awesome.min.css', 'path' => PJ_LIBS_PATH . 'pjQ/css/'),
			array('file' => "AppScheduler.css", 'path' => PJ_CSS_PATH),
			array('file' => "$theme.css", 'path' => PJ_CSS_PATH . "themes/")
		);
		header("Content-Type: text/css; charset=utf-8");
		foreach ($arr as $item)
		{
			ob_start();
			@readfile($item['path'] . $item['file']);
			$string = ob_get_contents();
			ob_end_clean();
			
			if ($string !== FALSE)
			{
				echo str_replace(
					array('../img/', '../fonts/', '[fonts]', 'images/', '[URL]', "pjWrapper"),
					array(
						PJ_INSTALL_URL . PJ_IMG_PATH,
						PJ_INSTALL_URL . PJ_LIBS_PATH . 'pjQ/bootstrap/fonts/',
						PJ_INSTALL_URL . PJ_LIBS_PATH . 'pjQ/css/fonts/',
						PJ_INSTALL_URL . PJ_LIBS_PATH . 'pjQ/css/images/',
						PJ_INSTALL_URL,
						"pjWrapperAppScheduler_" . $this->getForeignId()
					),
					$string
				) . "\n";
			}
		}
		exit;
	}
	
	public function pjActionCancel()
	{
		$pjBookingModel = pjBookingModel::factory();
				
		if (isset($_POST['booking_cancel']))
		{
			$arr = $pjBookingModel->find($_POST['id'])->getData();
			if (!empty($arr))
			{
				$pjBookingModel
					->reset()
					->where(sprintf("SHA1(CONCAT(`id`, `created`, '%s')) = ", PJ_SALT), $_POST['hash'])
					->limit(1)
					->modifyAll(array('booking_status' => 'cancelled'));

				# Confirmation email(s)
				$booking_arr = $pjBookingModel
					->reset()
					->select('t1.*, t1.id AS `booking_id`, t3.email AS `admin_email`, t4.content AS `country_name`,
						t5.content AS `cancel_subject_client`, t6.content AS `cancel_tokens_client`,
						t7.content AS `cancel_subject_admin`, t8.content AS `cancel_tokens_admin`,
						t9.content AS `cancel_subject_employee`, t10.content AS `cancel_tokens_employee`')
					->join('pjCalendar', 't2.id=t1.calendar_id', 'left outer')
					->join('pjUser', 't3.id=t2.user_id', 'left outer')
					->join('pjMultiLang', "t4.model='pjCountry' AND t4.foreign_id=t1.c_country_id AND t4.locale=t1.locale_id AND t4.field='name'", 'left outer')
					->join('pjMultiLang', "t5.model='pjCalendar' AND t5.foreign_id=t1.calendar_id AND t5.locale=t1.locale_id AND t5.field='cancel_subject_client'", 'left outer')
					->join('pjMultiLang', "t6.model='pjCalendar' AND t6.foreign_id=t1.calendar_id AND t6.locale=t1.locale_id AND t6.field='cancel_tokens_client'", 'left outer')
					->join('pjMultiLang', "t7.model='pjCalendar' AND t7.foreign_id=t1.calendar_id AND t7.locale=t1.locale_id AND t7.field='cancel_subject_admin'", 'left outer')
					->join('pjMultiLang', "t8.model='pjCalendar' AND t8.foreign_id=t1.calendar_id AND t8.locale=t1.locale_id AND t8.field='cancel_tokens_admin'", 'left outer')
					->join('pjMultiLang', "t9.model='pjCalendar' AND t9.foreign_id=t1.calendar_id AND t9.locale=t1.locale_id AND t9.field='cancel_subject_employee'", 'left outer')
					->join('pjMultiLang', "t10.model='pjCalendar' AND t10.foreign_id=t1.calendar_id AND t10.locale=t1.locale_id AND t10.field='cancel_tokens_employee'", 'left outer')
					->find($arr['id'])
					->getData();
					
				$booking_arr['bs_arr'] = pjBookingServiceModel::factory()
					->reset()
					->select('t1.*, t3.before, t3.length, t4.content AS `service_name`, t5.content AS `employee_name`,
						t6.phone AS `employee_phone`, t6.email AS `employee_email`, t6.is_subscribed, t6.is_subscribed_sms')
					->join('pjBooking', 't2.id=t1.booking_id', 'inner')
					->join('pjService', 't3.id=t1.service_id', 'inner')
					->join('pjMultiLang', "t4.model='pjService' AND t4.foreign_id=t1.service_id AND t4.field='name' AND t4.locale=t2.locale_id", 'left outer')
					->join('pjMultiLang', "t5.model='pjEmployee' AND t5.foreign_id=t1.employee_id AND t5.field='name' AND t5.locale=t2.locale_id", 'left outer')
					->join('pjEmployee', 't6.id=t1.employee_id', 'left outer')
					->where('t1.booking_id', $arr['id'])
					->findAll()
					->getData();

				pjFrontEnd::pjActionConfirmSend($this->option_arr, $booking_arr, 'cancel');
				# Confirmation email(s)
					
				pjUtil::redirect($_SERVER['PHP_SELF'] . '?controller=pjFrontEnd&action=pjActionCancel&err=5');
			}
		} else {
			if (isset($_GET['hash']) && isset($_GET['id']))
			{
				$arr = $pjBookingModel
					->select('t1.*, t2.content AS `country_title`')
					->join('pjMultiLang', "t2.model='pjCountry' AND t2.foreign_id=t1.c_country_id AND t2.field='name' AND t2.locale='t1.locale_id'", 'left outer')
					->find($_GET['id'])
					->getData();
				if (empty($arr))
				{
					$this->set('status', 2);
				} else {
					if ($arr['booking_status'] == 'cancelled')
					{
						$this->set('status', 4);
					} else {
						$hash = sha1($arr['id'] . $arr['created'] . PJ_SALT);
						if ($_GET['hash'] != $hash)
						{
							$this->set('status', 3);
						} else {
							
							$details_arr = pjBookingServiceModel::factory()
								->select('t1.*, t2.content AS `service_name`, t3.content AS `employee_name`, t4.before, t4.length')
								->join('pjMultiLang', sprintf("t2.model='pjService' AND t2.foreign_id=t1.service_id AND t2.field='name' AND t2.locale='%u'", $arr['locale_id']), 'left outer')
								->join('pjMultiLang', sprintf("t3.model='pjEmployee' AND t3.foreign_id=t1.employee_id AND t3.field='name' AND t3.locale='%u'", $arr['locale_id']), 'left outer')
								->join('pjService', 't4.id=t1.service_id', 'left outer')
								->where('t1.booking_id', $arr['id'])
								->orderBy("t1.start_ts ASC")
								->findAll()
								->getData();
							
							$start_time = $details_arr[0]['start_ts'];
							$cancel_earlier = $this->option_arr['o_cancel_earlier'] * 60 * 60;
							if(time() + $cancel_earlier > $start_time)					
							{
								$this->set('status', 6);
							}else{
								$arr['details_arr'] = $details_arr;
								$this->set('arr', $arr);
							}
						}
					}
				}
			} elseif (!isset($_GET['err'])) {
				$this->set('status', 1);
			}
			$this->appendCss('index.php?controller=pjFrontEnd&action=pjActionLoadCss', PJ_INSTALL_URL, true);
		}
	}
	
	public function pjActionCaptcha()
	{
		$pjCaptcha = new pjCaptcha(PJ_WEB_PATH . 'obj/Anorexia.ttf', $this->defaultCaptcha, 6);
		$pjCaptcha->setImage(PJ_IMG_PATH . 'frontend/as-captcha.png')->init(@$_GET['rand']);
		exit;
	}
	
	public function pjActionCheckCaptcha()
	{
		if ($this->isXHR())
		{
			echo isset($_SESSION[$this->defaultCaptcha]) && isset($_GET['captcha']) && $_SESSION[$this->defaultCaptcha] == strtoupper($_GET['captcha']) ? 'true' : 'false';
		}
		exit;
	}
		
	public function pjActionConfirmAuthorize()
	{
		$this->setAjax(true);
		
		if (pjObject::getPlugin('pjAuthorize') === NULL)
		{
			$this->log('Authorize.NET plugin not installed');
			exit;
		}
		
		if (!isset($_POST['x_invoice_num']))
		{
			$this->log('Missing arguments');
			exit;
		}
		
		$pjInvoiceModel = pjInvoiceModel::factory();
		$pjBookingModel = pjBookingModel::factory();
		
		$invoice_arr = $pjInvoiceModel
			->where('t1.uuid', $_POST['x_invoice_num'])
			->limit(1)
			->findAll()
			->getData();
		if (!empty($invoice_arr))
		{
			$invoice_arr = $invoice_arr[0];
			$booking_arr = $pjBookingModel
				->select('t1.*, t1.id AS `booking_id`, t3.email AS `admin_email`, t4.content AS `country_name`,
					t5.content AS `payment_subject_client`, t6.content AS `payment_tokens_client`,
					t7.content AS `payment_subject_admin`, t8.content AS `payment_tokens_admin`,
					t9.content AS `payment_subject_employee`, t10.content AS `payment_tokens_employee`')
				->join('pjCalendar', 't2.id=t1.calendar_id', 'left outer')
				->join('pjUser', 't3.id=t2.user_id', 'left outer')
				->join('pjMultiLang', "t4.model='pjCountry' AND t4.foreign_id=t1.c_country_id AND t4.locale=t1.locale_id AND t4.field='name'", 'left outer')
				->join('pjMultiLang', "t5.model='pjCalendar' AND t5.foreign_id=t1.calendar_id AND t5.locale=t1.locale_id AND t5.field='payment_subject_client'", 'left outer')
				->join('pjMultiLang', "t6.model='pjCalendar' AND t6.foreign_id=t1.calendar_id AND t6.locale=t1.locale_id AND t6.field='payment_tokens_client'", 'left outer')
				->join('pjMultiLang', "t7.model='pjCalendar' AND t7.foreign_id=t1.calendar_id AND t7.locale=t1.locale_id AND t7.field='payment_subject_admin'", 'left outer')
				->join('pjMultiLang', "t8.model='pjCalendar' AND t8.foreign_id=t1.calendar_id AND t8.locale=t1.locale_id AND t8.field='payment_tokens_admin'", 'left outer')
				->join('pjMultiLang', "t9.model='pjCalendar' AND t9.foreign_id=t1.calendar_id AND t9.locale=t1.locale_id AND t9.field='payment_subject_employee'", 'left outer')
				->join('pjMultiLang', "t10.model='pjCalendar' AND t10.foreign_id=t1.calendar_id AND t10.locale=t1.locale_id AND t10.field='payment_tokens_employee'", 'left outer')
				->where('t1.uuid', $invoice_arr['order_id'])
				->limit(1)
				->findAll()
				->getData();
			if (!empty($booking_arr))
			{
				$booking_arr = $booking_arr[0];
				$option_arr = pjOptionModel::factory()->getPairs($booking_arr['calendar_id']);

				$params = array(
					'transkey' => $option_arr['o_authorize_key'],
					'x_login' => $option_arr['o_authorize_mid'],
					'md5_setting' => $option_arr['o_authorize_hash'],
					'key' => md5($this->option_arr['private_key'] . PJ_SALT)
				);
				
				$response = $this->requestAction(array('controller' => 'pjAuthorize', 'action' => 'pjActionConfirm', 'params' => $params), array('return'));
				if ($response !== FALSE && $response['status'] === 'OK')
				{
					$pjBookingModel
						->reset()
						->set('id', $booking_arr['id'])
						->modify(array('booking_status' => $option_arr['o_status_if_paid']));
						
					$pjInvoiceModel
						->reset()
						->set('id', $invoice_arr['id'])
						->modify(array('status' => 'paid', 'modified' => ':NOW()'));
					
					$booking_arr['bs_arr'] = pjBookingServiceModel::factory()
						->select('t1.*, t3.before, t3.length, t4.phone AS `employee_phone`, t4.email AS `employee_email`, t4.is_subscribed, t4.is_subscribed_sms,
							t5.content AS `service_name`, t6.content AS `employee_name`')
						->join('pjBooking', 't2.id=t1.booking_id', 'inner')
						->join('pjService', 't3.id=t1.service_id', 'inner')
						->join('pjEmployee', 't4.id=t1.employee_id', 'inner')
						->join('pjMultiLang', "t5.model='pjService' AND t5.foreign_id=t1.service_id AND t5.field='name' AND t5.locale=t2.locale_id", 'left outer')
						->join('pjMultiLang', "t6.model='pjEmployee' AND t6.foreign_id=t1.employee_id AND t6.field='name' AND t6.locale=t2.locale_id", 'left outer')
						->where('t1.booking_id', $booking_arr['id'])
						->findAll()
						->getData();
					pjFrontEnd::pjActionConfirmSend($option_arr, $booking_arr, 'payment');
				} elseif (!$response) {
					$this->log('Authorization failed');
				} else {
					$this->log('Booking not confirmed. ' . $response['response_reason_text']);
				}
			} else {
				$this->log('Booking not found');
			}
		} else {
			$this->log('Invoice not found');
		}
		exit;
	}

	public function pjActionConfirmPaypal()
	{
		$this->setAjax(true);
		
		if (pjObject::getPlugin('pjPaypal') === NULL)
		{
			$this->log('Paypal plugin not installed');
			exit;
		}
		
		$pjInvoiceModel = pjInvoiceModel::factory();
		$pjBookingModel = pjBookingModel::factory();

		$invoice_arr = $pjInvoiceModel
			->where('t1.uuid', $_POST['custom'])
			->limit(1)
			->findAll()
			->getData();

		if (!empty($invoice_arr))
		{
			$invoice_arr = $invoice_arr[0];
			$booking_arr = $pjBookingModel
				->select('t1.*, t1.id AS `booking_id`, t3.email AS `admin_email`, t4.content AS `country_name`,
					t5.content AS `payment_subject_client`, t6.content AS `payment_tokens_client`,
					t7.content AS `payment_subject_admin`, t8.content AS `payment_tokens_admin`,
					t9.content AS `payment_subject_employee`, t10.content AS `payment_tokens_employee`')
				->join('pjCalendar', 't2.id=t1.calendar_id', 'left outer')
				->join('pjUser', 't3.id=t2.user_id', 'left outer')
				->join('pjMultiLang', "t4.model='pjCountry' AND t4.foreign_id=t1.c_country_id AND t4.locale=t1.locale_id AND t4.field='name'", 'left outer')
				->join('pjMultiLang', "t5.model='pjCalendar' AND t5.foreign_id=t1.calendar_id AND t5.locale=t1.locale_id AND t5.field='payment_subject_client'", 'left outer')
				->join('pjMultiLang', "t6.model='pjCalendar' AND t6.foreign_id=t1.calendar_id AND t6.locale=t1.locale_id AND t6.field='payment_tokens_client'", 'left outer')
				->join('pjMultiLang', "t7.model='pjCalendar' AND t7.foreign_id=t1.calendar_id AND t7.locale=t1.locale_id AND t7.field='payment_subject_admin'", 'left outer')
				->join('pjMultiLang', "t8.model='pjCalendar' AND t8.foreign_id=t1.calendar_id AND t8.locale=t1.locale_id AND t8.field='payment_tokens_admin'", 'left outer')
				->join('pjMultiLang', "t9.model='pjCalendar' AND t9.foreign_id=t1.calendar_id AND t9.locale=t1.locale_id AND t9.field='payment_subject_employee'", 'left outer')
				->join('pjMultiLang', "t10.model='pjCalendar' AND t10.foreign_id=t1.calendar_id AND t10.locale=t1.locale_id AND t10.field='payment_tokens_employee'", 'left outer')
				->where('t1.uuid', $invoice_arr['order_id'])
				->limit(1)
				->findAll()
				->getData();
			if (!empty($booking_arr))
			{
				$booking_arr = $booking_arr[0];
				$option_arr = pjOptionModel::factory()->getPairs($booking_arr['calendar_id']);
				$params = array(
					'txn_id' => @$booking_arr['txn_id'],
					'paypal_address' => @$option_arr['o_paypal_address'],
					'deposit' => @$invoice_arr['paid_deposit'],
					'currency' => @$invoice_arr['currency'],
					'key' => md5($this->option_arr['private_key'] . PJ_SALT)
				);

				$response = $this->requestAction(array('controller' => 'pjPaypal', 'action' => 'pjActionConfirm', 'params' => $params), array('return'));
				if ($response !== FALSE && $response['status'] === 'OK')
				{
					$this->log('Booking confirmed');
					$pjBookingModel->reset()->set('id', $booking_arr['id'])->modify(array(
						'booking_status' => $option_arr['o_status_if_paid'],
						'txn_id' => $response['transaction_id'],
						'processed_on' => ':NOW()'
					));
					
					$pjInvoiceModel
						->reset()
						->set('id', $invoice_arr['id'])
						->modify(array('status' => 'paid', 'modified' => ':NOW()'));
						
					$booking_arr['bs_arr'] = pjBookingServiceModel::factory()
						->select('t1.*, t3.before, t3.length, t4.phone AS `employee_phone`, t4.email AS `employee_email`, t4.is_subscribed, t4.is_subscribed_sms,
							t5.content AS `service_name`, t6.content AS `employee_name`')
						->join('pjBooking', 't2.id=t1.booking_id', 'inner')
						->join('pjService', 't3.id=t1.service_id', 'inner')
						->join('pjEmployee', 't4.id=t1.employee_id', 'inner')
						->join('pjMultiLang', "t5.model='pjService' AND t5.foreign_id=t1.service_id AND t5.field='name' AND t5.locale=t2.locale_id", 'left outer')
						->join('pjMultiLang', "t6.model='pjEmployee' AND t6.foreign_id=t1.employee_id AND t6.field='name' AND t6.locale=t2.locale_id", 'left outer')
						->where('t1.booking_id', $booking_arr['id'])
						->findAll()
						->getData();
					pjFrontEnd::pjActionConfirmSend($option_arr, $booking_arr, 'payment');
				} elseif (!$response) {
					$this->log('Authorization failed');
				} else {
					$this->log('Booking not confirmed');
				}
			} else {
				$this->log('Booking not found');
			}
		} else {
			$this->log('Invoice not found');
		}
		exit;
	}
	
	private static function pjActionConfirmSend($option_arr, $booking_arr, $type)
	{
		if (!in_array($type, array('confirm', 'payment', 'cancel')))
		{
			return false;
		}
		$Email = new pjEmail();
		$Email->setContentType('text/html');
		if ($option_arr['o_send_email'] == 'smtp')
		{
			$Email
				->setTransport('smtp')
				->setSmtpHost($option_arr['o_smtp_host'])
				->setSmtpPort($option_arr['o_smtp_port'])
				->setSmtpUser($option_arr['o_smtp_user'])
				->setSmtpPass($option_arr['o_smtp_pass'])
			;
		}
		$tokens = pjAppController::getTokens($booking_arr, $option_arr, 'multi');
		$from = pjAppController::getFromEmail();
		$admin_email = pjAppController::getAdminEmail();
		switch ($type)
		{
			case 'confirm':
				// Client
				$subject = str_replace($tokens['search'], $tokens['replace'], @$booking_arr['confirm_subject_client']);
				$message = str_replace($tokens['search'], $tokens['replace'], @$booking_arr['confirm_tokens_client']);
				if (!empty($subject) && !empty($message))
				{
					$message = pjUtil::textToHtml($message);
					$Email
						->setTo($booking_arr['c_email'])
						->setFrom($booking_arr['admin_email'])
						->setSubject($subject)
						->send($message);
				}
				// Admin
				$subject = str_replace($tokens['search'], $tokens['replace'], @$booking_arr['confirm_subject_admin']);
				$message = str_replace($tokens['search'], $tokens['replace'], @$booking_arr['confirm_tokens_admin']);
				if (!empty($subject) && !empty($message))
				{
					$message = pjUtil::textToHtml($message);
					foreach($admin_email as $email)
					{
						$Email
							->setTo($email)
							->setFrom($from)
							->setSubject($subject)
							->send($message);
					}
				}
				// Employee
				foreach ($booking_arr['bs_arr'] as $item)
				{
					if ((int) $item['is_subscribed'] === 1 && !empty($item['employee_email']))
					{
						$tokens = pjAppController::getTokens(array_merge($booking_arr, $item), $option_arr);
						$subject = str_replace($tokens['search'], $tokens['replace'], @$booking_arr['confirm_subject_employee']);
						$message = str_replace($tokens['search'], $tokens['replace'], @$booking_arr['confirm_tokens_employee']);
						if (!empty($subject) && !empty($message))
						{
							$message = pjUtil::textToHtml($message);
							$Email
								->setTo($item['employee_email'])
								->setFrom($booking_arr['admin_email'])
								->setSubject($subject)
								->send($message);
						}
					}
				}
				break;
			case 'payment':
				// Client
				$subject = str_replace($tokens['search'], $tokens['replace'], @$booking_arr['payment_subject_client']);
				$message = str_replace($tokens['search'], $tokens['replace'], @$booking_arr['payment_tokens_client']);
				if (!empty($subject) && !empty($message))
				{
					$message = pjUtil::textToHtml($message);
					$Email
						->setTo($booking_arr['c_email'])
						->setFrom($booking_arr['admin_email'])
						->setSubject($subject)
						->send($message);
				}
				// Admin
				$subject = str_replace($tokens['search'], $tokens['replace'], @$booking_arr['payment_subject_admin']);
				$message = str_replace($tokens['search'], $tokens['replace'], @$booking_arr['payment_tokens_admin']);
				if (!empty($subject) && !empty($message))
				{
					$message = pjUtil::textToHtml($message);
					foreach($admin_email as $email)
					{
						$Email
							->setTo($email)
							->setFrom($from)
							->setSubject($subject)
							->send($message);
					}
				}
				// Employee
				foreach ($booking_arr['bs_arr'] as $item)
				{
					if ((int) $item['is_subscribed'] === 1 && !empty($item['employee_email']))
					{
						$tokens = pjAppController::getTokens(array_merge($booking_arr, $item), $option_arr, 'single');
						$subject = str_replace($tokens['search'], $tokens['replace'], @$booking_arr['payment_subject_employee']);
						$message = str_replace($tokens['search'], $tokens['replace'], @$booking_arr['payment_tokens_employee']);
						if (!empty($subject) && !empty($message))
						{
							$message = pjUtil::textToHtml($message);
							$Email
								->setTo($item['employee_email'])
								->setFrom($booking_arr['admin_email'])
								->setSubject($subject)
								->send($message);
						}
					}
				}
				break;
			case 'cancel':
				// Client
				$subject = str_replace($tokens['search'], $tokens['replace'], @$booking_arr['cancel_subject_client']);
				$message = str_replace($tokens['search'], $tokens['replace'], @$booking_arr['cancel_tokens_client']);
				if (!empty($subject) && !empty($message))
				{
					$message = pjUtil::textToHtml($message);
					$Email
						->setTo($booking_arr['c_email'])
						->setFrom($booking_arr['admin_email'])
						->setSubject($subject)
						->send($message);
				}
				// Admin
				$subject = str_replace($tokens['search'], $tokens['replace'], @$booking_arr['cancel_subject_admin']);
				$message = str_replace($tokens['search'], $tokens['replace'], @$booking_arr['cancel_tokens_admin']);
				if (!empty($subject) && !empty($message))
				{
					$message = pjUtil::textToHtml($message);
					foreach($admin_email as $email)
					{
						$Email
							->setTo($email)
							->setFrom($from)
							->setSubject($subject)
							->send($message);
					}
				}
				// Employee
				foreach ($booking_arr['bs_arr'] as $item)
				{
					if ((int) $item['is_subscribed'] === 1 && !empty($item['employee_email']))
					{
						$tokens = pjAppController::getTokens(array_merge($booking_arr, $item), $option_arr, 'single');
						$subject = str_replace($tokens['search'], $tokens['replace'], @$booking_arr['cancel_subject_employee']);
						$message = str_replace($tokens['search'], $tokens['replace'], @$booking_arr['cancel_tokens_employee']);
						if (!empty($subject) && !empty($message))
						{
							$message = pjUtil::textToHtml($message);
							$Email
								->setTo($item['employee_email'])
								->setFrom($booking_arr['admin_email'])
								->setSubject($subject)
								->send($message);
						}
					}
				}
				break;
		}
	}
	
	public function pjActionGetCalendar()
	{
		list($year, $month, $day) = explode("-", $_GET['date']);
		$dates = $this->getDates($_GET['cid'], $_GET['year'], $_GET['month']);
		if((int) $month === (int) $_GET['month'] && (int) $year === (int) $_GET['year'])
		{
			$this->set('calendar', $this->getCalendar($dates[0], $_GET['year'], $_GET['month'], $day));
		}else{
			$this->set('calendar', $this->getCalendar($dates[0], $_GET['year'], $_GET['month']));
		}
	}
	
	public function pjActionGetCart()
	{
		$this->set('cart_arr', $this->getCart($_GET['cid']));
	}

	public function pjActionGetTerms()
	{
		if ($this->isXHR())
		{
			$this->set('terms_arr', $this->getTerms($_GET['cid']));
		}
	}
	
	public function pjActionGetTime()
	{
		$this->set('service_arr', pjServiceModel::factory()->find($_GET['service_id'])->getData());
		$this->set('t_arr', pjAppController::getSingleDateSlots($_GET['cid'], $_GET['date']));
	}
	
	public function pjActionGetEmployees()
	{
		$employee_arr = array();
		if(isset($_GET['service_id']))
		{
			$pjEmployeeModel = pjEmployeeModel::factory();
			$table = pjEmployeeServiceModel::factory()->getTable();
			if((int) $_GET['service_id'] > 0)
			{
				$pjEmployeeModel->where("(t1.id IN (SELECT TES2.employee_id FROM `".$table."` AS TES2 WHERE TES2.service_id = '".$_GET['service_id']."'))");
			}
			
			$employee_arr = $pjEmployeeModel
				->select("t1.*, t2.content AS `name`, 
							(
								SELECT GROUP_CONCAT(TL.content SEPARATOR ',') 
								FROM `".pjServiceModel::factory()->getTable()."` AS TS LEFT OUTER JOIN `".pjMultiLangModel::factory()->getTable()."` AS TL ON TL.model='pjService' AND TL.foreign_id=TS.id AND TL.locale='".$this->getLocaleId()."' AND TL.field='name' 
								WHERE TS.id IN (
						                         	SELECT TES.service_id 
													FROM `".$table."` AS TES 
													WHERE TES.employee_id = t1.id
												) 
							) AS services")
				->join('pjMultiLang', "t2.model='pjEmployee' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
				->where('t1.calendar_id', $_GET['cid'])
				->orderBy('`name` ASC')
				->findAll()
				->getData();
		}
		$this->set('employee_arr', $employee_arr);
	}
	
	public function pjActionGetIsoDate()
	{
		if ($this->isXHR())
		{
			if(isset($_GET['date']) && !empty($_GET['date']))
			{
				$date = pjUtil::formatDate($_GET['date'], $this->option_arr['o_date_format']);
				pjAppController::jsonResponse(array('date' => $date));
			}
			exit;
		}
	}
}
?>