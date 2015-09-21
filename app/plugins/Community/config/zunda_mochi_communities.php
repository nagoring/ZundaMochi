<?php

use Cake\Utility\Security;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;


//Action Logic
//////////////////////////////
$viewClass = '\\CakeHook\\View\\HookView';
//$group = 'App\Controller\CommunitiesController';
$group = 'Community\Controller\CommunitiesController';

$action = 'index';
$index = 100;
\CakeHook\Action::add($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	/* @var $ctrl App\Controller\ArticlesController */
	$param = $state->getParam();
	$ctrl = $state->getThis();
	$ctrl->layout = 'mochi';
	$ctrl->viewClass = $viewClass;
	$config = TableRegistry::exists('Communities') ? [] : ['className' => 'Community\Model\Table\CommunitiesTable'];
	$ctrl->Communities = TableRegistry::get('Communities', $config);
    $ctrl->set('communities', $ctrl->paginate($ctrl->Communities));
    $ctrl->set('_serialize', ['communities']);

});

/**
	Communityをinsert
	サムネイルがあったら画像をupload	
	Comunityのupdateでthumbnailにファイルパスを入れる
	ユーザー情報をmemberにinsert
 */
$action = 'add';
$index = 100;
\CakeHook\Action::add($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	$errors = [];
	/* @var $ctrl App\Controller\ArticlesController */
	$param = $state->getParam();
	$ctrl = $state->getThis();
	$ctrl->viewClass = $viewClass;
	$ctrl->loadComponent('ImageUpload');
	
	if ($ctrl->request->is('post')) {
		$communityAddtionalLogic = \Community\Lib\Logic\CommuinityAdditional::getInstance();
		$communityAddtionalLogic->flow($ctrl);
		$community = $communityAddtionalLogic->fetchCommunity();
	}else{
		$config = TableRegistry::exists('CommunityRoles') ? [] : ['className' => 'Community\Model\Table\CommunitiesTable'];
		$communitiesTable = TableRegistry::get('Communities', $config);
		$community = $communitiesTable->newEntity();
	}
	$ctrl->set(compact('community'));
	$ctrl->set('_serialize', ['community']);
});

$action = 'view';
$index = 100;
\CakeHook\Action::add($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	/* @var $ctrl App\Controller\ArticlesController */
	$param = $state->getParam();
	$ctrl = $state->getThis();
	$ctrl->layout = 'mochi';
	$ctrl->viewClass = $viewClass;
	$community_id = (int)$ctrl->request->params['id'];
	echo "com:{$community_id}<br>";
	exit;
	echo "view";
	exit;
//	$config = TableRegistry::exists('Communities') ? [] : ['className' => 'Community\Model\Table\CommunitiesTable'];
//	$ctrl->Communities = TableRegistry::get('Communities', $config);
//    $ctrl->set('communities', $ctrl->paginate($ctrl->Communities));
//    $ctrl->set('_serialize', ['communities']);

});


//$group = 'ContactManager\Controller\ContactsController';
//$action = 'index';
//$index = 100;
//\CakeHook\Action::add($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
//	/* @var $ctrl App\Controller\ArticlesController */
//	$param = $state->getParam();
//	$ctrl = $state->getThis();
//	$ctrl->viewClass = $viewClass;
//	return 'aaaaaaaa';
//});


