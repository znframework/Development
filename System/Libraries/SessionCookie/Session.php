<?php
class __USE_STATIC_ACCESS__Session
{
	/***********************************************************************************/
	/* SESSION COMPONENT	   	     		                   	                       */
	/***********************************************************************************/
	/* Yazar: Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	/* Site: www.zntr.net
	/* Lisans: The MIT License
	/* Telif Hakkı: Copyright (c) 2012-2015, zntr.net
	/*
	/* Sınıf Adı: Session
	/* Versiyon: 1.2
	/* Tanımlanma: Dinamik
	/* Dahil Edilme: Gerektirmez
	/* Erişim: Session:: $this->Session, zn::$use->Session, uselib('Session')
	/* Not: Büyük-küçük harf duyarlılığı yoktur.
	/***********************************************************************************/
	
	protected $name;
	protected $value;
	protected $regenerate = true;
	protected $encode = array();
	protected $error;
	
	/* Config Değişkeni
	 *  
	 * Oturum ayar bilgisini
	 * tutması için oluşturulmuştur.
	 *
	 */
	protected $config;
	
	public function __construct()
	{
		Config::iniSet(Config::get('Session','settings'));
		
		$this->config = Config::get('Session');
		
		if( ! isset($_SESSION) ) 
		{
			session_start();
		}
	}
	
	/******************************************************************************************
	* CALL                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Geçersiz fonksiyon girildiğinde çağrılması için.						  |
	|          																				  |
	******************************************************************************************/
	public function __call($method = '', $param = '')
	{	
		die(getErrorMessage('Error', 'undefinedFunction', "Session::$method()"));	
	}
	
	public function name($name = '')
	{
		if( ! isChar($name))
		{
			Error::set(lang('Error', 'valueParameter', 'name'));
			return $this;		
		}
		
		$this->name = $name;
		
		return $this;
	}
	
	public function encode($name = '', $value = '')
	{
		if( ! ( isHash($name) || isHash($value) ) )
		{
			Error::set(lang('Error', 'hashParameter', 'name | value'));
			return $this;		
		}
		
		$this->encode['name'] = $name;
		$this->encode['value'] = $value;
		
		return $this;
	}
	
	public function decode($hash = '')
	{
		if( ! isHash($hash))
		{
			Error::set(lang('Error', 'hashParameter', 'hash'));
			return $this;	
		}
		
		$this->encode['name'] = $hash;
		
		return $this;
	}
	
	public function value($value = '')
	{
		$this->value = $value;
		
		return $this;
	}

	public function regenerate($regenerate = true)
	{
		if( ! is_bool($regenerate) )
		{
			Error::set(lang('Error', 'booleanParameter', 'regenerate'));
			return $this;		
		}
		
		$this->regenerate = $regenerate;
		
		return $this;
	}
	
	/******************************************************************************************
	* INSERT                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Oturum oluşturmak için kullanılır.								      |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @name => Oluşturulacak oturumun adı.		    					      |
	| 2. mixed var @value => Oluşturulacak oturumun tutacağı değer.         			      |
	|          																				  |
	| Örnek Kullanım: insert('isim', 'Değer');       										  |
	| Not: Application/Config/Session.php dosyası üzerinden ayarlarını yapılandırabilirsiniz. |
	|          																				  |
	******************************************************************************************/
	public function insert($name = '', $value = '')
	{
		if( ! empty($name) ) 
		{
			if( ! isChar($name) )
			{
				Error::set(lang('Error', 'valueParameter', 'name'));
				return false;
			}
			
			$this->name($name);
		}
		
		if( ! empty($value) )
		{
			$this->value($value);	
		}
		
		if( ! empty($this->encode) )
		{
			if( isset($this->encode['name']) )
			{
				if( isHash($this->encode['name']) )
				{
					$this->name = hash($this->encode['name'], $this->name);		
				}		
			}
			
			if( isset($this->encode['value']) )
			{
				if( isHash($this->encode['value']) )
				{
					$this->value = hash($this->encode['value'], $this->value);	
				}
			}
		}
		
		$sessionConfig = $this->config;
	
		if( ! isset($this->encode['name']))
		{
			if($sessionConfig["encode"] === true)
			{
				$this->name = md5($this->name);
			}
		}
		
		$_SESSION[$this->name] = $this->value;
		
		if( $_SESSION[$this->name] )
		{
			if( $this->regenerate === true )
			{
				session_regenerate_id();	
			}
			
			$this->_defaultVariable();
			
			return true;	
		}
		else
		{
			return false;
		}
	} 
	
	public function select($name = '')
	{
		if( ! is_scalar($name) || empty($name) )
		{
			return Error::set(lang('Error', 'valueParameter', 'name'));	
		}
		
		if( isset($this->encode['name']) )
		{
			if( isHash($this->encode['name']) )
			{
				$name = hash($this->encode['name'], $name);		
				$this->encode = array();	
			}		
		}
		else
		{
			if( $this->config['encode'] === true )
			{
				$name = md5($name);
			}
		}
		
		if( isset($_SESSION[$name]) )
		{
			return $_SESSION[$name];
		}
		else
		{
			return false;	
		}
	}
	
	public function delete($name = '')
	{
		if( ! is_scalar($name) || empty($name) )
		{
			return Error::set(lang('Error', 'valueParameter', 'name'));	
		}	
		
		$sessionConfig = $this->config;
		
		if( isset($this->encode['name']) )
		{
			if( isHash($this->encode['name']) )
			{
				$name = hash($this->encode['name'], $name);	
				$this->encode = array();	
			}		
		}
		else
		{
			if( $sessionConfig["encode"] === true )
			{
				$name = md5($name);
			}
		}
		
		if( isset($_SESSION[$name]) )
		{ 	
			unset($_SESSION[$name]);
		}
		else
		{ 
			return false;		
		}
	}
	
	/******************************************************************************************
	* SELECT ALL                                                                              *
	*******************************************************************************************
	| Genel Kullanım: Oluşturulmuş tüm oturumlara erişmek için kullanılır.				      |
	|															                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	|          																				  |
	| Örnek Kullanım: selectAll();       										              |
	|          																				  |
	******************************************************************************************/
	public function selectAll()
	{
		return $_SESSION;	
	}
	
	/******************************************************************************************
	* DELETE ALL                                                                              *
	*******************************************************************************************
	| Genel Kullanım: Oluşturulmuş tüm oturumları silmek için kullanılır.				      |
	|															                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	|          																				  |
	| Örnek Kullanım: deleteAll();       										              |
	|          																				  |
	******************************************************************************************/
	public function deleteAll()
	{
		session_destroy();
	}
	
	public function error()
	{
		if( ! empty($this->error) )
		{
			Error::set($this->error);
			return $this->error;
		}
		else
		{
			return false;	
		}
	}
	
	protected function _defaultVariable()
	{
		if( ! empty($this->name)) 	  $this->name 	  	= NULL;
		if( ! empty($this->value)) 	  $this->value 	  	= NULL;
		if( ! empty($this->encode))   $this->encode   	= array();
		if($this->regenerate !== true)$this->regenerate  = true;
	}
}