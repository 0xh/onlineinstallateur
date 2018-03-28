<?php

namespace BackOffice\Controller\Admin;

use BackOffice\BackOffice;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Model\ConfigQuery;
use Thelia\Model\OrderQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Event\PdfEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Log\Tlog;

class OrderController extends BaseAdminController
{	
    public function viewAction()
    {
        return $this->render('export-orders');
    }

    public function getFile()
    {

        $form = $this->createForm("export.order.pdf.form");

        try {
            $data = $this->validateForm($form)->getData();

            $browser = 0;
            $date_start = date_create($data['datepickerCreatedAfter']);
            $date_end = date_create($data['datepickerCreatedBefore'].' 23:59:59');
 
            $orderIds = OrderQuery::create()
                ->filterByInvoiceDate(date_format($date_start,"Y-m-d H:i:s"), Criteria::GREATER_EQUAL)
                ->filterByInvoiceDate(date_format($date_end,"Y-m-d H:i:s"), Criteria::LESS_EQUAL)
                ->select('id')
                ->find();
            
            return $this->generateBackOfficeOrderPdf( $orderIds->getData(), ConfigQuery::read('pdf_orders_file', 'orders'), $browser);

        } catch (\Exception $e) {
            $this->setupFormErrorContext(
                $this->getTranslator()->trans("Error on new location : %message", ["message"=>$e->getMessage()], BackOffice::DOMAIN_NAME),
                $e->getMessage(),
                $form
            );

            return self::viewAction();
        }
    }

    private function generateBackOfficeOrderPdf( $orderIds, $fileName, $browser)
    {
    	Tlog::getInstance()->error("theliaorders ".$fileName);
        if (null === $response = $this->generateOrderPdfByDate( $orderIds, $fileName, true, true, $browser)) {
            return $this->generateRedirectFromRoute(
                "admin.order.update.view",
                [],
                ['orderIds' =>  $orderIds ]
            );
        }

        return $response;
    }
    

    protected function generateOrderPdfByDate($orderIds, $fileName, $checkOrderStatus = true, $checkAdminUser = true, $browser = false)
    {
      
        $html = $this->renderRaw(
            $fileName,
            array(
                'orderIds' => $orderIds
            ),
            $this->getTemplateHelper()->getActivePdfTemplate()
        );

        try {
            $pdfEvent = new PdfEvent($html);

            $this->dispatch(TheliaEvents::GENERATE_PDF, $pdfEvent);

            if ($pdfEvent->hasPdf()) {
                return $this->pdfResponse($pdfEvent->getPdf(), $fileName, 200, $browser);
            }
        } catch (\Exception $e) {
            Tlog::getInstance()->error(
                sprintf(
                    'error during generating orders invoice pdf with message "%s"',
                    $e->getMessage()
                )
            );
        }

        throw new TheliaProcessException(
            $this->getTranslator()->trans(
                "We're sorry, this PDF invoice is not available at the moment."
            )
        );
    }
}
