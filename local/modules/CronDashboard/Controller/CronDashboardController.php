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
use CronDashboard\Classes\Cron\CronExpression;

class CronDashboardController extends BaseAdminController {
    
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
            $schedule = $data['schedule'];
            
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
                ->setCommand($command)
                ->setSchedule($schedule)
                ->setNextrun(self::getNextRun($schedule));
            
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

    /*
    ** Return next run time as date_time format
    */
    public function getNextRun( $cronExpressionString )
    {
        $cronExpression = CronExpression::factory( $cronExpressionString );
        return $cronExpression->getNextRunDate()->format('Y-m-d H:i:s');
    }

    public function updateAction( )
    {
        
        return $this->render(
            'cronJob-edit',
            [
                'cronjobId' => $this->getRequest()->get('cronjobId')
            ]
        );        
    }

    public function processUpdateAction()
    {

        $cronJobId = $this->getRequest()->get('cronjobId');
        
        $form = new CronjobModificationForm( $this->getRequest() );

        $validForm = $this->validateForm($form);
        $data = $validForm->getData();

        if (null === $cronJobId) {
            $cronJobId = $this->getRequest()->attributes('cronJobId');
        }
        
        $cronObj = CronJobsQuery::create()
                ->filterById($cronJobId)
                ->findOneOrCreate();
        
        //Update Object
        $date = new DateTime();
        $cronObj->setTitle(     $data["title"]          )
                ->setCommand(   $data["command"]        )
                ->setPosition(  $data["position"]       )
                ->setSchedule(  $data["schedule"]       )
                ->setUpdatedAt( $date->format('Y-m-d H:i:s'));
        $cronObj->save();
        
        $activeRoute = '/admin/crondashboard';
        $response = RedirectResponse::create(URL::getInstance()->absoluteUrl($activeRoute));

        return $response;
    }
}