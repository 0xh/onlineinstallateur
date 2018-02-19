<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjFrontPublic extends pjFront
{
	public function __construct()
	{
		parent::__construct();
		
		$this->setAjax(true);
		
		$this->setLayout('pjActionEmpty');
	}
	
	public function pjActionCart()
	{
		if ($this->isXHR() || isset($_GET['_escaped_fragment_']))
		{
			$this->set('cart_arr', $this->getCart($this->getForeignId()));
		}
	}
	
	public function pjActionCheckout()
	{
		if ($this->isXHR() || isset($_GET['_escaped_fragment_']))
		{
			if ($this->cart->isEmpty())
			{
				$this->set('status', 'ERR');
				$this->set('code', '101'); //Empty cart
				return;
			}
			
			if (isset($_POST['as_checkout']))
			{
				$_SESSION[$this->defaultForm] = array_merge($_SESSION[$this->defaultForm], $_POST);
				pjAppController::jsonResponse(array('status' => 'OK', 'code' => 211, 'text' => __('system_211', true)));
			}
			
			if (in_array($this->option_arr['o_bf_country'], array(2,3)))
			{
				$this->set('country_arr', pjCountryModel::factory()
					->select('t1.*, t2.content AS name')
					->join('pjMultiLang', "t2.model='pjCountry' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
					->where('t1.status', 'T')
					->orderBy('`name` ASC')
					->findAll()
					->getData()
				);
			}
			
			$cart = $this->cart->getAll();
			$cart_arr = $this->getCart($this->getForeignId());
			
			$this->set('status', 'OK');
			$this->set('terms_arr', $this->getTerms($this->getForeignId()));
			$this->set('summary', $this->getSummary());
			$this->set('cart', $cart);
			$this->set('cart_arr', $cart_arr);
		}
	}
	
	public function pjActionService()
	{
		if ($this->isXHR() || isset($_GET['_escaped_fragment_']))
		{
			$service_id = null;
			$employee_id = null;
			$date = date('Y-m-d');
				
			if(isset($_GET['date']))
			{
				$date = $_GET['date'];
			}
			
			if (isset($_GET['service_id']) && (int) $_GET['service_id'] > 0 && isset($_GET['employee_id']) && (int) $_GET['employee_id'] > 0){
				$service_id = (int) $_GET['service_id'];
				$employee_id = (int) $_GET['employee_id'];
			}elseif (isset($_GET['service_id']) && (int) $_GET['service_id'] > 0){
				$service_id = (int) $_GET['service_id'];
			}elseif (isset($_GET['_escaped_fragment_'])) {
				preg_match('/\/Service\/(\d+)/', $_GET['_escaped_fragment_'], $matches);
				if (isset($matches[1]))
				{
					$service_id = $matches[1];
				}
				preg_match('/\/Service\/(\d+)\/(\d+)/', $_GET['_escaped_fragment_'], $matches);
				if (isset($matches[1]))
				{
					$service_id = $matches[1];
				}
				if (isset($matches[2]))
				{
					$employee_id = $matches[2];
				}
			
				preg_match('@^/Service/[\w\-]+\-(\d+)\.html$@', $_GET['_escaped_fragment_'], $matches);
				if ($matches)
				{
					$service_id = $matches[1];
				}
			
				preg_match('@^/Service/\d{4}/\d{2}/\d{2}/[\w\-]+\-(\d+)/[\w\-]+\-(\d+)\.html$@', $_GET['_escaped_fragment_'], $matches);
				if ($matches)
				{
					$service_id = $matches[1];
					$employee_id = $matches[2];
				}
			}
			
			list($year, $month, $day) = explode("-", $_GET['date']);
			$dates = $this->getDates($this->getForeignId(), $year, $month);
			$this->set('calendar', $this->getCalendar($dates[0], $year, $month, $day));
			
			$_employee_arr = pjEmployeeModel::factory()
				->select("t1.*, t2.content AS `name`")
				->join('pjMultiLang', "t2.model='pjEmployee' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
				->where('t1.calendar_id', $this->getForeignId())
				->where("t1.id IN (SELECT TES.employee_id FROM `".pjEmployeeServiceModel::factory()->getTable()."` AS TES WHERE TES.service_id='".$service_id."') ")
				->where('t1.is_active', 1)
				->findAll()
				->getData();
			$employee_arr = array();
			foreach($_employee_arr as $k => $v)
			{
				$app_info = pjAppController::getAppointmentInfo($v['id'], $service_id, $this->getForeignId(), $date, $this->getLocaleId());
				if (!$app_info['employee']['t_arr'])
				{
					unset($_employee_arr[$k]);
				}else{
					$employee_arr[] = $v;
				}
			}
			if(count($employee_arr) == 1)
			{
				$employee_id = $employee_arr[0]['id'];
			}
			if($service_id != null && $employee_id != null)
			{
				$app_info = pjAppController::getAppointmentInfo($employee_id, $service_id, $this->getForeignId(), $date, $this->getLocaleId());
				$this->set('service', $app_info['service']);
				$this->set('employee', $app_info['employee']);
			}
			
			if ($this->cart->isEmpty())
			{
				$this->set('status', 'ERR');
				$this->set('code', '101');
			}
			
			$this->set('date', $date);
			
			$this
				->set('service_arr', pjServiceModel::factory()
					->select("t1.*, t2.content AS `name`, t3.content AS `description`")
					->join('pjMultiLang', "t2.model='pjService' AND t2.foreign_id=t1.id AND t2.locale='".$this->getLocaleId()."' AND t2.field='name'", 'left outer')
					->join('pjMultiLang', "t3.model='pjService' AND t3.foreign_id=t1.id AND t3.locale='".$this->getLocaleId()."' AND t3.field='description'", 'left outer')
					->where('t1.calendar_id', $this->getForeignId())
					->where('t1.is_active', 1)
					->orderBy('`name` ASC')
					->findAll()
					->getData()
				)
				->set('employee_arr', $employee_arr)
				->set('cart_arr', $this->getCart($this->getForeignId()));
			
			if((int) $this->option_arr['o_booking_days_earlier'] > 0)
			{
				$today_ts = strtotime(date('Y-m-d 00:00:00', time()));
				$days_earlier = $this->option_arr['o_booking_days_earlier'] * 24 * 60 * 60;
				$ahead_ts = $today_ts + $days_earlier;
				$selected_ts = strtotime($_GET['date'] . ' 00:00:00');
				
				if($selected_ts > $ahead_ts)
				{
					$this->set('unavailable', true);
				}
			}
		}
	}
	
	public function pjActionServices()
	{
		if ($this->isXHR() || isset($_GET['_escaped_fragment_']))
		{
			$service_arr = pjServiceModel::factory()
				->select("t1.*, t2.content AS `name`, t3.content AS `description`")
				->join('pjMultiLang', "t2.model='pjService' AND t2.foreign_id=t1.id AND t2.locale='".$this->getLocaleId()."' AND t2.field='name'", 'left outer')
				->join('pjMultiLang', "t3.model='pjService' AND t3.foreign_id=t1.id AND t3.locale='".$this->getLocaleId()."' AND t3.field='description'", 'left outer')
				->where('t1.calendar_id', $this->getForeignId())
				->where('t1.is_active', 1)
				->orderBy('`name` ASC')
				->findAll()
				->getData();
			
			$_employee_arr = pjEmployeeModel::factory()
				->select("t1.*, t2.content AS `name`, 
							(
								SELECT GROUP_CONCAT(TL.content SEPARATOR ',') 
								FROM `".pjServiceModel::factory()->getTable()."` AS TS LEFT OUTER JOIN `".pjMultiLangModel::factory()->getTable()."` AS TL ON TL.model='pjService' AND TL.foreign_id=TS.id AND TL.locale='".$this->getLocaleId()."' AND TL.field='name' 
								WHERE TS.is_active='1' AND TS.id IN (
						                         	SELECT TES.service_id 
													FROM `".pjEmployeeServiceModel::factory()->getTable()."` AS TES 
													WHERE TES.employee_id = t1.id
												) 
							) AS services,
							(	SELECT GROUP_CONCAT(TS.id SEPARATOR '~:~') 
								FROM `".pjServiceModel::factory()->getTable()."` AS TS
								WHERE TS.is_active='1' AND TS.id IN (
						                         	SELECT TES.service_id 
													FROM `".pjEmployeeServiceModel::factory()->getTable()."` AS TES 
													WHERE TES.employee_id = t1.id
												)
							) AS service_ids")
				->join('pjMultiLang', "t2.model='pjEmployee' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
				->where('t1.calendar_id', $this->getForeignId())
				->where('t1.is_active', 1)
				->orderBy('`name` ASC')
				->findAll()
				->getData();
			
			$service_id_arr = array();
			$employee_arr = array();
			foreach($_employee_arr as $k => $v)
			{
				$wt_arr = pjAppController::getRawSlotsPerEmployee($v['id'], $_GET['date'],  $this->getForeignId());
				if($wt_arr == false)
				{
					unset($_employee_arr[$k]);
				}else{
					$employee_arr[] = $v;
				}
			}
			foreach($employee_arr as $k => $v)
			{
				if(!empty($v['service_ids']))
				{
					$_arr = explode("~:~", $v['service_ids']);
					foreach($_arr as $sid)
					{
						if(isset($service_id_arr[$sid]))
						{
							$service_id_arr[$sid] += 1;
						}else{
							$service_id_arr[$sid] = 1;
						}
					}
				}
			}
			
			$this->set('service_id_arr', $service_id_arr);
			$this->set('service_arr', $service_arr);
			$this->set('employee_arr', $employee_arr);
			$this->set('cart_arr',  $this->getCart($this->getForeignId()));
			
			list($year, $month, $day) = explode("-", $_GET['date']);
			$dates = $this->getDates($this->getForeignId(), $year, $month);
			$this->set('calendar', $this->getCalendar($dates[0], $year, $month, $day));
			
			if((int) $this->option_arr['o_booking_days_earlier'] > 0)
			{
				$today_ts = strtotime(date('Y-m-d 00:00:00', time()));
				$days_earlier = $this->option_arr['o_booking_days_earlier'] * 24 * 60 * 60;
				$ahead_ts = $today_ts + $days_earlier;
				$selected_ts = strtotime($_GET['date'] . ' 00:00:00');
				
				if($selected_ts > $ahead_ts)
				{
					$this->set('unavailable', true);
				}
			}
			switch ($_GET['layout'])
			{
				case 2:
					$this->setTemplate('pjFrontPublic', 'pjActionServices');
					break;
				case 1:
				default:
					$this->setTemplate('pjFrontPublic', 'pjActionEmployees');
					break;
			}
		}
	}
	
	public function pjActionEmployee()
	{
		if ($this->isXHR() || isset($_GET['_escaped_fragment_']))
		{
			$service_id = null;
			$employee_id = null;
			$date = date('Y-m-d');
	
			if(isset($_GET['date']))
			{
				$date = $_GET['date'];
			}
				
			if (isset($_GET['service_id']) && (int) $_GET['service_id'] > 0 && isset($_GET['employee_id']) && (int) $_GET['employee_id'] > 0){
				$service_id = (int) $_GET['service_id'];
				$employee_id = (int) $_GET['employee_id'];
			}elseif (isset($_GET['employee_id']) && (int) $_GET['employee_id'] > 0){
				$employee_id = (int) $_GET['employee_id'];
			}elseif (isset($_GET['_escaped_fragment_'])) {
				preg_match('/\/Employee\/(\d+)/', $_GET['_escaped_fragment_'], $matches);
				if (isset($matches[1]))
				{
					$employee_id = $matches[1];
				}
				preg_match('/\/Employee\/(\d+)\/(\d+)/', $_GET['_escaped_fragment_'], $matches);
				if (isset($matches[1]))
				{
					$employee_id = $matches[1];
				}
				if (isset($matches[2]))
				{
					$service_id = $matches[2];
				}
					
				preg_match('@^/Employee/[\w\-]+\-(\d+)\.html$@', $_GET['_escaped_fragment_'], $matches);
				if ($matches)
				{
					$employee_id = $matches[1];
				}
					
				preg_match('@^/Employee/\d{4}/\d{2}/\d{2}/[\w\-]+\-(\d+)/[\w\-]+\-(\d+)\.html$@', $_GET['_escaped_fragment_'], $matches);
				if ($matches)
				{
					$employee_id = $matches[1];
					$service_id = $matches[2];
				}
			}
				
			list($year, $month, $day) = explode("-", $_GET['date']);
			$dates = $this->getDates($this->getForeignId(), $year, $month);
			$this->set('calendar', $this->getCalendar($dates[0], $year, $month, $day));

			$service_arr = pjServiceModel::factory()
				->select("t1.*, t2.content AS `name`")
				->join('pjMultiLang', "t2.model='pjService' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
				->where('t1.calendar_id', $this->getForeignId())
				->where("t1.id IN (SELECT TES.service_id FROM `".pjEmployeeServiceModel::factory()->getTable()."` AS TES WHERE TES.employee_id='".$employee_id."') ")
				->where('t1.is_active', 1)
				->findAll()
				->getData();
			
			if(count($service_arr) == 1)
			{
				$service_id = $service_arr[0]['id'];
			}
			if($service_id != null && $employee_id != null)
			{
				$app_info = pjAppController::getAppointmentInfo($employee_id, $service_id, $this->getForeignId(), $date, $this->getLocaleId());
				$this->set('service', $app_info['service']);
				$this->set('employee', $app_info['employee']);
			}
			if ($this->cart->isEmpty())
			{
				$this->set('status', 'ERR');
				$this->set('code', '101');
			}
			
			$this->set('date', $date);
				
			$employee_arr = pjEmployeeModel::factory()
				->select("t1.*, t2.content AS `name`,
							(
								SELECT GROUP_CONCAT(TL.content SEPARATOR ',')
								FROM `".pjServiceModel::factory()->getTable()."` AS TS LEFT OUTER JOIN `".pjMultiLangModel::factory()->getTable()."` AS TL ON TL.model='pjService' AND TL.foreign_id=TS.id AND TL.locale='".$this->getLocaleId()."' AND TL.field='name'
								WHERE TS.is_active='1' AND TS.id IN (
						                         	SELECT TES.service_id
													FROM `".pjEmployeeServiceModel::factory()->getTable()."` AS TES
													WHERE TES.employee_id = t1.id
												)
							) AS services")
				->join('pjMultiLang', "t2.model='pjEmployee' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
				->where('t1.calendar_id', $this->getForeignId())
				->where('t1.is_active', 1)
				->orderBy('`name` ASC')
				->findAll()
				->getData();

			if((int) $this->option_arr['o_booking_days_earlier'] > 0)
			{
				$today_ts = strtotime(date('Y-m-d 00:00:00', time()));
				$days_earlier = $this->option_arr['o_booking_days_earlier'] * 24 * 60 * 60;
				$ahead_ts = $today_ts + $days_earlier;
				$selected_ts = strtotime($_GET['date'] . ' 00:00:00');
					
				if($selected_ts > $ahead_ts)
				{
					$this->set('unavailable', true);
				}
			}
			
			$this
				->set('employee_arr', $employee_arr)
				->set('service_arr', $service_arr)
				->set('cart_arr', $this->getCart($this->getForeignId()));
		}
	}
	
	public function pjActionBooking()
	{
		if ($this->isXHR() || isset($_GET['_escaped_fragment_']))
		{
			$this->set('status', 'OK');
			
			if (isset($_GET['booking_uuid']) && !empty($_GET['booking_uuid']))
			{
				$booking_uuid = $_GET['booking_uuid'];
			} elseif (isset($_GET['_escaped_fragment_'])) {
				preg_match('/\/Booking\/([A-Z]{2}\d{10})/', $_GET['_escaped_fragment_'], $matches);
				if (isset($matches[1]))
				{
					$booking_uuid = $matches[1];
				}
			}
			
			$booking_arr = pjBookingModel::factory()->where('t1.uuid', $booking_uuid)->findAll()->limit(1)->getData();
			if (!empty($booking_arr))
			{
				$booking_arr = $booking_arr[0];
				
				$invoice_arr = pjInvoiceModel::factory()->where('t1.order_id', $booking_uuid)->findAll()->limit(1)->getData();
				if (!empty($invoice_arr))
				{
					$invoice_arr = $invoice_arr[0];
					
					switch ($booking_arr['payment_method'])
					{
						case 'paypal':
							$this->set('params', array(
								'name' => 'asPaypal',
								'id' => 'asPaypal',
								'target' => '_self',
								'business' => $this->option_arr['o_paypal_address'],
								'item_name' => $booking_arr['uuid'],
								'custom' => $invoice_arr['uuid'],
								'amount' => $invoice_arr['paid_deposit'],
								'currency_code' => $invoice_arr['currency'],
								'return' => $this->option_arr['o_thankyou_page'],
								'notify_url' => PJ_INSTALL_URL . 'index.php?controller=pjFrontEnd&action=pjActionConfirmPaypal',
								'submit' => __('payment_paypal_submit', true),
								'submit_class' => 'asSelectorButton asButton asButtonGreen'
							));
							break;
						case 'authorize':
							$this->set('params', array(
								'name' => 'asAuthorize',
								'id' => 'asAuthorize',
								'target' => '_self',
								'timezone' => $this->option_arr['o_authorize_tz'],
								'transkey' => $this->option_arr['o_authorize_key'],
								'x_login' => $this->option_arr['o_authorize_mid'],
								'x_description' => $booking_arr['uuid'],
								'x_amount' => $invoice_arr['paid_deposit'],
								'x_invoice_num' => $invoice_arr['uuid'],
								'x_receipt_link_url' => $this->option_arr['o_thankyou_page'],
								'x_relay_url' => PJ_INSTALL_URL . 'index.php?controller=pjFrontEnd&action=pjActionConfirmAuthorize',
								'submit' => __('payment_authorize_submit', true),
								'submit_class' => 'asSelectorButton asButton asButtonGreen'
							));
							break;
					}
					
					$this->set('booking_arr', $booking_arr);
					$this->set('invoice_arr', $invoice_arr);
				}
			}
		}
	}
	
	public function pjActionPreview()
	{
		if ($this->isXHR() || isset($_GET['_escaped_fragment_']))
		{
			if ($this->cart->isEmpty())
			{
				$this->set('status', 'ERR');
				$this->set('code', '101'); //Empty cart
				return;
			}
			
			if (!isset($_SESSION[$this->defaultForm]) || empty($_SESSION[$this->defaultForm]))
			{
				$this->set('status', 'ERR');
				$this->set('code', '102'); //Checkout form not filled
				return;
			}
			
			if (in_array($this->option_arr['o_bf_country'], array(2,3)) && (int) @$_SESSION[$this->defaultForm]['c_country_id'] > 0)
			{
				$this->set('country_arr', pjCountryModel::factory()
					->select('t1.*, t2.content AS name')
					->join('pjMultiLang', "t2.model='pjCountry' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
					->find($_SESSION[$this->defaultForm]['c_country_id'])
					->getData()
				);
			}
			$cart = $this->cart->getAll();
			$cart_arr = $this->getCart($this->getForeignId());
			
			$this->set('status', 'OK');
			$this->set('summary', $this->getSummary());
			$this->set('cart', $cart);
			$this->set('cart_arr', $cart_arr);
		}
	}
		
	public function pjActionLoadCart()
	{	
		$this->setAjax(true);
		
		if ($this->isXHR() || isset($_GET['_escaped_fragment_']))
		{
			if ($this->cart->isEmpty())
			{
				$this->set('status', 'ERR');
				$this->set('code', '101');
				return;
			}
			$this->set('status', 'OK');
			$this->set('cart_arr', $this->getCart($this->getForeignId()));
			$this->setTemplate('pjFrontPublic', 'pjActionLoadCart');
		}
	}
	
	public function pjActionRouter()
	{
		$this->setAjax(false);

		if (isset($_GET['_escaped_fragment_']))
		{
			$templates = array('Checkout', 'Preview', 'Service', 'Services', 'Booking', 'Cart', 'Appointment');
			preg_match('/^\/(\w+).*/', $_GET['_escaped_fragment_'], $m);
			if (isset($m[1]) && in_array($m[1], $templates))
			{
				$template = 'pjAction'.$m[1];
			
				if (method_exists($this, $template))
				{
					$this->$template();
				}
				$this->setTemplate('pjFrontPublic', $template);
			}
		}
	}
	
}
?>