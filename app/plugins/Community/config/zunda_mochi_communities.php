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

//$action = 'edit';
//$index = 100;
//\CakeHook\Action::add($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
//	$errors = [];
//	/* @var $ctrl App\Controller\ArticlesController */
//	$param = $state->getParam();
//	$ctrl = $state->getThis();
//	$ctrl->viewClass = $viewClass;
//	$ctrl->loadComponent('ImageUpload');
//	
//	if ($ctrl->request->is('post')) {
//		$communityAddtionalLogic = \Community\Lib\Logic\CommuinityAdditional::getInstance();
//		$communityAddtionalLogic->flow($ctrl);
//		$community = $communityAddtionalLogic->fetchCommunity();
//	}else{
//		$config = TableRegistry::exists('CommunityRoles') ? [] : ['className' => 'Community\Model\Table\CommunitiesTable'];
//		$communitiesTable = TableRegistry::get('Communities', $config);
//		$community = $communitiesTable->newEntity();
//	}
//	$ctrl->set(compact('community'));
//	$ctrl->set('_serialize', ['community']);
//});


$action = 'view';
$index = 100;
\CakeHook\Action::add($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	/* @var $ctrl App\Controller\ArticlesController */
	$param = $state->getParam();
	$ctrl = $state->getThis();
	$ctrl->viewClass = $viewClass;
	$user_id = (int)$ctrl->Auth->user('id');
	$community_id = (int)$ctrl->request->params['id'];
	$communitiesTable = getTableModel('Communities', 'Community\Model\Table\CommunitiesTable');
	$communityMembersTable = getTableModel('CommunityMembers', 'Community\Model\Table\CommunityMembersTable');
	$community = $communitiesTable->get($community_id);
	$member = $communityMembersTable->find('joinedMember',[
		'user_id' => $user_id,
		'community_id' => $community_id,
	]);
	if($member){
		//コミュニティ参加者
	    $ctrl->set('is_joined_community', true);
	}else{
		//コミュニティ未加入
	    $ctrl->set('is_joined_community', false);
	}
	unset($member);
	
    $ctrl->set('community', $community);
});
/**
 * コミュニティに参加するための関数
 * community_idを
 */
$action = 'join';
$index = 100;
\CakeHook\Action::add($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	/* @var $ctrl App\Controller\ArticlesController */
	$param = $state->getParam();
	$ctrl = $state->getThis();
	$ctrl->viewClass = $viewClass;
	$community_id = (int)$ctrl->request->params['pass'][0];
	$communitiesTable = getTableModel('Communities', 'Community\Model\Table\CommunitiesTable');
	$communityRolesTable = getTableModel('CommunityRoles', 'Community\Model\Table\CommunityRolesTable');
	
	$refere = $ctrl->referer(null, true);
	if(substr($refere, 0, 5) !== '/m/co'){
		return $ctrl->redirect('/m/co' . $community_id);
	}
		
	//TODO デフォルト権限の設定がどこかにありそこで指定する
	$defaultCommunityRoleEntity = $communityRolesTable->find()->where([
		'community_id' => $community_id
	])->contain('Communities')->first();
	
	
	$communityMembersTable = getTableModel('CommunityMembers', 'Community\Model\Table\CommunityMembersTable');
	$communityMemberEntity = $communityMembersTable->newEntity();
	$communityMemberEntity->community_id = (int)$community_id;
	$communityMemberEntity->user_id = (int)$ctrl->Auth->user('id');
	$communityMemberEntity->community_role_id = $defaultCommunityRoleEntity->id;
	
	//既に登録されていた場合は登録を許さない
	$joinedCommunityMember = $communityMembersTable->find()->where([
		'community_id' => $communityMemberEntity->community_id,
		'user_id' => $communityMemberEntity->user_id,
	])->first();
	if($joinedCommunityMember){
		return $ctrl->redirect('/m/co' . $community_id);
	}
	if(!$communityMembersTable->save($communityMemberEntity)){
		//TODO エラーの場合エラー画面が有っても良いが今は保留
		throw new \Exception(__('CommunityMemberの関連付けに失敗'));
	}
	echo "END";
	exit;
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


