<?php
namespace CakeHook;
/**
 * Description of CakeHook
 *
 * @author nagomi
 */
class Hook {
	protected static $_queue = [];
	protected static $_maxIndex = 255;
	public static function action($group, $action, $param){
		if(!isset(self::$_queue[$group][$action]))return;
		ksort(self::$_queue[$group][$action]);
		$state = new \CakeHook\State($param);
		$_this = $param['_this'];
		\Closure::bind(function(){
		},$_this );
		exit;
		foreach(self::$_queue[$group][$action] as $func){
			var_dump($func);
			$func->bindTo($_this,$_this);
			$res = $func($state);
			$state->setReturn($res);
		}
		return $state->getReturn();
	}
	public static function addAction($group, $action, $index, $func){
		if(!isset(self::$_queue[$group])) self::$_queue[$group] = [];
		if(!isset(self::$_queue[$group][$action])) self::$_queue[$group][$action] = [];
		
		if(isset(self::$_queue[$group][$action][$index])){
			$_index = $index + 1;
			for($i=$_index;$i<self::$_maxIndex + $_index;$i++){
				if(!isset(self::$_queue[$group][$action][$i])){
					self::$_queue[$group][$action][$i] = $func;
				}
			}
			throw new \Exception('Failed addAction');
		}else{
			self::$_queue[$group][$action][$index] = $func;
		}
	}
	public static function overwriteAction($group, $action, $index, $func){
		if(!isset(self::$_queue[$group])) self::$_queue[$group] = [];
		if(!isset(self::$_queue[$group][$action])) self::$_queue[$group][$action] = [];
		self::$_queue[$group][$action][$index] = $func;
	}
	public static function removeAction($group, $action = null, $index = null){
		if($index !== null){
			unset(self::$_queue[$group][$action][$index]);
			return;
		}
		if($action !== null){
			unset(self::$_queue[$group][$action]);
			return;
		}
		unset(self::$_queue[$group]);
	}
	public static function isAction($group, $action){
		return isset(self::$_queue[$group][$action]);
	}
}

