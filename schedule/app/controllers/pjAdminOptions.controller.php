<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjAdminOptions extends pjAdmin
{
	public function pjActionIndex()
	{
		$this->checkLogin();

		if ($this->isAdmin())
		{
			if (isset($_GET['tab']) && in_array((int) $_GET['tab'], array(5,6)))
			{
				$locale_arr = pjLocaleModel::factory()->select('t1.*, t2.file')
					->join('pjLocaleLanguage', 't2.iso=t1.language_iso', 'left')
					->where('t2.file IS NOT NULL')
					->orderBy('t1.sort ASC')->findAll()->getData();
						
				$lp_arr = array();
				foreach ($locale_arr as $v)
				{
					$lp_arr[$v['id']."_"] = $v['file']; //Hack for jquery $.extend, to prevent (re)order of numeric keys in object
				}
				$this->set('lp_arr', $locale_arr);
				
				$arr = array();
				$arr['i18n'] = pjMultiLangModel::factory()->getMultiLang($this->getForeignId(), 'pjCalendar');
				$this->set('arr', $arr);
				
				if ((int) $this->option_arr['o_multi_lang'] === 1)
				{
					$this->set('locale_str', pjAppController::jsonEncode($lp_arr));
					$this->appendJs('jquery.multilang.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
				}
			} else {
				$tab_id = isset($_GET['tab']) && (int) $_GET['tab'] > 0 ? (int) $_GET['tab'] : 1;
				$arr = pjOptionModel::factory()
					->where('foreign_id', $this->getForeignId())
					->where('tab_id', $tab_id)
					->orderBy('t1.order ASC')
					->findAll()
					->getData();
				$this->set('arr', $arr);
				
				$tmp = $this->models['Option']->reset()->where('foreign_id', $this->getForeignId())->findAll()->getData();
				$o_arr = array();
				foreach ($tmp as $item)
				{
					$o_arr[$item['key']] = $item;
				}
				$this->set('o_arr', $o_arr);
			}
			$this->appendJs('jquery.tipsy.js', PJ_THIRD_PARTY_PATH . 'tipsy/');
			$this->appendCss('jquery.tipsy.css', PJ_THIRD_PARTY_PATH . 'tipsy/');
			$this->appendJs('tinymce.min.js', PJ_THIRD_PARTY_PATH . 'tiny_mce_4.1.1/');
			$this->appendJs('pjAdminOptions.js');
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjActionInstall()
	{
		$this->checkLogin();
		
		if ($this->isAdmin())
		{
			$o_arr = $this->models['Option']
				->where('t1.foreign_id', $this->getForeignId())
				->where('`key`', 'o_theme')
				->orderBy('t1.key ASC')
				->findAll()
				->getData();
			$this->set('theme_arr', $o_arr[0]);
			$o_arr = $this->models['Option']
				->reset()
				->where('t1.foreign_id', $this->getForeignId())
				->where('`key`', 'o_layout')
				->orderBy('t1.key ASC')
				->findAll()
				->getData();
			$this->set('layout_arr', $o_arr[0]);
					
			$this->appendJs('pjAdminOptions.js');
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjActionPreview()
	{
		$this->checkLogin();
		
		if ($this->isAdmin())
		{
			$this->appendJs('pjAdminOptions.js');
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjActionUpdateTheme()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			pjOptionModel::factory()
			->where('foreign_id', $this->getForeignId())
			->where('`key`', 'o_theme')
			->limit(1)
			->modifyAll(array('value' => 'theme1|theme2|theme3|theme4|theme5|theme6|theme7|theme8|theme9|theme10::theme' . $_GET['theme']));
	
		}
	}
	
	public function pjActionUpdate()
	{
		$this->checkLogin();

		if ($this->isAdmin())
		{
			if (isset($_POST['options_update']))
			{
				if (isset($_POST['tab']) && in_array($_POST['tab'], array(5, 6)))
				{
					if (isset($_POST['i18n']))
					{
						pjMultiLangModel::factory()->updateMultiLang($_POST['i18n'], $this->getForeignId(), 'pjCalendar', 'data');
					}
				} else {
					$OptionModel = new pjOptionModel();
					$OptionModel
						->where('foreign_id', $this->getForeignId())
						->where('type', 'bool')
						->where('tab_id', $_POST['tab'])
						->modifyAll(array('value' => '1|0::0'));
						
					foreach ($_POST as $key => $value)
					{
						if (preg_match('/value-(string|text|int|float|enum|bool|color)-(.*)/', $key) === 1)
						{
							list(, $type, $k) = explode("-", $key);
							if (!empty($k))
							{
								$OptionModel
									->reset()
									->where('foreign_id', $this->getForeignId())
									->where('`key`', $k)
									->limit(1)
									->modifyAll(array('value' => $value));
							}
						}
					}
				}
				if (isset($_POST['tab']))
				{
					switch ($_POST['tab'])
					{
						case '1':
							$err = 'AO01';
							break;
						case '2':
							$err = 'AO02';
							break;
						case '3':
							$err = 'AO03';
							break;
						case '4':
							$err = 'AO04';
							break;
						case '5':
							$err = 'AO05';
							break;
						case '6':
							$err = 'AO06';
							break;
						case '7':
							$err = 'AO07';
							break;
						case '8':
							$err = 'AO08';
							break;
					}
				}
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminOptions&action=" . @$_POST['next_action'] . "&tab=" . @$_POST['tab'] . "&err=$err");
			}
		} else {
			$this->set('status', 2);
		}
	}
}
?>