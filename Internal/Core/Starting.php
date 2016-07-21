<?php
//----------------------------------------------------------------------------------------------------
// SİSTEM BAŞLATILIRKEN 
//----------------------------------------------------------------------------------------------------
//
// Author     : Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
// Site       : www.znframework.com
// License    : The MIT License
// Copyright  : Copyright (c) 2012-2016, ZN Framework
//
//----------------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------------
// Ob Start
//----------------------------------------------------------------------------------------------------
//
// Tampon başlatılıyor.
//
//----------------------------------------------------------------------------------------------------
if( Config::get('Cache','obGzhandler') && substr_count(server('acceptEncoding'), 'gzip') ) 
{
	ob_start('ob_gzhandler');
}
else
{
	ob_start();
}
//-----------------------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------------------------
// Headers
//-----------------------------------------------------------------------------------------------------
//
// Başlık bilgileri düzenleniyor.
//
//-----------------------------------------------------------------------------------------------------
headers(Config::get('Headers', 'settings'));

//-----------------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------------
// Set Error Handler
//----------------------------------------------------------------------------------------------------
//
// Yakanalan hata set ediliyor.
//
//----------------------------------------------------------------------------------------------------
if( APPMODE !== 'publication' )
{
	set_error_handler('Exceptions::table');
}
//----------------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------------
// INI Ayarlarını Yapılandırma İşlemi
//----------------------------------------------------------------------------------------------------
$iniSet = Config::get('Htaccess', 'ini')['settings'];

if( ! empty($iniSet) ) 
{
	Config::iniSet($iniSet);
}
//----------------------------------------------------------------------------------------------------
		
//----------------------------------------------------------------------------------------------------
// Htaccess Dosyası Oluşturma İşlemi
//----------------------------------------------------------------------------------------------------	
if( Config::get('Htaccess','createFile') === true ) 
{
	_createHtaccessFile();
}	
//----------------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------------
// Robots Dosyası Oluşturma İşlemi
//----------------------------------------------------------------------------------------------------	
if( Config::get('Robots','createFile') === true ) 
{
	_createRobotsFile();
}	
//----------------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------------
// Composer Autoload İşlemi
//----------------------------------------------------------------------------------------------------
$composer = Config::get('Composer', 'autoload');

if( $composer === true )
{
	//------------------------------------------------------------------------------------------------
	// Varsayılan Yol: vendor/autoload.php
	//------------------------------------------------------------------------------------------------
	$path = 'vendor/autoload.php';
	
	if( file_exists($path) )
	{
		require_once($path);
	}
	else
	{
		report('Error', lang('Error', 'fileNotFound', $path) ,'AutoloadComposer');
		
		die(Errors::message('Error', 'fileNotFound', $path));
	}
}
elseif( is_file($composer) )
{
	require_once($composer);
}
elseif( ! empty($composer) )
{
	report('Error', lang('Error', 'fileNotFound', $composer) ,'AutoloadComposer');
	
	die(Errors::message('Error', 'fileNotFound', $composer));
}
//----------------------------------------------------------------------------------------------------	