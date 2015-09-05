<?php

use Cake\Utility\Security;
use Cake\ORM\TableRegistry;


$viewClass = '\\DefaultZundaMochi\\View\\HookView';
$group = 'App\Controller\CommunitiesController';
$action = 'index';
$index = 100;
\CakeHook\Hook::addAction($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	/* @var $ctrl App\Controller\ArticlesController */
	$param = $state->getParam();
	$ctrl = $state->getThis();
	$ctrl->viewClass = $viewClass;

});

$viewClass = '\\DefaultZundaMochi\\View\\HookView';
$group = 'App\Controller\CommunitiesController';
$action = 'add';
$index = 100;
\CakeHook\Hook::addAction($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	/* @var $ctrl App\Controller\ArticlesController */
	$param = $state->getParam();
	$ctrl = $state->getThis();
	$ctrl->viewClass = $viewClass;
});


