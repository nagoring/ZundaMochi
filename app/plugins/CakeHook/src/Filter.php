<?php
namespace CakeHook;

class Filter {
	protected static $_queue = [];
	protected static $_maxIndex = 120;
	public static function filter($label,  $param = null){
		if(!isset(self::$_queue[$label]))return $param;
		ksort(self::$_queue[$label]);
		$state = new \CakeHook\FilterState($param);
		foreach(self::$_queue[$label] as $_func){
			$res = $_func($state);
			$state->setReturn($res);
		}
		return $state->getReturn();
	}
	public static function add($label, $index, $func){
		if(!isset(self::$_queue[$label])) self::$_queue[$label] = [];
		if(isset(self::$_queue[$label][$index])){
			$_index = $index + 1;
			for($i=$_index;$i<self::$_maxIndex;$i++){
				if(!isset(self::$_queue[$label][$i])){
					self::$_queue[$label][$i] = $func;
					return ;
				}
			}
			throw new \Exception('Failed add11');
		}else{
			self::$_queue[$label][$index] = $func;
		}
	}
	public static function overwrite($label, $index, $func){
		if(!isset(self::$_queue[$label])) self::$_queue[$label] = [];
		self::$_queue[$label][$index] = $func;
	}
	public static function remove($label, $index = null){
		if($index !== null){
			unset(self::$_queue[$label][$index]);
			return;
		}
		unset(self::$_queue[$label]);
	}
	public static function is($label){
		return isset(self::$_queue[$label]);
	}
}

