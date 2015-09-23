<?php
namespace Community\Model\Table;

use App\Model\Entity\Community;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Communities Model
 *
 * @property \Cake\ORM\Association\HasMany $Calendars
 * @property \Cake\ORM\Association\HasMany $Members
 */
class CommunitiesTable extends Table
{
//	public function findWithRole(\Cake\ORM\Query $query, array $options){
//		$community_id = $options['community_id'];
//		return $this->find()
//				->where([
//					'id' => $community_id
//				])->contain(['CommunityRoles'])->first();
//	}

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('communities');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Calendars', [
            'foreignKey' => 'community_id'
        ]);
        $this->hasMany('Members', [
            'foreignKey' => 'community_id'
        ]);
    }
//
//    /**
//     * Default validation rules.
//     *
//     * @param \Cake\Validation\Validator $validator Validator instance.
//     * @return \Cake\Validation\Validator
//     */
//    public function validationDefault(Validator $validator)
//    {
//        $validator
//            ->add('id', 'valid', ['rule' => 'numeric'])
//            ->allowEmpty('id', 'create');
//
//        $validator
//            ->add('publish', 'valid', ['rule' => 'numeric'])
//            ->requirePresence('publish', 'create')
//            ->notEmpty('publish');
//
//        $validator
//            ->requirePresence('title', 'create')
//            ->notEmpty('title');
//
//        $validator
//            ->requirePresence('body', 'create')
//            ->notEmpty('body');
//
//        $validator
//            ->requirePresence('thumbnail', 'create')
//            ->notEmpty('thumbnail');
//
//        $validator
//            ->add('status', 'valid', ['rule' => 'numeric'])
//            ->requirePresence('status', 'create')
//            ->notEmpty('status');
//
//        $validator
//            ->requirePresence('status_name', 'create')
//            ->notEmpty('status_name');
//
//        return $validator;
//    }
}
