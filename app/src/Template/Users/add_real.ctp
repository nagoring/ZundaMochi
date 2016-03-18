
<div class="users form">
<?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('ユーザー登録') ?></legend>
		<label>ニックネームを入力して下さい</label>
        <?php echo  $this->Form->input('nickname', ['nickname' => '']) ?>
		<label>パスワードを入力して下さい</label>
        <?php echo  $this->Form->input('password') ?>
		<label>確認用です。同一のパスワードを入力して下さい</label>
        <?php echo  $this->Form->input('password_confirm',[
			'type' => 'password',
			'required' => 'required',
		]) ?>
        <?php echo  $this->Form->hidden('hash', ['value' => $hash]) ?>
   </fieldset>
<?= $this->Form->button(__('登録')); ?>
<?= $this->Form->end() ?>
	<div class="row">
	</div>
</div>
<script>
	(function(){
		var password = document.getElementById('password').value;
		var password_confirm = document.getElementById('password-confirm').value;
		console.log(password);
		console.log(password_confirm);
	}());
</script>