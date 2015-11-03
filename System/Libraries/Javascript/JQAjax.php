<?php
class __USE_STATIC_ACCESS__JQAjax extends JSCommon
{
	/***********************************************************************************/
	/* JQUERY AJAX LIBRARY    	     		                   	                       */
	/***********************************************************************************/
	/* Yazar: Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	/* Site: www.zntr.net
	/* Lisans: The MIT License
	/* Telif Hakkı: Copyright (c) 2012-2015, zntr.net
	/*
	/* Sınıf Adı: JQAjax
	/* Versiyon: 1.2
	/* Güncellemeler: 2.0 Eylül
	/* Tanımlanma: Dinamik
	/* Dahil Edilme: Gerektirmez
	/* Erişim: JQAjax::, $this->JQAjax, zn::$use->JQAjax, uselib('JQAjax')
	/* Not: Büyük-küçük harf duyarlılığı yoktur.
	/***********************************************************************************/
	
	/* 
	 * Fonksiyon blokları 
	 *
	 * success, error, complete...
	 *
	 * @var array
	 */
	protected $functions = array();
	
	/* 
	 * Ayar blokları
	 *
	 * url, method, data...
	 *
	 * @var array
	 */
	protected $sets = array();
	
	/* Dönüş fonksiyon blokları
	 *
	 * .done, .always, .then .fail
	 *
	 * @var array 
	 */
	protected $callbacks = array();
	
	/******************************************************************************************
	* CALL                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Geçersiz fonksiyon girildiğinde çağrılması için.						  |
	|          																				  |
	******************************************************************************************/
	public function __call($method = '', $param = '')
	{	
		die(getErrorMessage('Error', 'undefinedFunction', "JQAjax::$method()"));	
	}
	
	/******************************************************************************************
	* URL                                                                                     *
	*******************************************************************************************
	| Genel Kullanım: Url parametresini ayarlamak için kullanılır.				    		  |
	
	  @param string $url
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function url($url = '')
	{
		if( ! is_string($url) )
		{
			Error::set(lang('Error', 'stringParameter', '1.(url)'));
			return $this;	
		}
		
		// Veri bir url içermiyorsa siteUrl yöntemi ile url'ye dönüştürülür.
		if( ! isUrl($url) )
		{
			$url = siteUrl($url);	
		}
		
		$this->sets['url'] = "\turl:\"$url\",".eol();
		
		return $this;	
	}
	
	/******************************************************************************************
	* DATA                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Gönderilen Veri parametresini ayarlamak için kullanılır.				  |
	
	  @param string $data
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function data($data = '')
	{
		if( ! is_scalar($data) )
		{
			Error::set(lang('Error', 'valueParameter', '1.(data)'));
			return $this;	
		}
		
		$this->sets['data'] = "\tdata:$data,".eol();
		
		return $this;	
	}
	
	/******************************************************************************************
	* HEADERS                                                                                 *
	*******************************************************************************************
	| Genel Kullanım: Başlıklar parametresini ayarlamak için kullanılır.		    		  |
	
	  @param string $headers
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function headers($headers = '')
	{
		if( ! is_scalar($headers) )
		{
			Error::set(lang('Error', 'valueParameter', '1.(headers)'));
			return $this;	
		}
		
		$this->sets['headers'] = "\theaders:$headers,".eol();
		
		return $this;	
	}
	
	/******************************************************************************************
	* IF MODIFIED                                                                             *
	*******************************************************************************************
	| Genel Kullanım: If Modified parametresini ayarlamak için kullanılır.		    		  |
	
	  @param bool $ifModified true
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function ifModified($ifModified = true)
	{
		if( ! is_scalar($ifModified) )
		{
			Error::set(lang('Error', 'valueParameter', '1.(isModified)'));
			return $this;	
		}
		
		// Mantıklasal veri metinsel veriye dönüştürülüyor.
		$ifModified = $this->_boolToStr($ifModified);
		
		$this->sets['ifModified'] = "\tifModified:$ifModified,".eol();
		
		return $this;	
	}
	
	/******************************************************************************************
	* IS LOCAL                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Is Local parametresini ayarlamak için kullanılır.	    	    		  |
	
	  @param bool $isLocal true
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function isLocal($isLocal = true)
	{
		if( ! is_scalar($isLocal) )
		{
			Error::set(lang('Error', 'valueParameter', '1.(isLocal)'));
			return $this;	
		}
		
		$isLocal = $this->_boolToStr($isLocal);
		
		$this->sets['isLocal'] = "\tisLocal:$isLocal,".eol();
		
		return $this;	
	}
	
	
	/******************************************************************************************
	* MIME TYPE                                                                               *
	*******************************************************************************************
	| Genel Kullanım: MIME Type parametresini ayarlamak için kullanılır.	  	    		  |
	
	  @param bool $mimeType true
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function mimeType($mimeType = true)
	{
		if( ! isValue($mimeType) )
		{
			Error::set(lang('Error', 'valueParameter', 'mimeType'));
			return $this;	
		}
		
		$mimeType = $this->_boolToStr($mimeType);
		$this->sets['mimeType'] = "\tmimeType:$mimeType,".eol();
		
		return $this;	
	}
	
	/******************************************************************************************
	* JSONP                                                                                   *
	*******************************************************************************************
	| Genel Kullanım: Jsonp parametresini ayarlamak için kullanılır.     	  	    		  |
	
	  @param string/bool $jsonp
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function jsonp($jsonp = '')
	{
		if( is_bool($jsonp) )
		{
			$jsonp = $this->_boolToStr($jsonp);	
		}
		elseif( is_string($jsonp) )
		{
			$jsonp = "\"$jsonp\"";
		}
		else
		{
			return $this;
		}
		
		$this->sets['jsonp'] = "\tjsonp:$jsonp,".eol();
		
		return $this;	
	}
	
	/******************************************************************************************
	* JSONP CALLBACK                                                                          *
	*******************************************************************************************
	| Genel Kullanım: Jsonp Callback parametresini ayarlamak için kullanılır.   	   		  |
	
	  @param string $jsonpCallback
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function jsonpCallback($jsonpCallback = '')
	{
		if( ! isValue($jsonpCallback) )
		{
			Error::set(lang('Error', 'valueParameter', 'jsonpCallback'));
			return $this;	
		}
		
		if( $this->_isFunc($jsonpCallback) === false )
		{
			$jsonpCallback = "\"$jsonpCallback\"";
		}
		
		$this->sets['jsonpCallback'] = "\tjsonpCallback:$jsonpCallback,".eol();
		
		return $this;	
	}
	
	/******************************************************************************************
	* DATA TYPE                                                                               *
	*******************************************************************************************
	| Genel Kullanım: Data Type parametresini ayarlamak için kullanılır.  		 	   		  |
	
	  @param string $type
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function dataType($type = '')
	{
		if( ! is_string($type) )
		{
			Error::set(lang('Error', 'stringParameter', 'type'));
			return $this;	
		}
		
		$this->sets['type'] = "\tdataType:\"$type\",".eol();
		
		return $this;
	}
	
	// PASSWORD Property -------------------------------------------------------
	// password data
	// password:string
	public function password($password = '')
	{
		if( ! is_string($password) )
		{
			Error::set(lang('Error', 'stringParameter', 'password'));
			return $this;	
		}
		
		$this->sets['password'] = "\tpassword:\"$password\",".eol();
		
		return $this;
	}
	
	// USERNAME Property -------------------------------------------------------
	// username data
	// username:string
	public function username($username = '')
	{
		if( ! is_string($username) )
		{
			Error::set(lang('Error', 'stringParameter', 'username'));
			return $this;	
		}
		
		$this->sets['username'] = "\tusername:\"$username\",".eol();
		
		return $this;
	}
	
	// METHOD/TYPE Property ----------------------------------------------------
	// type() = method() 
	// type data
	// type:string : post, get ...
	public function method($method = 'post')
	{
		if( ! is_string($method) )
		{
			Error::set(lang('Error', 'stringParameter', 'method'));
			return $this;	
		}
		
		$this->sets['method'] = "\ttype:\"$method\",".eol();
		
		return $this;
	}
	
	// METHOD/TYPE Property ----------------------------------------------------
	// type() = method() 
	// type data
	// type:string : post, get ...
	public function type($method = 'post')
	{
		$this->method($method);
		
		return $this;
	}
	
	// SCRIPT CHARSET Property -------------------------------------------------------
	// scriptCharset data
	// scriptCharset:string
	public function scriptCharset($scriptCharset = 'utf-8')
	{
		if( ! isCharset($scriptCharset) )
		{
			Error::set(lang('Error', 'charsetParameter', 'scriptCharset'));
			return $this;	
		}
		
		$this->sets['scriptCharset'] = "\tscriptCharset:\"$scriptCharset\",".eol();
		
		return $this;
	}
	
	// TRADITIONAL Property -------------------------------------------------------
	// traditional data
	// traditional:bool: true or false
	public function traditional($traditional = true)
	{
		if( ! isValue($traditional) )
		{
			Error::set(lang('Error', 'valueParameter', 'traditional'));
			return $this;	
		}
		
		$traditional = $this->_boolToStr($traditional);
		$this->sets['traditional'] = "\ttraditional:$traditional,".eol();
		
		return $this;
	}
	
	// PROCESS DATA Property -------------------------------------------------------
	// processData data
	// processData:bool: true or false
	public function processData($processData = true)
	{
		if( ! isValue($processData) )
		{
			Error::set(lang('Error', 'valueParameter', 'processData'));
			return $this;	
		}
		
		$processData = $this->_boolToStr($processData);
		$this->sets['processData'] = "\tprocessData:$processData,".eol();
		
		return $this;
	}
	
	// CACHE Property -------------------------------------------------------
	// cache data
	// cache:bool: true or false
	public function cache($cache = true)
	{
		if( ! isValue($cache) )
		{
			Error::set(lang('Error', 'valueParameter', 'cache'));
			return $this;	
		}
		
		$cache = $this->_boolToStr($cache);
		$this->sets['cache'] = "\tcache:$cache,".eol();
		
		return $this;
	}
	
	// XHR FIELDS Property -------------------------------------------------------
	// xhrFields data
	// xhrFields:string
	public function xhrFields($xhrFields = '')
	{
		if( ! is_string($xhrFields) )
		{
			Error::set(lang('Error', 'stringParameter', 'xhrFields'));
			return $this;	
		}
		
		$this->sets['xhrFields'] = "\txhrFields:$xhrFields,".eol();
		
		return $this;
	}
	
	// CONTEXT Property -------------------------------------------------------
	// context data
	// context:plain object
	public function context($context = '')
	{
		if( ! isValue($context) )
		{
			Error::set(lang('Error', 'valueParameter', 'context'));
			return $this;	
		}
		
		$this->sets['context'] = "\tcontext:$context,".eol();
		
		return $this;
	}
	
	// ACCEPTS Property -------------------------------------------------------
	// accepts data
	// accepts:plain object
	public function accepts($accepts = '')
	{
		if( ! is_string($accepts) )
		{
			Error::set(lang('Error', 'stringParameter', 'accepts'));
			return $this;	
		}
		
		$this->sets['accepts'] = "\taccepts:$accepts,".eol();
		
		return $this;
	}
	
	// CONTENTS Property -------------------------------------------------------
	// contents data
	// contents:plain object
	public function contents($contents = '')
	{
		if( ! is_string($contents) )
		{
			Error::set(lang('Error', 'stringParameter', 'contents'));
			return $this;	
		}
		
		$this->sets['contents'] = "\tcontents:$contents,".eol();
		
		return $this;
	}
	
	// ASYNC Property -------------------------------------------------------
	// async data
	// async:bool: true or false
	public function async($async = true)
	{
		if( ! isValue($async) )
		{
			Error::set(lang('Error', 'valueParameter', 'async'));
			return $this;	
		}
		
		$async = $this->_boolToStr($async);
		$this->sets['async'] = "\tasync:$async,".eol();
		
		return $this;
	}
	
	// CROSS DOMAIN Property -------------------------------------------------------
	// crossDomain data
	// crossDomain:bool: true or false
	public function crossDomain($crossDomain = true)
	{
		if( ! isValue($crossDomain) )
		{
			Error::set(lang('Error', 'valueParameter', 'crossDomain'));
			return $this;	
		}
		
		$crossDomain = $this->_boolToStr($crossDomain);
		$this->sets['crossDomain'] = "\tcrossDomain:$crossDomain,".eol();
		
		return $this;
	}
	
	// TIMEOUT Property -------------------------------------------------------
	// timeout data
	// timeout:numeric
	public function timeout($timeout = '')
	{
		if( ! isValue($timeout) )
		{
			Error::set(lang('Error', 'valueParameter', 'timeout'));
			return $this;	
		}
		
		$this->sets['timeout'] = "\ttimeout:$timeout,".eol();
		
		return $this;
	}
	
	// GLOBAL Property -------------------------------------------------------
	// global data
	// global:bool : true or false
	// global is keywords so global is name globals
	public function globals($globals = true)
	{
		if( ! isValue($globals) )
		{
			Error::set(lang('Error', 'valueParameter', 'globals'));
			return $this;	
		}
		
		$globals = $this->_boolToStr($globals);
		$this->sets['globals'] = "\tglobal:$globals,".eol();
		
		return $this;
	}
	
	// CONTENT TYPE Property -------------------------------------------------------
	// contentType data
	// contentType:bool or string
	// is bool  : true or false
	// is_string: 'application/x-www-form-urlencoded; charset=UTF-8'
	public function contentType($contentType = 'application/x-www-form-urlencoded; charset=UTF-8')
	{
		if( is_bool($contentType) )
		{
			$contentType = $this->_boolToStr($contentType);		
		}
		elseif( is_string($contentType) )
		{
			$contentType = "\"$contentType\"";
		}
		else
		{
			Error::set(lang('Error', 'valueParameter', 'contentType'));
			return $this;	
		}
		
		$this->sets['contentType'] = "\tcontentType:$contentType,".eol();
		
		return $this;
	}
	
	protected function _object($name, $codes = array())
	{
		if( ! is_array($codes) )
		{
			Error::set(lang('Error', 'arrayParameter', 'codes'));
			return $this;	
		}	
		
		$statusCode = eol()."\t$name:".eol()."\t{";
		
		if( ! empty($codes) )
		{
			foreach( $codes as $code => $value )
			{
				$param = '';
				if(strstr($value, '->'))
				{
					$params = explode('->', $value);	
					$param = $params[0];
					$value = $params[1];
				}
				
				$statusCode .= eol()."\t\t$code:function($param)".eol()."\t\t{".eol()."\t\t\t$value".eol()."\t\t},".eol();
			}
			
			$statusCode = trim(trim($statusCode), ',').eol();
		}
		
		$statusCode .= "\t}";
		
		$this->functions[$name] = eol()."\t".$statusCode;
	}
	
	// STATUS CODE Property -------------------------------------------------------
	// statusCode data
	// statusCode:array
	// array(404 => 'alert(404);', 403 => 'alert(403);') 
	// To use parameters :::::    param1, param2->codes...   ::::: function(param1, param2){codes}
	// -> parameters and codes is seperators
	// array(404 => 'data->alert(data);', 403 => 'data->alert(data);')
	public function statusCode($codes = array())
	{
		$this->_object('statusCode', $codes);
			
		return $this;
	}
	
	// CONVERTERS Property -------------------------------------------------------
	// converters data
	// converters:array
	// To use parameters :::::    param1, param2->codes...   ::::: function(param1, param2){codes}
	// -> parameters and codes is seperators
	// array('C1' => 'alert('c1');', C2 => 'param1, param2->alert('c2');') 
	public function converters($codes = array())
	{
		$this->_object('converters', $codes);
			
		return $this;
	}
	
	
	protected function _functions($name, $params, $codes)
	{
		if( ! is_string($params) || ! is_string($codes) )
		{
			Error::set(lang('Error', 'stringParameter', 'params & codes'));
			return $this;
		}
		
		$this->functions[$name] = eol()."\t$name:function($params)".eol()."\t{".eol()."\t\t$codes".eol()."\t}";
	}
	
	// SUCCESS FUNCTION Property -------------------------------------------------------
	// success data
	// success: 2 Parameters
	// string @params : 'param1, param2'
	// string @success: 'alert("example")'
	public function success($params = 'e', $success = '')
	{
		$this->_functions('success', $params, $success);	
		
		return $this;
	}
	
	// ERROR FUNCTION Property -------------------------------------------------------
	// error data
	// error: 2 Parameters
	// string @params : 'param1, param2'
	// string @error  : 'alert("example")'
	public function error($params = 'e', $error = '')
	{
		$this->_functions('error', $params, $error);	
	
		return $this;
	}
	
	// COMPLETE FUNCTION Property -------------------------------------------------------
	// complete data
	// complete: 2 Parameters
	// string @params    : 'param1, param2'
	// string @complete  : 'alert("example")'
	public function complete($params = 'e', $complete = '')
	{
		$this->_functions('complete', $params, $complete);
		
		return $this;	
	}
	
	// BEFORE SEND FUNCTION Property -------------------------------------------------------
	// beforeSend data
	// beforeSend: 2 Parameters
	// string @params       : 'param1, param2'
	// string @before_send  : 'alert("example")'
	public function beforeSend($params = 'e', $beforeSend = '')
	{
		$this->_functions('beforeSend', $params, $beforeSend);
		
		return $this;
	}	
	
	// DATA FILTER FUNCTION Property -------------------------------------------------------
	// dataFilter data
	// dataFilter: 2 Parameters
	// string @params       : 'param1, param2'
	// string @data_filter  : 'alert("example")'
	public function dataFilter($params = 'e', $dataFilter = '')
	{
		$this->_functions('dataFilter', $params, $dataFilter);
		
		return $this;
	}
	
	protected function _callbacks($name, $params, $codes)
	{
		if( ! ( is_string($params) || is_string($codes) ) )
		{
			return $this;
		}
		
		$this->callbacks[$name] = eol().".$name(function($params)".eol()."{".eol()."\t$codes".eol()."})";
	}	
	
	// DONE CALLBACK FUNCTION Property -------------------------------------------------------
	// done data
	// done: 2 Parameters
	// string @params : 'param1, param2'
	// string @done   : 'alert("example")'
	public function done($params = 'e', $done = '')
	{
		$this->_callbacks('done', $params, $done);
		
		return $this;
	}
	
	// FAIL CALLBACK FUNCTION Property -------------------------------------------------------
	// fail data
	// fail: 2 Parameters
	// string @params : 'param1, param2'
	// string @fail   : 'alert("example")'
	public function fail($params = 'e', $fail = '')
	{
		$this->_callbacks('fail', $params, $fail);
		
		return $this;
	}
	
	// ALWAYS CALLBACK FUNCTION Property -------------------------------------------------------
	// always data
	// always: 2 Parameters
	// string @params : 'param1, param2'
	// string @always : 'alert("example")'
	public function always($params = 'e', $always = '')
	{
		$this->_callbacks('always', $params, $always);
		
		return $this;
	}
	
	// THEN CALLBACK FUNCTION Property -------------------------------------------------------
	// then data
	// then: 2 Parameters
	// string @params : 'param1, param2'
	// string @then   : 'alert("example")'
	public function then($params = 'e', $then = '')
	{
		$this->_callbacks('then', $params, $then);
		
		return $this;
	}
	
	// Complementary method of operation
	// Optional Use Parameters
	// [string @url])  => url() method instead of the alternative  
	// [string @data]) => data() method instead of the alternative 
	public function send($url = '', $data = '')
	{
		if( ! is_string($url) || ! is_string($data) )
		{
			return Error::set(lang('Error', 'stringParameter', 'url & data'));
		}
		
		if( ! empty($url) )
		{
			$this->url($url);	
		}
		
		if( ! empty($data) )
		{
			$this->data($data);	
		}
		
		if( ! isset($this->sets['method']) )
		{
			$this->method('post');
		} 
		
		$ajax = '';
		
		if( ! empty($this->sets) ) foreach( $this->sets as $val )
		{
			$ajax .= $val;
		}
		
		$ajax = substr($ajax, 0, -1);
		
		$ajax .= eol();
		
		if( ! empty($this->functions) ) foreach( $this->functions as $val )
		{
			$ajax .= "\t$val,";
		}
		
		$ajax = substr($ajax, 0, -1);
		
		$callbacks = '';
		
		if( ! empty($this->callbacks) )
		{
			foreach( $this->callbacks as $val )
			{
				$callbacks .= $val;	
			}
			
			$callbacks .= ";".eol();
		}
		else
		{
			$callbacks = ";".eol();
		}
		
		$ajax = eol()."$.ajax".eol()."({".eol()."$ajax".eol()."})$callbacks";
		
		$this->_defaultVariable();
		
		return $ajax;
	}
	
	// Complementary method of operation
	// Optional Use Parameters
	// [string @url])  => url() method instead of the alternative  
	// [string @data]) => data() method instead of the alternative 
	public function create($url = '', $data = '')
	{
		return $this->send($url, $data);	
	}
	
	// DEFAULT VARIABLES
	protected function _defaultVariable()
	{
		if( ! empty($this->functions)) $this->functions = array();
		if( ! empty($this->sets)) $this->sets = array();
		if( ! empty($this->callbacks)) $this->callbacks = array();
	}
}