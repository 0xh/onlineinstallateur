<?php

namespace AmazonIntegration\Form;

use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;
use AmazonIntegration\AmazonIntegration;

class GetRankingsForm extends BaseForm
{
	
	protected function buildForm()
	{
		$this->formBuilder
			->add("reference", "text", array(
					'label'=>Translator::getInstance()->trans("Insert product EAN CODE separated by space", array(), AmazonIntegration::DOMAIN_NAME),
					'label_attr'=>array("for"=>"reference")
			));
	}
	
	public function getName()
	{
		return "amazonintegrationrankingsform";
	}
}
