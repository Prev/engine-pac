<?php

	//header('Content-Type: text/plain');

	$postdata = file_get_contents('php://input');

	var_dump($HTTP_RAW_POST_DATA);
	var_dump($_GLOBALS['HTTP_RAW_POST_DATA']);
	var_dump($_REQUEST);
	var_dump($postdata);

?>

<form method="post">
	<input name="key">
	<input type="submit">
</form>