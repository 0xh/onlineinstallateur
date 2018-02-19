<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjAdminTime extends pjAdmin
{
	private $types = array('calendar', 'employee');
	
	public function pjActionIndex()
	{
		$this->checkLogin();

		if ($this->isAdmin() || $this->isEmployee())
		{
			if (isset($_POST['working_time']))
			{
				$data = array();
				$weekDays = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
				foreach ($weekDays as $day)
				{
					if (!isset($_POST[$day . '_dayoff']))
					{
						$data[$day . '_from'] = date('H:i', strtotime($_POST[$day . '_from']));
						$data[$day . '_to'] = date('H:i', strtotime($_POST[$day . '_to']));
						$data[$day . '_lunch_from'] = date('H:i', strtotime($_POST[$day . '_lunch_from']));
						$data[$day . '_lunch_to'] = date('H:i', strtotime($_POST[$day . '_lunch_to']));
						$data[$day . '_dayoff'] = "F";
					} else {
						$data[$day . '_from'] = ":NULL";
						$data[$day . '_to'] = ":NULL";
						$data[$day . '_lunch_from'] = ":NULL";
						$data[$day . '_lunch_to'] = ":NULL";
						$data[$day . '_dayoff'] = "T";
					}
				}

				if ($this->isEmployee())
				{
					pjWorkingTimeModel::factory()
						->where('foreign_id', $this->getUserId())
						->where('type', 'employee')
						->limit(1)
						->modifyAll(array_merge($_POST, $data));
				} else {
					if (isset($_POST['update_all']))
					{
						pjWorkingTimeModel::factory()
							->where('id', $_POST['id'])
							->orWhere('type', 'employee')
							->modifyAll($data);
					} else {
						pjWorkingTimeModel::factory()
							->set('id', $_POST['id'])
							->modify($data);
					}
				}

				if (isset($_POST['foreign_id']) && (int) $_POST['foreign_id'] > 0 && isset($_POST['type']) && in_array($_POST['type'], $this->types))
				{
					pjUtil::redirect(sprintf("%sindex.php?controller=pjAdminTime&action=pjActionIndex&type=%s&foreign_id=%u&err=AT01",
						PJ_INSTALL_URL, $_POST['type'], $_POST['foreign_id']));
				}
					
				pjUtil::redirect(sprintf("%sindex.php?controller=pjAdminTime&action=pjActionIndex&err=AT01", PJ_INSTALL_URL));
			}
			
			if ($this->isAdmin())
			{
				$foreign_id = $this->getForeignId();
				$type = 'calendar';
				if (isset($_GET['foreign_id']) && (int) $_GET['foreign_id'] > 0)
				{
					$foreign_id = (int) $_GET['foreign_id'];
				}
				if (isset($_GET['type']) && in_array($_GET['type'], $this->types))
				{
					$type = $_GET['type'];
				}
			} elseif ($this->isEmployee()) {
				$foreign_id = $this->getUserId();
				$type = 'employee';
			}
			
			$wt_arr = pjWorkingTimeModel::factory()
				->where('t1.foreign_id', $foreign_id)
				->where('t1.type', $type)
				->limit(1)
				->findAll()
				->getData();
			
			$this->set('wt_arr', !empty($wt_arr) ? $wt_arr[0] : array());
			$this->appendCss('jquery.ui.timepicker.css', PJ_THIRD_PARTY_PATH . 'timepicker/');
			$this->appendJs('jquery.ui.timepicker.js', PJ_THIRD_PARTY_PATH . 'timepicker/');
			$this->appendJs('pjAdminTime.js');
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjActionCustom()
	{
		$this->checkLogin();

		if ($this->isAdmin() || $this->isEmployee())
		{
			if (isset($_POST['custom_time']))
			{
				if ($this->isAdmin())
				{
					$foreign_id = $this->getForeignId();
					$type = 'calendar';
					if (isset($_POST['foreign_id']) && (int) $_POST['foreign_id'] > 0)
					{
						$foreign_id = (int) $_POST['foreign_id'];
					}
					if (isset($_POST['type']) && in_array($_POST['type'], $this->types))
					{
						$type = $_POST['type'];
					}
				} elseif ($this->isEmployee()) {
					$foreign_id = $this->getUserId();
					$type = 'employee';
				}
				
				$pjDateModel = pjDateModel::factory();
				$date = pjUtil::formatDate($_POST['date'], $this->option_arr['o_date_format']);
				$pjDateModel
					->where('foreign_id', $foreign_id)
					->where('`type`', $type)
					->where('`date`', $date)
					->limit(1)
					->eraseAll();
				
				$data = array();
				$data['foreign_id'] = $foreign_id;
				$data['type'] = $type;
				$data['start_time'] = !empty($_POST['start']) ? date('H:i', strtotime($_POST['start'])) : '00:00';
				$data['end_time'] = !empty($_POST['end']) ? date('H:i', strtotime($_POST['end'])) : '00:00';
				$data['start_lunch'] = !empty($_POST['start_lunch']) ? date('H:i', strtotime($_POST['start_lunch'])) : '00:00';
				$data['end_lunch'] = !empty($_POST['end_lunch']) ? date('H:i', strtotime($_POST['end_lunch'])) : '00:00';
				$data['date'] = $date;
				
				$pjDateModel->reset()->setAttributes(array_merge($_POST, $data))->insert();
				
				if (isset($_POST['foreign_id']) && (int) $_POST['foreign_id'] > 0 && isset($_POST['type']) && in_array($_POST['type'], $this->types))
				{
					pjUtil::redirect(sprintf("%sindex.php?controller=pjAdminTime&action=pjActionCustom&type=%s&foreign_id=%u&err=AT02",
						PJ_INSTALL_URL, $_POST['type'], $_POST['foreign_id']));
				}
				
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminTime&action=pjActionCustom&err=AT02");
			}

			$this->appendCss('jquery.ui.timepicker.css', PJ_THIRD_PARTY_PATH . 'timepicker/');
			$this->appendJs('jquery.ui.timepicker.js', PJ_THIRD_PARTY_PATH . 'timepicker/');
			$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
			$this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
			$this->appendJs('pjAdminTime.js');
			$this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true);
			
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjActionDeleteDate()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			if (isset($_GET['id']) && (int) $_GET['id'] > 0 && pjDateModel::factory()->set('id', $_GET['id'])->erase()->getAffectedRows() == 1)
			{
				pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => ''));
			}
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => ''));
		}
		exit;
	}
	
	public function pjActionDeleteDateBulk()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			if (isset($_POST['record']) && !empty($_POST['record']))
			{
				pjDateModel::factory()->whereIn('id', $_POST['record'])->eraseAll();
				pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => ''));
			}
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => ''));
		}
		exit;
	}
	
	public function pjActionGetDate()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			$pjDateModel = pjDateModel::factory();
				
			if ($this->isAdmin())
			{
				$foreign_id = $this->getForeignId();
				$type = 'calendar';
				if (isset($_GET['foreign_id']) && (int) $_GET['foreign_id'] > 0)
				{
					$foreign_id = (int) $_GET['foreign_id'];
				}
				if (isset($_GET['type']) && in_array($_GET['type'], $this->types))
				{
					$type = $_GET['type'];
				}
			} elseif ($this->isEmployee()) {
				$foreign_id = $this->getUserId();
				$type = 'employee';
			}
			
			$pjDateModel
				->where('t1.foreign_id', $foreign_id)
				->where('t1.type', $type);
			
			if (isset($_GET['is_dayoff']) && strlen($_GET['is_dayoff']) > 0 && in_array($_GET['is_dayoff'], array('T', 'F')))
			{
				$pjDateModel->where('t1.is_dayoff', $_GET['is_dayoff']);
			}
				
			$column = 'date';
			$direction = 'ASC';
			if (isset($_GET['direction']) && isset($_GET['column']) && in_array(strtoupper($_GET['direction']), array('ASC', 'DESC')))
			{
				$column = $_GET['column'];
				$direction = strtoupper($_GET['direction']);
			}

			$total = $pjDateModel->findCount()->getData();
			$rowCount = isset($_GET['rowCount']) && (int) $_GET['rowCount'] > 0 ? (int) $_GET['rowCount'] : 10;
			$pages = ceil($total / $rowCount);
			$page = isset($_GET['page']) && (int) $_GET['page'] > 0 ? intval($_GET['page']) : 1;
			$offset = ((int) $page - 1) * $rowCount;
			if ($page > $pages)
			{
				$page = $pages;
			}

			$data = $pjDateModel
				->orderBy("$column $direction")->limit($rowCount, $offset)->findAll()->getData();
			foreach($data as $k => $v)
			{
				$v['start_time'] = date($this->option_arr['o_time_format'], strtotime($v['date'] . ' ' . $v['start_time']));
				$v['end_time'] = date($this->option_arr['o_time_format'], strtotime($v['date'] . ' ' . $v['end_time']));
				$v['start_lunch'] = date($this->option_arr['o_time_format'], strtotime($v['date'] . ' ' . $v['start_lunch']));
				$v['end_lunch'] = date($this->option_arr['o_time_format'], strtotime($v['date'] . ' ' . $v['end_lunch']));
				$data[$k] = $v;
			}	
			pjAppController::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
		}
		exit;
	}
	
	public function pjActionSaveDate()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			$pjDateModel = pjDateModel::factory();
			if (!in_array($_POST['column'], $pjDateModel->getI18n()))
			{
				$pjDateModel->set('id', $_GET['id'])->modify(array($_POST['column'] => $_POST['value']));
			} else {
				pjMultiLangModel::factory()->updateMultiLang(array($this->getLocaleId() => array($_POST['column'] => $_POST['value'])), $_GET['id'], 'pjDate');
			}
		}
		exit;
	}
	
	public function pjActionUpdateCustom()
	{
		$this->checkLogin();

		if ($this->isAdmin() || $this->isEmployee())
		{
			if (isset($_POST['custom_time']))
			{
				$data = array();
				$data['date'] = pjUtil::formatDate($_POST['date'], $this->option_arr['o_date_format']);
				$data['start_time'] = !empty($_POST['start']) ? date('H:i', strtotime($_POST['start'])) : '00:00';
				$data['end_time'] = !empty($_POST['end']) ? date('H:i', strtotime($_POST['end'])) : '00:00';
				$data['start_lunch'] = !empty($_POST['start_lunch']) ? date('H:i', strtotime($_POST['start_lunch'])) : '00:00';
				$data['end_lunch'] = !empty($_POST['end_lunch']) ? date('H:i', strtotime($_POST['end_lunch'])) : '00:00';
				$data['is_dayoff'] = isset($_POST['is_dayoff']) ? 'T' : 'F';
				
				pjDateModel::factory()->set('id', $_POST['id'])->modify($data);
				
				if (isset($_POST['foreign_id']) && (int) $_POST['foreign_id'] > 0 && isset($_POST['type']) && in_array($_POST['type'], $this->types))
				{
					pjUtil::redirect(sprintf("%sindex.php?controller=pjAdminTime&action=pjActionCustom&type=%s&foreign_id=%u&err=AT03",
						PJ_INSTALL_URL, $_POST['type'], $_POST['foreign_id']));
				}
				
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminTime&action=pjActionCustom&err=AT03");
			}
			
			$this->set('arr', pjDateModel::factory()->find($_GET['id'])->getData());
			
			$this->appendCss('jquery.ui.timepicker.css', PJ_THIRD_PARTY_PATH . 'timepicker/');
			$this->appendJs('jquery.ui.timepicker.js', PJ_THIRD_PARTY_PATH . 'timepicker/');
			$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
			$this->appendJs('pjAdminTime.js');
		} else {
			$this->set('status', 2);
		}
	}
}
?>