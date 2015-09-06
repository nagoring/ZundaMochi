<h1>Add Article</h1>
<?php
echo $this->Form->create($article, ['type' => 'file']);
// just added the categories input
echo $this->Form->input('categories');
echo $this->Form->input('title');
echo $this->Form->input('body', ['rows' => '3']);
echo $this->Form->input('file1', ['type' => 'file', 'between' => '<br>']);
echo $this->Form->input('file2', ['type' => 'file', 'between' => '<br>']);
echo $this->Form->input('file3', ['type' => 'file', 'between' => '<br>']);
echo $this->Form->button(__('Save Article'));
echo $this->Form->end();