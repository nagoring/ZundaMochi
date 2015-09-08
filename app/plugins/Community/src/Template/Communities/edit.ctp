<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $community->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $community->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Communities'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="communities form large-10 medium-9 columns">
    <?= $this->Form->create($community) ?>
    <fieldset>
        <legend><?= __('Edit Community') ?></legend>
        <?php
            echo $this->Form->input('publish');
            echo $this->Form->input('title');
            echo $this->Form->input('body');
            echo $this->Form->input('thumbnail');
            echo $this->Form->input('status');
            echo $this->Form->input('status_name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>