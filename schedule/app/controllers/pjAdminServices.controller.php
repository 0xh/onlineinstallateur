<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjAdminServices extends pjAdmin
{
	public function pjActionCreate()
	{
		$this->checkLogin();
		
		if ($this->isAdmin())
		{
			$post_max_size = pjUtil::getPostMaxSize();
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['CONTENT_LENGTH']) && (int) $_SERVER['CONTENT_LENGTH'] > $post_max_size)
			{
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminServices&action=pjActionIndex&err=AS12");
			}
			
			if (isset($_POST['service_create']))
			{
				$data = array();
				$err = 'AS03';
				$data['calendar_id'] = $this->getForeignId();
				$id = pjServiceModel::factory(array_merge($_POST, $data))->insert()->getInsertId();
				if ($id !== false && (int) $id > 0)
				{
					if (isset($_POST['employee_id']) && !empty($_POST['employee_id']))
					{
						$pjEmployeeServiceModel = pjEmployeeServiceModel::factory()->setBatchFields(array('employee_id', 'service_id'));
						foreach ($_POST['employee_id'] as $employee_id)
						{
							$pjEmployeeServiceModel->addBatchRow(array($employee_id, $id));
						}
						$pjEmployeeServiceModel->insertBatch();
					}
					
					if (isset($_FILES['image']))
					{
						if($_FILES['image']['error'] == 0)
						{
							$size = getimagesize($_FILES['image']['tmp_name']);
							if($size == true)
							{
								$pjImage = new pjImage();
								$pjImage->setAllowedExt($this->extensions)->setAllowedTypes($this->mimeTypes);
								if ($pjImage->load($_FILES['image']))
								{
									$dst = PJ_UPLOAD_PATH . 'services/' . md5($id . PJ_SALT) . ".jpg";
									$pjImage
										->loadImage()
										->resizeSmart(150, 170)
										->saveImage($dst);
					
									pjServiceModel::factory()->set('id', $id)->modify(array('image' => $dst));
								}
							}else{
								$err = 'AS14';
							}
						}else if($_FILES['image']['error'] != 4){
							$err = 'AS13';
						}
					}
					
					if (isset($_POST['i18n']))
					{
						pjMultiLangModel::factory()->saveMultiLang($_POST['i18n'], $id, 'pjService');
					}
				} else {
					$err = 'AS04';
				}
				if($err == 'AS03' || $err == 'AS04')
				{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminServices&action=pjActionIndex&err=$err");
				}else{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminServices&action=pjActionUpdate&id=$id&err=$err");
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
				
				$this->set('employee_arr', pjEmployeeModel::factory()
					->select('t1.*, t2.content AS `name`')
					->join('pjMultiLang', "t2.model='pjEmployee' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
					->orderBy('`name` ASC')
					->findAll()
					->getData()
				);
				
				$this->appendJs('jquery.multiselect.min.js', PJ_THIRD_PARTY_PATH . 'multiselect/');
				$this->appendCss('jquery.multiselect.css', PJ_THIRD_PARTY_PATH . 'multiselect/');
				
				$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
				$this->appendJs('additional-methods.js', PJ_THIRD_PARTY_PATH . 'validate/');
				if ((int) $this->option_arr['o_multi_lang'] === 1)
				{
					$this->set('locale_str', pjAppController::jsonEncode($lp_arr));
					$this->appendJs('jquery.multilang.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
				}
				$this->appendJs('jquery.tipsy.js', PJ_THIRD_PARTY_PATH . 'tipsy/');
				$this->appendCss('jquery.tipsy.css', PJ_THIRD_PARTY_PATH . 'tipsy/');
				$this->appendJs('pjAdminServices.js');
			}
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjActionDeleteService()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			if (isset($_GET['id']) && (int) $_GET['id'] > 0 && pjServiceModel::factory()->set('id', $_GET['id'])->erase()->getAffectedRows() == 1)
			{
				pjMultiLangModel::factory()->where('model', 'pjService')->where('foreign_id', $_GET['id'])->eraseAll();
				pjEmployeeServiceModel::factory()->where('service_id', $_GET['id'])->eraseAll();
				pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => ''));
			}
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => ''));
		}
		exit;
	}
	
	public function pjActionDeleteServiceBulk()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			if (isset($_POST['record']) && !empty($_POST['record']))
			{
				pjServiceModel::factory()->whereIn('id', $_POST['record'])->eraseAll();
				pjMultiLangModel::factory()->where('model', 'pjService')->whereIn('foreign_id', $_POST['record'])->eraseAll();
				pjEmployeeServiceModel::factory()->whereIn('service_id',$_POST['record'])->eraseAll();
				pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => ''));
			}
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => ''));
		}
		exit;
	}
	
	public function pjActionGetService()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			$pjServiceModel = pjServiceModel::factory()
				->join('pjMultiLang', "t2.model='pjService' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
				->join('pjMultiLang', "t3.model='pjService' AND t3.foreign_id=t1.id AND t3.field='description' AND t3.locale='".$this->getLocaleId()."'", 'left outer')
				->where('t1.calendar_id', $this->getForeignId());
			
			if (isset($_GET['q']) && !empty($_GET['q']))
			{
				$q = str_replace(array('_', '%'), array('\_', '\%'), trim($_GET['q']));
				$pjServiceModel->where('t2.content LIKE', "%$q%");
				$pjServiceModel->orWhere('t3.content LIKE', "%$q%");
			}

			if (isset($_GET['is_active']) && strlen($_GET['is_active']) > 0 && in_array($_GET['is_active'], array(1, 0)))
			{
				//$pjServiceModel->where('t1.is_active', $_GET['is_active']);
			}

			$column = 'name';
			$direction = 'ASC';
			if (isset($_GET['direction']) && isset($_GET['column']) && in_array(strtoupper($_GET['direction']), array('ASC', 'DESC')))
			{
				$column = $_GET['column'];
				$direction = strtoupper($_GET['direction']);
			}

			$total = $pjServiceModel->findCount()->getData();
			$rowCount = isset($_GET['rowCount']) && (int) $_GET['rowCount'] > 0 ? (int) $_GET['rowCount'] : 10;
			$pages = ceil($total / $rowCount);
			$page = isset($_GET['page']) && (int) $_GET['page'] > 0 ? intval($_GET['page']) : 1;
			$offset = ((int) $page - 1) * $rowCount;
			if ($page > $pages)
			{
				$page = $pages;
			}

			$data = $pjServiceModel
				->select(sprintf("t1.*, t2.content AS `name`,
					(SELECT COUNT(es.id)
						FROM `%1\$s` AS `es`
						INNER JOIN `%2\$s` AS `e` ON `e`.`id` = `es`.`employee_id`
						WHERE `es`.`service_id` = `t1`.`id` 
						LIMIT 1) AS `employees`
					", pjEmployeeServiceModel::factory()->getTable(), pjEmployeeModel::factory()->getTable()))
				->orderBy("$column $direction")->limit($rowCount, $offset)->findAll()->getData();
				//AND `e`.`is_active`='1'
			foreach ($data as $k => $v)
			{
				if(array_key_exists('price',$v))
				$data[$k]['price_format'] = pjUtil::formatCurrencySign(number_format($v['price'], 2), $this->option_arr['o_currency']);
			}
				
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
			$this->appendJs('pjAdminServices.js');
			$this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true);
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjActionSaveService()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			$pjServiceModel = pjServiceModel::factory();
			if (!in_array($_POST['column'], $pjServiceModel->getI18n()))
			{
				$pjServiceModel->set('id', $_GET['id'])->modify(array($_POST['column'] => $_POST['value']));
			} else {
				pjMultiLangModel::factory()->updateMultiLang(array($this->getLocaleId() => array($_POST['column'] => $_POST['value'])), $_GET['id'], 'pjService', 'data');
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
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminServices&action=pjActionIndex&err=AS15");
			}
				
			if (isset($_POST['service_update']) && isset($_POST['id']) && (int) $_POST['id'] > 0)
			{
				$err = 'AS01';
				$data = array();
				
				if (isset($_FILES['image']))
				{
					if($_FILES['image']['error'] == 0)
					{
						$size = getimagesize($_FILES['image']['tmp_name']);
				
						if($size == true)
						{
							$pjServiceModel = pjServiceModel::factory();
							$arr = $pjServiceModel->find($_POST['id'])->getData();
							if (!empty($arr))
							{
								@clearstatcache();
								if (!empty($arr['image']) && is_file($arr['image']))
								{
									@unlink($arr['image']);
								}
							}
							
							$pjImage = new pjImage();
							$pjImage->setAllowedExt($this->extensions)->setAllowedTypes($this->mimeTypes);
							if ($pjImage->load($_FILES['image']))
							{
								$data['image'] = PJ_UPLOAD_PATH . 'services/' . md5($_POST['id'] . PJ_SALT) . ".jpg";
								$pjImage
									->loadImage()
									->resizeSmart(150, 170)
									->saveImage($data['image']);
							}
						}else{
							$err = 'AS17';
						}
					}else if($_FILES['image']['error'] != 4){
						$err = 'AS16';
					}
				}
				
				pjServiceModel::factory()->set('id', $_POST['id'])->modify(array_merge($_POST, $data));
				if (isset($_POST['i18n']))
				{
					pjMultiLangModel::factory()->updateMultiLang($_POST['i18n'], $_POST['id'], 'pjService', 'data');
				}
				
				$pjEmployeeServiceModel = pjEmployeeServiceModel::factory();
				$pjEmployeeServiceModel->where('service_id', $_POST['id'])->eraseAll();
				if (isset($_POST['employee_id']) && !empty($_POST['employee_id']))
				{
					$pjEmployeeServiceModel->reset()->setBatchFields(array('employee_id', 'service_id'));
					foreach ($_POST['employee_id'] as $employee_id)
					{
						$pjEmployeeServiceModel->addBatchRow(array($employee_id, $_POST['id']));
					}
					$pjEmployeeServiceModel->insertBatch();
				}
				
				if($err == 'AS01')
				{
					pjUtil::redirect(PJ_INSTALL_URL . "index.php?controller=pjAdminServices&action=pjActionIndex&err=AS01");
				}else{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminServices&action=pjActionUpdate&id=".$_POST['id']."&err=$err");
				}
				
			} else {
				$arr = pjServiceModel::factory()->find($_GET['id'])->getData();
				if (empty($arr))
				{
					pjUtil::redirect(PJ_INSTALL_URL. "index.php?controller=pjAdminServices&action=pjActionIndex&err=AS08");
				}
				$arr['i18n'] = pjMultiLangModel::factory()->getMultiLang($arr['id'], 'pjService');
				$this->set('arr', $arr);
				
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
				
				$this->set('employee_arr', pjEmployeeModel::factory()
					->select('t1.*, t2.content AS `name`')
					->join('pjMultiLang', "t2.model='pjEmployee' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
					->orderBy('`name` ASC')
					->findAll()
					->getData()
				);
				$this->set('es_arr', pjEmployeeServiceModel::factory()->where('t1.service_id', $arr['id'])->findAll()->getDataPair(null, 'employee_id'));
				
				$this->appendJs('jquery.multiselect.min.js', PJ_THIRD_PARTY_PATH . 'multiselect/');
				$this->appendCss('jquery.multiselect.css', PJ_THIRD_PARTY_PATH . 'multiselect/');
				
				$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
				$this->appendJs('additional-methods.js', PJ_THIRD_PARTY_PATH . 'validate/');
				if ((int) $this->option_arr['o_multi_lang'] === 1)
				{
					$this->set('locale_str', pjAppController::jsonEncode($lp_arr));
					$this->appendJs('jquery.multilang.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
				}
				$this->appendJs('jquery.tipsy.js', PJ_THIRD_PARTY_PATH . 'tipsy/');
				$this->appendCss('jquery.tipsy.css', PJ_THIRD_PARTY_PATH . 'tipsy/');
				$this->appendJs('pjAdminServices.js');
				$this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true);
			}
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjActionDeleteImage()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			$id = NULL;
			$id = $_POST['id'];
				
			if (!is_null($id))
			{
				$pjServiceModel = pjServiceModel::factory();
				$arr = $pjServiceModel->find($id)->getData();
				if (!empty($arr))
				{
					$pjServiceModel->modify(array('image' => ':NULL'));
						
					@clearstatcache();
					if (!empty($arr['image']) && is_file($arr['image']))
					{
						@unlink($arr['image']);
					}
						
					pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => ''));
				}
			}
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => ''));
		}
		exit;
	}
}
?>