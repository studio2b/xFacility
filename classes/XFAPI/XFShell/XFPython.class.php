<?php
//xFacility
//XFPython
//Studio2b
//Michael Son(mson0129@gmail.com)
//16Feb2016 - This file is newly created.

class XFPython extends XFShell {
	public static function run($code) {
		//return self::shell(sprintf("python -c \"%s\"", addcslashes($code, '"')));
		return self::shell(sprintf("echo -e \"%s\" | python", addcslashes($code, '"')));
	}
}
?>