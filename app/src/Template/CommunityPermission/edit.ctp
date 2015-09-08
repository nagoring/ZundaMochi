<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $communityPermission->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $communityPermission->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Community Permission'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="communityPermission form large-10 medium-9 columns">
    <?= $this->Form->create($communityPermission) ?>
    <fieldset>
        <legend><?= __('Edit Community Permission') ?></legend>
        <?php
            echo $this->Form->input('role_id');
            echo $this->Form->input('note');
            echo $this->Form->input('permission_str');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
