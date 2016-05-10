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

namespace KlimaKonfigurator\Form;

use KlimaKonfigurator\KlimaKonfigurator;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class KlimaBerechnung extends BaseForm
{
    protected function buildForm()
    {
         $formBuilder = $this->formBuilder
             
     		->add("grundflaeche", "integer", array(
				"label" => Translator::getInstance()->trans("FlÃ¤che"),
				"label_attr" => array(
						"for" => "flaeche"
				),
				"data" => 110
		))
             
            ->add("raumhoehe", "integer", array(
				"label" => Translator::getInstance()->trans("FlÃ¤che"),
				"label_attr" => array(
						"for" => "flaeche"
				),
				"data" => 110
		))
            ->add("fenster", "integer", array(
				"label" => Translator::getInstance()->trans("FlÃ¤che"),
				"label_attr" => array(
						"for" => "flaeche"
				),
				"data" => 110
		))
             
        ->add("decke", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("Nicht klimatisierter Raum"),
						2 => Translator::getInstance()->trans("Dachboden"),
                        3 => Translator::getInstance()->trans("Isoliertes Flachdach")
				),
				"label" => Translator::getInstance()->trans("dach_daemmung"),
				"label_attr" => array(
						"for" => "dach_daemmung",
				),
				"data" => 1
		))
             
         ->add("personen", "integer", array(
				"label" => Translator::getInstance()->trans("FlÃ¤che"),
				"label_attr" => array(
						"for" => "flaeche"
				),
				"data" => 110
		))
             
        ->add("zusaetzliche-waerme", "integer", array(
				"label" => Translator::getInstance()->trans("FlÃ¤che"),
				"label_attr" => array(
						"for" => "flaeche"
				),
				"data" => 110
		))
         ->add("wegstrecke", "integer", array(
				"label" => Translator::getInstance()->trans("FlÃ¤che"),
				"label_attr" => array(
						"for" => "flaeche"
				),
				"data" => 110
		))
         ->add("kondensatablauf", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("Gefälle"),
						2 => Translator::getInstance()->trans("Pumpe")
				),
				"label" => Translator::getInstance()->trans("dach_daemmung"),
				"label_attr" => array(
						"for" => "dach_daemmung",
				),
				"data" => 1
		))      
 
		->add("montage-aussenteil", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("Wandmontage mittels Konsole"),
						2 => Translator::getInstance()->trans("Bodenmontage mittels Standfuß"),
						3 => Translator::getInstance()->trans("Bodenmontagekonsole aus Gummi kurz"),
                        4 => Translator::getInstance()->trans("Bodenmontagekonsole aus Gummi lang"),
				),
				"label" => Translator::getInstance()->trans("gebaeudeart"),
				"label_attr" => array(
                    "for" => "gebaeudeart",
                ),
				"data" => 1
		))
		->add("stromanschluss", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("Stromanschluss ist Bauseits vorhanden"),
						2 => Translator::getInstance()->trans("Stromanschluss ist herzustellen")
						
				),
				"label" => Translator::getInstance()->trans("Baujahr"),
				"label_attr" => array(
                    "for" => "baujahr",
                ),
				"data" => 1
		))
		->add("personen_anzahl", "integer", array(
				"label" => Translator::getInstance()->trans("personen_anzahl"),
				"label_attr" => array(
						"for" => "personen_anzahl",
				),
				"data" => 3
		))

		->add("lage_des_gebaeudes", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("Frei"),
						2 => Translator::getInstance()->trans("Normal")
				),
				"label" => Translator::getInstance()->trans("Lage des gebÃ¤udes"),
				"label_attr" => array(
                    "for" => "lage_des_gebaeudes",
                ),
				"data" => 1
		))
		->add("windlage_des_gebaudes", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("Windstark"),
						2 => Translator::getInstance()->trans("Windschwach")
				),
				"label" => Translator::getInstance()->trans("Windlage des GebÃ¤udes"),
				"label_attr" => array(
                    "for" => "windlage_des_gebaudes",
                ),
				"data" => 1
		))
		->add("lage_des_raumes", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("1 Etage"),
						2 => Translator::getInstance()->trans("2 Etagen"),
						3 => Translator::getInstance()->trans("3-4 Etagen")
				),
				"label" => Translator::getInstance()->trans("Lage des RÃ¤umes"),
				"label_attr" => array(
                    "for" => "lage_des_raumes",
                ),
				"data" => 1
		))
		->add("anzahl_aussenwaende", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("3-4 Waende"),
						2 => Translator::getInstance()->trans("2 Waende"),
						3 => Translator::getInstance()->trans("1 Wand")
				),
				"label" => Translator::getInstance()->trans("Anzahl AuÃŸenwÃ¤nde"),
				"label_attr" => array(
                    "for" => "anzahl_aussenwaende",
                ),
				"data" => 1
		))
		->add("fenster", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("Einfach verglast"),
						2 => Translator::getInstance()->trans("Doppelt verglast"),
						3 => Translator::getInstance()->trans("Isoliertverglast")
				),
				"label" => Translator::getInstance()->trans("Fenster"),
				"label_attr" => array(
                    "for" => "fenster",
                ),
				"data" => 1
		))
		->add("verglaste_flaeche", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("Gross"),
						2 => Translator::getInstance()->trans("Mittel"),
						3 => Translator::getInstance()->trans("Klein")
				),
				"label" => Translator::getInstance()->trans("Verglaste FlÃ¤che"),
				"label_attr" => array(
                    "for" => "verglaste_flaeche",
                ),
				"data" => 1
		))
	
		->add("wohnraumtemperatur", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("22"),
						2 => Translator::getInstance()->trans("20"),
						3 => Translator::getInstance()->trans("15")
				),
				"label" => Translator::getInstance()->trans("Wohneaum temperatur"),
				"label_attr" => array(
                    "for" => "wohnraumtemperatur",
                ),
				"data" => 1
		))
		->add("aussentemperatur", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("-18C/-16C"),
						2 => Translator::getInstance()->trans("-14C/-12C"),
						3 => Translator::getInstance()->trans("-10C")
				),
				"label" => Translator::getInstance()->trans("AuÃŸentemperatur"),
				"label_attr" => array(
                    "for" => "aussentemperatur"
                ),
				"data" => 1
		))
		->add("waermedaemmung", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("Nicht"),
						2 => Translator::getInstance()->trans("Teilweise"),
						3 => Translator::getInstance()->trans("Erhoeht")
				),
				"label" => Translator::getInstance()->trans("WÃ¤rmedÃ¤mung"),
				"label_attr" => array(
                    "for" => "waermedaemmung"
                ),
				"data" => 1
		))
		->add("anmerkungen", "text", array(
		"label" => Translator::getInstance()->trans("anmerkungen"),
		"label_attr" => array(
                    "for" => "anmerkungen"
                )/*,
		"disabled" => true*/
		))
		;
    }

    public function getName()
    {
        return "klimakonfigurator";
    }
}
