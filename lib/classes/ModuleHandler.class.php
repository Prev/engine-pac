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


			$permission = Context::getInstance()->consumerPermission;
			$permission = explode(',', $permission);

			for ($i=0; $i<count($permission); $i++) { 
				$permission[$i] = trim($permission[$i]);

				$tempArr = explode('.', $permission[$i]);
				$pModule = $tempArr[0];
				$pAction = $tempArr[1];

				if ($permission[$i] == '*' || (($module == $pModule || $pModule == '*') && ($action == $pAction || $pAction == '*'))) {
					call_user_func($action);
					exit;
				}
			}

			Context::printError(ModuleError::PERMISSION_DENINED);
			exit;
			
		}

	}