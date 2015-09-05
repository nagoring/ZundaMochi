<?php

$viewClass = '\\DefaultZundaMochi\\View\\HookView';
$group = 'App\Controller\UsersController';
$action = 'login';
$index = 100;
CakeHook\Hook::addAction($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	/* @var $ctrl App\Controller\UsersController */
	$ctrl = $state->getThis();
	$param = $state->getParam();
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


$action = 'logout';
$index = 100;
CakeHook\Hook::addAction($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	$ctrl = $state->getThis();
	$ctrl->viewClass = $viewClass;
	$param = $state->getParam();
	$ctrl = $param['controller'];
	$ctrl->Auth->logout();
	return $ctrl->redirect('/users/login');
});


$action = 'index';
$index = 100;
CakeHook\Hook::addAction($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	$ctrl = $state->getThis();
	$ctrl->viewClass = $viewClass;
	$ctrl->set('users', $ctrl->Users->find('all'));
});

$action = 'add';
$index = 100;
CakeHook\Hook::addAction($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	$ctrl = $state->getThis();
	$ctrl->viewClass = $viewClass;
	$user = $ctrl->Users->newEntity($ctrl->request->data);
	if ($ctrl->request->is('post')) {
		if ($ctrl->Users->save($user)) {
			$ctrl->Flash->success(__('The user has been saved.'));
			return $ctrl->redirect(['action' => 'add']);
		}
		$ctrl->Flash->error(__('Unable to add the user.'));
	}
	$ctrl->set('user', $user);
});

$action = 'view';
$index = 100;
CakeHook\Hook::addAction($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	$ctrl = $state->getThis();
	$args = $state->getArgs();
	$ctrl->viewClass = $viewClass;
	if (!isset($args[0])) {
		throw new \Cake\Network\Exception\NotFoundException(__('Invalid user'));
	}
	$id = $args[0];
	$user = $ctrl->Users->get($id);
	$ctrl->set(compact('user'));
});

