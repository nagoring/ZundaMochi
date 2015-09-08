<?php
$viewClass = '\\CakeHook\\View\\HookView';
$group = 'App\Controller\AppController';
$action = 'login';
$index = 100;
CakeHook\Action::add($group, $action, $index, function(\CakeHook\State $state) use($viewClass){
	/*@var $ctrl App\Controller\AppController */
	$param = $state->getParam();
	$ctrl = $param['controller'];
	$ctrl->layout = 'mochi';
	$user = $param['user'];
	// Admin can access every action
	if (isset($user['role']) && $user['role'] === 'admin') {
		return true;
	}
	// Default deny
	return false;
	
});

