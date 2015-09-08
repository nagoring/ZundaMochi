<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Community Permission'), ['action' => 'edit', $communityPermission->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Community Permission'), ['action' => 'delete', $communityPermission->id], ['confirm' => __('Are you sure you want to delete # {0}?', $communityPermission->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Community Permission'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Community Permission'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="communityPermission view large-10 medium-9 columns">
    <h2><?= h($communityPermission->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Permission Str') ?></h6>
            <p><?= h($communityPermission->permission_str) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($communityPermission->id) ?></p>
            <h6 class="subheader"><?= __('Role Id') ?></h6>
            <p><?= $this->Number->format($communityPermission->role_id) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Note') ?></h6>
            <?= $this->Text->autoParagraph(h($communityPermission->note)) ?>
        </div>
    </div>
</div>
