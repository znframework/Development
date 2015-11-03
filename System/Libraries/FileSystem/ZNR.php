<?php
class __USE_STATIC_ACCESS__ZNR 
{
	/***********************************************************************************/
	/* ZN RECORD LIBRARY	     					                   	               */
	/***********************************************************************************/
	/* Yazar: Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	/* Site: www.zntr.net
	/* Lisans: The MIT License
	/* Telif Hakkı: Copyright (c) 2012-2015, zntr.net
	/*
	/* Sınıf Adı: ZNR
	/* Versiyon: 2.0 Eylül Güncellemesi
	/* Tanımlanma: Dinamik
	/* Dahil Edilme: Gerektirmez
	/* Erişim: ZNR::, $this->ZNR, zn::$use->ZNR, uselib('ZNR')
	/* Not: Büyük-küçük harf duyarlılığı yoktur.
	/***********************************************************************************/
	
	/* ZN Record Dir Değişkeni
	 *  
	 * Kayıt dizin bilgisini
	 * tutması için oluşturulmuştur.
	 *
	 */
	protected $znrDir;
	
	/* Extension Değişkeni
	 *  
	 * Dosya uzantı bilgisini
	 * tutması için oluşturulmuştur.
	 *
	 */
	protected $extension = '.znr.php';
	
	/* Select Record Değişkeni
	 *  
	 * Seçili kayıtın bilgisini
	 * tutması için oluşturulmuştur.
	 *
	 */
	protected $selectRecord;
	
	/* Table Değişkeni
	 *  
	 * Kayıtların tutulacağı tablo adı bilgisini
	 * tutması için oluşturulmuştur.
	 *
	 */
	protected $table;
	
	/* Config Değişkeni
	 *  
	 * Kayıt ayar bilgilerini
	 * tutması için oluşturulmuştur.
	 *
	 */
	protected $config;
	
	/* Where Değişkeni
	 *  
	 * Hangi kaydın silineceği bilgisini
	 * tutması için oluşturulmuştur.
	 *
	 */
	protected $where;
	
	/* Secure Fix Değişkeni
	 *  
	 * Kayıt güvenliği eki bilgisini
	 * tutması için oluşturulmuştur.
	 *
	 */
	protected $secureFix = '<?php exit; ?>';
	
	/******************************************************************************************
	* CONSTRUCT                                                                           	  *
	*******************************************************************************************
	| Genel Kullanım: Nesnelere değerler atanıyor.			   							      |
	******************************************************************************************/	
	public function __construct()
	{
		// Ayarlar alınıyor...
		$this->config     = Config::get('Record');
		// Ana dizin belirleniyor...
		$this->znrDir     = STORAGE_DIR.'ZNRecords/';
		// Güvenlik eki olşturuluyor...
		$this->secureFix .= eol();
		
		$recordName = $this->config['record'];
		$recordDir  = $this->_recordName($recordName);
		
		// Config/Record.php dosyasıda yer alan
		// record parametresi ayarlanmışsa 
		// oluşturma ve seçme işlemini otomatik yap.
		if( ! empty($recordName) )
		{
			if( ! is_dir($recordDir) )
			{
				$this->createRecord($recordName);
			}
			
			if( is_dir($recordDir) )
			{
				$this->selectRecord($recordName);
			}
		}
	}
	
	/******************************************************************************************
	* CALL                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Geçersiz fonksiyon girildiğinde çağrılması için.						  |
	|          																				  |
	******************************************************************************************/
	public function __call($method = '', $param = '')
	{	
		die(getErrorMessage('Error', 'undefinedFunction', "ZNR::$method()"));	
	}
	
	/******************************************************************************************
	* CREATE RECORD                                                                       	  *
	*******************************************************************************************
	| Genel Kullanım: Yeni kayıt dizini oluşturuluyor.		   							      |
	******************************************************************************************/	
	public function createRecord($recordName = '')
	{
		if( ! is_string($recordName) || empty($recordName) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(recordName)'));
		}
		
		// ZNRecords/ ana dizini yoksa oluştur.
		if( ! is_dir($this->znrDir) )
		{
			Folder::create($this->znrDir, 0777, true);	
		}
		
		// Dahan nce bu dizinden yoksa oluştur.
		if( ! is_dir($this->znrDir.$recordName) )
		{
			Folder::create($this->znrDir.$recordName, 0777, true);
		}
		else
		{
			return Error::set(lang('File', 'alreadyFileError', $this->znrDir.$recordName));	
		}
	}
	
	/******************************************************************************************
	* SELECT RECORD                                                                       	  *
	*******************************************************************************************
	| Genel Kullanım: Kayıt dizini seçiliyor     			   							      |
	******************************************************************************************/	
	public function selectRecord($recordName = '')
	{
		if( ! is_string($recordName) || empty($recordName) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(recordName)'));
		}
		
		$this->selectRecord = $this->_recordName($recordName);
		
		// Belirtilen kayıt dizini yoksa NULL değeri atar.
		if( ! is_dir($this->selectRecord) )
		{
			Error::set(lang('Error', 'dirNotFound', $this->selectRecord));
			$this->selectRecord = NULL;
			
			return false;
		}
		
		return true;
	}
	
	/******************************************************************************************
	* CREATE TABLE                                                                         	  *
	*******************************************************************************************
	| Genel Kullanım: Tablo oluşturmak için kullanılıyor.								      |
	******************************************************************************************/	
	public function createTable($tableName = '')
	{
		if( ! is_string($tableName) || empty($tableName) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(tableName)'));
		}
		
		if( empty($this->selectRecord) )
		{
			return Error::set(lang('Error', 'emptyVariable', '@this->selectRecord'));
		}
		
		$tableName = $this->_tableName($tableName);
		
		// Daha önce aynı tablodan oluşturulmamışsa oluşturur.
		if( ! is_file($tableName) )
		{
			return File::create($tableName);	
		}
		else
		{
			return Error::set(lang('File', 'alreadyFileError', $tableName));	
		}
	}
	
	/******************************************************************************************
	* TABLE                                                                              	  *
	*******************************************************************************************
	| Genel Kullanım: Tablo seçmek için kullanılıyor.		   							      |
	******************************************************************************************/	
	public function table($table = '')
	{
		if( ! is_string($table) || empty($table) )
		{
			Error::set(lang('Error', 'stringParameter', '1.(table)'));
			return $this;
		}
	
		$this->table = $this->_tableName($table);
		
		// Böyle bir tablo yoksa hata mesajı oluşturur.
		if( ! is_file($this->table) )
		{
			Error::set(lang('Error', 'fileNotFound', $table));	
		}
		
		return $this;
	}
	
	/******************************************************************************************
	* WHERE                                                                              	  *
	*******************************************************************************************
	| Genel Kullanım: Silinecek veri id'sini belirtmek için kullanılır.					      |
	******************************************************************************************/	
	public function where($where = 0)
	{
		if( ! is_numeric($where) || empty($where) )
		{
			Error::set(lang('Error', 'numericParameter', '1.(where)'));
			
			return $this;
		}
		
		$this->where = $where;
		
		return $this;
	}
	
	/******************************************************************************************
	* SELECT / GET                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Veri seçmek için kullanılır.			   							      |
	******************************************************************************************/	
	public function select($table = '', $where = 0)
	{
		if( ! is_string($table) )
		{
			Error::set(lang('Error', 'stringParameter', '1.(table)'));
			return $this;
		}
		
		if( ! is_numeric($where) )
		{
			Error::set(lang('Error', 'numericParameter', '2.(where)'));
			return $this;
		}
		
		$this->get($table, $where);
		
		return $this;
	}
	
	/******************************************************************************************
	* GET / SELECT                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Veri seçmek için kullanılır.			   							      |
	******************************************************************************************/	
	public function get($table = '', $where = 0)
	{
		if( ! empty($this->table) )
		{
			$where = $table; 
			$table = $this->table;	
			$this->table = NULL;
		}
		else
		{
			$table = $this->_tableName($table);	
		}
		
		if( ! empty($where) )
		{
			$this->where = $where;	
		}
		
		if( ! is_string($table) )
		{
			Error::set(lang('Error', 'stringParameter', '1.(table)'));
			return $this;
		}
		
		if( ! is_file($table) )
		{
			Error::set(lang('Error', 'fileNotFound', $table));	
			return $this;
		}
		
		if( ! is_numeric($where) )
		{
			Error::set(lang('Error', 'numericParameter', '2.(where)'));
			return $this;
		}
		
		// İçerik alınıyor ve sonuçlar değişkenlere aktarılıyor.
		$content 		   = file_get_contents($table);
		$this->result      = $this->_secureDecodeData($content);
		$this->resultArray = $this->_secureDecodeData($content, true);
		
		return $this;
	}
	
	/******************************************************************************************
	* ROW                                                                                	  *
	*******************************************************************************************
	| Genel Kullanım: Tek bir kayıdı seçmek için kullanılır	   							      |
	******************************************************************************************/	
	public function row($where = 'first')
	{
		if( ! empty($this->where) )
		{
			$where = $this->where;	
			$this->where = NULL;
		}
		
		if( ! isValue($where) )
		{
			return Error::set(lang('Error', 'valueParameter', '1.(where)'));
		}
		
		if( $where === 'first' )
		{
			$return = $this->resultArray[1];	
		}
		elseif( $where === 'last' )
		{
			$return = end($this->resultArray);
		}
		else
		{
			$return  = $this->resultArray[$where];	
		}
		
		// tek bir satır veri üretiliyor.
		return (object)$return;
	}
	
	/******************************************************************************************
	* RESULT                                                                             	  *
	*******************************************************************************************
	| Genel Kullanım: Object veri türünde sonuçları listeler. 							      |
	******************************************************************************************/	
	public function result()
	{
		if( ! empty($this->where) )
		{
			$r = $this->where;
			$this->where = NULL;
			$result = $this->result->$r;
			$this->result = $result;
		}
		
		return $this->result;	
	}
	
	/******************************************************************************************
	* RESULT ARRAY                                                                        	  *
	*******************************************************************************************
	| Genel Kullanım: Array veri türünde sonuçları listeler.  							      |
	******************************************************************************************/	
	public function resultArray()
	{
		if( ! empty($this->where) )
		{
			$resultArray = $this->resultArray[$this->where];
			$this->where = NULL;
			$this->resultArray = $resultArray;
		}
	
		return $this->resultArray;	
	}
	
	/******************************************************************************************
	* INSERT                                                                             	  *
	*******************************************************************************************
	| Genel Kullanım: Kayıt eklemek için kullanılır.			   							      |
	******************************************************************************************/	
	public function insert($table = '', $data = array())
	{
		if( ! empty($this->table) )
		{
			$data  = $table;
			$table = $this->table;	
			$this->table = NULL;
		}
		else
		{
			$table = $this->_tableName($table);	
		}
		
		if( ! is_string($table) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(table)'));
		}
		
		if( ! is_file($table) )
		{
			return Error::set(lang('Error', 'fileNotFound', '1.(table)'));
		}
		
		$oldData = $this->_secureDecodeData(file_get_contents($table), true);
		
		// Daha önce kayıt oluşturulmuşsa.
		if( is_array($oldData) )
		{
			end($oldData);
			
		  	$key  = key($oldData);
		  	$key += 1;
			
			$oldData[$key] = $data;
		}
		else
		{
			// Daha önce kayıt oluşturulmamışsa.
      		$oldData = array(1 => $data);
		}
		
		if( ! is_file($table) )
		{
			return Error::set(lang('Error', 'fileNotFound', '1.(table)'));	
		}
		
		file_put_contents($table, $this->_secureEncodeData($oldData));
	}
	
	/******************************************************************************************
	* UPDATE                                                                              	  *
	*******************************************************************************************
	| Genel Kullanım: Kayıtları güncellemek için kullanılmaktadır.   					      |
	******************************************************************************************/	
	public function update($table = '', $data = array(), $where = 0)
	{
		// Parametreler kaydırılıyor...
		if( ! empty($this->table) )
		{
			$where = $data; 
			$data  = $table;
			$table = $this->table;
			$this->table = NULL;	
		}
		else
		{
			$table = $this->_tableName($table);	
		}
		
		if( ! empty($this->where) )
		{
			$where = $this->where;	
		}
		
		if( ! is_string($table) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(table)'));
		}
		
		if( ! is_file($table) )
		{
			return Error::set(lang('Error', 'fileNotFound', '1.(table)'));
		}
		
		if( empty($where) )
		{
			return Error::set(lang('Error', 'emptyParameter', '3.(where)'));	
		}
		
		$oldData = $this->_secureDecodeData(file_get_contents($table), true);
		
		// Eğer belirtilen kayıt varsa güncelleniyor...
		if( isset($oldData[$where]) )
		{
			$oldData[$where] = $data;
			file_put_contents($table, $this->_secureEncodeData($oldData));
		}
	}
	
	/******************************************************************************************
	* DELETE                                                                             	  *
	*******************************************************************************************
	| Genel Kullanım: Kayıt silmek için kullanılır.			   							      |
	******************************************************************************************/	
	public function delete($table = '', $where = 0)
	{
		if( ! empty($this->table) )
		{
			$where = $table; 
			$table = $this->table;	
			$this->table = NULL;
		}
		else
		{
			$table = $this->_tableName($table);	
		}
		
		if( ! empty($this->where) )
		{
			$where = $this->where;	
		}
		
		if( ! is_string($table) )
		{
			return Error::set(lang('Error', 'stringParameter', '1.(table)'));
		}
		
		if( ! is_file($table) )
		{
			return Error::set(lang('Error', 'fileNotFound', '1.(table)'));
		}
		
		if( ! is_numeric($where) )
		{
			return Error::set(lang('Error', 'numericParameter', '2.(where)'));
		}

		$oldData = $this->_secureDecodeData(file_get_contents($table), true);
		
		if( isset($oldData[$where]) )
		{
			unset($oldData[$where]);
		}
		else
		{
			if( empty($where) )
			{
				$oldData = array();	
			}
		}
		
		file_put_contents($table, $this->_secureEncodeData($oldData));
	}
	
	/******************************************************************************************
	* PRIVATE SECURE ENCODE DATA                                                          	  *
	*******************************************************************************************
	| Genel Kullanım: Json veri türüne çevirir.			   			     				      |
	******************************************************************************************/	
	private function _secureEncodeData($data)
	{
		return $this->secureFix.json_encode($data);
	}
	
	/******************************************************************************************
	* PRIVATE SECURE DECODE DATA                                                          	  *
	*******************************************************************************************
	| Genel Kullanım: Json veri türünü dizi türüne çevirir.   							      |
	******************************************************************************************/	
	private function _secureDecodeData($data, $array = false)
	{
		$data = str_replace($this->secureFix, '', $data);
		
		return json_decode($data, $array);	
	}

	/******************************************************************************************
	* PRIVATE TABLE NAME                                                                  	  *
	*******************************************************************************************
	| Genel Kullanım: Tablo yolunu oluşturmak için kullanılır. 							      |
	******************************************************************************************/	
	private function _tableName($tableName)
	{	
		return $this->selectRecord.$tableName.$this->extension;
	}
	
	/******************************************************************************************
	* PRIVATE RECORD NAME                                                                 	  *
	*******************************************************************************************
	| Genel Kullanım: Kayıt yolunu oluşturmak için kullanılır.							      |
	******************************************************************************************/	
	private function _recordName($recordName)
	{
		return $this->znrDir.suffix($recordName);
	}
}