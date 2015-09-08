<?php

use Cake\Utility\Security;
use Cake\ORM\TableRegistry;

//Filter Logic
//////////////////////////////
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

//Action Logic
//////////////////////////////
$viewClass = '\\CakeHook\\View\\HookView';
$group = 'App\Controller\CommunitiesController';

$action = 'index';
$index = 100;
\CakeHook\Action::add($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	/* @var $ctrl App\Controller\ArticlesController */
	$param = $state->getParam();
	$ctrl = $state->getThis();
	$ctrl->layout = 'mochi';
	$ctrl->viewClass = $viewClass;
	
    $ctrl->set('communities', $ctrl->paginate($ctrl->Communities));
    $ctrl->set('_serialize', ['communities']);

});


$action = 'add';
$index = 100;
\CakeHook\Action::add($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	$errors = [];
	/* @var $ctrl App\Controller\ArticlesController */
	$param = $state->getParam();
	$ctrl = $state->getThis();
	$ctrl->viewClass = $viewClass;
	$ctrl->loadComponent('ImageUpload');
	
	$community = $ctrl->Communities->newEntity();
	if ($ctrl->request->is('post')) {
		$community = $ctrl->Communities->patchEntity($community, $ctrl->request->data);
		
		$result = $ctrl->Communities->save($community);
		if ($result) {
			if(isset($ctrl->request->data['thumbnail']) && $ctrl->request->data['thumbnail']){
				$tmp_name = $ctrl->request->data['thumbnail']['tmp_name'];
				$error_msg = $ctrl->ImageUpload->validate($ctrl->request->data['thumbnail']['error'], $tmp_name);
				if($error_msg !== true){
					$ctrl->Flash->error($error_msg);
				}
				$username = $ctrl->Auth->user('username');
				$path = WWW_ROOT . DS . 'media' . DS . 'img' . DS . $username;
				$filename = md5(Security::salt() . $result->id);
				$width = 125;
				$height = 125;
				$ctrl->ImageUpload->createImage($tmp_name, $path, $filename, $width, $height) ;
			}
			$ctrl->Flash->success(__('The community has been saved.'));
			return $ctrl->redirect(['action' => 'index']);
		} else {
			$ctrl->Flash->error(__('The community could not be saved. Please, try again.'));
		}
	}
	$ctrl->set(compact('community'));
	$ctrl->set('_serialize', ['community']);
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


