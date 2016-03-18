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
            <th>gazo</th>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('title') ?></th>
            <th><?= $this->Paginator->sort('body') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($communities as $community): ?>
        <tr>
            <td><a href="/m/co<?= $community->id ?>"><img src="<?= $community->img_url?>"></a></td>
            <td><?= $this->Number->format($community->id) ?></td>
            <td><?= h($community->title) ?></td>
            <td><?= mb_substr(h($community->body), 0, 255); ?></td>
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
