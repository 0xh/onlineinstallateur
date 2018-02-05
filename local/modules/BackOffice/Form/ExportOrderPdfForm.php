<?php
namespace BackOffice\Form;

use BackOffice\BackOffice;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class ExportOrderPdfForm extends BaseForm
{

    protected function buildForm()
    {  
        
        $this->formBuilder
	        ->add("datepickerCreatedAfter", "text", array(
	        	'label'=>Translator::getInstance()->trans("Created after", array(), BackOffice::DOMAIN_NAME),
	        	'label_attr'=>array("for"=>"datepickerCreatedAfter")
	        ))
            ->add("datepickerCreatedBefore", "text", array(
                'label'=>Translator::getInstance()->trans("Created before", array(), BackOffice::DOMAIN_NAME),
                'label_attr'=>array("for"=>"datepickerCreatedBefore")
            ));
    }
    
    public function getName()
    {
        return "exportorderpdf";
    }
}
