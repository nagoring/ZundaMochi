<?php
namespace App\Lib\Logic;
use Cake\Core\Configure;

/**
 * @author nagomi
 */
class Plugin {
	private function __construct() {
		$this->doCheckPluginLoadJsonFile();
	}
	/**
	 * @staticvar type $instance
	 * @return \App\Lib\Logic\Plugin
	 */
	public static function getInstance(){
		static $instance = null;
		if($instance === null){
			$instance = new \App\Lib\Logic\Plugin();
		}
		return $instance;
	}
	/**
	 * アクティベートしているプラグインを記述してあるjsonファイルをチェック
	 * ファイルがない場合は空ファイルを生成する
	 * @return \App\Lib\Logic\Plugin
	 */
	private function doCheckPluginLoadJsonFile(){
		$dir = \App\Lib\Util\Dir::getInstance();
		$jsonPluginLoadFilePath = $dir->pluginActivationJsonFilePath();
		if(!file_exists($jsonPluginLoadFilePath)){
			//無ければ空jsonを生成しておく
			$create_flg = true;
			$file = new \Cake\Filesystem\File($jsonPluginLoadFilePath, $create_flg);
			$data = json_encode([]);
			$file->write($data, 'w');
			$file->close();
		}
		return $this;
	}
	/**
	 * プラグインのアクティベート対象が記述されているjsonファイルを読み込む
	 * 形式はjsonをdecodeした配列のデータ返す
	 * @return array
	 */
	public function load(){
		$dir = \App\Lib\Util\Dir::getInstance();
		$jsonPluginLoadFilePath = $dir->pluginActivationJsonFilePath();
		$file = new \Cake\Filesystem\File($jsonPluginLoadFilePath);
		$json = $file->read();
		$file->close();
		return json_decode($json);
	}
	/**
	 * plugin_activatation.jsonファイルを上書きする
	 * 引数で渡された$rebuildActivationPluginsをそのままjsonにして上書きを行う
	 * @param array $rebuildActivationPlugins セーブ対象となるデータ
	 * [[
	 *		'name' => 'Community',
	 *		'priority' => 10
	 *	],[
	 *		'name' => 'Blog',
	 *		'priority' => 11
	 * ]]
	 * @return \App\Lib\Logic\Plugin
	 */
	public function overwirte($rebuildActivationPlugins){
		$file = new \Cake\Filesystem\File( \App\Lib\Util\Dir::getInstance()->pluginActivationJsonFilePath() );
		$file->write(json_encode($rebuildActivationPlugins, JSON_UNESCAPED_UNICODE));
		$file->close();
		return $this;
	}
	/**
	 * 対象となるプラグインをアクティベートする
	 * plugin_activatation.jsonを読み込んでその末尾に$targetの情報を追加する
	 * @param array $target
	 * @example 
	 *	[
	 *	'name' => 'Community',
	 *	'priority' => 10,
	 * ]
	 * @return \App\Lib\Logic\Plugin || 失敗時にはfalseを返す
	 */
	public function activate($target){
		$addActivationPlugin = [];
		if(!isset($target['name'])){
			return false;
		}
		$addActivationPlugin['name'] = $target['name'];
		$addActivationPlugin['priority'] = isset($target['priority']) ? $target['priority'] : 10;
		$activationPluginArray = $this->load();
		$activationPluginArray[] = $addActivationPlugin;
		$jsonPluginLoadFilePath = \App\Lib\Util\Dir::getInstance()->pluginActivationJsonFilePath();
		$file = new \Cake\Filesystem\File($jsonPluginLoadFilePath);
		$file->write(json_encode($activationPluginArray, JSON_UNESCAPED_UNICODE));
		$file->close();
		return $this;
	}
	/**
	 * 対象のプラグインをディアクティベートする
	 * 一度、データを全て読み込み、順次名前を調べて
	 * $plugin_nameと一致したものは追加しないようにしてる
	 * @param string $plugin_name
	 * @return \App\Lib\Logic\Plugin
	 */
	public function deactivate($plugin_name){
		$activationPluginArray = $this->load();
		$rebuildActivationPlugins = [];
		foreach($activationPluginArray as $activationPlugin){
			if($activationPlugin->name !== $plugin_name){
				$rebuildActivationPlugins[] = $activationPlugin;
			}
		}
		return $this->overwirte($rebuildActivationPlugins);
	}
	private function fetchZundaMochiPlugins(){
		$jsonFileName = 'cakehook.json';
		$jsons = [];
		//プラグインのパスを取得
		$pluginDirPath = ROOT . DS . 'plugins' . DS;
		$dirs = scandir($pluginDirPath);
		//ディレクトリ検索
		foreach($dirs as $dir){
			if($dir === '.' || $dir === '..')continue;
			//ZundaMochiプラグインが判定しつつ名前を取る
			$jsonFileFullPath = $pluginDirPath . $dir . DS . $jsonFileName;
			if(!file_exists($jsonFileFullPath))continue;
			$json = file_get_contents($jsonFileFullPath);
			$jsons[$dir] = json_decode($json);
			$jsons[$dir]->is_activate = false;
		}
		return $jsons;
	}
	public function loadAll(){
		$activationPluginArray = $this->load();
		$allPluginDetailArray = $this->fetchZundaMochiPlugins();
		foreach($activationPluginArray as $activationPlugin){
			$plugin_name = $activationPlugin->name;
			if(!isset($allPluginDetailArray[$plugin_name]))continue;
			$allPluginDetailArray[$plugin_name]->is_activate = true;
		}
		return $allPluginDetailArray;
	}
	
}
