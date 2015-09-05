<?php

use Cake\Utility\Security;
use Cake\ORM\TableRegistry;

\CakeHook\Filter::add('admin_menu_list', 101, function(\CakeHook\FilterState $state){
	$beforeMenuList = $state->getReturn();
	$menuList = [

		(object)[
			'name' => 'コミュニティ',
			'url' => '/communities/',
		],
	];
	if(is_array($beforeMenuList)){
		$menuList = array_merge($beforeMenuList, $menuList);
	}
	return $menuList;
});

$viewClass = '\\Community\\View\\HookView';
$group = 'App\Controller\CommunitiesController';
$action = 'index';
$index = 100;
\CakeHook\Hook::addAction($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	/* @var $ctrl App\Controller\ArticlesController */
	$param = $state->getParam();
	$ctrl = $state->getThis();
	$ctrl->viewClass = $viewClass;
	
    $ctrl->set('communities', $ctrl->paginate($ctrl->Communities));
    $ctrl->set('_serialize', ['communities']);

});

$viewClass = '\\Community\\View\\HookView';
$group = 'App\Controller\CommunitiesController';
$action = 'add';
$index = 100;
\CakeHook\Hook::addAction($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	/* @var $ctrl App\Controller\ArticlesController */
	$param = $state->getParam();
	$ctrl = $state->getThis();
	$ctrl->viewClass = $viewClass;
});


