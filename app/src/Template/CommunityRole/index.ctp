<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Community Role'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Members'), ['controller' => 'Members', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Member'), ['controller' => 'Members', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Role Permission'), ['controller' => 'RolePermission', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role Permission'), ['controller' => 'RolePermission', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="communityRole index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('name') ?></th>
            <th><?= $this->Paginator->sort('system_flag') ?></th>
            <th><?= $this->Paginator->sort('created_at') ?></th>
            <th><?= $this->Paginator->sort('modified_at') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($communityRole as $communityRole): ?>
        <tr>
            <td><?= $this->Number->format($communityRole->id) ?></td>
            <td><?= h($communityRole->name) ?></td>
            <td><?= h($communityRole->system_flag) ?></td>
            <td><?= h($communityRole->created_at) ?></td>
            <td><?= h($communityRole->modified_at) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $communityRole->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $communityRole->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $communityRole->id], ['confirm' => __('Are you sure you want to delete # {0}?', $communityRole->id)]) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
