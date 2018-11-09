<?php
namespace CronDashboard\Classes;
use CronDashboard\Classes\Proces;
use CronDashboard\CronDashboard;

class ProcessHandler
{
	protected $process;

	function __construct($process)
	{
		$this->process = $process;
	}

	public function stopProcess()
	{
        chdir( CronDashboard::getConfigValue('server_location') );
		exec("kill -9 ".$this->process->pid." /dev/null 2>/dev/null &");
	}

	public function holdProcess()
	{
		chdir( CronDashboard::getConfigValue('server_location') );
		exec("kill -STOP ".$this->process->pid." /dev/null 2>/dev/null &");		
	}

	public function startProcess()
	{
		chdir( CronDashboard::getConfigValue('server_location') );
		exec("kill -CONT ".$this->process->pid." /dev/null 2>/dev/null &");
	}
}