<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $communityComment->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $communityComment->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Community Comments'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="communityComments form large-9 medium-8 columns content">
    <?= $this->Form->create($communityComment) ?>
    <fieldset>
        <legend><?= __('Edit Community Comment') ?></legend>
        <?php
            echo $this->Form->input('thread_id');
            echo $this->Form->input('body');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
