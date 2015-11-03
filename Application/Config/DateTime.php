<?php
/************************************************************/
/*                        DATETIME                          */
/************************************************************/
/*

Yazar: Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
Site: http://www.zntr.net
Copyright 2012-2015 zntr.net - Tüm hakları saklıdır.

/******************************************************************************************
* DATETIME                                                                         	  	  *
*******************************************************************************************
| Genel Kullanım: Tarih saat ile ilgili ayarları yapmak için kullanılır.      			  |
******************************************************************************************/

/******************************************************************************************
* TIMEZONE                                                                         	  	  *
*******************************************************************************************
| Genel Kullanım: Saatlerde kaymama olmaması için bölge seçimi yapılmıştır.				  |
| Bulunduğunu bölgeye göre ayarlayabilirsiniz.											  | 
| Varsayılan olarak Europe/Istanbul seçilmiştir.      									  |	
******************************************************************************************/
$config['DateTime']['timeZone'] = 'Europe/Istanbul';

/******************************************************************************************
* SETLOCALE                                                                         	  *
*******************************************************************************************
| Genel Kullanım: Türkçe içerikli karakterleri desteklemesi amacıyla kullanılır.   		  |	
| setDate() yöntemi haric diğer yöntemler için kullanılır.							      |					
******************************************************************************************/
$config['DateTime']['setLocale'] = array(

	'charset'  => 'tr_TR.UTF-8',
	'language' => 'turkish',	
);

/******************************************************************************************
* SET TIME FORMAT CHARS                                                                   *
*******************************************************************************************
| Genel Kullanım: setTime() yöntemi için oluşturulmuş özel kullanımlar yerine			  |
| aşağıda anahtar olarak belirlenmiş ifadelerde kullanılabilir.							  |
| Örnek: %a yerine {short_day} ifadesi kullanılabilir.									  |
| ' | ' ifadesi ile ayrılmış anahtar değerler alternatif olarak 						  |
| kullanılabilirler.																	  |
| Örnek: {short_day_name} , {short_day} ya da {sd} kullanılabilir						  |
| hepsini karşılığı %a özel ifadesidir.						      						  |					
******************************************************************************************/
$config['DateTime']['setTimeFormatChars'] = array
(
	'{shortDayName}|{shortDay}|{SD}' 							=> '%a',
	'{dayName}|{day}|{D}' 										=> '%A',
	'{dayNumber0}|{dayNum0}|{DN0}' 								=> '%d',
	'{dayNumber}|{dayNum}|{DN}' 								=> '%e',
	'{yearDayNumber0}|{yearDayNum0}|{YDN}' 						=> '%j',	
	'{isoWeekDayNumber}|{isoWeekDayNum}|{IWDN}' 				=> '%u',
	'{weekDayNumber}|{weekDayNum}|{WDN}'						=> '%w',
	'{weekNumber}|{weekNum}|{WN}' 								=> '%U',
	'{startingMondayYearWeekNumber}|{smYearWeekNum}|{SMYWN}'	=> '%W',
	'{shortMonthName}|{shortMonth}|{SM}' 						=> '%b',
	'{monthName}|{month}|{mon}' 								=> '%B',
	'{monthNumber}|{monNum}|{MN}' 								=> '%m',	
	'{century}|{cen}' 											=> '%C',
	'{shortYear}|{SY}'			 								=> '%y',
	'{year}|{Y}' 												=> '%Y',
	'{hour024}|{H024}' 											=> '%H',
	'{hour24}|{H24}' 											=> '%k',
	'{hour012}|{H012}' 											=> '%I',
	'{hour12}|{H12}' 											=> '%l',	
	'{minute0}|{minute}|{min}|{min0}' 							=> '%M',
	'{AMPM}|{AM}'												=> '%p',
	'{ampm}|{am}' 												=> '%P',
	'{second}|{second0}|{sec}|{sec0}' 							=> '%S',
	'{clock}' 													=> '%X',	
	'{dateTime}' 												=> '%c',
	'{date}' 													=> '%x'
);


/******************************************************************************************
* SET DATE FORMAT CHARS                                                                   *
*******************************************************************************************
| Genel Kullanım: setDate() yöntemi için oluşturulmuş özel kullanımlar yerine			  |
| aşağıda anahtar olarak belirlenmiş ifadelerde kullanılabilir.							  |
| Örnek: D yerine {short_day} ifadesi kullanılabilir.									  |
| ' | ' ifadesi ile ayrılmış anahtar değerler alternatif olarak 						  |
| kullanılabilirler.																	  |
| Örnek: {short_day_name} , {short_day} ya da {sd} kullanılabilir						  |
| hepsini karşılığı D özel ifadesidir.						      						  |					
******************************************************************************************/
$config['DateTime']['setDateFormatChars'] = array
(
	'{shortDayName}|{shortDay}|{SD}' 							=> 'D',
	'{dayName}|{day}|{D}' 										=> 'l',
	'{dayNumber0}|{dayNum0}|{DN0}' 								=> 'd',
	'{dayNumber}|{dayNum}|{DN}' 								=> 'j',
	'{totalDays}|{TD}' 											=> 't',
	'{yearDayNumber0}|{yearDayNumber}|{yearDayNum0}|{yearDayNum}|{YDN0}|{YDN}' => 'z',	
	'{weekDayNumber}|{weekDayNum}|{WDN}' 						=> 'N',
	'{weekDayNumber0}|{weekDayNum0}|{WDN0}' 					=> 'w',
	'{weekNumber}|{weekNum}|{WN}' 								=> 'W',	
	'{shortMonthName}|{sortMonth}|{SM}' 						=> 'M',
	'{monthName}|{month}|{mon}' 								=> 'F',
	'{monthNumber0}|{monNum0}|{MN0}' 							=> 'm',	
	'{monthNumber}|{monNum}|{MN}' 								=> 'n',	
	'{shortYear}|{SY}' 											=> 'y',	
	'{year}|{Y}' 												=> 'o',
	'{currentYear}|{CY}' 										=> 'Y',
	'{yearNumber}|{yearNum}|{YN}' 								=> 'L',
	'{hour024}|{H024}' 											=> 'H',
	'{hour24}|{H24}' 											=> 'G',
	'{hour012}|{H012}' 											=> 'h',
	'{hour12}|{H12}' 											=> 'g',
	'{minute0}|{minute}|{min}|{min0}' 							=> 'i',
	'{AMPM}|{AM}' 												=> 'A',
	'{ampm}|{am}' 												=> 'a',
	'{second}|{second0}|{sec}|{sec0}' 							=> 's',
	'{microSecond}|{micSec}|{MS}'					 			=> 'u',
	'{internetConnectionTime}|{inConTime}|{ICT}' 				=> 'B',																						
	'{iso}|{ISO}' 												=> 'c',
	'{rfc}|{RFC}' 												=> 'r',
	'{unix}|{UNIX}' 											=> 'U'																										
);