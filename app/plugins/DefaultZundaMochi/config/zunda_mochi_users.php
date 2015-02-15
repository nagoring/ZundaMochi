<?php
$viewClass = '\\DefaultZundaMochi\\View\\HookView';
$group = 'App\Controller\UsersController';
$action = 'login';
$index = 100;
CakeHook\Hook::addAction($group, $action, $index, function(\CakeHook\State $state) use($viewClass){
	/*@var $ctrl App\Controller\UsersController */
	$param = $state->getParam();
	$ctrl = $param['controller'];
	$ctrl->viewClass = $viewClass;
	if ($ctrl->request->is('post')) {
		$user = $ctrl->Auth->identify();
		if ($user) {
			$ctrl->Auth->setUser($user);
			return $ctrl->redirect($ctrl->Auth->redirectUrl());
		}
		$ctrl->Flash->error(__('Invalid username or password, try again'));
	}
});


$group = 'App\Controller\UsersController';
$action = 'logout';
$index = 100;
CakeHook\Hook::addAction($group, $action, $index, function(\CakeHook\State $state) use($viewClass){
	$param = $state->getParam();
	$ctrl = $param['controller'];
	return $ctrl->redirect($ctrl->Auth->logout());
});

