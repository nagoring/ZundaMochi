<div class="actions columns large-4 medium-5">
    <h3>退会画面</h3>
	<div class="row">
		このコミュニティから退会しますが宜しいですか？
    <?= $this->Form->create($community, ['url' => '/community/communities/resign']) ?>
	<?= $this->Form->hidden('id')?>
	<?= $this->Form->hidden('hoge', ['value' => 'foobar'])?>
    <?= $this->Form->submit(__('Submit')) ?>
    <?= $this->Form->end() ?>		
	</div>
</div>
