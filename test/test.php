<?php
	
	header('Content-Type: text/plain');


	$auth = new StdClass();

	$auth->consumer_key = 'YFUO1KLQ9GO8UFQRORZB';
	$auth->nonce = getRandomAuthKey(20);
	$auth->signature_method = 'hmacsha1';
	$auth->timestamp = time();

	$sum = '';
	foreach ($auth as $key => $value) {
		$sum .= ($key . '=' . $value . ',');
	}
	$sum = substr($sum, 0, strlen($sum) - 1);

	$auth->signature = hash_hmac('sha1', $sum, 'EHXV47LCM2ESU578WJPQ8ZMWGO3COB7E170363R6');

	var_dump($sum);
	var_dump($auth);
	echo "\n\n\n\n\n\n\n";

	$data = getUrlData('http://127.0.0.1/pac/', ($sum . ',signature=' . $auth->signature));
	echo $data;


	function getRandomAuthKey($count) {
		$charKey = array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

		$str = '';
		for ($i=0; $i<$count; $i++)
			$str .= $charKey[mt_rand(0, count($charKey)-1)];
		return $str;
	}

	function getUrlData($url, $auth) {
		$temp = explode('://', $url);
		$temp = explode('/', $temp[1]);

		$host = $temp[0];
		$port = strstr($url, 'https://') ? 443 : 80;
		$output = '';

		if (!($fp = fsockopen(($port == 443 ? 'ssl://'.$host : $host), $port))) return NULL;
		
		fputs($fp,
			"GET ${url} HTTP/1.0\r\n" .
			"Host: ${host}\r\n" .
			'Authorization: ' . $auth . "\r\n" .
			'User-Agent: Mozilla/5.0 (Windows NT 6.2; WOW64)'.
			"\r\n\r\n"
		);


		while(!feof($fp))
			$output .= fgets($fp, 1024);	
		
		// 헤더 정보 잘라내기
		$output = substr($output, strpos($output, "\r\n\r\n")+4);
		
		fclose($fp);
		return $output; 
	}