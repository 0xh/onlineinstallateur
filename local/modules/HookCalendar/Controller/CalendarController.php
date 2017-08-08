<?php
namespace HookCalendar\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Thelia\Tools\URL;
use Thelia\Controller\Front\BaseFrontController;
use Thelia\Core\HttpFoundation\JsonResponse;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Log\Tlog;
use HookCalendar\Model\BookingsServicesQuery;
use Propel\Runtime\ActiveQuery\Criteria;
/**
 * Class CalendarController
 * @package HookCalendar\Controller
 * @author emanuel plopu <emanuel.plopu@sepa.at>
 */
class CalendarController extends BaseFrontController
{
	private $daySeconds = 86400;

    public function getDaysFromMonthRequest(Request $request){
    	//TODO sequence diagramm with the operations starting from konfigurator form and ending to the response products
    	if ($request->isXmlHttpRequest ()) {
    		//$view = $request->get ( 'ajax-view', "includes/konfigurator-suggestions" );
    		//$request->attributes->set ( '_view', $view );
    		$direction =$request->get('direction');
    			$month =date('m', time());
    			$year = date('Y', time());

    		//Tlog::getInstance()->error("calendarmonth ".$month." ".$year);
    		$content =$this->render('days_table',
    		array("month_days_array" => $this->getDaysForMonth($month, $year,$direction)));
    		//TODO redirect to the service category
    		return $content; 
    	}
    	else
    	{
    		//TODO redirect to the service category
    		return new JsonResponse ( array ('stuff' => 'more stuff') ); // $productsQuerry->__toString()
    	}
    }
    
    public function getTimeslotsFromDayRequest(Request $request){
    	if ($request->isXmlHttpRequest ()) {
    	$start_ts = $request->get("start_ts");
    	//$stop_ts  = $request->get("stop_ts");
    	
    	$content =$this->render('hours_table',
    			array("day_hours_array" => $this->getAppointmentsForDay(date('d', $start_ts), date('m', $start_ts), date('Y', $start_ts))));
    	
    	return $content;
    	}
    	else
    	{
    		//TODO redirect to the service category
    		return new JsonResponse ( array ('stuff' => 'more stuff') ); // $productsQuerry->__toString()
    	}
    }
    
    public function saveAppointmentChoices(Request $request){
    	
    }
    /* 27 28 29 30  1  2  3
     *  4  5  6  7  8  9 10
     * 11 12 13 14 15 16 17
     * 18 19 20 21 22 23 24
     * 25 26 27 28 29 30 31
     * */
    public function getDaysForMonth($month, $year, $direction){
    	
    	//Tlog::getInstance()->error("getDaysForMonth ".$month." ".$direction." year ".$year);
    	$correctMonthIncrement = array();
    	
    	if($direction == "next")
    		$correctMonthIncrement = $this->adjustDate($month+1, $year);
    	
    	if($direction == "prev")
    		$correctMonthIncrement = $this->adjustDate($month, $year);
    	
    	if($direction == null)
    		$correctMonthIncrement = array($month,$year);
    	
    	$correctedMonth = $correctMonthIncrement[0];
    	$correctedYear  = $correctMonthIncrement[1];

    	//$time = strtotime("monday ".$year."-".$month);
    	$startingDate = mktime(0,0,0, $correctedMonth, '1', $correctedYear); //start with last year
    	$endingDate   = mktime(0,0,0, $correctedMonth, date('t',$startingDate), $correctedYear);
    	$firstWeekNumber = (int)date('W',$startingDate);
    	$lastWeekNumber  = (int)date('W',$endingDate);
    	
    	//Tlog::getInstance()->error("calendarmonth ");
    	
    	$monthStructure = array();
    	$startingWeek = 0;
    	//Tlog::getInstance()->error("calendarmonth ".$firstWeekNumber." ".$lastWeekNumber." year ".$year." corrected_year ".$correctedYear);
    	if($firstWeekNumber == 52){//last week of the previous year
    		$monthStructure["w".(1)] = $this->getDaysForWeek($firstWeekNumber, $year);
    		$firstWeekNumber = 1;
    		$startingWeek = 1;
    	}
    	for($i=$firstWeekNumber;$i<=$lastWeekNumber;$i++)
    		$monthStructure["w".($i-$firstWeekNumber+$startingWeek+1)] = $this->getDaysForWeek($i, $correctedYear);
    	return $monthStructure;//$monthStructure;
    }
    
    /*
    array('week' => '31', 'year' => '2016', 'weekStartTime' => '1470002400', 'weekDate' => '01-08-2016', 
    		array(
    		'w1' => array(
    				'd1', array('nr' => '01', 'type' => '3', 'start_ts' => '1470027600', 'stop_ts' => '1470063600'), 
    				'd2', array('nr' => '02', 'type' => '3', 'start_ts' => '1470114000', 'stop_ts' => '1470150000'), 
    				'd3', array('nr' => '03', 'type' => '3', 'start_ts' => '1470200400', 'stop_ts' => '1470236400'), 
    				'd4', array('nr' => '04', 'type' => '3', 'start_ts' => '1470286800', 'stop_ts' => '1470322800'), 
    				'd5', array('nr' => '05', 'type' => '3', 'start_ts' => '1470373200', 'stop_ts' => '1470409200'), 
    				'd6', array('nr' => '06', 'type' => '3', 'start_ts' => '1470459600', 'stop_ts' => '1470495600'), 
    				'd7', array('nr' => '07', 'type' => '3', 'start_ts' => '1470546000', 'stop_ts' => '1470582000'))
    				),
    		'w2' => array(
    				'd8', array('nr' => '01', 'type' => '3', 'start_ts' => '1470027600', 'stop_ts' => '1470063600'), 
    				'd9', array('nr' => '02', 'type' => '3', 'start_ts' => '1470114000', 'stop_ts' => '1470150000'), 
    				'd10', array('nr' => '03', 'type' => '3', 'start_ts' => '1470200400', 'stop_ts' => '1470236400'), 
    				'd11', array('nr' => '04', 'type' => '3', 'start_ts' => '1470286800', 'stop_ts' => '1470322800'), 
    				'd12', array('nr' => '05', 'type' => '3', 'start_ts' => '1470373200', 'stop_ts' => '1470409200'), 
    				'd13', array('nr' => '06', 'type' => '3', 'start_ts' => '1470459600', 'stop_ts' => '1470495600'), 
    				'd14', array('nr' => '07', 'type' => '3', 'start_ts' => '1470546000', 'stop_ts' => '1470582000'))
    				),
    */
/*     
    1 pj-calendar-day-past
    2 pj-calendar-day-selected
    3 pj-calendar-day-today
    4 pj-calendar-day-inactive
    5 pjAsCalendarDate
     */
    private function isDayAvailable($day,$todayTimestamp,$isSunday){
    	if($isSunday)
    		return 4;
    	//past days
    	if($day < $todayTimestamp)
    		return 1;
    	else if($day == $todayTimestamp)
    			return 3;
    	return 5;
    	// weekends
    }
    /*
     1 pjAsTimeAvailable
     2 pjAsTimeBooked
     3 pjAsTimeSelected
     4 pjAsTimeBooked
     5 pjAsTimeUnavailable
     6 pjAsTimeUnavailable
     */
    private function isTimeslotAvailable($start_ts, $stop_ts, $currentTimestamp, $booked, $isUnavailable){
    	//sunday + saturday afternoon
    	if($isUnavailable)
    		return 5;
    	//existing bookings
    	if($booked)
    		return 2;
    	//past timeslots
    	if($start_ts < $currentTimestamp)
    		return 5;
    	
    	//before 11:00 current day O.Clock only last timeslot is available
    	$todayTime = time();
    	$day = date('d', $todayTime);
    	$month = date('m', $todayTime);
    	$year = date('Y', $todayTime);
    	$todayNoon = mktime( 11, 0, 0, $month, $day, $year);
    	$todayLastStart = mktime( 17, 0, 0, $month, $day, $year); 
    	
        if($currentTimestamp < $todayNoon && $start_ts == $todayLastStart)
        //before noon with start ts at the last timeslot second
        	return 1;
        else 
    		if($start_ts >= $todayNoon && $start_ts < mktime( 19, 0, 0, $month, $day, $year))
    			return 5;
    	
    	return 1;
    }

    public function getDaysForWeek($week,$year){
    	if($week <= "9")$week = "0".$week;
    	$weekStartTime = strtotime($year.'W'.$week);
    	$weekDate = date('d-m-Y', $weekStartTime);

    	$todayTime = time();
    	$todayTimestamp  =  mktime( 0, 0, 0, date('m', $todayTime), date('d', $todayTime), date('Y', $todayTime));
    	//$log = Tlog::getInstance();
    	//$log->error("week ".$week." ".$year." weekstarttime ".$weekStartTime." strtotime from ".$year.'W'.$week." returns ".strtotime($year.'W'.$week));
    	
    	$weekStructure = array();
    	for($i = 0;$i<7;$i++){
    		$dayTimestamp = $weekStartTime+$i*$this->daySeconds;
    		$dayDate  = date('d', $dayTimestamp);
    		$dayMonth = date('m', $dayTimestamp);
    		$dayYear  = date('Y', $dayTimestamp);
    		//$log->error("days ".$dayMonth." ".$dayDate." ".$dayYear);
    		////day 1 past 2 select 3 today 4 inactive 5 available
    		$weekDay = array("nr" => $dayDate, 
    				  "type" => $this->isDayAvailable($dayTimestamp, $todayTimestamp,($i == 6 ? true : false)),
    				  "start_ts" => mktime(   7, 0, 0, $dayMonth, $dayDate, $dayYear),
    				  "stop_ts"  => mktime(  17, 0, 0, $dayMonth, $dayDate, $dayYear));
    		$weekStructure["d".($i+1)] = $weekDay;
    		//$log->error(implode(' ',$weekDay));
    	}
    	return $weekStructure;
    }
    
    public function getAppointmentsForDay($day,$month,$year){
    	$log = Tlog::getInstance ();
    	$isOneSelected = false;
    	$time = time();
    	//get existing appointments for day
    	$day_start_ts = mktime(  7,  0, 0, $month, $day, $year);
    	$day_stop_ts =  mktime(  19,  0, 0, $month, $day, $year);
    	
    	$dayslots = array();
    	$dayslots[1][1] = $day_start_ts;
    	$dayslots[2][1] = mktime(  9,  0, 0, $month, $day, $year);
    	$dayslots[3][1] = mktime( 11,  0, 0, $month, $day, $year);
    	$dayslots[4][1] = mktime( 13,  0, 0, $month, $day, $year);
    	$dayslots[5][1] = mktime( 15,  0, 0, $month, $day, $year);
    	$dayslots[6][1] = mktime( 17,  0, 0, $month, $day, $year);
    	
    	$dayslots[1][2] = $dayslots[2][1];
    	$dayslots[2][2] = $dayslots[3][1];
    	$dayslots[3][2] = $dayslots[4][1];
    	$dayslots[4][2] = $dayslots[5][1];
    	$dayslots[5][2] = $dayslots[6][1];
    	$dayslots[6][2] = $day_stop_ts;
    	
    	$booked = array(0,false,false,false,false,false,false);
    	
    	$isSaturday = false;
    	if(date('w',$day_start_ts) == 6)
    		$isSaturday = true;
    	
    	try {
    		$bookingServiceQuery = BookingsServicesQuery::create();
    		$bookingServiceQuery
    		->condition ( 'start_ts', 'start_ts >= ?', $day_start_ts, \PDO::PARAM_INT )
    		->condition ( 'stop_ts', 'stop_ts <= ?', $day_stop_ts, \PDO::PARAM_INT )
    		//->condition ( 'service', 'service_id = ?', $service_id, \PDO::PARAM_INT )
    		->where ( array ('start_ts','stop_ts'), Criteria::LOGICAL_AND );
    			
    		$bookings =$bookingServiceQuery->find();

    		foreach($bookings as $booking)
    		{
    		$log->debug ( "-- getAppointmentsForDay ".$booking->getId());
    		$foundSlotNumber = 0;
    		for($j=1;$j<7;$j++)
    			if($booking->getStartTs() == $dayslots[$j][1])$foundSlotNumber = $j;
    			if($foundSlotNumber > 0)
    				$booked[$foundSlotNumber] = true;
    		}
    		
    	
    	} catch (PropelException $e) {
    		Tlog::getInstance()->error(sprintf("Failed to add item to cart with message : %s", $e->getMessage()));
    		/*$message = $this->getTranslator()->trans(
    				"Diese Timeslot ist leider schon gebucht, wählen Sie bitte ein neuen",
    				[],
    				Front::MESSAGE_DOMAIN
    				);*/
    	}
    	
        
        
        
    	return  array(
    					array("type" => $this->isTimeslotAvailable($dayslots[1][1], $dayslots[1][2], $time, $booked[1], false), 
    						"start"  => "07:00", "start_ts" => $dayslots[1][1], 
    						"end"    => "09:00", "end_ts"   => $dayslots[1][2], 
    						"employee_id" => "2"),
    					array("type" => $this->isTimeslotAvailable($dayslots[2][1], $dayslots[2][2], $time, $booked[2], false), 
    						"start"  => "09:00", "start_ts"        => $dayslots[2][1],
    						"end"    => "11:00", "end_ts"          => $dayslots[2][2],
    						"employee_id" => "2"),
    					array("type" => $this->isTimeslotAvailable($dayslots[3][1], $dayslots[3][2], $time, $booked[3], $isSaturday), 
    						"start"  => "11:00", "start_ts"        => $dayslots[3][1],
    						"end"    => "13:00", "end_ts"          => $dayslots[3][2],
    						"employee_id" => "2"),
    					array("type" => $this->isTimeslotAvailable($dayslots[4][1], $dayslots[4][2], $time, $booked[4], $isSaturday), 
    						"start"  => "13:00", "start_ts" 		=> $dayslots[4][1],
    						"end" 	 => "15:00", "end_ts" 			=> $dayslots[4][2],
    						"employee_id" => "2"),
    					array("type" => $this->isTimeslotAvailable($dayslots[5][1], $dayslots[5][2], $time, $booked[5], $isSaturday), 
    						"start"  => "15:00", "start_ts" 		=> $dayslots[5][1],
    						"end"    => "17:00", "end_ts" 			=> $dayslots[5][2],
    						"employee_id" => "2"),
    					array("type" => $this->isTimeslotAvailable($dayslots[6][1], $dayslots[6][2], $time, $booked[6], $isSaturday), 
    						"start"  => "17:00", "start_ts" 		=> $dayslots[6][1],
    						"end"    => "19:00", "end_ts" 			=> $dayslots[6][2],
    						"employee_id" => "2")
    	);
    }
    
    public function getAppointmentsForWeek($week,$year){
    	$stringTime = strtotime($year.'W'.$week);
    	$monthDayFromWeek = explode(" ",date('n d',$stringTime));
    	$month = $monthDayFromWeek[0];
    	$firstDay = $monthDayFromWeek[1];
    	
    	mktime( 7, 0, 0, $month, $firstDay, $year);
    	
    	$available_times = array(
    			"d1" => array(
    					"nr" => 18,
    					"type" => 3,
    					"ts" => array(
    					array("type" => "6","display" =>"07<sub>00</sub>-09<sub>00</sub>", "start" => "07:00", "start_ts" => mktime(  7,  0, 0, $month, $firstDay, $year), "end" => "09:00", "end_ts" => mktime( 9, 0, 0, $month, $firstDay, $year), "employee_id" => "2"),
    					array("type" => "6", "start" => "09:30", "start_ts" => mktime(  9, 30, 0, $month, $firstDay, $year), "end" => "11:30", "end_ts" => mktime( 11, 30, 0, $month, $firstDay, $year), "employee_id" => "2"),
    					array("type" => "6", "start" => "12:00", "start_ts" => mktime( 12,  0, 0, $month, $firstDay, $year), "end" => "14:00", "end_ts" => mktime( 14, 0, 0, $month, $firstDay, $year), "employee_id" => "2"),
    					array("type" => "6", "start" => "14:30", "start_ts" => mktime( 14, 30, 0, $month, $firstDay, $year), "end" => "16:30", "end_ts" => mktime( 16, 30, 0, $month, $firstDay, $year), "employee_id" => "2"),
    					array("type" => "6", "start" => "17:00", "start_ts" => mktime( 17,  0, 0, $month, $firstDay, $year), "end" => "19:00", "end_ts" => mktime( 19, 0, 0, $month, $firstDay, $year), "employee_id" => "2"))),
    			"d2" =>  array(
    					"nr" => 19,
    					"type" => 5,
    					"ts" => array(
    					array("type" => "1", "start" => "07:00", "start_ts" => mktime(  7,  0, 0, $month, $firstDay+1, $year), "end" => "09:00", "end_ts" => mktime( 9, 0, 0, $month, $firstDay+1, $year), "employee_id" => "2"),
    					array("type" => "1", "start" => "09:30", "start_ts" => mktime(  9, 30, 0, $month, $firstDay+1, $year), "end" => "11:30", "end_ts" => mktime( 11, 30, 0, $month, $firstDay+1, $year), "employee_id" => "2"),
    					array("type" => "1", "start" => "12:00", "start_ts" => mktime( 12,  0, 0, $month, $firstDay+1, $year), "end" => "14:00", "end_ts" => mktime( 14, 0, 0, $month, $firstDay+1, $year), "employee_id" => "2"),
    					array("type" => "1", "start" => "14:30", "start_ts" => mktime( 14, 30, 0, $month, $firstDay+1, $year), "end" => "16:30", "end_ts" => mktime( 16, 30, 0, $month, $firstDay+1, $year), "employee_id" => "2"),
    					array("type" => "1", "start" => "17:00", "start_ts" => mktime( 17,  0, 0, $month, $firstDay+1, $year), "end" => "19:00", "end_ts" => mktime( 19, 0, 0, $month, $firstDay+1, $year), "employee_id" => "2"))),
    			"d3" =>  array(
    					"nr" => 20,
    					"type" => 5,
    					"ts" => array(
    					array("type" => "1", "start" => "07:00", "start_ts" => mktime(  7,  0, 0, $month, $firstDay+2, $year), "end" => "09:00", "end_ts" => mktime( 9, 0, 0, $month, $firstDay+2, $year), "employee_id" => "2"),
    					array("type" => "1", "start" => "09:30", "start_ts" => mktime(  9, 30, 0, $month, $firstDay+2, $year), "end" => "11:30", "end_ts" => mktime( 11, 30, 0, $month, $firstDay+2, $year), "employee_id" => "2"),
    					array("type" => "1", "start" => "12:00", "start_ts" => mktime( 12,  0, 0, $month, $firstDay+2, $year), "end" => "14:00", "end_ts" => mktime( 14, 0, 0, $month, $firstDay+2, $year), "employee_id" => "2"),
    					array("type" => "1", "start" => "14:30", "start_ts" => mktime( 14, 30, 0, $month, $firstDay+2, $year), "end" => "16:30", "end_ts" => mktime( 16, 30, 0, $month, $firstDay+2, $year), "employee_id" => "2"),
    					array("type" => "1", "start" => "17:00", "start_ts" => mktime( 17,  0, 0, $month, $firstDay+2, $year), "end" => "19:00", "end_ts" => mktime( 19, 0, 0, $month, $firstDay+2, $year), "employee_id" => "2"))),
    			"d4" =>  array(
    					"nr" => 21,
    					"type" => 5,
    					"ts" => array(
    					array("type" => "1", "start" => "07:00", "start_ts" => mktime(  7,  0, 0, $month, $firstDay+3, $year), "end" => "09:00", "end_ts" => mktime( 9, 0, 0, $month, $firstDay+3, $year), "employee_id" => "2"),
    					array("type" => "1", "start" => "09:30", "start_ts" => mktime(  9, 30, 0, $month, $firstDay+3, $year), "end" => "11:30", "end_ts" => mktime( 11, 30, 0, $month, $firstDay+3, $year), "employee_id" => "2"),
    					array("type" => "1", "start" => "12:00", "start_ts" => mktime( 12,  0, 0, $month, $firstDay+3, $year), "end" => "14:00", "end_ts" => mktime( 14, 0, 0, $month, $firstDay+3, $year), "employee_id" => "2"),
    					array("type" => "1", "start" => "14:30", "start_ts" => mktime( 14, 30, 0, $month, $firstDay+3, $year), "end" => "16:30", "end_ts" => mktime( 16, 30, 0, $month, $firstDay+3, $year), "employee_id" => "2"),
    					array("type" => "1", "start" => "17:00", "start_ts" => mktime( 17,  0, 0, $month, $firstDay+3, $year), "end" => "19:00", "end_ts" => mktime( 19, 0, 0, $month, $firstDay+3, $year), "employee_id" => "2"))),
    			"d5" =>  array(
    					"nr" => 22,
    					"type" => 5,
    					"ts" => array(
    					array("type" => "1", "start" => "07:00", "start_ts" => mktime(  7,  0, 0, $month, $firstDay+4, $year), "end" => "09:00", "end_ts" => mktime( 9, 0, 0, $month, $firstDay+4, $year), "employee_id" => "2"),
    					array("type" => "1", "start" => "09:30", "start_ts" => mktime(  9, 30, 0, $month, $firstDay+4, $year), "end" => "11:30", "end_ts" => mktime( 11, 30, 0, $month, $firstDay+4, $year), "employee_id" => "2"),
    					array("type" => "1", "start" => "12:00", "start_ts" => mktime( 12,  0, 0, $month, $firstDay+4, $year), "end" => "14:00", "end_ts" => mktime( 14, 0, 0, $month, $firstDay+4, $year), "employee_id" => "2"),
    					array("type" => "1", "start" => "14:30", "start_ts" => mktime( 14, 30, 0, $month, $firstDay+4, $year), "end" => "16:30", "end_ts" => mktime( 16, 30, 0, $month, $firstDay+4, $year), "employee_id" => "2"),
    					array("type" => "1", "start" => "17:00", "start_ts" => mktime( 17,  0, 0, $month, $firstDay+4, $year), "end" => "19:00", "end_ts" => mktime( 19, 0, 0, $month, $firstDay+4, $year), "employee_id" => "2"))),
    			"d6" =>  array(
    					"nr" => 23,
    					"type" => 4,
    					"ts" => array(
    					array("type" => "2", "start" => "07:00", "start_ts" => mktime(  7,  0, 0, $month, $firstDay+5, $year), "end" => "09:00", "end_ts" => mktime( 9, 0, 0, $month, $firstDay+5, $year), "employee_id" => "2"),
    					array("type" => "2", "start" => "09:30", "start_ts" => mktime(  9, 30, 0, $month, $firstDay+5, $year), "end" => "11:30", "end_ts" => mktime( 11, 30, 0, $month, $firstDay+5, $year), "employee_id" => "2"),
    					array("type" => "2", "start" => "12:00", "start_ts" => mktime( 12,  0, 0, $month, $firstDay+5, $year), "end" => "14:00", "end_ts" => mktime( 14, 0, 0, $month, $firstDay+5, $year), "employee_id" => "2"),
    					array("type" => "2", "start" => "14:30", "start_ts" => mktime( 14, 30, 0, $month, $firstDay+5, $year), "end" => "16:30", "end_ts" => mktime( 16, 30, 0, $month, $firstDay+5, $year), "employee_id" => "2"),
    					array("type" => "2", "start" => "17:00", "start_ts" => mktime( 17,  0, 0, $month, $firstDay+5, $year), "end" => "19:00", "end_ts" => mktime( 19, 0, 0, $month, $firstDay+5, $year), "employee_id" => "2"))),
    			"d7" =>  array(
    					"nr" => 24,
    					"type" => 4,
    					"ts" => array(
    					array("type" => "5", "start" => "07:00", "start_ts" => mktime(  7,  0, 0, $month, $firstDay+6, $year), "end" => "09:00", "end_ts" => mktime( 9, 0, 0, $month, $firstDay+6, $year), "employee_id" => "2"),
    					array("type" => "5", "start" => "09:30", "start_ts" => mktime(  9, 30, 0, $month, $firstDay+6, $year), "end" => "11:30", "end_ts" => mktime( 11, 30, 0, $month, $firstDay+6, $year), "employee_id" => "2"),
    					array("type" => "5", "start" => "12:00", "start_ts" => mktime( 12,  0, 0, $month, $firstDay+6, $year), "end" => "14:00", "end_ts" => mktime( 14, 0, 0, $month, $firstDay+6, $year), "employee_id" => "2"),
    					array("type" => "5", "start" => "14:30", "start_ts" => mktime( 14, 30, 0, $month, $firstDay+6, $year), "end" => "16:30", "end_ts" => mktime( 16, 30, 0, $month, $firstDay+6, $year), "employee_id" => "2"),
    					array("type" => "5", "start" => "17:00", "start_ts" => mktime( 17,  0, 0, $month, $firstDay+6, $year), "end" => "19:00", "end_ts" => mktime( 19, 0, 0, $month, $firstDay+6, $year), "employee_id" => "2"))));
    					//timeslot 1 available 2 booked 3 selected 4 booked_by_user 5 not_available 6 past_time_slot
						//day 1 past 2 select 3 today 4 inactive
    	return $available_times;
    }
    
    static private function adjustDate($month, $year)
    {
    	$arr = array();
    	$arr[0] = $month;
    	$arr[1] = $year;
    
    	while ($arr[0] > 12)
    	{
    		$arr[0] -= 12;
    		$arr[1]++;
    	}
    
    	while ($arr[0] <= 0)
    	{
    		$arr[0] += 12;
    		$arr[1]--;
    	}
    
    	return $arr;
    }
    
    
}