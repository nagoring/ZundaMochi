<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Community Member'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Communities'), ['controller' => 'Communities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Community'), ['controller' => 'Communities', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="communityMembers index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('community_id') ?></th>
            <th><?= $this->Paginator->sort('user_id') ?></th>
            <th><?= $this->Paginator->sort('community_role_id') ?></th>
            <th><?= $this->Paginator->sort('modified_at') ?></th>
            <th><?= $this->Paginator->sort('created_at') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($communityMembers as $communityMember): ?>
        <tr>
            <td><?= $this->Number->format($communityMember->id) ?></td>
            <td>
                <?= $communityMember->has('community') ? $this->Html->link($communityMember->community->title, ['controller' => 'Communities', 'action' => 'view', $communityMember->community->id]) : '' ?>
            </td>
            <td>
                <?= $communityMember->has('user') ? $this->Html->link($communityMember->user->id, ['controller' => 'Users', 'action' => 'view', $communityMember->user->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($communityMember->community_role_id) ?></td>
            <td><?= $this->Number->format($communityMember->modified_at) ?></td>
            <td><?= $this->Number->format($communityMember->created_at) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $communityMember->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $communityMember->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $communityMember->id], ['confirm' => __('Are you sure you want to delete # {0}?', $communityMember->id)]) ?>
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
