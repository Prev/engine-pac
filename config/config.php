<?php

	if (!defined('PAC')) {
		exit();
	}


	/**
	 * Define PAC version
	 */
	define('PAC_VERSION', '0.0.2');

	/**
	 * Define text encoding
	 * Default : utf-8
	 */
	define('TEXT_ENCODING', 'utf-8');

	/**
	 * Define json unescaped unicode
	 * on false example : \u003Cfoo\u003E
	 */
	define('USE_JSON_UNESCAPED_UNICODE', false);



	date_default_timezone_set('Asia/Seoul');
	header('Content-Type: application/json; charset=' . TEXT_ENCODING);



	require ROOT_DIR . '/lib/functions/common.function.php';
	require ROOT_DIR . '/config/database.php';
	
	require ROOT_DIR . '/lib/others/lib.idiorm.php';
	require ROOT_DIR . '/lib/classes/Context.class.php';
	require ROOT_DIR . '/lib/classes/DBHandler.class.php';
	require ROOT_DIR . '/lib/classes/Error.class.php';
	require ROOT_DIR . '/lib/classes/AuthError.class.php';
	require ROOT_DIR . '/lib/classes/ModuleError.class.php';
	require ROOT_DIR . '/lib/classes/ModuleHandler.class.php';
