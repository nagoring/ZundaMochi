<div class="plugin-main-status">
有効化
    すべて (<?php echo count($plugins)?>) |
    使用中 (2) |
    停止中 (1)
</div>
インストールされているプラグインを検索:
一括操作を選択
3項目
<hr>

<?php foreach($plugins as $name => $json):?>
<div>
name : <?php echo $name?><br>
version: <?php echo $json->version?><br>
author: <?php echo $json->author?><br>
<?php if($json->is_activate):?>
	<a href="<?php echo Cake\Routing\Router::url('/')?>mochi/deacvivate_plugin/<?php echo $name?>">無効化</a>
<?php else:?>
	<a href="<?php echo Cake\Routing\Router::url('/')?>mochi/acvivate_plugin/<?php echo $name?>">有効化</a>
<?php endif?>

編集
削除
</div>
<hr>
<?php endforeach; ?>
