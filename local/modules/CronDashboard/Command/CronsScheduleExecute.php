<?php
namespace CronDashboard\Command;

use DateTime;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Thelia\Command\ContainerAwareCommand;
use CronDashboard\Classes\Cron\CronExpression;
use CronDashboard\Model\Base\CronJobsQuery;

class CronsScheduleExecute extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName("CronsScheduleExecute:persuitAndUpdate")
            ->setDescription("Run crons and update cron table");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $allCronJobsRows = CronJobsQuery::create()
                ->where(1)
                ->find();
    	
    	$now = time();
        foreach ($allCronJobsRows as $cronJob) 
        {     	
        	if($cronJob->getRunflag() != NULL && $cronJob->getRunflag() == 1){
        		//execute cron command
        		if($cronJob->getCommand() != NULL){
        			self::executeLinuxCommand( $cronJob->getCommand() );
        		}
        		$date = new DateTime();
            	$cronJob->setRunflag(0)
        				->setNextrun(self::getNextRun( $cronJob->getSchedule() ))
        				->setLastrun( $date->format('Y-m-d H:i:s') );
        		$cronJob->save();
        	}
        }
    }

    protected function executeLinuxCommand( $command )
    {
    	echo $command;
    	/*exec( $command );*/

    	return;
    }

    /*
    ** Return next run time as date_time format
    */
    public function getNextRun( $cronExpressionString )
    {
        $cronExpression = CronExpression::factory( $cronExpressionString );
        return $cronExpression->getNextRunDate()->format('Y-m-d H:i:s');
    }
}