<?php
namespace FilterConfigurator\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use FilterConfigurator\FilterConfigurator;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Security\AccessManager;
use FilterConfigurator\Model\Configurator;
use FilterConfigurator\Model\ConfiguratorI18n;
use FilterConfigurator\Model\ConfiguratorImageQuery;
use FilterConfigurator\Model\ConfiguratorImageI18nQuery;

class FilterConfiguratorController extends BaseAdminController
{
	public function viewAction() {
		
		if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('FilterConfigurator'), AccessManager::VIEW)) {
			return $response;
		}
		
		return $this->render("filter-configurator");
	}
	
	public function createAction() {
		
		if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('FilterConfigurator'), AccessManager::VIEW)) {
			return $response;
		}
		
		return $this->render("filter-configurator-create");
	}
	
	public function saveAction() {
		
		if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('FilterConfigurator'), AccessManager::UPDATE)) {
			return $response;
		}
		
		$form = $this->createForm("filter.configurator");
		
		try {
			$data = $this->validateForm($form)->getData();
			
			$configurator =  new Configurator();
			
			$configurator
				->setVisible(1)
				->save();
			
			$configuratorI18n =  new ConfiguratorI18n();
			
			$configuratorI18n
				->setId($configurator->getId())
				->setLocale($data["locale"])
				->setTitle($data["title"])
				->setChapo($data["chapo"])
				->setDescription($data["description"])
				->save();
			
			return $this->generateSuccessRedirect($form);
		} catch (\Exception $e) {
			$this->setupFormErrorContext(
					$this->getTranslator()->trans("Error on new configurator : %message", ["message"=>$e->getMessage()], FilterConfigurator::DOMAIN_NAME),
					$e->getMessage(),
					$form
					);
			
			return self::viewAction();
		}
		
	}
	
	public function getImageFormAjaxAction($parentId, $parentType)
	{
		$args = array('imageType' => $parentType, 'parentId' => $parentId);
	
		return $this->render('includes/image-upload', $args);
	}
	
	public function toggleVisibilityImageAction($id)
	{
		$configurator =  ConfiguratorImageQuery::create()
							->filterByConfiguratorId($id)
							->findOne();
						
		if($configurator) {
			$configurator->setVisible($configurator->getVisible() ? 0 : 1)
				->save();
		}
	
		return $configurator->getVisible() ? 0 : 1;
	}
	
	public function updateImage($id)
	{
		$redirectUrl = '/admin/modules/filter-configurator/';
		
		return $this->render('includes/image-edit', array(
				'imageId' => $id,
				'imageType' => 'configurator',
				'redirectUrl' => $redirectUrl,
				'formId' => 'thelia.admin.product.image.modification',
				'breadcrumb' => ''
		));
	}
	
	public function saveImage($id) 
	{
		if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('FilterConfigurator'), AccessManager::UPDATE)) {
			return $response;
		}
		
		$form = $this->createForm("filter.configurator.image");
		
		try {
			$data = $this->validateForm($form)->getData();

			$confImage = ConfiguratorImageQuery::create()
				->filterById($id)
				->findOne();
			
			if($confImage) {
				if($data['file']) {
					$confImage->setFile($data['file']->getClientOriginalName())
						->save();
					
					$target_dir = __DIR__ . "/../../../../media/images/configurator/";
					$target_file = $target_dir . basename($data['file']->getClientOriginalName());
					
					move_uploaded_file($data['file']->getPathname(), $target_file);
				}
				
				$confImage->setVisible($data['visible'])
					->save();
				
				$confImageI18n = ConfiguratorImageI18nQuery::create()
					->filterById($id)
					->filterByLocale($data['locale'])
					->findOneOrCreate();
					
				if($confImageI18n) {
					$confImageI18n->setTitle($data['title'])
						->setDescription($data['description'])
						->setChapo($data['chapo'])
						->setPostscriptum($data['postscriptum'])
						->save();
				}
			}
			
			return $this->generateSuccessRedirect($form);
		} catch (\Exception $e) {
			$this->setupFormErrorContext(
					$this->getTranslator()->trans("Error on edit image for configurator : %message", ["message"=>$e->getMessage()], FilterConfigurator::DOMAIN_NAME),
					$e->getMessage(),
					$form
					);
			
			return self::viewAction();
		}
	}
	
	public function deleteImageAction($id)
	{
		if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('FilterConfigurator'), AccessManager::UPDATE)) {
			return $response;
		}
		
		ConfiguratorImageI18nQuery::create()
			->filterById($id)
			->delete();
		
		ConfiguratorImageQuery::create()
			->filterById($id)
			->delete();
	}
	
	public function saveImageAction($id)
	{
		
	}
	
	public function updateImagePosition($id) 
	{
		$position = $this->getRequest()->request->get('position');
		$image_id= $this->getRequest()->request->get('image_id');
		
		$posImage = ConfiguratorImageQuery::create()
			->filterById($image_id)
			->findOne();
		
		$posImage->setPosition($position)->save();
		
	}
	
	public function getImageListAjaxAction($id)
	{
		if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('FilterConfigurator'), AccessManager::UPDATE)) {
			return $response;
		}
		
		$this->checkXmlHttpRequest();
		$args = array('imageType' => 'configurator', 'parentId' => $id);
		
		return $this->render('includes/image-upload-list', $args);
	}
}