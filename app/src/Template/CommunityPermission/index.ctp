<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Community Permission'), ['action' => 'add']) ?></li>
    </ul>
</div>
<div class="communityPermission index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('role_id') ?></th>
            <th><?= $this->Paginator->sort('permission_str') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($communityPermission as $communityPermission): ?>
        <tr>
            <td><?= $this->Number->format($communityPermission->id) ?></td>
            <td><?= $this->Number->format($communityPermission->role_id) ?></td>
            <td><?= h($communityPermission->permission_str) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $communityPermission->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $communityPermission->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $communityPermission->id], ['confirm' => __('Are you sure you want to delete # {0}?', $communityPermission->id)]) ?>
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
