<?php

namespace CronDashboard\Controller;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Exception\PropelException;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Tools\URL;
use CronDashboard\Classes\Proces;
use CronDashboard\Classes\ProcessHandler;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CronDashboardProcessController extends BaseAdminController {
	
	public function getProcessLists()
	{
		$proces_name = 'Thelia';
        $returnArray = [];
        $output ='';
        exec("ps axf |grep ".$proces_name." | awk '{print $1}'" , $output);

        foreach($output as $pid){
            $returnArray[] = self::buildModuleProcess($pid, $proces_name);
        }

		return $returnArray;
	}

	protected function buildModuleProcess($pid, $proces_name)
	{
		$user = exec("ps -o user fp ".$pid);
        $cpu = exec("ps -p ".$pid." -o %cpu");
        $mem = exec("ps -p ".$pid." -o %mem");
        $vsz = exec("ps -p ".$pid." -o vsz");
        $rss = exec("ps -p ".$pid." -o rss");
        $tty = exec("ps -p ".$pid." -o tty");
        $stat = exec("ps -p ".$pid." -o stat");
        $start = exec("ps -p ".$pid." -o start");
        $time = exec("ps -p ".$pid." -o time");
        $command = exec("ps -o cmd fp ".$pid);

        $user       = isset($user) ? $user : '';
        $pid        = isset($pid) ? $pid : '';
        $prname     = isset($proces_name) ? $proces_name : '';
        $cpu        = isset($cpu) ? $cpu : '';
        $mem        = isset($mem) ? $mem : '';
        $vsz        = isset($vsz) ? $vsz : '';
        $rss        = isset($rss) ? $rss : '';
        $tty        = isset($tty) ? $tty : '';
        $stat       = isset($stat) ? $stat : '';
        $start      = isset($start) ? $start : '';
        $time       = isset($time) ? $time : '';
        $command    = isset($command) ? $command : '';
        
        return new Proces($user, $pid, $prname, $cpu, $mem, $vsz, $rss, $tty, $stat, $start, $time, $command);
	}

	public function processUpdateState( $processId )
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(isset($_POST['hold'])) {
		        // hold - suspend
		        self::holdTheliaProcess( $processId, 'Thelia');
		    }
		    
		    if(isset($_POST['stop'])) {
		        // stop
		        self::stopTheliaProcess( $processId, 'Thelia');
		    }

		    if(isset($_POST['start'])) {
		    	//start - resume
		       	self::startTheliaProcess( $processId, 'Thelia');
		    }
		}
	}

	protected function stopTheliaProcess( $processId, $proces_name )
	{
		$processObject = self::buildModuleProcess( $processId, $proces_name);
		$procesHandler = new ProcessHandler( $processObject );
		$procesHandler->stopProcess();

		$activeRoute = '/admin/crondashboard/#processes';
        $response = RedirectResponse::create(URL::getInstance()->absoluteUrl($activeRoute));

        return $response;
	}

	public function holdTheliaProcess( $processId, $proces_name )
	{
		$processObject = self::buildModuleProcess( $processId, $proces_name);
		$procesHandler = new ProcessHandler( $processObject );
		$procesHandler->holdProcess();

		$activeRoute = '/admin/crondashboard/#processes';
        $response = RedirectResponse::create(URL::getInstance()->absoluteUrl($activeRoute));

        return $response;
	}

	public function startTheliaProcess( $processId, $proces_name )
	{
		$processObject = self::buildModuleProcess( $processId, $proces_name);
		$procesHandler = new ProcessHandler( $processObject );
		$procesHandler->startProcess();

		$activeRoute = '/admin/crondashboard/#processes';
        $response = RedirectResponse::create(URL::getInstance()->absoluteUrl($activeRoute));

        return $response;
	}
}