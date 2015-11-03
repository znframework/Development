<?php
/************************************************************/
/*                             INI                          */
/************************************************************/
/*

Yazar: Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
Site: http://www.zntr.net
Copyright 2012-2015 zntr.net - Tüm hakları saklıdır.

/******************************************************************************************
* INI                                                                            		  *
*******************************************************************************************
| Genel Kullanım: php ini dosyası ile ilgili ayarları yapabilmek için kullanılır.	      |
******************************************************************************************/

/******************************************************************************************
* SET HTACCESS FILE                                                                       *
*******************************************************************************************
| Genel Kullanım: ini_set() yöntemiyle yapamadığınız ayarlamaları buradan yapabilirsiniz. |
| .htaccess dosyasında ini ayarları yapılabilsin mi?   									  |
******************************************************************************************/
$config['Ini']['setHtaccessFile'] = false;

/******************************************************************************************
* SETTINGS                                                                                *
*******************************************************************************************
| Genel Kullanım: .htaccess üzerinden hangi ini ayarlarını yapacaksanız onları 			  |
| yazıyorsunuz. Anahtar kelime => değeri												  |
| Örnek: upload_max_filesize => "10M" 						      						  |
******************************************************************************************/
$config['Ini']['settings'] = array();