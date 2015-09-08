<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CommunityRole Controller
 *
 * @property \App\Model\Table\CommunityRoleTable $CommunityRole
 */
class CommunityRoleController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('communityRole', $this->paginate($this->CommunityRole));
        $this->set('_serialize', ['communityRole']);
    }

    /**
     * View method
     *
     * @param string|null $id Community Role id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $communityRole = $this->CommunityRole->get($id, [
            'contain' => []
        ]);
        $this->set('communityRole', $communityRole);
        $this->set('_serialize', ['communityRole']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $communityRole = $this->CommunityRole->newEntity();
        if ($this->request->is('post')) {
            $communityRole = $this->CommunityRole->patchEntity($communityRole, $this->request->data);
            if ($this->CommunityRole->save($communityRole)) {
                $this->Flash->success(__('The community role has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The community role could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('communityRole'));
        $this->set('_serialize', ['communityRole']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Community Role id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $communityRole = $this->CommunityRole->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $communityRole = $this->CommunityRole->patchEntity($communityRole, $this->request->data);
            if ($this->CommunityRole->save($communityRole)) {
                $this->Flash->success(__('The community role has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The community role could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('communityRole'));
        $this->set('_serialize', ['communityRole']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Community Role id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $communityRole = $this->CommunityRole->get($id);
        if ($this->CommunityRole->delete($communityRole)) {
            $this->Flash->success(__('The community role has been deleted.'));
        } else {
            $this->Flash->error(__('The community role could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
