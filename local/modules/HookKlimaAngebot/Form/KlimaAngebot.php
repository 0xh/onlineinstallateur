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

namespace HookKlimaAngebot\Form;

use HookKlimaAngebot\HookKlimaAngebot;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class KlimaAngebot extends BaseForm
{
    protected function buildForm()
    {
         $formBuilder = $this->formBuilder
        
           
        ->add("firstname", "text", array(
         		"label" => Translator::getInstance()->trans("Vorname"),
         		"label_attr" => array(
         				"for" => "firstname",
         		)
         ))
        ->add("lastname", "text", array(
         		"label" => Translator::getInstance()->trans("Nachname"),
         		"label_attr" => array(
         				"for" => "lastname",
         		)
         ))
        ->add("email", "text", array(
         		"label" => Translator::getInstance()->trans("E-Mail"),
         		"label_attr" => array(
         				"for" => "email",
         		)
         ))
         ->add("phone", "text", array(
         		"label" => Translator::getInstance()->trans("Telefon"),
         		"label_attr" => array(
         				"for" => "email",
         		)
         ))
        ->add("cellphone", "text", array(
         		"label" => Translator::getInstance()->trans("Mobil"),
         		"label_attr" => array(
         				"for" => "cellphone",
         		)
         ))
             
        ->add("building_etage", "text", array(
         		"label" => Translator::getInstance()->trans("3.	Wie viele Stockwerke hat das Gebäude?"),
         		"label_attr" => array(
         				"for" => "building_etage",
         		)
         ))
             
        ->add("etage", "text", array(
         		"label" => Translator::getInstance()->trans("In welchem Stockwerk befindet sich Ihre Wohnung?"),
         		"label_attr" => array(
         				"for" => "etage",
         		)
         ))
        ->add("gebaeudeart", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("Einzelhaus"),
						2 => Translator::getInstance()->trans("Panel"),
						3 => Translator::getInstance()->trans("Stein")
				),
				"label" => Translator::getInstance()->trans("Art des Gebäudes"),
				"label_attr" => array(
                    "for" => "gebaeudeart",
                ),
				"data" => 1
		))
        ->add("marke", "text", array(
         		"label" => Translator::getInstance()->trans("Welche Marke hat Ihr Gerät?"),
         		"label_attr" => array(
         				"for" => "etage",
         		)
         ))
             
        ->add("geraetetyp", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("An der Wand befestigt"),
						2 => Translator::getInstance()->trans("Bodenschrank"),
						3 => Translator::getInstance()->trans("Decke"),
                        4 => Translator::getInstance()->trans("Normal R410")
				),
				"label" => Translator::getInstance()->trans("Gerätetyp"),
				"label_attr" => array(
                    "for" => "gebaeudeart",
                ),
				"data" => 1
		))
             
         ->add("distance", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("bis 3 Meter"),
						2 => Translator::getInstance()->trans("von 3 bis 6 Meter"),
						3 => Translator::getInstance()->trans("Sonstige")
				),
				"label" => Translator::getInstance()->trans("Wegstrecke vom Innenteil zum Außenteil"),
				"label_attr" => array(
                    "for" => "gebaeudeart",
                ),
				"data" => 1
		))


		 ->add("image_upload", "file", array(
		"label" => Translator::getInstance()->trans("upload"),
		"label_attr" => array(
                    "for" => "upload"
                )
            
            /*,
		"disabled" => true*/
		))         
		        
		
		->add("anmerkungen", "text", array(
		"label" => Translator::getInstance()->trans("anmerkungen"),
		"label_attr" => array(
                    "for" => "anmerkungen"
                )/*,
		"disabled" => true*/
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
        return "klimaangebot";
    }
}
