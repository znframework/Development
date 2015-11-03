<?php
class __USE_STATIC_ACCESS__Clean
{
	/***********************************************************************************/
	/* CLEAN LIBRARY						                   	                       */
	/***********************************************************************************/
	/* Yazar: Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	/* Site: www.zntr.net
	/* Lisans: The MIT License
	/* Telif Hakkı: Copyright (c) 2012-2015, zntr.net
	/*
	/* Sınıf Adı: Clean
	/* Versiyon: 1.4
	/* Tanımlanma: Statik
	/* Dahil Edilme: Gerektirmez
	/* Erişim: captcha::, $this->clean, zn::$use->clean, uselib('clean')
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
		die(getErrorMessage('Error', 'undefinedFunction', "Clean::$method()"));	
	}
	
	/******************************************************************************************
	* DATA                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Dizi ya da metinsel ifadelerden veri silmek için kullanılır. 			  |
	|																						  |
	| Parametreler: 2 parametresi vardır.                                              	      |
	| 1. string/array var @searchData => Aranacak metin veya dizi elamanları.				  |
	| 2. string/array var @cleanWord => Silinecek metin veya dizi elamanları.				  |
	|																						  |
	******************************************************************************************/	
	public function data($searchData = '', $cleanWord = '')
	{
		if( ! is_array($searchData) )
		{	
			if( ! isValue($cleanWord) ) 
			{
				$cleanWord = '';
			}
			
			$result = str_replace($cleanWord, '', $searchData);
		}
		else
		{
			if( ! is_array($cleanWord) ) 
			{
				$cleanWordArray[] = $cleanWord;
			}
			else
			{
				$cleanWordArray = $cleanWord;
			}
			
			$result = array_diff($searchData, $cleanWordArray);	
		}
		
		return $result;
	}
}