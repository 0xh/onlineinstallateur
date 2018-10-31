<?php
namespace CronDashboard\Classes;
use CronDashboard\Classes\Proces;

class ProcessHandler
{
	protected $process;

	function __construct($process)
	{
		$this->process = $process;
	}

	public function stopProcess()
	{
		exec("kill -9 ".$this->process->pid);
	}

	public function holdProcess()
	{
		exec("kill -STOP ".$this->process->pid);		
	}

	public function startProcess()
	{
		exec("kill -CONT ".$this->process->pid);
	}
}