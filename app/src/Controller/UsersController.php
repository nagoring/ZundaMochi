<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\ForbiddenException;
use Cake\Event\Event;

class UsersController extends UsersAppController {
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->viewBuilder()->layout('mochi');
	}
	public function login() {
		$this->viewBuilder()->layout('home');
		if ($this->request->is('post')) {
			$user = $this->Auth->identify();
			if ($user) {
				$this->Auth->setUser($user);
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Flash->error(__('Invalid username or password, try again'));
		}
	}
	public function logout() {
		return $this->redirect($this->Auth->logout());
	}

	public function index() {
		$authUtil = \App\Lib\Util\Auth::getInstance($this);
		if(!$authUtil->isDeveloper()){
			$this->redirect('/mochi');
		}
		$this->set('users', $this->Users->find('all'));
	}

	public function view($id) {
		if (!$id) {
			throw new NotFoundException(__('Invalid user'));
		}

		$user = $this->Users->get($id);
		$this->set(compact('user'));
	}

	public function add() {
		$this->viewBuilder()->layout('home');
		$user = $this->Users->newEntity($this->request->data);
		if ($this->request->is('post')) {
			$user->role = 'author';
			if ($this->Users->save($user)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(['action' => 'add']);
			}
			$this->Flash->error(__('Unable to add the user.'));
		}
		$this->set('user', $user);
	}

}
