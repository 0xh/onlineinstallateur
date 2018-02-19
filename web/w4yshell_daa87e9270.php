<?php
/*
	Copyright (c) 2018 All Rights Reserved, World4You Internet Services GmbH
	Product: World4You Terminal
	Version: 1.1
	Webpage: https://www.world4you.com/
 */


	$lifetime = 3600*4; // = 4h
	if(filectime(__FILE__) + $lifetime < time())
	{
		echo "ERR:Timeout\n";
	 	unlink(__FILE__);
	 	exit();
	}
 
	if($_SERVER['REMOTE_ADDR'] != '81.19.145.14')
	{
		exit();
	}

	class w4yshell
	{
		private $path = null;

		public function __construct()
		{
			if(isset($_REQUEST['path']) && strlen($_REQUEST['path']))
				$this->path = $_REQUEST['path'];

			if(isset($_REQUEST['action']))
				$this->parseAction($_REQUEST['action']);
			elseif(isset($_REQUEST['cmd']))
				$this->parseCmd($_REQUEST['cmd']);
		}


		public function parseAction($action, $path = null)
		{
			if($action == 'pwd') {
				if($this->path)
				{
					set_error_handler(function($errno, $errstr, $errfile, $errline, array $errcontext) {
						throw new ErrorException($errstr, $errno, $errno, $errfile, $errline);
					});

					try {
						if(is_dir($this->path))	
						{
							chdir($this->path);
						} else 
						{
							echo "ERR:Verzeichnis nicht gefunden\r\n";
							exit();
						}
					} catch(ErrorException $e) {
						$errcode = $e->getCode();
						if($errcode == 2) 
							echo "ERR:Keine Berechtigung für dieses Verzeichnis\r\n";
						else 
							echo "ERR:Fehler beim wechseln zum Verzeichnis\r\n";
						exit();
					}
					restore_error_handler();
				}
				echo 'OUTPUT:'.getcwd();
			} elseif($action == 'gethome') 
			{
				echo 'OUTPUT:'.dirname(__FILE__);
			}
		}


		public function parseCmd($cmd)
		{
			$this->outputBufferOff();

			if(!is_string($this->path)) 
			{
				$this->path = dirname(__FILE__);
			}
			chdir($this->path);

			putenv('ROWS=30');
			putenv('COLUMNS=100');
			putenv('TERM=xterm');
			putenv('COLORTERM=1');
			putenv('PS1=\u $');

			$cmd = $this->getAlias($cmd);

			$this->runCmd($cmd);

			$pwu_data = posix_getpwuid(posix_geteuid());
			$username = $pwu_data['name'];

			echo "\033[1;37m[" . $username . '@' . idn_to_utf8($_SERVER['HTTP_HOST']) . "]$ \033[0m";
		}


		private function getAlias($cmd)
		{
			$alias = array(
				'grep' => 'grep --color=always',
				'egrep' => 'egrep --color=always',
				'fgrep' => 'fgrep --color=always',
				'dir' => 'ls --color=always',
				'ls' => 'ls --color=always -h',
				'll' => 'ls --color=always -lah',
				'ping' => 'ping -c4'
			);

			$bin = explode(" ", $cmd);
			$bin = trim($bin[0]);

			if(isset($alias[$bin]))
				$cmd = str_replace($bin, $alias[$bin], $cmd);

			return $cmd;
		}


		private function outputBufferOff() 
		{
			ini_set('output_buffering', 'Off');
			ini_set('zlib.output_compression', 'Off');
			ini_set('implicit_flush', 1);
			ob_implicit_flush(1);

			header("Cache-Control: no-cache");
			header("Cache-Control: private");
			header("Pragma: no-cache");	
			header("Content-type: text/plain");
		}


		private function runCmd($cmd)
		{
			$pipe = array();
			$descspec = array(1 => array('pipe', 'w'));

			echo 'OUTPUT:';

			if(strlen($cmd)) 
			{
				$p = proc_open(''.$cmd. ' 2>&1', $descspec, $pipe);
				
				if(is_resource($p))
				{
					$output = '';

					while (isset($pipe[1]) && $pipe[1] && !feof($pipe[1])) {
						$line=fgets($pipe[1]);
						if (function_exists('mb_convert_encoding')) {
							$line = mb_convert_encoding($line, 'UTF-8', 'UTF-8');
						}
						echo str_replace("\n", "\r\n", $line);
						ob_flush();
						ob_implicit_flush();
						flush();
					}

					fclose($pipe[1]);
					proc_close($p);
				}
			}
		}

	}

	$shell = new w4yshell();
