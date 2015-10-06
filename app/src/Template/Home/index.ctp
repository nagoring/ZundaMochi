<h1>スカゼミ</h1>

<h2>コミュニティ一覧</h2>

<div class="row">
<?php foreach($communities as $community):?>
	<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
		<img src="<?= h($community->img_url)?>" /><br><?= h($community->title)?>
	</div>
<?php endforeach; ?>
</div>

<h2>スレッド一覧</h2>
<?php foreach($communityThreads as $communityThread):?>
	<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
		<?= h($communityThread->title)?>
	</div>
<?php endforeach?>
