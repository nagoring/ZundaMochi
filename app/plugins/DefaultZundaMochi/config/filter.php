<?php
CakeHook\Filter::add('admin_menu_list', 101, function(\CakeHook\FilterState $state){
	$beforeMenuList = $state->getReturn();
	$menuList = [
		(object)[
			'name' => 'ユーザーリスト',
			'url' => '/users/index/',
		],
		(object)[
			'name' => '記事一覧',
			'url' => '/articles/',
		],

	];
	if(is_array($beforeMenuList)){
		$menuList = array_merge($beforeMenuList, $menuList);
	}
	return $menuList;
});