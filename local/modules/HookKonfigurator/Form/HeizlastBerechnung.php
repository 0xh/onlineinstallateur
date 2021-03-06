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

class HeizlastBerechnung extends BaseForm
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
         ->add("brennstoff_momentan", "choice", array(
         		"choices" => array (
         				1 => $this->setLabel("brennstoff_momentan",1,"Erdgas"),
         				2 => $this->setLabel("brennstoff_momentan",2,"Heizöl"),
         				3 => $this->setLabel("brennstoff_momentan",3,"Holz"),
                        4 => $this->setLabel("brennstoff_momentan",4,"Wärmepumpe"),
         				5 => $this->setLabel("brennstoff_momentan",5,"Sonstiges")
         		),
         		"label" => Translator::getInstance()->trans("Womit heizen Sie momentan?"),
         		"label_attr" => array(
         				"for" => "brennstoff_momentan",
         		),
         		"data" => 1
         ))
         ->add("brennstoff_zukunft", "choice", array(
         		"choices" => array (
         				1 => $this->setLabel("brennstoff_zukunft",1,"Erdgas"),
         				2 => $this->setLabel("brennstoff_zukunft",2,"Heizöl"),
         				3 => $this->setLabel("brennstoff_zukunft",3,"Holz"),
                        4 => $this->setLabel("brennstoff_zukunft",4,"Wärmepumpe"),
         				5 => $this->setLabel("brennstoff_zukunft",5,"Sonstiges")
         		),
         		"label" => Translator::getInstance()->trans("Womit werden Sie in Zukunft heizen?"),
         		"label_attr" => array(
         				"for" => "brennstoff_zukunft",
         		),
         		"data" => 1
         ))
		->add("gebaeudeart", "choice", array(
				"choices" => array (
						1 => $this->setLabel("gebaeudeart",1,"Einfamilienhaus"),
						2 => $this->setLabel("gebaeudeart",2,"Reihenhaus oder Doppelhaushälfte"),
						3 => $this->setLabel("gebaeudeart",3,"Mehrfamilienhaus mit Zentralheizung"),
                        4 => $this->setLabel("gebaeudeart",4,"Wohnung mit eigener Heizung")
				),
				"label" => Translator::getInstance()->trans("Um was für ein Gebäude handelt es sich?"),
				"label_attr" => array(
                    "for" => "gebaeudeart",
                ),
				"data" => 1
		))
             
        ->add("bestehendes_geraet_mit_warmwasser", "choice", array(
				"choices" => array (
						1 => $this->setLabel("bestehendes_geraet_mit_warmwasser",1,"Durchlauf"),
						2 => $this->setLabel("bestehendes_geraet_mit_warmwasser",2,"Kleinen Speicher bis 50l"),
						3 => $this->setLabel("bestehendes_geraet_mit_warmwasser",3,"Speicher größer 50l")
				),
				"label" => Translator::getInstance()->trans("Ist das bestehende Gerät mit Warmwasser?"),
				"label_attr" => array(
                    "for" => "mitwarmwasser",
                ),
				"data" => 1
		))
		
		
        ->add("bestehendes_geraet_kw", "integer", array(
                "label" => Translator::getInstance()->trans("Wie viel KW hat das bestehende Gerät?"),
				"label_attr" => array(
						"for" => "kw",
				),
				"data" => 1
		))
		->add("baujahr", "choice", array(
				"choices" => array (
						1 => $this->setLabel("baujahr",1,"Bis 1960"),
						2 => $this->setLabel("baujahr",2,"1961-1977"),
						3 => $this->setLabel("baujahr",3,"1978-1994"),
                        4 => $this->setLabel("baujahr",4,"Ab 1995")
				),
				"label" => Translator::getInstance()->trans("Wann wurde das Gebäude gebaut?"),
				"label_attr" => array(
                    "for" => "baujahr",
                ),
				"data" => 1
		))
		->add("personen_anzahl", "integer", array(
				"label" => Translator::getInstance()->trans("Wie viele Personen leben im Haushalt?"),
				"label_attr" => array(
						"for" => "personen_anzahl",
				),
				"data" => 3
		))
             
       ->add("etagen", "integer", array(
				"label" => Translator::getInstance()->trans("Wie viele Etagen hat Ihr Gebäude?"),
				"label_attr" => array(
						"for" => "etagen",
				),
				"data" => 2
		))
             
             
		->add("flaeche", "integer", array(
				"label" => Translator::getInstance()->trans("Wie groß ist die zu beheizende Fläche?"),
				"label_attr" => array(
						"for" => "flaeche"
				),
				"data" => 110
		))
		->add("lage_des_gebaeudes", "choice", array(
				"choices" => array (
						1 => $this->setLabel("lage_des_gebaeudes",1,"Frei"),
						2 =>  $this->setLabel("lage_des_gebaeudes",2,"Normal")
				),
				"label" => Translator::getInstance()->trans("Lage des Gebäudes?"),
				"label_attr" => array(
                    "for" => "lage_des_gebaeudes",
                ),
				"data" => 1
		))
		->add("windlage_des_gebaudes", "choice", array(
				"choices" => array (
						1 => $this->setLabel("windlage_des_gebaudes",1,"Windstark"),
						2 => $this->setLabel("windlage_des_gebaudes",2,"Windschwach")
				),
				"label" => Translator::getInstance()->trans("Windlage des Gebaudes"),
				"label_attr" => array(
                    "for" => "windlage_des_gebaudes",
                ),
				"data" => 1
		))
		/*
		->add("lage_des_raumes", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("1. Etag"),
						2 => Translator::getInstance()->trans("2. Etage"),
						3 => Translator::getInstance()->trans("3.-4 Etage")
				),
				"label" => Translator::getInstance()->trans("In welcher Etage befinden sich die Räume?"),
				"label_attr" => array(
                    "for" => "lage_des_raumes",
                ),
				"data" => 1
		))
		*/
		->add("anzahl_aussenwaende", "choice", array(
				"choices" => array (
						1 => $this->setLabel("anzahl_aussenwaende",1,"1 Wand"),
						2 => $this->setLabel("anzahl_aussenwaende",2,"2 Wände"),
						3 => $this->setLabel("anzahl_aussenwaende",3,"Mehr als 3 Wände")
				),
				"label" => Translator::getInstance()->trans("Wie viel ist die Anzahl der Außenwände?"),
				"label_attr" => array(
                    "for" => "anzahl_aussenwaende",
                ),
				"data" => 1
		))
		->add("fenster", "choice", array(
				"choices" => array (
						1 => $this->setLabel("fenster",1,"Einfach verglast"),
						2 => $this->setLabel("fenster",2,"Doppelt verglast"),
						3 => $this->setLabel("fenster",3,"Isolierverglast")
				),
				"label" => Translator::getInstance()->trans("Wie sind Ihre Fenster verglast?"),
				"label_attr" => array(
                    "for" => "fenster",
                ),
				"data" => 1
		))
		/*
		->add("verglaste_flaeche", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("Gross"),
						2 => Translator::getInstance()->trans("Mittel"),
						3 => Translator::getInstance()->trans("Klein")
				),
				"label" => Translator::getInstance()->trans("Wie groß sind Ihre Fensterflächen?"),
				"label_attr" => array(
                    "for" => "verglaste_flaeche",
                ),
				"data" => 1
		))
		*/
		->add("dach_daemmung", "choice", array(
				"choices" => array (
						1 => $this->setLabel("dach_daemmung",1,"Ja"),
						2 => $this->setLabel("dach_daemmung",2,"Nein")
				),
				"label" => Translator::getInstance()->trans("Ist das Dach gedämmt?"),
				"label_attr" => array(
						"for" => "dach_daemmung",
				),
				"data" => 1
		))
		->add("wohnraumtemperatur", "choice", array(
				"choices" => array (
						1 => $this->setLabel("wohnraumtemperatur",1,"15°C"),
						2 => $this->setLabel("wohnraumtemperatur",2,"20°C"),
                        3 => $this->setLabel("wohnraumtemperatur",3,"22°C"),
						4 => $this->setLabel("wohnraumtemperatur",4,"mehr als 22°C")
				),
				"label" => Translator::getInstance()->trans("Wie hoch ist die Wohnraumtemperatur?"),
				"label_attr" => array(
                    "for" => "wohnraumtemperatur",
                ),
				"data" => 1
		))
		->add("aussentemperatur", "choice", array(
				"choices" => array (
						1 => $this->setLabel("aussentemperatur",1,"-10°C"),
						2 => $this->setLabel("aussentemperatur",2,"-14°C/-12°C"),
                        3 => $this->setLabel("aussentemperatur",3,"-18°C/-16°C"),
						4 => $this->setLabel("aussentemperatur",4,"kälter als -18°C")
				),
				"label" => Translator::getInstance()->trans("Wie kalt kann bei ihnen im Winter die Außentemperatur werden?"),
				"label_attr" => array(
                    "for" => "aussentemperatur"
                ),
				"data" => 1
		))
		->add("waermedaemmung", "choice", array(
				"choices" => array (
						1 => $this->setLabel("waermedaemmung",1,"Nicht"),
						2 => $this->setLabel("waermedaemmung",2,"Teilweise"),
						3 => $this->setLabel("waermedaemmung",3,"Erhöht")
				),
				"label" => Translator::getInstance()->trans("Ist eine Wärmedämmung vorhanden?"),
				"label_attr" => array(
                    "for" => "waermedaemmung"
                ),
				"data" => 1
		)) 
         /* slide 7 */    
        
        ->add("abgasfuehrung", "choice", array(
				"choices" => array (
						1 => $this->setLabel("abgasfuehrung",1,"Aussen am Haus"),
						2 => $this->setLabel("abgasfuehrung",2,"Im Kamin"),
						3 => $this->setLabel("abgasfuehrung",3,"Direkt durch das Dach"),
                        4 => $this->setLabel("abgasfuehrung",4,"Ist noch ein zweites Gerät im Kamin eingebunden")
				),
				"label" => Translator::getInstance()->trans("Wie verläuft die Abgasführung heute?"),
				"label_attr" => array(
                    "for" => "abgasfuehrung"
                ),
				"data" => 1
		))   
        ->add("waermeabgabe", "choice", array(
				"choices" => array (
						1 => $this->setLabel("waermeabgabe",1,"Heizkörper"),
						2 => $this->setLabel("waermeabgabe",2,"Fußbodenheizung"),
						3 => $this->setLabel("waermeabgabe",3,"Heizkörper und Fußbodenheizung"),
                        4 => $this->setLabel("waermeabgabe",4,"Sonstiges")
				),
				"label" => Translator::getInstance()->trans("Wie erfolgt die Wärmeabgabe?"),
				"label_attr" => array(
                    "for" => "waermeabgabe"
                ),
				"data" => 1
		)) 
        ->add("duschwasser", "choice", array(
				"choices" => array (
						1 => $this->setLabel("duschwasser",1,"Ja"),
						2 => $this->setLabel("duschwasser",2,"Nein")

				),
				"label" => Translator::getInstance()->trans("Wird Duschwasser mit der Heizung erwärmt? "),
				"label_attr" => array(
                    "for" => "duschwasser"
                ),
				"data" => 1
		))                
        ->add("wasserabfluss", "choice", array(
				"choices" => array (
						1 => $this->setLabel("wasserabfluss",1,"Ja"),
						2 => $this->setLabel("wasserabfluss",2,"Nein")
				),
				"label" => Translator::getInstance()->trans("Ist ein Wasserabfluss unter der Heizung vorhanden? "),
				"label_attr" => array(
                    "for" => "duschwasser"
                ),
				"data" => 1
		))
        ->add("warmwasserversorgung", "choice", array(
				"choices" => array (
						1 => $this->setLabel("warmwasserversorgung",1,"Ja"),
						2 => $this->setLabel("warmwasserversorgung",2,"Nein")
				),
				"label" => Translator::getInstance()->trans("Soll die Warmwasserversorgung über die Heizung erfolgen? "),
				"label_attr" => array(
                    "for" => "warmwasserversorgung"
                ),
				"data" => 2
		))                 
        ->add("warmwasserversorgung-extra", "choice", array(
				"choices" => array (
						1 => $this->setLabel("warmwasserversorgung-extra",1,"Warmwasserspeicher"),
						2 => $this->setLabel("warmwasserversorgung-extra",2,"Kombigerät / Durchlauferhitzer"),
                        3 => $this->setLabel("warmwasserversorgung-extra",3,"Sonstige")
				),
				"label" => Translator::getInstance()->trans("Wie wollen Sie die Warmwasserversorgung haben mit einem?"),
				"label_attr" => array(
                    "for" => "warmwasserversorgung"
                ),
				"data" => 1
		))
		->add("warmwasserversorgung-extra-oel-holz", "choice", array(
				"choices" => array (
						1 => $this->setLabel("warmwasserversorgung-extra-oel-holz",1,"Warmwasserspeicher"),
				),
				"label" => Translator::getInstance()->trans("Wie wollen Sie die Warmwasserversorgung haben mit einem?"),
				"label_attr" => array(
						"for" => "warmwasserversorgung"
				),
				"data" => 1
		))		
        ->add("warmwasserversorgung-extra-waermepumpe", "choice", array(
				"choices" => array (
						1 => $this->setLabel("warmwasserversorgung-extra-waermepumpe",1,"Warmwasserspeicher"),
                        2 => $this->setLabel("warmwasserversorgung-extra-waermepumpe",2,"Sonstige")
				),
				"label" => Translator::getInstance()->trans("Wie wollen Sie die Warmwasserversorgung haben mit einem?"),
				"label_attr" => array(
                    "for" => "warmwasserversorgung"
                ),
				"data" => 1
		))     
		->add("anmerkungen", "text", array(
		"label" => Translator::getInstance()->trans("Anmerkungen zu Ihrer Heizung"),
		"label_attr" => array(
                    "for" => "anmerkungen"
                )/*,
		"disabled" => true*/
		))
		;
    }

    public function getName()
    {
        return "konfigurator";
    }
}
