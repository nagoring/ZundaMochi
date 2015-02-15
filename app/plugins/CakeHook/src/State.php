<?php
namespace CakeHook;

/**
 * Description of State
 *
 * @author nagomi
 */
class State {
	private $param;
	private $return;
	private $_this;
	public function __construct($param) {
		$this->param = $param;
		$this->_this = $param['_this'];
		unset($this->param['_this']);
	}
	
	public function setReturn($return){
		$this->return = $return;
	}
	public function getReturn(){
		return $this->return;
	}
	public function getParam(){
		return $this->param;
	}
	public function getThis(){
		return $this->_this;
	}
	public function getArgs(){
		return $this->param['pass'];
	}
}
