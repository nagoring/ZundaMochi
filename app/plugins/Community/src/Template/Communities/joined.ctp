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
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($communityMembers as $communityMember): ?>
        <tr>
            <td>
				<a href="/m/co<?= $communityMember->community->id ?>"><img src="<?= $communityMember->community->img_url?>"></a>
			</td>
            <td><?= $this->Number->format($communityMember->community->id) ?></td>
            <td><?= h($communityMember->community->title) ?></td>
            <td class="actions">
				<a href="/m/co<?= $communityMember->community->id ?>">View</a>
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
