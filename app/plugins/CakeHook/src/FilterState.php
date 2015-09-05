<?php
namespace CakeHook;

/**
 * Description of State
 *
 * @author nagomi
 */
class FilterState {
	private $param;
	private $return = null;
	public function __construct($param) {
		$this->param = $param;
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
}
