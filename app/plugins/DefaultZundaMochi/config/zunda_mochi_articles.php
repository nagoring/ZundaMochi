<?php

use Cake\Utility\Security;
use Cake\ORM\TableRegistry;


$viewClass = '\\DefaultZundaMochi\\View\\HookView';
$group = 'App\Controller\ArticlesController';
$action = 'add';
$index = 100;
\CakeHook\Hook::addAction($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	/* @var $ctrl App\Controller\ArticlesController */
	$param = $state->getParam();
	$ctrl = $state->getThis();
	$ctrl->viewClass = $viewClass;

	if ($ctrl->request->is('post')) {
		clearstatcache();
		if (isset($ctrl->request->data['file1']) && $ctrl->request->data['file1']['tmp_name']) {
			$image = new \stdClass();
			$image->file = $ctrl->request->data['file1'];
			$image->filename = Security::hash($image->file['name'], 'md5');
			$image->size = $image->file['size'];
			$image->tmpName = $image->file['tmp_name'];
			//TODOファイルサイズチェック
			$image->info = getimagesize($image->tmpName);
			$image->ext = $ctrl->Image->getExtenstion($image);

			$image->filedir = WWW_ROOT . 'i' . DS;
//    function create_image($image, $filename, $quality = 75) {
			$ctrl->Image->image($image);
			//TODOarticle_imageに入れるためのロジックを書きます！
		}

		$articlesTable = TableRegistry::get('Articles');
		$article = $articlesTable->newEntity($ctrl->request->data);
		$article->user_id = $ctrl->Auth->user('id');
		
		if ($ctrl->Articles->save($article)) {
			$ctrl->Flash->success(__('Your article has been saved.'));
			return $ctrl->redirect(['action' => 'index']);
		}
		$ctrl->Flash->error(__('Unable to add your article.'));
	}
	$ctrl->set('article', $article);

	// Just added the categories list to be able to choose
	// one category for an article
	$categories = $ctrl->Articles->Categories->find('treeList');
	$ctrl->set(compact('categories'));
});


$action = 'edit';
$index = 100;
\CakeHook\Hook::addAction($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	$param = $state->getParam();
	$ctrl = $state->getThis();
	$args = $param['pass'];
	if (count($args) === 0) {
		throw new NotFoundException(__('Invalid article'));
	}
	$ctrl->viewClass = $viewClass;
	$id = $args[0];
	$article = $ctrl->Articles->get($id);
	if ($ctrl->request->is(['post', 'put'])) {
		$ctrl->Articles->patchEntity($article, $ctrl->request->data);
		if ($ctrl->Articles->save($article)) {
			$ctrl->Flash->success(__('Your article has been updated.'));
			return $ctrl->redirect(['action' => 'index']);
		}
		$ctrl->Flash->error(__('Unable to update your article.'));
	}
	$ctrl->set('article', $article);
});

$action = 'view';
$index = 100;
\CakeHook\Hook::addAction($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	$param = $state->getParam();
	$ctrl = $state->getThis();
	$args = $param['pass'];
	if (count($args) === 0) {
		throw new NotFoundException(__('Invalid article'));
	}
	$ctrl->viewClass = $viewClass;
	$id = $args[0];
	$article = $ctrl->Articles->get($id);
	$ctrl->set('article', $article);
});

$action = 'index';
$index = 100;
CakeHook\Hook::addAction($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	$ctrl = $state->getThis();
	$ctrl->viewClass = $viewClass;
	$user_id = $ctrl->Auth->user('id');
	$articles = $ctrl->Articles->find()->where(['Articles.user_id' => $user_id]);
	$ctrl->set(compact('articles'));
});

$action = 'delete';
$index = 100;
CakeHook\Hook::addAction($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	$ctrl = $state->getThis();
	$args = $state->getArgs();
	$id = $args[0];
	$ctrl->viewClass = $viewClass;
	$ctrl->request->allowMethod(['post', 'delete']);
	$article = $ctrl->Articles->get($id);
	if ($ctrl->Articles->delete($article)) {
		$ctrl->Flash->success(__('The article with id: {0} has been deleted.', h($id)));
		return $ctrl->redirect(['action' => 'index']);
	}
	
});

$action = 'aaa';
$index = 100;
CakeHook\Hook::addAction($group, $action, $index, function(\CakeHook\State $state) use($viewClass) {
	$ctrl = $state->getThis();
	$ctrl->viewClass = $viewClass;
	$articles = $ctrl->Articles->find('all');
	$ctrl->set(compact('articles'));
});

