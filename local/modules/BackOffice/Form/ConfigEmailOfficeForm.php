<?php

namespace BackOffice\Form;

use Symfony\Component\Validator\Constraints;
use Thelia\Form\AttributeAvCreationForm;
use Thelia\Core\Translation\Translator;

class ConfigEmailOfficeForm extends AttributeAvCreationForm
{
	protected function buildForm()
	{	
		$this->formBuilder->add(
				'office_email',
				'email',
				[
						'constraints' => [ ],
						'required'    => true,
						'label'       => Translator::getInstance()->trans('Office email address'),
						'label_attr'  => [
								'for'         => 'summary_field',
								'help'        => Translator::getInstance()->trans('This is the office email address, the failed orders will be sent here.'),
						],
						'attr' => [
								'rows'        => 3,
								'placeholder' => Translator::getInstance()->trans('email for failed orders'),
						]
				]
				);		
		
	}
	
	public function getName()
	{
		return "email_office_form";
	}
}
