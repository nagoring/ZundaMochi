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
class AppController extends \CakeHook\Controller\CakeHookAppController {

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
//		$this->loadComponent('Auth', [
//			'loginRedirect' => [
//				'controller' => 'Articles',
//				'action' => 'index'
//			],
//			'logoutRedirect' => [
//				'controller' => 'Pages',
//				'action' => 'display',
//				'home'
//			]
//		]);
		$pluginSettingsTable = \Cake\ORM\TableRegistry::get('PluginSettings');
		$plugins = $pluginSettingsTable->find()->all();
		foreach($plugins as $plugin){
			\Cake\Core\Plugin::load($plugin->name, ['autoload' => true, 'bootstrap' => true, 'routes' => true]);
//			include dirname(__FILE__) . '/../plugins/Community/routes.php';
		}
	}

	public function isAuthorized($user) {
		return CakeHook::action('AppController', 'isAuthorized', [
			'controller' => $this,
			'user' => 'user'
		]);
	}

	public function beforeFilter(\Cake\Event\Event $event) {
		parent::beforeFilter($event);
		\CakeHook\Filter::filter('app.beforeFilter', $event);
	}

}
