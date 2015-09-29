<?php
namespace Community\Controller;

use App\Controller\AppController;

/**
 * CommunityComments Controller
 *
 * @property \App\Model\Table\CommunityCommentsTable $CommunityComments
 */
class CommunityCommentsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('communityComments', $this->paginate($this->CommunityComments));
        $this->set('_serialize', ['communityComments']);
    }

    /**
     * View method
     *
     * @param string|null $id Community Comment id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $communityComment = $this->CommunityComments->get($id, [
            'contain' => []
        ]);
        $this->set('communityComment', $communityComment);
        $this->set('_serialize', ['communityComment']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $communityComment = $this->CommunityComments->newEntity();
        if ($this->request->is('post')) {
            $communityComment = $this->CommunityComments->patchEntity($communityComment, $this->request->data);
            if ($this->CommunityComments->save($communityComment)) {
                $this->Flash->success(__('The community comment has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The community comment could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('communityComment'));
        $this->set('_serialize', ['communityComment']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Community Comment id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $communityComment = $this->CommunityComments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $communityComment = $this->CommunityComments->patchEntity($communityComment, $this->request->data);
            if ($this->CommunityComments->save($communityComment)) {
                $this->Flash->success(__('The community comment has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The community comment could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('communityComment'));
        $this->set('_serialize', ['communityComment']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Community Comment id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $communityComment = $this->CommunityComments->get($id);
        if ($this->CommunityComments->delete($communityComment)) {
            $this->Flash->success(__('The community comment has been deleted.'));
        } else {
            $this->Flash->error(__('The community comment could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
