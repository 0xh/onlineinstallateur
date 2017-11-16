<?php
/*************************************************************************************/
/*      This file is part of the GoogleTagManager package.                           */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace GoogleTagManager\Form;


use GoogleTagManager\GoogleTagManager;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

/**
 * Class Configuration
 * @package GoogleTagManager\Form
 * @author Tom Pradat <tpradat@openstudio.fr>
 */
class Configuration extends BaseForm
{
    protected function buildForm()
    {
        $form = $this->formBuilder;

        $valueCode = GoogleTagManager::getConfigValue('googletagmanager_trackingcode');
        $valueIframe = GoogleTagManager::getConfigValue('googletagmanager_trackingiframe');
        $form->add(
            "trackingcode",
            "text",
            array(
                'data'  => $valueCode,
                'label' => Translator::getInstance()->trans("Tracking Code",[] ,GoogleTagManager::DOMAIN_NAME),
                'label_attr' => array(
                    'for' => "trackingcode"
                ),
            )
        );
        $form->add(
            "trackingiframe",
            "text",
            array(
                'data'  => $valueIframe,
                'label' => Translator::getInstance()->trans("Tracking iFrame",[] ,GoogleTagManager::DOMAIN_NAME),
                'label_attr' => array(
                    'for' => "trackingiframe"
                ),
            )
            );
    }

    public function getName(){
        return 'googletagmanager';
    }
}