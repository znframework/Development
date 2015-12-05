<?php
interface TemplateInterface
{
	//----------------------------------------------------------------------------------------------------
	//
	// Yazar      : Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	// Site       : www.zntr.net
	// Lisans     : The MIT License
	// Telif Hakkı: Copyright (c) 2012-2016, zntr.net
	//
	//----------------------------------------------------------------------------------------------------
	
	/******************************************************************************************
	* DATA                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Metinsel ifadelerde ayrıştırma işlemi yapmak için kullanılır.			  |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @string => Metinsel veri.					 							  |
	| 2. array var @data => Değiştirilecek veriler.					  					      |
	|          																				  |
	| Örnek Kullanım: ->data('test', array('test' => 'deneme'))         					  |
	|          																				  |
	******************************************************************************************/
	public function data($string, $data);
	
	/******************************************************************************************
	* DELIMITER                                                                               *
	*******************************************************************************************
	| Genel Kullanım: Ayrıştırma karakterlerini değiştirmek için kullanılır.			      |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @ldel => Başlangıç ayrıştırıcı karakteri. Varsayılan:{					  |
	| 2. string var @4del => Bitiş ayrıştırıcı karakteri. Varsayılan:}	     				  |
	|          																				  |
	| Örnek Kullanım: ->delimiter('[', ']') 		  	 		         					  |
	|          																				  |
	******************************************************************************************/
	public function delimiter($ldel, $rdel);
}