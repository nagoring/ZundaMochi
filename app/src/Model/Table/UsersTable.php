<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table {

	public function initialize(array $config) {
		$this->addBehavior('Timestamp');
	}

	public function validationDefault(Validator $validator) {
		$validator
			->add('password_confirm', 'compare', ['rule' => ['compareWith', 'password'], 'message'=>'パスワードが一致しません'])
			->requirePresence('password_confirm', 'create')
			->notEmpty('password_confirm', '入力してください');
	
		return $validator
						->notEmpty('username', 'A username is required')
						->notEmpty('password', 'A password is required')
						->notEmpty('role', 'A role is required')
						->add('role', 'inList', [
							'rule' => ['inList', ['admin', 'author']],
							'message' => 'Please enter a valid role'
		]);
	}

}
