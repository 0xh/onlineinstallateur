<?php
namespace FilterConfigurator\Controller\Admin;

use Thelia\Controller\Admin\BaseAdminController;
use FilterConfigurator\FilterConfigurator;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Security\AccessManager;
use FilterConfigurator\Model\FilterConfiguratorFeaturesQuery;
use FilterConfigurator\Model\FilterConfiguratorI18nQuery;
use FilterConfigurator\Model\FilterConfiguratorImageI18nQuery;
use FilterConfigurator\Model\FilterConfiguratorImageQuery;
use FilterConfigurator\Model\FilterConfiguratorQuery;
use FilterConfigurator\Model\FilterConfiguratorI18n;
use FilterConfigurator\Model\FilterConfiguratorFeatures;
use FilterConfigurator\Model\FilterConfiguratorImage;
use FilterConfigurator\Model\FilterConfiguratorImageI18n;
use Thelia\Files\FileConfiguration;
use Thelia\Tools\Rest\ResponseRest;
use Thelia\Core\HttpFoundation\Response;
use Thelia\Files\Exception\ProcessFileException;
use Propel\Runtime\ActiveQuery\Criteria;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Thelia\Tools\URL;

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
		
		$args = array('parentId' => '');
		
		return $this->render('filter-configurator-create', $args);
	}
	
	public function update($id) {
		
		if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('FilterConfigurator'), AccessManager::VIEW)) {
			return $response;
		}
		
		$args = array('parentId' => $id);
		
		return $this->render('filter-configurator-update', $args);
	}
	
	public function updateAction() {
		
		if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('FilterConfigurator'), AccessManager::UPDATE)) {
			return $response;
		}
		
		$form = $this->createForm("filter.configurator");
		
	 	try {
	 		$data = $this->validateForm($form)->getData();

	 		if(isset($data["category_id"])){
	 		    $configurator = FilterConfiguratorQuery::create()
	 		        ->filterById($data['id'])
	 		        ->findOneOrCreate();
	 		    
	 		     $configurator
	 		        ->setCategoryId($data["category_id"])
	 		        ->save();
	 		}
	 		
	 		$configuratorI18n =  FilterConfiguratorI18nQuery::create()
				->filterById($data['id'])
				->filterByLocale($data["locale"])
				->findOneOrCreate();
			
			$configuratorI18n
				->setTitle($data["title"])
				->setChapo($data["chapo"])
				->setDescription($data["description"])
				->save();
			
			return $this->generateSuccessRedirect($form);
		} catch (\Exception $e) {
			$this->setupFormErrorContext(
					$this->getTranslator()->trans("Error on edit configurator : %message", ["message"=>$e->getMessage()], FilterConfigurator::DOMAIN_NAME),
					$e->getMessage(),
					$form
					);
			
			return self::viewAction();
		} 
		
	}
	
	public function saveAction() {
		
		if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('FilterConfigurator'), AccessManager::UPDATE)) {
			return $response;
		}
		
		$form = $this->createForm("filter.configurator");
		
		try {
		    
			$data = $this->validateForm($form)->getData();
			
			$configuratorPosition = FilterConfiguratorQuery::create()
				->orderByPosition(Criteria::DESC)
				->findOne();
			
				$configurator =  new FilterConfigurator();
			
			$configurator
				->setVisible(1)
				->setPosition($configuratorPosition !== null ? $configuratorPosition->getPosition() + 1 : 1)
				->setCategoryId($data["category_id"])
				->save();
			
				$configuratorI18n =  new FilterConfiguratorI18n();
			
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
	
	public function saveFiltersAction()
	{
		$configurators_features = $_GET;
		
		if($configurators_features) {
			foreach($configurators_features as $key=>$configurator_features) {
				$featuresDb = array();
				$featuresBack = array();
				
				$configuratorFeatureRelation = FilterConfiguratorFeaturesQuery::create()
					->filterByConfiguratorId($key)
					->find();
			    
				foreach($configuratorFeatureRelation as $relation)
					$featuresDb[] = $relation->getFeatureId();
				
				foreach($configurator_features as $features) 
					$featuresBack[] = $features;
					
				$insert = array_diff($featuresBack, $featuresDb);
				$delete = array_diff($featuresDb, $featuresBack);
				
				if($delete)
					foreach($delete as $featureToDelete) {
						
					    $configuratorFeatures = FilterConfiguratorFeaturesQuery::create()
							->filterByConfiguratorId($key)
							->filterByFeatureId($featureToDelete)
							->delete();
					}
				
				if($insert)
					foreach($insert as $featureToInsert) {
					    $configuratorFeatures = new FilterConfiguratorFeatures();
						
						$configuratorFeatures->setConfiguratorId($key)
							->setFeatureId($featureToInsert)
							->save();
					}
			}
		}
		
		$params = array();
		
		return RedirectResponse::create(
				URL::getInstance()->absoluteUrl(
						'/admin/module/FilterConfigurator', $params
						)
				);
	}
	
	public function getImageFormAjaxAction($parentId, $parentType)
	{
		$args = array('imageType' => $parentType, 'parentId' => $parentId);
		
		return $this->render('includes/image-upload', $args);
	}
	
	public function toggleVisibilityImageAction($id)
	{
	    $configurator =  FilterConfiguratorImageQuery::create()
			->filterById($id)
			->findOne();
		
		if($configurator) {
			$configurator->setVisible($configurator->getVisible() ? 0 : 1)
			->save();
		}
		
		return $configurator->getVisible() ? 0 : 1;
	}
	
	public function updateImage($id)
	{
		if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('FilterConfigurator'), AccessManager::UPDATE)) {
			return $response;
		}
		
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
			
			$confImage = FilterConfiguratorImageQuery::create()
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
				
					$confImageI18n = FilterConfiguratorImageI18nQuery::create()
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
		
		FilterConfiguratorImageI18nQuery::create()
			->filterById($id)
			->delete();
		
		FilterConfiguratorImageQuery::create()
			->filterById($id)
			->delete();
	}
	
	public function saveImageAction($id)
	{
		$config = FileConfiguration::getImageConfig();
		
		return $this->saveFileAjaxAction(
				$id,
				'configurator',
				$config['objectType'],
				$config['validMimeTypes'],
				$config['extBlackList']
				);
	}
	
	
	public function saveFileAjaxAction(
			$parentId,
			$parentType,
			$objectType,
			$validMimeTypes = array(),
			$extBlackList = array()
			) {
				
				$this->checkXmlHttpRequest();
				
				if ($this->getRequest()->isMethod('POST')) {
					/** @var UploadedFile $fileBeingUploaded */
					$fileBeingUploaded = $this->getRequest()->files->get('file');
					
					try {
						$this->processFile(
								$fileBeingUploaded,
								$parentId,
								$parentType,
								$objectType,
								$validMimeTypes,
								$extBlackList
								);
					} catch (ProcessFileException $e) {
						return new ResponseRest($e->getMessage(), 'text', $e->getCode());
					}
					
					return new ResponseRest(array('status' => true, 'message' => ''));
				}
				
				return new Response('', 404);
	}
	
	/**
	 * Process file uploaded
	 *
	 * @param UploadedFile $fileBeingUploaded
	 * @param  int      $parentId       Parent id owning files being saved
	 * @param  string   $parentType     Parent Type owning files being saved (product, category, content, etc.)
	 * @param  string   $objectType     Object type, e.g. image or document
	 * @param  array    $validMimeTypes an array of valid mime types. If empty, any mime type is allowed.
	 * @param  array    $extBlackList   an array of blacklisted extensions.
	 * @return ResponseRest
	 *
	 * @since 2.3
	 */
	public function processFile(
			$fileBeingUploaded,
			$parentId,
			$parentType,
			$objectType,
			$validMimeTypes = array(),
			$extBlackList = array()
			) {
				
				// Validate if file is too big
				if ($fileBeingUploaded->getError() == 1) {
					$message = $this->getTranslator()
					->trans(
							'File is too large, please retry with a file having a size less than %size%.',
							array('%size%' => ini_get('upload_max_filesize')),
							'core'
							);
					
					throw new ProcessFileException($message, 403);
				}
				
				$message = null;
				$realFileName = $fileBeingUploaded->getClientOriginalName();
				
				if (! empty($validMimeTypes)) {
					$mimeType = $fileBeingUploaded->getMimeType();
					
					if (!isset($validMimeTypes[$mimeType])) {
						$message = $this->getTranslator()
						->trans(
								'Only files having the following mime type are allowed: %types%',
								[ '%types%' => implode(', ', array_keys($validMimeTypes))]
								);
					} else {
						$regex = "#^(.+)\.(".implode("|", $validMimeTypes[$mimeType]).")$#i";
						
						if (!preg_match($regex, $realFileName)) {
							$message = $this->getTranslator()
							->trans(
									"There's a conflict between your file extension \"%ext\" and the mime type \"%mime\"",
									[
											'%mime' => $mimeType,
											'%ext' => $fileBeingUploaded->getClientOriginalExtension()
									]
									);
						}
					}
				}
				
				if (!empty($extBlackList)) {
					$regex = "#^(.+)\.(".implode("|", $extBlackList).")$#i";
					
					if (preg_match($regex, $realFileName)) {
						$message = $this->getTranslator()
						->trans(
								'Files with the following extension are not allowed: %extension, please do an archive of the file if you want to upload it',
								[
										'%extension' => $fileBeingUploaded->getClientOriginalExtension(),
								]
								);
					}
				}
				
				if ($message !== null) {
					throw new ProcessFileException($message, 415);
				}
				
				$configuratorImageLastPosition = FilterConfiguratorImageQuery::create()
					->filterByConfiguratorId($parentId)
					->orderByPosition(Criteria::DESC)
					->findOne();
				
					$configuratorImage =  new FilterConfiguratorImage();
				
				$configuratorImage
					->setConfiguratorId($parentId)
					->setFile($realFileName)
					->setVisible(1)
					->setPosition($configuratorImageLastPosition !== null ? $configuratorImageLastPosition->getPosition() + 1 : 1)
					->save();
				
					$configuratorImageI18n =  new FilterConfiguratorImageI18n();
				
				$configuratorImageI18n
					->setId($configuratorImage->getId())
					->setLocale('de_DE')
					->save();
				
				$target_dir = __DIR__ . "/../../../../media/images/configurator/";
				$target_file = $target_dir . basename($realFileName);
				
				move_uploaded_file($fileBeingUploaded->getPathname(), $target_file);
	}
	
	public function updateImagePosition($id)
	{
		if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('FilterConfigurator'), AccessManager::UPDATE)) {
			return $response;
		}
		
		$position = $this->getRequest()->request->get('position');
		$image_id= $this->getRequest()->request->get('image_id');
		
		$posImage = FilterConfiguratorImageQuery::create()
			->filterById($image_id)
			->findOne();
		
		$posImage->setPosition($position)->save();
		
		$confImages = FilterConfiguratorImageQuery::create()
			->filterByConfiguratorId($id)
			->orderByPosition(Criteria::ASC)
			->find();
		
		$i=1;
		
		foreach($confImages as $image) {
			if($image->getId() == $image_id){
				$image->setPosition($position)->save();
			}
			else {
				if($i != $position) {
					$image->setPosition($i)->save();
				}
				else {
					$i++;
					$image->setPosition($i)->save();
				}
				$i++;	
			}
		}	
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
	
	public function deleteAction($id)
	{
		if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('FilterConfigurator'), AccessManager::UPDATE)) {
			return $response;
		}
		
		FilterConfiguratorQuery::create()
			->filterById($id)
			->delete();
		
		$params = array();
		
		return RedirectResponse::create(
				URL::getInstance()->absoluteUrl(
						'/admin/module/FilterConfigurator', $params
						)
				);
	}
}