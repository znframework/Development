<?php
namespace ZN\Services;

class InternalCrontab extends \Requirements implements CrontabInterface
{
	//----------------------------------------------------------------------------------------------------
	//
	// Yazar      : Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	// Site       : www.zntr.net
	// Lisans     : The MIT License
	// Telif Hakkı: Copyright (c) 2012-2016, zntr.net
	//
	//----------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------
	// Const CONFIG_NAME
	//----------------------------------------------------------------------------------------------------
	// 
	// @const string
	//
	//----------------------------------------------------------------------------------------------------
	const CONFIG_NAME  = 'Services:crontab';
	
	//----------------------------------------------------------------------------------------------------
	// Crontab Interval 
	//----------------------------------------------------------------------------------------------------
	// 
	// comands
	//
	//----------------------------------------------------------------------------------------------------
	use Crontab\IntervalTrait;	
	
	//----------------------------------------------------------------------------------------------------
	// Command
	//----------------------------------------------------------------------------------------------------
	// 
	// @var string
	//
	//----------------------------------------------------------------------------------------------------
	protected $command;
	
	//----------------------------------------------------------------------------------------------------
	// Type
	//----------------------------------------------------------------------------------------------------
	// 
	// @var string
	//
	//----------------------------------------------------------------------------------------------------
	protected $type;
	
	//----------------------------------------------------------------------------------------------------
	// Path
	//----------------------------------------------------------------------------------------------------
	// 
	// @var string
	//
	//----------------------------------------------------------------------------------------------------
	protected $path;
	
	//----------------------------------------------------------------------------------------------------
	// Callback
	//----------------------------------------------------------------------------------------------------
	// 
	// @var callback
	//
	//----------------------------------------------------------------------------------------------------
	protected $callback;
	
	//----------------------------------------------------------------------------------------------------
	// After
	//----------------------------------------------------------------------------------------------------
	// 
	// @var callback
	//
	//----------------------------------------------------------------------------------------------------
	protected $after;
	
	//----------------------------------------------------------------------------------------------------
	// Before
	//----------------------------------------------------------------------------------------------------
	// 
	// @var callback
	//
	//----------------------------------------------------------------------------------------------------
	protected $before;
	
	//----------------------------------------------------------------------------------------------------
	// Driver
	//----------------------------------------------------------------------------------------------------
	// 
	// @var string
	//
	//----------------------------------------------------------------------------------------------------
	protected $driver;
	
	//----------------------------------------------------------------------------------------------------
	// Debug
	//----------------------------------------------------------------------------------------------------
	// 
	// @var boolean: false
	//
	//----------------------------------------------------------------------------------------------------
	protected $debug = false;
	
	//----------------------------------------------------------------------------------------------------
	// Driver
	//----------------------------------------------------------------------------------------------------
	// 
	// @var string
	//
	//----------------------------------------------------------------------------------------------------
	protected $crontabDir = '';
	
	//----------------------------------------------------------------------------------------------------
	// Jobs
	//----------------------------------------------------------------------------------------------------
	// 
	// @var array
	//
	//----------------------------------------------------------------------------------------------------
	protected $jobs = [];
	
	//----------------------------------------------------------------------------------------------------
	// Constructor
	//----------------------------------------------------------------------------------------------------
	// 
	// __costruct()
	//
	//----------------------------------------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
		
		$this->driver     = $this->config['driver'];	
		
		$this->debug 	  = $this->config['debug'] === true 
						  ? $this->config['debug']
						  : false;
			
		$this->crontabDir = str_replace('/', DIRECTORY_SEPARATOR, REAL_BASE_DIR.STORAGE_DIR.'Crontab'.DIRECTORY_SEPARATOR);
		
		if( $this->driver !== 'ssh' && ! function_exists($this->driver) )
		{
			die( getErrorMessage('Error', 'undefinedFunctionExtension', $this->driver) );	
		}
	}
	
	//----------------------------------------------------------------------------------------------------
	// Driver
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  string $driver: empty
	// @return object
	//
	//----------------------------------------------------------------------------------------------------
	public function driver($driver = '')
	{
		$this->driver = $driver;
		
		return $this;
	}
	
	//----------------------------------------------------------------------------------------------------
	// Connect
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  string $path: empty
	// @return object
	//
	//----------------------------------------------------------------------------------------------------
	public function connect($config = [])
	{
		\SSH::connect($config);
		
		return $this;	
	}
	
	//----------------------------------------------------------------------------------------------------
	// Path
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  string $path: empty
	// @return object
	//
	//----------------------------------------------------------------------------------------------------
	public function path($path = '')
	{
		if( empty($path) )
		{
			$path = $this->config['path'];	
		}
		
		$this->path = $path;
		
		return $this;	
	}
	
	//----------------------------------------------------------------------------------------------------
	// Roster
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  void
	// @return string
	//
	//----------------------------------------------------------------------------------------------------
	public function roster()
	{
		return $this->_exec('crontab -l');
	}
	
	//----------------------------------------------------------------------------------------------------
	// Create File
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  string $name: crontab.txt
	// @return object
	//
	//----------------------------------------------------------------------------------------------------
	public function createFile($name = 'crontab.txt')
	{
		if( ! is_dir($this->crontabDir) )
		{
			\Folder::create($this->crontabDir);
		}
		else
		{
			$cronFile = $this->crontabDir.$name;
			
			if( ! is_file($cronFile) )
			{
				$command = 'crontab -l > '.$cronFile.' && [ -f '.$cronFile.' ] || > '.$cronFile;
 
				return $this->_exec($command);
			}
		}
	}
	
	//----------------------------------------------------------------------------------------------------
	// Delete File
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  string $name: crontab.txt
	// @return object
	//
	//----------------------------------------------------------------------------------------------------
	public function deleteFile($name = 'crontab.txt')
	{
		$cronFile = $this->crontabDir.$name;
			
		if( is_file($cronFile) )
		{
			$command = 'rm '.$cronFile;

			return $this->_exec($command);
		}
	}
	
	//----------------------------------------------------------------------------------------------------
	// Remove
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  string $name: crontab.txt
	// @return object
	//
	//----------------------------------------------------------------------------------------------------
	public function remove($name = 'crontab.txt')
	{
		$this->deleteFile($name);
		
		return $this->_exec('crontab -r');
	}
	
	//----------------------------------------------------------------------------------------------------
	// Add
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  void
	// @return object
	//
	//----------------------------------------------------------------------------------------------------
	public function add()
	{		
		$command = $this->_command();
		
		$this->_defaultVariables();
		
		$this->jobs[] = $command;
		
		return $this;
	}	
	
	//----------------------------------------------------------------------------------------------------
	// Run
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  string $cmd: empty
	// @return string
	//
	//----------------------------------------------------------------------------------------------------
	public function run($cmd = '')
	{
		$command = '';	
		
		if( empty($this->jobs) )
		{	
			$command = $this->_command();
			
			if( ! empty($cmd) )
			{
				$command = $cmd;	
			}
			
			return $this->_exec($command);
		}
		else
		{
			$jobs = $this->jobs;
			
			$this->jobs = [];	
			
			foreach( $jobs as $job )
			{
				$this->_exec($job);	
			}	
			
			return true;
		}	
	}	
	
	//----------------------------------------------------------------------------------------------------
	// Protected Exec
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  string $command: empty
	// @return string
	//
	//----------------------------------------------------------------------------------------------------
	protected function _exec($command)
	{
		$driver  = $this->driver;
		
		\Buffer::select('before');
		
		\Buffer::select('callback');
		
		$return = $driver === 'ssh'
		 		? \SSH::run($command)
				: $driver($command);
		
		\Buffer::select('after');
		
		return $return;
	}
	
	//----------------------------------------------------------------------------------------------------
	// Protected Command Fix
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  string $command: empty
	// @return string
	//
	//----------------------------------------------------------------------------------------------------
	protected function _commandFix($command = '')
	{
		if( strlen($command) === 1 )
		{
			return prefix($command, '-');	
		}
		
		return $command;
	}
	
	//----------------------------------------------------------------------------------------------------
	// Debug
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  bool   $status: true
	// @return object
	//
	//----------------------------------------------------------------------------------------------------
	public function debug($status = true)
	{
		$this->debug = $status;
		
		return $this;
	}

	//----------------------------------------------------------------------------------------------------
	// Command
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  string $command: empty
	// @return object
	//
	//----------------------------------------------------------------------------------------------------
	public function command($command = '')
	{
		$fix = '';
		
		$command = str_replace('-', '', $command);
		$command = preg_replace('/\s+/', ' ', $command);
		
		if( strstr($command, ' ') )
		{
			$commands = explode(' ', $command);
			
			$commandJoin = '';
			
			foreach( $commands as $cmd )
			{
				$commandJoin .= $this->_commandFix($cmd).' ';	
			}
			
			$this->command = rtrim($commandJoin, ' ');
		}
		else
		{
			$this->command = $this->_commandFix($command);
		}
		
		return $this;
	}
	
	//----------------------------------------------------------------------------------------------------
	// Callback
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  function $callback: empty
	// @return object
	//
	//----------------------------------------------------------------------------------------------------
	public function callback($callback = '')
	{
		\Buffer::insert('callback', $callback);
		
		return $this;	
	}
	
	//----------------------------------------------------------------------------------------------------
	// After
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  function $callback: empty
	// @return object
	//
	//----------------------------------------------------------------------------------------------------
	public function after($callback = '')
	{
		\Buffer::insert('after', $callback);
		
		return $this;	
	}
	
	//----------------------------------------------------------------------------------------------------
	// Before
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  function $callback: empty
	// @return object
	//
	//----------------------------------------------------------------------------------------------------
	public function before($callback = '')
	{
		\Buffer::insert('before', $callback);
		
		return $this;	
	}
	
	//----------------------------------------------------------------------------------------------------
	// File
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  string $file: empty
	// @return string
	//
	//----------------------------------------------------------------------------------------------------
	public function file($file = '')
	{
		$this->type = REAL_BASE_DIR.$file;
		
		return $this;	
	}
	
	//----------------------------------------------------------------------------------------------------
	// Url
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  string $file: empty
	// @param  bool   $type: wget, get, curl
	// @return string
	//
	//----------------------------------------------------------------------------------------------------
	public function url($url = '')
	{
		if( ! isUrl($url) )
		{
			$url = siteUrl($url);
		}
		
		$this->type = $url;
		
		return $this;	
	}
	
	//----------------------------------------------------------------------------------------------------
	// Protected Date Time
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  void
	// @return string
	//
	//----------------------------------------------------------------------------------------------------
	protected function _datetime()
	{
		if( $this->interval !== '* * * * *' )
		{
			$interval = $this->interval.' ';	
		}
		else
		{
			$interval = ( isset( $this->minute )    ? $this->minute    : '*').' '.
			   			( isset( $this->hour )      ? $this->hour 	   : '*').' '.
			   			( isset( $this->dayNumber ) ? $this->dayNumber : '*').' '.
			   			( isset( $this->month )   	? $this->month	   : '*').' '.
			   			( isset( $this->day ) 		? $this->day       : '*').' ';
		}
		
		$this->_intervalDefaultVariables();
		
		return $interval;
	}
	
	//----------------------------------------------------------------------------------------------------
	// Protected Date Time
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  void
	// @return string
	//
	//----------------------------------------------------------------------------------------------------
	protected function _command()
	{
		$datetimeFormat = $this->_datetime();
		$type			= $this->type;
		$path			= $this->path;
		$command		= $this->command; 	
		$debug			= $this->debug;	
		
		$match = '(\*|[0-9]{1,2}|\*\/[0-9]{1,2}|[0-9]{1,2}\s*\-\s*[0-9]{1,2}|(([0-9]{1,2})*\s*\,\s*[0-9]{1,2})+)\s+';
		
		if( ! preg_match('/^'.$match.$match.$match.$match.$match.'$/', $datetimeFormat) )
		{
			return \Exceptions::throws('Services', 'crontabTimeFormatError');
		}
		else
		{
			return $datetimeFormat.
				   ( ! empty($path)    ? $path.' ' 	  : '' ).
				   ( ! empty($command) ? $command.' ' : '' ).
				   ( ! empty($type)    ? $type.' ' 	  : '' ).
				   ( $debug === true   ? '>> '.$this->crontabDir.'debug.log 2>&1' : '' );
		}	   
	}
	
	//----------------------------------------------------------------------------------------------------
	// Protected Date Time
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  void
	// @return void
	//
	//----------------------------------------------------------------------------------------------------
	protected function _defaultVariables()
	{
		$this->type  	= NULL;
		$this->path 	= NULL;
		$this->command 	= NULL;	
		$this->callback = NULL;	
		$this->after 	= NULL;	
		$this->before	= NULL;	
		$this->debug 	= false;	
	}
	
	//----------------------------------------------------------------------------------------------------
	// Protected Date Time
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  void
	// @return void
	//
	//----------------------------------------------------------------------------------------------------
	protected function _intervalDefaultVariables()
	{
		$this->interval	 = '* * * * *';
		$this->minute    = '*';
	    $this->hour		 = '*';
	    $this->dayNumber = '*';
	  	$this->month	 = '*';
	   	$this->day		 = '*';
	}
}