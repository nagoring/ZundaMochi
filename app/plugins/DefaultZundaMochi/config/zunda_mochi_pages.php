<?php
$viewClass = '\\DefaultZundaMochi\\View\\HookView';
$group = 'App\Controller\PagesController';
$action = 'index';
$index = 100;
CakeHook\Hook::addAction($group, $action, $index, function(\CakeHook\State $state) use($viewClass){
	/*@var $ctrl App\Controller\UsersController */
	$param = $state->getParam();
	$ctrl = $state->getThis();
	$ctrl->viewClass = $viewClass;
	
	
});

