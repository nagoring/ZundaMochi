<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CommunityPermission Controller
 *
 * @property \App\Model\Table\CommunityPermissionTable $CommunityPermission
 */
class CommunityPermissionController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Roles']
        ];
        $this->set('communityPermission', $this->paginate($this->CommunityPermission));
        $this->set('_serialize', ['communityPermission']);
    }

    /**
     * View method
     *
     * @param string|null $id Community Permission id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $communityPermission = $this->CommunityPermission->get($id, [
            'contain' => ['Roles', 'RolePermission']
        ]);
        $this->set('communityPermission', $communityPermission);
        $this->set('_serialize', ['communityPermission']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $communityPermission = $this->CommunityPermission->newEntity();
        if ($this->request->is('post')) {
            $communityPermission = $this->CommunityPermission->patchEntity($communityPermission, $this->request->data);
            if ($this->CommunityPermission->save($communityPermission)) {
                $this->Flash->success(__('The community permission has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The community permission could not be saved. Please, try again.'));
            }
        }
        $roles = $this->CommunityPermission->Roles->find('list', ['limit' => 200]);
        $this->set(compact('communityPermission', 'roles'));
        $this->set('_serialize', ['communityPermission']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Community Permission id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $communityPermission = $this->CommunityPermission->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $communityPermission = $this->CommunityPermission->patchEntity($communityPermission, $this->request->data);
            if ($this->CommunityPermission->save($communityPermission)) {
                $this->Flash->success(__('The community permission has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The community permission could not be saved. Please, try again.'));
            }
        }
        $roles = $this->CommunityPermission->Roles->find('list', ['limit' => 200]);
        $this->set(compact('communityPermission', 'roles'));
        $this->set('_serialize', ['communityPermission']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Community Permission id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $communityPermission = $this->CommunityPermission->get($id);
        if ($this->CommunityPermission->delete($communityPermission)) {
            $this->Flash->success(__('The community permission has been deleted.'));
        } else {
            $this->Flash->error(__('The community permission could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
