<?php
	
	class ModuleHandler {

		public static function initModule() {
			$module = $_REQUEST['module'];
			$action = $_REQUEST['action'];

			Context::printJson( (object) array(
				'success' => true
			));

			/*if (!isset($_REQUEST['module']) || !isset($_REQUEST['action'])) {
				Context::printError(ModuleError::ATTRIBUTE_MISSING);
				exit;
			}

			if (!$module || !is_dir(ROOT_DIR . '/modules/' . $module)) {
				Context::printError(ModuleError::MODULE_NOT_EXISTS);
				exit;
			}*/
		}

	}