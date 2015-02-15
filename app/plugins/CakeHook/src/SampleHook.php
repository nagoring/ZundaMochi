<?php
namespace CakeHook;
class SampleHook{
	private $func;
	public static function getInstance(){
		static $instance = null;
		if($instance === null){
			$instance = new self();
		}
		return $instance;
	}
	public function set($func){
		$this->func = $func;
	}
	public function get(){
		return $this->func;
	}
}
