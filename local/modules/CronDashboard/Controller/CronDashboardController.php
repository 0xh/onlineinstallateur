<?php

namespace CronDashboard\Controller;

use DateTime;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Exception\PropelException;
use Thelia\Controller\Admin\BaseAdminController;
use CronDashboard\Model\CronJobs;
use CronDashboard\Model\CronJobsQuery;
use Thelia\Tools\URL;
use Thelia\Form\BaseForm;
use CronDashboard\Form\CronjobCreateForm;
use CronDashboard\Form\CronjobModificationForm;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Thelia\Controller\Admin\AbstractCrudController;

class CronDashboardController extends AbstractCrudController {

    protected $currentRouter = "cron.list";

    public function __construct()
    {
        parent::__construct(
            'cronJob',
            'created_reverse',
            'order',
            'crondashboard',
            'CRONJOB_CREATE',
            'CRONJOB_UPDATE',
            'CRONJOB_DELETE',
            null, // No visibility toggle
            'CRONJOB_POSITION',
            'crondashboard'
        );
    }

    public function viewAction() 
    {
        return $this->render("cron-dashboard");
    }

    public function createCronJobEntry()
    {
    	$form = new CronjobCreateForm( $this->getRequest() );
   	
    	try{
    		$validForm = $this->validateForm($form);
            $data = $validForm->getData();
            $title = $data['title'];
            $command = $data['command'];

            $cronJob = new CronJobs();

            $lastCronJob = CronJobsQuery::create()->orderByPosition(Criteria::DESC)->findOne();
            if (null !== $lastCronJob) {
                $position = $lastCronJob->getPosition() + 1;
            } else {
                $position = 1;
            }

	        $date = new DateTime();

	        $cronJob ->setCreatedAt($date->format('Y-m-d H:i:s'))
	            ->setUpdatedAt($date->format('Y-m-d H:i:s'))
	            ->setVisible(1)
	            ->setPosition($position)
	            ->setTitle($title)
              	->setCommand($command);

            $cronJob->save();

            $activeRoute = '/admin/crondashboard';
            $response = RedirectResponse::create(URL::getInstance()->absoluteUrl($activeRoute));
        
            return $response;
    	}
    	catch (FormValidationException $ex){
            $error_msg = $this->createStandardFormValidationErrorMessage($ex);
        } 
        catch (\Exception $ex){
            $error_msg = $ex->getMessage();
        }
    }

    public function getCreationForm(){
        
        return null;
    }

    public function getUpdateForm(){
        
        return new CronjobModificationForm($this->getRequest());
    }

    /**
     * Hydrate the update form for this object, before passing it to the update template
    */
    public function hydrateObjectForm($object){

        $data = [
            'id' => $object->getId(),
            'visible' => $object->getVisible(),
            'title' => $object->getTitle(),
            'command' => $object->getCommand(),
            'position' => $object->getPosition(),
            'createdAt' => $object->getCreatedAt(),
            'updatedAt' => $object->getUpdatedAt()
        ];
   
        // Setup the object form
        return new CronjobModificationForm($this->getRequest(), "form", $data);
    }

    public function getCreationEvent( $formData ){
        
        return null;   
    }

    public function getUpdateEvent( $formData ){
        
        $cronJobId = $this->getRequest()->get('cronjobId');
        
        if (null === $cronJobId) {
            $cronJobId = $this->getRequest()->attributes('cronJobId');
        }

        $cronObj = CronJobsQuery::create()
                ->filterById($cronJobId)
                ->findOneOrCreate();

        //Update Object
        $date = new DateTime();
        $cronObj->setTitle(     $formData["title"]          )
                ->setCommand(   $formData["command"]        )
                ->setPosition(  $formData["position"]       )
                ->setUpdatedAt( $date->format('Y-m-d H:i:s'));

        $cronObj->save();

        return true;
    }

    public function getDeleteEvent(){
        
        return null;   
    }
    
    public function eventContainsObject( $event ){
        
        return null;   
    }

    public function getObjectFromEvent( $event ){
        
        return null;   
    }

    
    /**
     * Load an existing object from the database
     */
    protected function getExistingObject()
    {
        $cronJobId = $this->getRequest()->get('cronjobId');
        
        if (null === $cronJobId) {
            $cronJobId = $this->getRequest()->attributes('cronJobId');
        }

        return CronJobsQuery::create()->findPk($cronJobId);
    }

    public function getObjectLabel( $object ){
        
        return null;   
    }

    public function getObjectId( $object ){
        
        return null;   
    }

    public function renderListTemplate( $currentOrder ){
        
        return null;   
    }

    public function renderEditionTemplate(){
        return $this->render(
            'cronJob-edit',
            [
                'cronjobId' => $this->getRequest()->get('cronjobId')
            ]
        );
    }

    public function redirectToEditionTemplate(){
        
        return null;   
    }

    public function redirectToListTemplate(){
        
        return null;   
    }
}