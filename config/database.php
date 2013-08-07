<?php
	
	function getDBInfo() {
		$dt = debug_backtrace();
		$allow = (defined('ROOT_DIR') && ROOT_DIR . DIRECTORY_SEPARATOR . 'index.php' == $dt[0]['file']);
		if (!$allow) {		
			if (class_exists(Context))
				Context::printWarning('SandBox error : call getDBInfo in other file');
			else
				throw new Exception('SandBox error : call getDBInfo in other file');
			return;
		}
		
		return (object) array(
			'type' => 'mysql',
			'host' => 'localhost',
			'username' => 'pac_test',
			'password' => 'test123',
			'database_name' => 'pac_test',
			'prefix' => 'pac_'
		);
	
	}
