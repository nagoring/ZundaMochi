
<div class="users form">
<?= $this->Form->create($user) ?>
		<?php if($add_real_url):?>
		<a href="<?php echo $add_real_url?>"><?php echo $add_real_url?></a><br>
		<?php endif?>
    <fieldset>
        <legend><?= __('ユーザー登録') ?></legend>
		<label>メールアドレスを入力して下さい</label>
        <?php echo  $this->Form->input('email', ['label' => '']) ?>
        <?php // echo  $this->Form->input('username') ?>
        <?php // echo  $this->Form->input('password') ?>
   </fieldset>
<?= $this->Form->button(__('仮登録')); ?>
<?= $this->Form->end() ?>
	<div class="row">
<pre>
仮登録を行うと入力したメールアドレスにメールが届きます。
メールアドレスにURLが記載されているのでクリックして下さい。
URLが途切れている場合はコピーして直接URLをブラウザに貼り付けてください。
※現在メールは送られないので仮登録後のURLをクリックして下さい。
</pre>
	</div>
</div>
