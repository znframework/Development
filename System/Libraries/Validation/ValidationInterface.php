<?php
interface ValidationInterface
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
	* IDENDITY                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Kimlik numarası kontrolü.		        		          				  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. numeric var @no => Kontrol edilecek kimlik numarası bilgisi.                         |
	|          																				  |
	| Örnek Kullanım: identity(123213); // Çıktı: true veya false      		      			  |
	|          																				  |
	******************************************************************************************/
	public function identity($no);
	
	/******************************************************************************************
	* E-MAIL                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: E-posta kontrolü kontrolü.		        		          		      |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. numeric var @data => Kontrol edilecek e-posta bilgisi.                               |
	|          																				  |
	| Örnek Kullanım: email('bilgi@zntr.net'); // Çıktı: true veya false      		      	  |
	|          																				  |
	******************************************************************************************/
	public function email($data);
	
	/******************************************************************************************
	* URL                                                                                     *
	*******************************************************************************************
	| Genel Kullanım: URL adres kontrolü kontrolü.		        		          		      |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. numeric var @data => Kontrol edilecek url adres bilgisi.                             |
	|          																				  |
	| Örnek Kullanım: url('zntr.net'); // Çıktı: true veya false      		      	          |
	|          																				  |
	******************************************************************************************/
	public function url($data);
	
	/******************************************************************************************
	* SPECIAL CHAR                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Özel karakter kontrolü kontrolü.		        		          		  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. numeric var @data => Kontrol edilecek metin bilgisi.                                 |
	|          																				  |
	| Örnek Kullanım: specialChar('zntr.net'); // Çıktı: true veya false      		      	  |
	|          																				  |
	******************************************************************************************/
	public function specialChar($data);
	
	/******************************************************************************************
	* MAXCHAR                                                                                 *
	*******************************************************************************************
	| Genel Kullanım: Maksimum karakter kontrolü kontrolü.		        		          	  |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. numeric var @data => Kontrol edilecek metin bilgisi.                                 |
	| 2. numeric var @char => Maksimum karakter sayısı.                                       |
	|          																				  |
	| Örnek Kullanım: maxchar('zntr.net', 10); // Çıktı: true veya false      		      	  |
	|          																				  |
	******************************************************************************************/
	public function maxchar($data, $char);
	
	/******************************************************************************************
	* MINCHAR                                                                                 *
	*******************************************************************************************
	| Genel Kullanım: Minimum karakter kontrolü kontrolü.		        		          	  |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. numeric var @data => Kontrol edilecek metin bilgisi.                                 |
	| 2. numeric var @char => Minimum karakter sayısı.                                        |
	|          																				  |
	| Örnek Kullanım: minchar('zntr.net', 5); // Çıktı: true veya false      		      	  |
	|          																				  |
	******************************************************************************************/
	public function minchar($data, $char);
	
	//----------------------------------------------------------------------------------------------------
	// name()
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $name
	//
	//----------------------------------------------------------------------------------------------------
	public function name($name);
	
	//----------------------------------------------------------------------------------------------------
	// method()
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $method
	//
	//----------------------------------------------------------------------------------------------------
	public function method($method);
	
	//----------------------------------------------------------------------------------------------------
	// value()
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $value
	//
	//----------------------------------------------------------------------------------------------------
	public function value($value);
	
	//----------------------------------------------------------------------------------------------------
	// required()
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function required();
	
	//----------------------------------------------------------------------------------------------------
	// numeric()
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function numeric();
	
	//----------------------------------------------------------------------------------------------------
	// match()
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $match
	//
	//----------------------------------------------------------------------------------------------------
	public function match($match);
	
	//----------------------------------------------------------------------------------------------------
	// matchPassword()
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $match
	//
	//----------------------------------------------------------------------------------------------------
	public function matchPassword($match);
	
	//----------------------------------------------------------------------------------------------------
	// oldPassword()
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $oldPassword
	//
	//----------------------------------------------------------------------------------------------------
	public function oldPassword($oldPassword);
	
	//----------------------------------------------------------------------------------------------------
	// compare()
	//----------------------------------------------------------------------------------------------------
	//
	// @param numeric $min
	// @param numeric $max
	//
	//----------------------------------------------------------------------------------------------------
	public function compare($min, $max);
	
	//----------------------------------------------------------------------------------------------------
	// validate()
	//----------------------------------------------------------------------------------------------------
	//
	// @param args
	//
	//----------------------------------------------------------------------------------------------------
	public function validate();
	
	//----------------------------------------------------------------------------------------------------
	// secure()
	//----------------------------------------------------------------------------------------------------
	//
	// @param args
	//
	//----------------------------------------------------------------------------------------------------
	public function secure();
	
	//----------------------------------------------------------------------------------------------------
	// pattern()
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $pattern
	// @param string $char
	//
	//----------------------------------------------------------------------------------------------------
	public function pattern($pattern, $char);
	
	//----------------------------------------------------------------------------------------------------
	// captcha()
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $captcha
	//
	//----------------------------------------------------------------------------------------------------
	public function captcha($captcha);
	
	/******************************************************************************************
	* RULES                                                                                   *
	*******************************************************************************************
	| Genel Kullanım: form araçlarının hangi kurallardan oluşacağını belirlemek için 		  |
	| kullanılan fonksiyondur. Birinci parametre form nesnesinin adı, ikinci parametre ise    |
	| oluşacak kurallar dizisidir		        		          	  						  |			
	|															                              |
	| Parametreler: 4 parametresi vardır.                                                     |
	| 1. string var @name => Kontrol edilecek form verisi.                                    |
	| 2. array var @config => Kontrol parametreleri dizisi.                                   |
	| 3. string var @view_name => Kontrollerde görünmesini istediğiniz form verisinin ismi.   |
	| 4. [ string var @method ] => Formdan hangi methodla verinin gönderildiğidir. Varsayılan:|
	| post ayarlıdır.																	      |
	|          																				  |
	| Örnek Kullanım: rules('kullanici', array('required', 'email'), 'E-posta');              |
	|          																				  |
	| 2. Parametre => Kontrol Parametreleri         										  |
	|          																				  |
	| 1-required => Bu veri boş geçilemez.         											  |
	| 2-idendity => Bu bir kimlik numarası olmalıdır.         								  |
	| 3-url => Bu bir url veri tipi olmalıdır.         										  |
	| 4-email => Bu bir e-posta veri tipi olmalıdır.         								  |
	| 5-minchar => 5 => Bu verinin minimun karakter sayısı 5 olmalıdır.         			  |
	| 6-maxchar => 5 => Bu verinin maksimum karakter sayısı 5 olmalıdır.         			  |
	| .																						  |
	| .																						  |
	| .																						  |
	|  >>>>>>>>>>>>>>>>>>>>>>>>>>>Detaylı bilgi için ZNTR.NET<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<   |    																				  |
	******************************************************************************************/
	public function rules($name, $config, $viewName, $met);
	
	/******************************************************************************************
	* NEW VALUE                                                                               *
	*******************************************************************************************
	| Genel Kullanım: Validasyon kontrollerinden geçirilen yeni veri.	        		      |			
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @name => Kontroleri sağlanan form verisi.                                 |
	|          																				  |
	| Örnek Kullanım: nval('kullanici');              										  |
	|          																				  |
	******************************************************************************************/
	public function nval($name);
	
	/******************************************************************************************
	* ERROR                                                                                   *
	*******************************************************************************************
	| Genel Kullanım: Validasyon işlemlerinde kurala ayrıkı veri girişlerini öğrenmek içindir.|			
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @name => Hata bilgilerini hangi formatta alınacağının belirtilmesidir.    |
	|          																				  |
	| Parametreye 3 farklı veri girişi yapılabilir.          								  |
	|          																				  |
	| 1- array  => Hatalar dizi türünde döndürülür.         								  |
	| 2- string/echo => Hatalar metinsel türde döndürülür.         							  |
	| 3- forum nesnesinin ismi => Hatanın oluştuğu forum nesnesinin adı.         			  |
	|          																				  |
	| Örnek Kullanım: error('array'); // Çıktı: array              							  |
	| Örnek Kullanım: error('string'); // Çıktı: string              						  |
	| Örnek Kullanım: error('echo'); // Çıktı: string              							  |
	| Örnek Kullanım: error('kullanici'); // Çıktı: kullanici nesnesine ait string            |
	|          																				  |
	******************************************************************************************/
	public function error($name);
	
	// sayfanın post edilmesin oluşan hatalardan dolayı tekrar aynı bilgilerin girilmesini engellemek yerine
	// bu fonksiyon aracılığı ile sayfa yenilendiğin ya da formun gönderilmesi srıasında
	
	// hata oluştuğunda ekrana girilen bilgileri yansıtır.
	public function postBack($name, $met);
}