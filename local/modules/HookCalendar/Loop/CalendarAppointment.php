<?php
namespace HookCalendar\Loop;

use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Element\SearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Log\Tlog;
use HookCalendar\Model\Map\BookingsServicesTableMap;
use HookCalendar\Model\BookingsServicesQuery;
use Propel\Runtime\ActiveQuery\Criteria;

/**
 *
 * CalendarAppointment loop
 *
 * Class CalendarAppointment
 *
 * * @method int getCartItemId()
 * 
 * @package HookCalendar\Loop
 * @author Emanuel Plopu <emanuel.plopu@sepa.at>
 */
class CalendarAppointment extends BaseI18nLoop implements PropelSearchLoopInterface, SearchLoopInterface {
	protected $timestampable = true;
	
	/**
	 *
	 * @return ArgumentCollection
	 */
	protected function getArgDefinitions() {
		return new ArgumentCollection ( 
				Argument::createIntTypeArgument('cart_item_id'),
				Argument::createIntTypeArgument('order_id'),
				Argument::createIntTypeArgument('service_id'));
	}
	public function getSearchIn() {
		return [ 
				
		];
	}
	
	/**
	 *
	 * @param ProductQuery $search        	
	 * @param
	 *        	$searchTerm
	 * @param
	 *        	$searchIn
	 * @param
	 *        	$searchCriteria
	 */
	public function doSearch(&$search, $searchTerm, $searchIn, $searchCriteria) {
		$search->_and ();
		foreach ( $searchIn as $index => $searchInElement ) {
			if ($index > 0) {
				$search->_or ();
			}
			switch ($searchInElement) {
				case "ref" :
					$search->filterByRef ( $searchTerm, $searchCriteria );
					break;
				case "title" :
					$search->where ( "CASE WHEN NOT ISNULL(`requested_locale_i18n`.ID) THEN `requested_locale_i18n`.`TITLE` ELSE `default_locale_i18n`.`TITLE` END " . $searchCriteria . " ?", $searchTerm, \PDO::PARAM_STR );
					break;
			}
		}
	}
	public function parseResults(LoopResult $loopResult) {

		return $this->parseSimpleResults ( $loopResult );
	}
	
	public function parseSimpleResults(LoopResult $loopResult) {
		$log = Tlog::getInstance ();
		
		/** @var \Thelia\Core\Security\SecurityContext $securityContext */
		$securityContext = $this->container->get ( 'thelia.securityContext' );
		
		/** @var \Thelia\Model\Product $product */
		foreach ( $loopResult->getResultDataCollection () as $bookingService ) {
			
			$loopResultRow = new LoopResultRow ( $bookingService );

            $this->addOutputFields ( $loopResultRow, $bookingService );
			
			$loopResult->addRow ( $this->associateValues ( $loopResultRow, $bookingService) );
		}
		
		return $loopResult;
	}
	
	/**
	 *
	 * @param LoopResultRow $loopResultRow
	 *        	the current result row
	 * @param \Thelia\Model\Product $product        	
	 * @param
	 *        	$default_category_id
	 * @return mixed
	 */
	private function associateValues($loopResultRow, $bookingsService) {
		$log = Tlog::getInstance ();
		//$log->debug ( " innerjoinprod " .$product->getUrl ( $this->locale ) );
		//$log->debug ( " URLpath " . implode ( "|", $product->getVirtualColumns () ) );
	//	$montage = MontageQuery::create()->findById($product->getVirtualColumn('montage_id'));
		//$bookingsService = new BookingsServices();
		$loopResultRow
		->set ( "ID", $bookingsService->getId() )
		->set ( "TMP_HASH", $bookingsService->getTmpHash() )
		->set ( "BOOKING_ID", $bookingsService->getBookingId() )
		->set ( "CUSTOMER_ID", $bookingsService->getCustomerId() )
		->set ( "CART_ITEM_ID", $bookingsService->getCartItemId() )
		->set ( "SERVICE_ID", $bookingsService->getServiceId() )
		->set ( "EMPLOYEE_ID", $bookingsService->getEmployeeId() )
		->set ( "BOOKING_DATE", $bookingsService->getDate() )
		->set ( "BOOKING_TIME", $bookingsService->getStart() )
		->set ( "BOOKING_START_TS", $bookingsService->getStartTs() )
		->set ( "BOOKING_STOP_TS", $bookingsService->getStopTs() )
		->set ( "REMINDER_EMAIL", $bookingsService->getReminderEmail() )
		->set ( "REMINDER_SMS", $bookingsService->getReminderSms() );

		return $loopResultRow;
	}
	
	public function buildModelCriteria() {

		$log = Tlog::getInstance ();
		 
		//$request = $this->getCurrentRequest();
		
		$currentCustomer = $this->securityContext->getCustomerUser();
		if($currentCustomer == null)
			$currentCustomer	= 0;//$this->getCurrentRequest()->getSession()->getId();
		else $currentCustomer = $currentCustomer->getId();
		
		$log->error(" building modelCriteria for ".BookingsServicesTableMap::TABLE_NAME);
		
		$search = BookingsServicesQuery::create();
		
		$cart_item_id = $this->getCartItemId();
		$order_id = $this->getOrderId();
		$service_id = $this->getServiceId();
		
		$conditionsArray = array();
		
		if($cart_item_id != null){
			$search->condition('cart_item','cart_item_id = ?',$cart_item_id,\PDO::PARAM_INT);
			array_push($conditionsArray,"cart_item");
		}
			
		if($order_id != null){
			$search->condition('order','order_id = ?',$order_id,\PDO::PARAM_INT);
			array_push($conditionsArray,"order");
		}
		
		if($service_id != null){
			$search->condition('service','service_id = ?',$service_id,\PDO::PARAM_INT);
			array_push($conditionsArray,"service");
		}
		
		$log->error(" conditions ".implode(" ",$conditionsArray));
		
		$search->where( $conditionsArray, Criteria::LOGICAL_AND);

		return $search;
	}
}
