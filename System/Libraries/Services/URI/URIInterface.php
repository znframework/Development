<?php
interface URIInterface
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
	* GET                                                                                     *
	*******************************************************************************************
	| Genel Kullanım: Uri üzerinde istenilen segmenti elde etmek için oluşturulmuş yötemdir.  |
	|															                              |
	| Parametreler: 3 parametresi vardır.                                                     |
	| 1. string var @get => İstenilen segmentin bir önceki segment ismi.			          |
	| 2. numeric var @index => Belirtilen segmentten kaç segment sonraki bölümün istendiği.   |
	| 3. mixed var @while => Belirlenen segment aralığı alınsın mı?.	                      |
	|    																					  |
	| Örnek URL: http://www.example.com/test/zntr/yerli/framework      						  |
	| Örnek Kullanım: get('test'); // zntr       		      								  |
	| Örnek Kullanım: get('test', 2); // yerli       		      							  |
	| Örnek Kullanım: get('test', 2, true); // zntr/yerli       		      				  |
	| Örnek Kullanım: get('test', "count"); // test bölümü sonrası segment sayısı:3           |
	| Örnek Kullanım: get('test', "all"); // zntr/yerli/framework    		                  |
	| Örnek Kullanım: get('test', "framework"); // test/zntr/yerli/framework     		      |
	|          																				  |
	******************************************************************************************/
	public function get($get, $index, $while);
	
	/******************************************************************************************
	* SEGMENT ARRAY                                                                          *
	*******************************************************************************************
	| Genel Kullanım: Uri bölümlerini bir dizi tipinde veri olarak almak için kullanılır.     |
	|															                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	|    																					  |
	| Örnek URL: http://www.example.com/test/zntr/yerli/framework      						  |
	| Örnek Kullanım: segmentArray(); // array('test', 'zntr', 'yerli', 'framework')         |
	|          																				  |
	******************************************************************************************/
	public function segmentArray();
	
	/******************************************************************************************
	* TOTAL SEGMENTS                                                                          *
	*******************************************************************************************
	| Genel Kullanım: Uride yer alan toplam segment sayısı.                                   |
	|															                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	|    																					  |
	| Örnek URL: http://www.example.com/test/zntr/yerli/framework      						  |
	| Örnek Kullanım: totalSegments(); // 4                                                  |
	|          																				  |
	******************************************************************************************/
	public function totalSegments();
	
	/******************************************************************************************
	* SEGMENT                                                                                 *
	*******************************************************************************************
	| Genel Kullanım: Uride yer alan toplam segment sayısı.                                   |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. numeric var @seg => İstenilen segmentin segment numarası.			                  |
	|    																					  |
	| Örnek URL: http://www.example.com/test/zntr/yerli/framework      						  |
	| Örnek Kullanım: segment(1); // test                                                     |
	| Örnek Kullanım: segment(2); // zntr                                                     |
	| Örnek Kullanım: segment(3); // yerli                                                    |
	|          																				  |
	******************************************************************************************/
	public function segment($seg);
	
	/******************************************************************************************
	* CURRENT SEGMENT                                                                         *
	*******************************************************************************************
	| Genel Kullanım: Urideki son segmenti verir.                                             |
	|															                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	|    																					  |
	| Örnek URL: http://www.example.com/test/zntr/yerli/framework      						  |
	| Örnek Kullanım: currentSegment(); // framework                                         |
	|          																				  |
	******************************************************************************************/
	public function currentSegment();
}