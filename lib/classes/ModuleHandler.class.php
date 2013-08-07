<?php
	
	class ModuleHandler {

		public static function initModule() {
			$module = basename($_REQUEST['module']);
			$action = basename($_REQUEST['action']);

			if (!isset($_REQUEST['module']) || !isset($_REQUEST['action'])) {
				Context::printError(ModuleError::ATTRIBUTE_MISSING);
				exit;
			}

			if (!is_dir(ROOT_DIR . '/modules/' . $module)) {
				Context::printError(ModuleError::MODULE_NOT_EXISTS);
				exit;
			}

			if (!is_file(ROOT_DIR . '/modules/' . $module . '/' . $action . '.php')) {
				Context::printError(ModuleError::ACTION_NOT_EXISTS);
				exit;
			}

			require ROOT_DIR . '/modules/' . $module . '/' . $action . '.php';

			if (!function_exists($action)) {
				Context::printError(ModuleError::ACTION_NOT_EXISTS);
				exit;
			}

			call_user_func($action);
		}

	}