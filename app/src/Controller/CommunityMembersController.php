<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CommunityMembers Controller
 *
 * @property \App\Model\Table\CommunityMembersTable $CommunityMembers
 */
class CommunityMembersController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('communityMembers', $this->paginate($this->CommunityMembers));
        $this->set('_serialize', ['communityMembers']);
    }

    /**
     * View method
     *
     * @param string|null $id Community Member id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $communityMember = $this->CommunityMembers->get($id, [
            'contain' => []
        ]);
        $this->set('communityMember', $communityMember);
        $this->set('_serialize', ['communityMember']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $communityMember = $this->CommunityMembers->newEntity();
        if ($this->request->is('post')) {
            $communityMember = $this->CommunityMembers->patchEntity($communityMember, $this->request->data);
            if ($this->CommunityMembers->save($communityMember)) {
                $this->Flash->success(__('The community member has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The community member could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('communityMember'));
        $this->set('_serialize', ['communityMember']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Community Member id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $communityMember = $this->CommunityMembers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $communityMember = $this->CommunityMembers->patchEntity($communityMember, $this->request->data);
            if ($this->CommunityMembers->save($communityMember)) {
                $this->Flash->success(__('The community member has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The community member could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('communityMember'));
        $this->set('_serialize', ['communityMember']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Community Member id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $communityMember = $this->CommunityMembers->get($id);
        if ($this->CommunityMembers->delete($communityMember)) {
            $this->Flash->success(__('The community member has been deleted.'));
        } else {
            $this->Flash->error(__('The community member could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
