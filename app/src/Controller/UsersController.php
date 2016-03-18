<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\ForbiddenException;
use Cake\Event\Event;
use Cake\Utility\Security;
use Cake\Routing\Router;

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
//		if(!$authUtil->isDeveloper()){
//			$this->redirect('/mochi');
//		}
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
		$this->loadModel('Tmpusers');
		$this->viewBuilder()->layout('home');
		$tmpuser = $this->Tmpusers->newEntity($this->request->data);
		if ($this->request->is('post')) {
//			$user->role = 'author';
			$tmpuser->hash = Security::hash($tmpuser->email, 'md5');
			
			$_tmpuser = $this->Tmpusers->find()
				->where([
					'hash' => $tmpuser->hash
				])->select()->first();
			if($_tmpuser){
				$tmpuser->id = $_tmpuser->id;
			}
			if ($this->Tmpusers->save($tmpuser)) {
				$add_real_url = str_replace('/users/add', '/users/add_real/', Router::url( NULL, true )) . $tmpuser->hash;
				$this->Flash->success("仮登録完了しました。メールアドレスもしくは下記のリンクから登録して下さい");
				$this->set('user', $tmpuser);
				$this->set('add_real_url', $add_real_url);
				return '';
//				return $this->redirect(['action' => 'add']);
			}
			$this->Flash->error(__('Unable to add the user.'));
		}
//		$user = $this->Users->newEntity($this->request->data);
//		if ($this->request->is('post')) {
//			$user->role = 'author';
//			if ($this->Users->save($user)) {
//				$this->Flash->success(__('The user has been saved.'));
//				return $this->redirect(['action' => 'add']);
//			}
//			$this->Flash->error(__('Unable to add the user.'));
//		}
		$this->set('add_real_url', '');
		$this->set('user', $tmpuser);
	}
	public function add_real(){
		$this->loadModel('Tmpusers');
		$user = $this->Users->newEntity($this->request->data);
		if ($this->request->is('post')) {
			$hash = $this->request->data['hash'];
			$this->set('hash', $hash);
			$tmpuser = $this->Tmpusers->find()
					->where([
						'hash' => $hash
					])->select(['email'])->first();
			$user->username = $tmpuser->email;
			$user->role = 'author';
			
			if ($this->Users->save($user)) {
				$this->Flash->success(__('ユーザーの登録が出来ました。'));
				return $this->redirect(['action' => '/', 'controller' => 'mochi']);
			}else{
				$this->Flash->error(__('エラーです'));
			}
			$this->set('user', $user);
		}
		if(!isset($this->request->pass[0])){
			return $this->redirect(['action' => '/', 'controller' => '/']);
		}
		$this->set('user', $user);
		$hash = $this->request->pass[0];
		$tmpuser = $this->Tmpusers->find()
				->where([
					'hash' => $hash
				])->select(['email'])->first();
		$email = $tmpuser->email;
		$this->set('email', $email);
		$this->set('hash', $hash);
	}

}
