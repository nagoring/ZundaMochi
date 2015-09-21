<?php
namespace Community\Lib\Logic;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * @author nagomi
 */
class CommuinityAdditional {
	private $ctrl;
	private $community_id;
	private $communitiesTable;
	private $rolesTable;
	private function __construct() {
	}
	public static function getInstance(){
		static $instance = null;
		if($instance === null){
			$instance = new \Community\Lib\Logic\CommuinityAdditional();
		}
		return $instance;
	}
	/**
	 * CommunityEntityを取得
	 * このメソッドをcallする場合はflowの後に呼ぶ
	 * @return \Community\Model\Entity\Community
	 */
	public function fetchCommunity(){
		return $this->communitiesTable->get($this->community_id);
	}
	public function flow($ctrl){
		$this->init($ctrl);
		$result = $this->createNewCommunity();
		$this->communitiesTable->connection()->begin();
		try{
			if(!$result){
				$this->communitiesTable->connection()->rollback();
				$this->ctrl->Flash->error(__('The community could not be saved. Please, try again.'));
				return;
			}
			$this->community_id = $result->id;
			//画像アップロード処理
			if(isset($this->ctrl->request->data['thumbnail']) && $this->ctrl->request->data['thumbnail']['error'] === 0 && $this->ctrl->request->data['thumbnail']['error'] !== ''){
				$this->registerThumbnail();
			}
			//add to default roles
			$this->createDefaultRole();
			//add to memeber
			$this->addMember();
			$this->communitiesTable->connection()->commit();
			$this->ctrl->Flash->success(__('The community has been saved.'));
			$this->ctrl->redirect(['action' => 'index']);
		} catch (\Exception $ex) {
			$this->ctrl->Flash->error($ex->getMessage());
			return;
		}
	}
	private function init($ctrl){
		$this->ctrl = $ctrl;
		$config = TableRegistry::exists('CommunityRoles') ? [] : ['className' => 'Community\Model\Table\CommunitiesTable'];
		$this->communitiesTable = TableRegistry::get('Communities', $config);
		$config = TableRegistry::exists('CommunityRoles') ? [] : ['className' => 'Community\Model\Table\CommunityRolesTable'];
		$this->rolesTable = TableRegistry::get('CommunityRoles', $config);
	}
	
	private function createNewCommunity(){
		$community = $this->communitiesTable->newEntity();
		$community = $this->communitiesTable->patchEntity($community, $this->ctrl->request->data);
		return $this->communitiesTable->save($community);
	}
	private function registerThumbnail(){
		$dir = \App\Lib\Util\Dir::getInstance();
		$tmp_name = $this->ctrl->request->data['thumbnail']['tmp_name'];
		$error_msg = $this->ctrl->ImageUpload->validate($this->ctrl->request->data['thumbnail']['error'], $tmp_name);
		if($error_msg !== true){
			$this->communitiesTable->connection()->rollback();
			throw new \Exception($error_msg);
		}
		$username = $this->ctrl->Auth->user('username');
		$dir->checkAndMakeImageDir($username);
		$path = $dir->communityImageDir($username);
		$filename = $dir->communityImageFilename($this->community_id, $username);
		$width = Configure::read('Community.thumbnail.width');
		$height = Configure::read('Community.thumbnail.height');
		$this->ctrl->ImageUpload->createImage($tmp_name, $path, $filename, $width, $height);
		$community = $this->communitiesTable->get($this->community_id);
		$community->thumbnail = $filename;
		$ext = $this->ctrl->ImageUpload->getExtention($tmp_name);
		$dirdommunity = Configure::read('DIR_COMMUNITY');
		$community->thumbnail = $username . '/' . $dirdommunity . '/' . $filename . $ext;
		if(!$this->communitiesTable->save($community)){
			$this->communitiesTable->connection()->rollback();
			throw new \Exception(__('thumbnailの保存に失敗'));
		}
	}
	private function createDefaultRole(){
		$roleNames = ['管理人','副管理人','一般'];
		foreach($roleNames as $rolename){
			$roleEntity = $this->rolesTable->newEntity();
			$roleEntity->community_id = $this->community_id;
			$roleEntity->system_flag = 1;
			$roleEntity->name = $rolename;
			if(!$this->rolesTable->save($roleEntity)){
				$this->communitiesTable->connection()->rollback();
				throw new \Exception(__('ロールの追加に失敗'));
			}
		}
		return $this;
	}
	private function addMember(){
		$role = $this->rolesTable->find()->where(['name' => '管理人', 'community_id' => $this->community_id])->first();
		$user_id = $this->ctrl->Auth->user('id');
		$membersTable = TableRegistry::get('CommunityMembers', ['className' => 'Community\Model\Table\CommunityMembersTable']);
		$memberEntity = $membersTable->newEntity();
		$memberEntity->community_id = $this->community_id;
		$memberEntity->user_id = $user_id;
		$memberEntity->community_role_id = $role->id;

		if(!$membersTable->save($memberEntity)){
			$this->communitiesTable->connection()->rollback();
			throw new \Exception(__('Memberの関連付けに失敗' . var_export($memberEntity, true)));
		}
	}
}
