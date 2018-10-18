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

namespace RevenueDashboard\Action;

use RevenueDashboard\Events\RevenueDashboardBrandEvent;
use RevenueDashboard\Events\RevenueDashboardBrandEvents;
use RevenueDashboard\Events\RevenueDashboardCategoryEvent;
use RevenueDashboard\Events\RevenueDashboardCategoryEvents;
use RevenueDashboard\Model\WholesalePartnerBrandMatchingQuery;
use RevenueDashboard\Model\WholesalePartnerCategoryMatchingQuery;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Log\Tlog;

class RevenueDashboardAction implements EventSubscriberInterface
{

    /**
     * Returns an object of event names this subscriber wants to listen to.
     * The class can either return an RevenueDashboardBrandEvent or a  RevenueDashboardCategoryEvent
     * based on what event is called in the method. The first object type returns an object of the
     * wholesale_partner_brand_matching table. The second object type returns an object of the
     * wholesale_partner_category_matching table
     *
     * @param event $RevenueDashboardBrandEvent To be used with an instantion of eventDispatcher,
     * event instantiation (RevenueDashboardBrandEvent), setter (setBrand_extern()) and dispatch event
     *
     * *$eventDispatcher = $this->getContainer()->get('event_dispatcher');
     * *$createEvent = new RevenueDashboardBrandEvent();
     * *$createEvent->setBrand_extern("BOODHEAHEA");
     * *$eventDispatcher->dispatch(RevenueDashboardBrandEvents::FINDBRAND, $createEvent);
     * *
     * @param event $RevenueDashboardCategoryEvent To be used as brand but with appropriate methods.
     *
     * @return object based on input event.
     *
     */
    public static function getSubscribedEvents()
    {
        return [
         RevenueDashboardBrandEvents::FINDBRAND       => ["findBrandRef", 128],
         RevenueDashboardCategoryEvents::FINDCATEGORY => ["findCategory", 128]
        ];
    }

    public function findBrandRef(RevenueDashboardBrandEvent $event)
    {
        $brandMatchingQuery = WholesalePartnerBrandMatchingQuery::create();

        $response = $brandMatchingQuery
         ->findOneByBrandExtern($event->getBrand_extern());

        if ($response != null) {
            $event->setBrandMatch($response);
        }
    }

    public function findCategory(RevenueDashboardCategoryEvent $event)
    {
        $categoryMatchingQuery = WholesalePartnerCategoryMatchingQuery::create();

        $responseById = null;
        if ($event->getExtern_id() !== null) {

            $responseById = $categoryMatchingQuery
             ->findOneByCategoryExternId($event->getExtern_id());
        }

        $responseByName = null;
        if ($event->getExtern_name() !== null) {

            $responseByName = $categoryMatchingQuery
             ->findOneByCategoryExternName($event->getExtern_name());
        }


        if ($responseByName != null) {
            $event->setCategoryMatch($responseByName);
        }
        if ($responseById != null) {
            $event->setCategoryMatch($responseById);
        }
    }

}
