<?php
namespace CronDashboard\Controller;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Exception\PropelException;
use Thelia\Controller\Admin\BaseAdminController;
use CronDashboard\Classes\Proces;
use CronDashboard\Classes\ProcessHandler;
use CronDashboard\Classes\ProcessLogger;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Thelia\Tools\URL;
use CronDashboard\CronDashboard;

class CronDashboardProcessController extends BaseAdminController {
	
	public function getProcessLists()
	{
		$proces_name = CronDashboard::getConfigValue('process_name');
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
		        self::holdTheliaProcess( $processId, CronDashboard::getConfigValue('process_name'));
		    }
		    
		    if(isset($_POST['stop'])) {
		        // stop
		        self::stopTheliaProcess( $processId, CronDashboard::getConfigValue('process_name'));
		    }

		    if(isset($_POST['start'])) {
		    	//start - resume
		       	self::startTheliaProcess( $processId, CronDashboard::getConfigValue('process_name'));
		    }
		}

		return $this->generateRedirect('/admin/crondashboard');
	}

	public function stopTheliaProcess( $processId, $proces_name )
	{
		$processObject = self::buildModuleProcess( $processId, $proces_name);
		$procesHandler = new ProcessHandler( $processObject );
		$procesHandler->stopProcess();	

        $theliaUserId = $this->getRequest()->getSession()->getAdminUser()->getId();
        $theliaUserLogin = $this->getRequest()->getSession()->getAdminUser()->getlogin();
        
        $logger = new ProcessLogger( $processObject, 'stop', $theliaUserId, $theliaUserLogin );
		$logger->log();

		/*return $this->generateRedirectFromRoute('cron.list', array(), array('module_code' => 'CronDashboard') );*/
		/*return $this->generateRedirectFromRoute('cron.list');*/

		return $this->generateRedirect('/admin/crondashboard');
	}

	public function holdTheliaProcess( $processId, $proces_name )
	{
		$processObject = self::buildModuleProcess( $processId, $proces_name);
		$procesHandler = new ProcessHandler( $processObject );
		$procesHandler->holdProcess();

        $theliaUserId = $this->getRequest()->getSession()->getAdminUser()->getId();
        $theliaUserLogin = $this->getRequest()->getSession()->getAdminUser()->getlogin();
        
        $logger = new ProcessLogger( $processObject, 'hold', $theliaUserId, $theliaUserLogin );
		$logger->log();

		/*return $this->generateRedirectFromRoute('cron.list', array(), array('module_code' => 'CronDashboard') );*/
		/*return $this->generateRedirectFromRoute('cron.list');*/

		return $this->generateRedirect('/admin/crondashboard');
	}

	public function startTheliaProcess( $processId, $proces_name )
	{
		$processObject = self::buildModuleProcess( $processId, $proces_name);
		$procesHandler = new ProcessHandler( $processObject );
		$procesHandler->startProcess();

        $theliaUserId = $this->getRequest()->getSession()->getAdminUser()->getId();
        $theliaUserLogin = $this->getRequest()->getSession()->getAdminUser()->getlogin();
        
        $logger = new ProcessLogger( $processObject, 'start', $theliaUserId, $theliaUserLogin );
		$logger->log();

		/*return $this->generateRedirectFromRoute('cron.list', array(), array('module_code' => 'CronDashboard') );*/
		/*return $this->generateRedirectFromRoute('cron.list');*/

		return $this->generateRedirect('/admin/crondashboard');
	}
}