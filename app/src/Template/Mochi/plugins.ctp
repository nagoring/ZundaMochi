有効化
    すべて (3) |
    使用中 (2) |
    停止中 (1)
インストールされているプラグインを検索:
一括操作を選択
3項目

<?php foreach($plugins as $name => $json):?>
name : <?php echo $name?><br>
version: <?php echo $json->version?><br>
author: <?php echo $json->author?><br>
<a href="<?php echo Cake\Routing\Router::url('/')?>mochi/acvivate_plugin/<?php echo $name?>">有効化</a>

編集
削除

<?php endforeach; ?>