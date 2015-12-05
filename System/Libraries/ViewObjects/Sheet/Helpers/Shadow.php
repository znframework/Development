<?php
class CSSShadow
{
	//----------------------------------------------------------------------------------------------------
	//
	// Yazar      : Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	// Site       : www.zntr.net
	// Lisans     : The MIT License
	// Telif Hakkı: Copyright (c) 2012-2016, zntr.net
	//
	//----------------------------------------------------------------------------------------------------
	
	use SheetTrait;
	
	use CallUndefinedMethodTrait;
	
	/* Params Değişkeni
	 *  
	 * Sınıfa ait kullanacak
	 * verileri tutması için oluşturulmuştur.
	 *
	 */
	protected $params = array();
	
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
		if( ! is_scalar($val) )
		{
			Error::set('Error', 'valueParameter', 'val');
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
		if( ! is_scalar($val) )
		{
			Error::set('Error', 'valueParameter', 'val');
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
		if( ! is_scalar($val) )
		{
			Error::set('Error', 'valueParameter', 'val');
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
		if( ! is_scalar($val) )
		{
			Error::set('Error', 'valueParameter', 'val');
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
		if( ! is_scalar($val))
		{
			Error::set('Error', 'valueParameter', 'val');
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
			Error::set('Error', 'stringParameter', 'val');
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