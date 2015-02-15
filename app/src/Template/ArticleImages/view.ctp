<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Article Image'), ['action' => 'edit', $articleImage->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Article Image'), ['action' => 'delete', $articleImage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $articleImage->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Article Images'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Article Image'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articles'), ['controller' => 'Articles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Article'), ['controller' => 'Articles', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="articleImages view large-10 medium-9 columns">
    <h2><?= h($articleImage->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Article') ?></h6>
            <p><?= $articleImage->has('article') ? $this->Html->link($articleImage->article->title, ['controller' => 'Articles', 'action' => 'view', $articleImage->article->id]) : '' ?></p>
            <h6 class="subheader"><?= __('User') ?></h6>
            <p><?= $articleImage->has('user') ? $this->Html->link($articleImage->user->id, ['controller' => 'Users', 'action' => 'view', $articleImage->user->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Filename') ?></h6>
            <p><?= h($articleImage->filename) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($articleImage->id) ?></p>
            <h6 class="subheader"><?= __('Index') ?></h6>
            <p><?= $this->Number->format($articleImage->index) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created') ?></h6>
            <p><?= h($articleImage->created) ?></p>
            <h6 class="subheader"><?= __('Modified') ?></h6>
            <p><?= h($articleImage->modified) ?></p>
        </div>
    </div>
</div>
