<?php
namespace CakeHook;

class Filter {
	protected static $_queue = [];
	protected static $_maxIndex = 1024;
	protected static $ctrl;
	
	public static function setCtrl($ctrl){
		self::$ctrl = $ctrl;
	}
	public static function getCtrl(){
		return self::$ctrl;
	}
	/**
	 * execute addtional filter
	 * @param string $label
	 * @param array $param
	 * @return type
	 */
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
	/**
	 * Add filter. 
	 * This method was registerd, it would be execute by filter method
	 * @param string $label
	 * @param int $index
	 * @param \Closure $func
	 * @return void
	 * @throws \Exception
	 */
	public static function add($label, $index, $func){
		if(!isset(self::$_queue[$label])) self::$_queue[$label] = [];
		if(self::$_maxIndex < $index){
			throw new \Exception('Failed add in Filter class over max index. Not Index :' . $index);
		}		
		if(isset(self::$_queue[$label][$index])){
			$_index = $index + 1;
			for($i=$_index;$i<self::$_maxIndex;$i++){
				if(!isset(self::$_queue[$label][$i])){
					self::$_queue[$label][$i] = $func;
					return ;
				}
			}
			throw new \Exception('Failed add in Filter class over max index. Not Index :' . $index);
		}else{
			self::$_queue[$label][$index] = $func;
		}
	}
	/**
	 * Overwrite registered function by the new function.
	 * @param string $label
	 * @param int $index
	 * @param \Closure $func
	 */
	public static function overwrite($label, $index, $func){
		if(!isset(self::$_queue[$label])) self::$_queue[$label] = [];
		self::$_queue[$label][$index] = $func;
	}
	/**
	 * Remove registered function.
	 * 1. Target index function was remove
	 * 2. Target index is null.  Remove all index in label.
	 * @param string $label
	 * @param int $index
	 * @return void
	 */
	public static function remove($label, $index = null){
		if($index !== null){
			unset(self::$_queue[$label][$index]);
			return;
		}
		unset(self::$_queue[$label]);
	}
	/**
	 * This method check whether be registered method.
	 * @param string $label
	 * @return boolean
	 */
	public static function is($label){
		return isset(self::$_queue[$label]);
	}
	/**
	 * clear the method that has been registered
	 */
	public static function clear(){
		self::$_queue = [];
	}
}

