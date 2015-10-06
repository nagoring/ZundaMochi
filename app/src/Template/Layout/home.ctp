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
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スカゼミ</title>
    <?= $this->Html->meta('icon') ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

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
	<div class="container bg-info">
		<nav class="navbar navbar-default">
				<div class="navbar-header">
					<a href="/" class="navbar-brand">スカゼミ</a>
				</div>
				<ul class="nav navbar-nav">
					<li><a href="#">コミュニティ</a></li>
					<li><a href="#">プロジェクト</a></li>
					<li><a href="/users/add"><?= __("ユーザー登録")?></a></li>
				</ul>
		</nav>
			<?= $this->Flash->render() ?>
			<?= $this->fetch('content') ?>
	</div>

</body>
</html>
