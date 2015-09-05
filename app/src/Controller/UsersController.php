<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\ForbiddenException;
use Cake\Event\Event;

class UsersController extends AppController {
	protected $layout = 'mochi';
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->allow('add');
		$this->Auth->allow(['add', 'logout']);
	}

//	public function login() {
//		if ($this->request->is('post')) {
//			$user = $this->Auth->identify();
//			if ($user) {
//				$this->Auth->setUser($user);
//				return $this->redirect($this->Auth->redirectUrl());
//			}
//			$this->Flash->error(__('Invalid username or password, try again'));
//		}
//	}
//	public function logout() {
//		return $this->redirect($this->Auth->logout());
//	}
//
//	public function index() {
//		$this->set('users', $this->Users->find('all'));
//	}
//
//	public function view($id) {
//		if (!$id) {
//			throw new NotFoundException(__('Invalid user'));
//		}
//
//		$user = $this->Users->get($id);
//		$this->set(compact('user'));
//	}
//
//	public function add() {
//		$user = $this->Users->newEntity($this->request->data);
//		if ($this->request->is('post')) {
//			if ($this->Users->save($user)) {
//				$this->Flash->success(__('The user has been saved.'));
//				return $this->redirect(['action' => 'add']);
//			}
//			$this->Flash->error(__('Unable to add the user.'));
//		}
//		$this->set('user', $user);
//	}

}
