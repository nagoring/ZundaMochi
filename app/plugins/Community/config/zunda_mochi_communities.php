<?php

use Cake\Utility\Security;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

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
	$ctrl->Communities = TableRegistry::get('Communities', ['className' => 'Community\Model\Table\CommunitiesTable']);
	$community = $ctrl->Communities->newEntity();
	if ($ctrl->request->is('post')) {
		
			
		$community = $ctrl->Communities->patchEntity($community, $ctrl->request->data);
		$ctrl->Communities->connection()->begin();
		$result = $ctrl->Communities->save($community);
		if ($result) {
			$community_id = $result->id;
			//画像アップロード処理
			if(isset($ctrl->request->data['thumbnail']) && $ctrl->request->data['thumbnail']['error'] === 0 && $ctrl->request->data['thumbnail']['error'] !== ''){
				$tmp_name = $ctrl->request->data['thumbnail']['tmp_name'];
				$error_msg = $ctrl->ImageUpload->validate($ctrl->request->data['thumbnail']['error'], $tmp_name);
				if($error_msg !== true){
					$ctrl->Communities->connection()->rollback();
					$ctrl->Flash->error($error_msg);
					return;
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
				$community->thumbnail = $username . '/' . $dirdommunity . '/' . $filename . $ext;
				if(!$ctrl->Communities->save($community)){
					$ctrl->Communities->connection()->rollback();
					$ctrl->Flash->error(__('thumbnailの保存に失敗'));
					return;
				}
			}
			//add to default roles
			$config = TableRegistry::exists('CommunityRoles') ? [] : ['className' => 'Community\Model\Table\CommunityRolesTable'];
			$rolesTable = TableRegistry::get('CommunityRoles', $config);
			$roleNames = ['管理人','副管理人','一般'];
			foreach($roleNames as $rolename){
				$roleEntity = $rolesTable->newEntity();
				$roleEntity->community_id = $community_id;
				$roleEntity->system_flag = 1;
				$roleEntity->name = $rolename;
				if(!$rolesTable->save($roleEntity)){
					$ctrl->Communities->connection()->rollback();
					$ctrl->Flash->error(__('ロールの追加に失敗'));
					return ;
				}
			}
			$role = $rolesTable->find()->where(['name' => '管理人', 'community_id' => $community_id])->first();
			//Memberの追加
			$user_id = $ctrl->Auth->user('id');
			$membersTable = TableRegistry::get('CommunityMembers', ['className' => 'Community\Model\Table\CommunityMembersTable']);
			$memberEntity = $membersTable->newEntity();
			$memberEntity->community_id = $community_id;
			$memberEntity->user_id = $user_id;
			$memberEntity->community_role_id = $role->id;
			
			if(!$membersTable->save($memberEntity)){
				$ctrl->Communities->connection()->rollback();
				$ctrl->Flash->error(__('Memberの関連付けに失敗'));
				return;
			}
			
			$ctrl->Communities->connection()->commit();
			$ctrl->Flash->success(__('The community has been saved.'));
			return $ctrl->redirect(['action' => 'index']);
		} else {
			$ctrl->Communities->connection()->rollback();
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


