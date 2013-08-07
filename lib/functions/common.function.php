<?php
	
	/**
	 * json_encode와 비슷
	 * 유니코드 값을 \ucXXX 로 치환하지 않으며 json_encode가 구현되지 않은서버에서도 사용할 수 있음
	 */
	function json_encode2($data) {
		switch(gettype($data)) {
			case 'boolean':
				return $data ? 'true' : 'false';
			case 'integer':
			case 'double':
				return $data;
			case 'string':
				return '"' . strtr($data, array('\\' => '\\\\', '"' => '\\"')) . '"';
			case 'object':
				$data = get_object_vars($data);
			case 'array':
				$rel = FALSE; // relative array?
				$key = array_keys($data);
				foreach($key as $v) {
					if(!is_int($v)) {
						$rel = TRUE;
						break;
					}
				}
	
				$arr = array();
				foreach($data as $k => $v)
					$arr[] = ($rel ? '"' . strtr($k, array('\\' => '\\\\', '"' => '\\"')) . '":' : '') . json_encode2($v);
	
				return $rel ? '{' . join(',', $arr) . '}' : '[' . join(',', $arr) . ']';
			default:
				return '""';
		}
	}


	if (!function_exists('getallheaders')) 
	{ 
		function getallheaders() { 
			$headers = ''; 
			
			foreach ($_SERVER as $name => $value)  { 
				if (substr($name, 0, 5) == 'HTTP_') { 
					$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value; 
				} 
			}
			$headers['Authorization'] = $headers['HTTP_AUTHORIZATION'];
			$headers['Authorization-Signature'] = $headers['HTTP_AUTHORIZATION_SIGNATURE'];

			return $headers; 
		} 
	} 