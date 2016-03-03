<?php
//xFacility
//XFModel
//Studio2b
//Michael Son(mson0129@gmail.com)
//17FEB2016(1.0.0.) - This class is newly created on REST API Architecture.
class XFModel extends XFObject {
	var $requests;
	
	function __construct() {
		$this->requests = $this->getRequests();
		if(strtoupper($_SERVER['REQUEST_METHOD'])=="POST") { //create
			$this->create();
		} else if(strtoupper($_SERVER['REQUEST_METHOD'])=="GET") { //read
			$this->read();
		} else if(strtoupper($_SERVER['REQUEST_METHOD'])=="PUT") { //update
			$this->update();
		} else if(strtoupper($_SERVER['REQUEST_METHOD'])=="DELETE") { //delete
			$this->delete();
		}
	}
	
	public static function create() {}
	public static function read() {}
	public static function update() {}
	public static function delete() {}
	
	protected static function getRequests() {
		$body = file_get_contents("php://input");
		json_decode($body);
		if(json_last_error() == JSON_ERROR_NONE) {
			$return = json_decode($body);
		} else if(count($_REQUEST) > 0) {
			$return = $_REQUEST;
		} else {
			$return = $body;
		}
		return $return;
	}
}
?>