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
//use Symfony\Component\Validator\Constraints;
//use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class KlimaBerechnung extends BaseForm
{
	private $formLabels ;
	
	public function getLabel($field,$choice = null){
		if($choice == null)
			return $this->formLabels[$field];
		else 
			return $this->formLabels[$field.$choice];
	}
	
	private function setLabel($field,$choice,$label){
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
         
         //grundfläche in m2 für jede Raum bis $max_raum
         ->add('grundflaeche', 'collection', array(
         		'entry_type'         => NumberType::class,
         		'label'        => Translator::getInstance()->trans('Grundfläche des Räumes'),
         		'label_attr'   => array('for' => 'grundflaeche'),
         		'allow_add'    => true,
         		'allow_delete' => true,/*
         		"constraints" => array(
         				new Callback(array(
         						"methods" => array(array($this, "checkAttributeAv")),
         				)),
         		)*/
         		'data' => array(1,2,3,4,5,6,7,8)
         ))
         //höhe von alle räumen
         ->add("raumhoehe", "integer", array(
         		"label" => Translator::getInstance()->trans("Raumhöhe"),
         		"label_attr" => array(
         				"for" => "raumhoehe"
         		),
         		"data" => 3
         ))
         //fenster fläche für jede Raum bis $max_raum
         ->add('fenster', CollectionType::class, array(
         		'entry_type'         => NumberType::class,
         		'label'        => Translator::getInstance()->trans('Fenster (mit Innenjalousie) der Sonne ausgesetzt'),
         		'label_attr'   => array('for' => 'fenster'),
         		'allow_add'    => true,
         		'allow_delete' => true,
         		'data' => array(1,2,3,4,5,6,7,8)
         ))
          
         ->add('decke', ChoiceType::class, array(
         				'choices' => array (
         						1 => Translator::getInstance()->trans("Nicht klimatisierter Raum"),
         						2 => Translator::getInstance()->trans("Dachboden"),
         						3 => Translator::getInstance()->trans("Isoliertes Flachdach"),
         				),
         		'label'        => Translator::getInstance()->trans('Lage der Zimmer - Decke'),
         		'label_attr'   => array('for' => 'decke'),
         ))
         
         
         
         
         
         
         
         
         
         
         
         ->add('personen', CollectionType::class, array(
         		'entry_type'         => NumberType::class,
         		'label'        => Translator::getInstance()->trans('Wie viele Personen halten sich dauerhaft im Raum auf?'),
         		'label_attr'   => array('for' => 'personen'),
         		'allow_add'    => true,
         		'allow_delete' => true,
         		'data' => array(1,1,1,1,1,1,1,1)
         ))   
         ->add('zusaetzliche_waerme', CollectionType::class, array(
         		'entry_type'         => NumberType::class,
         		'label'        => Translator::getInstance()->trans('Anschlusswert in Watt von elektrischen Geräten und der Beleuchtung (TV, PC, Kühlschrank, Lampen etc.)'),
         		'label_attr'   => array('for' => 'zusaetzliche_waerme'),
         		'allow_add'    => true,
         		'allow_delete' => true,
         		'data' => array(200,200,200,200,200,200,200,200)
         ))         
         ->add('wegstrecke', CollectionType::class, array(
         		'entry_type'         => NumberType::class,
         		'label'        => Translator::getInstance()->trans('Innenteil für Raum:'),
         		'label_attr'   => array('for' => 'wegstrecke'),
         		'allow_add'    => true,
         		'allow_delete' => true,
         		'data' => array(2,2,2,2,2,2,2,2)
         ))
         
         
         ->add("kondensatablauf", "choice", array(
         		"choices" => array (
         				1 => Translator::getInstance()->trans("Gefälle"),
         				2 => Translator::getInstance()->trans("Pumpe")
         		),
         		"label" => Translator::getInstance()->trans("Kondensatablauf mit"),
         		"label_attr" => array(
         				"for" => "Pumpe",
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
         		"label" => Translator::getInstance()->trans("Montage des Außenteils:"),
         		"label_attr" => array(
         				"for" => "montage-aussenteil",
         		),
         		"data" => 1
         ))
         ->add("stromanschluss", "choice", array(
         		"choices" => array (
         				1 => Translator::getInstance()->trans("Stromanschluss ist Bauseits vorhanden"),
         				2 => Translator::getInstance()->trans("Stromanschluss ist herzustellen")
         
         		),
         		"label" => Translator::getInstance()->trans("Stromanschluss Außenteil:"),
         		"label_attr" => array(
         				"for" => "stromanschluss",
         		),
         		"data" => 1
         ))
         
         ->add("anmerkungen", "text", array(
         		"label" => Translator::getInstance()->trans("Anmerkungen"),
         		"label_attr" => array(
         				"for" => "anmerkungen"
         		)/*,
         		"disabled" => true*/
         ))
         
             /*
     		->add("grundflaeche", "integer", array(
				"label" => Translator::getInstance()->trans("Grundfläche des Räumes"),
				"label_attr" => array(
						"for" => "grundflaeche"
				),
				"data" => 10
		))
             
            ->add("raumhoehe", "integer", array(
				"label" => Translator::getInstance()->trans("Raumhöhe"),
				"label_attr" => array(
						"for" => "raumhoehe"
				),
				"data" => 3
		))
            ->add("fenster", "integer", array(
				"label" => Translator::getInstance()->trans("Fenster (mit Innenjalousie) der Sonne ausgesetzt"),
				"label_attr" => array(
						"for" => "fenster"
				),
				"data" => 2
		))

             
         ->add("personen", "integer", array(
				"label" => Translator::getInstance()->trans("Wie viele Personen halten sich dauerhaft im Raum auf?"),
				"label_attr" => array(
						"for" => "personen"
				),
				"data" => 1
		))
             
        ->add("zusaetzliche_waerme", "integer", array(
				"label" => Translator::getInstance()->trans("Anschlusswert in Watt von elektrischen Geräten und der Beleuchtung (TV, PC, Kühlschrank, Lampen etc.)"),
				"label_attr" => array(
						"for" => "zusaetzliche_waerme"
				),
				"data" => 200
		))
         ->add("wegstrecke", "integer", array(
				"label" => Translator::getInstance()->trans("Innenteil für Raum:"),
				"label_attr" => array(
						"for" => "wegstrecke"
				),
				"data" => 2
		))
         ->add("kondensatablauf", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("Gefälle"),
						2 => Translator::getInstance()->trans("Pumpe")
				),
				"label" => Translator::getInstance()->trans("Kondensatablauf mit"),
				"label_attr" => array(
						"for" => "Pumpe",
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
				"label" => Translator::getInstance()->trans("Montage des Außenteils:"),
				"label_attr" => array(
                    "for" => "montage-aussenteil",
                ),
				"data" => 1
		))
		->add("stromanschluss", "choice", array(
				"choices" => array (
						1 => Translator::getInstance()->trans("Stromanschluss ist Bauseits vorhanden"),
						2 => Translator::getInstance()->trans("Stromanschluss ist herzustellen")
						
				),
				"label" => Translator::getInstance()->trans("Stromanschluss Außenteil:"),
				"label_attr" => array(
                    "for" => "stromanschluss",
                ),
				"data" => 1
		))

		->add("anmerkungen", "text", array(
		"label" => Translator::getInstance()->trans("Anmerkungen"),
		"label_attr" => array(
                    "for" => "anmerkungen"
                )/*,
		"disabled" => true
		))*/
		;
    }

    public function getName()
    {
        return "klimakonfigurator";
    }
}
