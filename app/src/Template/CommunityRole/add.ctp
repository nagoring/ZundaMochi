<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Community Role'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Members'), ['controller' => 'Members', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Member'), ['controller' => 'Members', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Role Permission'), ['controller' => 'RolePermission', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role Permission'), ['controller' => 'RolePermission', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="communityRole form large-10 medium-9 columns">
    <?= $this->Form->create($communityRole) ?>
    <fieldset>
        <legend><?= __('Add Community Role') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('system_flag');
            echo $this->Form->input('created_at');
            echo $this->Form->input('modified_at');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
