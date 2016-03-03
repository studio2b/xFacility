<?php
//xFacility2015
//Loader
//Studio2b
//Michael Son(mson0129@gmail.com)
//22SEP2014(1.0.0.) - Loader is updated.
//16MAR2015(1.1.0.) - Loader is divided from XFObject.class.php of xFacility2014. And path setting is modified. It's set automatically.
//27APR2015(1.1.1.) - Stopping with a non-exist path is corrected.
//22SEP2015(1.2.0.) - Autoloader is added.

function load($className) {
	//Autoloader which works with spl_autoload_register();
	
	$paths[0] = __DIR__."/classes";
	$j = 1;
	
	for($i=0; $i<$j; $i++) {
		$handle = opendir($paths[$i]);
		if(is_dir($paths[$i])) {
			while(false !==($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					if(!is_dir($paths[$i]."/".$file)) {
						if(substr($file, 0, 1)!=".") {
							if($file==$className.".class.php") {
								if($_GET['debug']==true)
									echo $paths[$i]."/".$file;
								require_once($paths[$i]."/".$file);
								if($_GET['debug']==true)
									echo "...OK\n";
								break;
							}
						}
					} else {
						$paths[] = $paths[$i]."/".$file;
						$j = count($paths);
					}
				}
			}
		}
	}
}

function loadAll($classPath=NULL) {
	if(!is_null($classPath)) {
		if(substr($classPath, -1)=="/")
			$classPath = substr($classPath, 0, -1);
		$paths[0] = $_SERVER['DOCUMENT_ROOT'].$classPath;
	} else {
		$paths[0] = __DIR__."/classes";
	}
	$j = 1;
	for($i=0; $i<$j; $i++) {
		$handle = opendir($paths[$i]);
		if(is_dir($paths[$i])) {
			while(false !==($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					if(!is_dir($paths[$i]."/".$file)) {
						if(substr($file, 0, 1)!=".") {
							if($_GET['debug']==true)
								echo $paths[$i]."/".$file;
							require_once($paths[$i]."/".$file);
							if($_GET['debug']==true)
								echo "...OK\n";
						}
					} else {
						$paths[] = $paths[$i]."/".$file;
						$j = count($paths);
					}
				}
			}
		}
	}
	return false;
}

if($_GET[debug]==true) {
	//error_reporting(E_ALL);
	//ini_set("display_errors", 1);
	error_reporting(23);
	ini_set("display_errors", 1);
	ini_set("html_errors", 1);
}
spl_autoload_register('load');
//loadAll();
?>