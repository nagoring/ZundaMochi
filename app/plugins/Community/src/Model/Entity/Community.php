<?php
namespace Community\Model\Entity;

use Cake\ORM\Entity;

/**
 * Community Entity.
 */
class Community extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
   protected function _getTitle($title)
    {
	   
        return ucwords($title);
    }	
	protected function _setHello($value) {
		return $value . " set;";
	}
	protected function _getHello() {
		return   " hello ";
	}
    protected function _getFullName()
    {
        return $this->_properties['title'];
    }
	protected function _getImgUrl() {
		$thumbnail = $this->_properties['thumbnail'];
		if(!$thumbnail){
			return 'http://placehold.it/150x150';
		}
		return $thumbnail;
	}
	

}
