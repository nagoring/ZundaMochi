<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\ForbiddenException;
use Cake\Event\Event;

class MochiController extends AppController {
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->allow('add');
		$this->Auth->allow(['logout']);
		$this->Auth->config('loginRedirect', [
				'controller' => 'Mochi',
				'action' => 'index'
			]
		);
		$this->Auth->config('logoutRedirect', [
				'controller' => 'Mochi',
				'action' => 'login',
			]
		);
	}
	public function index(){
		$this->render('index', 'mochi');
	}
	public function plugins(){
		$jsonFileName = 'cakehook.json';
		$jsons = [];
		//プラグインのパスを取得
		$pluginDirPath = ROOT . DS . 'plugins' . DS;
		$dirs = scandir($pluginDirPath);
		//ディレクトリ検索
		foreach($dirs as $dir){
			if($dir === '.' || $dir === '..')continue;
			echo $dir . "<br>";
			//ZundaMochiプラグインが判定しつつ名前を取る
			$jsonFileFullPath = $pluginDirPath . $dir . DS . $jsonFileName;
			if(!file_exists($jsonFileFullPath))continue;
			$json = file_get_contents($jsonFileFullPath);
			$jsons[$dir] = json_decode($json);
		}
		$this->set('plugins', $jsons);
		//取得した情報を元にviewに渡す
		$this->render('plugins', 'mochi');
	}
	public function acvivate_plugin($dir = null){
		if($dir === null){
			$this->redirect(\Cake\Routing\Router::url('/'));
			return;
		}
		$this->loadModel('PluginSettings');
		
		$pluginSettingData = $this->PluginSettings->findByName($dir);
		if($pluginSettingData !== null){
			$this->redirect(\Cake\Routing\Router::url('/'));
			return;
		}
		
		$pluginDirPath = ROOT . DS . 'plugins' . DS;
		$jsonFileName = 'cakehook.json';
		$jsonFileFullPath = $pluginDirPath . $dir . DS . $jsonFileName;
		if(!file_exists($jsonFileFullPath)){
			$this->redirect(\Cake\Routing\Router::url('/'));
			return;
		}
		$pluginSetting = $this->PluginSettings->newEntity();
		//アクティベートする
		$pluginSetting->name = $dir;
		$pluginSetting->priority = 10;
		$this->PluginSettings->save($pluginSetting);
		
		$this->redirect('mochi/plugins');
	}
	public function login() {
		if ($this->request->is('post')) {
			$user = $this->Auth->identify();
			if ($user) {
				$this->Auth->setUser($user);
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Flash->error(__('Invalid username or password, try again'));
		}
		$this->render('login', 'mochi');
	}

	public function logout() {
		return $this->redirect($this->Auth->logout());
	}

	public function isAuthorized($user) {
		// Admin can access every action
		if (isset($user['role']) && $user['role'] === 'admin') {
			return true;
		}
		// Default deny
		return false;
	}

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
