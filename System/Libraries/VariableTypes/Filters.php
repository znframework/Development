<?php	
class __USE_STATIC_ACCESS__Filters
{
	/***********************************************************************************/
	/* FILTERS LIBRARY					                   	                           */
	/***********************************************************************************/
	/* Yazar: Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	/* Site: www.zntr.net
	/* Lisans: The MIT License
	/* Telif Hakkı: Copyright (c) 2012-2015, zntr.net
	/*
	/* Sınıf Adı: Filters
	/* Versiyon: 2.0 Eylül Güncellemesi
	/* Tanımlanma: Mixed
	/* Dahil Edilme: Gerektirmez
	/* Erişim: Filters::, $this->Filters, zn::$use->Filters, uselib('Filters')
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
		die(getErrorMessage('Error', 'undefinedFunction', "Filters::$method()"));	
	}
	
	/******************************************************************************************
	* GET VAR                                                                                 *
	*******************************************************************************************
	| Genel Kullanım: GET değişkeninin tanımlı olup olmadına bakar.				 	          |
	|          																				  |
	******************************************************************************************/
	public function getVar($varName = '')
	{
		return $this->_var($varName, INPUT_GET);
	}	
	
	/******************************************************************************************
	* POST VAR                                                                                *
	*******************************************************************************************
	| Genel Kullanım: POST değişkeninin tanımlı olup olmadına bakar.			 	          |
	|          																				  |
	******************************************************************************************/
	public function postVar($varName = '')
	{
		return $this->_var($varName, INPUT_POST);
	}	
	
	/******************************************************************************************
	* COOKIE VAR                                                                              *
	*******************************************************************************************
	| Genel Kullanım: COOKIE değişkeninin tanımlı olup olmadına bakar.			 	          |
	|          																				  |
	******************************************************************************************/
	public function cookieVar($varName = '')
	{
		return $this->_var($varName, INPUT_COOKIE);
	}
	
	/******************************************************************************************
	* ENV VAR                                                                  		          *
	*******************************************************************************************
	| Genel Kullanım: ENV değişkeninin tanımlı olup olmadına bakar.				 	          |
	|          																				  |
	******************************************************************************************/
	public function envVar($varName = '')
	{
		return $this->_var($varName, INPUT_ENV);
	}
	
	/******************************************************************************************
	* SERVER VAR                                                                              *
	*******************************************************************************************
	| Genel Kullanım: SERVER değişkeninin tanımlı olup olmadına bakar.			 	          |
	|          																				  |
	******************************************************************************************/
	public function serverVar($varName = '')
	{
		return $this->_var($varName, INPUT_SERVER);
	}
	
	/******************************************************************************************
	* ID		                                                                              *
	*******************************************************************************************
	| Genel Kullanım: Filter nesnesinin idsini döndürür.						 	          |
	|          																				  |
	******************************************************************************************/
	public function id($filterName = '')
	{
		if( ! is_string($filterName) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(filterName)'));	
		}	
		
		return filter_id($filterName);	
	}
	
	/******************************************************************************************
	* GET LIST                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Filtre nesnelerinin listesini döndürür.					 	          |
	|          																				  |
	******************************************************************************************/
	public function getList()
	{
		return filter_list();	
	}	
	
	/******************************************************************************************
	* INPUT ARRAY                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Harici değişkenleri alır ve isteğe bağlı olarak filtreler.		      |
	|          																				  |
	******************************************************************************************/
	public function inputArray($type = 'post', $definition = array(), $addEmpty = true)
	{		
		return filter_input_array($this->_inputConstant($type), $definition, $addEmpty);	
	}
	
	/******************************************************************************************
	* VAR ARRAY                                                                               *
	*******************************************************************************************
	| Genel Kullanım: Harici değişkenleri alır ve isteğe bağlı olarak filtreler.		      |
	|          																				  |
	******************************************************************************************/
	public function varArray($data = array(), $definition = NULL, $addEmpty = true)
	{		
		if( ! is_array($data) )
		{
			return Error::set(lang('Error', 'arrayParameter', '1.(data)'));	
		}
		
		return filter_var_array($data, $definition, $addEmpty);	
	}
	
	/******************************************************************************************
	* INPUT 	                                                                              *
	*******************************************************************************************
	| Genel Kullanım: Harici değişkenleri alır ve isteğe bağlı olarak filtreler.		      |
	|          																				  |
	******************************************************************************************/
	public function input($var = '', $type = 'post', $filter = 'default' , $options = NULL)
	{
		return filter_input($this->_inputConstant($type), $var, $this->_filterConstant($filter), $options);	
	}
	
	/******************************************************************************************
	* VAR    	                                                                              *
	*******************************************************************************************
	| Genel Kullanım: Birden çok değişken alır ve isteğe bağlı olarak bunları filtreler.	  |
	|          																				  |
	******************************************************************************************/
	public function vars($var = '', $filter = 'default', $options = NULL)
	{
		return filter_var($var, $this->_filterConstant($filter), $options);	
	}
	
	protected function _var($varName = '', $type)
	{
		if( ! is_string($varName) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(varName)'));	
		}	
		
		return filter_has_var($this->_inputConstant($type), $varName);	
	}	
	
	protected function _inputConstant($const)
	{
		return Convert::toConstant($const, 'INPUT_');
	}	
	
	protected function _filterConstant($const)
	{
		return Convert::toConstant($const, 'FILTER_');
	}	
}