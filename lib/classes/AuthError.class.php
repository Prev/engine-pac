<?php
	
	class AuthError extends Error {

		const ATTRIBUTE_MISSING = 1;					// 모든 변수가 넘어오지 않음	
		const CONSUMER_KEY_NOT_VALID = 2;				// 유효하지 않은 컨슈머키
		const TIME_STAMP_EXPIRATION = 3;				// 타임아웃
		const NONCE_OVERLAP = 4;						// 중복 체크 실패
		const SIGNATURE_INTEGRITY_ERROR = 5;			// 시그니처 무결성 테스트 실패

		public function __construct($code = parent::UNKNOWN) {
			$this->type = 'Auth Error';
			$this->code = $code;
			
			switch ($code) {
				case parent::UNKNOWN : 
					$this->message = 'UnKnowned Error';
					break;

				case self::ATTRIBUTE_MISSING : 
					$this->message = 'attribute missing';
					break;
					
				case self::CONSUMER_KEY_NOT_VALID : 
					$this->message = 'consumer key is not valid';
					break;

				case self::TIME_STAMP_EXPIRATION : 
					$this->message = 'timeStamp expiration';
					break;

				case self::NONCE_OVERLAP : 
					$this->message = 'nonce overlap error';
					break;
				
				case self::SIGNATURE_INTEGRITY_ERROR : 
					$this->message = 'intergrity error';
					break;
			}
		}
	}
