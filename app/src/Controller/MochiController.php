<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\ForbiddenException;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class MochiController extends UsersAppController {
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->viewBuilder()->layout('mochi');
	}
	public function index(){

		$this->set('authUser', $this->Auth->user());
		$this->render('index');
	}
	public function plugins(){
		$this->loadModel('PluginSettings');
		//データベースからアクティベート情報 is_activate を付加する
		/**
		 * [$plugins stdClass fields]
		 * version
		 * author
		 * name
		 * is_activate
		 */
		/**@var $plugins[] stdClass*/
//		$activationPluginArray = \App\Lib\Logic\Plugin::getInstance()->load();
//		$plugins = $this->PluginSettings->find('activated', ['plugins' => $jsons]);
		$activationPluginArray = \App\Lib\Logic\Plugin::getInstance()->loadAll();
		$this->set('plugins', $activationPluginArray);
		//取得した情報を元にviewに渡す
		$this->render('plugins', 'mochi');
	}
	public function plugins_install($id = null){
		echo "factory!!<br>";
		echo "id:{$id}<br>";
		exit;
	}
	public function acvivate_plugin($dir = null){
		if($dir === null){
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
		\App\Lib\Logic\Plugin::getInstance()->activate([
			'name' => $dir,
			'priority' => 10,
		]);
//		$this->loadModel('PluginSettings');
//		$pluginSettingData = $this->PluginSettings->find()->where(['PluginSettings.name' => $dir])->first();
//		if($pluginSettingData !== null){
//			$this->redirect(\Cake\Routing\Router::url('/'));
//			return;
//		}
//		$query = $this->PluginSettings->query()
//			->insert(['name', 'priority'])
//			->values([
//				'name' => $dir,
//				'priority' => 10,
//			])
//			->execute();
		
		$this->redirect('mochi/plugins');
	}
	public function deacvivate_plugin($dir = null){
		if($dir === null){
			$this->redirect(\Cake\Routing\Router::url('/') . 'mochi/plugins');
			return;
		}
		\App\Lib\Logic\Plugin::getInstance()->deactivate($dir);
//		$this->loadModel('PluginSettings');
//		$row = $this->PluginSettings->find()->where(['PluginSettings.name' => $dir])->first();
//		if($row === null){
//			$this->redirect(\Cake\Routing\Router::url('/') . 'mochi/plugins');
//			return;
//		}
//		$query = $this->PluginSettings->query();
//		$query->delete()
//			->where(['id' => $row->id])
//			->execute();
		$this->redirect(\Cake\Routing\Router::url('/') . 'mochi/plugins');
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
