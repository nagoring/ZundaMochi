<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Community'), ['action' => 'edit', $community->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Community'), ['action' => 'delete', $community->id], ['confirm' => __('Are you sure you want to delete # {0}?', $community->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Communities'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Community'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="communities view large-10 medium-9 columns">
    <h2><?= h($community->title) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Title') ?></h6>
            <p><?= h($community->title) ?></p>
            <h6 class="subheader"><?= __('Thumbnail') ?></h6>
            <p><?= h($community->thumbnail) ?></p>
            <h6 class="subheader"><?= __('Status Name') ?></h6>
            <p><?= h($community->status_name) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($community->id) ?></p>
            <h6 class="subheader"><?= __('Publish') ?></h6>
            <p><?= $this->Number->format($community->publish) ?></p>
            <h6 class="subheader"><?= __('Status') ?></h6>
            <p><?= $this->Number->format($community->status) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Modified') ?></h6>
            <p><?= h($community->modified) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Body') ?></h6>
            <?= $this->Text->autoParagraph(h($community->body)) ?>
        </div>
    </div>
	<div class="row">
		<?php if($is_joined_community):?>
			<p>このコミュニティに参加しています</p>
			<p>
				<a href="/community/communities/quit/<?= $community->id?>">このコミュニティから退会します</a>
			</p>
		<?php else:?>
			<a href="/community/communities/join/<?= $community->id?>">このコミュニティに参加する</a>
		<?php endif?>
	</div>
</div>
