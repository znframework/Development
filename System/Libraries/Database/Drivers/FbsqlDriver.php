<?php
class FbsqlDriver
{
	/***********************************************************************************/
	/* FBSQL DRIVER LIBRARY	     				                   	                   */
	/***********************************************************************************/
	/* Yazar: Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	/* Site: www.zntr.net
	/* Lisans: The MIT License
	/* Telif Hakkı: Copyright (c) 2012-2015, zntr.net
	/*
	/* Sınıf Adı: FbsqlDriver
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
		return ' AUTO_INCREMENT ';
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
		return $this->cvartype('INT', $len);
	}
	
	public function smallInt($len = '')
	{
		return $this->cvartype('SMALLINT', $len);
	}
	
	public function tinyInt($len = '')
	{
		return $this->cvartype('SMALLINT', $len);
	}
	
	public function mediumInt($len = '')
	{
		return $this->cvartype('INT', $len);
	}
	
	public function bigInt($len = '')
	{
		return $this->cvartype('INT', $len);
	}
	
	public function decimal($len = '')
	{
		return $this->cvartype('DECIMAL', $len);
	}
	
	public function double($len = '')
	{
		return $this->cvartype('DOUBLE PRECISION', $len);
	}
	
	public function float($len = '')
	{
		return $this->cvartype('FLOAT', $len);
	}
	
	// STRING
	public function char($len = '')
	{
		return $this->cvartype('CHAR', $len);
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
		return $this->cvartype('VARCHAR(65535)');
	}
	
	// max. 16777215 karakter 
	public function mediumText()
	{
		return $this->cvartype('VARCHAR(16277215)');
	}
	
	// max. 4294967295 karakter
	public function longText()
	{
		return $this->cvartype('CLOB');
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
		return $this->cvartype('TIMESTAMP', $len);
	}
	
	// hh:mm:ss
	public function time($len = '')
	{
		return $this->cvartype('TIME', $len);
	}
	
	// yyyymmddhhmmss
	public function timeStamp($len = '')
	{
		return $this->cvartype('TIMESTAMP', $len);
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
		$this->config  = $config;
	    $this->connect = ( $this->config['pconnect'] === true )
						 ? @fbsql_pconnect($this->config['host'], $this->config['user'], $this->config['password'])
						 : @fbsql_connect($this->config['host'], $this->config['user'], $this->config['password']);
		
		if( empty($this->connect) ) 
		{
			die(getErrorMessage('Database', 'mysqlConnectError'));
		}
		
		fbsql_select_db($this->config['database'], $this->connect);
	}
	
	/******************************************************************************************
	* EXEC                                                                                    *
	*******************************************************************************************
	| Genel Kullanım: Veritabanı sürücülerindeki exec yönteminin kullanımıdır.  			  |
	|          																				  |
	******************************************************************************************/
	public function exec($query)
	{
		return fbsql_query($this->connect, $query);
	}
	
	/******************************************************************************************
	* QUERY                                                                                   *
	*******************************************************************************************
	| Genel Kullanım: Veritabanı sürücülerindeki query yönteminin kullanımıdır.  			  |
	|          																				  |
	******************************************************************************************/
	public function query($query, $security = array())
	{
		$this->query = fbsql_query($query, $this->connect);
		return $this->query;
	}
	
	/******************************************************************************************
	* TRANS START                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Veritabanı sürücülerindeki autocommit özelliğinin kullanımıdır.  		  |
	|          																				  |
	******************************************************************************************/
	public function transStart()
	{
		if( fbsql_autocommit($this->connect) )
		{
			fbsql_autocommit($this->connect, false);
		}
		
		return true;	
	}
	
	/******************************************************************************************
	* TRANS ROLLBACK                                                                          *
	*******************************************************************************************
	| Genel Kullanım: Veritabanı sürücülerindeki rollback özelliğinin kullanımıdır.  		  |
	|          																				  |
	******************************************************************************************/
	public function transRollback()
	{
		fbsql_rollback($this->connect);
		
		if ( ! fbsql_autocommit($this->connect) )
		{
			fbsql_autocommit($this->connect, true);
		}
		
		return true;
	}
	
	/******************************************************************************************
	* TRANS COMMIT                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Veritabanı sürücülerindeki autocommits özelliğinin kullanımıdır.        |
	|          																				  |
	******************************************************************************************/
	public function transCommit()
	{
		fbsql_commit($this->connect);
		
		if ( ! fbsql_autocommit($this->connect) )
		{
			fbsql_autocommit($this->connect, true);
		}
		
		return true;
	}
	
	/******************************************************************************************
	* LIST DATABASES                                                                          *
	*******************************************************************************************
	| Genel Kullanım: DbTool sınıfında kullanımı için oluşturulmuş yöntemdir.                 | 
	|          																				  |
	******************************************************************************************/
	public function listDatabases()
	{
		if( ! empty($this->connect) )
		{
			return fbsql_list_dbs($this->connect);
		}
		else
		{
			return false;
		}
	}
	
	/******************************************************************************************
	* LIST TABLES                                                                             *
	*******************************************************************************************
	| Genel Kullanım: DbTool sınıfında kullanımı için oluşturulmuş yöntemdir.                 | 
	|          																				  |
	******************************************************************************************/
	public function listTables()
	{
		if( ! empty($this->connect) )
		{
			return fbsql_list_tables($this->config['database'], $this->connect);
		}
		else
		{
			return false;
		}
	}
	
	/******************************************************************************************
	* INSERT ID                                                                               *
	*******************************************************************************************
	| Genel Kullanım: Db sınıfında kullanımı için oluşturulmuş yöntemdir.                	  | 
	|          																				  |
	******************************************************************************************/
	public function insertId()
	{
		if( ! empty($this->connect) )
		{
			return fbsql_insert_id($this->connect);
		}
		else
		{
			return false;
		}
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
		
		$columns = array();
		
		for ($i = 0, $c = $this->num_fields(); $i < $c; $i++)
		{
			$columns[$i]				= new stdClass();
			$columns[$i]->name			= fbsql_field_name($this->query, $i);
			$columns[$i]->type			= fbsql_field_type($this->query, $i);
			$columns[$i]->maxLength		= fbsql_field_len($this->query, $i);
			$columns[$i]->primaryKey	= (int) (strpos(fbsql_field_flags($this->query, $i), 'primary_key') !== false);
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
	| Genel Kullanım: Bu sürücü bu yöntemi desteklememektedir.                				  | 
	|          																				  |
	******************************************************************************************/
	public function truncate($table = '')
	{ 
		// Ön tanımlı sorgu kullanıyor.
		return false; 
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
	| Genel Kullanım: Bu sürücü için rename column yönteminin kullanımıdır.   				  | 
	|          																				  |
	******************************************************************************************/
	public function renameColumn()
	{ 
		return 'RENAME COLUMN ';
	}
	
	/******************************************************************************************
	* MODIFY COLUMN                                                                           *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü bu yöntemi desteklememektedir.                				  | 
	|          																				  |
	******************************************************************************************/
	public function modifyColumn()
	{ 
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
		if( ! empty($this->query) )
		{
			return fbsql_num_rows($this->query);
		}
		else
		{
			return 0;	
		}
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
			$columns[] = fbsql_field_name($this->query, $i);
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
			return fbsql_num_fields($this->query);
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
		
		while($data = fbsql_fetch_assoc($this->query))
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
		
		while($data = fbsql_fetch_assoc($this->query))
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
		
		$data = fbsql_fetch_assoc($this->query);
		
		return (object)$data;
	}
	
	/******************************************************************************************
	* REAL STRING ESCAPE                                                                      *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü için bu kullanım desteklenmediği için. aşağıdaki yöntemden	  |
	| yararlanılmıştır.												 			              | 
	|          																				  |
	******************************************************************************************/
	public function realEscapeString($data = '')
	{
		return Security::escapeStringEncode($data);
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
			return fbsql_error($this->connect);
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
			return fbsql_fetch_array($this->query);
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
			return fbsql_fetch_assoc($this->query);
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
			return fbsql_fetch_row($this->query);
		}
		else
		{
			return 0;	
		}
	}
	
	/******************************************************************************************
	* AFFECTED ROWS                                                                 		  *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü için affected_rows yönteminin kullanımıdır. 		          | 
	|          																				  |
	******************************************************************************************/
	public function affectedRows()
	{
		if( ! empty($this->connect) )
		{
			return fbsql_affected_rows($this->connect);
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
			@fbsql_close($this->connect); 
		}
		else 
		{
			return false;
		}
	}	
	
	/******************************************************************************************
	* VERSION                                                                         		  *
	*******************************************************************************************
	| Genel Kullanım: Bu sürücü için bu kullanım desteklenmemektedir. 		                  | 
	|          																				  |
	******************************************************************************************/
	public function version()
	{	
		// Ön tanımlı sorgu kullanıyor.
		if( ! empty($this->connect) ) 
		{
			return false;
		}
	}
}