<div class="users form">
<?= $this->Flash->render('auth') ?>
<?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('メールアドレスとパスワードを入力してログインして下さい。') ?></legend>
		<label>メールアドレス</label>
        <?= $this->Form->input('username', [
			'label' => ''
		]) ?>
		<label>パスワード</label>
        <?= $this->Form->input('password', [
			'label' => ''
		]) ?>
    </fieldset>
<?= $this->Form->button(__('Login')); ?>
<?= $this->Form->end() ?>
</div>