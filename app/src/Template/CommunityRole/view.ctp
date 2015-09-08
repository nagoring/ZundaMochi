<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Community Role'), ['action' => 'edit', $communityRole->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Community Role'), ['action' => 'delete', $communityRole->id], ['confirm' => __('Are you sure you want to delete # {0}?', $communityRole->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Community Role'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Community Role'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Members'), ['controller' => 'Members', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Member'), ['controller' => 'Members', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Role Permission'), ['controller' => 'RolePermission', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role Permission'), ['controller' => 'RolePermission', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="communityRole view large-10 medium-9 columns">
    <h2><?= h($communityRole->name) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Name') ?></h6>
            <p><?= h($communityRole->name) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($communityRole->id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created At') ?></h6>
            <p><?= h($communityRole->created_at) ?></p>
            <h6 class="subheader"><?= __('Modified At') ?></h6>
            <p><?= h($communityRole->modified_at) ?></p>
        </div>
        <div class="large-2 columns booleans end">
            <h6 class="subheader"><?= __('System Flag') ?></h6>
            <p><?= $communityRole->system_flag ? __('Yes') : __('No'); ?></p>
        </div>
    </div>
</div>
<div class="related">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Members') ?></h4>
    <?php if (!empty($communityRole->members)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Community Id') ?></th>
            <th><?= __('User Id') ?></th>
            <th><?= __('Community Role Id') ?></th>
            <th><?= __('Notice Flag') ?></th>
            <th><?= __('Modified At') ?></th>
            <th><?= __('Created At') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($communityRole->members as $members): ?>
        <tr>
            <td><?= h($members->id) ?></td>
            <td><?= h($members->community_id) ?></td>
            <td><?= h($members->user_id) ?></td>
            <td><?= h($members->community_role_id) ?></td>
            <td><?= h($members->notice_flag) ?></td>
            <td><?= h($members->modified_at) ?></td>
            <td><?= h($members->created_at) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Members', 'action' => 'view', $members->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Members', 'action' => 'edit', $members->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Members', 'action' => 'delete', $members->id], ['confirm' => __('Are you sure you want to delete # {0}?', $members->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Role Permission') ?></h4>
    <?php if (!empty($communityRole->role_permission)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Community Role Id') ?></th>
            <th><?= __('Community Permission Id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($communityRole->role_permission as $rolePermission): ?>
        <tr>
            <td><?= h($rolePermission->community_role_id) ?></td>
            <td><?= h($rolePermission->community_permission_id) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'RolePermission', 'action' => 'view', $rolePermission->]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'RolePermission', 'action' => 'edit', $rolePermission->]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'RolePermission', 'action' => 'delete', $rolePermission->], ['confirm' => __('Are you sure you want to delete # {0}?', $rolePermission->)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
