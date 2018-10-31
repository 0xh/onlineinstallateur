<?php

namespace CronDashboard\Classes;

class Proces 
{
	public $user;
	public $pid;
   	public $prname;
   	public $cpu;
   	public $mem;
   	public $vsz;
   	public $rss;
   	public $tty;
   	public $stat;
   	public $start;
   	public $time;
   	public $command;

   	public function __construct($user, $pid, $prname, $cpu, $mem, $vsz, $rss, $tty, $stat, $start, $time, $command)
   	{
   		$this->user 	= $user;
   		$this->pid 		= $pid;
   		$this->prname 	= $prname;
   		$this->cpu 		= $cpu;
   		$this->mem 		= $mem;
   		$this->vsz 		= $vsz;
   		$this->rss 		= $rss;
   		$this->tty 		= $tty;
   		$this->stat 	= $stat;
   		$this->start 	= $start;
   		$this->time 	= $time;
   		$this->command 	= $command;
   	}
}