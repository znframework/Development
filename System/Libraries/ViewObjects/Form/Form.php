<?php
class __USE_STATIC_ACCESS__Form implements FormInterface
{
	//----------------------------------------------------------------------------------------------------
	//
	// Yazar      : Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	// Site       : www.zntr.net
	// Lisans     : The MIT License
	// Telif Hakkı: Copyright (c) 2012-2016, zntr.net
	//
	//----------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------
	// $settings
	//----------------------------------------------------------------------------------------------------
	//
	// Ayarları tutmak için
	//
	// @var array
	//
	//----------------------------------------------------------------------------------------------------
	protected $settings = array();
	
	//----------------------------------------------------------------------------------------------------
	// Common
	//----------------------------------------------------------------------------------------------------
	// 
	// attributes()
	// _input()
	//
	//----------------------------------------------------------------------------------------------------
	use HyperTextTrait;
	
	//----------------------------------------------------------------------------------------------------
	// Setting Methods Başlangıç
	//----------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------
	// name()
	//----------------------------------------------------------------------------------------------------
	// 
	// @param string $name
	//
	//----------------------------------------------------------------------------------------------------
	public function name($name = '')
	{
		$this->settings['attr']['name'] = $name;
		
		return $this;
	}
	
	//----------------------------------------------------------------------------------------------------
	// value()
	//----------------------------------------------------------------------------------------------------
	// 
	// @param string $value
	//
	//----------------------------------------------------------------------------------------------------
	public function value($value = '')
	{
		$this->settings['attr']['value'] = $value;
		
		return $this;
	}
	
	//----------------------------------------------------------------------------------------------------
	// id()
	//----------------------------------------------------------------------------------------------------
	// 
	// @param string $id
	//
	//----------------------------------------------------------------------------------------------------
	public function id($id = '')
	{
		$this->settings['attr']['id'] = $id;
		
		return $this;
	}
	
	//----------------------------------------------------------------------------------------------------
	// attr()
	//----------------------------------------------------------------------------------------------------
	// 
	// @param array $attr
	//
	//----------------------------------------------------------------------------------------------------
	public function attr($attr = array())
	{
		$this->settings['attr'] = array_merge($this->settings['attr'], $attr);
		
		return $this;
	}
	
	//----------------------------------------------------------------------------------------------------
	// checked()
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  void
	// @return string
	//
	//----------------------------------------------------------------------------------------------------
	public function checked($checked = true)
	{
		if( $checked === true )
		{		
			$this->settings['attr']['checked'] = "checked";
		}
	
		return $this;
	}
	
	//----------------------------------------------------------------------------------------------------
	// selected()
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  void
	// @return string
	//
	//----------------------------------------------------------------------------------------------------
	public function selected($selected = true)
	{
		if( $selected === true )
		{
			$this->settings['attr']['selected'] = "selected";
		}
		
		return $this;
	}
	
	//----------------------------------------------------------------------------------------------------
	// multiple()
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  void
	// @return string
	//
	//----------------------------------------------------------------------------------------------------
	public function multiple($multiple = true)
	{
		if( $multiple === true )
		{
			$this->settings['attr']['multiple'] = "multiple";
		}
		
		return $this;
	}
	
	//----------------------------------------------------------------------------------------------------
	// Setting Methods Bitiş
	//----------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------
	// Tag Methods Başlangıç
	//----------------------------------------------------------------------------------------------------

	//----------------------------------------------------------------------------------------------------
	// enctype()
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  void
	// @return string
	//
	//----------------------------------------------------------------------------------------------------
	public function enctype($enctype = '')
	{
		$this->settings['attr']['enctype'] = $enctype;
		
		return $this;
	}
	
	//----------------------------------------------------------------------------------------------------
	// method()
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  string $method
	// @return string
	//
	//----------------------------------------------------------------------------------------------------
	public function method($method = '')
	{
		$this->settings['attr']['method'] = $method;
		
		return $this;
	}
	
	//----------------------------------------------------------------------------------------------------
	// action()
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  string $method
	// @return string
	//
	//----------------------------------------------------------------------------------------------------
	public function action($action = '')
	{
		$this->settings['attr']['action'] = isUrl($action) ? $action : siteUrl($action);
		
		return $this;
	}
	
	/******************************************************************************************
	* OPEN                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Html <form> tagının kullanımıdır. Yani form tagını açmak içindir.  	  |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                              	      |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  						      |
	| 2. array var @attributes => Özellik ve değer çiftlerini içerecek dizi parametresi.	  |
	|          																				  |
	| Örnek Kullanım: open('yeniForm', array('id' => 'zntr'));        	  					  |
	| // <form name="yeniForm" id="zntr">         											  |
	|          																				  |
	| ENCTYPE anahtar kelimesinin alabileceği değerler.         							  |
	| 2. parametrede enctype anahtar kelimesi kullanılırsa şu değerleri alabilir.         	  |
	|																						  |
	| 1. multipart    	=> multipart/form-data       										  |
	| 2. application 	=> application/x-www-form-urlencoded       							  |
	| 3. text 		 	=> text/plain      											          |
	|          																				  |
	******************************************************************************************/	
	public function open($name = '', $_attributes = '')
	{
		if( isset($this->settings['attr']['name']) )
		{
			$name = $this->settings['attr']['name'];
		}
		
		if( isset($this->settings['attr']) )
		{
			$_attributes = $this->settings['attr'];
		}
		
		if( isset($this->settings['enctype']) )
		{
			$_attributes['enctype'] = $this->settings['enctype'];
		}
		
		// Enctype için 3 parametre kullamı.
		// 1. multipart    	=> multipart/form-data       										  
		// 2. application 	=> application/x-www-form-urlencoded       							  
		// 3. text 		 	=> text/plain      											           
		if( isset($_attributes['enctype']) )
		{
			switch( $_attributes['enctype'] )
			{
				case "multipart" : 
					$_attributes['enctype'] = 'multipart/form-data'; 					
				break;
				
				case "application" : 
					$_attributes['enctype'] = 'application/x-www-form-urlencoded';	
				break;
				
				case "text" : 
					$_attributes['enctype'] = 'text/plain'; 							
				break;
			}
		}
		
		// 2. parametrede dizi içerisinde method belirtilmemişse
		// Varsayılan olarak post değerini kullan.
		if( ! isset($_attributes['method']) ) 
		{
			$_attributes['method'] = 'post';
		}
		
		$return = '<form'.$this->attributes($_attributes).'>'.eol();
		
		$this->settings = array();	
		
		return $return;
	}

	/******************************************************************************************
	* CLOSE                                                                                   *
	*******************************************************************************************
	| Genel Kullanım: Html </form> tagının kullanımıdır. Yani form tagını kapatmak içindir.   |
	|															                              |
	| Parametreler: Herhangi bir parametresi yoktur.                                          |
	|          																				  |
	| Örnek Kullanım: close();        	  					  								  |
	| // </form>         											  						  |
	|          																				  |
	******************************************************************************************/	
	public function close()
	{
		return '</form>'.eol();
	}
	
	//----------------------------------------------------------------------------------------------------
	// Tag Methods Bitiş
	//----------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------
	// Button Methods Başlangıç
	//----------------------------------------------------------------------------------------------------

	/******************************************************************************************
	* BUTTON                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Html <input type="button"> tagının kullanımıdır.    				      |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @name => Form nesnesinin değerini belirtilir.	  				          |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: button('nesne', 'Değer', array('style' => 'color:red'));        	      |
	| // <input type="button" name="nesne" value="Değer" style="color:red">       		      |
	|          																				  |
	******************************************************************************************/	
	public function button($name = "", $value = "", $_attributes = '')
	{
		return $this->_input($name, $value, $_attributes, 'button');
	}
	
	/******************************************************************************************
	* RESET                                                                                   *
	*******************************************************************************************
	| Genel Kullanım: Html <input type="reset"> tagının kullanımıdır.    				      |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @name => Form nesnesinin değerini belirtilir.	  				          |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: reset('nesne', 'Değer', array('style' => 'color:red'));        	      |
	| // <input type="reset" name="nesne" value="Değer" style="color:red">       		      |
	|          																				  |
	******************************************************************************************/	
	public function reset($name = "", $value = "", $_attributes = '')
	{
		return $this->_input($name, $value, $_attributes, 'reset');
	}	
	
	/******************************************************************************************
	* SUBMIT                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Html <input type="submit"> tagının kullanımıdır.    				      |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @name => Form nesnesinin değerini belirtilir.	  				          |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: submit('nesne', 'Değer', array('style' => 'color:red'));        	      |
	| // <input type="submit" name="nesne" value="Değer" style="color:red">       		      |
	|          																				  |
	******************************************************************************************/	
	public function submit($name = "", $value = "", $_attributes = '')
	{
		return $this->_input($name, $value, $_attributes, 'submit');
	}
	
	/******************************************************************************************
	* RADIO                                                                                   *
	*******************************************************************************************
	| Genel Kullanım: Html <input type="radio"> tagının kullanımıdır.    				      |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @name => Form nesnesinin değerini belirtilir.	  				          |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: radio('nesne', 'Değer', array('style' => 'color:red'));        	      |
	| // <input type="radio" name="nesne" value="Değer" style="color:red">       		      |
	|          																				  |
	******************************************************************************************/	
	public function radio($name = "", $value = "", $_attributes = '')
	{
		return $this->_input($name, $value, $_attributes, 'radio');
	}
	
	/******************************************************************************************
	* CHECKBOX                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Html <input type="checkbox"> tagının kullanımıdır.    				  |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @name => Form nesnesinin değerini belirtilir.	  				          |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: checkBox('nesne', 'Değer', array('style' => 'color:red'));        	  |
	| // <input type="checkbox" name="nesne" value="Değer" style="color:red">       		  |
	|          																				  |
	******************************************************************************************/	
	public function checkBox($name = "", $value = "", $_attributes = '')
	{
		return $this->_input($name, $value, $_attributes, 'checkbox');
	}
	
	//----------------------------------------------------------------------------------------------------
	// Button Methods Bitiş
	//----------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------
	// Date Time Input Methods Başlangıç
	//----------------------------------------------------------------------------------------------------

	/******************************************************************************************
	* DATE OBJECT                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Html <input type="date"> tagının kullanımıdır.    					  |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @name => Form nesnesinin değerini belirtilir.	  				          |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: dateObject('nesne', 'Değer', array('style' => 'color:red'));           |
	| // <input type="date" name="nesne" value="Değer" style="color:red">       			  | 
	|          																				  |
	******************************************************************************************/
	public function date($name = "", $value = "", $_attributes = '')
	{
		return $this->_input($name, $value, $_attributes, 'date');
	}
	
	/******************************************************************************************
	* TIME OBJECT                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Html <input type="time"> tagının kullanımıdır.    			          |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @name => Form nesnesinin değerini belirtilir.	  				          |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: timeObject('nesne', 'Değer', array('style' => 'color:red'));           |
	| // <input type="time" name="nesne" value="Değer" style="color:red">       	          | 
	|          																				  |
	******************************************************************************************/
	public function time($name = "", $value = "", $_attributes = '')
	{
		return $this->_input($name, $value, $_attributes, 'time');
	}
	
	/******************************************************************************************
	* DATETIME OBJECT                                                                         *
	*******************************************************************************************
	| Genel Kullanım: Html <input type="datetime"> tagının kullanımıdır.    				  |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @name => Form nesnesinin değerini belirtilir.	  				          |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: datetimeObject('nesne', 'Değer', array('style' => 'color:red'));       |
	| // <input type="datetime" name="nesne" value="Değer" style="color:red">       		  | 
	|          																				  |
	******************************************************************************************/
	public function datetime($name = "", $value = "", $_attributes = '')
	{
		return $this->_input($name, $value, $_attributes, 'datetime');
	}
	
	/******************************************************************************************
	* DATETIME-LOCAL OBJECT                                                                   *
	*******************************************************************************************
	| Genel Kullanım: Html <input type="datetime-local"> tagının kullanımıdır.    			  |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @name => Form nesnesinin değerini belirtilir.	  				          |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: datetimeLocalObject('nesne', 'Değer', array('style' => 'color:red')); |
	| // <input type="datetime-local" name="nesne" value="Değer" style="color:red">       	  | 
	|          																				  |
	******************************************************************************************/
	public function datetimeLocal($name = "", $value = "", $_attributes = '')
	{
		return $this->_input($name, $value, $_attributes, 'datetime-local');
	}
	
	/******************************************************************************************
	* WEEK OBJECT                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Html <input type="week"> tagının kullanımıdır.    			          |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @name => Form nesnesinin değerini belirtilir.	  				          |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: weekObject('nesne', 'Değer', array('style' => 'color:red'));           |
	| // <input type="week" name="nesne" value="Değer" style="color:red">       	          | 
	|          																				  |
	******************************************************************************************/
	public function week($name = "", $value = "", $_attributes = '')
	{
		return $this->_input($name, $value, $_attributes, 'week');
	}
	
	/******************************************************************************************
	* MONTH OBJECT                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Html <input type="month"> tagının kullanımıdır.    			          |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @name => Form nesnesinin değerini belirtilir.	  				          |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: monthObject('nesne', 'Değer', array('style' => 'color:red'));          |
	| // <input type="month" name="nesne" value="Değer" style="color:red">       	          | 
	|          																				  |
	******************************************************************************************/
	public function month($name = "", $value = "", $_attributes = '')
	{
		return $this->_input($name, $value, $_attributes, 'month');
	}
	
	//----------------------------------------------------------------------------------------------------
	// Date Time Input Methods Başlangıç
	//----------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------
	// Text Box Methods Başlangıç
	//----------------------------------------------------------------------------------------------------

	/******************************************************************************************
	* TEXT                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Html <input type="text"> tagının kullanımıdır.    					  |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @name => Form nesnesinin değerini belirtilir.	  				          |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: text('nesne', 'Değer', array('style' => 'color:red'));        	  	  |
	| // <input type="text" name="nesne" value="Değer" style="color:red">       			  |
	|          																				  |
	******************************************************************************************/	
	public function text($name = "", $value = "", $_attributes = '')
	{
		return $this->_input($name, $value, $_attributes, 'text');
	}
	
	/******************************************************************************************
	* TEXTAREA                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Html <textarea></textarea> tagının kullanımıdır.    				      |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @name => Form nesnesinin değerini belirtilir.	  				          |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: textArea('nesne', 'Değer', array('style' => 'color:red'));        	  |
	| // <textarea name="nesne" style="color:red">Değer</textarea>				       		  |
	|          																				  |
	******************************************************************************************/	
	public function textArea($name = "", $value = "", $_attributes = '')
	{
		if( isset($this->settings['attr']['name']) )
		{
			$name = $this->settings['attr']['name'];
		}
		
		if( isset($this->settings['attr']['value']) )
		{
			$value = $this->settings['attr']['value'];
			
			unset($this->settings['attr']['value']);
		}
		
		if( isset($this->settings['attr']) )
		{
			$_attributes = $this->settings['attr'];
		}
		
		$this->settings = array();	
		
		return '<textarea'.$this->attributes($_attributes).'>'.$value.'</textarea>'.eol();
	}
	
	/******************************************************************************************
	* SEARCH OBJECT                                                                           *
	*******************************************************************************************
	| Genel Kullanım: Html <input type="search"> tagının kullanımıdır.    					  |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @name => Form nesnesinin değerini belirtilir.	  				          |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: searchObject('nesne', 'Değer', array('style' => 'color:red'));         |
	| // <input type="search" name="nesne" value="Değer" style="color:red">       			  | 
	|          																				  |
	******************************************************************************************/	
	public function search($name = "", $value = "", $_attributes = '')
	{
		return $this->_input($name, $value, $_attributes, 'search');
	}
	
	/******************************************************************************************
	* PASSWORD                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Html <input type='password'> tagının kullanımıdır.    				  |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @name => Form nesnesinin değerini belirtilir.	  				          |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: password('nesne', 'Değer', array('style' => 'color:red'));        	  |
	| // <input type='password' name="nesne" value="Değer" style="color:red">       		  |
	|          																				  |
	******************************************************************************************/	
	public function password($name = "", $value = "", $_attributes = '')
	{
		return $this->_input($name, $value, $_attributes, 'password');
	}
	
	//----------------------------------------------------------------------------------------------------
	// Text Box Methods Bitiş
	//----------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------
	// Validate Input Methods Başlangıç
	//----------------------------------------------------------------------------------------------------

	/******************************************************************************************
	* EMAIL OBJECT                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Html <input type="email"> tagının kullanımıdır.    					  |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @name => Form nesnesinin değerini belirtilir.	  				          |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: emailObject('nesne', 'Değer', array('style' => 'color:red'));          |
	| // <input type="email" name="nesne" value="Değer" style="color:red">       			  |
	|          																				  |
	******************************************************************************************/	
	public function email($name = '', $value = '', $_attributes = '')
	{
		return $this->_input($name, $value, $_attributes, 'email');
	}
	
	/******************************************************************************************
	* TEL OBJECT                                                                              *
	*******************************************************************************************
	| Genel Kullanım: Html <input type="tel"> tagının kullanımıdır.    					      |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @name => Form nesnesinin değerini belirtilir.	  				          |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: telObject('nesne', 'Değer', array('style' => 'color:red'));            |
	| // <input type="tel" name="nesne" value="Değer" style="color:red">       			  | 
	|          																				  |
	******************************************************************************************/	
	public function tel($name = "", $value = "", $_attributes = '')
	{
		return $this->_input($name, $value, $_attributes, 'tel');
	}
	
	/******************************************************************************************
	* NUMBER OBJECT                                                                           *
	*******************************************************************************************
	| Genel Kullanım: Html <input type="number"> tagının kullanımıdır.    					  |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @name => Form nesnesinin değerini belirtilir.	  				          |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: numberObject('nesne', 'Değer', array('style' => 'color:red'));         |
	| // <input type="url" name="nesne" value="Değer" style="color:red">       			  | 
	|          																				  |
	******************************************************************************************/	
	public function number($name = "", $value = "", $_attributes = '')
	{
		return $this->_input($name, $value, $_attributes, 'number');
	}
	
	/******************************************************************************************
	* URL OBJECT                                                                              *
	*******************************************************************************************
	| Genel Kullanım: Html <input type="url"> tagının kullanımıdır.    					      |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @name => Form nesnesinin değerini belirtilir.	  				          |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: urlObject('nesne', 'Değer', array('style' => 'color:red'));            |
	| // <input type="url" name="nesne" value="Değer" style="color:red">       			      | 
	|          																				  |
	******************************************************************************************/	
	public function url($name = "", $value = "", $_attributes = '')
	{
		return $this->_input($name, $value, $_attributes, 'url');
	}
	
	//----------------------------------------------------------------------------------------------------
	// Validate Input Methods Bitiş
	//----------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------
	// Select Box Input Methods Başlangıç
	//----------------------------------------------------------------------------------------------------

	//----------------------------------------------------------------------------------------------------
	// selectedKey()
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  void
	// @return string
	//
	//----------------------------------------------------------------------------------------------------
	public function selectedKey($key = '')
	{
		$this->settings['selectedKey'] = $key;
		
		return $this;
	}
	
	//----------------------------------------------------------------------------------------------------
	// selectedValue()
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  void
	// @return string
	//
	//----------------------------------------------------------------------------------------------------
	public function selectedValue($value = '')
	{
		$this->settings['selectedValue'] = $value;
		
		return $this;
	}
	
	//----------------------------------------------------------------------------------------------------
	// option()
	//----------------------------------------------------------------------------------------------------
	// 
	// @param array $attr
	//
	//----------------------------------------------------------------------------------------------------
	public function option($key = '', $value = '')
	{
		$this->settings['option'][$key] = $value;
		
		return $this;
	}
	
	/******************************************************************************************
	* SELECT                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Html <select><option></option></select tagının kullanımıdır.    		  |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. array var @name => Form nesnesinin seçeneklerini belirtilir.	  				      |
	| 3. string var @selected => Seçili olması istenen seçenek.	  				              |
	| 4. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: select('nesne', array(1 => 'a', 2 => 'b'), 2);        	              |
	| // <select name='nesne' id='nesne'>													  |
	|			<option value="1">a</option>  												  |
	|			<option selected="selected" value="1">a</option>   							  |
	|	 </select>   		      															  |
	|          																				  |
	******************************************************************************************/	
	public function select($name = '', $options = array(), $selected = '', $_attributes = '', $multiple = false)
	{
		if( isset($this->settings['attr']) )
		{
			$_attributes = $this->settings['attr'];
		}
		
		if( isset($this->settings['option']) )
		{
			$options = $this->settings['option'];
		}
		
		if( isset($this->settings['selectedKey']) )
		{
			$selected = $this->settings['selectedKey'];
		}
		
		if( isset($this->settings['selectedValue']) )
		{
			$flip     = array_flip($options);
			$selected = $flip[$this->settings['selectedValue']];
		}

		// Son parametrenin durumuna multiple olması belirleniyor.
		// Ancak bu parametrenin kullanımı gerekmez.
		// Bunun için multiple() yöntemi oluşturulmuştur.
		if( $multiple === true )
		{
			$_attributes['multiple'] ="multiple";	
		}
		
		if( $name !== '' )
		{
			$_attributes['name'] ="name";	
		}
				  
		$selectbox = '<select'.$this->attributes($_attributes).'>';
		
		if( is_array($options) ) foreach( $options as $key => $value )
		{
			if( $selected == $key ) 
			{
				$select = 'selected="selected"'; 
			}
			else 
			{
				$select = "";
			}
			$selectbox .= '<option value="'.$key.'" '.$select.'>'.$value.'</option>'.eol();
		}
		
		$selectbox .= '</select>'.eol();	
		
		$this->settings = array();	
		
		return $selectbox;
	}
	
	/******************************************************************************************
	* MULTI SELECT                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Html <select><option></option></select tagının kullanımıdır.    		  |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. array var @name => Form nesnesinin seçeneklerini belirtilir.	  				      |
	| 3. string var @selected => Seçili olması istenen seçenek.	  				              |
	| 4. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: select('nesne', array(1 => 'a', 2 => 'b'), 2);        	              |
	| // <select multiple="multiple" name='nesne' id='nesne'>								  |
	|			<option value="1">a</option>  												  |
	|			<option selected="selected" value="1">a</option>   							  |
	|	 </select>   		      															  |
	|          																				  |
	******************************************************************************************/	
	public function multiSelect($name = '', $options = array(), $selected = '', $_attributes = '')
	{
		return $this->select($name, $options, $selected, $_attributes, true);
	}
	
	//----------------------------------------------------------------------------------------------------
	// Select Box Input Methods Bitiş
	//----------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------
	// Other Input Methods Başlangıç
	//----------------------------------------------------------------------------------------------------

	/******************************************************************************************
	* RANGE OBJECT                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Html <input type="range"> tagının kullanımıdır.    			          |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @name => Form nesnesinin değerini belirtilir.	  				          |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: rangeObject('nesne', 'Değer', array('style' => 'color:red'));          |
	| // <input type="range" name="nesne" value="Değer" style="color:red">       	          | 
	|          																				  |
	******************************************************************************************/
	public function range($name = "", $value = "", $_attributes = '')
	{
		return $this->_input($name, $value, $_attributes, 'range');
	}
	
	/******************************************************************************************
	* IMAGE OBJECT                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Html <input type="image"> tagının kullanımıdır.    			          |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @name => Form nesnesinin değerini belirtilir.	  				          |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: imageObject('nesne', 'Değer', array('style' => 'color:red'));          |
	| // <input type="image" name="nesne" value="Değer" style="color:red">       	          | 
	|          																				  |
	******************************************************************************************/
	public function image($name = "", $value = "", $_attributes = '')
	{
		return $this->_input($name, $value, $_attributes, 'image');
	}
	
	/******************************************************************************************
	* HIDDEN                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Html <input type="hidden"> tagının kullanımıdır.    					  |
	|															                              |
	| Parametreler: 2 parametresi vardır.		                                              |
	| 1. string/array var @name => Form hidden nesnesinin ismi belirtilir.	  				  |
	| 2. string var @name => Form hidden nesnesinin değerini belirtilir.	  				  |
	|          																				  |
	| Örnek Kullanım: hidden('nesne', 'Değer');        	  					  				  |
	| // <input type="hidden" name="nesne" value="Değer">       							  |
	|          																				  |
	| Çoklu HIDDEN nesnesi oluştrumak için 2 parametre dizi olarak girilir.         		  |
	| Örnek Kullanım: hidden(array('nesne1' => 'değer1', 'nesne2' => 'değer2' ... ));         |
	|          																				  |
	| Not: Çoklu kullanım sadece hidden nesnesine özgüdür.         							  |
	|          																				  |
	******************************************************************************************/	
	public function hidden($name = '', $value = '')
	{
		if( ! is_scalar($value) ) 
		{
			$value = '';
		}
		
		if( isset($this->settings['attr']['name']) )
		{
			$name = $this->settings['attr']['name'];
		}
		
		if( isset($this->settings['attr']['value']) )
		{
			$value = $this->settings['attr']['value'];
		}
		
		$hiddens = NULL;
		
		$value = ( ! empty($value) ) 
				 ? 'value="'.$value.'"' 
				 : "";
		
		// 1. parametre dizi ise
		if( is_array($name) ) foreach( $name as $key => $val )
		{
			$hiddens .= '<input type="hidden" name="'.$key.'" id="'.$key.'" value="'.$val.'">'.eol();	
		}
		else
		{
			$hiddens = 	'<input type="hidden" name="'.$name.'" id="'.$name.'" '.$value.'>'.eol();
		}
		
		$this->settings = array();	
		
		return $hiddens;
	}	
	
	/******************************************************************************************
	* FILE                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Html <input type="file"> tagının kullanımıdır.         				  |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @multiple => Çoklu upload olup olmayacağı belirtilir.   			      |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: file('nesne', 'Değer', array('style' => 'color:red'));        	      |
	| // <input type="file" name="nesne" value="Değer" style="color:red">       		      |
	|          																				  |
	******************************************************************************************/	
	public function file($name = "", $multiple = false, $_attributes = '')
	{
		if( isset($this->settings['attr']) )
		{
			$_attributes = $this->settings['attr'];
		}
		
		if( ! empty($this->settings['attr']['multiple']) )
		{
			$multiple = true;
		}
		
		if( ! empty($this->settings['attr']['name']) )
		{
			$name = $this->settings['attr']['name'];
		}
		
		if( $multiple === true )
		{
			$_attributes['multiple'] = 'multiple';	
			$name = suffix($name, '[]');
		}
		
		return $this->_input($name, '', $_attributes, 'file');
	}
	
	/******************************************************************************************
	* COLOR OBJECT                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Html <input type="color"> tagının kullanımıdır.    					  |
	|															                              |
	| Parametreler: 3 parametresi vardır.		                                              |
	| 1. string var @name => Form nesnesinin ismi belirtilir.	  				              |
	| 2. string var @name => Form nesnesinin değerini belirtilir.	  				          |
	| 3. array var @attributes => Form nesnesine farklı özellik değer çifti belirtmek içindir.|
	|          																				  |
	| Örnek Kullanım: colorObject('nesne', 'Değer', array('style' => 'color:red'));          |
	| // <input type="color" name="nesne" value="Değer" style="color:red">       			  | 
	|          																				  |
	******************************************************************************************/
	public function color($name = "", $value = "", $_attributes = '')
	{
		return $this->_input($name, $value, $_attributes, 'color');
	}
	
	//----------------------------------------------------------------------------------------------------
	// Other Input Methods Bitiş
	//----------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------
	// Input Method Başlangıç
	//----------------------------------------------------------------------------------------------------

	//----------------------------------------------------------------------------------------------------
	// type()
	//----------------------------------------------------------------------------------------------------
	// 
	// @param string $id
	//
	//----------------------------------------------------------------------------------------------------
	public function type($type = '')
	{
		$this->settings['attr']['type'] = $type;
		
		return $this;
	}
	
	//----------------------------------------------------------------------------------------------------
	// Input Method Bitiş
	//----------------------------------------------------------------------------------------------------
}