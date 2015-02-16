<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PluginSetting Entity.
 */
class PluginSetting extends Entity {

	/**
	 * Fields that can be mass assigned using newEntity() or patchEntity().
	 *
	 * @var array
	 */
	protected $_accessible = [
		'name' => true,
		'priority' => true,
	];
}
