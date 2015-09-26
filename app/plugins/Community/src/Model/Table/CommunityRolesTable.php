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
	private $defaultRole = '一般';
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
		$this->addBehavior('Timestamp');
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
	public function findDefaultPermission(\Cake\ORM\Query $query, array $options){
		//TODO デフォルト設定をコミュニティで用意する必要がある。とりあえず一般を返すようにする
		$name = $this->defaultRole;
		$community_id = $options['community_id'];
		return $this->find()
				->where([
					'name' => $name,
					'community_id' => $community_id
				])->first();
	}
	/**
	 * デフォルトのRoleを追加(一般)
	 * TODO デフォルトはコミュニティの設定で変えても良い
	 * @param Query $query
	 * @param array $options
	 * @return type
	 */
	public function findDefaultRole(\Cake\ORM\Query $query, array $options){
		$community_id = $options['community_id'];
		return $this->find()->where([
			'community_id' => $community_id, 
			'name' => $this->defaultRole, 
		])->contain('Communities')->first();
	}
	/**
	 * 対象のコミュニティのsystem_flagが1のものを全て取得
	 * hashで返す[name => id, name => id, name => id]
	 * @param \Cake\ORM\Query $query
	 * @param array $options
	 * ['community_id' => int]
	 */
	public function findDefaultRolesHashNameId(\Cake\ORM\Query $query, array $options){
		$community_id = (int)$options['community_id'];
		$defaultRoles = $this->find()->where([
			'id' => $community_id,
			'system_flag' => 1,
		])->all();
		if($defaultRoles === null){
			return null;
		}
		$ret = [];
		foreach($defaultRoles as $defaultRole){
			$ret[ $defaultRole->name ] = $defaultRole->id;
		}
		return $ret;
	}
	/**
	 * デフォルトRoleを作成する
	 * @staticvar array $roleNames
	 * @param type $community_id
	 * @return boolean
	 */
	public function createDefaultRole($community_id){
		//TODO デフォルトRoleの情報はどこかで持たなければならない
		static $roleNames = ['管理人','副管理人','一般'];
		$defaultRolesHashNameId = $this->find('defaultRolesHashNameId', ['community_id' => $community_id]);
		
		foreach($roleNames as $rolename){
			//登録済がチェックを掛けて、登録なしの場合のみ追加
			if(isset($defaultRolesHashNameId[$rolename]))continue;
			$roleEntity = $this->newEntity();
			$roleEntity->community_id = $community_id;
			$roleEntity->system_flag = 1;
			$roleEntity->name = $rolename;
			if($this->save($roleEntity) === false){
				//TODO Log出力
				return false;
			}
		}
		return true;
	}
	
	
}
