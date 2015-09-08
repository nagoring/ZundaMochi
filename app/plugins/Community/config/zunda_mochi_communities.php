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
	
	$community = $ctrl->Communities->newEntity();
	if ($ctrl->request->is('post')) {
		$community = $ctrl->Communities->patchEntity($community, $ctrl->request->data);
		
		if(isset($this->request->data['thumbnail']) && $this->request->data['thumbnail']){
			$validateImage = function () use ($ctrl){
				$error = $ctrl->request->data['thumbnail']['error'];
				if($error === UPLOAD_ERR_OK){
					return true;
				}
				return false;
			};
			if(!$validateImage()){
				$ctrl->Flash->error(__('ファイルのアップロードに失敗しました'));
			}
			$tmp_name = $ctrl->request->data['thumbnail']['tmp_name'];
			
//			checkAttackImage($image);
			$filename = $ctrl->request->data['thumbnail']['name'];
			$type = $ctrl->request->data['thumbnail']['type'];
			$size = $ctrl->request->data['thumbnail']['size'];
			$type = @exif_imagetype($tmp_name);
			if (!in_array($type, [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) {
				$ctrl->Flash->error(__('画像形式が未対応です'));
			}			
		}
		
		if ($ctrl->Communities->save($community)) {
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


