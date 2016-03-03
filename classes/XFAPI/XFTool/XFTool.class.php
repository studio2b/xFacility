<?php
//xFacility
//XFTool
//Studio2b
//Michael Son(mson0129@gmail.com)
//18FEB2016(1.0.0.) - This class is newly created.

class XFTool extends XFObject {
	var $model, $view, $controller;
	var $requests;
	
	function __construct() {
		//Load MVC Classes
		$mvcArray = array("Model", "View", "Controller");
		foreach($mvcArray as $mvc) {
			if(file_exists(sprintf("%s/classes/%s%s.class.php", dirname($_SERVER['SCRIPT_FILENAME']), get_class($this), $mvc))) {
				require_once(sprintf("%s/classes/%s%s.class.php", dirname($_SERVER['SCRIPT_FILENAME']), get_class($this), $mvc));
				$className = get_class($this).$mvc;
				$lowerMvc = strtolower($mvc);
				$this->$lowerMvc = new $className();
			}
		}
		
		if(is_null($_REQUEST['how']))
			$how = "read";
		else
			$how = strtolower($_REQUEST['how']);
		
		switch($how) {
			case "create":
			case "read":
			case "browse":
			case "peruse":
			case "update":
			case "delete":
				//how = CRUD -> model에서 처리
				if(is_object($this->model))
					$return = call_user_func(array($this->model, $how), $what);
				break;
			default:
				//how = 기타 -> controller에서 처리
				if(is_object($this->controller))
					$return = call_user_func(array($this->controller, $how), $what);
		}
		
		//Return in acceptable MIME type
		if(strtolower($_SERVER['HTTP_ACCEPT'])=="application/json"
		|| (strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])==strtolower("XMLHttpRequest") && strtolower($_SERVER['HTTP_ACCEPT'])!="application/json")
		) {
		//|| is_object($view)) {
			//return in JSON
			if(!is_null($return)) {
				echo json_encode($return);
			} else {
				$return = new stdClass();
				//error http code
				$return->how = $how;
				$return->model = is_object($this->model);
				$return->controller = is_object($this->controller);
				$return->error = "Program exited with code 0";
				echo json_encode($return);
			}
		} else {
			//echo sprintf("%s/resorces/en-us/%s.htm", str_replace($_SERVER['DOCUMENT_ROOT'], "", dirname($_SERVER['SCRIPT_FILENAME'])), $how);
			//exit;
			
			//return in HTML
			if(!is_null($return) || !is_null($how)) {
				$xfView = new XFView(sprintf("%s/resources/ko-kr/%s.htm", str_replace($_SERVER['DOCUMENT_ROOT'], "", dirname($_SERVER['SCRIPT_FILENAME'])), $how));
			} else {
				$xfView = new XFView(sprintf("%s/resources/ko-kr/index.htm", str_replace($_SERVER['DOCUMENT_ROOT'], "", dirname($_SERVER['SCRIPT_FILENAME']))));
			}
			$xfView->show();
		}
	}
}
?>