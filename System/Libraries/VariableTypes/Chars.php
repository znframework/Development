<?php	
class __USE_STATIC_ACCESS__Chars
{
	/***********************************************************************************/
	/* CHARS LIBRARY					                   	                           */
	/***********************************************************************************/
	/* Yazar: Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	/* Site: www.zntr.net
	/* Lisans: The MIT License
	/* Telif Hakkı: Copyright (c) 2012-2015, zntr.net
	/*
	/* Sınıf Adı: Chars
	/* Versiyon: 2.0 Eylül Güncellemesi
	/* Tanımlanma: Karışık
	/* Dahil Edilme: Gerektirmez
	/* Erişim: Chars::, $this->Chars, zn::$use->Chars, uselib('Chars')
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
		die(getErrorMessage('Error', 'undefinedFunction', "Chars::$method()"));	
	}
	
	/******************************************************************************************
	* IS ALNUM                                                                                *
	*******************************************************************************************
	| Genel Kullanım: A,B..Z, 0-9 alfa sayısal karakterler için sınama yapılır.	 		      |
	
	  @param  string $string
	  @return bool
	|          																				  |
	******************************************************************************************/
	public function isAlnum($string = '')
	{
		if( ! is_string($string) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(string)'));	
		}
		
		return ctype_alnum($string);		
	}
	
	/******************************************************************************************
	* IS ALPHA                                                                                *
	*******************************************************************************************
	| Genel Kullanım: A,B..Z metinsel karakterler için sınama yapılır.	 				      |
	
	  @param  string $string
	  @return bool
	|          																				  |
	******************************************************************************************/
	public function isAlpha($string = '')
	{
		if( ! is_string($string) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(string)'));	
		}
		
		return ctype_alpha($string);		
	}
	
	/******************************************************************************************
	* IS NUMERIC                                                                              *
	*******************************************************************************************
	| Genel Kullanım: 0-Z sayısal karakterler için sınama yapılır.		 				      |
	
	  @param  string $string
	  @return bool
	|          																				  |
	******************************************************************************************/
	public function isNumeric($string = '')
	{
		if( ! is_scalar($string) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(string)'));	
		}
		
		return ctype_digit($string);		
	}
	
	/******************************************************************************************
	* IS GRAPH	                                                                              *
	*******************************************************************************************
	| Genel Kullanım: Sınama, boşluk karakterleri hariç basılabilir karakterler için yapılır. |
	
	  @param  string $string
	  @return bool
	|          																				  |
	******************************************************************************************/
	public function isGraph($string = '')
	{
		if( ! is_string($string) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(string)'));	
		}
		
		return ctype_graph($string);		
	}
	
	/******************************************************************************************
	* IS LOWER	                                                                              *
	*******************************************************************************************
	| Genel Kullanım: Sınama, küçük harfler için yapılır.				 					  |	
	
	  @param  string $string
	  @return bool
	|          																				  |
	******************************************************************************************/
	public function isLower($string = '')
	{
		if( ! is_string($string) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(string)'));	
		}
		
		return ctype_lower($string);		
	}
	
	/******************************************************************************************
	* IS UPPER	                                                                              *
	*******************************************************************************************
	| Genel Kullanım: Sınama, büyük harfler için yapılır.				 					  |	
	
	  @param  string $string
	  @return bool
	|          																				  |
	******************************************************************************************/
	public function isUpper($string = '')
	{
		if( ! is_string($string) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(string)'));	
		}
		
		return ctype_upper($string);		
	}
	
	/******************************************************************************************
	* IS PRINT	                                                                              *
	*******************************************************************************************
	| Genel Kullanım: Sınama, basılabilir karakterler için yapılı.		 					  |	
	
	  @param  string $string
	  @return bool
	|          																				  |
	******************************************************************************************/
	public function isPrint($string = '')
	{
		if( ! is_string($string) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(string)'));	
		}
		
		return ctype_print($string);		
	}
	
	/******************************************************************************************
	* IS NON ALNUM                                                                            *
	*******************************************************************************************
	| Genel Kullanım: birer alfasayısal veya boşluk karakteri olmayan basılabilir karakterler |
	  için yapılır.		 					 
	
	  @param  string $string
	  @return bool
	|          																				  |
	******************************************************************************************/
	public function isNonAlnum($string = '')
	{
		if( ! is_string($string) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(string)'));	
		}
		
		return ctype_punct($string);		
	}
	
	/******************************************************************************************
	* IS SPACE                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Sınama, boşluk karakterleri için yapılır.								  |	 					 
	
	  @param  string $string
	  @return bool
	|          																				  |
	******************************************************************************************/
	public function isSpace($string = '')
	{
		if( ! is_string($string) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(string)'));	
		}
		
		return ctype_space($string);		
	}
	
	/******************************************************************************************
	* IS HEX                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Sınama, onaltılık rakamlar için yapılır.								  |	 					 
	
	  @param  string $string
	  @return bool
	|          																				  |
	******************************************************************************************/
	public function isHex($string = '')
	{
		if( ! is_string($string) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(string)'));	
		}
		
		return ctype_xdigit($string);		
	}
	
	/******************************************************************************************
	* IS CONTROL                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Sınama, denetim karakterleri için yapılır.		 				      |
	
	  @param  string $string
	  @return bool
	|          																				  |
	******************************************************************************************/
	public function isControl($string = '')
	{
		if( ! is_string($string) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(string)'));	
		}
		
		return ctype_cntrl($string);		
	}	
}