<?php
//xFacility
//XFShell
//Studio2b
//Michael Son(mson0129@gmail.com)
//16FEB2016 - This file is newly created.

class XFShell extends XFObject {
	protected static $debug = false;

	protected static function shell($command) {
		if(self::$debug)
			var_dump($command);
			$descriptorspec = array(array("pipe", "r"), array("pipe", "w"), array("pipe", "w"));
			$proc = proc_open($command, $descriptorspec, $pipes);
			$return = new stdClass;
			$return->stdout = stream_get_contents($pipes[1]);
			$return->stderr = stream_get_contents($pipes[2]);
			foreach($pipes as $pipe) {
				fclose($pipe);
			}
			$return->return = proc_close($proc);
			if(self::$debug)
				var_dump($return);
				return $return;
	}
}
?>