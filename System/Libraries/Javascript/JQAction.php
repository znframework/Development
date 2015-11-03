<?php
class __USE_STATIC_ACCESS__JQAction extends JSCommon
{
	/***********************************************************************************/
	/* JQUERY ACTION LIBRARY  	     		                   	                       */
	/***********************************************************************************/
	/* Yazar: Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	/* Site: www.zntr.net
	/* Lisans: The MIT License
	/* Telif Hakkı: Copyright (c) 2012-2015, zntr.net
	/*
	/* Sınıf Adı: JQAction
	/* Versiyon: 1.2
	/* Güncellemeler: 2.0 Eylül
	/* Tanımlanma: Statik, Dinamik
	/* Dahil Edilme: Gerektirmez
	/* Erişim: JQAction::, $this->JQAction, zn::$use->JQAction, uselib('JQAction')
	/* Not: Büyük-küçük harf duyarlılığı yoktur.
	/***********************************************************************************/
	
	/* 
	 * Seçici seçimi
	 *
	 * $(this), $("#custom"), $(".example") 
	 *
	 * @var string this
	 */
	protected $selector = 'this';
	
	/* 
	 * Özellik belirteci.
	 *
	 * .show(), .slideUp(), .fadeIn() ...
	 *
	 * @var string show
	 */
	protected $type		= 'show';
	
	/* 
	 * Fonksiyon bloğu
	 *
	 * function(data){alert("example");}
	 *
	 * @var string
	 */
	protected $callback = '';
	
	/* 
	 * Hız bilgisi 
	 *
	 * 1000, slow, fast
	 *
	 * @var string 
	 */
	protected $speed 	= '';
	
	/* 
	 * Hareket bilgisi 
	 * 
	 * easeIn, ease ...
	 * 
	 * @var string
	 */
	protected $easing   = '';
	 
	/******************************************************************************************
	* CALL                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Geçersiz fonksiyon girildiğinde çağrılması için.						  |
	|          																				  |
	******************************************************************************************/
	public function __call($method = '', $param = '')
	{	
		die(getErrorMessage('Error', 'undefinedFunction', "JQAction::$method()"));	
	}
	
	/******************************************************************************************
	* SELECTOR                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Seçici bilgisini oluşturulması için kullanılır.						  |
		
	  @param string $selector
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function selector($selector = '')
	{
		$this->selector = $selector;
		
		return $this;
	}
	
	/******************************************************************************************
	* SPEED                                                                                   *
	*******************************************************************************************
	| Genel Kullanım: Animasyon hızı bilgisini oluşturulması için kullanılır.			      |
		
	  @param string $speed
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function speed($speed = '')
	{
		$this->speed = $speed;
		
		return $this;
	}
	
	/******************************************************************************************
	* DURATION                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Speed işlevinin bir diğer ismidir.								      |
		
	  @param string $speed
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function duration($speed = '')
	{
		$this->speed($speed);
		
		return $this;
	}
	
	/******************************************************************************************
	* EASING                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Hareketin animasyon türünü belirlemek için kullanılır.			      |
		
	  @param string $data easeInOut...
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function easing($data = '')
	{
		$this->easing = $data;
		
		return $this;
	}
	
	/******************************************************************************************
	* TYPE                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Hareketin türünü belirlemek için kullanılır.						      |
		
	  @param string $type show, hide, slideUp, slideDown ...
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
 	public function type($type = 'show')
	{
		if( ! is_string($type))
		{
			Error::set(lang('Error', 'stringParameter', 'type'));
			return $this;	
		}
		
		$this->type = $type;
		
		return $this;
	}
	
	/******************************************************************************************
	* PROTECTED EFFECT                                                                        *
	*******************************************************************************************
	| Genel Kullanım: Efekt türlerini ayarlamak için oluşturulmuş temel işlevdir.   	      |
		
	  @param string $type
	  @param string $selector
	  @param string $callback
	  
	  @return void
	|          																				  |
	******************************************************************************************/
	protected function _effect($type = '', $selector = '', $speed = '', $callback = '')
	{
		$this->type = $type;
		
		if( ! empty($selector))
		{
			$this->selector($selector);	
		}
		
		if( ! empty($speed))
		{
			$this->speed($speed);	
		}
		
		if( ! empty($callback))
		{
			$this->callback('e', $callback);	
		}
	}
	
	/******************************************************************************************
	* SHOW                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Show animasyonun kullanımını sağlar.								      |
		
	  @param string $selector
	  @param string $callback 
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function show($selector = '', $speed = '', $callback = '')
	{
		$this->_effect('show', $selector, $speed, $callback);
		
		return $this->create();
	}
	
	/******************************************************************************************
	* HIDE                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Hide animasyonun kullanımını sağlar.								      |
		
	  @param string $selector
	  @param string $callback 
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function hide($selector = '', $speed = '', $callback = '')
	{
		$this->_effect('hide', $selector, $speed, $callback);
		
		return $this->create();
	}
	
	/******************************************************************************************
	* FADE IN                                                                                 *
	*******************************************************************************************
	| Genel Kullanım: Fade in animasyonun kullanımını sağlar.   						      |
		
	  @param string $selector
	  @param string $callback 
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function fadeIn($selector = '', $speed = '', $callback = '')
	{
		$this->_effect('fadeIn', $selector, $speed, $callback);
		
		return $this->create();
	}
	
	/******************************************************************************************
	* FADE OUT                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Fade out animasyonun kullanımını sağlar.	    					      |
		
	  @param string $selector
	  @param string $callback 
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function fadeOut($selector = '', $speed = '', $callback = '')

	{
		$this->_effect('fadeOut', $selector, $speed, $callback);
		
		return $this->create();
	}
	
	/******************************************************************************************
	* FADE TO                                                                                 *
	*******************************************************************************************
	| Genel Kullanım: Fade to animasyonun kullanımını sağlar.							      |
		
	  @param string $selector
	  @param string $callback 
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function fadeTo($selector = '', $speed = '', $callback = '')
	{
		$this->_effect('fadeTo', $selector, $speed, $callback);
		
		return $this->create();
	}
	
	/******************************************************************************************
	* SLIDE UP                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Slide up animasyonun kullanımını sağlar.	    					      |
		
	  @param string $selector
	  @param string $callback 
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function slideUp($selector = '', $speed = '', $callback = '')
	{
		$this->_effect('slideUp', $selector, $speed, $callback);
		
		return $this->create();
	}
	
	/******************************************************************************************
	* SLIDE DOWN                                                                              *
	*******************************************************************************************
	| Genel Kullanım: Slide down animasyonun kullanımını sağlar.	    				      |
		
	  @param string $selector
	  @param string $callback 
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function slideDown($selector = '', $speed = '', $callback = '')
	{
		$this->_effect('slideDown', $selector, $speed, $callback);
		
		return $this->create();
	}
	
	/******************************************************************************************
	* SLIDE TOGGLE                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Slide toggle animasyonun kullanımını sağlar.				    	      |
		
	  @param string $selector
	  @param string $callback 
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function slideToggle($selector = '', $speed = '', $callback = '')
	{
		$this->_effect('slideToggle', $selector, $speed, $callback);
		
		return $this->create();
	}
	
	/******************************************************************************************
	* CALLBACK                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Sorgunun fonksiyon bloğunu oluşturmak için kullanılır.     		      |
		
	  @param string $params
	  @param string $callback 
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function callback($params = '', $callback = '')
	{
		$this->callback = JQ::func($params, $callback);
		
		return $this;
	}
	
	/******************************************************************************************
	* FUNC                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Callback işlevinin diğer adıdır.						     		      |
		
	  @param string $params
	  @param string $callback 
	  
	  @return $this
	|          																				  |
	******************************************************************************************/
	public function func($params = '', $callback = '')
	{
		$this->callback($params, $callback);
		
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
		$event = JQ::property($this->type, array($this->speed, $this->easing, $this->callback));
		
		$this->_defaultVariable();
		
		return $event;
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
		$combineEffect = func_get_args();
		
		$event  = eol().JQ::selector($this->selector);
		$event .= $this->complete();
		
		if( ! empty($combineEffect) ) foreach($combineEffect as $effect)
		{			
			$event .= $effect;
		}
		
		$event .= ";";

		return $event;
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
		if($this->selector !== 'this') 	$this->selector = 'this';
		if($this->type !== 'show')  	$this->type		= 'show';
		if($this->callback !== '')  	$this->callback = '';
		if($this->speed !== '')  		$this->speed 	= '';
		if($this->easing !== '')  		$this->easing   = '';	
	}
}