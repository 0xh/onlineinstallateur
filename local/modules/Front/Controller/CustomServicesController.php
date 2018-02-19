<?php

namespace Front\Controller;

use Thelia\Controller\Front\BaseFrontController;
use HookCustomServices\Form\CustomServices;
use Thelia\Log\Tlog;
use Thelia\Model\ConfigQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\FileBag;
/**
 * Class ContactController
 * @package Thelia\Controller\Front
 * @author Manuel Raynaud <manu@raynaud.io>
 */
class CustomServicesController extends BaseFrontController
{
    /**
     * send contact message
     */
    public function sendAction()
    {
        $log = Tlog::getInstance();
        $contactForm = $this->createForm("custom.services");
        $form = $this->validateForm($contactForm);
        
        $subject = "Individuelle Services Anfrage";
        $emailTest = "angebote@hausfabrik.at";
        $project_art = $this->getRequest()->get('customservices')['projekt-art'];
        $marke =  $this->getRequest()->get('customservices')['marke'];
        $oel_gas =  $this->getRequest()->get('customservices')['oel-gas'];
        $arbeit_art =  $this->getRequest()->get('customservices')['arbeit-art'];
        $zugaenglichkeit =  $this->getRequest()->get('customservices')['zugaenglichkeit'];
        $zeit =  $this->getRequest()->get('customservices')['zeit'];
        $anmerkungen =  $this->getRequest()->get('customservices')['anmerkungen'];
        
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        
     //   $image_upload =  $this->getRequest()->get('customservices')['image_upload'];
        // $image_upload = new UploadedFile();
       //  $image_upload->getClientOriginalName()
        // $image_upload->
        $files = new FileBag();
        $files = $this->getRequest()->files;
        
       // $image_upload_name = implode(" ",$files->keys());
        //$image_upload = new UploadedFile();
        $image_upload = $files->get("customservices")["image_upload"];
        //$image_upload->move($directory)
        $new_image_path = THELIA_ROOT .ConfigQuery::read('images_library_path')."/imani";
        if($image_upload != null){
        $new_image_name = $image_upload->getClientOriginalName();
        $image_upload->move($new_image_path ,$new_image_name);
        $image_full_path = $new_image_path."/".$new_image_name;
        }else {
        	$image_upload = "no_image";
        	$image_full_path = "no_image";
        }
        $message = "Welche Art von Projekt haben Sie?:".$project_art."<br>Welche Marke und / oder Modell?:".$marke."<br>Ist Ihr System von Öl oder Gas?".$oel_gas."<br>Welche Art von Arbeit brauchen Sie?".$arbeit_art."<br>Ist Ihr Gerät gut zugänglich?".$zugaenglichkeit."<br>Wann benötigen Sie den Service?".$zeit."<br>Anmerkungen?".$anmerkungen."<br>Bilder<img src=".$image_upload.">";
        
        
        
$log->error(sprintf('message : %s', $message));
            $htmlMessage = "<p>$message</p>";
$storeName="Hausfabrik";
$contactEmail="angebote@hausfabrik.at";
            $instance = \Swift_Message::newInstance()
            
                ->addTo($emailTest, $storeName)
                ->addFrom($contactEmail, $storeName)
                ->setSubject($subject)
                ->setBody($message, 'text/plain')
                ->setBody($htmlMessage, 'text/html')
                
                ->setContentType("text/html")
            ;
            if($image_full_path != "no_image")$instance->attach(\Swift_Attachment::fromPath($new_image_path."/".$new_image_name));

            try {
                $this->getMailer()->send($instance);
                
            } catch (\Exception $ex) {
               
                $log->error(sprintf('message : %s', $ex->getMessage()));
            }
//;
/*foreach ($form->get('projekt-art')->getConfig()->getOptions() as $option)
	if(is_string($option))
	$log->debug("1234aaa ".$option);
	else 
		if(is_array($option))
		$log->debug("1234aaa ".implode(" ",$option));
		else if(is_bool($option))
		$log->debug("1234aaa ".$option);
		else if(is_object($option)){
			if(get_class($option) == "Symfony\Component\Form\ChoiceList\ArrayKeyChoiceList")
			$log->debug($option->getValuesForChoices(array(1,2))[1]);
			else $log->debug(get_class($option));
			//Symfony\Component\Form\ChoiceList\ArrayKeyChoiceList;
		}*/
			
			foreach ($form->get('projekt-art')->getConfig()->getAttributes() as $option)
				if(is_string($option))
					$log->debug("1234aaa ".$option);
					else
						if(is_array($option))
							$log->debug("1234aaa ".implode(" ",$option));
							else if(is_bool($option))
								$log->debug("1234aaa ".$option);
								else if(is_object($option)){
									if(get_class($option) == "Symfony\Component\Form\ChoiceList\ArrayKeyChoiceList")
										$log->debug($option->getValuesForChoices(array(1,2))[1]);
										else $log->debug(get_class($option));
										//Symfony\Component\Form\ChoiceList\ArrayKeyChoiceList;
								}
								
return new JsonResponse($contactForm->getChoiceName());
          // return $this->generateRedirectFromRoute('custom.services.success');




    }
}
