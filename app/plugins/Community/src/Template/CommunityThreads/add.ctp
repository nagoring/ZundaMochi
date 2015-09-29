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
        <?php
            echo $this->Form->input('community_id', ['options' => $communities]);
            echo $this->Form->input('title');
            echo $this->Form->input('body');
            echo $this->Form->input('publish');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
