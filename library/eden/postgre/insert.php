<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Generates insert query string syntax
 *
 * @package    Eden
 * @category   sql
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: insert.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Postgre_Insert extends Eden_Sql_Insert {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * Set clause that assigns a given field name to a given value.
	 * You can also use this to add multiple rows in one call
	 *
	 * @param string
	 * @param string
	 * @return this
	 * @notes loads a set into registry
	 */
	public function set($key, $value, $index = 0) {
		//argument test
		Eden_Sql_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'scalar', 'null');	//Argument 2 must be scalar or null
		
		if(!in_array($key, $this->_setKey)) {
			$this->_setKey[] = $key;
		}
		
		if(is_null($value)) {
			$value = 'NULL';
		} else if(is_bool($value)) {
			$value = $value ? 'TRUE' : 'FALSE';
		}
		
		$this->_setVal[$index][] = $value;
		return $this;
	}
	
	/**
	 * Returns the string version of the query 
	 *
	 * @param  bool
	 * @return string
	 * @notes returns the query based on the registry
	 */
	public function getQuery() {
		$multiValList = array();
		foreach($this->_setVal as $val) {
			$multiValList[] = '('.implode(', ', $val).')';
		}
		
		return 'INSERT INTO "'. $this->_table . '" ("'.implode('", "', $this->_setKey).'") VALUES '.implode(", \n", $multiValList).';';
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}