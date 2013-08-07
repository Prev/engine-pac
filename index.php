<?php
	
	
	/**
	 * @ proj P.A.C
	 *  (Parameter Authorization Core)
	 *
	 * @ author prevdev@gmail.com
	 *
	 *
	 */
	
	define('PAC', true);
	define('ROOT_DIR', dirname(__FILE__));

	require ROOT_DIR . '/config/config.php';


	$oContext = Context::getInstance();
	$oContext->init(getDBInfo());

	if ($oContext) {
		ModuleHandler::initModule();
	}
	