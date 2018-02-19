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
use HookHeizungAngebot\Form\HeizungAngebot;
use Thelia\Log\Tlog;
use Thelia\Model\ConfigQuery;
use Symfony\Component\HttpFoundation\FileBag;
use HookKonfigurator\Model\HeizungkonfiguratorAngebot;
/**
 * Class ContactController
 * @package Thelia\Controller\Front
 * @author Ani Jalavyan <ani.jalavyan@sepa.at>
 */
class HeizungAngebotController extends BaseFrontController
{
    /**
     * send contact message
     */
    public function sendAction()
    {
        $log = Tlog::getInstance();
        
        $request = $this->getRequest();
        
        $currentCustomer = $this->getSecurityContext()->getCustomerUser();
        if($currentCustomer == null)
        	$currentCustomer	= 0;//$this->getCurrentRequest()->getSession()->getId();
        else $currentCustomer = $currentCustomer->getId();
        
        
        $contactForm = $this->createForm("heizung.angebot");
        $form = $this->validateForm($contactForm);
        $subject = "Heizung Individuelles Angebot";
        $emailTest = "angebote@hausfabrik.at";
        $firstname = $this->getRequest()->get('heizungangebot')['firstname'];
        $lastname =  $this->getRequest()->get('heizungangebot')['lastname'];
        $phone =  $this->getRequest()->get('heizungangebot')['phone'];
        $cellphone = $this->getRequest()->get('heizungangebot')['cellphone'];
        $building_etage = $this->getRequest()->get('heizungangebot')['building_etage'];
        $email = $this->getRequest()->get('heizungangebot')['email'];
        
        
        $brennstoffZukunft = $request->request->get('heizungangebot')['brennstoff_zukunft'];
        $brennstoffZukunft = $contactForm->getLabel("brennstoff_zukunft",$brennstoffZukunft);
        
        $gebaudeart = $request->request->get('heizungangebot')['gebaeudeart'];
        $gebaudeart = $contactForm->getLabel("gebaeudeart",$gebaudeart);
        
        $baujahr = $request->request->get('heizungangebot')['baujahr'];
        $baujahr = $contactForm->getLabel("baujahr",$baujahr);
        
        $personen_anzahl = $request->request->get('heizungangebot')['personen_anzahl'];
        //$personen_anzahl = $contactForm->getLabel("personen_anzahl",$personen_anzahl);       
        
        $lage_des_gebaeudes = $request->request->get('heizungangebot')['lage_des_gebaeudes'];
        $lage_des_gebaeudes = $contactForm->getLabel("lage_des_gebaeudes",$lage_des_gebaeudes);        
        
        $building_etage = $request->request->get('heizungangebot')['building_etage'];
        
        $windlage_des_gebaudes = $request->request->get('heizungangebot')['windlage_des_gebaudes'];
        $windlage_des_gebaudes = $contactForm->getLabel("windlage_des_gebaudes",$windlage_des_gebaudes);
        
        $anzahl_aussenwaende = $request->request->get('heizungangebot')['anzahl_aussenwaende'];
        $anzahl_aussenwaende = $contactForm->getLabel("anzahl_aussenwaende",$anzahl_aussenwaende);
        
        $abgasfuehrung = $request->request->get('heizungangebot')['abgasfuehrung'];
        $abgasfuehrung = $contactForm->getLabel("abgasfuehrung",$abgasfuehrung);
        
        $dach_daemmung = $request->request->get('heizungangebot')['dach_daemmung'];
        $dach_daemmung = $contactForm->getLabel("dach_daemmung",$dach_daemmung);
        
        $fenster = $request->request->get('heizungangebot')['fenster'];
        $fenster = $contactForm->getLabel("fenster",$fenster); 
        
        $wohnraumtemperatur = $request->request->get('heizungangebot')['wohnraumtemperatur'];
        $wohnraumtemperatur = $contactForm->getLabel("wohnraumtemperatur",$wohnraumtemperatur); 
        
        $aussentemperatur = $request->request->get('heizungangebot')['aussentemperatur'];
        $aussentemperatur = $contactForm->getLabel("aussentemperatur",$aussentemperatur);
        
        $waermedaemmung = $request->request->get('heizungangebot')['waermedaemmung'];
        $waermedaemmung = $contactForm->getLabel("waermedaemmung",$waermedaemmung);
        
        $flaeche = $request->request->get('heizungangebot')['flaeche'];
        //$flaeche = $contactForm->getLabel("flaeche",$flaeche);
        
        $warmwasserversorgung = $request->request->get('heizungangebot')['warmwasserversorgung'];
        $warmwasserversorgung = $contactForm->getLabel("warmwasserversorgung",$warmwasserversorgung);
        
        $anmerkungen = $request->request->get('heizungangebot')['anmerkungen'];
        //$anmerkungen = $contactForm->getLabel("anmerkungen",$anmerkungen);
        
        $wasserabfluss = $request->request->get('heizungangebot')['wasserabfluss'];
        $wasserabfluss = $contactForm->getLabel("wasserabfluss",$wasserabfluss);
        
        $plan_heizung = $request->request->get('heizungangebot')['plan_heizung'];
        $plan_heizung = $contactForm->getLabel("plan_heizung",$plan_heizung);
        
        $building_etage = $request->request->get('heizungangebot')['building_etage'];
        //$building_etage = $contactForm->getLabel("building_etage",$building_etage);
        
        $heizungsmethode = $request->request->get('heizungangebot')['heizungsmethode'];
        $heizungsmethode = $contactForm->getLabel("heizungsmethode",$heizungsmethode);
        
        $solaranlage = $request->request->get('heizungangebot')['solaranlage'];
        $solaranlage = $contactForm->getLabel("solaranlage",$solaranlage);
        
        $solaranlageextra = $request->request->get('heizungangebot')['solaranlageextra'];
        $solaranlageextra = $contactForm->getLabel("solaranlageextra",$solaranlageextra);
        
        $photovoltaik = $request->request->get('heizungangebot')['photovoltaik'];
        $photovoltaik = $contactForm->getLabel("photovoltaik",$photovoltaik);

        $heizungsAngebot = new HeizungkonfiguratorAngebot();
        $heizungsAngebot
        ->setBrennstoffZukunft($brennstoffZukunft)
        ->setGebaeudeart($gebaudeart)
        ->setBaujahr($baujahr)
        ->setPersonenAnzahl($personen_anzahl)        
        ->setGebaeudelage($lage_des_gebaeudes)
        ->setWindlage($windlage_des_gebaudes)
        ->setAnzahlAussenwaende($anzahl_aussenwaende)
        ->setAbgasfuehrung($abgasfuehrung)        
        ->setDachDaemmung($dach_daemmung)        
        ->setVerglasteFenster($fenster)
        ->setWohnraumtemperatur($wohnraumtemperatur)
        ->setAussentemperatur($aussentemperatur)
        ->setWaermedaemmung($waermedaemmung)
        ->setFlaeche($flaeche)
        ->setWarmwasserversorgung($warmwasserversorgung)
        ->setAnmerkungen($anmerkungen)
        ->setWasserabfluss($wasserabfluss)
        ->setPlanHeizung($plan_heizung)
        ->setBuildingEtagen($building_etage)
        ->setHeizungsmethode($heizungsmethode)
        ->setSolaranlage($solaranlage)
        ->setSolaranlageextra($solaranlageextra)
        ->setPhotovoltaik($photovoltaik)
        ->setCreatedAt(date ( "Y-m-d H:i:s" ))
        ->setUserId($currentCustomer)
        ->setVersion("1.0")
        ->save();

        $files = new FileBag();
        $files = $this->getRequest()->files;
        
        $storeName="Hausfabrik";
        $contactEmail="angebote@hausfabrik.at";
        $instance = \Swift_Message::newInstance()
        ->addTo($emailTest, $storeName)
        ->addFrom($contactEmail, $storeName)
        ->setSubject($subject)
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
        //$message = "Vorname:".$firstname."<br>Nachname:".$lastname."<br>Telefon".$phone."<br>Mobil".$cellphone."<br>Wie viele Stöcke hat das Gebäude?".$building_etage." <br>In welchem Stock befindet sich Ihre Wohnung?<br>Art des Gebäudes?<br>Marke des Gerätes?<br>Gerätetyp?<br>Wegstrecke vom Innenteil zum Außenteil?<br>Bilder<img src=".$image_upload.">";
        
        if($imagesHTML != "")$imagesHTML = "Bilder ".$imagesHTML;
        $message = "Vorname:".$firstname.
        "<br>Nachname:".$lastname.
        "<br>Telefon: ".$phone.
        "<br>Mobil: ".$cellphone.
        "<br>Email: ".$email.
        "<br>Womit werden Sie in Zukunft heizen? ".$brennstoffZukunft.
        "<br>Um was für ein Gebäude handelt es sich? ".$gebaudeart.
        "<br>Wie viele Personen leben im Haushalt? ".$personen_anzahl.
        "<br>Wann wurde das Gebäude gebaut? ".$baujahr.
        "<br>Lage des Gebäudes? ". $lage_des_gebaeudes.
        "<br>Windlage des Gebäudes? ". $windlage_des_gebaudes.
        "<br>Wie viel ist die Anzahl der Außenwände? ". $anzahl_aussenwaende.
        "<br>Wie sind Ihre Fenster verglast? ". $fenster.
        "<br>Wie hoch ist die Wohnraumtemperatur? ". $wohnraumtemperatur.
        "<br>Wie kalt kann bei ihnen im Winter die Außentemperatur werden? ". $aussentemperatur.
        "<br>Ist eine Wärmedämmung vorhanden? ".  $waermedaemmung.
        "<br>Wie viele Etagen hat Ihr Gebäude? ".$building_etage.
        "<br>Ist das Dach gedämmt?".$dach_daemmung.
        "<br>Wie verläuft die Abgasführung heute? ".$abgasfuehrung.
        "<br>Ist ein Wasserabfluss unter der Heizung vorhanden? ".$wasserabfluss.
        "<br>Soll die Warmwasserversorgung über die Heizung erfolgen? ".$warmwasserversorgung.
        "<br>Anmerkungen zu Ihrer Heizung ".$anmerkungen.
        "<br>Wie groß ist die zu beheizende Fläche? ".  $flaeche.
        "<br>".$imagesHTML;
        
        
        $log->error(sprintf('message : %s', $message));
        $htmlMessage = "<p>$message</p>";
        
        $instance->setBody($message, 'text/plain')
        ->setBody($htmlMessage, 'text/html');
        
        try {
        	$this->getMailer()->send($instance);
        } catch (\Exception $ex) {
        	$log->error(sprintf('message : %s', $ex->getMessage()));
        }


           return $this->generateRedirectFromRoute('heizung.angebot.success');




    }
}
