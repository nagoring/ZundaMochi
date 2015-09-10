<?php
namespace Community\Model\Table;

use App\Model\Entity\CommunityRole;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CommunityRoles Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Communities
 * @property \Cake\ORM\Association\HasMany $CommunityMembers
 * @property \Cake\ORM\Association\HasMany $RolePermission
 */
class CommunityRolesTable extends Table
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

        $this->table('community_roles');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Communities', [
            'foreignKey' => 'community_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('CommunityMembers', [
            'foreignKey' => 'community_role_id'
        ]);
        $this->hasMany('RolePermission', [
            'foreignKey' => 'community_role_id'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->add('system_flag', 'valid', ['rule' => 'boolean'])
            ->requirePresence('system_flag', 'create')
            ->notEmpty('system_flag');

        $validator
            ->add('created_at', 'valid', ['rule' => 'datetime'])
            ->requirePresence('created_at', 'create')
            ->notEmpty('created_at');

        $validator
            ->add('modified_at', 'valid', ['rule' => 'datetime'])
            ->requirePresence('modified_at', 'create')
            ->notEmpty('modified_at');

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
        return $rules;
    }
}
