<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PluginSettingsTable extends Table {

	public function initialize(array $config) {
	}

	public function findActivated(\Cake\ORM\Query $query, array $options) {
		$plugins = $options['plugins'];
		$or = ['OR' => []];
		foreach($plugins as $name => $json){
			$or['OR'][] = ['name' => $name];
		}
		$dataArray = $this->find()->where($or)->select(['name'])->all();
		foreach($dataArray as $data){
			$plugins[$data->name]->is_activate = true;
		}
		return $plugins;
	}

}
