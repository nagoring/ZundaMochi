<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Communities'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="communities form large-10 medium-9 columns">
    <?= $this->Form->create($community, ['enctype' => 'multipart/form-data']) ?>
    <fieldset>
        <legend><?= __('Add Community') ?></legend>
        <?php
            echo $this->Form->input('title');
            echo $this->Form->input('body');
            echo $this->Form->file('thumbnail',['accept' => 'image/png,image/jpeg,image/gif']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
