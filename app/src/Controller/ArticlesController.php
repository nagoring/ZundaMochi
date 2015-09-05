<?php

namespace App\Controller;
use Cake\Utility\Security;

/**
 * Description of ArticlesController
 *
 * @author nagomi
 */
class ArticlesController extends AppController {
	protected $layout = 'mochi';
//	public function index() {
//		$articles = $this->Articles->find('all');
//		var_dump(compact($articles));
//		$this->set('articles', $articles);
//		$this->set(compact('articles'));
//	}

//	public function view($id = null) {
//		if (!$id) {
//			throw new NotFoundException(__('Invalid article'));
//		}
//		$article = $this->Articles->get($id);
//		$this->set('article', $article);
//	}

//	public function add() {
//		$article = $this->Articles->newEntity($this->request->data);
//		if ($this->request->is('post')) {
//			clearstatcache();
//			$image = new \stdClass();
//			$image->file = $this->request->data['file1'];
//			$image->filename = Security::hash($image->file['name'], 'md5');
//			$image->size = $image->file['size'];
//			$image->tmpName = $image->file['tmp_name'];
//			//TODOファイルサイズチェック
//			$image->info = getimagesize($image->tmpName);
//			$image->ext = $this->Image->getExtenstion($image);
//			
//			$image->filedir = WWW_ROOT . 'i' . DS ;
////    function create_image($image, $filename, $quality = 75) {
//			$this->Image->image($image);
//			//TODOarticle_imageに入れるためのロジックを書きます！
//			
//			$article->user_id = $this->Auth->user('id');
//			if ($this->Articles->save($article)) {
//				$this->Flash->success(__('Your article has been saved.'));
//				return $this->redirect(['action' => 'index']);
//			}
//			$this->Flash->error(__('Unable to add your article.'));
//		}
//		$this->set('article', $article);
//
//		// Just added the categories list to be able to choose
//		// one category for an article
//		$categories = $this->Articles->Categories->find('treeList');
//		$this->set(compact('categories'));
//	}

//	public function edit($id = null) {
//		if (!$id) {
//			throw new NotFoundException(__('Invalid article'));
//		}
//		$article = $this->Articles->get($id);
//		if ($this->request->is(['post', 'put'])) {
//			$this->Articles->patchEntity($article, $this->request->data);
//			if ($this->Articles->save($article)) {
//				$this->Flash->success(__('Your article has been updated.'));
//				return $this->redirect(['action' => 'index']);
//			}
//			$this->Flash->error(__('Unable to update your article.'));
//		}
//		$this->set('article', $article);
//	}

//	public function delete($id) {
//		$this->request->allowMethod(['post', 'delete']);
//
//		$article = $this->Articles->get($id);
//		if ($this->Articles->delete($article)) {
//			$this->Flash->success(__('The article with id: {0} has been deleted.', h($id)));
//			return $this->redirect(['action' => 'index']);
//		}
//	}

	public function isAuthorized($user) {
		// All registered users can add articles
		if ($this->request->action === 'add') {
			return true;
		}

		// The owner of an article can edit and delete it
		if (in_array($this->request->action, ['edit', 'delete'])) {
			$articleId = (int) $this->request->params['pass'][0];
			if ($this->Articles->isOwnedBy($articleId, $user['id'])) {
				return true;
			}
		}

		return parent::isAuthorized($user);
	}

}
