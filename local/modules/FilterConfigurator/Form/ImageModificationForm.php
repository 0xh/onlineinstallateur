<?php

namespace FilterConfigurator\Form;

use Symfony\Component\Validator\Constraints\Image;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;
use Thelia\Form\StandardDescriptionFieldsTrait;


class ImageModificationForm extends BaseForm
{
	use StandardDescriptionFieldsTrait;
	
	/**
	 * @inheritdoc
	 */
	protected function buildForm()
	{
		$translator = Translator::getInstance();
		
		$this->formBuilder
		->add(
				'file',
				'file',
				[
						'required' => false,
						'constraints' => [
								new Image([
										//'minWidth' => 200,
										//'minHeight' => 200
								]),
						],
						'label' => $translator->trans('Replace current image by this file'),
						'label_attr' => [
								'for' => 'file',
						]
				]
				)
				// Is this image online ?
		->add(
				'visible',
				'checkbox',
				[
						'constraints' => [ ],
						'required'    => false,
						'label'       => $translator->trans('This image is online'),
						'label_attr' => [
								'for' => 'visible_create',
						]
				]
				)
				;
		
		// Add standard description fields
		$this->addStandardDescFields();
	}
}
