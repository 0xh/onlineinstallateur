<?php

namespace Selection\Form;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Thelia\Form\BaseForm;
use Symfony\Component\Validator\Constraints;

class SelectionCreateForm extends BaseForm
{

    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                'selection_title',
                'text',
                array(
                    "constraints"   => array(
                        new Constraints\NotBlank()
                    ),
                    "label"         => 'Title',
                )
            )
            ->add(
                'selection_chapo',
                TextareaType::class,
                array(
                    "constraints"   => array(
                    ),
                    "label"         =>'Summary',
                )
            )
            ->add(
                'selection_header',
                TextareaType::class,
                array(
                    'attr'          => array('class' => 'tinymce'),
                    "constraints"   => array(
                    ),
                    "label"         =>'Header',
                )
            )
            ->add(
                'selection_footer',
                TextareaType::class,
                array(
                    'attr'          => array('class' => 'tinymce'),
                    "constraints"   => array(
                    ),
                    "label"         =>'Footer',
                )
            )
            ->add(
                'selection_postscriptum',
                TextareaType::class,
                array(
                    "constraints"   => array(
                    ),
                    "label"         =>'Conclusion',
                )
            )
            ->add(
                'save',
                SubmitType::class,
                array(
                    'attr'          => array('class' => 'save'),
                    'label'         =>'Save'
                )
            );
    }

    /**
     * @return string the name of the form. This name need to be unique.
     */
    public function getName()
    {
        return "admin_selection_create";
    }
}
