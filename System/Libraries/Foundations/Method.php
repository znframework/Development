<?php
class __USE_STATIC_ACCESS__Method
{
	/***********************************************************************************/
	/* METHOD LIBRARY						                   	                       */
	/***********************************************************************************/
	/* Yazar: Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	/* Site: www.zntr.net
	/* Lisans: The MIT License
	/* Telif Hakkı: Copyright (c) 2012-2015, zntr.net
	/*
	/* Sınıf Adı: Method
	/* Versiyon: 1.0
	/* Tanımlanma: Statik
	/* Dahil Edilme: Gerektirmez
	/* Erişim: method::, $this->method, zn::$use->method, uselib('method')
	/* Not: Büyük-küçük harf duyarlılığı yoktur.
	/***********************************************************************************/
	
	/******************************************************************************************
	* CALL                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Geçersiz fonksiyon girildiğinde çağrılması için.						  |
	|          																				  |
	******************************************************************************************/
	public function __call($method = '', $param = '')
	{	
		die(getErrorMessage('Error', 'undefinedFunction', "Method::$method()"));	
	}
	
	/******************************************************************************************
	* POST                                                                                    *
	*******************************************************************************************
	| Genel Kullanım:$_POST Global değişkeninin kullanımıdır.                                 |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                              	      |
	| 1. string var @name => Post değişkeninin anahtar ismidir. $_POST['isim']       	  	  |
	| 2. string var @value => Anahtarın tutacağı veri. $_POST['isim'] = 'Değer'               |
	|          																				  |
	| Örnek Kullanım: post('isim', 'Değer');        	  					                  |
	| // $_POST['isim'] = 'Değer'      													      |
	|          																				  |
	******************************************************************************************/	
	public function post($name = '', $value = '')
	{
		// Parametreler kontrol ediliyor. --------------------------------------------
		if( ! is_string($name) ) 
		{
			return Error::set(lang('Error', 'stringParameter', 'name'));
		}
		
		if( empty($name) ) 
		{
			return $_POST;
		}
		// ---------------------------------------------------------------------------
		
		// @value parametresi boş değilse
		if( ! empty($value) )
		{
			$_POST[$name] = $value;
		}
		
		// Global veri içersinde
		// böyle bir veri yoksa
		if( empty($_POST[$name]) ) 
		{
			return Error::set(lang('Error', 'emptyVariable', '@$_POST[\'name\']'));
		}
		
		return $_POST[$name];
	}	
	
	/******************************************************************************************
	* GET                                                                                     *
	*******************************************************************************************
	| Genel Kullanım:$_GET Global değişkeninin kullanımıdır.                                  |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                              	      |
	| 1. string var @name => Get değişkeninin anahtar ismidir. $_GET['isim']       	  	      |
	| 2. string var @value => Anahtarın tutacağı veri. $_GET['isim'] = 'Değer'                |
	|          																				  |
	| Örnek Kullanım: get('isim', 'Değer');        	  					                      |
	| // $_GET['isim'] = 'Değer'      													      |
	|          																				  |
	******************************************************************************************/	
	public function get($name = '', $value = '')
	{
		if( ! is_string($name) ) 
		{
			return Error::set(lang('Error', 'stringParameter', 'name'));
		}
		
		if( empty($name) ) 
		{
			return $_GET;
		}
		
		if( ! empty($value) )
		{
			$_GET[$name] = $value;
		}
		
		if( empty($_GET[$name]) ) 
		{
			return Error::set(lang('Error', 'emptyVariable', '@$_GET[\'name\']'));
		}
		
		return $_GET[$name];	
	}
	
	/******************************************************************************************
	* REQUEST                                                                                 *
	*******************************************************************************************
	| Genel Kullanım:$_REQUEST Global değişkeninin kullanımıdır.                              |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                              	      |
	| 1. string var @name => Request değişkeninin anahtar ismidir. $_REQUEST['isim']       	  |
	| 2. string var @value => Anahtarın tutacağı veri. $_REQUEST['isim'] = 'Değer'            |
	|          																				  |
	| Örnek Kullanım: request('isim', 'Değer');        	  					                  |
	| // $_REQUEST['isim'] = 'Değer'      													  |
	|          																				  |
	******************************************************************************************/	
	public function request($name = '', $value = '')
	{
		if( ! is_string($name) ) 
		{
			return Error::set(lang('Error', 'stringParameter', 'name'));
		}
		
		if( empty($name) ) 
		{
			return $_REQUEST;
		}
		
		if( ! empty($value) )
		{
			$_REQUEST[$name] = $value;
		}
		
		if( empty($_REQUEST[$name]) ) 
		{
			return Error::set(lang('Error', 'emptyVariable', '@$_REQUEST[\'name\']'));
		}
		
		return $_REQUEST[$name];
	}
	
	/******************************************************************************************
	* FILES                                                                                   *
	*******************************************************************************************
	| Genel Kullanım:$_FILES Global değişkeninin kullanımıdır.                                |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                              	      |
	| 1. string var @file_name => Request değişkeninin anahtar ismidir.$_FILES['upload']	  |
	| 2. [ string var @type ] => Veri türü. Varsayılan:name. $_FILES['upload']['name']        |
	|          																				  |
	| Örnek Kullanım: request('upload', 'name');        	  					              |
	| // $_FILES['upload']['name']      											          |
	|          																				  |
	******************************************************************************************/	
	public function files($fileName = '', $type = 'name')
	{
		if( ! is_string($fileName) ) 
		{
			return Error::set(lang('Error', 'stringParameter', 'fileName'));
		}
		
		if( ! is_string($type) ) 
		{
			$type = 'name';
		}
		
		if( empty($fileName) ) 
		{
			return Error::set(lang('Error', 'emptyVariable', '@fileName'));
		}
		
		return $_FILES[$fileName][$type];
	}
}