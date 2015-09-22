<?php
namespace CakeHook;
/**
 * Description of CakeHook
 *
 * @author nagomi
 */
class Action {
	protected static $_queue = [];
	protected static $_maxIndex = 1024;
	/**
	 * 登録されたアクションの呼び出し
	 * groupとactionを指定して登録したアクションを逐次実行する
	 * 
	 * @param string $group
	 * @param string $action
	 * @param type $param
	 * @return type
	 */
	public static function action($group, $action, $param){
		if(!isset(self::$_queue[$group][$action]))return;
		ksort(self::$_queue[$group][$action]);
		$state = new \CakeHook\State($param);
		foreach(self::$_queue[$group][$action] as $_func){
//			$func = $_func->bindTo($_this);
			$res = $_func($state);
			$state->setReturn($res);
		}
		return $state->getReturn();
	}
	/**
	 * アクションの登録を行う
	 * \CakeHook\Controller\CakeHookAppControllerを継承しているコントローラーなら自動でコントローラーのアクションになる
	 * アクションとはラベルを貼って関数を遅延実行するための機能である
	 * actionメソッドによる呼び出しで初めて実行される
	 * indexはデフォルトが100になり、少ないほうが先に実行される
	 * group,action,indexが一致した場合次の空いているindexを登録する
	 * 
	 * @param string $group
	 * @param string $action
	 * @param int $index
	 * @param type $func 関数 引数に \CakeHook\State を持たなければならない。
	 * @return type
	 * @throws \Exception
	 */
	public static function add($group, $action, $index, $func){
		if(!isset(self::$_queue[$group])) self::$_queue[$group] = [];
		if(!isset(self::$_queue[$group][$action])) self::$_queue[$group][$action] = [];
		if(self::$_maxIndex < $index){
			throw new \Exception('Failed addAction over max index :' . $index);
		}
		if(isset(self::$_queue[$group][$action][$index])){
			$_index = $index + 1;
			for($i=$_index;$i<self::$_maxIndex + $_index;$i++){
				if(!isset(self::$_queue[$group][$action][$i])){
					self::$_queue[$group][$action][$i] = $func;
					return ;
				}
			}
			throw new \Exception('Failed addAction over max index. Not Index :' . $index);
		}else{
			self::$_queue[$group][$action][$index] = $func;
		}
	}
	/**
	 * アクションの上書きを行う
	 * group,action,indexが一致した場合そこを上書きする
	 * 空の場合はそのまま追加される
	 * @param type $group
	 * @param type $action
	 * @param type $index
	 * @param type $func
	 */
	public static function overwrite($group, $action, $index, $func){
		if(!isset(self::$_queue[$group])) self::$_queue[$group] = [];
		if(!isset(self::$_queue[$group][$action])) self::$_queue[$group][$action] = [];
		self::$_queue[$group][$action][$index] = $func;
	}
	/**
	 * アクションの削除を行う
	 * groupのみを指定した場合そのgroupのアクションは全て削除される
	 * groupとactionを指定した場合はactionのアクションは全て削除される
	 * groupとactionとindexを指定した場合は指定したindexのアクションを削除する
	 * @param string $group
	 * @param string $action
	 * @param int $index
	 * @return type
	 */
	public static function remove($group, $action = null, $index = null){
		if($index !== null){
			unset(self::$_queue[$group][$action][$index]);
			return;
		}
		if($action !== null){
			unset(self::$_queue[$group][$action]);
			return;
		}
		unset(self::$_queue[$group]);
	}
	/**
	 * 指定したアクションが存在するか調べる
	 * @param string $group
	 * @param string $action
	 * @return type
	 */
	public static function is($group, $action){
		return isset(self::$_queue[$group][$action]);
	}
}

