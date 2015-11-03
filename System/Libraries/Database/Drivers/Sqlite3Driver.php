<?php
class Sqlite3Driver
{
	/***********************************************************************************/
	/* SQLITE 3 DRIVER LIBRARY					                   	                   */
	/***********************************************************************************/
	/* Yazar: Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	/* Site: www.zntr.net
	/* Lisans: The MIT License
	/* Telif Hakkı: Copyright (c) 2012-2015, zntr.net
	/*
	/* Sınıf Adı: Sqlite3Driver
	/* Versiyon: 1.2
	/* Tanımlanma: Dinamik
	/* Dahil Edilme: Gerektirmez
	/* Erişim: Database kütüphanesi tarafından kullanılmaktadır.
	/* Not: Büyük-küçük harf duyarlılığı yoktur.
	/***********************************************************************************/
	
	/* Config Değişkeni
	 *  
	 * Veritabanı ayarlar bilgisini
	 * tutmak için oluşturulmuştur.
	 *
	 */
	private $config;
	
	/* Connect Değişkeni
	 *  
	 * Veritabanı bağlantı bilgisini
	 * tutmak için oluşturulmuştur.
	 *
	 */
	private $connect;
	
	/* Query Değişkeni
	 *  
	 * Veritabanı sorgu bilgisini
	 * tutmak için oluşturulmuştur.
	 *
	 */
	private $query;
	
	/* Operators Değişkeni
	 *  
	 * Farklı platformlardaki operator farklılıklar bilgisi
	 * tutmak için oluşturulmuştur.
	 *
	 */
	public $operators = array
	(
		'like' => '%'
	);
	 
	protected function cvartype($type = '', $len = '')
	{
	 	if( $len === '' )
		{
			return " $type ";	
		}
		else
		{
			return " $type($len) ";	
		}
	}
	
	public function autoIncrement()
	{
		return ' AUTOINCREMENT  ';
	}
	
	public function primaryKey($col = '')
	{
		return $this->cvartype('PRIMARY KEY', $col);
	}
	
	public function foreignKey($col = '')
	{
		return $this->cvartype('FOREIGN KEY', $col);
	}
	
	public function unique($col = '')
	{
		return $this->cvartype('UNIQUE', $col);
	}
	
	public function null($type = true)
	{
		return $type === true ? ' NULL ' : ' NOT NULL ';
	}
	
	public function notNull()
	{
		return ' NOT NULL ';
	}
	
	// NUMERICAL
	public function int($len = '')
	{
		return $this->cvartype('INTEGER', $len);
	}
	
	public function smallInt($len = '')
	{
		return $this->cvartype('SMALLINT', $len);
	}
	
	public function tinyInt($len = '')
	{
		return $this->cvartype('TINYINT', $len);
	}
	
	public function mediumInt($len = '')
	{
		return $this->cvartype('MEDIUMINT', $len);
	}
	
	public function bigInt($len = '')
	{
		return $this->cvartype('BIGINT', $len);
	}
	
	public function decimal($len = '')
	{
		return $this->cvartype('DECIMAL', $len);
	}
	
	public function double($len = '')
	{
		return $this->cvartype('DOUBLE', $len);
	}
	
	public function float($len = '')
	{
		return $this->cvartype('FLOAT', $len);
	}
	
	// STRING
	public function char($len = '')
	{
		return $this->cvartype('CHARACTER', $len);
	}
	
	public function varChar($len = '')
	{
		return $this->cvartype('VARCHAR', $len);
	}
	
	// max.255 karakter
	public function tinyText()
	{
		return $this->cvartype('VARCHAR(255)');
	}
	
	// max. 65535 karakter 
	public function text()
	{
		return $this->cvartype('TEXT');
	}
	
	// max. 16777215 karakter 
	public function mediumText()
	{
		return $this->cvartype('CLOB');
	}
	
	// max. 4294967295 karakter
	public function longText()
	{
		return $this->cvartype('BLOB');
	}
	
	// DATETIME
	// yyyy-mm-dd
	public function date($len = '')
	{
		return $this->cvartype('DATE', $len);
	}
	
	// yyyy-mm-dd hh:mm:ss
	public function datetime($len = '')
	{
		return $this->cvartype('DATETIME', $len);
	}
	
	// hh:mm:ss
	public function time($len = '')
	{
		return $this->cvartype('DATE', $len);
	}
	
	// yyyymmddhhmmss
	public function timeStamp($len = '')
	{
		return $this->cvartype('DATETIME', $len);
	}
	
	// ENUM ENUMERATED listesinin kisaltılmış halidir. () içinde 65535 değer tutabilir
	public function enum()
	{
		return false;
	}
	
	// ENUM ENUMERATED listesinin kisaltılmış halidir. () içinde 65535 değer tutabilir
	public function set()
	{
		return false;
	}
	
	/******************************************************************************************
	* CONNECT                                                                                 *
	*******************************************************************************************
	| Genel Kullanım: Nesne tanımlaması ve veritabanı ayarları çalıştırılıyor.				  |
	|          																				  |
	******************************************************************************************/
	public function connect($config = array())
	{
		$this->config = $config;
		
		try
		{
			$this->connect = 	( ! empty($this->config['password']) )
							 	? new SQLite3($this->config['database'], SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE, $this->config['password'])
							  	: new SQLite3($this->config['database']);
		}	
		catch(Exception $e)
		{
			die(getErrorMessage('Database', 'mysqlConnectError'));
		}
	}	
	
	/******************************************************************************************
	* EXEC                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Veritabanı sürücülerindeki exec yönteminin kullanımıdır.  			  |
	|          																				  |
	******************************************************************************************/
	public function exec($query)
	{
		return $this->connect->exec($query);
	}
	
	/******************************************************************************************
	* QUERY                                                                                   *
	*******************************************************************************************
	| Genel Kullanım: Veritabanı sürücülerindeki query yönteminin kullanımıdır.  			  |
	|          																				  |
	******************************************************************************************/	
	public function query($query, $security = array())
	{
		$this->query = $this->connect->query($query);
		return $this->query;
	}
	
	/******************************************************************************************
	* TRANS START                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Veritabanı sürücülerindeki begin transaction özelliğinin kullanımıdır.  |		
	|          																				  |
	******************************************************************************************/
	public function transStart()
	{
		return $this->connect->exec('BEGIN TRANSACTION');
	}
	
	/******************************************************************************************
	* TRANS ROLLBACK                                                                          *
	*******************************************************************************************
	| Genel Kullanım: Veritabanı sürücülerindeki rollback özelliğinin kullanımıdır.  	  	  |
	|          																				  |
	******************************************************************************************/
	public function transRollback()
	{
		return $this->connect->exec('ROLLBACK');		 
	}
	
	/******************************************************************************************
	* TRANS COMMIT                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Veritabanı sürücülerindeki commit özelliğinin kullanımıdır.        	  |
	|          																				  |
	******************************************************************************************/
	public function transCommit()
	{
		return $this->connect->exec('END TRANSACTION');
	}
	
	/******************************************************************************************
	* LIST DATABASES                                                                          *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü için bu yöntem desteklenmemektedir.                 		  | 
	|          																				  |
	******************************************************************************************/
	public function listDatabases()
	{
		// Ön tanımlı sorgu kullanıyor.
		return false;
	}
	
	/******************************************************************************************
	* LIST TABLES                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü için bu yöntem desteklenmemektedir.                 		  | 
	|          																				  |
	******************************************************************************************/
	public function listTables()
	{
		// Ön tanımlı sorgu kullanıyor.
		return false;
	}
	
	/******************************************************************************************
	* INSERT ID                                                                               *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü için insert id kullanımıdır.                 		          |
	|          																				  |
	******************************************************************************************/
	public function insertId()
	{
		return $this->connect->lastInsertRowID();
	}
	
	/******************************************************************************************
	* COLUMN DATA                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Db sınıfında kullanımı için oluşturulmuş yöntemdir.                	  | 
	|          																				  |
	******************************************************************************************/
	public function columnData()
	{
		if( empty($this->query) ) 
		{
			return false;
		}
		
		static $data_types = array
		(
			SQLITE3_INTEGER	=> 'integer',
			SQLITE3_FLOAT	=> 'float',
			SQLITE3_TEXT	=> 'text',
			SQLITE3_BLOB	=> 'blob',
			SQLITE3_NULL	=> 'null'
		);
		
		$columns = array();
		
		for ($i = 0, $c = $this->num_fields(); $i < $c; $i++)
		{	
			$type 					= $this->query->columnType($i);
			
			$columns[$i]			= new stdClass();
			$columns[$i]->name		= $this->result_id->columnName($i);		
			$columns[$i]->type		= isset($data_types[$type]) ? $data_types[$type] : $type;
			$columns[$i]->maxLength	= NULL;
		}
		
		return $columns;
	}
	
	/******************************************************************************************
	* BACKUP                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü bu yöntemi desteklememektedir.                				  | 
	|          																				  |
	******************************************************************************************/
	public function backup($filename = '')
	{ 
		// Ön tanımlı sorgu kullanıyor.
		return false; 
	}
	
	/******************************************************************************************
	* TRUNCATE                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Db sınıfında kullanımı için oluşturulmuş truncate yöntemidir.           | 
	|          																				  |
	******************************************************************************************/		
	public function truncate($table = '')
	{ 
		return 'DELETE FROM '.$table; 
	}
	
	/******************************************************************************************
	* ADD COLUMN                                                                              *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü bu yöntemi desteklememektedir.                				  | 
	|          																				  |
	******************************************************************************************/
	public function addColumn()
	{
		// Ön tanımlı sorgu kullanıyor.
		return false; 
	}
	
	/******************************************************************************************
	* DROP COLUMN                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü bu yöntemi desteklememektedir.                				  | 
	|          																				  |
	******************************************************************************************/
	public function dropColumn()
	{ 
		// Ön tanımlı sorgu kullanıyor.
		return false; 
	}
	
	/******************************************************************************************
	* RENAME COLUMN                                                                           *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü bu yöntemi desteklememektedir. 				  				  | 
	|          																				  |
	******************************************************************************************/
	public function renameColumn()
	{
		// Ön tanımlı sorgu kullanıyor.
		return false; 
	}
	
	/******************************************************************************************
	* MODIFY COLUMN                                                                           *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü bu yöntemi desteklememektedir.			    				  | 
	|          																				  |
	******************************************************************************************/
	public function modifyColumn()
	{ 
		// Ön tanımlı sorgu kullanıyor.
		return false; 
	}
	
	/******************************************************************************************
	* NUM ROWS                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü için toplam kayıt sayısı bilgisini verir.                	  | 
	|          																				  |
	******************************************************************************************/
	public function numRows()
	{
		if( empty($this->result) ) 
		{
			return false;
		}
		
		return count($this->result());
	}
	
	/******************************************************************************************
	* COLUMNS                                                                                 *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü için sütun özellikleri bilgisini verir.                	      | 
	|          																				  |
	******************************************************************************************/
	public function columns()
	{
		if( empty($this->query) ) 
		{
			return false;
		}
		
		$columns = array();		
		$num_fields = $this->numFields();
		
		for($i=0; $i < $num_fields; $i++)
		{		
			$columns[] = $this->query->columnName($i);
		}
		
		return $columns;
	}
	
	/******************************************************************************************
	* NUM FIEDLS                                                                              *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü için toplam sütun sayısı bilgisini verir.                	  | 
	|          																				  |
	******************************************************************************************/
	public function numFields()
	{
		if( ! empty($this->query) )
		{
			return $this->query->numColumns();
		}
		else
		{
			return 0;
		}
	}
	
	/******************************************************************************************
	* RESULT                                                                                  *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü için sorgu sonucu kayıtlar bilgisini verir.                	  | 
	|          																				  |
	******************************************************************************************/
	public function result()
	{
		if( empty($this->query) ) 
		{
			return false;
		}
		
		$rows = array();
		
		while($data = $this->query->fetchArray(SQLITE3_ASSOC))
		{
			$rows[] = (object)$data;
		}
		
		return $rows;
	}
	
	/******************************************************************************************
	* RESULT ARRAY                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü için sorgu sonucu kayıtlar bilgisini dizi olarak verir.       | 
	|          																				  |
	******************************************************************************************/
	public function resultArray()
	{
		if( empty($this->query) ) 
		{
			return false;
		}
		
		$rows = array();
		
		while($data = $this->query->fetchArray(SQLITE3_ASSOC))
		{
			$rows[] = $data;
		}
		
		return $rows;
	
	}
	
	/******************************************************************************************
	* ROW                                                                                     *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü için sorgu sonucu tek bir kayıt bilgisini verir.              | 
	|          																				  |
	******************************************************************************************/
	public function row()
	{
		if( empty($this->query) ) 
		{
			return false;
		}
		
		$data = $this->query->fetchArray(SQLITE3_ASSOC);
		
		return (object)$data;
	}
	
	/******************************************************************************************
	* REAL STRING ESCAPE                                                                      *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü için real_escape_string yönteminin kullanımıdır.			  | 
	|          																				  |
	******************************************************************************************/
	public function realEscapeString($data = '')
	{
		if( empty($this->connect) ) 
		{
			return false;
		}
		
		return $this->connect->escapeString($data);
	}
	
	/******************************************************************************************
	* ERROR                                                                      			  *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü için hata bilgisini verir. 			              			  | 
	|          																				  |
	******************************************************************************************/
	public function error()
	{
		if( ! empty($this->connect) )
		{
			return $this->connect->lastErrorMsg();
		}
		else
		{
			return false;
		}
	}
	
	/******************************************************************************************
	* FETCH ARRAY                                                                 			  *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü için fetch_array yönteminin kullanımıdır. 		              | 
	|          																				  |
	******************************************************************************************/
	public function fetchArray()
	{
		if( ! empty($this->query) )
		{
			return $this->query->fetchArray(SQLITE3_BOTH);
		}
		else
		{
			return false;	
		}
	}
	
	/******************************************************************************************
	* FETCH ASSOC                                                                  			  *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü için fetch_array yönteminin kullanımıdır. 		              | 
	|          																				  |
	******************************************************************************************/
	public function fetchAssoc()
	{
		if( ! empty($this->query) )
		{
			return $this->query->fetchArray(SQLITE3_ASSOC);
		}
		else
		{
			return false;	
		}
	}
	
	/******************************************************************************************
	* FETCH ROW                                                                  			  *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü için fetch_row yönteminin kullanımıdır. 		              | 
	|          																				  |
	******************************************************************************************/
	public function fetchRow()
	{
		if( ! empty($this->query) )
		{
			return $this->query->fetchArray();
		}
		else
		{
			return 0;	
		}
	}
	
	/******************************************************************************************
	* AFFECTED ROWS                                                                 		  *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü için bu yöntem desteklenmemektedir. 		         		  | 
	|          																				  |
	******************************************************************************************/
	public function affectedRows()
	{
		if( ! empty($this->connect) )
		{
			return  $this->connect->changes();
		}
		else
		{
			return false;	
		}
	}
	
	/******************************************************************************************
	* CLOSE                                                                         		  *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü için close yönteminin kullanımıdır. 		                  | 
	|          																				  |
	******************************************************************************************/
	public function close()
	{
		if( ! empty($this->connect) ) 
		{
			@$this->connect->close(); 
		}
		else 
		{
			return false;
		}
	}
	
	/******************************************************************************************
	* VERSION                                                                         		  *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü için version yönteminin kullanımıdır. 		                  | 
	|          																				  |
	******************************************************************************************/
	public function version($v = 'versionString')
	{
		if( ! empty($this->connect) )
		{
			$version = SQLite3::version();
			
			return $version[$v];
		}
		else
		{
			return false;
		}
	}
}