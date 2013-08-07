<?php

	if (!defined('PAC')) {
		exit();
	}


	header('Content-Type: application/json');



	/**
	 * Define PAC version
	 */
	define('PAC_VERSION', '0.0.1');

	/**
	 * Define text encoding
	 * Default : utf-8
	 */
	define('TEXT_ENCODING', 'utf-8');

	/**
	 * Define json unescaped unicode
	 * on false example : \u003Cfoo\u003E
	 */
	define('JSON_UNESCAPED_UNICODE', false);


	require ROOT_DIR . '/lib/functions/common.function.php';
	require ROOT_DIR . '/config/database.php';
	
	require ROOT_DIR . '/lib/others/lib.idiorm.php';
	require ROOT_DIR . '/lib/classes/Context.class.php';
	require ROOT_DIR . '/lib/classes/DBHandler.class.php';
	require ROOT_DIR . '/lib/classes/AuthError.class.php';
