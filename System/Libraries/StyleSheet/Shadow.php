<?php
class __USE_STATIC_ACCESS__Shadow
{
	/***********************************************************************************/
	/* SHADOW COMPONENT	     	     		                   	                       */
	/***********************************************************************************/
	/* Yazar: Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	/* Site: www.zntr.net
	/* Lisans: The MIT License
	/* Telif Hakkı: Copyright (c) 2012-2015, zntr.net
	/*
	/* Sınıf Adı: Shadow
	/* Versiyon: 1.2
	/* Tanımlanma: Dinamik
	/* Dahil Edilme: Gerektirmez
	/* Erişim: Shadow::, $this->Shadow, zn::$use->Shadow, uselib('Shadow')
	/* Not: Büyük-küçük harf duyarlılığı yoktur.
	/***********************************************************************************/
	
	/* Easing Değişkeni
	 *  
	 * Easing animasyon bilgisini tutması 
	 * için oluşturulumuştur. 
	 */
	protected $easing;
	
	/* Selector Değişkeni
	 *  
	 * Seçici bilgisini tutması için
	 * oluşturulumuştur. 
	 */
	protected $selector = 'this';
	
	/* Attr Değişkeni
	 *  
	 * Eklenmek istenen farklı css kodlarına.
	 * ait bilgileri tutması için oluşturulmuştur.
	 */
	protected $attr;
	
	/* Params Değişkeni
	 *  
	 * Sınıfa ait kullanacak
	 * verileri tutması için oluşturulmuştur.
	 *
	 */
	protected $params = array();

	// Construct yapıcısı tarafından
	// Config/Css3.php dosyasından ayarlar alınıyor.
	public function __construct()
	{
		$this->browsers = Config::get('Css3', 'browsers');	
	}
	
	/******************************************************************************************
	* CALL                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Geçersiz fonksiyon girildiğinde çağrılması için.						  |
	|          																				  |
	******************************************************************************************/
	public function __call($method = '', $param = '')
	{	
		die(getErrorMessage('Error', 'undefinedFunction', "Shadow::$method()"));	
	}
	
	/******************************************************************************************
	* SELECTOR                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Css kodlarının uygulanacağı nesne seçicisi.        		  		      |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @selector => .nesne, #eleman, td ... gibi seçiciler belirtilir.		      |
	|          																				  |
	| Örnek Kullanım: ->selector('#eleman') 						 		 		  		  |
	|          																				  |
	******************************************************************************************/
	public function selector($selector = '')
	{
		if( ! isChar($selector) )
		{
			Error::set(lang('Error', 'valueParameter', 'selector'));
			return $this;	
		}

		$this->selector = $selector;	
	
		return $this;
	}
	
	/******************************************************************************************
	* ATTR                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Farklı bir css kodu ekleneceği zaman kullanılır.        		  		  |
	|															                              |
	| Parametreler: Tek dizi parametresi vardır.                                              |
	| 1. array var @_attributes => Eklenecek css kodları ve değerleri.		     			  |
	|          																				  |
	| Örnek Kullanım: ->attr(array('color' => 'red', 'border' => 'solid 1px #000')) 		  |
	|          																				  |
	******************************************************************************************/
	public function attr($_attributes = array())
	{
		$attribute = '';
		
		if( is_array($_attributes) )
		{
			foreach($_attributes as $key => $values)
			{
				if( is_numeric($key) )
				{
					$key = $values;
				}
				$attribute .= ' '.$key.':'.$values.';';
			}	
		}
		
		$this->attr = $attribute;
		
		return $this;	
	}
	
	/******************************************************************************************
	* X                                                                                       *
	*******************************************************************************************
	| Genel Kullanım: Gölgenin yataydaki boyutu.        		  		  				      |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string/numeric var @val => Miktar.		     			  							  |
	|          																				  |
	| Örnek Kullanım: ->x(10) // 10px 		  												  |
	|          																				  |
	******************************************************************************************/
	public function x($val = '')
	{
		if( ! isValue($val) )
		{
			Error::set(lang('Error', 'valueParameter', 'val'));
			return $this;	
		}
		
		if( is_numeric($val) )
		{
			$val = $val."px";
		}
		
		$this->params['horizontal'] = $val;
		
		return $this;
	}
	
	/******************************************************************************************
	* HORIZONTAL / X                                                                          *
	*******************************************************************************************
	| Genel Kullanım: X() yönteminin alternatifidir. Gölgenin yataydaki boyutu.        		  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string/numeric var @val => Miktar.		     			  							  |
	|          																				  |
	| Örnek Kullanım: ->horizontal(10) // 10px 		  										  |
	|          																				  |
	******************************************************************************************/
	public function horizontal($val = '')
	{
		$this->x($val);
		
		return $this;
	}
	
	/******************************************************************************************
	* Y                                                                                       *
	*******************************************************************************************
	| Genel Kullanım: Gölgenin dikeydeki boyutu.        		  		  				      |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string/numeric var @val => Miktar.		     			  							  |
	|          																				  |
	| Örnek Kullanım: ->y(10) // 10px 		  												  |
	|          																				  |
	******************************************************************************************/
	public function y($val = '')
	{
		if( ! isValue($val) )
		{
			Error::set(lang('Error', 'valueParameter', 'val'));
			return $this;	
		}
		
		if( is_numeric($val) )
		{
			$val = $val."px";
		}
		
		$this->params['vertical'] = $val;
		
		return $this;
	}
	
	/******************************************************************************************
	* VERTICAL / Y                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Y() yönteminin alternatifidir. Gölgenin dikeydeki boyutu.        		  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string/numeric var @val => Miktar.		     			  							  |
	|          																				  |
	| Örnek Kullanım: ->y(10) // 10px 		  												  |
	|          																				  |
	******************************************************************************************/
	public function vertical($val = '')
	{
		$this->y($val);
		
		return $this;
	}
	
	/******************************************************************************************
	* BLUR                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Gölgenin görünülük miktarıdır.        		  						  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string/numeric var @val => Miktar.		     			  							  |
	|          																				  |
	| Örnek Kullanım: ->blur(10) // 10px 		  											  |
	|          																				  |
	******************************************************************************************/
	public function blur($val = '')
	{
		if( ! isValue($val) )
		{
			Error::set(lang('Error', 'valueParameter', 'val'));
			return $this;	
		}
		
		if( is_numeric($val) )
		{
			$val = $val."px";
		}
		
		$this->params['blur'] = $val;
		
		return $this;
	}
	
	/******************************************************************************************
	* DIFFUSION                                                                               *
	*******************************************************************************************
	| Genel Kullanım: Gölgenin yayılma miktarı.        		  						  		  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string/numeric var @val => Miktar.		     			  							  |
	|          																				  |
	| Örnek Kullanım: ->diffusion(10) // 10px 		  										  |
	|          																				  |
	******************************************************************************************/
	public function diffusion($val = '')
	{
		if( ! isValue($val) )
		{
			Error::set(lang('Error', 'valueParameter', 'val'));
			return $this;	
		}
		
		if( is_numeric($val) )
		{
			$val = $val."px";
		}
		
		$this->params['spread'] = $val;
		
		return $this;
	}
	
	/******************************************************************************************
	* SPREAD / DIFFUSION                                                                      *
	*******************************************************************************************
	| Genel Kullanım: diffusion() yönteminin alternatifidir. Gölgenin yayılma miktarı.        |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string/numeric var @val => Miktar.		     			  							  |
	|          																				  |
	| Örnek Kullanım: ->spread(10) // 10px 		  										      |
	|          																				  |
	******************************************************************************************/
	public function spread($val = '')
	{
		$this->diffusion($val);
		
		return $this;
	}
	
	/******************************************************************************************
	* COLOR                                                                     			  *
	*******************************************************************************************
	| Genel Kullanım: Gölgenin rengini belirlemek için kullanılır.					          |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string/numeric var @val => Renk kodu veya adı.  		  							  |
	|          																				  |
	| Örnek Kullanım: ->color('red')			  										      |
	| Örnek Kullanım: ->color('000') // #000		  										  |
	|          																				  |
	******************************************************************************************/
	public function color($val = '')
	{
		if( ! isValue($val))
		{
			Error::set(lang('Error', 'valueParameter', 'val'));
			return $this;	
		}
		
		if( is_numeric($val) )
		{
			$val = "#".$val;
		}
		
		$this->params['color'] = $val;
		
		return $this;
	}
	
	/******************************************************************************************
	* TYPE                                                                     			      *
	*******************************************************************************************
	| Genel Kullanım: Gölgenin rengini belirlemek için kullanılır.					          |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string/numeric var @val => Renk kodu veya adı.  		  							  |
	|          																				  |
	| Örnek Kullanım: ->type('box')	// box veya text		  								  |
	|          																				  |
	******************************************************************************************/
	public function type($val = 'box')
	{
		if( ! is_string($val))
		{
			Error::set(lang('Error', 'stringParameter', 'val'));
			return $this;	
		}
		
		$this->params['type'] = $val;
		
		return $this;
	}
	
	/******************************************************************************************
	* CREATE                                                                     			  *
	*******************************************************************************************
	| Genel Kullanım: Efekti tamamlamak için kullanılan zincirin son halkasıdır.			  |
	|															                              |
	| Örnek Kullanım: ->create('box') // box veya text					  					  |
	|          																				  |
	******************************************************************************************/	
	public function create($type = 'box')
	{
		$str  = $this->selector."{".eol();	
		$str .= $this->attr.eol();
		
		if( isset($this->params['type']) )
		{
			$type = $this->params['type'];
		}
		
		$x 			= ! isset($this->params['horizontal']) ? 0 : $this->params['horizontal'];	
		$y 			= ! isset($this->params['vertical']) ? 0 : $this->params['vertical'];	
		$blur 		= ! isset($this->params['blur']) ? 0 : $this->params['blur'];
		$diffusion 	= ! isset($this->params['spread']) ? 0 : $this->params['spread'];	
		$color 		= ! isset($this->params['color']) ? 0 : $this->params['color'];
		
		if( $type === 'box' )
		{ 
			$shadow = "$type-shadow:$x $y $blur $diffusion $color;".eol();
		}
		else
		{
			$shadow = "$type-shadow:$x $y $blur $color;".eol();	
		}
		
		$browser = '';	
				
		foreach($this->browsers as $val)
		{
			$str .= $val.$shadow.eol();
		}
		$str .= "}".eol();
		
		$this->_defaultVariable();
		
		return $str;
	}
	
	// VARSAYILAN DEĞİŞKEN AYARLARI
	// Efekt tamamlandığında değişkenler
	// varsayılan ayarlarına getirmek için
	// kullanılmaktadır.
	protected function _defaultVariable()
	{
		if( ! empty($this->attr) ) 			$this->attr = NULL;
		if( ! empty($this->params) )		$this->params = array();
		if( $this->selector !== 'this' )  	$this->selector = 'this';
	}
}