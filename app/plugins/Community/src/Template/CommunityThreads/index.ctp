<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Community Thread'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Communities'), ['controller' => 'Communities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Community'), ['controller' => 'Communities', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="communityThreads index large-9 medium-8 columns content">
    <h3><?= __('Community Threads') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('community_id') ?></th>
                <th><?= $this->Paginator->sort('title') ?></th>
                <th><?= $this->Paginator->sort('publish') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($communityThreads as $communityThread): ?>
            <tr>
                <td><?= $this->Number->format($communityThread->id) ?></td>
                <td><?= $communityThread->has('community') ? $this->Html->link($communityThread->community->title, ['controller' => 'Communities', 'action' => 'view', $communityThread->community->id]) : '' ?></td>
                <td><?= h($communityThread->title) ?></td>
                <td><?= $this->Number->format($communityThread->publish) ?></td>
                <td><?= h($communityThread->modified) ?></td>
                <td><?= h($communityThread->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $communityThread->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $communityThread->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $communityThread->id], ['confirm' => __('Are you sure you want to delete # {0}?', $communityThread->id)]) ?>
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
