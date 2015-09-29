<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Community Comment'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="communityComments index large-9 medium-8 columns content">
    <h3><?= __('Community Comments') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('thread_id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($communityComments as $communityComment): ?>
            <tr>
                <td><?= $this->Number->format($communityComment->id) ?></td>
                <td><?= $this->Number->format($communityComment->thread_id) ?></td>
                <td><?= h($communityComment->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $communityComment->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $communityComment->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $communityComment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $communityComment->id)]) ?>
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
