<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ArticleImages Controller
 *
 * @property \App\Model\Table\ArticleImagesTable $ArticleImages
 */
class ArticleImagesController extends UsersAppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Articles', 'Users']
        ];
        $this->set('articleImages', $this->paginate($this->ArticleImages));
        $this->set('_serialize', ['articleImages']);
    }

    /**
     * View method
     *
     * @param string|null $id Article Image id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $articleImage = $this->ArticleImages->get($id, [
            'contain' => ['Articles', 'Users']
        ]);
        $this->set('articleImage', $articleImage);
        $this->set('_serialize', ['articleImage']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $articleImage = $this->ArticleImages->newEntity();
        if ($this->request->is('post')) {
            $articleImage = $this->ArticleImages->patchEntity($articleImage, $this->request->data);
            if ($this->ArticleImages->save($articleImage)) {
                $this->Flash->success('The article image has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The article image could not be saved. Please, try again.');
            }
        }
        $articles = $this->ArticleImages->Articles->find('list', ['limit' => 200]);
        $users = $this->ArticleImages->Users->find('list', ['limit' => 200]);
        $this->set(compact('articleImage', 'articles', 'users'));
        $this->set('_serialize', ['articleImage']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Article Image id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $articleImage = $this->ArticleImages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $articleImage = $this->ArticleImages->patchEntity($articleImage, $this->request->data);
            if ($this->ArticleImages->save($articleImage)) {
                $this->Flash->success('The article image has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The article image could not be saved. Please, try again.');
            }
        }
        $articles = $this->ArticleImages->Articles->find('list', ['limit' => 200]);
        $users = $this->ArticleImages->Users->find('list', ['limit' => 200]);
        $this->set(compact('articleImage', 'articles', 'users'));
        $this->set('_serialize', ['articleImage']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Article Image id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $articleImage = $this->ArticleImages->get($id);
        if ($this->ArticleImages->delete($articleImage)) {
            $this->Flash->success('The article image has been deleted.');
        } else {
            $this->Flash->error('The article image could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
