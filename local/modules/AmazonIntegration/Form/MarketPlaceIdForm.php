<?php

namespace AmazonIntegration\Form;
use AmazonIntegration\AmazonIntegration;
use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Form\BaseForm;

class MarketPlaceIdForm extends BaseForm
{

    protected function buildForm()
    {
        $this->formBuilder
            ->add("marketplaceid", "text", [
                'constraints' => [
                    new NotBlank()
                ],
                'label' => $this->translator->trans('marketplaceid', [], AmazonIntegration::DOMAIN_NAME)
            ])
            ->add("marketplace", "text", [
                'constraints' => [
                    new NotBlank()
                ],
//                 'attr' => array('readonly' => true),
                'label' => $this->translator->trans('marketplace', [], AmazonIntegration::DOMAIN_NAME)
            ]);
    }
    
    public function getName()
    {
        return "addmarketplaceidform";
    }
}
