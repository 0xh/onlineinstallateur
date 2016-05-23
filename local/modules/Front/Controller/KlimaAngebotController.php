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
use HookKlimaAngebot\Form\KlimaAngebot;
use Thelia\Form\Definition\FrontForm;
use Thelia\Form\Exception\FormValidationException;
use Thelia\Log\Tlog;
use Thelia\Model\ConfigQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;
/**
 * Class ContactController
 * @package Thelia\Controller\Front
 * @author Ani Jalavyan <ani.jalavyan@sepa.at>
 */
class KlimaAngebotController extends BaseFrontController
{
    /**
     * send contact message
     */
    public function sendAction()
    {
        $log = Tlog::getInstance();
        $contactForm = $this->createForm("klima.angebot");
        $form = $this->validateForm($contactForm);
        $subject = "Klima Individuelles Angebot";
        $emailTest = "ani.jalavyan@sepa.at";
        $firstname = $this->getRequest()->get('klimaangebot')['firstname'];
        $lastname =  $this->getRequest()->get('klimaangebot')['lastname'];
        $phone =  $this->getRequest()->get('klimaangebot')['phone'];
        $cellphone = $this->getRequest()->get('klimaangebot')['cellphone'];
        $building_etage = $this->getRequest()->get('klimaangebot')['building_etage'];
        $etage = $this->getRequest()->get('klimaangebot')['etage'];
        //§gebaeudeart = $this->getRequest()->get('klimaangebot')['gebaeudeart'];
        //§marke = $this->getRequest()->get('klimaangebot')['marke'];
        //§geraetetyp = $this->getRequest()->get('klimaangebot')['geraetetyp'];
        //§distance = $this->getRequest()->get('klimaangebot')['distance'];


        
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
        $image_upload = $files->get("klimaangebot")["image_upload"];
        
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
        $message = "Vorname:".$firstname."<br>Nachname:".$lastname."<br>Telefon".$phone."<br>Mobil".$cellphone."<br>Wie viele Stöcke hat das Gebäude?".$building_etage." <br>In welchem Stock befindet sich Ihre Wohnung?".$etage."<br>Art des Gebäudes?<br>Marke des Gerätes?<br>Gerätetyp?<br>Wegstrecke vom Innenteil zum Außenteil?<br>Bilder<img src=".$image_upload.">";
        
        
        
$log->error(sprintf('message : %s', $message));
            $htmlMessage = "<p>$message</p>";
$storeName="Hausfabrik";
$contactEmail="ani.jalavyan@sepa.at";
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


           return $this->generateRedirectFromRoute('klima.angebot.success');




    }
}
