<?php 
class __USE_STATIC_ACCESS__Cart
{
	/***********************************************************************************/
	/* CART LIBRARY	     					                   	                       */
	/***********************************************************************************/
	/* Yazar: Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	/* Site: www.zntr.net
	/* Lisans: The MIT License
	/* Telif Hakkı: Copyright (c) 2012-2015, zntr.net
	/*
	/* Sınıf Adı: Cart
	/* Versiyon: 1.0
	/* Tanımlanma: Statik
	/* Dahil Edilme: Gerektirmez
	/* Erişim: cart::, $this->cart, zn::$use->cart, uselib('cart')
	/* Not: Büyük-küçük harf duyarlılığı yoktur.
	/***********************************************************************************/
	
	/* Items Dizi Değişkeni
	 *  
	 * Sepetteki güncel veri bilgisini tutuması
	 * için oluşturulmuştur.
	 *
	 */
	private $items = array();
	
	/* Error Değişkeni
	 *  
	 * Sepet işlemlerinde oluşan hata bilgilerini
	 * tutması için oluşturulmuştur.
	 *
	 */
	private $error;
	
	public function __construct()
	{
		if( ! isset($_SESSION) ) session_start();
	}
	
	/******************************************************************************************
	* CALL                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Geçersiz fonksiyon girildiğinde çağrılması için.						  |
	|          																				  |
	******************************************************************************************/
	public function __call($method = '', $param = '')
	{	
		die(getErrorMessage('Error', 'undefinedFunction', "Cart::$method()"));	
	}
	
	/******************************************************************************************
	* INSERT ITEM                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Sepete ürün eklemek için kullanılır. Eklenecek ürünler dizi olarak	  |
	| belirtilir.														                      |
	|															                              |
	| Parametreler: Tek dizi parametresi vardır.                                              |
	| 1. array var @product => Eklenecek ürünlerin bilgisini tutar .					      |
	|          																				  |
	| Örnek Kullanım: array('id' => 1, 'price' => 5, quantity => 1, 'name' => 'Urun')         |
	|          																				  |
	| Ürün eklenirken belirtilmek zorunda olunan parametreler şunlardır.          			  |
	|          																				  |
	| 1-Fiyat Parametresi: price => fiyat bildirilirken price anahtar kelimesi kullanılır.    |
	| 2-Adet Parametresi: quantity => adet bildirilirken quantity anahtar kelime kullanılır.  |
	| bu anahtar kelime kullanılmazsa ürün adeti 1 kabul edilir. Bunların dışındaki        	  |
	| isimlendirmeler keyfidir. Yani isteğe bağlıdır.        								  |
	|          																				  |
	******************************************************************************************/
	public function insertItem($product = array())
	{
		// Ürünün parametresinin boş olması durumunda rapor edilmesi istenmiştir.
		if( empty($product) )
		{
			$this->error = lang('Error', 'emptyParameter', 'product');
			return Error::set($this->error);	
		}
		
		// Ürünün parametresinin dizi olmaması durumunda rapor edilmesi istenmiştir.
		if( ! is_array($product))
		{
			$this->error = lang('Error', 'arrayParameter', 'product');
			return Error::set($this->error);	
		}
		
		// Ürünün adet parametresinin belirtilmemesi durumunda 1 olarak kabul edilmesi istenmiştir.
		if( ! isset($product['quantity']) )
		{
			$product['quantity'] = 1;
		}
		
		// Sepettin daha önce oluşturulup oluşturulmadığına göre işlemler gerçekleştiriliyor.
		if( isset($_SESSION[md5('cart')]) )
		{
			$this->items = $_SESSION[md5('cart')];
			array_push($this->items, $product);
			$_SESSION[md5('cart')] = $this->items;
		}
		else
		{
			array_push($this->items, $product);
			$_SESSION[md5('cart')] = $this->items;
		}
		
		$this->items = $_SESSION[md5('cart')];
		
		return $this->items;
	}
	
	/******************************************************************************************
	* SELECT ITEMS                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Sepetteki tüm ürün bilgilerini dizi olarak döndürmek için kullanılır.	  |
	|															                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	|          																				  |
	******************************************************************************************/
	public function selectItems()
	{
		if( isset($_SESSION[md5('cart')]) )
		{
			$this->items = $_SESSION[md5('cart')];
			return $this->items;	
		}
		else
		{
			$this->error = getMessage('Cart', 'noDataError');
			return Error::set($this->error);
		}
	}
	
	/******************************************************************************************
	* SELECT ITEM                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Sepet içerisindeki belirtilen ürün hakkında verilere ulaşmak için       |
	| kullanılır. Yani ürün seçmek için kullanılır.											  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. mixed var @code => Seçilen ürüne ait ayırt edici bilgi parametre olarak girilir.	  |
	|        		  																		  |
	| Code parametresi 2 tür değişken türü içerir bunlar;                                     |
	|          																				  |
	| 1-String/Numeric  => bu tipte parametre için ürünün ayırt edici bilgisi kullanılır.     |	
	| Örnek: id, ürün kodu, seri numara gibi.                                                 |
	|																						  |   													
	| 2-Array => bu tipte parametre kullanımında ise hangi parametreye göre ürünün seçileceği |
	| belirtilir.    																		  |
	| Örnek: array('id' => 'id değeri').                                                      |
	|          																				  |
	******************************************************************************************/
	public function selectItem($code = '')
	{
		if( empty($code) ) 
		{
			return Error::set(lang('Error', 'emptyParameter', 'code'));
		}
		
		$this->items = ( isset($_SESSION[md5('cart')]) ) 
		               ? $_SESSION[md5('cart')] 
					   : '';
		
		if( empty($this->items) ) 
		{
			return false;
		}
		
		foreach( $this->items as $row )
		{
			if( ! is_array($code) )
			{
				$key = array_search($code, $row);
			}
			else
			{
				if( isset($row[key($code)]) && $row[key($code)] == current($code) )
				{
					$key = $row;
				}
			}
			
			if( ! empty($key) )
			{
				return (object)$row;
			}
		}
	}
	
	/******************************************************************************************
	* TOTAL ITEMS                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Sepetteki toplam ürün adet bilgisine erişmek için kullanılır.			  |
	|															                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	| NOT:Bu hesaplama ürün verileri içerisinde quantity parametresine göre yapılmaktadır.    |
	| Bu nedenle quantity dışında ürün adeti için farklı bir parametre kullanmayınız.         |
	|        																				  |
	******************************************************************************************/
	public function totalItems()
	{
		if( isset($_SESSION[md5('cart')]) )
		{
			$this->items = $_SESSION[md5('cart')];
			$total_items = 0;
			
			if( ! empty($this->items) ) foreach( $this->items as $item )
			{
				$total_items += $item['quantity'];	
			}
			
			return $total_items;
		}
		else
		{
			$this->error = getMessage('Cart', 'noDataError');
			Error::set($this->error);
			return 0;	
		}
	}
	
	
	/******************************************************************************************
	* TOTAL PRICES                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Sepetteki ürünlerin toplam fiyat değerine erişmek için kullanılır.	  |
	|															                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	| NOT:Bu hesaplama ürün verileri içerisinde quantity ve price parametrelerine göre        |
	| yapılmaktadır. Bu nedenle quantity dışında ürün adeti ve fiyat için farklı bir          |
	| parametre kullanmayınız.      														  |
	|     														  |
	******************************************************************************************/
	public function totalPrices()
	{
		$this->items = ( isset($_SESSION[md5('cart')]) ) 
				       ? $_SESSION[md5('cart')] 
					   : '';
		
		if( empty($this->items) )
		{
			$this->error = getMessage('Cart', 'noDataError');
			Error::set($this->error);
			return 0;	
		}
		
		$total = '';
		
		foreach( $this->items as $values )
		{
			$quantity  = isset($values['quantity']) 
					   ? $values['quantity'] 
					   : 1;
					   
			$total    += $values['price'] * $quantity;
		}
		
		return $total;
	}
	
	/******************************************************************************************
	* UPDATE ITEM                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Sepet içerisindeki belirtilen ürün bilgilerinin güncellenmesi için	  |
	| kullanılır.															                  |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. mixed var @code => Güncellenen ürüne ait ayırt edici bilgi parametre olarak girilir. |
	| 2. array var @data => Güncellenecek verileri dizi içerisinde anahtar değer çifti olarak |
	| girilmelidir.																			  |
	|																						  |
	| Code parametresi 2 tür değişken türü içerir bunlar;                                     |
	|          																				  |
	| 1-String/Numeric  => bu tipte parametre için ürünün ayırt edici bilgisi kullanılır.     |	
	| Örnek: id, ürün kodu, seri numara gibi.                                                 |
	|																						  |   													
	| 2-Array => bu tipte parametre kullanımında ise hangi parametreye göre ürünün seçileceği |
	| belirtilir.    																		  |
	| Örnek: array('id' => 'id değeri').                                                      |
	|          																				  |
	| Örnek Kullanım: updateItem(array('id' => 10), array('price' => 5, 'name' => 'Urun1'))  |
	| Yukarıda yapılan id'si 10 olan ürünün fiyatını 5 ve isminide Urun1                      |
	| olarak güncelle işlemidir.         												      |
	|          																				  |
	******************************************************************************************/
	public function updateItem($code = '', $data = array())
	{	
		if( empty($code) )
		{
			$this->error = getMessage('Cart', 'updateCodeError');
			return Error::set($this->error);
		}
		
		if( empty($data) )
		{
			$this->error = getMessage('Cart', 'updateParameterEmptyError');
			return Error::set($this->error);
		}
		
		if( ! is_array($data) )
		{
			$this->error = getMessage('Cart', 'updateArrayParameterError');
			return Error::set($this->error);
		}	
		
		$this->items = ( isset($_SESSION[md5('cart')]) ) 
		               ? $_SESSION[md5('cart')] 
					   : '';
		
		if( empty($this->items) ) 
		{
			return false;
		}
		
		$i=0;
		
		foreach( $this->items as $row )
		{
			if( is_array($code) ) 
			{
				if(isset($row[key($code)]) && $row[key($code)] == current($code))
				{
					$code = $row[key($code)];
				}
			}
			
			$key = array_search($code,$row);
			
			if( ! empty($key) )
			{
				array_splice($this->items, $i, 1);
				
				if( count($data) !== count($row) )
				{
					foreach( $data as $k => $v )
					{
						$row[$k] = $v;	
					}
					
					array_push($this->items, $row);
				}
				else
				{
					array_push($this->items, $data);
				}
			}
		
			$i++;
		}
		
		$_SESSION[md5('cart')] = $this->items;
	}
	
	/******************************************************************************************
	* DELETE ITEM                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Sepet içerisindeki belirtilen ürünü silmek için kullanılır.             |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. mixed var @code => Seçilen ürüne ait ayırt edici bilgi parametre olarak girilir.	  |
	|        		  																		  |
	| Code parametresi 2 tür değişken türü içerir bunlar;                                     |
	|          																				  |
	| 1-String/Numeric  => bu tipte parametre için ürünün ayırt edici bilgisi kullanılır.     |	
	| Örnek: id, ürün kodu, seri numara gibi.                                                 |
	|																						  |   													
	| 2-Array => bu tipte parametre kullanımında ise hangi parametreye göre ürünün seçileceği |
	| belirtilir.    																		  |
	| Örnek: array('id' => 'id değeri').                                                      |
	|          																				  |
	******************************************************************************************/
	public function deleteItem($code = '')
	{		
		if( empty($code) )
		{
			$this->error = getMessage('Cart', 'deleteCodeError');
			return Error::set($this->error);	
		}

		$this->items = ( isset($_SESSION[md5('cart')]) ) 
		               ? $_SESSION[md5('cart')] 
					   : '';
		
		if( empty($this->items) ) 
		{
			return false;
		}
		
		$i=0;
		
		foreach( $this->items as $row )
		{	
			if( is_array($code) ) 
			{
				if( isset($row[key($code)]) && $row[key($code)] == current($code) )
				{
					$code = $row[key($code)];
				}
			}
			
			$key = array_search($code, $row);
			
			if( ! empty($key) )
			{
				array_splice($this->items, $i--, 1);
			}
		
			$i++;
		}
		
		$_SESSION[md5('cart')] = $this->items;		
	}
	
	/******************************************************************************************
	* DELETE ITEMS                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Sepetteki tüm ürünleri silmek için kullanılır.	                      |
	|															                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	|     														                              |
	******************************************************************************************/
	public function deleteItems()
	{
		if( isset($_SESSION[md5('cart')]) )
		{
			unset($_SESSION[md5('cart')]);
		}
	}
	
	/******************************************************************************************
	* MONEY FORMAT                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Parametre olarak belirtilen sayısal veriyi para birimine çevirmek için. |
	| kullanılır.		                                                                      |
	|     														                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	|     														                              |
	| 1. numeric var @money => Para biçimine çevrilmek istenen sayılsal veri.				  |
	| 2. string var @type => Sayısal verinin sonunda görüntülenmesi istenilen para birimidir. |
	|     														                              |
	| Örnek Kullanım: moneyFormat(1200, '₺');  // Çıktı: 1.200,00 ₺     					  |
	| Örnek Kullanım: moneyFormat(1000, '€');  // Çıktı: 1.000,00 €     					  |
	|     														                              |
	******************************************************************************************/
	public function moneyFormat($money = 0, $type = '')
	{
		if( ! is_numeric($money) ) 
		{
			return Error::set(lang('Error', 'numericParameter', 'money'));
		}
		
		if( ! is_string($type) ) 
		{
			$type = '';
		}
		
		$moneyFormat = '';
		$money  	 = round($money, 2);
		$str_ex 	 = explode(".",$money);
		$join   	 = array();
		$str    	 = strrev($str_ex[0]);
		
		for( $i = 0; $i < strlen($str); $i++ )
		{
			if( $i%3 === 0 )
			{
				array_unshift($join, '.');
			}
			
			array_unshift($join, $str[$i]);
		}
		
		for( $i = 0; $i < count($join); $i++ )
		{
			$moneyFormat .= $join[$i];	
		}
		
		$type = ! empty($type) 
		        ? ' '.$type 
				: '';
		
		$remaining = ( isset($str_ex[1]) ) 
					 ? $str_ex[1] 
					 : '00';
		
		if( strlen($remaining) === 1 ) 
		{
			$remaining .= '0';
		}
		
		$moneyFormat = substr($moneyFormat,0,-1).','.$remaining.$type;
		
		return $moneyFormat;
	}
	
	/******************************************************************************************
	* ERROR                                                                                   *
	*******************************************************************************************
	| Genel Kullanım: Sepet işlemlerinde oluşan hata bilgilerini tutması için oluşturulmuştur.|
	|     														                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	|     														                              |
	******************************************************************************************/
	public function error()
	{
		if( isset($this->error) )
		{
			Error::set($this->error);
			return $this->error;
		}
		else
		{
			return false;
		}
	}
}