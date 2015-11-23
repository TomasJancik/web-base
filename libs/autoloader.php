<?php

/**
 * Automatic loading of classes
 *
 * @author t.jancik
 */
class autoloader {
    /** @var array - List of known classes */
    private static $list = array();
    
    private static $exts = array('php');
    
    /**
     * Get the classes list
     * @param bool $forceScan
     */
    public static function init($forceScan = false) {
		if(!$forceScan && file_exists(_TMP_ . 'autoload.json')) {
			$json = file_get_contents(_TMP_ . 'autoload.json');
			self::$list = json_decode($json, true);
		} else {
			self::scan();
			file_put_contents(_TMP_ . 'autoload.json', json_encode(self::$list));
		}
    }
    
    /**
     * Scan the directory tree and find classes
     */
    private static function scan($dir = null) {
		// go through and seach
		if(is_null($dir)) {
			$dir = _BASEPATH_;
		}
		
		$list = scandir($dir);
		foreach($list as $item) {
			if('.' == $item || '..' == $item) {
				continue;
			}elseif(is_dir($item)) {
				self::scan($dir . $item . '/');
			} else {
				// get extension
				$ext = strtolower(substr($item, strrpos($item, '.')+1));
				if(in_array($ext, self::$exts)) {
					self::readfile($dir.$item);
				}
			}
		}
    }
    
    /**
     * Read the file and find any class / interface in it
     * @param string $file
     */
    public static function readfile($file) {
	$fileContent = file_get_contents($file);
	$regexp = '/(class|interface)\s([_a-z]+)/i';
	$classes;
	preg_match_all($regexp, $fileContent, $classes);
	if(isset($classes[2])) {
	    foreach($classes[2] as $class) {
		self::$list[$class] = $file;
	    }
	}
    }
    
    public static function load($className) {
	if(isset(self::$list[$className])) {
	    require_once self::$list[$className];
	} else {
	    throw new RuntimeException('Class ' . $className . ' not found');
	}
    }
}

function __autoload($className) {
    autoloader::load($className);
}
