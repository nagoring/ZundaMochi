<?php

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

