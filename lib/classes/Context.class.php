<?php
	
	class Context {

		private $authorization;
		private $consumerKey;
		private $secretKey;
		private $consumerPermission;

		public static function getInstance() {
			if(!isset($GLOBALS['__Context__'])) {
				$GLOBALS['__Context__'] = new Context();
			}
			
			return $GLOBALS['__Context__'];
		}


		public function init($db_info) {
			DBHandler::init($db_info);

			$headers = getallheaders();
			$authorization = $headers['Authorization'];
			//$authorization = $_GET['Authorization'];

			if (!isset($authorization) || empty($authorization)) {
				self::printError(AuthError::ATTRIBUTE_MISSING);
				exit;
			}

			$this->initAuthorization($authorization);
			
			$this->initConsumerData();		// 컨슈머 데이터 초기화 및 컨슈머키 존재 체크
			$this->checkTimestamp();		// 타임스탬프 체크
			$this->checkNonce();			// nonce (랜덤 값) DB 체크
			$this->checkSignature();		// signature 무결성 테스트
			
			$this->printJson( (object) array(
				'success' => true
			));
		}

		private function sortUrlVariable($object) {
			$arr = array();
			$output = '';

			foreach ($object as $keyname => $value)
				array_push($arr, array('name'=>$keyname, 'value'=>$value) );

			sort($arr);
			
			for ($i=0; $i<count($arr); $i++) {
				$output .= ($arr[$i]['name']. '=' . $arr[$i]['value']);
				
				if ($i+1 != count($arr)) $output .= '&';
			}
			return $output;
		}

		private function initAuthorization($auth) {
			$auth = explode(',', $auth);
			$obj = new StdClass();

			for ($i=0; $i<count($auth); $i++) { 
				$auth[$i] = trim($auth[$i]);
				$tempArr = explode('=', $auth[$i]);

				$key = $tempArr[0];
				$value = $tempArr[1];
				
				if (substr($value, 0, 1) == '"') $value = substr($value, 1);
				if (substr($value, 0, 2) == "\\\"") $value = substr($value, 2);
				if (substr($value, strlen($value)-2) == "\\\"") $value = substr($value, 0, strlen($value)-2);
				if (substr($value, strlen($value)-1) == '"') $value = substr($value, 0, strlen($value)-1);

				$obj->{$key} = $value;
			}

			if (
				!isset($obj->consumer_key) ||
				!isset($obj->nonce) ||
				!isset($obj->signature) ||
				!isset($obj->signature_method) ||
				!isset($obj->timestamp)
			){
				self::printError(AuthError::ATTRIBUTE_MISSING);
				exit;
			}

			$this->authorization = $obj;
		}

		private function initConsumerData() {
			if ($this->consumerKey) return $this->consumerKey;

			$row = DBHandler::for_table('consumer')
				->where('consumer_key', $this->authorization->consumer_key)
				->find_one();

			if ($row === false || !$row->consumer_key || !$row->secret_key) {
				self::printError(AuthError::CONSUMER_KEY_NOT_VALID);
				exit;
			}

			$this->consumerKey = $row->consumer_key;
			$this->secretKey = $row->secret_key;
			$this->consumerPermission = $row->permission;
		}

		private function checkTimestamp() {
			$timestamp = (int)$this->authorization->timestamp;

			if ($timestamp < mktime() - 60 || $timestamp > mktime() + 60) {
				self::printError(AuthError::TIME_STAMP_EXPIRATION);
				exit;
			}
		}

		private function checkNonce() {
			// 임의의 문자열 nonce의 중복 체크
			$nonceRow = DBHandler::for_table('used_nonce')
				->where('nonce', $this->authorization->nonce)
				->where('consumer_key', $this->authorization->consumer_key)
				->find_one();

			if ($nonceRow !== false) {
				self::printError(AuthError::NONCE_OVERLAP);
				exit;
			}

			$record = DBHandler::for_table('used_nonce')->create();
			$record->set(array(
				'nonce' => $this->authorization->nonce,
				'expire_time' => date('Y-m-d H:i:s', mktime(date('H', date('i')+1))),
				'consumer_key' => $this->authorization->consumer_key
			));
			$record->save();
		}

		private function checkSignature() {
			$content = $this->sortUrlVariable($_REQUEST);

			switch (strtolower($this->authorization->signature_method)) {
				case 'hmacsha1' :
					$algo = 'sha1';
					break;

				case 'hmacmd5' :
					$algo = 'md5';
					break;

				case 'hmacsha128' :
					$algo = 'sha128';
					break;

				case 'hmacsha256' :
					$algo = 'sha256';
					break;

				case 'hmacsha512' :
					$algo = 'sha512';
					break;
				
			}

			$hash = hash_hmac($algo, $this->secretKey, $content);

			if ($hash != $this->authorization->signature) {
				self::printError(AuthError::SIGNATURE_INTEGRITY_ERROR);
				exit;
			}
		}



		public static function printJson($obj) {
			$output = JSON_UNESCAPED_UNICODE ? 
				json_encode2($obj) :
				json_encode($obj);

			if (TEXT_ENCODING != 'utf-8')
				$output = iconv('utf-8', TEXT_ENCODING, $output);

			echo $output;
		}

		public static function printError($code) {
			$obj = new StdClass();
			$obj->success = false;
			$obj->error = new AuthError($code);

			self::printJson($obj);
		}
	}