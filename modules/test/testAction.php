<?php
	

	function testAction {

		$obj = (object) array();
		$obj->data = 'hello world';
		
		Context::printJson($obj);
		
	}