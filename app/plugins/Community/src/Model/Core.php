<?php
namespace Community\Model;

class Core {
	/**
	 * @return \Community\Model\Table\CommunitiesTable
	 */
	public static function getCommunitiesTable(){
		return getTableModel('Communities', 'Community\Model\Table\CommunitiesTable');
	}
	/**
	 * @return \Community\Model\Table\CommunityMembersTable
	 */
	public static function getCommunityMembersTable(){
		return getTableModel('CommunityMembers', 'Community\Model\Table\CommunityMembersTable');
	}
	/**
	 * @return \Community\Model\Table\CommunityThreadsTable
	 */
	public static function getCommunityThreadsTable(){
		return getTableModel('CommunityThreads', 'Community\Model\Table\CommunityThreadsTable');
	}
	
	
}
