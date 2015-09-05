<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Community'), ['action' => 'add']) ?></li>
    </ul>
</div>
<div class="communities index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('publish') ?></th>
            <th><?= $this->Paginator->sort('title') ?></th>
            <th><?= $this->Paginator->sort('thumbnail') ?></th>
            <th><?= $this->Paginator->sort('status') ?></th>
            <th><?= $this->Paginator->sort('status_name') ?></th>
            <th><?= $this->Paginator->sort('modified') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($communities as $community): ?>
        <tr>
            <td><?= $this->Number->format($community->id) ?></td>
            <td><?= $this->Number->format($community->publish) ?></td>
            <td><?= h($community->title) ?></td>
            <td><?= h($community->thumbnail) ?></td>
            <td><?= $this->Number->format($community->status) ?></td>
            <td><?= h($community->status_name) ?></td>
            <td><?= h($community->modified) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $community->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $community->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $community->id], ['confirm' => __('Are you sure you want to delete # {0}?', $community->id)]) ?>
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
