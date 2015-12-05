<?php
class __USE_STATIC_ACCESS__Script implements ViewObjectsInterface
{
	//----------------------------------------------------------------------------------------------------
	//
	// Yazar      : Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	// Site       : www.zntr.net
	// Lisans     : The MIT License
	// Telif Hakkı: Copyright (c) 2012-2016, zntr.net
	//
	//----------------------------------------------------------------------------------------------------
	
	/* 
	 * Jquery Ready durumu 
	 *
	 * @var bool true 
	 */
	protected $ready = true;
	
	/* 
	 * Script text türü 
	 *
	 * @var string text/javascript 
	 */
	protected $type  = 'text/javascript';
	
	//----------------------------------------------------------------------------------------------------
	// Call Method
	//----------------------------------------------------------------------------------------------------
	// 
	// __call()
	//
	//----------------------------------------------------------------------------------------------------
	use CallUndefinedMethodTrait;
	
	//----------------------------------------------------------------------------------------------------
	// Error Control
	//----------------------------------------------------------------------------------------------------
	// 
	// $error
	// $success
	//
	// error()
	// success()
	//
	//----------------------------------------------------------------------------------------------------
	use ErrorControlTrait;
	
	/******************************************************************************************
	* TYPE                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Scriptin türünü ayarlamak için kullanılır.       	  		    		  |
	
	  @param string $type text/javascript
	  
	  @return this
	|          																				  |
	******************************************************************************************/
	public function type($type = 'text/javascript')
	{
		if( ! is_string($type) )
		{
			Error::set('Error', 'stringParameter', 'type');
			return $this;	
		}
		
		$this->type = $type;
		
		return $this;
	}
	
	/******************************************************************************************
	* LIBRARY                                                                                 *
	*******************************************************************************************
	| Genel Kullanım: Yüklemek istediğiniz harici script kütüphanelerini dahil etmek içindir. |
	
	  @param string arguments k1, k2 ... kN
	  
	  @return this
	|          																				  |
	******************************************************************************************/
	public function library()
	{
		$arguments = array_unique(func_get_args());
		Import::script($arguments);
		
		return $this;
	}
	
	/******************************************************************************************
	* OPEN                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Script tagını açmak için kullanılır.           	  		    		  |
	
	  @param bool $ready true
	  
	  @return string
	|          																				  |
	******************************************************************************************/
	public function open($ready = true)
	{		
		$this->ready = $ready;
		
		$eol     = eol();
		$script  = "";
		$script .= Import::script('jquery', true);
		$script .= "<script type=\"$this->type\">".$eol;
		
		if( $this->ready === true )
		{
			$script .= "$(document).ready(function()".$eol."{".$eol;
		}
		
		return $script;
	}

	/******************************************************************************************
	* CLOSE                                                                                   *
	*******************************************************************************************
	| Genel Kullanım: Script tagını kapatmak için kullanılır.          	  		    		  |
	
	  @param void
	  
	  @return string
	|          																				  |
	******************************************************************************************/
	public function close()
	{	
		$script = "";
		$eol    = eol();
		
		if( $this->ready === true )
		{
			$script .= $eol.'});';
		}
		
		$script .=  $eol.'</script>'.$eol;
		
		return $script;
	}	
}