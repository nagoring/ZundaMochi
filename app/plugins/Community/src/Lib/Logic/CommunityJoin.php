<?php
namespace Community\Lib\Logic;
class CommunityJoin {
	private $ctrl;
	private $community_id;
	/*@var $communitiesTable Community\Model\Table\CommunitiesTable */
	private $communitiesTable;
	/*@var $communityRolesTable Community\Model\Table\CommunityRolesTable */
	private $communitiesRolesTable;
	private function __construct() {
	}
	/**
	 * @staticvar type $instance
	 * @return \Community\Lib\Logic\CommunityJoin
	 */
	public static function getInstance(){
		static $instance = null;
		if($instance === null){
			$instance = new \Community\Lib\Logic\CommunityJoin();
		}
		return $instance;
	}
	
	public function flow($ctrl, $community_id){
		try{
			$this->init($ctrl, $community_id);
			$default_community_role_id = $this->getDefaultCommunityRoleId();
			if($default_community_role_id === null){
				throw new \Exception('default_community_role_idが空');
			}
			return $this->joinMember($default_community_role_id);
		} catch (\Exception $ex) {
			$this->ctrl->Flash->error(__($ex->getMessage()));
			return false;
		}
	}
	private function init($ctrl, $community_id){
		$this->ctrl = $ctrl;
		$this->community_id = $community_id;
		$this->communitiesTable = getTableModel('Communities', 'Community\Model\Table\CommunitiesTable');
		$this->communitiesRolesTable = getTableModel('CommunityRoles', 'Community\Model\Table\CommunityRolesTable');
	}
	/**
	 * @throws Exception
	 */
	private function getDefaultCommunityRoleId(){
		//TODO デフォルト権限の設定がどこかにありそこで指定する
		$defaultCommunityRoleEntity = $this->communitiesRolesTable->find('defaultRole', ['community_id' => $this->community_id]);
		//デフォルトRoleが見つからない場合イレギュラーなのでsystem_flagの基本ロールを調べて無いものを挿入する
		if($defaultCommunityRoleEntity === null){
			$this->communitiesRolesTable->createDefaultRole($this->community_id);
			$defaultCommunityRoleEntity = $this->communitiesRolesTable->find('defaultRole', ['community_id' => $this->community_id]);
			if($defaultCommunityRoleEntity === null){
				throw new Exception(__('ロールが追加できません。データベースや設定を見なおして下さい'));
			}
		}
		return $defaultCommunityRoleEntity->id;
	}
	/**
	 * @param type $default_community_role_id
	 * @return boolean
	 * @throws \Exception
	 */
	private function joinMember($default_community_role_id){
		/*@var $communityMembersTable Community\Model\Table\CommunityMembersTable */
		$communityMembersTable = getTableModel('CommunityMembers', 'Community\Model\Table\CommunityMembersTable');
		$communityMemberEntity = $communityMembersTable->newEntity();
		$communityMemberEntity->community_id = (int)$this->community_id;
		$communityMemberEntity->user_id = (int)$this->ctrl->Auth->user('id');
		$communityMemberEntity->community_role_id = $default_community_role_id;

		//既に登録されていた場合は登録を許さない
		$joinedCommunityMember = $communityMembersTable->find()->where([
			'community_id' => $communityMemberEntity->community_id,
			'user_id' => $communityMemberEntity->user_id,
		])->first();

		if($joinedCommunityMember){
			return true;
		}
		if(!$communityMembersTable->save($communityMemberEntity)){
			//TODO エラーの場合エラー画面が有っても良いが今は保留
			throw new \Exception(__('CommunityMemberの関連付けに失敗'));
		}
		return true;
	}
}
