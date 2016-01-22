<?php
//xFacility2015
//XFDirectory
//Studio2b
//Michael Son(mson0129@gmail.com)
//18DEC2015 - This file is newly created.

class XFDirectory extends XFObject {
	private static $path, $fullPath;
	
	public function __construct($path = NULL) {
	}
	
	public static function create($path = NULL) {
		//Create directories recursively
		if(!empty($path))
			self::getPath($path);
		$directories = explode("/", self::$fullPath);
		foreach($directories as $directory) {
			$now .= "/".$directory;
			if(!is_dir($now))
				if(!mkdir($now))
					return false;
		}
		return true;
	}
	
	public static function browse($path = NULL) {
		//getList in a directory.
		
	}
	
	public static function peruse($path = NULL) {
		//getInfo
		
	}
	
	public static function update($oldPath, $newPath) {
		
	}
	
	public static function delete($path = NULL) {
		//Delete directories recursively
		if(!empty($path))
			self::getPath($path);
		$dir = dir(self::$fullPath);
		while($now = $dir->read()) {
			if($now!="." || $now!="..") {
				if(is_dir(self::$fullPath."/".$now)) {
					self::delete(self::$fullPath."/".$now);
				} else {
					unlink(self::$fullPath."/".$now);
				}
			}
		}
		$dir->close();
		rmdir(self::$fullPath);
	}
	
	protected static function getPath($path) {
		//Add front slash
		if(substr($path, 0, 1)!="/")
			$path = "/".$path;
		//Remove end slash
		if(substr($path, -1)=="/")
			$path = substr($path, 0, strlen($path)-1);
		//Set a path
		if(!is_dir($_SERVER['DOCUMENT_ROOT'].$path) && is_dir($path)) {
			//Absoulute Path
			self::$fullPath = $path;
			self::$path = substr($path, strlen($_SERVER['DOCUMENT_ROOT']));
		} else {
			//DocumentRoot Path
			if(!is_null($path)) {
				self::$fullPath = $_SERVER['DOCUMENT_ROOT'].$path;
				self::$path = $path;
			} else {
				self::$fullPath = $_SERVER['DOCUMENT_ROOT'];
			}
		}
	}
}
?>