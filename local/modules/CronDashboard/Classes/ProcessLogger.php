<?php

namespace CronDashboard\Classes;

use DateTime;
use CronDashboard\Classes\Proces;
use CronDashboard\Model\CronDashboardProcessLog;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Thelia\Tools\URL;

class ProcessLogger
{
	protected $process;
	protected $process_action;
	protected $thelia_user_id;
	protected $thelia_user_name;

	public function __construct($process, $process_action, $thelia_user_id, $thelia_user_name)
	{ 
		$this->process 			= $process;
		$this->process_action 	= $process_action;
		$this->thelia_user_id	= $thelia_user_id;
		$this->thelia_user_name	= $thelia_user_name;
	}

	public function log()
	{
		$date = new DateTime();
		
		$cronDashboardProcessLog = new CronDashboardProcessLog();
		$cronDashboardProcessLog->setLinuxUser( $this->process->user )
        						->setLinuxPid( $this->process->pid )
        						->setProcessName( $this->process->prname )
        						->setCpu( $this->process->cpu )
        						->setMem( $this->process->mem )
        						->setVsz( $this->process->vsz )
        						->setTty( $this->process->tty )
        						->setStat( $this->process->stat )
        						->setStart( $this->process->start )
        						->setTime( $this->process->time )
        						->setCommand( $this->process->command )
        						->setTheliaUserName( $this->thelia_user_name )
        						->setTheliaUserId( $this->thelia_user_id )
        						->setActionTriggered( $this->process_action )
        						->setTriggerTime( $date->format('Y-m-d H:i:s') );

        $cronDashboardProcessLog->save();
	}
}