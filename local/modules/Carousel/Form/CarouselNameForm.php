<?php

/* * ********************************************************************************** */
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/* * ********************************************************************************** */

namespace Carousel\Form;

use Carousel\Carousel;
use Thelia\Form\BaseForm;
use Thelia\Log\Tlog;

/**
 * Class CarouselNameForm
 * @package Carousel\Form
 * @author manuel raynaud <mraynaud@openstudio.fr>
 */
class CarouselNameForm extends BaseForm
{

    /**
     * @inheritdoc
     */
    protected function buildForm()
    {
        $this->formBuilder
         ->add("name", "text", [
          'constraints' => [
          ],
          'label'       => $this->translator->trans('Carousel name', [], Carousel::DOMAIN_NAME)
         ])->add("template", "text", [
         'constraints' => [
         ],
         'label'       => $this->translator->trans('Carousel template', [], Carousel::DOMAIN_NAME)
        ]);
    }

    /**
     * @return string the name of you form. This name must be unique
     */
    public function getName()
    {
        return 'carousel_name';
    }

}
