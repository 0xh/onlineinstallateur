<?php

namespace Carousel\Form;

use Carousel\Carousel;
use Symfony\Component\Validator\Constraints\Image;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;
use Thelia\Log\Tlog;

class CarouselHookForm extends BaseForm
{

    public function getName()
    {
        return 'carousel_hook';
    }

    protected function buildForm()
    {

        $this->formBuilder
         ->add("carousel_id", "number", ['label' => Translator::getInstance()->trans("Carousel for hook")])
         ->add("hook_code", "text", ['attr' => ['readonly' => 'readonly']])
         ->add("hook_id", "number");
    }

}
