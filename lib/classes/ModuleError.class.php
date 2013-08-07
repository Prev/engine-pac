<?php
	
	class ModuleError extends Error {

		const ATTRIBUTE_MISSING = 11;					// 모든 변수가 넘어오지 않음	
		const MODULE_NOT_EXISTS = 12;					// 모듈이 존재하지 않음
		const ACTION_NOT_EXISTS = 13;					// 액션이 존재하지 않음
		const PERMISSION_DENINED = 14;					// 권한이 없음

		public function __construct($code = parent::UNKNOWN) {
			$this->type = 'Module Error';
			$this->code = $code;

			switch ($code) {
				case parent::UNKNOWN : 
					$this->message = 'UnKnowned Error';
					break;

				case self::ATTRIBUTE_MISSING : 
					$this->message = 'attribute missing';
					break;

				case self::MODULE_NOT_EXISTS : 
					$this->message = 'module does not exist';
					break;

				case self::ACTION_NOT_EXISTS : 
					$this->message = 'action does not exist';
					break;
				
				case self::PERMISSION_DENINED : 
					$this->message = 'permission denined';
					break;
			}
		}

	}