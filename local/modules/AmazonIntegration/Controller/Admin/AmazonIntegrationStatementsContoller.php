<?php

namespace AmazonIntegration\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use AmazonIntegration\Model\AmazonFinancialEventGroup;
use AmazonIntegration\Model\AmazonFinancialEventGroupQuery;
use AmazonIntegration\Model\Map\AmazonFinancialEventGroupTableMap;
use function Composer\Autoload\includeFile;
use Propel\Runtime\Propel;

class AmazonIntegrationStatementsContoller extends BaseAdminController {
	
	protected static $logger;

	public function getServiceForFinancialEventsAction() {
        include __DIR__ . '/../../Classes/API/src/MWSFinancesService/Samples/GetServiceStatusSample.php';

        $result = invokeGetServiceStatus($service, $request);
        //echo json_encode($result);

/*        echo "<pre> getServiceForFinancialEventsAction ";
        var_dump( $result );
*/
    }

    public function getAmazonListFinancialEventGroups(){

    }

	public function saveAmazonStatements(){
		
		/*self::getServiceForFinancialEventsAction();*/
		
		include __DIR__ . '/../../Classes/API/src/MWSFinancesService/Samples/ListFinancialEventsSample.php';

		$statemets = invokeListFinancialEvents($service, $request);
/*		echo "<pre>";
		var_dump( $statemets );
*/
	}

	public function saveAmazonListFinancialEventGroups(){
		include __DIR__ . '/../../Classes/API/src/MWSFinancesService/Samples/ListFinancialEventGroupsSample.php';
		
		$result = invokeListFinancialEventGroups($service, $request);

		/*$con = Propel::getConnection(AmazonFinancialEventGroupTableMap::DATABASE_NAME);
		$con->beginTransaction();*/

		foreach ($result->ListFinancialEventGroupsResult->FinancialEventGroupList as $i => $FinancialEventGroup) {
			//var_dump( $FinancialEventGroup );die();
			foreach ($FinancialEventGroup as $key => $FinancialEventGroupItem) {
				/*var_dump( $FinancialEventGroupItem );die();*/

				/*if( $FinancialEventGroupItem ){
					$FinancialEventGroupItemData = AmazonFinancialEventGroupQuery::create()->filterById($FinancialEventGroup->FinancialEventGroupId)->findOne();
	            	if ($FinancialEventGroupItemData) {
	            		//check for updates
	            	}
	            	else{
	            		$financialEventGroupId 		= isset($FinancialEventGroupItemData->FinancialEventGroupId)? $FinancialEventGroup->FinancialEventGroupId : 'missing_group_id';
	            		$processingStatus	   		= isset($FinancialEventGroupItemData->ProcessingStatus)? $FinancialEventGroup->ProcessingStatus : 'missing_processing_status';
	            		$fundTransferStatus			= isset($FinancialEventGroupItemData->FundTransferStatus)? $FinancialEventGroup->FundTransferStatus : 'missing_fundtransfer_status';
	            		$originalTotal				= isset($FinancialEventGroupItemData->OriginalTotal)? $FinancialEventGroup->OriginalTotal : '0.00';
	            		$convertedTotal				= isset($FinancialEventGroupItemData->ConvertedTotal)? $FinancialEventGroup->ConvertedTotal : '0.00';
	            		$fundTransferDate			= isset($FinancialEventGroupItemData->FundTransferDate)? $FinancialEventGroup->FundTransferDate : 0;
	            		$traceId					= isset($FinancialEventGroupItemData->TraceId)? $FinancialEventGroup->TraceId : 'missing_trace_id';
	            		$accountTail				= isset($FinancialEventGroupItemData->AccountTail)? $FinancialEventGroup->AccountTail : 'missing_accountTail';
	            		$beginningBalance			= isset($FinancialEventGroupItemData->BeginningBalance)? $FinancialEventGroup->BeginningBalance : '0.00';
	            		$financialEventGroupStart	= isset($FinancialEventGroupItemData->FinancialEventGroupStart)? $FinancialEventGroup->FinancialEventGroupStart : 0;
	            		$financialEventGroupEnd		= isset($FinancialEventGroupItemData->FinancialEventGroupEnd)? $FinancialEventGroup->FinancialEventGroupEnd : 0;
	            		
	            		$this->createAmazonFinancialEventGroup($financialEventGroupId, $processingStatus, $fundTransferStatus, $originalTotal, $convertedTotal, $fundTransferDate, $traceId, $accountTail, $beginningBalance, $financialEventGroupStart, $financialEventGroupEnd, $con);
	            	}
				}*/

						$financialEventGroupId 		= isset($FinancialEventGroupItem->FinancialEventGroupId)? $FinancialEventGroupItem->FinancialEventGroupId : 'missing_group_id';
	            		$processingStatus	   		= isset($FinancialEventGroupItem->ProcessingStatus)? $FinancialEventGroupItem->ProcessingStatus : 'missing_processing_status';
	            		$fundTransferStatus			= isset($FinancialEventGroupItem->FundTransferStatus)? $FinancialEventGroupItem->FundTransferStatus : 'missing_fundtransfer_status';
	            		$originalTotal				= isset($FinancialEventGroupItem->OriginalTotal)? $FinancialEventGroupItem->OriginalTotal->CurrencyAmount : '0.00';
	            		$convertedTotal				= isset($FinancialEventGroupItem->ConvertedTotal)? $FinancialEventGroupItem->ConvertedTotal->CurrencyAmount : '0.00';
	            		$fundTransferDate			= isset($FinancialEventGroupItem->FundTransferDate)? $FinancialEventGroupItem->FundTransferDate : 0;
	            		$traceId					= isset($FinancialEventGroupItem->TraceId)? $FinancialEventGroupItem->TraceId : 'missing_trace_id';
	            		$accountTail				= isset($FinancialEventGroupItem->AccountTail)? $FinancialEventGroupItem->AccountTail : 'missing_accountTail';
	            		$beginningBalance			= isset($FinancialEventGroupItem->BeginningBalance)? $FinancialEventGroupItem->BeginningBalance->CurrencyAmount : '0.00';
	            		$financialEventGroupStart	= isset($FinancialEventGroupItem->FinancialEventGroupStart)? $FinancialEventGroupItem->FinancialEventGroupStart : 0;
	            		$financialEventGroupEnd		= isset($FinancialEventGroupItem->FinancialEventGroupEnd)? $FinancialEventGroupItem->FinancialEventGroupEnd : 0;

				$this->createAmazonFinancialEventGroup($financialEventGroupId, $processingStatus, $fundTransferStatus, $originalTotal, $convertedTotal, $fundTransferDate, $traceId, $accountTail, $beginningBalance, $financialEventGroupStart, $financialEventGroupEnd);
			}
		}

		//$con->commit();

		/*echo "</br> -------------------";
		var_dump( $result->ListFinancialEventGroupsResult->FinancialEventGroupList );*/
	}

	public function createAmazonFinancialEventGroup($financialEventGroupId, $processingStatus, $fundTransferStatus, $originalTotal, $convertedTotal, $fundTransferDate, $traceId, $accountTail, $beginningBalance, $financialEventGroupStart, $financialEventGroupEnd){

/*var_dump($financialEventGroupId);
var_dump($processingStatus);
var_dump($fundTransferStatus);
var_dump($originalTotal);
var_dump($convertedTotal);
var_dump($fundTransferDate);
var_dump($traceId);
var_dump($accountTail);
var_dump($beginningBalance);
var_dump($financialEventGroupStart);
var_dump($financialEventGroupEnd);

*/

		$financialEventGroup = new AmazonFinancialEventGroup();

		$financialEventGroup 	-> setfinancialEventGroupId( $financialEventGroupId )
								-> setProcessingStatus( $processingStatus )
								-> setFundTransferStatus( $fundTransferStatus )
								-> setOriginalTotal( $originalTotal )
								-> setConvertedTotal( $convertedTotal )
								-> setFundTransferDate( $fundTransferDate )
								-> setTraceId( $traceId )
								-> setAccountTail( $accountTail )
								-> setBeginningBalance( $beginningBalance )
								-> setFinancialEventGroupStart ( $financialEventGroupStart )
								-> setFinancialEventGroupEnd ( $financialEventGroupEnd );

		$financialEventGroup->save();
	}
}