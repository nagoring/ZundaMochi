<?php
namespace Community\Controller;

use App\Controller\AppController;

/**
 * CommunityThreads Controller
 *
 * @property \App\Model\Table\CommunityThreadsTable $CommunityThreads
 */
class CommunityThreadsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('communityThreads', $this->paginate($this->CommunityThreads));
        $this->set('_serialize', ['communityThreads']);
    }

    /**
     * View method
     *
     * @param string|null $id Community Thread id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $communityThread = $this->CommunityThreads->get($id, [
            'contain' => []
        ]);
        $this->set('communityThread', $communityThread);
        $this->set('_serialize', ['communityThread']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $communityThread = $this->CommunityThreads->newEntity();
        if ($this->request->is('post')) {
            $communityThread = $this->CommunityThreads->patchEntity($communityThread, $this->request->data);
            if ($this->CommunityThreads->save($communityThread)) {
                $this->Flash->success(__('The community thread has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The community thread could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('communityThread'));
        $this->set('_serialize', ['communityThread']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Community Thread id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $communityThread = $this->CommunityThreads->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $communityThread = $this->CommunityThreads->patchEntity($communityThread, $this->request->data);
            if ($this->CommunityThreads->save($communityThread)) {
                $this->Flash->success(__('The community thread has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The community thread could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('communityThread'));
        $this->set('_serialize', ['communityThread']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Community Thread id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $communityThread = $this->CommunityThreads->get($id);
        if ($this->CommunityThreads->delete($communityThread)) {
            $this->Flash->success(__('The community thread has been deleted.'));
        } else {
            $this->Flash->error(__('The community thread could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
