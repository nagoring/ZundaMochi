<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Community Member'), ['action' => 'edit', $communityMember->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Community Member'), ['action' => 'delete', $communityMember->id], ['confirm' => __('Are you sure you want to delete # {0}?', $communityMember->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Community Members'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Community Member'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Communities'), ['controller' => 'Communities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Community'), ['controller' => 'Communities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="communityMembers view large-10 medium-9 columns">
    <h2><?= h($communityMember->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Community') ?></h6>
            <p><?= $communityMember->has('community') ? $this->Html->link($communityMember->community->title, ['controller' => 'Communities', 'action' => 'view', $communityMember->community->id]) : '' ?></p>
            <h6 class="subheader"><?= __('User') ?></h6>
            <p><?= $communityMember->has('user') ? $this->Html->link($communityMember->user->id, ['controller' => 'Users', 'action' => 'view', $communityMember->user->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($communityMember->id) ?></p>
            <h6 class="subheader"><?= __('Community Role Id') ?></h6>
            <p><?= $this->Number->format($communityMember->community_role_id) ?></p>
            <h6 class="subheader"><?= __('Modified At') ?></h6>
            <p><?= $this->Number->format($communityMember->modified_at) ?></p>
            <h6 class="subheader"><?= __('Created At') ?></h6>
            <p><?= $this->Number->format($communityMember->created_at) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Notice Flag') ?></h6>
            <?= $this->Text->autoParagraph(h($communityMember->notice_flag)) ?>
        </div>
    </div>
</div>
