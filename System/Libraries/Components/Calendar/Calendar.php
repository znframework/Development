<?php
class __USE_STATIC_ACCESS__Calendar implements CalendarInterface
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
	// Css
	//----------------------------------------------------------------------------------------------------
	//
	// Css sınıf bilgisi
	//
	// @var  array
	//
	//----------------------------------------------------------------------------------------------------
	protected $css;
	
	//----------------------------------------------------------------------------------------------------
	// Style
	//----------------------------------------------------------------------------------------------------
	//
	// Stil sınıf bilgisi
	//
	// @var  array
	//
	//----------------------------------------------------------------------------------------------------
	protected $style;
	
	//----------------------------------------------------------------------------------------------------
	// Month Names
	//----------------------------------------------------------------------------------------------------
	//
	// Ay isimleri bilgisi
	//
	// @var  string
	//
	//----------------------------------------------------------------------------------------------------
	protected $monthNames = 'long';
	
	//----------------------------------------------------------------------------------------------------
	// Day Names
	//----------------------------------------------------------------------------------------------------
	//
	// Gün isimleri bilgisi
	//
	// @var  string
	//
	//----------------------------------------------------------------------------------------------------
	protected $dayNames = 'short';
	
	//----------------------------------------------------------------------------------------------------
	// Prev
	//----------------------------------------------------------------------------------------------------
	//
	// Önceki link bilgisi
	//
	// @var  string
	//
	//----------------------------------------------------------------------------------------------------
	protected $prev = '<<';
	
	//----------------------------------------------------------------------------------------------------
	// Next
	//----------------------------------------------------------------------------------------------------
	//
	// Sonraki link bilgisi
	//
	// @var  string
	//
	//----------------------------------------------------------------------------------------------------
	protected $next = '>>';
	
	//----------------------------------------------------------------------------------------------------
	// Url
	//----------------------------------------------------------------------------------------------------
	//
	// Bağlantı sağlanacak url bilgisi
	//
	// @var  string
	//
	//----------------------------------------------------------------------------------------------------
	protected $url;
	
	//----------------------------------------------------------------------------------------------------
	// Config
	//----------------------------------------------------------------------------------------------------
	//
	// Ayarlar bilgisi
	//
	// @var  string
	//
	//----------------------------------------------------------------------------------------------------
	protected $config;
	
	//----------------------------------------------------------------------------------------------------
	// Construct
	//----------------------------------------------------------------------------------------------------
	// 
	// @param  void
	// @return bool
	//
	//----------------------------------------------------------------------------------------------------
	public function __construct()
	{
		$this->config = Config::get('Calendar');
	}
	
	//----------------------------------------------------------------------------------------------------
	// Call Method
	//----------------------------------------------------------------------------------------------------
	// 
	// __call()
	//
	//----------------------------------------------------------------------------------------------------
	use CallUndefinedMethodTrait;
	
	//----------------------------------------------------------------------------------------------------
	// Error Control
	//----------------------------------------------------------------------------------------------------
	// 
	// $error
	// $success
	//
	// error()
	// success()
	//
	//----------------------------------------------------------------------------------------------------
	use ErrorControlTrait;

	//----------------------------------------------------------------------------------------------------
	// Designer Methods Başlangıç
	//----------------------------------------------------------------------------------------------------

	//----------------------------------------------------------------------------------------------------
	// Url
	//----------------------------------------------------------------------------------------------------
	// 
	// Takvimin bağlantı kurucağı url adresi.
	// 
	// @param  string $url
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function url($url = '')
	{
		if( ! isUrl($url) )
		{
			$url = siteUrl($url);	
		}
		
		$this->url = $url;
		
		return $this;
	}
	
	//----------------------------------------------------------------------------------------------------
	// Name Type
	//----------------------------------------------------------------------------------------------------
	// 
	// Ay ve günler için normal isimlerini mi yoksa kısaltılmış isimlerin mi	
	// kullanılacağını belirlemek için kullanılır.
	// 
	// @param  string $day
	// @param  string $month
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function nameType($day = 'short', $month = 'long')
	{
		if( ! is_string($day) || ! is_string($month) )	
		{
			Error::set('Error', 'stringParameter', 'day | month');
			return $this;	
		}
		
		$this->dayNames   = $day;	

		$this->monthNames = $month;	
	
		return $this;
	}
	
	//----------------------------------------------------------------------------------------------------
	// Css
	//----------------------------------------------------------------------------------------------------
	// 
	// Takvime css sınıfları uygulamak için kullanılır.
	// 
	// @param  array $css
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function css($css = array())
	{
		if( ! is_array($css) )
		{
			Error::set('Error', 'arrayParameter', 'css');
			return $this;	
		}
		
		$this->css = $css;
		
		return $this;
	}
	
	//----------------------------------------------------------------------------------------------------
	// Style
	//----------------------------------------------------------------------------------------------------
	// 
	// Takvime stiller uygulamak için kullanılır.
	// 
	// @param  array $style
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function style($style = array())
	{
		if( ! is_array($style) )
		{
			Error::set('Error', 'arrayParameter', 'style');
			return $this;	
		}
		
		$this->style = $style;
		
		return $this;
	}
	
	//----------------------------------------------------------------------------------------------------
	// Link Name
	//----------------------------------------------------------------------------------------------------
	// 
	// Takvimde yer alan iler ve geri butonu linklerinin isimlerini			 
	// değiştirmek için kulanılır.
	// 
	// @param  string $prev
	// @param  string $next
	// @return this
	//
	//----------------------------------------------------------------------------------------------------
	public function linkName($prev = '<<', $next = '>>')
	{
		if( ! ( is_string($prev) && is_string($next) ) )	
		{
			Error::set('Error', 'stringParameter', 'prev | next');
			return $this;	
		}
		
		if( ! empty($prev) )
		{
			$this->prev = $prev;
		}
		
		if( ! empty($next) )
		{
			$this->next = $next;
		}
		
		return $this;
	}
	
	//----------------------------------------------------------------------------------------------------
	// Designer Methods Bitiş
	//----------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------
	// Create Method Başlangıç
	//----------------------------------------------------------------------------------------------------

	//----------------------------------------------------------------------------------------------------
	// Create
	//----------------------------------------------------------------------------------------------------
	// 
	// Takvimin oluşturulması için kullanılan son yöntemdir.
	// 
	// @param  numeric $year
	// @param  numeric $month
	// @return string
	//
	//----------------------------------------------------------------------------------------------------
	public function create($year = NULL, $month = NULL)
	{	
		// Gün, ay ve yıl bilgilerini alınıyor.
		$today = getdate();
		
		if( ! isset($this->url) )
		{
			$this->url = suffix(CURRENT_CFURL);		
		}
		
		// Eğer parametreler boş ise
		// Varsayılan olarak URL adresinin
		// Son iki segmentini kullan
		// Son segment ay bilgisini
		// Sondan bir önceki segmen 
		// yıl bilgisini tutmaktadır.
		if( $month === NULL && $year === NULL ) 
		{
			if( ! is_numeric(Uri::segment(-1)) )
			{ 
				$month = $today['mon']; 
			}
			else
			{ 
				$month = Uri::segment(-1);
			}
			
			if( ! is_numeric(Uri::segment(-2)) )
			{ 
				$year = $today['year']; 
			}
			else
			{ 
				$year = Uri::segment(-2);
			}
		}
		else 
		{
			if( ! is_numeric($month) ) 
			{
				$month = $today['mon'];
			}			
			if( ! is_numeric($year) ) 
			{
				$year = $today['year'];
			}	
		}
		
		// Ay 0 değerine ulaştığında
		if( $month < 1 )
		{
			$month = 12;
			$year--;	
		}
		// Ay 13 değerine ulaştığında
		elseif( $month > 12 )
		{
			$month = 1;
			$year++;	
		}
		
		// Ay ismini sitenin aktif
		// diline göre ayarlar. 
		
		
		if( $this->monthNames === 'long' )
		{
			$monthNames = array_keys($this->config['monthNames'][getLang()]);
		}
		else
		{
			$monthNames = array_values($this->config['monthNames'][getLang()]);
		}
		
		$monthName = $monthNames[$month - 1];
		// Gün ismini sitenin aktif
		// diline göre ayarlar.
		$dayNames  = ( $this->dayNames === 'long' )
					 ? array_keys($this->config['dayNames'][getLang()])
					 : array_values($this->config['dayNames'][getLang()]);
		
		// Belirtilen ayarlamara göre tarih bilgisi elde ediliyor.
		$firstDay = getdate( mktime(0, 0, 0, $month, 1, $year) );
		$lastDay  = getdate( mktime(0, 0, 0, $month + 1, 0, $year));
		
		// TABLO İÇİN CSS
		$tableClass = ( isset($this->css['table']) )
					  ? ' class="'.$this->css['table'].'"'
					  : '';
		// TABLO İÇİN STYLE	
		$tableStyle = ( isset($this->style['table']) )
					  ? ' style="'.$this->style['table'].'"'
					  : '';
		// AY VE TARİH SÜTUNU İÇİN	CSS	   
		$monthRowClass = ( isset($this->css['monthName']) )
					     ? ' class="'.$this->css['monthName'].'"'
					     : '';
		// AY VE TARİH SÜTUNU İÇİN	STYLE			
		$monthRowStyle = ( isset($this->style['monthName']) )
					     ? ' style="'.$this->style['monthName'].'"'
					     : '';
		// GÜN SÜTUNU İÇİN	CSS	
		$dayRowClass = ( isset($this->css['dayName']) )
					   ? ' class="'.$this->css['dayName'].'"'
					   : '';
		// GÜN SÜTUNU İÇİN	STYLE			
		$dayRowStyle = ( isset($this->style['dayName']) )
					   ? ' style="'.$this->style['dayName'].'"'
					   : '';
		// GÜN SAYILARI SÜTUNLARI İÇİN	CSS	
		$rowsClass = ( isset($this->css['days']) )
					 ? ' class="'.$this->css['days'].'"'
					 : '';
		// GÜN SAYILARI SÜTUNLARI İÇİN	STYLE			
		$rowsStyle = ( isset($this->style['days']) )
					 ? ' style="'.$this->style['days'].'"'
					 : '';
		// ÖNCEKİ VE SONRAKİ LİNKLERİ İÇİN	CSS					 
		$buttonClass = ( isset($this->css['links']) )
					   ? ' class="'.$this->css['links'].'"'
					   : '';
		// ÖNCEKİ VE SONRAKİ LİNKLERİ İÇİN	STYLE		
		$buttonStyle = ( isset($this->style['links']) )
					   ? ' style="'.$this->style['links'].'"'
					   : '';
		
		$eol  = eol();
		
		// Önceki linki oluşturuluyor.
		$prev = "<a href='". suffix($this->url) . $year. "/". ( $month - 1 ) ."' {$buttonClass}{$buttonStyle}>$this->prev</a>";
		// Sonraki linki oluşturuluyor.
		$next = "<a href='". suffix($this->url) . $year. "/". ( $month + 1 ) ."' {$buttonClass}{$buttonStyle}>$this->next</a>";
			 
		$str  = "<table{$tableClass}{$tableStyle}>".$eol;
		// Ay - Tarih Satırı
		$str .= "\t<tr>".$eol."\t\t<th{$monthRowClass}{$monthRowStyle} colspan=\"7\">{$prev} {$monthName} - {$year} {$next}</th></tr>".$eol;
		$str .= "\t<tr>".$eol;
		
		// Gün İsimleri Satırı
		foreach( $dayNames as $day )
		{
			$str .= "\t\t<td{$dayRowClass}{$dayRowStyle}>$day</td>".$eol;
		}
		
		$str .= "\t<tr>".$eol;
		
		if( $firstDay['wday'] == 0 ) 
		{
			$firstDay['wday'] = 7;
		}
		
		// Günler Satırı
		for( $i=1; $i<$firstDay['wday']; $i++ )
		{
			$str .= "\t\t<td{$rowsClass}{$rowsStyle}>&nbsp;</td>".$eol;
		}
		
		$activeDay = 0;
		
		for( $i = $firstDay['wday']; $i<=7; $i++ )
		{
			$activeDay++;
			
			// Aktif gün için stil ve css kullanımı.
			if( $activeDay == $today['mday'] ) 
			{
				$class = ( isset($this->css['current']) )
						 ? ' class="'.$this->css['current'].'"'
						 : '';
				
				$style = ( isset($this->style['current']) )
						 ? ' style="'.$this->style['current'].'"'
						 : '';
			} 
			else 
			{
				$class = ( isset($this->css['days']) )
						 ? ' class="'.$this->css['days'].'"'
						 : '';
				
				$style = ( isset($this->style['days']) )
						 ? ' style="'.$this->style['days'].'"'
						 : '';
			}
			
			$str .= "\t\t<td{$class}{$style}>$activeDay</td>".$eol;
		}
		
		$str .= "\t</tr>".$eol;
		
		$weekCount = floor(($lastDay ['mday'] - $activeDay) / 7);
		
		for( $i = 0; $i < $weekCount; $i++ )
		{
			$str .= "\t<tr>";
			
			for( $j = 0; $j < 7; $j++ )
			{
				$activeDay++;
				// Aktif gün için stil ve css kullanımı.
				if ( $activeDay == $today['mday'] ) 
				{
					$class = ( isset($this->css['current']) )
							 ? ' class="'.$this->css['current'].'"'
							 : '';
				
					$style = ( isset($this->style['current']) )
							 ? ' style="'.$this->style['current'].'"'
							 : '';
				} 
				else 
				{
					$class = ( isset($this->css['days']) )
							 ? ' class="'.$this->css['days'].'"'
							 : '';
				
					$style = ( isset($this->style['days']) )
							 ? ' style="'.$this->style['days'].'"'
							 : '';
				}
				
				$str .= "\t\t<td{$class}{$style}>$activeDay</td>".$eol;
			}
			
			$str .= "\t</tr>".$eol;
		}
		
	
		if( $activeDay < $lastDay['mday'] )
		{
			$str .= "\t<tr>".$eol;
			
			for( $i = 0; $i < 7; $i++ )
			{
				$activeDay++;
				// Aktif gün için stil ve css kullanımı.
				if( $activeDay == $today['mday'] ) 
				{
					$class = ( isset($this->css['current']) )
							 ? ' class="'.$this->css['current'].'"'
							 : '';
				
					$style = ( isset($this->style['current']) )
							 ? ' style="'.$this->style['current'].'"'
							 : '';
				} 
				else 
				{
					$class = ( isset($this->css['days']) )
							 ? ' class="'.$this->css['days'].'"'
							 : '';
				
					$style = ( isset($this->style['days']) )
							 ? ' style="'.$this->style['days'].'"'
							 : '';
				}
				
				if( $activeDay <= $lastDay ['mday'] )
				{
					$str .= "\t\t<td{$class}{$style}>$activeDay</td>".$eol;
				}
				else 
				{
					$str .= "\t\t<td{$class}{$style}>&nbsp;</td>".$eol;
				}
			}			
			$str .= "\t</tr>".$eol;
		}
		
		$str .= "</table>";
		
		$this->_defaultVariables();
		
		return $str;
	}
	
	//----------------------------------------------------------------------------------------------------
	// Create Method Bitiş
	//----------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------
	// Create
	//----------------------------------------------------------------------------------------------------
	// 
	// Takvim değikenleri sıfılanıyor.
	// 
	// @param  void
	// @return void
	//
	//----------------------------------------------------------------------------------------------------
	protected function _defaultVariables()
	{
		$this->css 			= NULL;
		$this->style 		= NULL;
		$this->monthNames 	= NULL;
		$this->dayNames 	= NULL;
		$this->url 			= NULL;
		$this->config 		= NULL;
		$this->prev 		= '<<';
		$this->next 		= '>>';	
	}
}