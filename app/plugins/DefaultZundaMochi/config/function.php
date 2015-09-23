<?php
use Cake\ORM\TableRegistry;

function checkAttackImage($image){
	mb_regex_encoding('ASCII');
	if (mb_eregi('<\\?php', $image)) {
		die('Attack detected');
	}
	mb_regex_encoding('ASCII');
	if (mb_eregi('^.*<\\?php.*$', $image)) {
		die('Attack detected');
	}
	if (preg_match('/<\\?php./i', $image)) {
		die('Attack detected');
	}	
}
function getTableModel($class_name, $class_path){
	$config = TableRegistry::exists($class_name) ? [] : ['className' => $class_path];
	return TableRegistry::get($class_name, $config);
}

