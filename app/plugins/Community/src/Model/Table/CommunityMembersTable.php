<?php
namespace Community\Model\Table;

use App\Model\Entity\CommunityMember;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CommunityMembers Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Communities
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $CommunityRoles
 */
class CommunityMembersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('community_members');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Communities', [
            'foreignKey' => 'community_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CommunityRoles', [
            'foreignKey' => 'community_role_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('notice_flag', 'create')
            ->notEmpty('notice_flag');

        $validator
            ->add('modified_at', 'valid', ['rule' => 'numeric'])
            ->requirePresence('modified', 'create')
            ->notEmpty('modified');

        $validator
            ->add('created_at', 'valid', ['rule' => 'numeric'])
            ->requirePresence('created', 'create')
            ->notEmpty('created');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['community_id'], 'Communities'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['community_role_id'], 'CommunityRoles'));
        return $rules;
    }
	public function findJoinedMember(\Cake\ORM\Query $query, array $options) {
		$user_id = $options['user_id'];
		$community_id = $options['community_id'];
		return $this->find()
				->where([
					'user_id' => $user_id,
					'community_id' => $community_id
				])->select(['id'])->first();
	}
	public function findJoinedQuery(Query $query, array $options){
		$user_id = $options['user_id'];
//		$limit = $options['limit'];
//		$page = $options['page'];
//		$communityMembers = getTableModel('CommunityMembers', 'Community\Model\Table\CommunityMembersTable');
//		return $communityMembers->find()
		return $query
				->contain(['Communities'])
				->where(['CommunityMembers.user_id' => $user_id]);
//				
//		return $query->find()
//				->contain(['Communities'])
//				->where(['CommunityMembers.user_id' => $user_id])
//				;
	}	
	
}
