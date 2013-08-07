<?php
	
	abstract class Error {

		public $message = 'Unknown error';
		public $code;
		
		const UNKNOWN = 0;	// 알수없는 에러

		abstract public function __construct($code = self::UNKNOWN);
	}