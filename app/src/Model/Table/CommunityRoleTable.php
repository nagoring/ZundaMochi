<?php
namespace App\Model\Table;

use App\Model\Entity\CommunityRole;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CommunityRole Model
 *
 * @property \Cake\ORM\Association\HasMany $Members
 * @property \Cake\ORM\Association\HasMany $RolePermission
 */
class CommunityRoleTable extends Table
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

        $this->table('community_role');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('Members', [
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
}
