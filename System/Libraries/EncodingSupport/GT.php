<?php 
class __USE_STATIC_ACCESS__GT
{
	/***********************************************************************************/
	/* GETTEXT LIBRARY     						                   	                   */
	/***********************************************************************************/
	/* Yazar: Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	/* Site: www.zntr.net
	/* Lisans: The MIT License
	/* Telif Hakkı: Copyright (c) 2012-2015, zntr.net
	/*
	/* Sınıf Adı: GT
	/* Versiyon: 2.0 Eylül Güncellemesi
	/* Tanımlanma: Statik - Dinamik
	/* Dahil Edilme: Gerektirmez
	/* Erişim: GT::, $this->GT, zn::$use->GT, uselib('GT')
	/* Not: Büyük-küçük harf duyarlılığı yoktur.
	/***********************************************************************************/
	
	public function __construct()
	{
		if( ! function_exists('gettext') )
		{
			die(getErrorMessage('Error', 'undefinedFunctionExtension', 'Gettext'));	
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
		die(getErrorMessage('Error', 'undefinedFunction', "GT::$method()"));	
	}
	
	/******************************************************************************************
	* DATA                   	                                                              *
	*******************************************************************************************
	| Genel Kullanım: Geçerli uygulama alanında bir iletiyi arar. 	    					  | 
		
	  @param  string $message
	  @return string  
	|														                                  |
	******************************************************************************************/
	public function data($message = '')
	{
		if( ! is_string($message) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(message)'));	
		}
	
		return gettext($message);
	}
	
	/******************************************************************************************
	* LOCALE                 	                                                              *
	*******************************************************************************************
	| Genel Kullanım: Yereli ayarlar. 	 													  | 
		
	  @param  int 	$category
	  @param  mixed $locale  
	  
	  @return bool
	|														                                  |
	******************************************************************************************/
	public function locale($category = '', $locale = '')
	{
		return setlocale(Convert::toConstant($category, 'LC_'), $locale);
	}
	
	/******************************************************************************************
	* DATAS                  	                                                              *
	*******************************************************************************************
	| Genel Kullanım: Gettext işlevinin çoğul biçemli sürümü. 		    					  | 
		
	  @param  string  $msgId1
	  @param  string  $msgId2
	  @param  numeric $count
	  @return string  
	|														                                  |
	******************************************************************************************/
	public function datas($msgId1 = '', $msgId2 = '', $count = 0)
	{
		if( ! is_string($msgId1) || ! is_string($msgId2) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(msgId1) & 2.(msgId2)'));	
		}
	
		return ngettext($msgId1, $msgId2, $count);
	}
	
	/******************************************************************************************
	* CHANGE                	                                                              *
	*******************************************************************************************
	| Genel Kullanım: Geçerli uygulama adını değiştirir. 	   			 					  | 
		
	  @param  string $domain
	  @param  string $message
	  @return string  
	|														                                  |
	******************************************************************************************/
	public function change($domain = '', $message = '')
	{
		if( ! is_string($domain) || ! is_string($message) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(domain) & 2.(message)'));	
		}
	
		return dgettext($domain, $message);
	}
	
	/******************************************************************************************
	* CHANGES                	                                                              *
	*******************************************************************************************
	| Genel Kullanım: Nettext işlevinin çoğul biçemli sürümü. 		    					  | 
	
	  @param  string  $domain
	  @param  string  $msgId1
	  @param  string  $msgId2
	  @param  numeric $count
	  @return string  
	|														                                  |
	******************************************************************************************/
	public function changes($domain = '', $msgId1 = '', $msgId2 = '', $count = 0)
	{
		if( ! is_string($domain) || ! is_string($msgId1) || ! is_string($msgId2) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(domain) & 2.(msgId1) & 3.(msgId2)'));	
		}
	
		return dngettext($domain, $msgId1, $msgId2, $count);
	}
	
	/******************************************************************************************
	* EARCH                                                                           *
	*******************************************************************************************
	| Genel Kullanım: Geçerli uygulama alanında bir iletiyi arar. 	    					  | 
		
	  @param  string  $domain
	  @param  string  $message
	  @param  numeric $category
	  @return string  
	|														                                  |
	******************************************************************************************/
	public function search($domain = '', $message = '', $category = 0)
	{
		if( ! is_string($domain) || ! is_string($message) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(domain) & 2.(message)'));	
		}
	
		return dcgettext($domain, $message, $category);
	}
	
	/******************************************************************************************
	* SEARCHES                                                                         *
	*******************************************************************************************
	| Genel Kullanım: Geçerli uygulama alanında bir iletiyi arar. 	    					  | 
		
	  @param  string  $domain
	  @param  string  $msgId1
	  @param  string  $msgId2
	  @param  numeric $count
	  @param  numeric $category
	  @return string  
	|														                                  |
	******************************************************************************************/
	public function searches($domain = '', $msgId1 = '', $msgId2 = '', $count = 0, $category = 0)
	{
		if( ! is_string($domain) || ! is_string($msgId1) || ! is_string($msgId2) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(domain) & 2.(msgId1) & 3.(msgId2)'));	
		}
	
		return dcngettext($domain, $msgId1, $msgId2, $count, $category);
	}
	
	/******************************************************************************************
	* CODESET            	                                                              *
	*******************************************************************************************
	| Genel Kullanım: Belli bir uygulamanın iletileri için karakter kodlaması tanımlar. 	  | 
		
	  @param  string $domain
	  @param  string $codeset
	  @return string  
	|														                                  |
	******************************************************************************************/
	public function codeset($domain = '', $codeset = '')
	{
		if( ! is_string($domain) || ! is_string($codeset) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(domain) & 2.(codeset)'));	
		}
	
		return bind_textdomain_codeset($domain, $codeset);
	}
	
	/******************************************************************************************
	* BIND DOMAIN              	                                                              *
	*******************************************************************************************
	| Genel Kullanım: Belli bir uygulamanın iletileri için karakter kodlaması tanımlar. 	  | 
		
	  @param  string $domain
	  @param  string $directory
	  @return string  
	|														                                  |
	******************************************************************************************/
	public function dir($domain = '', $directory = '')
	{
		if( ! is_string($domain) || ! is_string($directory) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(domain) & 2.(directory)'));	
		}
	
		return bindtextdomain($domain, $directory);
	}
	
	/******************************************************************************************
	* DOMAIN                 	                                                              *
	*******************************************************************************************
	| Genel Kullanım: Öntanımlı uygulama adını tanımlar. 	 								  | 
		
	  @param  string $textDomain
	  @return string  
	|														                                  |
	******************************************************************************************/
	public function name($textDomain = '')
	{
		if( ! is_string($textDomain))
		{
			return Error::set(lang('Error', 'stringParameter', '1.(textDomain)'));	
		}
	
		return textdomain($textDomain);
	}
}