<?php
CakeHook\Filter::add('admin_menu_list', 101, function(\CakeHook\FilterState $state){
	$beforeMenuList = $state->getReturn();
	
	/* @var $ctrl App\Controller\ArticlesController */
	$param = $state->getParam();
	$ctrl = CakeHook\Filter::getCtrl();
	$user = $ctrl->Auth->user();
	$menuList = [];
	if($user['role'] === 'admin'){
	}
	$menuList[] = (object)[
			'name' => 'ユーザーリスト',
			'url' => '/users/index/',
	];
	$menuList[] = (object)[
			'name' => '記事一覧',
			'url' => '/articles/',
	];
	if(is_array($beforeMenuList)){
		$menuList = array_merge($beforeMenuList, $menuList);
	}
	return $menuList;
});