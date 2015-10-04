<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><a href="/m/co<?=$communityThread->community_id?>">コミュニティトップ</a> </li>
        <li><?= $this->Html->link(__('Edit Community Thread'), ['action' => 'edit', $communityThread->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Community Thread'), ['action' => 'delete', $communityThread->id], ['confirm' => __('Are you sure you want to delete # {0}?', $communityThread->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Community Threads'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Community Thread'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Communities'), ['controller' => 'Communities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Community'), ['controller' => 'Communities', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="communityThreads view large-9 medium-8 columns content">
    <h3><?= h($communityThread->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Community') ?></th>
            <td><?= $communityThread->has('community') ? $this->Html->link($communityThread->community->title, ['controller' => 'Communities', 'action' => 'view', $communityThread->community->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Title') ?></th>
            <td><?= h($communityThread->title) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($communityThread->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Publish') ?></th>
            <td><?= $this->Number->format($communityThread->publish) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($communityThread->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($communityThread->created) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('スレッド') ?></h4>
        <?= $this->Text->autoParagraph(h($communityThread->body)); ?>
    </div>
</div>
<div class="communityComments form large-9 medium-8 columns content">
		<h4><?= __('コメント') ?></h4>
		<?php foreach($communityCommentEntities as $communityCommentEntity):?>
			<div class="row">
			<?= h($communityCommentEntity->created) ?>
			<?= h($communityCommentEntity->title) ?>
			<?= h($communityCommentEntity->body) ?>
			</div>
		<?php endforeach; ?>
	<h4><?= __('コメントを書く') ?></h4>
    <fieldset>
		<?= $this->Form->create($communityCommentEntities, [
			'type' => 'post',
			'url' => '/community/community_comments/add',
		])?>
		<?= $this->Form->textarea('body')?>
		<?= $this->Form->hidden('community_thread_id', ['value' => $communityThread->id]) ?>
		<?= $this->Form->hidden('community_id', ['value' => $communityThread->community_id]) ?>
		<?= $this->Form->button(__('コメントする')) ?>
		<?= $this->Form->end()?>
	</fieldset>
	
</div>


	