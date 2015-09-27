<?php
//Filter Logic
//////////////////////////////
\CakeHook\Filter::add('admin_menu_list', 101, function(\CakeHook\FilterState $state){
	$beforeMenuList = $state->getReturn();
	$menuList = [

		(object)[
			'name' => '全てのコミュニティ',
			'url' => '/community/communities/',
		],
		(object)[
			'name' => '参加コミュニティ',
			'url' => '/community/communities/joined/',
		],
	];
	if(is_array($beforeMenuList)){
		$menuList = array_merge($beforeMenuList, $menuList);
	}
	return $menuList;
});
