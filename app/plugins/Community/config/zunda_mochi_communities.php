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

$action = 'joined';
$index = 100;
\CakeHook\Action::add($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	/* @var $ctrl App\Controller\ArticlesController */
	$param = $state->getParam();
	$ctrl = $state->getThis();
	$ctrl->viewClass = $viewClass;
	$ctrl->Communities = getTableModel('Communities', 'Community\Model\Table\CommunitiesTable');
	$ctrl->CommunityMembers = getTableModel('CommunityMembers', 'Community\Model\Table\CommunityMembersTable');
	$user_id = $ctrl->Auth->user('id');
	
	$page = isset($ctrl->request->query['page']) ? (int)$ctrl->request->query['page'] : 1;
	$show_community_number = 20;
	$ctrl->paginate = [
		'limit' => $show_community_number,
		'order' => [
			 'Communities.created' => 'DESC'
		],
		'finder' => [
			'joinedQuery' => [
				'limit' => $show_community_number,
				'page' => $page,
				'user_id' => $user_id
			]
		]
	];
	try{
	    $ctrl->set('communityMembers', $ctrl->paginate($ctrl->CommunityMembers));
	} catch (Cake\Network\Exception\NotFoundException $ex) {
	    $ctrl->set('communities', []);
	}
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
	
	$refere = $ctrl->referer(null, true);
	//TODO 本当はセッションを使ったCSRFチェックしたいが簡易でリファラーチェック
	if(substr($refere, 0, 5) !== '/m/co'){
		return $ctrl->redirect('/m/co' . $community_id);
	}
	$communityJoin = Community\Lib\Logic\CommunityJoin::getInstance();
	if($communityJoin->flow($ctrl, $community_id) === false){
		return $ctrl->redirect('/m/co' . $community_id);
	}
	return $ctrl->redirect('/m/co' . $community_id);
});

/**
 * コミュニティ退会buttonのあるpage
 */
$action = 'quit';
$index = 100;
\CakeHook\Action::add($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	/* @var $ctrl App\Controller\ArticlesController */
	$param = $state->getParam();
	$ctrl = $state->getThis();
	$ctrl->viewClass = $viewClass;
	$community_id = (int)$ctrl->request->params['pass'][0];
	$communitiesTable = getTableModel('Communities', 'Community\Model\Table\CommunitiesTable');
	$community = $communitiesTable->get($community_id);
	$ctrl->set('community', $community);
});

/**
 * コミュニティ退会 logic
 */
$action = 'resign';
$index = 100;
\CakeHook\Action::add($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	/* @var $ctrl App\Controller\ArticlesController */
	$param = $state->getParam();
	$ctrl = $state->getThis();
	$ctrl->viewClass = $viewClass;
	$ctrl->request->allowMethod(['post', 'delete']);
	if(!isset($ctrl->request->data['id'])){
		//TODO エラー
	}
	$user_id = $ctrl->Auth->user('id');
	$community_id = $ctrl->request->data['id'];
	$communityMembersTable = getTableModel('Communities', 'Community\Model\Table\CommunityMembersTable');
	$communityMemberEntity = $communityMembersTable->find()->where([
		'community_id' => $community_id,
		'user_id' => $user_id,
	])->first();
	if($communityMemberEntity === null){
		return $ctrl->redirect(['url' => "/m/co{$community_id}"]);
	}
	if (!$communityMembersTable->delete($communityMemberEntity)) {
		$ctrl->Flash->error(__('コミュニティから抜けました'));
		return $ctrl->redirect(['url' => "/m/co{$community_id}"]);
	}
	$ctrl->Flash->success(__('コミュニティから抜けました'));
	return $ctrl->redirect(['url' => "/community/communities/joined/"]);
	
});

