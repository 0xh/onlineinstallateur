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
    protected function buildForm()
    {
         $formBuilder = $this->formBuilder
         ->add("brennstoff_momentan", "choice", array(
         		"choices" => array (
         				1 => Translator::getInstance()->trans("Erdgas"),
         				2 => Translator::getInstance()->trans("Erdöl"),
         				3 => Translator::getInstance()->trans("Flüssiggas"),
         				4 => Translator::getInstance()->trans("Sonstiges")
         		),
         		"label" => Translator::getInstance()->trans("Womit heizen Sie momentan?"),
         		"label_attr" => array(
         				"for" => "brennstoff_momentan",
         		),
         		"data" => 1
         ))
         ->add("brennstoff_zukunft", "choice", array(
         		"choices" => array (
         				1 => Translator::getInstance()->trans("Erdgas"),
         				2 => Translator::getInstance()->trans("Erdöl"),
         				3 => Translator::getInstance()->trans("Flüssiggas"),
         				4 => Translator::getInstance()->trans("Sonstiges")
         		),
         		"label" => Translator::getInstance()->trans("Womit werden Sie in Zukunft heizen?"),
         		"label_attr" => array(
         				"for" => "brennstoff_zukunft",
         		),
         		"data" => 1
         ))
		->add("gebaeudeart", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("Einzelhaus"),
						2 => Translator::getInstance()->trans("Reihenhaus"),
						3 => Translator::getInstance()->trans("Mehrfamilienhaus")
				),
				"label" => Translator::getInstance()->trans("Um was für ein Objekt handelt es sich?"),
				"label_attr" => array(
                    "for" => "gebaeudeart",
                ),
				"data" => 1
		))
		->add("baujahr", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("Bis 1960"),
						2 => Translator::getInstance()->trans("1966-1977"),
						3 => Translator::getInstance()->trans("Ab 1978")
				),
				"label" => Translator::getInstance()->trans("Wann wurde das Objekt gebaut?"),
				"label_attr" => array(
                    "for" => "baujahr",
                ),
				"data" => 1
		))
		->add("personen_anzahl", "integer", array(
				"label" => Translator::getInstance()->trans("Wie viele Personen leben in Ihrem Objekt?"),
				"label_attr" => array(
						"for" => "personen_anzahl",
				),
				"data" => 3
		))
		->add("flaeche", "integer", array(
				"label" => Translator::getInstance()->trans("Wie groß ist die Heizfläche?"),
				"label_attr" => array(
						"for" => "flaeche"
				),
				"data" => 110
		))
		->add("lage_des_gebaeudes", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("Frei"),
						2 => Translator::getInstance()->trans("Normal")
				),
				"label" => Translator::getInstance()->trans("Lage des Gebäudes?"),
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
				"label" => Translator::getInstance()->trans("Windlage des Gebaudes"),
				"label_attr" => array(
                    "for" => "windlage_des_gebaudes",
                ),
				"data" => 1
		))
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
		->add("anzahl_aussenwaende", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("1 Wand"),
						2 => Translator::getInstance()->trans("2 Wände"),
						3 => Translator::getInstance()->trans("mehr als 3 Wände")
				),
				"label" => Translator::getInstance()->trans("Wie viel ist die Anzahl der Außenwände?"),
				"label_attr" => array(
                    "for" => "anzahl_aussenwaende",
                ),
				"data" => 1
		))
		->add("fenster", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("Einfach verglast"),
						2 => Translator::getInstance()->trans("Doppelt verglast"),
						3 => Translator::getInstance()->trans("Isolierverglast")
				),
				"label" => Translator::getInstance()->trans("Wie sind Ihre Fenster verglast?"),
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
				"label" => Translator::getInstance()->trans("Wie groß sind Ihre Fensterflächen?"),
				"label_attr" => array(
                    "for" => "verglaste_flaeche",
                ),
				"data" => 1
		))
		->add("dach_daemmung", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("Ja"),
						2 => Translator::getInstance()->trans("Nein")
				),
				"label" => Translator::getInstance()->trans("Ist das Dach gedämmt?"),
				"label_attr" => array(
						"for" => "dach_daemmung",
				),
				"data" => 1
		))
		->add("wohnraumtemperatur", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("22"),
						2 => Translator::getInstance()->trans("20"),
						3 => Translator::getInstance()->trans("15")
				),
				"label" => Translator::getInstance()->trans("Wie hoch ist die Wohnraumtemperatur?"),
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
				"label" => Translator::getInstance()->trans("Wie hoch ist die Außentemperatur?"),
				"label_attr" => array(
                    "for" => "aussentemperatur"
                ),
				"data" => 1
		))
		->add("waermedaemmung", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("Nicht"),
						2 => Translator::getInstance()->trans("Teilweise"),
						3 => Translator::getInstance()->trans("Erhöht")
				),
				"label" => Translator::getInstance()->trans("Ist eine Wärmedämmung vorhanden?"),
				"label_attr" => array(
                    "for" => "waermedaemmung"
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
