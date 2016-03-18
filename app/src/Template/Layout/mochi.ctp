<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$menuList = CakeHook\Filter::filter('admin_menu_list', []);
$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
	<style>
#sidebar{
	width: 200px;
	float:left;
}
		
	</style>
</head>
<body>
    <header>
        <div class="header-title">
            <span><a style="color:#ffffff;" href="/mochi/"><?= $this->fetch('title') ?></a></span>
        </div>
        <div class="header-help">
            <span>
				 <?= $loginUser['username']?>さんいらっしゃい
			</span>
            <span><a target="_blank" href="/users/logout">Logout</a></span>
            <span><a target="_blank" href="http://book.cakephp.org/3.0/">Documentation</a></span>
            <span><a target="_blank" href="http://api.cakephp.org/3.0/">API</a></span>
        </div>
    </header>
    <div id="container">
        <div id="content">
			<div id="sidebar">
				<?php foreach($menuList as $menu):?>
				<p><a href="<?php echo $menu->url?>"><?php echo $menu->name?></a></p>
				<?php endforeach?>
			</div>
            <?= $this->Flash->render() ?>
            <div class="row">
                <?= $this->fetch('content') ?>
            </div>
        </div>
        <footer>
        </footer>
    </div>
</body>
</html>
