<?php
//----------------------------------------------------------------------------------------------------
// TEMEL YAPI 
//----------------------------------------------------------------------------------------------------
//
// Yazar      : Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
// Site       : www.zntr.net
// Lisans     : The MIT License
// Telif Hakkı: Copyright (c) 2012-2016, zntr.net
//
//----------------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------------
// Production                                                                                     
//----------------------------------------------------------------------------------------------------
//
// Genel Kullanım: Çıktıyı üretmek için kullanılır.						  
//          																				  
//----------------------------------------------------------------------------------------------------

$datas 		= Structure::data();
$parameters = $datas['parameters'];
$page       = $datas['page'];
$isFile     = $datas['file'];
$function   = $datas['function'];

//----------------------------------------------------------------------------------------------------
// CURRENT_CFILE
//----------------------------------------------------------------------------------------------------
//
// @return Aktif çalıştırılan kontrolcü dosyasının yol bilgisi.
//
//----------------------------------------------------------------------------------------------------
define('CURRENT_CFILE', $isFile);

//----------------------------------------------------------------------------------------------------
// CURRENT_CFUNCTION
//----------------------------------------------------------------------------------------------------
//
// @return Aktif çalıştırılan sayfaya ait fonksiyon bilgisi.
//
//----------------------------------------------------------------------------------------------------
define('CURRENT_CFUNCTION', $function);

//----------------------------------------------------------------------------------------------------
// CURRENT_CPAGE
//----------------------------------------------------------------------------------------------------
//
// @return Aktif çalıştırılan sayfaya ait kontrolcü dosyasının ad bilgisini.
//
//----------------------------------------------------------------------------------------------------
define('CURRENT_CPAGE', $page.".php");

//----------------------------------------------------------------------------------------------------
// CURRENT_CONTROLLER
//----------------------------------------------------------------------------------------------------
//
// @return Aktif çalıştırılan sayfaya ait kontrolcü bilgisi.
//
//----------------------------------------------------------------------------------------------------
define('CURRENT_CONTROLLER', $page);

//----------------------------------------------------------------------------------------------------
// CURRENT_CPATH
//----------------------------------------------------------------------------------------------------
//
// @return Aktif çalıştırılan sayfaya ait kontrolcü ve fonksiyon yolu	bilgisi.
//
//----------------------------------------------------------------------------------------------------
define('CURRENT_CFPATH', str_replace(CONTROLLERS_DIR, '', CURRENT_CONTROLLER).'/'.CURRENT_CFUNCTION);

//----------------------------------------------------------------------------------------------------
// CURRENT_CFURI
//----------------------------------------------------------------------------------------------------
//
// @return Aktif çalıştırılan sayfaya ait kontrolcü ve fonksiyon yolu	bilgisi.
//
//----------------------------------------------------------------------------------------------------
define('CURRENT_CFURI', CURRENT_CFPATH);

//----------------------------------------------------------------------------------------------------
// CURRENT_CPATH
//----------------------------------------------------------------------------------------------------
//
// @return Aktif çalıştırılan sayfaya ait kontrolcü ve fonksiyon URL yol bilgisi.
//
//----------------------------------------------------------------------------------------------------
define('CURRENT_CFURL', siteUrl(CURRENT_CFPATH));

// TAMPONLAMA BAŞLATILIYOR...

if( Config::get('Cache','obGzhandler') && substr_count(server('acceptEncoding'), 'gzip') ) 
{
	ob_start('ob_gzhandler');
}
else
{
	ob_start();
}

// ----------------------------------------------------------------------

// BAŞLIK BİLGİLERİ DÜZENLENİYOR...

headers(Config::get('Headers', 'settings'));

// ----------------------------------------------------------------------

// SAYFA KONTROLÜ YAPILIYOR...
// -------------------------------------------------------------------------------
//  Sayfa bilgisine erişilmişse sayfa dahil edilir.
// -------------------------------------------------------------------------------
if( file_exists($isFile) )
{
	// -------------------------------------------------------------------------------
	//  Sayfa dahil ediliyor.
	// -------------------------------------------------------------------------------
	require_once $isFile;
		
	// -------------------------------------------------------------------------------
	// Sayfaya ait controller nesnesi oluşturuluyor.
	// -------------------------------------------------------------------------------
	if( class_exists($page, false) )
	{
		$var = new $page;
		
		// -------------------------------------------------------------------------------
		//  Varsayılan açılış Fonksiyonu. index ya da main kullanılabilir.
		// -------------------------------------------------------------------------------
		if( strtolower($function) === 'index' && ! is_callable(array($var, $function)) )
		{
			$function = 'main';	
		}	
		
		// -------------------------------------------------------------------------------
		// Sınıf ve yöntem bilgileri geçerli ise sayfayı çalıştır.
		// -------------------------------------------------------------------------------	
		if( is_callable(array($var, $function)) )
		{
			if( APP_TYPE === 'local' )
			{
				set_error_handler('Exceptions::table');	
			}
			
			call_user_func_array( array($var, $function), $parameters);
			
			if( APP_TYPE === 'local' )
			{
				restore_error_handler();
			}
		}
		else
		{
			// Sayfa bilgisine erişilemezse hata bildir.
			if( ! Config::get('Route', 'show404') )
			{		
				// Hatayı rapor et.
				report('Error', lang('Error', 'callUserFuncArrayError', $function), 'SystemCallUserFuncArrayError');	
					
				// Hatayı ekrana yazdır.
				die(Error::message('Error', 'callUserFuncArrayError', $function));
			}
			else
			{
				redirect(Config::get('Route', 'show404'));
			}
		}
	}
}
else
{	
	// Sayfa bilgisine erişilemezse hata bildir.
	if( Config::get('Route','show404') ) 
	{				
		redirect(Config::get('Route','show404'));		
	}
	else
	{
		// Hatayı rapor et.
		report('Error', lang('Error', 'notIsFileError', $isFile), 'SystemNotIsFileError');
		
		// Hatayı ekrana yazdır.
		die(Error::message('Error', 'notIsFileError', $isFile));
	}		
}

// ----------------------------------------------------------------------

// TAMPONLAMA KAPATILIYOR...

ob_end_flush();

// ----------------------------------------------------------------------