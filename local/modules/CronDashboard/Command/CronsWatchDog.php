<?php

namespace CronDashboard\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Thelia\Command\ContainerAwareCommand;
use CronDashboard\Classes\Cron\CronExpression;
use CronDashboard\Model\Base\CronJobsQuery;

class CronsWatchDog extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName("CronsWatchDog:computeTimestamp")
            ->setDescription("Check if crons need to run");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /*$cronExpression = CronExpression::factory('* * 5 * *');
        echo $cronExpression->getNextRunDate()->format('Y-m-d H:i:s');*/

        while ( true ) {
        	self::checkCronJobsSchedule();
        	sleep( 60 );
        }
        
    }

    protected function checkCronJobsSchedule()
    {
    	$allCronJobsRows = CronJobsQuery::create()
                ->where(1)
                ->find();

        $now = time();
        foreach ($allCronJobsRows as $cronJob) 
        {     	
        	$nextRunDateTime = $cronJob->getNextrun();
        	$nextRunDateTime = (array)$nextRunDateTime;
        	$nextRunAt = strtotime( $nextRunDateTime["date"] );
        	if( $nextRunAt <= $now ) {
        		$cronJob->setRunflag(1);
        		$cronJob->save();
        	}
        }
    }
}
