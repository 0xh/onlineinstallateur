<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjAdminBookings extends pjAdmin
{
	public function pjActionCheckUID()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			if (!isset($_GET['uuid']) || empty($_GET['uuid']))
			{
				echo 'false';
				exit;
			}
			$pjBookingModel = pjBookingModel::factory()->where('t1.uuid', $_GET['uuid']);
			if (isset($_GET['id']) && (int) $_GET['id'] > 0)
			{
				$pjBookingModel->where('t1.id !=', $_GET['id']);
			}
			echo $pjBookingModel->findCount()->getData() == 0 ? 'true' : 'false';
		}
		exit;
	}
	
	public function pjActionCreate()
	{
		$this->checkLogin();
		
		if ($this->isAdmin())
		{
			if (isset($_POST['booking_create']))
			{
				$data = array();
				$data['calendar_id'] = $this->getForeignId();
				$data['locale_id'] = $this->getLocaleId();
				$data['ip'] = $_SERVER['REMOTE_ADDR'];
				if ($_POST['payment_method'] != "creditcard")
				{
					$data['cc_type'] = ':NULL';
					$data['cc_num'] = ':NULL';
					$data['cc_code'] = ':NULL';
					$data['cc_exp_year'] = ':NULL';
					$data['cc_exp_month'] = ':NULL';
				}
				$id = pjBookingModel::factory(array_merge($_POST, $data))->insert()->getInsertId();
				if ($id !== false && (int) $id > 0)
				{
					if (!empty($_POST['tmp_hash']))
					{
						pjBookingServiceModel::factory()
							->where('tmp_hash', $_POST['tmp_hash'])
							->modifyAll(array('booking_id' => $id, 'tmp_hash' => ':NULL'));
					}
					$err = 'ABK03';
				} else {
					$err = 'ABK04';
				}
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminBookings&action=pjActionIndex&err=$err");
			} else {
				$this->set('country_arr', pjCountryModel::factory()
					->select('t1.*, t2.content AS `name`')
					->join('pjMultiLang', "t2.model='pjCountry' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
					->where('t1.status', 'T')
					->orderBy('`name` ASC')
					->findAll()->getData());
				
				$tmp_hash = md5(uniqid(rand(), true));
				
				if(isset($_GET['employee_id']) && isset($_GET['service_id']) && isset($_GET['start_ts']))
				{
					$date = date('Y-m-d', $_GET['start_ts']);
					
					$service_arr = pjServiceModel::factory()->find($_GET['service_id'])->getData();
						
					$bs_id = pjBookingServiceModel::factory()->setAttributes(array(
							'tmp_hash' => $tmp_hash,
							'booking_id' => 0,
							'service_id' => $_GET['service_id'],
							'employee_id' => $_GET['employee_id'],
							'date' => $date,
							'start' => date("H:i:s", $_GET['start_ts']),
							'start_ts' => $_GET['start_ts'],
							'total' => @$service_arr['duration'],
							'price' => @$service_arr['price']
					))->insert()->getInsertId();
						
					if ($bs_id !== FALSE && (int) $bs_id > 0)
					{
						$this->set('bs_id', $bs_id);
					}
				}
				
				$this->set('tmp_hash', $tmp_hash);				
				$this
					->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/')
					->appendJs('pjAdminBookings.js')
					->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true);
			}
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjActionDeleteBooking()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			if (isset($_GET['id']) && (int) $_GET['id'] > 0 && pjBookingModel::factory()->set('id', $_GET['id'])->erase()->getAffectedRows() == 1)
			{
				pjBookingServiceModel::factory()->where('booking_id', $_GET['id'])->eraseAll();
				pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => ''));
			}
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => ''));
		}
		exit;
	}
	
	public function pjActionDeleteBookingBulk()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			if (isset($_POST['record']) && !empty($_POST['record']))
			{
				pjBookingModel::factory()->whereIn('id', $_POST['record'])->eraseAll();
				pjBookingServiceModel::factory()->whereIn('booking_id', $_POST['record'])->eraseAll();
				pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => ''));
			}
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => ''));
		}
		exit;
	}
	
	public function pjActionExport()
	{
		$this->checkLogin();
	
		if ($this->isAdmin())
		{
			if(isset($_POST['bookings_export']))
			{
				$pjBookingModel = pjBookingModel::factory()
					->select('t1.*, t2.*, t3.total as service_length, t4.content as employee_name, t5.content as service_name')
					->join('pjBookingService', 't2.booking_id=t1.id', 'left outer')
					->join('pjService', 't2.service_id=t3.id', 'left outer')
					->join('pjMultiLang', "t4.model='pjEmployee' AND t4.foreign_id=t2.employee_id AND t4.field='name' AND t4.locale='".$this->getLocaleId()."'", 'left outer')
					->join('pjMultiLang', "t5.model='pjService' AND t5.foreign_id=t2.service_id AND t5.field='name' AND t5.locale='".$this->getLocaleId()."'", 'left outer');
					
				if($_POST['period'] == 'next')
				{
					$column = 't2.date';
					$direction = 'ASC';
	
					$where_str = pjUtil::getComingWhere($_POST['coming_period'], $this->option_arr['o_week_start']);
					if($where_str != '')
					{
						$pjBookingModel->where($where_str);
					}
				}else{
					$column = 't1.created';
					$direction = 'ASC';
					$where_str = pjUtil::getMadeWhere($_POST['made_period'], $this->option_arr['o_week_start']);
					if($where_str != '')
					{
						$pjBookingModel->where($where_str);
					}
				}
	
				$arr= $pjBookingModel
					->orderBy("$column $direction")
					->findAll()
					->getData();
				if($_POST['type'] == 'file')
				{
					$this->setLayout('pjActionEmpty');
	
					if($_POST['format'] == 'csv')
					{
						$csv = new pjCSV();
						$csv
							->setHeader(true)
							->setName("Export-".time().".csv")
							->process($arr)
							->download();
					}
					if($_POST['format'] == 'xml')
					{
						$xml = new pjXML();
						$xml
							->setEncoding('UTF-8')
							->setName("Export-".time().".xml")
							->process($arr)
							->download();
					}
					if($_POST['format'] == 'ical')
					{
						foreach($arr as $k => $v)
						{
							$end_ts = $v['start_ts'] + 60 * $v['service_length'];
							$v['date_from'] = date('Y-m-d', $v['start_ts']) . ' ' . date('H:i:s', $v['start_ts']);
							$v['date_to'] = date('Y-m-d', $end_ts) . ' ' . date('H:i:s', $end_ts);
							$_arr = array();
							if(!empty($v['c_name']))
							{
								$_arr[] = pjSanitize::html($v['c_name']);
							}
							if(!empty($v['service_name']))
							{
								$_arr[] = 'Service name: ' . pjSanitize::html($v['service_name']);
							}
							if(!empty($v['employee_name']))
							{
								$_arr[] = 'Employee name: ' . pjSanitize::html($v['employee_name']);
							}
							if(!empty($v['c_email']))
							{
								$_arr[] = 'Email: ' . pjSanitize::html($v['c_email']);
							}
							if(!empty($v['c_phone']))
							{
								$_arr[] = 'Phone: ' . pjSanitize::html($v['c_phone']);
							}
							if(!empty($v['booking_total']))
							{
								$_arr[] = 'Price: ' . pjSanitize::html($v['booking_total']);
							}
							if(!empty($v['c_notes']))
							{
								$_arr[] = 'Notes: ' . pjSanitize::html(preg_replace('/\n|\r|\r\n/', ' ', $v['c_notes']));
							}
							$_arr[] = 'Status: ' . pjSanitize::html($v['booking_status']);
							
							$v['desc'] = join("\; ", $_arr);
							$v['location'] = '';
							$v['summary'] = 'Booking';
							$arr[$k] = $v;
						}
						
						$ical = new pjICal();
						$ical
							->setName("Export-".time().".ics")
							->setProdID('Appointment Scheduler')
							->setSummary('summary')
							->setCName('desc')
							->setLocation('location')
							->setTimezone(pjUtil::getTimezoneName($this->option_arr['o_timezone']))
							->process($arr)
							->download();
					}
					exit;
				}else{
					$pjPasswordModel = pjPasswordModel::factory();
					$password = md5($_POST['password'].PJ_SALT);
					$arr = $pjPasswordModel
						->where("t1.password", $password)
						->limit(1)
						->findAll()
						->getData();
					if (count($arr) != 1)
					{
						$pjPasswordModel->setAttributes(array('password' => $password))->insert();
					}
					$this->set('password', $password);
				}
			}
	
			$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
			$this->appendJs('pjAdminBookings.js');
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjActionExportFeed()
	{
		$this->setLayout('pjActionEmpty');
		$access = true;
		if(isset($_GET['p']))
		{
			$pjPasswordModel = pjPasswordModel::factory();
			$arr = $pjPasswordModel
				->where('t1.password', $_GET['p'])
				->limit(1)
				->findAll()
				->getData();
			if (count($arr) != 1)
			{
				$access = false;
			}
		}
		if($access == true)
		{
			$arr = $this->pjGetFeedData($_GET);
			if(!empty($arr))
			{
				if($_GET['format'] == 'xml')
				{
					$xml = new pjXML();
					echo $xml
						->setEncoding('UTF-8')
						->process($arr)
						->getData();
	
				}
				if($_GET['format'] == 'csv')
				{
					$csv = new pjCSV();
					echo $csv
						->setHeader(true)
						->process($arr)
						->getData();
	
				}
				if($_GET['format'] == 'ical')
				{
					foreach($arr as $k => $v)
					{
						$end_ts = $v['start_ts'] + 60 * $v['service_length'];
						$v['date_from'] = date('Y-m-d', $v['start_ts']) . ' ' . date('H:i:s', $v['start_ts']);
						$v['date_to'] = date('Y-m-d', $end_ts) . ' ' . date('H:i:s', $end_ts);
						$_arr = array();
						if(!empty($v['c_name']))
						{
							$_arr[] = pjSanitize::html($v['c_name']);
						}
						if(!empty($v['service_name']))
						{
							$_arr[] = 'Service name: ' . pjSanitize::html($v['service_name']);
						}
						if(!empty($v['employee_name']))
						{
							$_arr[] = 'Employee name: ' . pjSanitize::html($v['employee_name']);
						}
						if(!empty($v['c_email']))
						{
							$_arr[] = 'Email: ' . pjSanitize::html($v['c_email']);
						}
						if(!empty($v['c_phone']))
						{
							$_arr[] = 'Phone: ' . pjSanitize::html($v['c_phone']);
						}
						if(!empty($v['booking_total']))
						{
							$_arr[] = 'Price: ' . pjSanitize::html($v['booking_total']);
						}
						if(!empty($v['c_notes']))
						{
							$_arr[] = 'Notes: ' . pjSanitize::html(preg_replace('/\n|\r|\r\n/', ' ', $v['c_notes']));
						}
						$_arr[] = 'Status: ' . pjSanitize::html($v['booking_status']);
	
						$v['desc'] = join("\; ", $_arr);
						$v['location'] = '';
						$v['summary'] = 'Booking';
						$arr[$k] = $v;
					}
						
					$ical = new pjICal();
					echo $ical
						->setProdID('Appointment Scheduler')
						->setSummary('summary')
						->setCName('desc')
						->setLocation('location')
						->setTimezone(pjUtil::getTimezoneName($this->option_arr['o_timezone']))
						->process($arr)
						->getData();
	
				}
			}
		}else{
			__('lblNoAccessToFeed');
		}
		exit;
	}
	public function pjGetFeedData($get)
	{
		$arr = array();
		$status = true;
		$type = '';
		$period = '';
		if(isset($get['period']))
		{
			if(!ctype_digit($get['period']))
			{
				$status = false;
			}else{
				$period = $get['period'];
			}
		}else{
			$status = false;
		}
		if(isset($get['type']))
		{
			if(!ctype_digit($get['type']))
			{
				$status = false;
			}else{
				$type = $get['type'];
			}
		}else{
			$status = false;
		}
		if($status == true && $type != '' && $period != '')
		{
			$pjBookingModel = pjBookingModel::factory()
				->select('t1.*, t2.*, t3.total as service_length, t4.content as employee_name, t5.content as service_name')
				->join('pjBookingService', 't2.booking_id=t1.id', 'left outer')
				->join('pjService', 't2.service_id=t3.id', 'left outer')
				->join('pjMultiLang', "t4.model='pjEmployee' AND t4.foreign_id=t2.employee_id AND t4.field='name' AND t4.locale='".$this->getLocaleId()."'", 'left outer')
				->join('pjMultiLang', "t5.model='pjService' AND t5.foreign_id=t2.service_id AND t5.field='name' AND t5.locale='".$this->getLocaleId()."'", 'left outer');
			
			if($type == '1')
			{
				$column = 't2.date';
				$direction = 'ASC';
					
				$where_str = pjUtil::getComingWhere($period, $this->option_arr['o_week_start']);
				if($where_str != '')
				{
					$pjBookingModel->where($where_str);
				}
			}else{
				$column = 't1.created';
				$direction = 'DESC';
				$where_str = pjUtil::getMadeWhere($period, $this->option_arr['o_week_start']);
				if($where_str != '')
				{
					$pjBookingModel->where($where_str);
				}
			}
			$arr= $pjBookingModel
				->orderBy("$column $direction")
				->findAll()
				->getData();
		}
		return $arr;
	}
	
	public function pjActionGetBooking()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged() && $this->isAdmin())
		{
			$pjBookingModel = pjBookingModel::factory();
			$pjBookingServiceModel = pjBookingServiceModel::factory();
				
			if (isset($_GET['q']) && !empty($_GET['q']))
			{
				$q = $pjBookingModel->escapeString($_GET['q']);
				$q = str_replace(array('%', '_'), array('\%', '\_'), trim($q));
				$pjBookingModel->where(sprintf("t1.uuid LIKE '%1\$s' OR t1.c_email LIKE '%1\$s' OR t1.c_name LIKE '%1\$s'", "%$q%"));
			}

			if (isset($_GET['booking_status']) && !empty($_GET['booking_status']) && in_array((int) $_GET['booking_status'], array('confirmed', 'pending', 'cancelled')))
			{
				$pjBookingModel->where('t1.booking_status', $_GET['booking_status']);
			}
			
			if (isset($_GET['employee_id']) && (int) $_GET['employee_id'] > 0)
			{
				$pjBookingModel->where(sprintf("t1.id IN (SELECT `booking_id` FROM `%s` WHERE `employee_id` = '%u')", $pjBookingServiceModel->getTable(), (int) $_GET['employee_id']));
			}
			
			if (isset($_GET['service_id']) && (int) $_GET['service_id'] > 0)
			{
				$pjBookingModel->where(sprintf("t1.id IN (SELECT `booking_id` FROM `%s` WHERE `service_id` = '%u')", $pjBookingServiceModel->getTable(), (int) $_GET['service_id']));
			}
			
			if (isset($_GET['date_from']) && isset($_GET['date_to']) && !empty($_GET['date_from']) && !empty($_GET['date_to']))
			{
				$date_from = pjUtil::formatDate($_GET['date_from'], $this->option_arr['o_date_format']);
				$date_to = pjUtil::formatDate($_GET['date_to'], $this->option_arr['o_date_format']);
				$pjBookingModel->where(sprintf("t1.id IN (SELECT `booking_id` FROM `%s` WHERE `date` BETWEEN '%s' AND '%s')", $pjBookingServiceModel->getTable(), $date_from, $date_to));
			} else {
				if (isset($_GET['date_from']) && !empty($_GET['date_from']))
				{
					$date_from = pjUtil::formatDate($_GET['date_from'], $this->option_arr['o_date_format']);
					$pjBookingModel->where(sprintf("t1.id IN (SELECT `booking_id` FROM `%s` WHERE `date` >= '%s')", $pjBookingServiceModel->getTable(), $date_from));
				}
				if (isset($_GET['date_to']) && !empty($_GET['date_to']))
				{
					$date_to = pjUtil::formatDate($_GET['date_to'], $this->option_arr['o_date_format']);
					$pjBookingModel->where(sprintf("t1.id IN (SELECT `booking_id` FROM `%s` WHERE `date` <= '%s')", $pjBookingServiceModel->getTable(), $date_to));
				}
			}
			
			$column = 'id';
			$direction = 'DESC';
			if (isset($_GET['direction']) && isset($_GET['column']) && in_array(strtoupper($_GET['direction']), array('ASC', 'DESC')))
			{
				$column = $_GET['column'];
				$direction = strtoupper($_GET['direction']);
			}

			$total = $pjBookingModel->findCount()->getData();
			$rowCount = isset($_GET['rowCount']) && (int) $_GET['rowCount'] > 0 ? (int) $_GET['rowCount'] : 10;
			$pages = ceil($total / $rowCount);
			$page = isset($_GET['page']) && (int) $_GET['page'] > 0 ? intval($_GET['page']) : 1;
			$offset = ((int) $page - 1) * $rowCount;
			if ($page > $pages)
			{
				$page = $pages;
			}

			$data = $pjBookingModel
				->select(sprintf("t1.*,
					(SELECT GROUP_CONCAT(CONCAT_WS('~.~', bs.service_id, DATE_FORMAT(FROM_UNIXTIME(bs.start_ts), '%%Y-%%m-%%d %%H:%%i:%%s'), m.content) SEPARATOR '~:~')
						FROM `%1\$s` AS `bs`
						LEFT JOIN `%2\$s` AS `m` ON m.model='pjService' AND m.foreign_id=bs.service_id AND m.field='name' AND m.locale='%3\$u'
						WHERE bs.booking_id = t1.id) AS `items`
					", $pjBookingServiceModel->getTable(), pjMultiLangModel::factory()->getTable(), $this->getLocaleId()))
				->orderBy("$column $direction")->limit($rowCount, $offset)
				->findAll()
				->toArray('items', '~:~')
				->getData();

			foreach ($data as $k => $v)
			{
				foreach ($data[$k]['items'] as $key => $val)
				{
					$tmp = explode('~.~', $val);
					if (isset($tmp[1]))
					{
						$tmp[1] = date($this->option_arr['o_datetime_format'], strtotime($tmp[1]));
						$data[$k]['items'][$key] = join("~.~", $tmp);
					}
				}
				$data[$k]['total_formated'] = pjUtil::formatCurrencySign(number_format($v['booking_total'], 2), $this->option_arr['o_currency']);
			}
				
			pjAppController::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
		}
		exit;
	}
	
	public function pjActionGetBookingService()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged() && $this->isEmployee())
		{
			$pjBookingServiceModel = pjBookingServiceModel::factory()
				->join('pjBooking', 't2.id=t1.booking_id', 'inner')
				->where('t1.employee_id', $this->getUserId());
				
			if (isset($_GET['q']) && !empty($_GET['q']))
			{
				$q = $pjBookingServiceModel->escapeString($_GET['q']);
				$q = str_replace(array('%', '_'), array('\%', '\_'), trim($q));
				$pjBookingServiceModel->where(sprintf("t2.uuid LIKE '%1\$s' OR t2.c_email LIKE '%1\$s' OR t2.c_name LIKE '%1\$s'", "%$q%"));
			}

			if (isset($_GET['booking_status']) && !empty($_GET['booking_status']) && in_array((int) $_GET['booking_status'], array('confirmed', 'pending', 'cancelled')))
			{
				$pjBookingServiceModel->where('t2.booking_status', $_GET['booking_status']);
			}
			
			if (isset($_GET['service_id']) && (int) $_GET['service_id'] > 0)
			{
				$pjBookingServiceModel->where('t1.service_id', $_GET['service_id']);
			}
			
			if (isset($_GET['date_from']) && isset($_GET['date_to']) && !empty($_GET['date_from']) && !empty($_GET['date_to']))
			{
				$date_from = pjUtil::formatDate($_GET['date_from'], $this->option_arr['o_date_format']);
				$date_to = pjUtil::formatDate($_GET['date_to'], $this->option_arr['o_date_format']);
				$pjBookingServiceModel->where(sprintf("(t1.date BETWEEN '%s' AND '%s')", $date_from, $date_to));
			} else {
				if (isset($_GET['date_from']) && !empty($_GET['date_from']))
				{
					$date_from = pjUtil::formatDate($_GET['date_from'], $this->option_arr['o_date_format']);
					$pjBookingServiceModel->where('t1.date >=', $date_from);
				}
				if (isset($_GET['date_to']) && !empty($_GET['date_to']))
				{
					$date_to = pjUtil::formatDate($_GET['date_to'], $this->option_arr['o_date_format']);
					$pjBookingServiceModel->where('t1.date <=', $date_to);
				}
			}
			
			$column = 't1.date';
			$direction = 'DESC';
			if (isset($_GET['direction']) && isset($_GET['column']) && in_array(strtoupper($_GET['direction']), array('ASC', 'DESC')))
			{
				$column = $_GET['column'];
				$direction = strtoupper($_GET['direction']);
			}

			$total = $pjBookingServiceModel->findCount()->getData();
			$rowCount = isset($_GET['rowCount']) && (int) $_GET['rowCount'] > 0 ? (int) $_GET['rowCount'] : 10;
			$pages = ceil($total / $rowCount);
			$page = isset($_GET['page']) && (int) $_GET['page'] > 0 ? intval($_GET['page']) : 1;
			$offset = ((int) $page - 1) * $rowCount;
			if ($page > $pages)
			{
				$page = $pages;
			}

			$data = $pjBookingServiceModel
				->select("t1.*, t2.uuid, t2.booking_status, t2.c_name, t2.c_email, t2.c_phone, t3.content AS `service_name`")
				->join('pjMultiLang', "t3.model='pjService' AND t3.foreign_id=t1.service_id AND t3.field='name' AND t3.locale='".$this->getLocaleId()."'", 'left outer')
				->orderBy("$column $direction")->limit($rowCount, $offset)
				->findAll()
				->getData();

			foreach ($data as $k => $v)
			{
				$data[$k]['time'] = date($this->option_arr['o_datetime_format'], $v['start_ts']);
			}
				
			pjAppController::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
		}
		exit;
	}
	
	public function pjActionGetPrice()
	{
		$this->setAjax(true);
		
		if ($this->isXHR())
		{
			$price = $deposit = $tax = $total = 0;
			
			if (isset($_POST['id']) && (int) $_POST['id'] > 0)
			{
				$key = 't1.booking_id';
				$value = $_POST['id'];
			} elseif (isset($_POST['tmp_hash']) && !empty($_POST['tmp_hash'])) {
				$key = 't1.tmp_hash';
				$value = $_POST['tmp_hash'];
			}
			
			if (isset($key) && isset($value))
			{
				$bs_arr = pjBookingServiceModel::factory()->where($key, $value)->findAll()->getData();
				if(empty($bs_arr))
				{
					pjAppController::jsonResponse(array('status' => 'ERR'));
				}
				foreach ($bs_arr as $service)
				{
					$price += $service['price'];
				}
			}
			
			if ((float) $this->option_arr['o_tax'] > 0)
			{
				$tax = ($price * (float) $this->option_arr['o_tax']) / 100;
			}
			
			$total = $price + $tax;
			
			switch ($this->option_arr['o_deposit_type'])
			{
				case 'percent':
					$deposit = ($total * (float) $this->option_arr['o_deposit']) / 100;
					break;
				case 'amount':
					$deposit = (float) $this->option_arr['o_deposit'];
					break;
			}
			
			$data = compact('price', 'deposit', 'tax', 'total');
			$data = array_map('floatval', $data);
			
			pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => '', 'data' => $data));
		}
		exit;
	}
	
	public function pjActionGetService()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			if (isset($_GET['id']) && (int) $_GET['id'] > 0 && isset($_GET['date']) && !empty($_GET['date']))
			{
				$id = (int) $_GET['id'];
				$date = pjUtil::formatDate($_GET['date'], $this->option_arr['o_date_format']);
				
				$pjEmployeeServiceModel = pjEmployeeServiceModel::factory()
					->select("t1.*, t2.avatar, t2.calendar_id, t3.content AS `name`")
					->join('pjEmployee', 't2.id=t1.employee_id AND t2.is_active=1', 'inner')
					->join('pjMultiLang', "t3.model='pjEmployee' AND t3.foreign_id=t1.employee_id AND t3.field='name' AND t3.locale='".$this->getLocaleId()."'", 'left outer')
					->where('t1.service_id', $id)
					->orderBy('`name` ASC')
					->findAll();
				
				$employee_arr = $pjEmployeeServiceModel->getData();
				$employee_ids = $pjEmployeeServiceModel->getDataPair(null, 'employee_id');
				$bs_arr = array();
				if (!empty($employee_ids))
				{
					$bs_arr = pjBookingServiceModel::factory()
						->join('pjBooking', "t1.booking_id=t2.id AND t2.booking_status='confirmed'", 'inner')
						->whereIn('t1.employee_id', $employee_ids)
						->where('t1.date', $date)
						->findAll()
						->getData();
				}
	
				foreach ($employee_arr as $k => $employee)
				{
					$employee_arr[$k]['t_arr'] = pjAppController::getRawSlotsPerEmployee($employee['employee_id'], $date, $employee['calendar_id']);
					$employee_arr[$k]['bs_arr'] = array();
					foreach ($bs_arr as $item)
					{
						if ($item['employee_id'] != $employee['employee_id'])
						{
							continue;
						}
						$employee_arr[$k]['bs_arr'][] = $item;
					}
				}
	
				$this
					->set('service_arr', pjServiceModel::factory()
						->select('t1.*, t2.content AS `name`')
						->join('pjMultiLang', "t2.model='pjService' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
						->find($id)
						->getData()
					)
					->set('employee_arr', $employee_arr);
			}
		}
	}
	
	public function pjActionIndex()
	{
		$this->checkLogin();
		
		if ($this->isAdmin())
		{
			$this->set('employee_arr', pjEmployeeModel::factory()
				->select('t1.*, t2.content AS `name`')
				->join('pjMultiLang', "t2.model='pjEmployee' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
				->orderBy('`name` ASC')
				->findAll()
				->getData()
			);
		
			$this->set('service_arr', pjServiceModel::factory()
				->select('t1.*, t2.content AS `name`')
				->join('pjMultiLang', "t2.model='pjService' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
				->orderBy('`name` ASC')
				->findAll()
				->getData()
			);
			
			$this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
			$this->appendJs('pjAdminBookings.js');
			$this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true);
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjActionList()
	{
		$this->checkLogin();
		
		if ($this->isEmployee())
		{
			$this->set('service_arr', pjServiceModel::factory()
				->select('t1.*, t2.content AS `name`')
				->join('pjMultiLang', "t2.model='pjService' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
				->orderBy('`name` ASC')
				->where(sprintf("t1.id IN (SELECT `service_id` FROM `%s` WHERE `employee_id` = '%u')", pjEmployeeServiceModel::factory()->getTable(), $this->getUserId()))
				->findAll()
				->getData()
			);

			$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
			$this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
			$this->appendJs('pjEmployeeBookings.js');
			$this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true);
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjActionSaveBooking()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			$pjBookingModel = pjBookingModel::factory();
			if (!in_array($_POST['column'], $pjBookingModel->getI18n()))
			{
				$pjBookingModel->set('id', $_GET['id'])->modify(array($_POST['column'] => $_POST['value']));
			} else {
				pjMultiLangModel::factory()->updateMultiLang(array($this->getLocaleId() => array($_POST['column'] => $_POST['value'])), $_GET['id'], 'pjBooking');
			}
		}
		exit;
	}
	
	public function pjActionUpdate()
	{
		$this->checkLogin();
		
		if ($this->isAdmin())
		{
			$pjBookingModel = pjBookingModel::factory();
			if (isset($_REQUEST['id']) && (int) $_REQUEST['id'] > 0)
			{
				$pjBookingModel->where('t1.id', $_REQUEST['id']);
			} elseif (isset($_GET['uuid']) && !empty($_GET['uuid'])) {
				$pjBookingModel->where('t1.uuid', $_GET['uuid']);
			}
			$arr = $pjBookingModel
				->limit(1)
				->findAll()
				->getData();
				
			if (empty($arr))
			{
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminBookings&action=pjActionIndex&err=ABK08");
			}
			$arr = $arr[0];
			
			if (isset($_POST['booking_update']))
			{
				$data = array();
				if ($_POST['payment_method'] != "creditcard")
				{
					$data['cc_type'] = ':NULL';
					$data['cc_num'] = ':NULL';
					$data['cc_code'] = ':NULL';
					$data['cc_exp_year'] = ':NULL';
					$data['cc_exp_month'] = ':NULL';
				}
				$arr = $pjBookingModel->find($_POST['id'])->getData();
				$pjInvoiceModel = pjInvoiceModel::factory();
				$_arr = $pjInvoiceModel->where('t1.order_id', $arr['uuid'])->limit(1)->findAll()->getData();
				$_arr = $_arr[0];
				$pjInvoiceModel->reset()->set('id', $_arr['id'])->modify(array('order_id'=>$_POST['uuid']));
								
				pjBookingModel::factory()->set('id', $_POST['id'])->modify(array_merge($_POST, $data));
				pjUtil::redirect(PJ_INSTALL_URL . "index.php?controller=pjAdminBookings&action=pjActionIndex&err=ABK01");
				
			} else {
				$this->set('arr', $arr)
					->set('country_arr', pjCountryModel::factory()
						->select('t1.*, t2.content AS `name`')
						->join('pjMultiLang', "t2.model='pjCountry' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
						->orderBy('`name` ASC')
						->findAll()->getData());
				
				$this->set('bi_arr', pjBookingServiceModel::factory()
					->select('t1.*, t2.content AS `title`')
					->join('pjMultiLang', sprintf("t2.model='pjService' AND t2.foreign_id=t1.service_id AND t2.field='name' AND t2.locale='%u'", $arr['locale_id']), 'left outer')
					->where('t1.booking_id', $arr['id'])
					->findAll()
					->getData()
				);
				
				$this
					->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/')
					->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/')
					->appendJs('pjAdminBookings.js')
					->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true)
				;
			}
		} else {
			$this->set('status', 2);
		}
	}
		
	public function pjActionViewBookingService()
	{
		$this->setAjax(true);
		
		if ($this->isXHR() && $this->isLoged())
		{
			if (isset($_GET['id']) && (int) $_GET['id'] > 0)
			{
				$arr = pjBookingServiceModel::factory()
					->select('t2.*, t1.*, t3.content AS `service_name`, t4.content AS `country_name`')
					->join('pjBooking', 't2.id=t1.booking_id', 'inner')
					->join('pjMultiLang', "t3.model='pjService' AND t3.foreign_id=t1.service_id AND t3.field='name' AND t3.locale='".$this->getLocaleId()."'", 'left outer')
					->join('pjMultiLang', "t4.model='pjCountry' AND t4.foreign_id=t2.c_country_id AND t4.field='name' AND t4.locale='".$this->getLocaleId()."'", 'left outer')
					->find($_GET['id'])
					->getData();
				
				$this->set('arr', $arr);
			}
		}
	}
	
	public function pjActionItemAdd()
	{
		$this->setAjax(true);
		
		if ($this->isXHR() && $this->isLoged())
		{
			$pjBookingServiceModel = pjBookingServiceModel::factory();
			
			if (isset($_POST['item_add']))
			{
				if (isset($_POST['service_id']) && (int) $_POST['service_id'] > 0)
				{
					$date = pjUtil::formatDate($_POST['date'], $this->option_arr['o_date_format']);
				
					$service_arr = pjServiceModel::factory()->find($_POST['service_id'])->getData();
					
					$bs_id = $pjBookingServiceModel->reset()->setAttributes(array(
						'tmp_hash' => @$_POST['tmp_hash'],
						'booking_id' => @$_POST['booking_id'],
						'service_id' => $_POST['service_id'],
						'employee_id' => $_POST['employee_id'],
						'date' => $date,
						'start' => date("H:i:s", $_POST['start_ts']),
						'start_ts' => $_POST['start_ts'],
						'total' => @$service_arr['duration'],
						'price' => @$service_arr['price']
					))->insert()->getInsertId();
					
					if ($bs_id !== FALSE && (int) $bs_id > 0)
					{
						pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Service has been added.'));
					}
					pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Service has not been added.'));
				}
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Service couldn\'t be empty.'));
			}
			
			$service_arr = pjServiceModel::factory()
				->select('t1.*, t2.content AS `name`')
				->join('pjMultiLang', "t2.model='pjService' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
				->findAll()->getData();
			
			$this->set('service_arr', $service_arr);
		}
	}
	
	public function pjActionItemDelete()
	{
		$this->setAjax(true);
		
		if ($this->isXHR() && $this->isLoged())
		{
			if (isset($_POST['id']) && (int) $_POST['id'] > 0)
			{
				$pjBookingServiceModel = pjBookingServiceModel::factory();
				$arr = $pjBookingServiceModel->find($_POST['id'])->getData();
				if (empty($arr))
				{
					pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 103, 'text' => 'Item not found.'));
				}
				if (1 == $pjBookingServiceModel->set('id', $_POST['id'])->erase()->getAffectedRows())
				{
					pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Item has been deleted.'));
				}
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 102, 'text' => 'Item has not been deleted.'));
			}
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'Missing parameters.'));
		}
		pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Access denied.'));
		exit;
	}
	
	public function pjActionItemGet()
	{
		$this->setAjax(true);
		
		if ($this->isXHR() && $this->isLoged())
		{
			$pjBookingServiceModel = pjBookingServiceModel::factory()
				->select("t1.*, t2.content AS `service`, t3.content AS `employee`")
				->join('pjMultiLang', "t2.model='pjService' AND t2.foreign_id=t1.service_id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'")
				->join('pjMultiLang', "t3.model='pjEmployee' AND t3.foreign_id=t1.employee_id AND t3.field='name' AND t3.locale='".$this->getLocaleId()."'");
			
			if (isset($_GET['booking_id']) && (int) $_GET['booking_id'] > 0)
			{
				$pjBookingServiceModel
					->join('pjBooking', 't4.id=t1.booking_id', 'inner')
					->where('t1.booking_id', $_GET['booking_id']);
			} elseif (isset($_GET['tmp_hash']) && !empty($_GET['tmp_hash'])) {
				$pjBookingServiceModel->where('t1.tmp_hash', $_GET['tmp_hash']);
			} else {
				$pjBookingServiceModel->where('t1.id', -999);
			}
			$bi_arr = $pjBookingServiceModel->findAll()->getData();
			
			$this->set('bi_arr', $bi_arr);
		}
	}

	public function pjActionItemEmail()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			if (isset($_POST['send_email']) && isset($_POST['to']) && !empty($_POST['to']) && !empty($_POST['from']) &&
				!empty($_POST['subject']) && !empty($_POST['message']) && !empty($_POST['id']))
			{
				$Email = new pjEmail();
				$Email->setContentType('text/html');
				if ($this->option_arr['o_send_email'] == 'smtp')
				{
					$Email
						->setTransport('smtp')
						->setSmtpHost($this->option_arr['o_smtp_host'])
						->setSmtpPort($this->option_arr['o_smtp_port'])
						->setSmtpUser($this->option_arr['o_smtp_user'])
						->setSmtpPass($this->option_arr['o_smtp_pass']);
				}
				
				$r = false;
				if (isset($_POST['message']) && !empty($_POST['message']))
				{
					$message = pjUtil::textToHtml($_POST['message']);
					foreach ($_POST['to'] as $recipient)
					{
						$r = $Email
							->setTo($recipient)
							->setFrom($_POST['from'])
							->setSubject($_POST['subject'])
							->send($message);
					}
				}
					
				if ($r)
				{
					pjBookingServiceModel::factory()->set('id', $_POST['id'])->modify(array('reminder_email' => 1));
					pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Email has been sent.'));
				}
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Email failed to send.'));
			}
			
			if (isset($_GET['id']) && (int) $_GET['id'] > 0)
			{
				$booking_arr = pjBookingServiceModel::factory()
					->select('t2.*, t1.*, t3.length, t3.before, t4.content AS `service_name`,
						t6.email AS `admin_email`, t7.content AS `country_name`, t8.email AS `employee_email`')
					->join('pjBooking', 't2.id=t1.booking_id', 'inner')
					->join('pjService', 't3.id=t1.service_id', 'inner')
					->join('pjMultiLang', "t4.model='pjService' AND t4.foreign_id=t1.service_id AND t4.field='name' AND t4.locale=t2.locale_id", 'left outer')
					->join('pjCalendar', 't5.id=t2.calendar_id', 'left outer')
					->join('pjUser', 't6.id=t5.user_id', 'left outer')
					->join('pjMultiLang', "t7.model='pjCountry' AND t7.foreign_id=t2.c_country_id AND t7.locale=t2.locale_id AND t7.field='name'", 'left outer')
					->join('pjEmployee', 't8.id=t1.employee_id', 'left outer')
					->find($_GET['id'])
					->getData();
				
				$tokens = pjAppController::getTokens($booking_arr, $this->option_arr);
				
				$subject_client = str_replace($tokens['search'], $tokens['replace'], $this->option_arr['o_reminder_subject']);
				$message_client = str_replace($tokens['search'], $tokens['replace'], $this->option_arr['o_reminder_body']);
				
				$this->set('arr', array(
					'id' => $_GET['id'],
					//'to' => $booking_arr['c_email'],
					'client_email' => $booking_arr['c_email'],
					'employee_email' => $booking_arr['employee_email'],
					'from' => !empty($booking_arr['admin_email']) ? $booking_arr['admin_email'] : $booking_arr['c_email'],
					'message' => $message_client,
					'subject' => $subject_client
				));
			} else {
				exit;
			}
		}
	}
	
	public function pjActionItemSms()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			if (isset($_POST['send_sms']) && isset($_POST['to']) && !empty($_POST['to']) && !empty($_POST['message']) && !empty($_POST['id']))
			{
				$params = array(
					'text' => $_POST['message'],
					'type' => 'unicode',
					'key' => md5($this->option_arr['private_key'] . PJ_SALT)
				);
				
				foreach ($_POST['to'] as $recipient)
				{
					$params['number'] = $recipient;
					$result = $this->requestAction(array('controller' => 'pjSms', 'action' => 'pjActionSend', 'params' => $params), array('return'));
				}

				if ((int) $result === 1)
				{
					pjBookingServiceModel::factory()->set('id', $_POST['id'])->modify(array('reminder_sms' => 1));
					pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'SMS has been sent.'));
				}
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'SMS failed to send.'));
			}
			
			if (isset($_GET['id']) && (int) $_GET['id'] > 0)
			{
				$booking_arr = pjBookingServiceModel::factory()
					->select('t2.*, t1.*, t3.before, t3.length, t4.content AS `service_name`,
						t6.email AS `admin_email`, t7.content AS `country_name`, t8.phone AS `employee_phone`')
					->join('pjBooking', 't2.id=t1.booking_id', 'inner')
					->join('pjService', 't3.id=t1.service_id', 'inner')
					->join('pjMultiLang', "t4.model='pjService' AND t4.foreign_id=t1.service_id AND t4.field='name' AND t4.locale=t2.locale_id", 'left outer')
					->join('pjCalendar', 't5.id=t2.calendar_id', 'left outer')
					->join('pjUser', 't6.id=t5.user_id', 'left outer')
					->join('pjMultiLang', "t7.model='pjCountry' AND t7.foreign_id=t2.c_country_id AND t7.locale=t2.locale_id AND t7.field='name'", 'left outer')
					->join('pjEmployee', 't8.id=t1.employee_id', 'left outer')
					->find($_GET['id'])
					->getData();
				
				$tokens = pjAppController::getTokens($booking_arr, $this->option_arr);
				
				$message_client = str_replace($tokens['search'], $tokens['replace'], $this->option_arr['o_reminder_sms_message']);
				
				$this->set('arr', array(
					'id' => $_GET['id'],
					//'to' => $booking_arr['c_phone'],
					'client_phone' => $booking_arr['c_phone'],
					'employee_phone' => $booking_arr['employee_phone'],
					'message' => $message_client
				));
			} else {
				exit;
			}
		}
	}
}
?>