<?php
namespace FilterConfigurator\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Model\FeatureAvI18nQuery;
use FilterConfigurator\FilterConfigurator;

class FeatureAvController extends BaseAdminController 
{
	public function updateAction() {
		
		$feature_av_id = $this->getRequest()->get("feature_av_id");
		$feature_id = $this->getRequest()->get("feature_id");
		
		return $this->render("update-feature-av", array(
				"feature_av_id" => $feature_av_id,
				"feature_id" => $feature_id
		));
	}
	
	public function saveAction() {
		
		$form = $this->createForm("attributeav.modification");
		
		try {
			$data = $this->validateForm($form)->getData();
		
			$featureAv = FeatureAvI18nQuery::create()
				->filterById($data["id"])
				->filterByLocale($data["locale"])
				->findOneOrCreate();
			
			if (null === $featureAv) {
				throw new \Exception($this->getTranslator()->trans("feature av doesn't exist"), array(), FilterConfigurator::DOMAIN_NAME);
			}
			
			$featureAv
				->setTitle($data["title"])
				->setChapo($data["chapo"])
				->setDescription($data["description"])
				->setPostscriptum($data["postscriptum"])
				->setLocale($data["locale"])
				->save();
			
			return $this->generateSuccessRedirect($form);
		} catch (\Exception $e) {
			$this->setupFormErrorContext(
					$this->getTranslator()->trans("Error updating feature av : %message", ["message"=>$e->getMessage()], FilterConfigurator::DOMAIN_NAME),
					$e->getMessage(),
					$form
					);
			
			return self::viewAction();
		}
	}
	
}