<?php
namespace Community\Lib\Logic;
use Cake\Core\Configure;

/**
 * @author nagomi
 */
class ImageUpload {
	private function __construct() {
	}
	/**
	 * @staticvar type $instance
	 * @return \\App\Lib\Logic\ImageUpload
	 */
	public static function getInstance(){
		static $instance = null;
		if($instance === null){
			$instance = new \App\Lib\Logic\ImageUpload();
		}
		return $instance;
	}
	public function upload($ctrl, $community_id){
		$dir = \App\Lib\Util\Dir::getInstance();
		$tmp_name = $ctrl->request->data['thumbnail']['tmp_name'];
		$error_msg = $ctrl->ImageUpload->validate($ctrl->request->data['thumbnail']['error'], $tmp_name);
		if($error_msg !== true){
			$ctrl->Communities->connection()->rollback();
			$ctrl->Flash->error($error_msg);
			return;
		}
		$username = $ctrl->Auth->user('username');
		$dir->checkAndMakeImageDir($username);
		$path = $dir->communityImageDir($username);
		$filename = $dir->communityImageFilename($community_id, $username);
		$width = 125;
		$height = 125;
		$ctrl->ImageUpload->createImage($tmp_name, $path, $filename, $width, $height);
		$community = $ctrl->Communities->get($community_id);
		$community->thumbnail = $filename;
		$ext = $ctrl->ImageUpload->getExtention($tmp_name);
		$dirdommunity = Configure::read('DIR_COMMUNITY');
		$community->thumbnail = $username . '/' . $dirdommunity . '/' . $filename . $ext;
		if(!$ctrl->Communities->save($community)){
			$ctrl->Communities->connection()->rollback();
			$ctrl->Flash->error(__('thumbnailの保存に失敗'));
			return;
		}
	}
}
