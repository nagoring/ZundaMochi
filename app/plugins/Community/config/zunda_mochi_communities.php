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
	$dir = \App\Lib\Util\Dir::getInstance();

	$community = $ctrl->Communities->newEntity();
	if ($ctrl->request->is('post')) {
		$community = $ctrl->Communities->patchEntity($community, $ctrl->request->data);
		$ctrl->Communities->begin();
		$result = $ctrl->Communities->save($community);
		if ($result) {
			$community_id = $result->id;
			//画像アップロード処理
			if(isset($ctrl->request->data['thumbnail']) && $ctrl->request->data['thumbnail']){
				$tmp_name = $ctrl->request->data['thumbnail']['tmp_name'];
				$error_msg = $ctrl->ImageUpload->validate($ctrl->request->data['thumbnail']['error'], $tmp_name);
				if($error_msg !== true){
					$ctrl->Communities->rollback();
					$ctrl->Flash->error($error_msg);
				}
				$username = $ctrl->Auth->user('username');
				$dir->checkAndMakeImageDir($username);
				$path = $dir->communityImageDir($username);
				$filename = $dir->communityImageFilename($community_id, $username);
				$width = 125;
				$height = 125;
				$ctrl->ImageUpload->createImage($tmp_name, $path, $filename, $width, $height);
				$community = $ctrl->Communities->get($community_id);
				$community->thumbnail = $filename;
				$ext = $ctrl->ImageUpload->getExtention($tmp_name);
				$dirdommunity = Configure::read('DIR_COMMUNITY');
				$community->thumbnail = $username . DS . $dirdommunity . DS . $filename . $ext;
				if(!$ctrl->Communities->save($community)){
					$ctrl->Communities->rollback();
					$ctrl->Flash->error(__('thumbnailの保存に失敗'));
				}
			}
			//MemberとRollの追加
			$membersTable = TableRegistry::get('CommunityMembers', ['className' => 'Community\Model\Table\CommunityMembersTable']);
			$memberEntity = $membersTable->newEntity();
			$memberEntity->community_id = $community_id;
			$memberEntity->user_id = $user_id;
			$memberEntity->role_id = 1;
			$membersTable->save($entity);
			
			$ctrl->Flash->success(__('The community has been saved.'));
			return $ctrl->redirect(['action' => 'index']);
		} else {
			$ctrl->Communities->rollback();
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


