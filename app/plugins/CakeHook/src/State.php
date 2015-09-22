<?php
namespace CakeHook;

/**
 * Description of State
 *
 * @author nagomi
 */
class State {
	private $param;
	private $return;
	private $_this;
	/**
	 * 指定したパラメータを渡す
	 * コントローラーからの呼び出しは必ず_thisを含む。_thisは呼び出し元のコントローラー
	 * @param array $param
	 * @eaxample
	 *	[
	 *		'aaa' => 100,
	 *		'_this' => $this(コントローラー)
	 *	]
	 */
	public function __construct($param) {
		$this->param = $param;
		$this->_this = isset($param['_this']) ? $param['_this'] : null;
		unset($this->param['_this']);
	}
	/**
	 * Hookされている次のアクションに渡すための返り値をセットする
	 * @param type $return
	 */
	public function setReturn($return){
		$this->return = $return;
	}
	/**
	 * 前の呼びだされたHookされているアクションの返り値を受け取る
	 * @return type
	 */
	public function getReturn(){
		return $this->return;
	}
	/**
	 * Hookされたアクションに渡された引数を取得する
	 * @return type
	 */
	public function getParam(){
		return $this->param;
	}
	/**
	 * 呼び出し元のコントローラーの取得
	 * @return type
	 */
	public function getThis(){
		return $this->_this;
	}
	
	public function getArgs(){
		return $this->param['pass'];
	}
}
