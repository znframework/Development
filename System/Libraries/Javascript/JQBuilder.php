<?php
class __USE_STATIC_ACCESS__JQBuilder extends JSCommon
{
	/***********************************************************************************/
	/* JQUERY BUILDER LIBRARY 	     		                   	                       */
	/***********************************************************************************/
	/* Yazar: Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	/* Site: www.zntr.net
	/* Lisans: The MIT License
	/* Telif Hakkı: Copyright (c) 2012-2015, zntr.net
	/*
	/* Sınıf Adı: JQBuilder
	/* Versiyon: 1.2
	/* Tanımlanma: Dinamik
	/* Dahil Edilme: Gerektirmez
	/* Erişim: JQBuilder::, $this->JQBuilder, zn::$use->JQBuilder, uselib('JQBuilder')
	/* Not: Büyük-küçük harf duyarlılığı yoktur.
	/***********************************************************************************/
	
	/* Selector Variables
	 * Selector 
	 * this, #custom, .example
	 *
	 * $(this), $("#custom"), $(".example") 
	 */
	protected $selector = 'this';
	
	/* Property Variables
	 * Property 
	 * css, attr, val
	 *
	 * $.css(), .attr(), .val()
	 */
	 
	protected $property = '';
	
	/* Property Queue Variables
	 * 
	 *
	 * @string var = 1
	 * 
	 */	
	protected $propertyQueue = '';
	
	/* Attributes Variables
	 * Attributes 
	 * 
	 *
	 * {key:val} 
	 */
	protected $attr = '';
	
	/******************************************************************************************
	* CALL                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Geçersiz fonksiyon girildiğinde çağrılması için.						  |
	|          																				  |
	******************************************************************************************/
	public function __call($method = '', $param = '')
	{	
		die(getErrorMessage('Error', 'undefinedFunction', "JQBuilder::$method()"));	
	}
	
	/******************************************************************************************
	* SELECTOR                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Seçiciyi belirlemek için kullanılır.									  |
		
	  @param string $selector $(selector)
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function selector($selector = '')
	{
		$this->selector = $selector;
		
		return $this;
	}	
	
	/******************************************************************************************
	* PROPERTY                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Özelliği belirlemek için kullanılır.									  |
		
	  @param string $property .property()
	  @param array  $attr     .property(p1, p2, p3 .... )
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function property($property = '', $attr = array())
	{
		if( ! is_string($property) )
		{
			Error::set(lang('Error', 'stringParameter', 'property'));
			return $this;	
		}
		
		$this->property = $property;

		$this->attr = $attr;
		
		$this->propertyQueue .= JQ::property($property, $attr);

		return $this;
	}
	
	/******************************************************************************************
	* COMPLETE                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Bağlantılı dizge oluşturmak istenirse dizge bu yöntem ile sonlandırılır.|
		
	  @param string $void
	  
	  @return string
	|          																				  |
	******************************************************************************************/
	public function complete()
	{
		$complete = $this->propertyQueue;

		$this->_defaultVariable();
		
		return $complete;
	}
	
	/******************************************************************************************
	* CREATE                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Dizgeyi tamamlayıp oluşturmak için kullanılan nihai yöntemdir.	      |
		
	  @param string arguments $complete1, $complete2 ... $completeN
	  
	  @return $string
	|          																				  |
	******************************************************************************************/
	public function create()
	{
		$combineFunction = func_get_args();
		
		$complete  = eol().JQ::selector($this->selector);
		
		$complete .= $this->complete();		
			
		if( ! empty($combineFunction)) foreach( $combineFunction as $function )
		{			
			$complete .= $function;
		}
		
		$complete .= ";";
		
		return $complete;	
	}
	
	/******************************************************************************************
	* PROTECTED DEFAULT VARIABLE                                                              *
	*******************************************************************************************
	| Genel Kullanım: Değişkenlerin var sayılan ayarlarına dönmeleri sağlanır.     		      |
		
	  @param void
	  
	  @return void
	|          																				  |
	******************************************************************************************/
	protected function _defaultVariable()
	{
		if( $this->selector !== 'this' ) 	$this->selector = 'this';
		if( $this->property !== '' )  		$this->property = '';
		if( $this->attr !== '' )  			$this->attr = '';
		if( $this->propertyQueue !== '') 	$this->propertyQueue = '';
	}
}