<?php
namespace App\Lib\Util;
class Auth {
	private $ctrl;
	private function __construct($ctrl) {
		$this->ctrl = $ctrl;
	}
	public static function getInstance($ctrl){
		static $instance = null;
		if($instance === null){
			$instance = new self($ctrl);
		}
		return $instance;
	}
	public function isDeveloper(){
		$role = $this->ctrl->Auth->user('role');
		return $role === 'admin' || $role === 'dev';
	}
}
