<?php
/*************************************************************************************/
/*                                                                                   */
/*      Thelia	                                                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : info@thelia.net                                                      */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      This program is free software; you can redistribute it and/or modify         */
/*      it under the terms of the GNU General Public License as published by         */
/*      the Free Software Foundation; either version 3 of the License                */
/*                                                                                   */
/*      This program is distributed in the hope that it will be useful,              */
/*      but WITHOUT ANY WARRANTY; without even the implied warranty of               */
/*      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                */
/*      GNU General Public License for more details.                                 */
/*                                                                                   */
/*      You should have received a copy of the GNU General Public License            */
/*	    along with this program. If not, see <http://www.gnu.org/licenses/>.         */
/*                                                                                   */
/*************************************************************************************/

namespace Front\Controller;

use Thelia\Controller\Front\BaseFrontController;
use HookServices\Form\Services;
use Thelia\Log\Tlog;
use Thelia\Model\ConfigQuery;
use Symfony\Component\HttpFoundation\FileBag;
/**
 * Class ContactController
 * @package Thelia\Controller\Front
 * @author Ani Jalavyan <ani.jalavyan@sepa.at>
 */
class HirePlumberController extends BaseFrontController
{
    /**
     * send contact message
     */
    public function sendAction()
    {
        $log = Tlog::getInstance();
        $contactForm = $this->createForm("services");
        //$form = $this->validateForm($contactForm);
        $subject = "Hire a Plumber";
        $emailTest = ConfigQuery::read('offer_email');
       
        $anmerkungen = $this->getRequest()->get('services')['anmerkungen'];
        $firstname =  $this->getRequest()->get('services')['firstname'];
        $lastname =  $this->getRequest()->get('services')['lastname'];
        $phone =  $this->getRequest()->get('services')['phone'];
        $cellphone = $this->getRequest()->get('services')['cellphone'];
        $email = $this->getRequest()->get('services')['email'];
        
        $projektArt = $this->getRequest()->get('services')['projekt_art'];
        if($projektArt!=1)
        $projektArt = $contactForm->getLabel("projekt_art",$projektArt);
        
        /* BAD */
        
        $badProjektGeraet = $this->getRequest()->get('services')['bad-projekt-geraet'];
        if($badProjektGeraet!=1)
        $badProjektGeraet = $contactForm->getLabel("bad-projekt-geraet",$badProjektGeraet);
        
        $badArbeitTyp = $this->getRequest()->get('services')['bad-arbeit-typ'];
        if($badArbeitTyp!=1)
        $badArbeitTyp = $contactForm->getLabel("bad-arbeit-typ",$badArbeitTyp);
        
        $badMarke = $this->getRequest()->get('services')['badMarke'];
        if($badMarke!="")
        $badMarke = $contactForm->getLabel("badMarke",$badMarke);
        
        $badAnbieten = $this->getRequest()->get('services')['badAnbieten'];
        if($badAnbieten!=1)
        $badAnbieten = $contactForm->getLabel("badAnbieten",$badAnbieten);
        
        
        /* KÜCHE */
        
        $kuecheProjektGeraet = $this->getRequest()->get('services')['kueche-projekt-geraet'];
        if($kuecheProjektGeraet!=1)
        $kuecheProjektGeraet = $contactForm->getLabel("kueche-projekt-geraet",$kuecheProjektGeraet);
        
        $kuecheArbeitTyp = $this->getRequest()->get('services')['kueche-arbeit-typ'];
        if($kuecheArbeitTyp!=1)
        $kuecheArbeitTyp = $contactForm->getLabel("kueche-arbeit-typ",$kuecheArbeitTyp);
        
        $kuecheMarke = $this->getRequest()->get('services')['kuecheMarke'];
        if($kuecheMarke!="")
        $kuecheMarke = $contactForm->getLabel("kuecheMarke",$kuecheMarke);
        
        $kuecheAnbieten = $this->getRequest()->get('services')['kuecheAnbieten'];
        if($kuecheAnbieten!=1)
        $kuecheAnbieten = $contactForm->getLabel("kuecheAnbieten",$kuecheAnbieten);
        
        
        /* HEIZUNG */
        
        $heizungProjektGeraet = $this->getRequest()->get('services')['heizung-projekt-geraet'];
        if($heizungProjektGeraet!=1)
        $heizungProjektGeraet = $contactForm->getLabel("heizung-projekt-geraet",$heizungProjektGeraet);
        
        $heizungArbeitTyp = $this->getRequest()->get('services')['heizung-arbeit-typ'];
        if($heizungArbeitTyp!=1)
        $heizungArbeitTyp = $contactForm->getLabel("heizung-arbeit-typ",$heizungArbeitTyp);
        
        $heizungMarke = $this->getRequest()->get('services')['heizungMarke'];
        if($heizungMarke!="")
        $heizungMarke = $contactForm->getLabel("heizungMarke",$heizungMarke);
        
        $heizungAnbieten = $this->getRequest()->get('services')['heizungAnbieten'];
        if($heizungAnbieten!=1)
        $heizungAnbieten = $contactForm->getLabel("heizungAnbieten",$heizungAnbieten);
        
        /* WARMWASSER */
        
        $warmwasserProjektGeraet = $this->getRequest()->get('services')['warmwasser-projekt-geraet'];
        if($warmwasserProjektGeraet!=1)
        $warmwasserProjektGeraet = $contactForm->getLabel("warmwasser-projekt-geraet",$warmwasserProjektGeraet);
        
        $warmwasserArbeitTyp = $this->getRequest()->get('services')['warmwasser-arbeit-typ'];
        if($warmwasserArbeitTyp!=1)
        $warmwasserArbeitTyp = $contactForm->getLabel("warmwasser-arbeit-typ",$warmwasserArbeitTyp);
        
        $warmwasserMarke = $this->getRequest()->get('services')['warmwasserMarke'];
        if($warmwasserMarke!="")
        $warmwasserMarke = $contactForm->getLabel("warmwasserMarke",$warmwasserMarke);
        
        $warmwasserAnbieten = $this->getRequest()->get('services')['warmwasserAnbieten'];
        if($warmwasserAnbieten!=1)
        $warmwasserAnbieten = $contactForm->getLabel("warmwasserAnbieten",$warmwasserAnbieten);
        
         /* ANDERE */
        
        $andereArbeitTyp = $this->getRequest()->get('services')['andere-arbeit-typ'];
        if($andereArbeitTyp!=1)
        $andereArbeitTyp = $contactForm->getLabel("andere-arbeit-typ",$andereArbeitTyp);
        
        $andereMarke = $this->getRequest()->get('services')['andereMarke'];
        if($andereMarke!="")
        $andereMarke = $contactForm->getLabel("andereMarke",$andereMarke);
        
        $andereAnbieten = $this->getRequest()->get('services')['andereAnbieten'];
        if($andereAnbieten!=1)
        $andereAnbieten = $contactForm->getLabel("andereAnbieten",$andereAnbieten);


        
        
        $files = new FileBag();
        $files = $this->getRequest()->files;
        
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        
        
        $storeName="Hausfabrik";
        $contactEmail=ConfigQuery::read('offer_email');
        $kundenEmail = $email;
        $kundenEmailSubject = "Vielen Dank für Ihre Anfrage";
        $instance = \Swift_Message::newInstance()
        
        ->addTo($emailTest, $storeName)
        ->addFrom($contactEmail, $storeName)
        ->setSubject($subject)
        ->setContentType("text/html");
        
        
         $kundenInstance = \Swift_Message::newInstance()
        ->addTo($kundenEmail, $storeName)
        ->addFrom($contactEmail, $storeName)
        ->setSubject($kundenEmailSubject)
        ->setContentType("text/html");
        
        $imagesHTML = "";
        $new_image_path = THELIA_ROOT .ConfigQuery::read('images_library_path')."/imani";
        
        if($files->get("file")!=NULL)
        foreach ($files->get("file") as $image){
        	if($image != null){
        		$new_image_name = $image->getClientOriginalName();
        		$image->move($new_image_path ,$new_image_name);
        		$image_full_path = $new_image_path."/".$new_image_name;
        		$imagesHTML.= '<img src="'.$image.'">"';
        	}else 
        		$image_full_path = "no_image";
        	
        	if($image_full_path != "no_image")$instance->attach(\Swift_Attachment::fromPath($new_image_path."/".$new_image_name));
        }
        
        	//Bilder<img src=".$image_upload.">"
        
       // $image_upload = $files->get("file")["image_upload"];
        
		//if($imagesHTML != "")$imagesHTML = "Bilder ";
        
        
         $message = "Vorname:".$firstname.
        "<br>Nachname: <strong>".$lastname."</strong>
        <br>Telefon: <strong>".$phone."</strong>
        <br>Mobil: <strong>".$cellphone."</strong>
        <br>Email: <strong>".$email."</strong>";
        if($projektArt!=1)
        $message.="<br>Um welche Art von Projekt handelt es sich?: <strong>".$projektArt."</strong>";
        
        /* BAD */
        
        if($badProjektGeraet!=1)
        $message.="<br>Welchen Bereich umfasst Ihr Projekt?: <strong>".$badProjektGeraet."</strong>";
        if($badArbeitTyp!=1)
        $message.="<br>Was muss getan werden?: <strong>".$badArbeitTyp."</strong>";
        
        if($badMarke!="")
        $message.="<br>Welche Marke oder welches Modell wollen Sie?: <strong>".$badMarke."</strong>";
        
        if($badAnbieten!=1)
        $message.="<br>Was soll unser Angebot beeinhalten?: <strong>".$badAnbieten."</strong>";
        
        /* KÜCHE */
        
        if($kuecheProjektGeraet!=1)
        $message.="<br>Welchen Bereich umfasst Ihr Projekt?: <strong>".$kuecheProjektGeraet."</strong>";
        if($kuecheArbeitTyp!=1)
        $message.="<br>Was muss getan werden?: <strong>".$kuecheArbeitTyp."</strong>";
        
        if($kuecheMarke!="")
        $message.="<br>Welche Marke oder welches Modell wollen Sie?: <strong>".$kuecheMarke."</strong>";
        
        if($kuecheAnbieten!=1)
        $message.="<br>Was soll unser Angebot beeinhalten?: <strong>".$kuecheAnbieten."</strong>";
        
        /* HEIZUNG */
        
        if($heizungProjektGeraet!=1)
        $message.="<br>Welchen Bereich umfasst Ihr Projekt?: <strong>".$heizungProjektGeraet."</strong>";
        if($heizungArbeitTyp!=1)
        $message.="<br>Was muss getan werden?: <strong>".$heizungArbeitTyp."</strong>";
        
        if($heizungMarke!="")
        $message.="<br>Welche Marke oder welches Modell wollen Sie?: <strong>".$heizungMarke."</strong>";
        
        if($heizungAnbieten!=1)
        $message.="<br>Was soll unser Angebot beeinhalten?: <strong>".$heizungAnbieten."</strong>";
        
        
        /* WARMWASSER */
        
        if($warmwasserProjektGeraet!=1)
        $message.="<br>Welchen Bereich umfasst Ihr Projekt?: <strong>".$warmwasserProjektGeraet."</strong>";
        if($warmwasserArbeitTyp!=1)
        $message.="<br>Was muss getan werden?: <strong>".$warmwasserArbeitTyp."</strong>";
        
        if($warmwasserMarke!="")
        $message.="<br>Welche Marke oder welches Modell wollen Sie?: <strong>".$warmwasserMarke."</strong>";
        
        if($warmwasserAnbieten!=1)
        $message.="<br>Was soll unser Angebot beeinhalten?: <strong>".$warmwasserAnbieten."</strong>";
        
        /* ANDERE */
        
       
        if($andereArbeitTyp!=1)
        $message.="<br>Was muss getan werden?: <strong>".$andereArbeitTyp."</strong>";
        
        if($andereMarke!="")
        $message.="<br>Welche Marke oder welches Modell wollen Sie?: <strong>".$andereMarke."</strong>";
        
        if($andereAnbieten!=1)
        $message.="<br>Was soll unser Angebot beeinhalten?: <strong>".$andereAnbieten."</strong>";
        
        
        
        $message.="<br>Anmerkungen: <strong>".$anmerkungen."</strong>";
        $message.="<br>".$imagesHTML;
        
        $kundenMessage = "Vielen Dank für Ihre Anfrage! Wir werden Sie bald kontaktieren!";
        
        $log->error(sprintf('message : %s', $message));
        $htmlMessage = "<p>$message</p>";
        
        $htmlMessageKunde = "<p>$kundenMessage</p><p>$message</p>";

            

            $instance->setBody($message, 'text/plain')
            ->setBody($htmlMessage, 'text/html');
            
            try {
                $this->getMailer()->send($instance);
            } catch (\Exception $ex) {
                $log->error(sprintf('message : %s', $ex->getMessage()));
            }
        
       
            $kundenInstance->setBody($htmlMessageKunde, 'text/plain')
            ->setBody($htmlMessageKunde, 'text/html');
            
            try {
                $this->getMailer()->send($kundenInstance);
            } catch (\Exception $ex) {
                $log->error(sprintf('message : %s', $ex->getMessage()));
            }
        

           return $this->generateRedirectFromRoute('services.success');
    }
}
