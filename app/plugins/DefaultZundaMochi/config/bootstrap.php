<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.8
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
include_once dirname(__FILE__) . '/../View/HookView.php';
//add Template path for View
\CakeHook\TemplatePath::add(dirname(__FILE__) . DS . '..' . DS . 'Template' . DS);
include dirname(__FILE__) . DS . 'zunda_mochi_app.php';
include dirname(__FILE__) . DS . 'zunda_mochi_articles.php';
include dirname(__FILE__) . DS . 'zunda_mochi_users.php';
include dirname(__FILE__) . DS . 'zunda_mochi_pages.php';


CakeHook\Filter::add('admin_menu_list', 101, function(\CakeHook\FilterState $state){
	$beforeMenuList = $state->getReturn();
	$menuList = [
		(object)[
			'name' => 'プラグイン',
			'url' => '/mochi/plugins',
		],
		(object)[
			'name' => 'プラグインインストール',
			'url' => '/mochi/plugins_install',
		],
		(object)[
			'name' => 'ユーザーリスト',
			'url' => '/users/index/',
		],
	];
	if(is_array($beforeMenuList)){
		$menuList = array_merge($beforeMenuList, $menuList);
	}
	return $menuList;
});