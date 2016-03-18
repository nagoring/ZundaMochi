<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use CakeHook\Action;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
//class UsersAppController extends \CakeHook\Controller\CakeHookAppController {
class UsersAppController extends \App\Controller\AppController {
	public function beforeFilter(\Cake\Event\Event $event) {
		parent::beforeFilter($event);
		\CakeHook\Filter::filter('app.beforeFilter', $event);
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
			]);
		\CakeHook\Filter::setCtrl($this);
		\CakeHook\Filter::add('admin_menu_list', 101, function(\CakeHook\FilterState $state){
			$beforeMenuList = $state->getReturn();
			$menuList = [];
			$authUtil = \App\Lib\Util\Auth::getInstance($this);
			if($authUtil->isDeveloper()){
				$menuList[] = (object)[
					'name' => 'プラグイン',
					'url' => '/mochi/plugins',
				];
				$menuList[] = (object)[
					'name' => 'プラグインインストール',
					'url' => '/mochi/plugins_install',
				];
			}
			$menuList[] = (object)[
				'name' => 'ダッシュボード',
				'url' => '/mochi/',
			];
			
			if(is_array($beforeMenuList)){
				$menuList = array_merge($beforeMenuList, $menuList);
			}
			return $menuList;
		});
		$this->set('loginUser', $this->Auth->user());
	}
	/**
	 * Initialization hook method.
	 *
	 * Use this method to add common initialization code like loading components.
	 *
	 * @return void
	 */
	public function initialize() {
		$this->loadComponent('Flash');
		$this->loadComponent('Image');
		$this->loadComponent('Auth', [
			'loginRedirect' => [
				'controller' => 'Articles',
				'action' => 'index'
			],
			'logoutRedirect' => [
				'controller' => 'Pages',
				'action' => 'display',
				'home'
			]
		]);
	}

	public function isAuthorized($user) {
		return CakeHook::action('AppController', 'isAuthorized', [
			'controller' => $this,
			'user' => 'user'
		]);
	}


}
