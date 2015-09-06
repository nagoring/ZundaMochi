<?php
namespace CakeHook;
/**
 * Description of CakeHook
 *
 * @author nagomi
 */
class Action {
	protected static $_queue = [];
	protected static $_maxIndex = 255;
	public static function action($group, $action, $param){
		if(!isset(self::$_queue[$group][$action]))return;
		ksort(self::$_queue[$group][$action]);
		$state = new \CakeHook\State($param);
		$_this = $param['_this'];
		foreach(self::$_queue[$group][$action] as $_func){
//			$func = $_func->bindTo($_this);
			$res = $_func($state);
			$state->setReturn($res);
		}
		return $state->getReturn();
	}
	public static function add($group, $action, $index, $func){
		if(!isset(self::$_queue[$group])) self::$_queue[$group] = [];
		if(!isset(self::$_queue[$group][$action])) self::$_queue[$group][$action] = [];
		
		if(isset(self::$_queue[$group][$action][$index])){
			$_index = $index + 1;
			for($i=$_index;$i<self::$_maxIndex + $_index;$i++){
				if(!isset(self::$_queue[$group][$action][$i])){
					self::$_queue[$group][$action][$i] = $func;
					return ;
				}
			}
			throw new \Exception('Failed addAction');
		}else{
			self::$_queue[$group][$action][$index] = $func;
		}
	}
	public static function overwrite($group, $action, $index, $func){
		if(!isset(self::$_queue[$group])) self::$_queue[$group] = [];
		if(!isset(self::$_queue[$group][$action])) self::$_queue[$group][$action] = [];
		self::$_queue[$group][$action][$index] = $func;
	}
	public static function remove($group, $action = null, $index = null){
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
	public static function is($group, $action){
		return isset(self::$_queue[$group][$action]);
	}
}

