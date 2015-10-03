<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Community Threads'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Communities'), ['controller' => 'Communities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Community'), ['controller' => 'Communities', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="communityThreads form large-9 medium-8 columns content">
    <?= $this->Form->create($communityThread) ?>
    <fieldset>
        <legend><?= __('Add Community Thread') ?></legend>
		<h3>コミュニティ<?php echo $community->title?>にスレッドを立てます</h3>
        <?php
//            echo $this->Form->input('community_id', ['options' => $communities]);
            echo $this->Form->input('title');
            echo $this->Form->input('body');
            echo $this->Form->select('publish', [
				'Web' => 'Web全体に公開',
				'SNS' => 'SNS内のみ公開', 
				'Community' => 'Community内のみ公開'
			]);
        ?>
    </fieldset>
	
    <?= $this->Form->hidden('community_id', ['value' => $community->id]) ?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
