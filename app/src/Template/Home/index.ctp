<h1>スカゼミで勉強しよう ネット勉強会を開こう </h1>
<pre>
共に学べる仲間に出会えるネット勉強会SNS「スカゼミ」です。スカイプ上でプログラミグ、数学、英語、資格などの勉強会を行っています。
</pre>
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
