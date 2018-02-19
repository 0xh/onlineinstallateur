<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace HookKonfigurator\Form;

use HookKonfigurator\HookKonfigurator;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class PersonalData extends BaseForm
{
	private $formLabels ;
	
	public function getLabel($field,$choice = null){
		if($choice == null)
			return $this->formLabels[$field];
			else
				return $this->formLabels[$field.$choice];
	}
	
	private function setLabel($field,$choice,$label){
		Translator::getInstance()->trans($label);
		if($choice == null)
		{
			$this->formLabels[$field]= $label;
			return $this->formLabels[$field];
		}
		else {
			$this->formLabels[$field.$choice]= $label;
			return $this->formLabels[$field.$choice];
		}
	}
	
    protected function buildForm()
    {
         $formBuilder = $this->formBuilder
           
        ->add("firstname", "text", array(
        		
         		"label" => $this->setLabel("firstname",null,"Vorname"),
         		"label_attr" => array(
         				"for" => "firstname",
         		)
         ))
        ->add("lastname", "text", array(
         		"label" => $this->setLabel("lastname",null,"Nachname"),
         		"label_attr" => array(
         				"for" => "lastname",
         		)
         ))
        ->add("email", "text", array(
         		"label" => $this->setLabel("email",null,"Email"),
         		"label_attr" => array(
         				"for" => "email",
         		)
         ))
         ->add("phone", "text", array(
         		"label" => $this->setLabel("phone",null,"Telefon"),
         		"label_attr" => array(
         				"for" => "email",
         		)
         ))
        ->add("cellphone", "text", array(
         		"label" => $this->setLabel("cellphone",null,"Mobil"),
         		"label_attr" => array(
         				"for" => "cellphone",
         		)
         ))

        ->add("image_upload", "file", array(
		"label" => Translator::getInstance()->trans("upload"),
		"label_attr" => array(
                    "for" => "upload"
                )
            /*,
		"disabled" => true*/
		))         
		;
    }

    public function getName()
    {
        return "konfiguratorpersonaldata";
    }
}
