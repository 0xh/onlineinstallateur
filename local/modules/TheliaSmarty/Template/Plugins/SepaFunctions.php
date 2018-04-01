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

namespace TheliaSmarty\Template\Plugins;

use Thelia\Core\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RequestStack;
use TheliaSmarty\Template\AbstractSmartyPlugin;
use TheliaSmarty\Template\SmartyPluginDescriptor;

/**
 *
 * format_date and format_date smarty function.
 *
 * Class Format
 * @package Thelia\Core\Template\Smarty\Plugins
 * @author Manuel Raynaud <manu@raynaud.io>
 * @author Benjamin Perche <benjamin@thelia.net>
 */
class SepaFunctions extends AbstractSmartyPlugin
{
    
    /** @var RequestStack */
    protected $requestStack;
    
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    
    /**
     * Smarty choptext modifier plugin
     *
     * Type: modifier<br>
     * Name: choptext<br>
     * Date: Nov 9, 2005
     * Purpose: chop up a string of text
     * Input: string to chop
     * Example: {$var|choptext:32:" "}
     * @author Monte Ohrt <monte at ohrt dot com>
     * @version 1.0
     * @param string
     * @param string
     * @return string
     */
    function smarty_modifier_choptext($string, $length=32, $insert_char=' ')
    {
        return preg_replace("!(?:^|\s)([\w\!\?\.]{" . $length . ",})(?:\s|$)!e",'chunk_split("\\1",' . $length . ',"' . $insert_char. '")',$string);
    } 
    
    /**
     * @return SmartyPluginDescriptor[]
     */
    public function getPluginDescriptors()
    {
        return array(
            new SmartyPluginDescriptor("function", "choptext", $this, "smarty_modifier_choptext"),
        );
    }
}
