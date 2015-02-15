<?php
namespace CakeHook;

/**
 * Description of TemplatePath
 *
 * @author nagomi
 */
class TemplatePath {
	private static $__paths = [];
	public static function add($path){
		self::$__paths[] = realpath($path) . DS;
	}
	public static function get(){
		return self::$__paths;
	}
}
