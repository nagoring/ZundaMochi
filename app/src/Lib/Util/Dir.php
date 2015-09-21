<?php
namespace App\Lib\Util;
use Cake\Core\Configure;
/**
 * Description of Dir
 *
 * @author nagomi
 */
class Dir {
	private function __construct() {
	}
	public static function getInstance(){
		static $instance = null;
		if($instance === null){
			$instance = new self;
		}
		return $instance;
	}
	public function checkAndMakeImageDir($username){
		$imageuserdir = $this->imageUserDir($username);
		if(!file_exists($imageuserdir)){
			mkdir($imageuserdir, 0644);
		}
		$communityimagedir = $this->communityImageDir($username);
		if(!file_exists($communityimagedir)){
			mkdir($communityimagedir, 0644);
		}
	}
	public function communityImageFilename($community_id, $username){
		return md5(\Cake\Utility\Security::salt() . $community_id . $username . 'Community');
	}
	public function communityImageDir($username){
		$dir = Configure::read('DIR_COMMUNITY');
		return $this->imageUserDir($username) . DS . $dir;
	}
	public function imageUserDir($username){
		return WWW_ROOT . DS . 'media' . DS . 'img' . DS . $username;
	}
	public function pluginActivationJsonFilePath(){
		return APP . '..' . DS .  'config' . DS . 'plugin_activatation.json';
	}
}
