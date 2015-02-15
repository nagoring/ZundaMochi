<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Article Image'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articles'), ['controller' => 'Articles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Article'), ['controller' => 'Articles', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="articleImages index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('article_id') ?></th>
            <th><?= $this->Paginator->sort('user_id') ?></th>
            <th><?= $this->Paginator->sort('filename') ?></th>
            <th><?= $this->Paginator->sort('index') ?></th>
            <th><?= $this->Paginator->sort('created') ?></th>
            <th><?= $this->Paginator->sort('modified') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($articleImages as $articleImage): ?>
        <tr>
            <td><?= $this->Number->format($articleImage->id) ?></td>
            <td>
                <?= $articleImage->has('article') ? $this->Html->link($articleImage->article->title, ['controller' => 'Articles', 'action' => 'view', $articleImage->article->id]) : '' ?>
            </td>
            <td>
                <?= $articleImage->has('user') ? $this->Html->link($articleImage->user->id, ['controller' => 'Users', 'action' => 'view', $articleImage->user->id]) : '' ?>
            </td>
            <td><?= h($articleImage->filename) ?></td>
            <td><?= $this->Number->format($articleImage->index) ?></td>
            <td><?= h($articleImage->created) ?></td>
            <td><?= h($articleImage->modified) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $articleImage->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $articleImage->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $articleImage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $articleImage->id)]) ?>
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
