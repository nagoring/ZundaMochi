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
		return _Hook::getInstance()->action($group, $action, $param);
	}
	public static function addAction($group, $action, $index, $func){
		return _Hook::getInstance()->addAction($group, $action, $index, $func);
	}
	public static function overwriteAction($group, $action, $index, $func){
		return _Hook::getInstance()->overwriteAction($group, $action, $index, $func);
	}
	public static function removeAction($group, $action = null, $index = null){
		return _Hook::getInstance()->removeAction($group, $action, $index);
	}
	public static function isAction($group, $action){
		return _Hook::getInstance()->isAction($group, $action);
	}
}

class _Hook {
	protected $_queue = [];
	protected $_maxIndex = 255;
	private function __construct() {
	}
	public static function getInstance(){
		static $instance = null;
		if($instance === null){
			$instance = new _Hook();
		}
		return $instance;
	}
	public function action($group, $action, $param){
		if(!isset($this->_queue[$group][$action]))return;
		ksort($this->_queue[$group][$action]);
		$state = new \CakeHook\State($param);
		$_this = $param['_this'];
//		$f = \CakeHook\SampleHook::getInstance()->get();
////		$master = $f();
//		$master = function(){
//			return function(){
//				echo "n:" . $this->nagomi . '<br>';
//			};
//		};
//		$a = $master();
//		$a->bindTo($_this, get_class($_this));
//		$a->bindTo(null, $_this);
//		$a = Closure::bind($_this, $a, $_this);
		foreach($this->_queue[$group][$action] as $func){
			$executerFunc = $func->bindTo($_this, $_this);
//			\Closure::bind($func, $_this);
			$res = $executerFunc($state);
				
//			$res = $func($state);
//			$state->setReturn($res);
		}
		return $state->getReturn();
	}
	public function addAction($group, $action, $index, $func){
		if(!isset($this->_queue[$group])) $this->_queue[$group] = [];
		if(!isset($this->_queue[$group][$action])) $this->_queue[$group][$action] = [];
		
		if(isset($this->_queue[$group][$action][$index])){
			$_index = $index + 1;
			for($i=$_index;$i<$this->_maxIndex + $_index;$i++){
				if(!isset($this->_queue[$group][$action][$i])){
					$this->_queue[$group][$action][$i] = $func;
				}
			}
			throw new \Exception('Failed addAction');
		}else{
			$this->_queue[$group][$action][$index] = $func;
		}
	}
	public function overwriteAction($group, $action, $index, $func){
		if(!isset($this->_queue[$group])) $this->_queue[$group] = [];
		if(!isset($this->_queue[$group][$action])) $this->_queue[$group][$action] = [];
		$this->_queue[$group][$action][$index] = $func;
	}
	public function removeAction($group, $action = null, $index = null){
		if($index !== null){
			unset($this->_queue[$group][$action][$index]);
			return;
		}
		if($action !== null){
			unset($this->_queue[$group][$action]);
			return;
		}
		unset($this->_queue[$group]);
	}
	public function isAction($group, $action){
		return isset($this->_queue[$group][$action]);
	}
}
