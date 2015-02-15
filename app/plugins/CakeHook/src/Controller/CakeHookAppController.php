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

namespace CakeHook\Controller;

use Cake\Controller\Controller;
//use CakeHook;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class CakeHookAppController extends Controller {
	protected $nagomi = "nagonago";
	public function beforeFilter(\Cake\Event\Event $event) {
		parent::beforeFilter($event);
//		CakeHook::action($group, $action, $param);
	}
	/**
	 * Dispatches the controller action. Checks that the action
	 * exists and isn't private.
	 *
	 * @return mixed The resulting response.
	 * @throws \LogicException When request is not set.
	 * @throws \Cake\Controller\Exception\MissingActionException When actions are not defined or inaccessible.
	 */
	public function invokeAction() {
		$request = $this->request;
		if (!isset($request)) {
			throw new LogicException('No Request object configured. Cannot invoke action');
		}
		$isAction = $this->isAction($request->params['action']);
		$isHookAction = \CakeHook\Hook::isAction(get_class($this), $request->params['action']);
		if (!$isAction && !$isHookAction) {
			throw new MissingActionException([
		'controller' => $this->name . "Controller",
		'action' => $request->params['action'],
		'prefix' => isset($request->params['prefix']) ? $request->params['prefix'] : '',
		'plugin' => $request->params['plugin'],
			]);
		}
		\CakeHook\Hook::action(get_class($this), $request->params['action'], [
			'pass' => $request->params['pass'],
			'controller' => $this,
			'_this' => $this,
		]);
		if ($isAction) {
			call_user_func_array($callable, $request->params['pass']);
		}
	}

}