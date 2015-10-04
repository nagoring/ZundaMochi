<?php
namespace Community\Controller;

use App\Controller\AppController;

/**
 * CommunityThreads Controller
 *
 * @property \App\Model\Table\CommunityThreadsTable $CommunityThreads
 */
class CommunityThreadsController extends \App\Controller\UsersAppController
{
	public function beforeFilter(\Cake\Event\Event $event) {
		parent::beforeFilter($event);
		$this->viewBuilder()->layout('mochi');
	}
//    /**
//     * Index method
//     *
//     * @return void
//     */
//    public function index()
//    {
//        $this->set('communityThreads', $this->paginate($this->CommunityThreads));
//        $this->set('_serialize', ['communityThreads']);
//    }
//
    /**
     * View method
     *
     * @param string|null $id Community Thread id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view(){
		if(count($this->request->params['pass']) === 0){
			$this->redirect('/');
		}
		$community_thread_id = (int)$this->request->params['pass'][0];
		
		$communityThreadsTable = getTableModel('CommunityThreads', 'Community\Model\Table\CommunityThreadsTable');
		$communityCommentsTable = getTableModel('CommunityComments', 'Community\Model\Table\CommunityCommentsTable');

        $communityThread = $communityThreadsTable->get($community_thread_id, [
            'contain' => []
        ]);
		$communityCommentEntities = $communityCommentsTable->find()->where(['community_thread_id' => $community_thread_id])->all();
        $this->set('communityCommentEntities', $communityCommentEntities);
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
		if(count($this->request->params['pass']) === 0){
			$this->redirect('/');
		}
		$community_id = (int)$this->request->params['pass'][0];
		if(!$community_id){
			$community_id = $this->request->data['community_id'];
		}
		$user_id = $this->Auth->user('id');
		
		$communitiesTable = getTableModel('Communities', 'Community\Model\Table\CommunitiesTable');
		$communityMembersTable = getTableModel('CommunityMembers', 'Community\Model\Table\CommunityMembersTable');
		$communityMemberEntity = $communityMembersTable->find()->where([
			'community_id' => $community_id,
			'user_id' => $user_id,
		])->first();
		if($communityMemberEntity === null){
			$this->Flash->error(__('あなたはコミュニティに参加していません'));
			return $this->redirect('/m/co' . $community_id);
		}
		$community = $communitiesTable->get($community_id);
		
        $communityThread = $this->CommunityThreads->newEntity();
        if ($this->request->is('post')) {
			$community_id = (int)$this->request->data['community_id'];
			$communityThread->user_id = $this->Auth->user('id');
			$communityThread->community_id = $community_id;
			$communityThread->title = $this->request->data['title'];
			$communityThread->body = $this->request->data['body'];
			$communityThread->publish = $this->request->data['publish'];
			
            if ($this->CommunityThreads->save($communityThread)) {
                $this->Flash->success(__('新規にスレッドを立ち上げました'));
                return $this->redirect('/m/co' . $community_id);
            } else {
                $this->Flash->error(__('スレットを立てるのに失敗しました'));
            }
        }
        $this->set('community', $community);
        $this->set(compact('communityThread'));
        $this->set('_serialize', ['communityThread']);
    }
//
//    /**
//     * Edit method
//     *
//     * @param string|null $id Community Thread id.
//     * @return void Redirects on successful edit, renders view otherwise.
//     * @throws \Cake\Network\Exception\NotFoundException When record not found.
//     */
//    public function edit($id = null)
//    {
//        $communityThread = $this->CommunityThreads->get($id, [
//            'contain' => []
//        ]);
//        if ($this->request->is(['patch', 'post', 'put'])) {
//            $communityThread = $this->CommunityThreads->patchEntity($communityThread, $this->request->data);
//            if ($this->CommunityThreads->save($communityThread)) {
//                $this->Flash->success(__('The community thread has been saved.'));
//                return $this->redirect(['action' => 'index']);
//            } else {
//                $this->Flash->error(__('The community thread could not be saved. Please, try again.'));
//            }
//        }
//        $this->set(compact('communityThread'));
//        $this->set('_serialize', ['communityThread']);
//    }
//
//    /**
//     * Delete method
//     *
//     * @param string|null $id Community Thread id.
//     * @return void Redirects to index.
//     * @throws \Cake\Network\Exception\NotFoundException When record not found.
//     */
//    public function delete($id = null)
//    {
//        $this->request->allowMethod(['post', 'delete']);
//        $communityThread = $this->CommunityThreads->get($id);
//        if ($this->CommunityThreads->delete($communityThread)) {
//            $this->Flash->success(__('The community thread has been deleted.'));
//        } else {
//            $this->Flash->error(__('The community thread could not be deleted. Please, try again.'));
//        }
//        return $this->redirect(['action' => 'index']);
//    }
}
