<?php
class __USE_STATIC_ACCESS__DBForge implements DBForgeInterface, DatabaseInterface
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
	// Common
	//----------------------------------------------------------------------------------------------------
	// 
	// $config
	// $prefix
	// $secure
	// $table
	// $tableName
	// $stringQuery
	// $unlimitedStringQuery
	//
	// run()
	// table()
	// stringQuery()
	// differentConnection()
	// secure()
	// error()
	// close()
	// version()
	//
	//----------------------------------------------------------------------------------------------------
	use DatabaseTrait;
	
	//----------------------------------------------------------------------------------------------------
	// Database Manipulation Methods Başlangıç
	//----------------------------------------------------------------------------------------------------
	
	/******************************************************************************************
	* CREATE DATABASE                                                                         *
	*******************************************************************************************
	| Genel Kullanım: Sorgu işlemlerinde CREATE DATABASE kullanımı için oluşturulmuştur.	  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @dbname => Oluşturulacak veritabanı ismi.                                 |
	|          																				  |
	| Örnek Kullanım: $this->dbforge->createDatabase('OrnekVeritabani')        			  	  |
	|          																				  |
	******************************************************************************************/
	public function createDatabase($dbname = '')
	{
		if( ! is_string($dbname) || empty($dbname) ) 
		{
			return Error::set('Error', 'stringParameter', 'dbname');
		}

		$query  = 'CREATE DATABASE '.$dbname;	
		
		return $this->db->exec($this->_querySecurity($query), $this->secure);
	}
	
	/******************************************************************************************
	* DROP DATABASE                                                                           *
	*******************************************************************************************
	| Genel Kullanım: Sorgu işlemlerinde DROP DATABASE kullanımı için oluşturulmuştur.	      |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @dbname => Kaldırılacak veritabanı ismi.                                  |
	|          																				  |
	| Örnek Kullanım: $this->dbforge->dropDatabase('OrnekVeritabani')        			      |
	|          																				  |
	******************************************************************************************/
	public function dropDatabase($dbname = '')
	{
		if( ! is_string($dbname) || empty($dbname) ) 
		{
			return Error::set('Error', 'stringParameter', 'dbname');
		}
		
		$query  = 'DROP DATABASE '.$dbname;	
		
		return $this->db->exec($this->_querySecurity($query), $this->secure);
	}
	
	//----------------------------------------------------------------------------------------------------
	// Database Manipulation Methods Başlangıç
	//----------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------
	// Table Manipulation Methods Başlangıç
	//----------------------------------------------------------------------------------------------------
	
	/******************************************************************************************
	* CREATE TABLE                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Sorgu işlemlerinde CREATE TABLE kullanımı için oluşturulmuştur.	      |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @table => Oluşturulacak tablo ismi.                                  	  |
	| 2. array var @condition => Sütun isimler ve özellikleri bilgisini içerir.               |
	|          																				  |
	| Örnek Kullanım: $this->dbforge->createTable('OrnekTablo', array('id' => 'int(11)'));   |
	|          																				  |
	******************************************************************************************/
	public function createTable($table = '', $condition = array())
	{
		if( ! empty($this->table) ) 
		{
			// Table yöntemi tanımlanmış ise
			// 1. parametre, 2. parametre olarak kullanılsın
			$condition = $table;
			$table = $this->table; 
			$this->table = NULL;
		}
		else
		{
			$table = $this->prefix.$table;	
		}
		
		if( ! empty($this->column) )
		{
			$condition = $this->column;
			$this->column = NULL;
		}
		
		if( ! is_string($table) || empty($table) ) 
		{
			return Error::set('Error', 'stringParameter', 'table');
		}
		
		if( ! is_array($condition) || empty($condition) ) 
		{
			return Error::set('Error', 'arrayParameter', 'condition');
		}
		
		$keys = array_keys($condition);
		
		$column = "";
		

		foreach( $condition as $key => $value )
		{
			$values = "";
			
			if( is_array($value) ) foreach( $value as $val )
			{
				$values .= ' '.$val;
			}
			else
			{
				$values = $value;	
			}
			
			$column .= $key.' '.$values.',';
		}

		$query  = 'CREATE TABLE '.$table.'('.rtrim(trim($column), ',').')';
	
		return $this->db->exec($this->_querySecurity($query), $this->secure);
	}
	
	/******************************************************************************************
	* DROP TABLE                                                                              *
	*******************************************************************************************
	| Genel Kullanım: Sorgu işlemlerinde DROP TABLE kullanımı için oluşturulmuştur.	          |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @table => Kaldırılacak tablo ismi.                                  	  |
	|          																				  |
	| Örnek Kullanım: $this->dbforge->dropTable('OrnekTablo');   							  |
	|          																				  |
	******************************************************************************************/
	public function dropTable($table = '')
	{
		if( ! empty($this->table) ) 
		{
			// Table yöntemi tanımlanmış ise
			// 1. parametre, 2. parametre olarak kullanılsın
			$table = $this->table; 
			$this->table = NULL;
		}
		else
		{
			$table = $this->prefix.$table;	
		}
		
		if( ! is_string($table) || empty($table) ) 
		{
			return Error::set('Error', 'stringParameter', 'table');
		}
		
		$query  = 'DROP TABLE '.$table;
		
		return $this->db->exec($this->_querySecurity($query), $this->secure);
	}
	
	/******************************************************************************************
	* ALTER TABLE                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Sorgu işlemlerinde ALTER TABLE kullanımı için oluşturulmuştur.	      |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @table => Düzenlenecek tablo ismi.                                  	  |
	| 2. array var @condition => Sütun isimler ve özellikleri bilgisini içerir.               |
	|          																				  |
	| Örnek Kullanım: $this->dbforge->alterTable('OrnekTablo', array('işlemler'));   		  |
	|          																				  |
	| >>>>>>>>>>>>>>>>>>>>>>>>>>>Detaylı kullanım için zntr.net<<<<<<<<<<<<<<<<<<<<<<<<<<  	  |
	|          																				  |
	******************************************************************************************/
	public function alterTable($table = '', $condition = array())
	{
		if( ! empty($this->table) ) 
		{
			// Table yöntemi tanımlanmış ise
			// 1. parametre, 2. parametre olarak kullanılsın
			$condition = $table;
			$table = $this->table; 
			$this->table = NULL;
		}
		else
		{
			$table = $this->prefix.$table;	
		}
		
		if( key($condition) === 'renameTable' ) 			
		{
			return $this->renameTable($table, $condition['renameTable']);
		}
		elseif( key($condition) === 'addColumn' ) 		
		{
			return $this->addColumn($table, $condition['addColumn']);
		}
		elseif( key($condition) === 'dropColumn' ) 		
		{
			return $this->dropColumn($table, $condition['dropColumn']);	
		}
		elseif( key($condition) === 'modifyColumn' ) 	
		{
			return $this->modifyColumn($table, $condition['modifyColumn']);
		}
		elseif( key($condition) === 'renameColumn' ) 	
		{
			return $this->renameColumn($table, $condition['renameColumn']);
		}
	}
	
	/******************************************************************************************
	* RENAME TABLE                                                                            *
	*******************************************************************************************
	| Genel Kullanım: Sorgu işlemlerinde ALTER TABLE kullanımına alternatif olarak kullanılır.|
	| daha basit bir şekilde tablo ismini değiştirmek için kullanılır.               	      |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @name => Eski tablo ismi.                                  	  		      |
	| 1. string var @new_name => Yeni tablo ismi.                                  	  		  |
	|          																				  |
	| Örnek Kullanım: $this->dbforge->renameTable('OrnekTablo', 'YeniTablo');   		      |
	|          																				  |
	******************************************************************************************/	
	public function renameTable($name = '', $newName = '')
	{
		if( ! empty($this->table) ) 
		{
			// Table yöntemi tanımlanmış ise
			// 1. parametre, 2. parametre olarak kullanılsın
			$newName = $name;
			$name = $this->table; 
			$this->table = NULL;
		}
		else
		{
			$name = $this->prefix.$name;	
		}
		
		if( ! is_string($name) || empty($name) ) 
		{
			return Error::set('Error', 'stringParameter', 'name');
		}
		
		if( ! is_string($newName) || empty($newName) ) 
		{
			return Error::set('Error', 'stringParameter', 'newName');
		}
		
		$query  = 'ALTER TABLE '.$name.' RENAME TO '.$this->prefix.$newName;
		
		return $this->db->exec($this->_querySecurity($query), $this->secure);
	}
	
	/******************************************************************************************
	* TRUNCATE                                                                                *
	*******************************************************************************************
	| Genel Kullanım: Sorgu işlemlerinde TRUNCATE kullanımı için oluşturulmuştur.			  |
	|															                              |
	| Parametreler: Tek parametresi vardır.                                                   |
	| 1. string var @table => İçi boşaltılacak tablo ismi.                                    |
	|          																				  |
	| Örnek Kullanım: $this->dbforge->truncate('OrnekTablo');       						  |
	|          																				  |
	| >>>>>>>>>>>>>>>>>>>>>>>>>>>Detaylı kullanım için zntr.net<<<<<<<<<<<<<<<<<<<<<<<<<<  	  |
	|          																				  |
	******************************************************************************************/
	public function truncate($table = '')
	{
		if( ! empty($this->table) ) 
		{
			// Table yöntemi tanımlanmış ise
			// 1. parametre, 2. parametre olarak kullanılsın
			$table = $this->table; 
			$this->table = NULL;
		}
		else
		{
			$table = $this->prefix.$table;	
		}
		
		if( ! is_string($table) || empty($table) ) 
		{
			return Error::set('Error', 'stringParameter', 'table');
		}
		
		$truncate = $this->db->truncate() !== false
				  ? $this->db->truncate()
				  : 'TRUNCATE TABLE ';
		
		$query  = $truncate.$table;
		
		return $this->db->exec($this->_querySecurity($query), $this->secure);
	}
	
	//----------------------------------------------------------------------------------------------------
	// Table Manipulation Methods Bitiş
	//----------------------------------------------------------------------------------------------------
	
	//----------------------------------------------------------------------------------------------------
	// Column Manipulation Methods Başlangıç
	//----------------------------------------------------------------------------------------------------

	/******************************************************************************************
	* ADD COLUMN                                                                              *
	*******************************************************************************************
	| Genel Kullanım: Sorgu işlemlerinde ALTER TABLE kullanımına alternatif olarak kullanılır.|
	| daha basit bir şekilde sütun eklemek için kullanılır.               	                  |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @table => Sütun eklenecek tablo ismi.                                     |
	| 1. array var @condition => Sütun ismi ve özellikleri.                                   |
	|          																				  |
	| Örnek Kullanım: $this->dbforge->addColumn('OrnekTablo', array('sütun işlemleri'));     |
	|          																				  |
	| >>>>>>>>>>>>>>>>>>>>>>>>>>>Detaylı kullanım için zntr.net<<<<<<<<<<<<<<<<<<<<<<<<<<  	  |
	|          																				  |
	******************************************************************************************/	
	public function addColumn($table = '', $condition = array())
	{
		if( ! empty($this->table) ) 
		{
			// Table yöntemi tanımlanmış ise
			// 1. parametre, 2. parametre olarak kullanılsın
			$condition = $table;
			$table = $this->table; 
			$this->table = NULL;
		}
		else
		{
			$table = $this->prefix.$table;	
		}
		
		if( ! empty($this->column) )
		{
			$condition = $this->column;
			$this->column = NULL;
		}
		
		if( ! is_string($table) || empty($table) ) 
		{
			return Error::set('Error', 'stringParameter', 'table');
		}
		
		if( ! is_array($condition) || empty($condition) ) 
		{
			return Error::set('Error', 'arrayParameter', 'condition');
		}
		
		$addColumn = $this->db->addColumn() !== false
				   ? $this->db->addColumn()
			       : 'ADD ';
				   
		$con = NULL;
		
		foreach( $condition as $column => $values )
		{
			$colvals = '';
			
			if( is_array($values) )
			{	
				foreach( $values as $val )
				{
					$colvals .= ' '.$val;
				}
			}
			else
			{
				$colvals .= ' '.$values;
			}
			
			$con .= $addColumn.$column.$colvals.',';
		}		
			
		$con = substr($con, 0 , -1);
		
		$query  = 'ALTER TABLE '.$table.' '.$con.';';
		
		return $this->db->exec($this->_querySecurity($query), $this->secure);
	}
	
	/******************************************************************************************
	* DROP COLUMN                                                                             *
	*******************************************************************************************
	| Genel Kullanım: Sorgu işlemlerinde ALTER TABLE kullanımına alternatif olarak kullanılır.|
	| daha basit bir şekilde sütun kaldırmak için kullanılır.               	              |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @table => Sütun kaldırılacak tablo ismi.                                  |
	| 1. string/array var @column => Sütun ismi.                                              |
	|          																				  |
	| Örnek Kullanım: $this->dbforge->dropColumn('OrnekTablo', 'col1');   			          |
	|          																				  |
	| >>>>>>>>>>>>>>>>>>>>>>>>>>>Detaylı kullanım için zntr.net<<<<<<<<<<<<<<<<<<<<<<<<<<  	  |
	|          																				  |
	******************************************************************************************/	
	public function dropColumn($table = '', $column = '')
	{
		if( ! empty($this->table) ) 
		{
			// Table yöntemi tanımlanmış ise
			// 1. parametre, 2. parametre olarak kullanılsın
			$column = $table;
			$table = $this->table; 
			$this->table = NULL;
		}
		else
		{
			$table = $this->prefix.$table;	
		}
		
		if( ! empty($this->column) )
		{
			$column = array_keys($this->column);
			$this->column = NULL;
		}
		
		if( ! is_string($table) || empty($table) ) 
		{
			return Error::set('Error', 'stringParameter', 'table');
		}
		
		if( ! ( is_string($column) || is_array($column) ) || empty($column) ) 
		{
			return Error::set('Error', 'stringArrayParameter', 'column');
		}
		
		$dropColumn = $this->db->dropColumn() !== false
					? $this->db->dropColumn()
					: 'DROP ';
	
		if( ! is_array($column) )
		{
			$query  = 'ALTER TABLE '.$table.' '.$dropColumn.$column.';';
			
			return $this->db->exec($this->_querySecurity($query), $this->secure);	
		}
		else
		{
			foreach($column as $col)
			{
				$query  = 'ALTER TABLE '.$table.' '.$dropColumn.$col.';';
				
				$this->db->exec($this->_querySecurity($query), $this->secure);
			}
			
			return true;
		}
	}
	
	/******************************************************************************************
	* MODIFY COLUMN                                                                           *
	*******************************************************************************************
	| Genel Kullanım: Sorgu işlemlerinde ALTER TABLE kullanımına alternatif olarak kullanılır.|
	| daha basit bir şekilde sütun düzenlemek için kullanılır.               	              |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @table => Sütun kaldırılacak tablo ismi.                                  |
	| 1. string/array var @condition => Sütun ismi ve özellikleri.                            |
	|          																				  |
	| Örnek Kullanım: $this->dbforge->modifyColumn('OrnekTablo', array('sütun işlemleri'));  |
	|          																				  |
	| >>>>>>>>>>>>>>>>>>>>>>>>>>>Detaylı kullanım için zntr.net<<<<<<<<<<<<<<<<<<<<<<<<<<  	  |
	|          																				  |
	******************************************************************************************/	
	public function modifyColumn($table = '', $condition = array())
	{
		if( ! empty($this->table) ) 
		{
			// Table yöntemi tanımlanmış ise
			// 1. parametre, 2. parametre olarak kullanılsın
			$condition = $table;
			$table = $this->table; 
			$this->table = NULL;
		}
		else
		{
			$table = $this->prefix.$table;	
		}
		
		if( ! empty($this->column) )
		{
			$condition = $this->column;
			$this->column = NULL;
		}
		
		if( ! is_string($table) || empty($table) ) 
		{
			return Error::set('Error', 'stringParameter', 'table');
		}
		
		if( ! is_array($condition) || empty($condition) ) 
		{
			return Error::set('Error', 'arrayParameter', 'condition');
		}
		
		$modifyColumn = $this->db->modifyColumn() !== false
					  ? $this->db->modifyColumn()
					  : 'MODIFY ';
	
		$con = NULL;
			
		foreach( $condition as $column => $values )
		{
			$colvals = '';
			
			if( is_array($values) )
			{	
				foreach($values as $val)
				{
					$colvals .= ' '.$val;
				}
			}
			else
			{
				$colvals .= ' '.$values;
			}
			
			$con .= $modifyColumn.$column.$colvals.',';
		}		
		
		$con = substr($con, 0 , -1);
		
		$query  = 'ALTER TABLE '.$table.' '.$con.';';
		
		return $this->db->exec($this->_querySecurity($query), $this->secure);
	}
	
	/******************************************************************************************
	* RENAME COLUMN                                                                           *
	*******************************************************************************************
	| Genel Kullanım: Sorgu işlemlerinde ALTER TABLE kullanımına alternatif olarak kullanılır.|
	| daha basit bir şekilde sütun ismini değiştirmek için kullanılır.               	      |
	|															                              |
	| Parametreler: 2 parametresi vardır.                                                     |
	| 1. string var @table => Sütun kaldırılacak tablo ismi.                                  |
	| 1. string/array var @condition => Sütun ismi ve özellikleri.                            |
	|          																				  |
	| Örnek Kullanım: $this->dbforge->renameColumn('OrnekTablo', array('sütun işlemleri'));  |
	|          																				  |
	| >>>>>>>>>>>>>>>>>>>>>>>>>>>Detaylı kullanım için zntr.net<<<<<<<<<<<<<<<<<<<<<<<<<<  	  |
	|          																				  |
	******************************************************************************************/
	public function renameColumn($table = '', $condition = array())
	{
		if( ! empty($this->table) ) 
		{
			// Table yöntemi tanımlanmış ise
			// 1. parametre, 2. parametre olarak kullanılsın
			$condition = $table;
			$table = $this->table; 
			$this->table = NULL;
		}
		else
		{
			$table = $this->prefix.$table;	
		}
		
		if( ! empty($this->column) )
		{
			$condition = $this->column;
			$this->column = NULL;
		}
		
		if( ! is_string($table) || empty($table) ) 
		{
			return Error::set('Error', 'stringParameter', 'table');
		}
		
		if( ! is_array($condition) || empty($condition) ) 
		{
			return Error::set('Error', 'arrayParameter', 'condition');
		}
		
		$renameColumn = $this->db->renameColumn() !== false
					  ? $this->db->renameColumn()
					  : 'CHANGE COLUMN ';
		
		$con = NULL;
		
		foreach( $condition as $column => $values )
		{
			$colvals = '';
			
			if( is_array($values) )
			{	
				foreach( $values as $val )
				{
					$colvals .= ' '.$val;
				}
			}
			else
			{
				$colvals .= ' '.$values;
			}
			
			$con .= $renameColumn.$column.$colvals.',';
		}		
		
		$con = substr($con, 0 , -1);
		
		$query  = 'ALTER TABLE '.$table.' '.$con.';';
		
		return $this->db->exec($this->_querySecurity($query), $this->secure);
	}
	
	//----------------------------------------------------------------------------------------------------
	// Column Manipulation Methods Bitiş
	//----------------------------------------------------------------------------------------------------
}