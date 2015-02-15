<?php
namespace DefaultZundaMochi\config;

class ZundaMochiUsers {

	public function __construct() {
		$viewClass = '\\DefaultZundaMochi\\View\\HookView';
		$group = 'App\Controller\UsersController';
		$action = 'login';
		$index = 100;
		\CakeHook\Hook::addAction($group, $action, $index, function(\CakeHook\State $state) use ($viewClass) {
			/* @var $this App\Controller\UsersController */
			$param = $state->getParam();
			$this->viewClass = $viewClass;
			if ($this->request->is('post')) {
				$user = $this->Auth->identify();
				if ($user) {
					$this->Auth->setUser($user);
					return $this->redirect($this->Auth->redirectUrl());
				}
				$this->Flash->error(__('Invalid username or password, try again'));
			}
		});

		$group = 'App\Controller\UsersController';
		$action = 'logout';
		$index = 100;
		\CakeHook\Hook::addAction($group, $action, $index, function(\CakeHook\State $state) use ($viewClass) {
			$param = $state->getParam();
			$ctrl = $param['controller'];
			return $ctrl->redirect($ctrl->Auth->logout());
		});
		;
	}

}

new \DefaultZundaMochi\config\ZundaMochiUsers();
