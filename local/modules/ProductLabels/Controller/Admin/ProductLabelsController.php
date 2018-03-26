<?php


namespace ProductLabels\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Event\TheliaEvents;
use OfferCreation\Model\OfferQuery;
use OfferCreation\Model\OfferProductQuery;
use OfferCreation\Model\OfferProductTaxQuery;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Thelia\Tools\URL;
use Thelia\Core\Event\PdfEvent;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Log\Tlog;
use Thelia\Model\MessageQuery;
use Thelia\Exception\TheliaProcessException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductLabelsController extends BaseAdminController
{
    public function generateLabelsTabAction(){
        $barcode = new Barcode(1349875921348, 4);
         return $this->render('product-labels',array("product" => array("product_title"=>"title","product_price"=>"price"))
//             ,array("small_template" => "small_template",
//                 "medium_template" => $this->renderRaw("medium_template"),
//                 "large_template" => $this->getParser()->render("large_template")
//             )
);
    }
    
    public function previewAsHtmlAction($messageId)
    {
        if (null !== $response = $this->checkAuth(AdminResources::MESSAGE, [], AccessManager::VIEW)) {
            return $response;
        }
        
        if (null === $message = MessageQuery::create()->findPk($messageId)) {
            $this->pageNotFound();
        }
        Tlog::getInstance()->error("ProductLabels info ".$message);
        $parser = $this->getParser($this->getTemplateHelper()->getActiveMailTemplate());
        
            $content = $message->setLocale($this->getCurrentEditionLocale())->getHtmlMessageBody($parser);
        Tlog::getInstance()->error("ProductLabels info ".$content);
        return "bbb"."bb";
    }

}
