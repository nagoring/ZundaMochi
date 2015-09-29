<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Community Comment'), ['action' => 'edit', $communityComment->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Community Comment'), ['action' => 'delete', $communityComment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $communityComment->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Community Comments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Community Comment'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="communityComments view large-9 medium-8 columns content">
    <h3><?= h($communityComment->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($communityComment->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Thread Id') ?></th>
            <td><?= $this->Number->format($communityComment->thread_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($communityComment->created) ?></tr>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Body') ?></h4>
        <?= $this->Text->autoParagraph(h($communityComment->body)); ?>
    </div>
</div>
