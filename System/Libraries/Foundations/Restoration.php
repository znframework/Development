<?php 
class Restoration
{
	//----------------------------------------------------------------------------------------------------
	//
	// Yazar      : Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	// Site       : www.zntr.net
	// Lisans     : The MIT License
	// Telif Hakkı: Copyright (c) 2012-2016, zntr.net
	//
	//----------------------------------------------------------------------------------------------------
	
	public static function mode()
	{
		if( isResmac() === true ) 
		{
			return false;
		}
		
		// Tamir moduna geçildiği durumnda tadilat makinesi olarak belirlenmeyen
		// diğer kullanıcı bilgisayarlarında herhangi bir hata ile karşı karşıya
		// kalmamaları için hata raporlama kapatılıyor.
		error_reporting(0); 
		
		global $system;
		// Config/Repair.php dosyasında tadilata alınacak sayfalar belirtilir.
		// Burada ayarlarda belirtilen sayfa isimleri bilgisi alınıyor.

		$repairPages  = $system['restorationPages'];
		$routePate	  = strtolower($system['restorationRoutePage']);
		$currentPath  = strtolower(currentPath()); 
		
		// Eğer Config/Repair.php dosyasında pages = "all" olarrak alınmış ise 
		// tüm sayfalar için tadilat modu uygulanıyor demektir.
		if( is_string($repairPages) )
		{
			if( $repairPages === "all" )
			{
				if( $currentPath !== $routePate ) 
				{
					redirect($system['routePage']);
				}
			}
		}
		
		
		// Sayfalar tek tek çağrılıyor..
		if( is_array($repairPages) && ! empty($repairPages) )
		{		
			// Eğer Config/Repair.php dosyasında pages = array("all") olarrak alınmış ise 
			// tüm sayfalar için tadilat modu uygulanıyor demektir.
			if( $repairPages[0] === "all" )
			{
				if( $currentPath !== $routePate ) 
				{
					redirect($system['restorationRoutePage']);
				}
			}
		
			foreach( $repairPages as $k => $rp )
			{
				// Yönlendirme sayfası bir anahtar-değer çifti içeriyorsa bu sayfaya yönlenmesi sağlanır
				if( strstr($currentPath, strtolower($k)) )
				{
					redirect($rp);	
				}
				else
				{
					// Eğer gelen sayfa o anki url içinde geçiyorsa yani sonuc -1 den büyükse 
					// yönlendirme sayfası olarak belirlene sayfaya yönlendir.
					if( strstr($currentPath, strtolower($rp)) )
					{
						if( $currentPath !== $routePate )
						{
							redirect($system['restorationRoutePage']);
						}
					}	
				}
			}
		}	
	}	
}