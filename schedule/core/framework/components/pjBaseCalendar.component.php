<?php
class pjBaseCalendar
{
    private $startDay = 0;

    private $startMonth = 1;

    private $currentDate = NULL;
    
    private $dayNames = array("S", "M", "T", "W", "T", "F", "S");

    private $monthNames = array(
    	1 => "Januar",
    	2 => "Februar",
    	3 => "März",
    	4 => "April",
    	5 => "Mai",
    	6 => "Juni",
    	7 => "Juli",
    	8 => "August",
    	9 => "September",
    	10 => "October",
    	11 => "November",
    	12 => "Dezember"
    );

    private $daysInMonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    
    private $showNextLink = true;
    
    private $showPrevLink = true;

    private $weekNumbers = NULL;
    
    private $showDayNames = true;
    
    private $prevLink = "&lt;";
    
    private $nextLink = "&gt;";
    
    private $showTooltip = false;
    
    private $serviceId = NULL;
    
    private $employeeId = NULL;
    
    private $selectedTimeslot = NULL;
    
    private $options = array(
    	'o_month_year_format' => 'Month, Year'
    );
    
    protected $classMonthPrev = "pj-calendar-next-month";
    protected $classMonthNext = "pj-calendar-prev-month";
    protected $classCalendar = "pj-calendar-date";
    
	protected $classPast = "pj-calendar-day-past";
	protected $classToday = "pj-calendar-day-today";
	protected $classReserved = "pj-calendar-day-inactive";
	protected $classSelected = "pj-calendar-day-selected";
	protected $classEmpty = "pj-calendar-day-disabled";
	
    public function __construct()
    {
    	$this->setCurrentDate(time());
    }
    
    
    
    public function setPrevLink($value)
    {
    	$this->prevLink = $value;
    	return $this;
    }
    
	public function setNextLink($value)
    {
    	$this->nextLink = $value;
    	return $this;
    }
    
	public function getPrevLink()
    {
    	return $this->prevLink;
    }
    
	public function getNextLink()
    {
    	return $this->nextLink;
    }
    
    public function setShowNextLink($value)
    {
    	if (is_bool($value))
    	{
    		$this->showNextLink = $value;
    	}
    	return $this;
    }
    
    public function getShowNextLink()
    {
    	return $this->showNextLink;
    }
    
	public function setShowPrevLink($value)
    {
    	if (is_bool($value))
    	{
    		$this->showPrevLink = $value;
    	}
    	return $this;
    }
    
    public function getShowPrevLink()
    {
    	return $this->showPrevLink;
    }

 	public function getCurrentDate()
    {
        return $this->currentDate;
    }

    public function setCurrentDate($time)
    {
        $this->currentDate = $time;
        return $this;
    }
    
    public function getDayNames()
    {
        return $this->dayNames;
    }

    public function setDayNames($names)
    {
        $this->dayNames = $names;
        return $this;
    }
    
    public function getShowDayNames()
    {
    	return $this->showDayNames;
    }
    
    public function setShowDayNames($value)
    {
    	if (is_bool($value))
    	{
    		$this->showDayNames = $value;
    	}
    	return $this;
    }
    
    public function getOptions()
    {
    	return $this->options;
    }
    
    public function setOptions($opts)
    {
    	$this->options = $opts;
    	return $this;
    }

    public function getMonthNames()
    {
        return $this->monthNames;
    }

    public function setMonthNames($names)
    {
        $this->monthNames = $names;
        return $this;
    }

    public function getStartDay()
    {
        return $this->startDay;
    }

    public function setStartDay($day)
    {
        $this->startDay = $day;
        return $this;
    }

    public function getStartMonth()
    {
        return $this->startMonth;
    }

    public function setStartMonth($month)
    {
        $this->startMonth = $month;
        return $this;
    }
    
	public function getWeekNumbers()
    {
        return $this->weekNumbers;
    }

    public function setWeekNumbers($value)
    {
    	$this->weekNumbers = $value;
        return $this;
    }
    
    public function getShowTooltip()
    {
    	return $this->showTooltip;
    }
    
    public function setShowTooltip($value)
    {
    	$this->showTooltip = $value;
    	return $this;
    }
    
    public function getServiceId() {
    	return $this->serviceId;
    }
    
    public function setServiceId($serviceId) {
    	$this->serviceId = $serviceId;
    	return $this;
    }
    
    public function getEmployeeId() {
    	return $this->employeeId;
    }
    
    public function setEmployeeId($employeeId) {
    	$this->employeeId = $employeeId;
    	return $this;
    }

    public function getCurrentMonthView()
    {
        $date = getdate(time());
        return $this->getMonthView($date["mon"], $date["year"]);
    }

    public function getMonthView($month, $year)
    {
        return $this->getMonthHTML($month, $year);
    }

    public function getDaysInMonth($month, $year)
    {
        if ($month < 1 || $month > 12)
        {
            return 0;
        }
   
        $day = $this->daysInMonth[$month - 1];
   
        if ($month == 2)
        {
            if ($year%4 == 0)
            {
                if ($year%100 == 0)
                {
                    if ($year%400 == 0)
                    {
                        $day = 29;
                    }
                } else {
                    $day = 29;
                }
            }
        }
    
        return $day;
    }

    public function onShowTooltip($timestamp)
    {
    	return '';
    }
    public function onBeforeShow($timestamp, $iso, $today, $current, $year, $month, $day)
    {
		if ($timestamp < $today[0])
		{
			$class = $this->classPast;
		} else {
			$class = $this->classCalendar;

			if ($year == $today["year"] && $month == $today["mon"] && $day == $today["mday"])
			{
				$class .= " " . $this->classToday;
			}
			if ($year == $current["year"] && $month == $current["mon"] && $day == $current["mday"])
			{
				$class .= " " . $this->classSelected;
			}
		}

		return $class;
    }
    
    public function getActionHTML($header, $prev_month, $prev_year, $next_month, $next_year)
    {
    	$str = "";
    	
    	$str .= '<div class="pj-calendar-actions">';
    	if($this->getShowPrevLink())
    	{
    		$str .= '<a class="btn btn-primary btn-sm pull-left '.$this->classMonthPrev.'" data-direction="prev" data-month="'.$prev_month.'" data-year="'.$prev_year.'" href="#"><span class="glyphicon glyphicon-chevron-left"></span></a>';
    	}
    	$str .= '<div class="pj-calendar-ym">Kalenderwoche '.$header.' </div>';
    	if($this->getShowNextLink())
    	{
    		$str .= '<a class="btn btn-primary btn-sm pull-right '.$this->classMonthNext.'" data-direction="next" data-month="'.$next_month.'" data-year="'.$next_year.'" href="#"><span class="glyphicon glyphicon-chevron-right"></span></a>';
    	}
    	$str .= '</div>';
    	
    	return $str;
    }
    
    //TODO
    public function getWeekHTML($inputWeek, $inputYear, $showYear = 1)
    {
    	$str = "";
    	
    	$arr = $this->updateYear($inputWeek, $inputYear);
    	$week = $arr[0];
    	$year = $arr[1];
    	
    	if($week < 10)
    	 	$stringTime = strtotime($year.'W0'.$week);
    	else
    		$stringTime = strtotime($year.'W'.$week);
    	//$str .= $week.'|'. $year.' time '.$stringTime." date ".date('n d',$stringTime);
    	
    	$monthDayFromWeek = explode(" ",date('n d',$stringTime));
    	$month = $monthDayFromWeek[0];
    	$firstDay = $monthDayFromWeek[1];
    	$daysInMonth = $this->getDaysInMonth($month, $year);
    	
    	//$str .= ' '.$month.'|'.$firstDay;
    	$monthName = $this->monthNames[$month];
    	 
    	$option_arr = $this->getOptions();
    	 
    	$search = array('Month', 'Year');
    	$replace = array($week, $showYear > 0 ? $year : "");//.' '.$monthName
    	$header = str_replace($search, $replace, $option_arr['o_month_year_format']);
    	$header.=" ".$monthName;
    	 
    	$prevW = ((int) $week - 1) < 1 ? 52 : (int) $week - 1;
    	$prevY = ((int) $week - 1) < 1 ? (int) $year - 1 : (int) $year;
    	 
    	$nextW = ((int) $week + 1) > 52 ? 1 : (int) $week + 1;
    	$nextY = ((int) $week + 1) > 52 ? (int) $year + 1 : (int) $year;
    	
    	$str .= '<div class="form-horizontal asEmployeeInfo">
    				<form class="pjAsAddToCartForm" action="" method="post">
    					<div class="form-group" style="display: block">
							<div class="col-lg-12 col-md-12 col-sm-12 col-sx-12">
								<div class="pjAsTableTimes">';

    	$str .= $this->getActionHTML($header, $prevW, $prevY, $nextW, $nextY);
    	
    	$cols = 7;
    	
    	if($this->getShowDayNames() == true)
    	{
    		$str .= '<div class="pj-calendar-head pj-calendar-'.$cols.'-columns">';
    		$str .= '<div class="pj-calendar-day-header"><p>'.$this->dayNames[($this->startDay)%7].'</p></div>';
    		$str .= '<div class="pj-calendar-day-header"><p>'.$this->dayNames[($this->startDay + 1)%7].'</p></div>';
    		$str .= '<div class="pj-calendar-day-header"><p>'.$this->dayNames[($this->startDay + 2)%7].'</p></div>';
    		$str .= '<div class="pj-calendar-day-header"><p>'.$this->dayNames[($this->startDay + 3)%7].'</p></div>';
    		$str .= '<div class="pj-calendar-day-header"><p>'.$this->dayNames[($this->startDay + 4)%7].'</p></div>';
    		$str .= '<div class="pj-calendar-day-header"><p>'.$this->dayNames[($this->startDay + 5)%7].'</p></div>';
    		$str .= '<div class="pj-calendar-day-header"><p>'.$this->dayNames[($this->startDay + 6)%7].'</p></div>';
    		$str .= '</div>';
    	}
    	$day = $this->startDay + $firstDay-1; //$this->startDay + 1 - $firstDay;
    	$str .= '<div class="pj-calendar-body pj-calendar-'.$cols.'-columns">';//.$month.' '.$day.' '.$year;
    	//$day = $this->startDay + 1 - $firstDay;
    	
    	$today = getdate(time());
    	$current = getdate($this->getCurrentDate());
    	 
    	$ts = $this->selectedTimeslot;
    	$start_ts = 0;
    	$end_ts = 0;
    	$selected_date = "";
    	
    		for ($i = 0; $i < 7; $i++)
    		{
    			$timestamp = mktime(0, 0, 0, $month, $day, $year);
    			$iso = date('Y-m-d', $timestamp);
    	
    				$class = $this->onBeforeShow($timestamp, $iso, $today, $current, $year, $month, $day);
    				$dayOfWeek = getdate($timestamp)['wday'];
    				if($dayOfWeek < 1 || $dayOfWeek>5)$class = $this->classReserved;
    				$timeSlotClass = "pjAsTimeAvailable";
    				$timeAsSlotClass = "asSlotAvailable";
    				if($class == $this->classPast || $class == $this->classReserved){
    					$timeSlotClass = "pjAsTimeUnavailable";
    					$timeAsSlotClass = "";
    				}
    				
    				//== $i."1")$timeSlotClass = "pjAsTimeSelected";
    				$dataDate = date('d-m-Y', $timestamp = mktime(0, 0, 0, $month, $day, $year));
    				
    				if($ts == $i."1"){
    					$start_ts = mktime( 9, 0, 0, $month, $day, $year);
    					$end_ts = mktime( 12, 0, 0, $month, $day, $year);
    					$selected_date = $dataDate;
    				}
    				if($ts == $i."2"){
    					$start_ts = mktime( 12, 0, 0, $month, $day, $year);
    					$end_ts = mktime( 15, 0, 0, $month, $day, $year);
    					$selected_date = $dataDate;
    				}
    				if($ts == $i."3"){
    					$start_ts = mktime( 15, 0, 0, $month, $day, $year);
    					$end_ts = mktime( 18, 0, 0, $month, $day, $year);
    					$selected_date = $dataDate;
    				}
    				
    				//$str .= "?".$timestamp."||".$iso."||".implode(" ",$today)."||".implode(" ",$current)."||".$class."||".$this->getCurrentDate()."?";
    				if($this->getShowTooltip() == true)
    				{
    					$tooltip = $this->onShowTooltip($timestamp);
    					$str .= '<div class="pj-calendar-day '.$class.'" data-iso="'.$iso.'" data-time="'.$timestamp.'"><p>'.$day.'</p>'.$tooltip.'</div>';
    				}else{
    					
    					
    					$str .= '<div class="pj-calendar-day '.$class.'" data-iso="'.$iso.'" data-time="'.$timestamp.'"><p>'.$day.'</p>'.
    					'<table class="table" border="0" cellpadding="0" cellspacing="0" width="100%">
							<tbody>						
    							<tr><td class="text-uppercase pjAsTime '.($ts == $i.'1' ? "pjAsTimeSelected" : $timeSlotClass ).'"><a href="#" class="asSlotBlock '.$timeAsSlotClass.'" data-tsid="'.$i.'1" data-date="'.$dataDate.'" data-end="07:00 AM" data-start_ts="'.mktime( 7, 0, 0, $month, $day, $year).'" data-end_ts="'.mktime( 9, 0, 0, $month, $day, $year).'" data-employee_id="1" data-service_id="'.$this->serviceId.'">7:00-9:00</a></td></tr>
								<tr><td class="text-uppercase pjAsTime '.($ts == $i.'2' ? "pjAsTimeSelected" : $timeSlotClass ).'"><a href="#" class="asSlotBlock '.$timeAsSlotClass.'" data-tsid="'.$i.'2" data-date="'.$dataDate.'" data-end="09:30 PM" data-start_ts="'.mktime( 9,30, 0, $month, $day, $year).'" data-end_ts="'.mktime(11,30, 0, $month, $day, $year).'" data-employee_id="1" data-service_id="'.$this->serviceId.'">9:30-11:30</a></td></tr>
								<tr><td class="text-uppercase pjAsTime '.($ts == $i.'3' ? "pjAsTimeSelected" : $timeSlotClass ).'"><a href="#" class="asSlotBlock '.$timeAsSlotClass.'" data-tsid="'.$i.'3" data-date="'.$dataDate.'" data-end="12:00 PM" data-start_ts="'.mktime(12, 0, 0, $month, $day, $year).'" data-end_ts="'.mktime(14, 0, 0, $month, $day, $year).'" data-employee_id="1" data-service_id="'.$this->serviceId.'">12:00-14:00</a></td></tr>
    							<tr><td class="text-uppercase pjAsTime '.($ts == $i.'4' ? "pjAsTimeSelected" : $timeSlotClass ).'"><a href="#" class="asSlotBlock '.$timeAsSlotClass.'" data-tsid="'.$i.'3" data-date="'.$dataDate.'" data-end="14:30 PM" data-start_ts="'.mktime(14,30, 0, $month, $day, $year).'" data-end_ts="'.mktime(16,30, 0, $month, $day, $year).'" data-employee_id="1" data-service_id="'.$this->serviceId.'">14:30-16:30</a></td></tr>
    							<tr><td class="text-uppercase pjAsTime '.($ts == $i.'5' ? "pjAsTimeSelected" : $timeSlotClass ).'"><a href="#" class="asSlotBlock '.$timeAsSlotClass.'" data-tsid="'.$i.'3" data-date="'.$dataDate.'" data-end="17:00 PM" data-start_ts="'.mktime(17, 0, 0, $month, $day, $year).'" data-end_ts="'.mktime(19, 0, 0, $month, $day, $year).'" data-employee_id="1" data-service_id="'.$this->serviceId.'">17:00-19:00</a></td></tr>
							</tbody>
						</table>
					</div>';
    				}
    		if($day < $daysInMonth)
    			$day++;
    		else 
    		{
    			$day = 1;
    			if($month + 1 > 12 ) {$year += 1;$month = 1;}
    			else $month += 1;
    		}
    		}
    		$str .= '</div>
    				<input type="hidden" name="employee_id" value="'.$this->employeeId.'">
    				<input type="hidden" name="date" value="'.$selected_date.'">
    				<input type="hidden" name="service_id" value="'.$this->serviceId.'">
					<input type="hidden" name="start_ts" value="'.$start_ts.'">
					<input type="hidden" name="end_ts" value="'.$end_ts.'">
    				
    				</div><!-- /.pjAsTableTimes -->
				</div><!-- /.col-lg-8 col-md-8 col-sm-8 col-sx-12 -->
			</div><!-- /.form-group -->
    		
			<div class="form-group">
				<div class="col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-sx-12">  
					<input class="btn btn-default pjAsBtn pjAsBtnPrimary pjAsBtnAppointment" value="den Termin buchen" type="submit" '.($start_ts != 0 ? "" : 'disabled="disabled"' ).'">
						<a href="#" class="btn btn-default pjAsBtn pjAsBtnSecondary pjAsBtnBackToServices">Cancel</a>
				</div><!-- /.col-lg-8 col-lg-offset-4 col-md-8 col-md-offset-4 col-sm-8 col-sm-offset-4 col-sx-12 -->
			</div><!-- /.form-group -->
    		
		</form>
	</div>';
    	
    	return $str;
    }
    
    static public function updateYear($week, $year)
    {
    	$arr = array();
    	$arr[0] = $week;
    	$arr[1] = $year;
    
    	while ($arr[0] > 52){
    		$arr[0] -= 52;
    		$arr[1]++;
    	}
    
    	while ($arr[0] <= 0){
    		$arr[0] += 52;
    		$arr[1]--;
    	}
    	return $arr;
    }
    
	public function getMonthHTML($inputMonth, $inputYear, $showYear = 1)
	{
		$str = "";

		$arr = $this->adjustDate($inputMonth, $inputYear);
        $month = $arr[0];
		$year = $arr[1];
        
    	$daysInMonth = $this->getDaysInMonth($month, $year);
    	$date = getdate(mktime(12, 0, 0, $month, 1, $year));
    	
    	$first = $date["wday"];
    	$monthName = $this->monthNames[$month];
    	
    	$option_arr = $this->getOptions();
    	
    	$search = array('Month', 'Year');
    	$replace = array($monthName, $showYear > 0 ? $year : "");
    	$header = str_replace($search, $replace, $option_arr['o_month_year_format']);
		    	
    	$prevM = ((int) $month - 1) < 1 ? 12 : (int) $month - 1;
    	$prevY = ((int) $month - 1) < 1 ? (int) $year - 1 : (int) $year;
    	
    	$nextM = ((int) $month + 1) > 12 ? 1 : (int) $month + 1;
    	$nextY = ((int) $month + 1) > 12 ? (int) $year + 1 : (int) $year;
    	
    	$cols = ($this->getWeekNumbers() == 'left' || $this->getWeekNumbers() == 'right') ? 8 : 7;
    	$str .= $this->getActionHTML($header, $prevM, $prevY, $nextM, $nextY);

    	if($this->getShowDayNames() == true)
    	{
	    	$str .= '<div class="pj-calendar-head pj-calendar-'.$cols.'-columns">';
	    	if($this->getWeekNumbers() == 'left')
	    	{
	    		$str .= '<div class="pj-calendar-day-header"><p>#</p></div>';
	    	}
	    	$str .= '<div class="pj-calendar-day-header"><p>'.$this->dayNames[($this->startDay)%7].'</p></div>';
	    	$str .= '<div class="pj-calendar-day-header"><p>'.$this->dayNames[($this->startDay + 1)%7].'</p></div>';
	    	$str .= '<div class="pj-calendar-day-header"><p>'.$this->dayNames[($this->startDay + 2)%7].'</p></div>';
	    	$str .= '<div class="pj-calendar-day-header"><p>'.$this->dayNames[($this->startDay + 3)%7].'</p></div>';
	    	$str .= '<div class="pj-calendar-day-header"><p>'.$this->dayNames[($this->startDay + 4)%7].'</p></div>';
	    	$str .= '<div class="pj-calendar-day-header"><p>'.$this->dayNames[($this->startDay + 5)%7].'</p></div>';
	    	$str .= '<div class="pj-calendar-day-header"><p>'.$this->dayNames[($this->startDay + 6)%7].'</p></div>';
	    	if($this->getWeekNumbers() == 'right')
	    	{
	    		$str .= '<div class="pj-calendar-day-header"><p>#</p></div>';
	    	}
	    	$str .= '</div>';
    	}
    	
    	$str .= '<div class="pj-calendar-body pj-calendar-'.$cols.'-columns">';
    	$day = $this->startDay + 1 - $first;
    	while ($day > 1)
    	{
    	    $day -= 7;
    	}

        $today = getdate(time());
		$current = getdate($this->getCurrentDate());
    	
        $rows = 0;
    	while ($day <= $daysInMonth)
    	{
    		if ($this->getWeekNumbers() == 'left')
    		{
    			$str .= '<div class="pj-calendar-day '.$this->classEmpty.'"><p>{WEEK_NUM}</p></div>';
    		}
    		for ($i = 0; $i < 7; $i++)
    	    {
    	    	$timestamp = mktime(0, 0, 0, $month, $day, $year);
    	    	$iso = date('Y-m-d', $timestamp);

        	    if ($day < 1 || $day > $daysInMonth) {
        	    	$str .= '<div class="pj-calendar-day '.$this->classEmpty.'"><p>&nbsp;</p></div>';
        	    } else {
        	    	$class = $this->onBeforeShow($timestamp, $iso, $today, $current, $year, $month, $day);
        	    	if($this->getShowTooltip() == true)
        	    	{
	        	    	$tooltip = $this->onShowTooltip($timestamp);
	        	    	$str .= '<div class="pj-calendar-day '.$class.'" data-iso="'.$iso.'" data-time="'.$timestamp.'"><p>'.$day.'</p>'.$tooltip.'</div>';
        	    	}else{
        	    		$str .= '<div class="pj-calendar-day '.$class.'" data-iso="'.$iso.'" data-time="'.$timestamp.'"><p>'.$day.'</p></div>';
        	    	}
        	    }
        	    $day++;
    	    }
    	    if ($this->getWeekNumbers() == 'right')
    	    {
    	    	$str .= '<div class="pj-calendar-day '.$this->classEmpty.'"><p>{WEEK_NUM}</p></div>';
    	    }
    	    
    	    if ($this->getWeekNumbers() == 'left' || $this->getWeekNumbers() == 'right')
    	    {
    	    	$str = str_replace('{WEEK_NUM}', date("W", $timestamp), $str);
    	    }
    	    $rows++;
    	}
    	
    	if ($rows == 5)
    	{
    		if ($cols == 7)
    		{
    			$str .=  str_repeat('<div class="pj-calendar-day '.$this->classEmpty.'"><p>&nbsp;</p></div>', $cols);
    		}
    	}
    	$str .= '</div>';
    	
    	return $str;
    }

    
    static public function adjustDate($month, $year)
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
	public function getSelectedTimeslot() {
		return $this->selectedTimeslot;
	}
	public function setSelectedTimeslot($selectedTimeslot) {
		$this->selectedTimeslot = $selectedTimeslot;
		return $this;
	}
	
}
?>