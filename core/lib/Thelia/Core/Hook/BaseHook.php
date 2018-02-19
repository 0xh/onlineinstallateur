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

namespace Thelia\Core\Hook;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Core\HttpFoundation\Session\Session;
use Thelia\Core\Template\Assets\AssetResolverInterface;
use Thelia\Core\Template\ParserInterface;
use Thelia\Model\Cart;
use Thelia\Model\Currency;
use Thelia\Model\Customer;
use Thelia\Model\Lang;
use Thelia\Model\Order;
use Thelia\Module\BaseModule;

/**
 * The base class for hook. If you provide hooks in your module you have to extends
 * this class.
 *
 * These class provides some helper functions to retrieve object from the current session
 * of the current user. It also provides a render function that allows you to get the right
 * template file from different locations and allows you to override templates in your current
 * template.
 *
 * Class BaseHook
 * @package Thelia\Core\Hook
 * @author  Julien Chanséaume <jchanseaume@openstudio.fr>
 */
abstract class BaseHook
{
    const INJECT_TEMPLATE_METHOD_NAME = "insertTemplate";

    /** @var BaseModule */
    public $module = null;

    /** @var array list of templates automatically injected */
    protected $templates = [];

    /** @var \Thelia\Core\Template\ParserInterface */
    public $parser = null;

    /** @var TranslatorInterface $translator */
    public $translator = null;

    /** @var AssetResolverInterface $assetsResolver */
    public $assetsResolver = null;

    /** @var EventDispatcherInterface  */
    public $dispatcher = null;

    /** @var Request $request */
    protected $request = null;

    /** @var Session $session */
    protected $session = null;

    /** @var Customer $customer */
    protected $customer = null;

    /** @var Cart $cart */
    protected $cart = null;

    /** @var Order $order */
    protected $order = null;

    /** @var Lang $lang */
    protected $lang = null;

    /** @var Currency $currency */
    protected $currency = null;

    /**
     * This function is called when hook uses the automatic insert template.
     *
     * @param HookRenderEvent $event
     * @param string $code
     */
    public function insertTemplate(HookRenderEvent $event, $code)
    {
        if (array_key_exists($code, $this->templates)) {
            $templates = explode(';', $this->templates[$code]);

            foreach ($templates as $template) {
                list($type, $filepath) = $this->getTemplateParams($template);

                if ("render" === $type) {
                    $event->add($this->render($filepath, $event->getArguments()));
                    continue;
                }

                if ("dump" === $type) {
                    $event->add($this->render($filepath));
                    continue;
                }

                if ("css" === $type) {
                    $event->add($this->addCSS($filepath));
                    continue;
                }

                if ("js" === $type) {
                    $event->add($this->addJS($filepath));
                    continue;
                }

                if (method_exists($this, $type)) {
                    $this->{$type}($filepath, $event->getArguments());
                }
            }
        }
    }

    /**
     * helper function allowing you to render a template using a template engine
     *
     * @param string $templateName the template path of the template
     * @param array  $parameters   an array of parameters to assign to a template engine
     *
     * @return string the content generated by a template engine
     */
    public function render($templateName, array $parameters = array())
    {
        $templateDir = $this->assetsResolver->resolveAssetSourcePath($this->module->getCode(), false, $templateName, $this->parser);

        if (null !== $templateDir) {
            // retrieve the template
            $content      = $this->parser->render($templateDir . DS . $templateName, $parameters);
        } else {
            $content = sprintf("ERR: Unknown template %s for module %s", $templateName, $this->module->getCode());
        }

        return $content;
    }

    /**
     * helper function allowing you to get the content of a file
     *
     * @param string $fileName the template path of the template
     *
     * @return string the content of the file
     */
    public function dump($fileName)
    {
        $fileDir = $this->assetsResolver->resolveAssetSourcePath($this->module->getCode(), false, $fileName, $this->parser);

        if (null !== $fileDir) {
            $content = file_get_contents($fileDir . DS . $fileName);
            if (false === $content) {
                $content = "";
            }
        } else {
            $content = sprintf("ERR: Unknown file %s for module %s", $fileName, $this->module->getCode());
        }

        return $content;
    }

    /**
     * helper function allowing you to generate the HTML link tag
     *
     * @param string $fileName   the path to the css file
     * @param array  $attributes the attributes of the tag
     * @param array  $filters an array of assets processing filters (less, sass, etc.)
     *
     * @return string the link tag
     */
    public function addCSS($fileName, $attributes = [], $filters = [])
    {
        $tag = "";

        $url = $this->assetsResolver->resolveAssetURL($this->module->getCode(), $fileName, "css", $this->parser, $filters);

        if ("" !== $url) {
            $tags   = array();
            $tags[] = '<link rel="stylesheet" type="text/css" ';
            $tags[] = ' href="' . $url . '" ';
            foreach ($attributes as $name => $val) {
                if (is_string($name) && !in_array($name, [ "href", "rel", "type" ])) {
                    $tags[] = $name . '="' . $val . '" ';
                }
            }
            $tags[] = "/>";
            $tag    = implode($tags);
        }

        return $tag;
    }

    /**
     * helper function allowing you to generate the HTML script tag
     *
     * @param string $fileName   the path to the js file
     * @param array  $attributes the attributes of the tag
     * @param array  $filters an array of assets processing filters (cofeescript, compress, etc.)
     *
     * @return string the script tag
     */
    public function addJS($fileName, $attributes = array(), $filters = [])
    {
        $tag = "";

        $url = $this->assetsResolver->resolveAssetURL($this->module->getCode(), $fileName, "js", $this->parser, $filters);

        if ("" !== $url) {
            $tags   = array();
            $tags[] = '<script type="text/javascript" ';
            $tags[] = ' src="' . $url . '" ';
            foreach ($attributes as $name => $val) {
                if (is_string($name) && !in_array($name, [ "src", "type" ])) {
                    $tags[] = $name . '="' . $val . '" ';
                }
            }
            $tags[] = "></script>";
            $tag    = implode($tags);
        }

        return $tag;
    }

    /**
     * @param \Thelia\Module\BaseModule $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * @return \Thelia\Module\BaseModule
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param \Thelia\Core\Template\ParserInterface $parser
     */
    public function setParser(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @return \Thelia\Core\Template\ParserInterface
     */
    public function getParser()
    {
        return $this->parser;
    }

    /**
     * Translates the given message.
     *
     * @param string $id         The message id (may also be an object that can be cast to string)
     * @param array  $parameters An array of parameters for the message
     * @param string $domain     The domain for the message
     * @param string $locale     The locale
     *
     * @return string The translated string
     *
     * @api
     */
    protected function trans($id, array $parameters = array(), $domain = null, $locale = null)
    {
        return $this->translator->trans($id, $parameters, $domain, $locale);
    }

    /**
     * get the request
     *
     * @return Request
     */
    protected function getRequest()
    {
        if (null === $this->request) {
            $this->request = $this->getParser()->getRequest();
        }

        return $this->request;
    }

    /**
     * get the session
     *
     * @return Session
     */
    protected function getSession()
    {
        if (null === $this->session) {
            if (null !== $this->getRequest()) {
                $this->session = $this->request->getSession();
            }
        }

        return $this->session;
    }

    /**
     * Get the view argument for the request.
     *
     * It allows you to identify the page currently displayed. eg: index, category, ...
     *
     * @return string the current view
     */
    protected function getView()
    {
        $ret = "";
        if (null !== $this->getRequest()) {
            $ret = $this->getRequest()->attributes->get("_view", "");
        }

        return $ret;
    }

    /**
     * Get the cart from the session
     *
     * @return \Thelia\Model\Cart|null
     */
    protected function getCart()
    {
        if (null === $this->cart) {
            $this->cart = $this->getSession() ? $this->getSession()->getSessionCart($this->dispatcher) : null;
        }

        return $this->cart;
    }

    /**
     * Get the order from the session
     *
     * @return \Thelia\Model\Order|null
     */
    protected function getOrder()
    {
        if (null === $this->order) {
            $this->order = $this->getSession() ? $this->getSession()->getOrder() : null;
        }

        return $this->order;
    }

    /**
     * Get the current currency used or if not present the default currency for the shop
     *
     * @return \Thelia\Model\Currency
     */
    protected function getCurrency()
    {
        if (null === $this->currency) {
            $this->currency = $this->getSession() ? $this->getSession()->getCurrency(true) : Currency::getDefaultCurrency();
        }

        return $this->currency;
    }

    /**
     * Get the current customer logged in. If no customer is logged return null
     *
     * @return \Thelia\Model\Customer|null
     */
    protected function getCustomer()
    {
        if (null === $this->customer) {
            $this->customer = $this->getSession() ? $this->getSession()->getCustomerUser() : null;
        }

        return $this->customer;
    }

    /**
     * Get the current lang used or if not present the default lang for the shop
     *
     * @return \Thelia\Model\Lang
     */
    protected function getLang()
    {
        if (null === $this->lang) {
            $this->lang = $this->getSession() ? $this->getSession()->getLang(true) : $this->lang = Lang::getDefaultLanguage();
        }

        return $this->lang;
    }

    /**
     * Add a new template for automatic render
     *
     * @param string $hookCode the code of the hook (the name of the event used to render) : 'hook.{type}.{hook code}'
     * @param string $value list of the template to render or add.
     *                      eg: 'render:mytemplate.html;css:assets/css/mycss.css;js:assets/js/myjs.js'
     */
    public function addTemplate($hookCode, $value)
    {
        if (array_key_exists($hookCode, $this->templates)) {
            throw new \InvalidArgumentException(sprintf("The hook '%s' is already used in this class.", $hookCode));
        }

        $this->templates[$hookCode] = $value;
    }

    /**
     * @return array templates
     */
    public function getTemplates()
    {
        return $this->templates;
    }

    /**
     * @param $template
     * @return array
     */
    protected function getTemplateParams($template)
    {
        $templateParams = explode(':', $template);

        if (count($templateParams) > 1) {
            $type = $templateParams[0];
            $filepath = $templateParams[1];
        } else {
            $type = 'render';
            $filepath = $templateParams[0];
        }

        return [$type, $filepath];
    }
}
