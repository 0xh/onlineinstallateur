<?php

namespace PageBuilder\Form;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;
use Symfony\Component\Validator\Constraints;

class PageBuilderUpdateForm extends BaseForm
{
    /**
     *  Form build for add and update a page builder
     */
    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                'page_builder_id',
                'text',
                array(
                    "constraints"   => array(
                        new Constraints\NotBlank()
                    ),
                "label"         => 'PageBuilder reference',
                "required"      => false,
                "read_only"     => true,
                )
            )
            ->add(
                'page_builder_title',
                'text',
                array(
                    "constraints"   => array(
                        new Constraints\NotBlank()
                    ),
                "label"         => Translator::getInstance()->trans('Title'),
                "required"      => false,
                )
            )
            ->add(
                'page_builder_chapo',
                TextareaType::class,
                array(
                    'attr'          => array('class' => 'tinymce'),
                    "constraints"   => array(
                    ),
                "label"         =>Translator::getInstance()->trans('Summary'),
                "required"      => false,
                )
            )
            ->add(
                'page_builder_header',
                TextareaType::class,
                array(
                    'attr'          => array('class' => 'tinymce'),
                    "constraints"   => array(
                    ),
                "label"         =>Translator::getInstance()->trans('Header'),
                "required"      => false,
                )
            )
            ->add(
                'page_builder_footer',
                TextareaType::class,
                array(
                    'attr'          => array('class' => 'tinymce'),
                    "constraints"   => array(
                    ),
                "label"         =>Translator::getInstance()->trans('Footer'),
                "required"      => false,
                )
            )
            ->add(
                'page_builder_postscriptum',
                TextareaType::class,
                array(
                    'attr'          => array('class' => 'tinymce'),
                    "constraints"   => array(
                    ),
                "label"         => Translator::getInstance()->trans('Conclusion'),
                "required"      => false,
                )
            )
            ->add(
                'save_mode',
                SubmitType::class,
                array(
                    'attr'          => array('class' => 'save'),
                    'label'         =>'save',
                    )
            )
            ->add(
                'save_mode',
                SubmitType::class,
                array(
                    'attr'          => array('class' => 'save_and_close'),
                    'label'         =>'save_and_close'
                    )
            );
    }

    /**
     * @return string the name of the form. This name need to be unique.
     */
    public function getName()
    {
        return "admin_page_builder_update";
    }
}
