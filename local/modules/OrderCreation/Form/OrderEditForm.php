<?php

namespace OrderCreation\Form;

use OrderCreation\OrderCreation;
use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class OrderEditForm extends BaseForm
{
	
    protected function buildForm()
    {
    	$this->formBuilder
	    	->add("order_id", "integer", array(
	    			"constraints" => array(
	    					new NotBlank()
	    			),
	    			"required" => true,
	    	))
	    	->add("order_product_id", "integer", array(
	    			"constraints" => array(
	    					new NotBlank()
	    			),
	    			"required" => true,
	    	))
	    	->add("product_title", "text", array(
	    			"constraints" => array(
	    					new NotBlank()
	    			),
	    			"label" => Translator::getInstance()->trans("Title"),
	    			"label_attr" => array(
	    					"for" => "product_title",
	    			),
	    	))
	    	->add("product_quantity", "text", array(
	    			"constraints" => array(
	    					new NotBlank()
	    			),
	    			"label" => Translator::getInstance()->trans("Quantity - available quantity "),
	    			"label_attr" => array(
	    					"for" => "product_quantity",
	    			),
	    	))
	    	->add("product_price", "text", array(
	    			"constraints" => array(
	    					new NotBlank()
	    			),
	    			"label" => Translator::getInstance()->trans("Price (e.g. price format 1234.21)"),
	    			"label_attr" => array(
	    					"for" => "product_price",
	    			),
	    	));
    }

    /**
     * @return string the name of you form. This name must be unique
     */
    public function getName()
    {
        //This name MUST be the same that the form OrderDelivery (because of ajax delivery module return)
        return "admin_order_edit";
    }
}
