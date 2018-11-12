<?php
namespace CronDashboard\Controller;

use DateTime;
use CronDashboard\CronDashboard;
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
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Security\AccessManager;
use Symfony\Component\HttpFoundation\ParameterBag;

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

    public function deleteAction()
    {
        // Check current user authorization
        if (null !== $response = $this->checkAuth(AdminResources::COUPON, [], AccessManager::DELETE)) {
            return $response;
        }

        try {

            // Check token
            $this->getTokenProvider()->checkToken(
                $this->getRequest()->query->get("_token")
            );
            
            //Find the one and delete it
            $cronJob = CronJobsQuery::create()
                ->findPk($couponId = $this->getRequest()->request->get('cronjob_id'));
            
            $cronJob->delete();

            return $response = RedirectResponse::create(
                URL::getInstance()->absoluteUrl($this->getRoute('cron.list'))
            );

        }
        catch(\Exception $e) {
            $this->getParserContext()
                ->setGeneralError($e->getMessage())
            ;

            return $this->viewAction();
        }
    }

    public function runAtOnce( )
    {
        if( $this->getRequest()->request->get('start_cronjob_id') !== NULL ){
            $cronJob = CronJobsQuery::create()
                ->findPk($couponId = $this->getRequest()->request->get('start_cronjob_id'));

            chdir( CronDashboard::getConfigValue('server_location') );
            exec( $cronJob->getCommand().' > /dev/null 2>/dev/null &' );

            $date = new DateTime();
            $cronJob->setLastrun($date->format('Y-m-d H:i:s'))
                ->setRunflag(0);
            
            $cronJob->save();
        }

        return $this->viewAction();
    }
}