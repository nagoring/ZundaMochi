<?php
namespace Community\Test\TestCase\Controller;

use CakeHook\Action;
use App\Controller\ArticleImagesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\ArticleImagesController Test Case
 */
class ActionTest extends IntegrationTestCase
{
	public function setUp() {
		parent::setUp();
		Action::clear();
	}
    /**
     *
     * @return void
     */
    public function testAddSimple(){
		$group = 'ActionTestController';
		$action = 'sayHello';
		$index = 10;
		Action::add($group, $action, $index, function(\CakeHook\State $state){
			return 'hello';
		});
		$this->assertSame('hello', Action::action($group, $action, []));
    }
    public function testAddMultiIndexes_pt1(){
		$group = 'ActionTestController';
		$action = 'sayHello';
		$index = 10;
		Action::add($group, $action, $index, function(\CakeHook\State $state){
			return 'hello';
		});
		$index = 11;
		Action::add($group, $action, $index, function(\CakeHook\State $state){
			return $state->getReturn() . ' world';
		});
		$this->assertSame('hello world', Action::action($group, $action, []));
    }
	/**
	 * 同じindexを指定した場合自動で次のindexで登録されているか
	 */
    public function testAddMultiIndexes_pt2(){
		$group = 'ActionTestController';
		$action = 'sayHello';
		$index = 10;
		Action::add($group, $action, $index, function(\CakeHook\State $state){
			return 'hello';
		});
		$index = 10;
		Action::add($group, $action, $index, function(\CakeHook\State $state){
			return $state->getReturn() . ' world';
		});
		$this->assertSame('hello world', Action::action($group, $action, []));
    }
    public function testAddMaximumIndex(){
		$group = 'ActionTestController';
		$action = 'sayHello';
		$index = 1000000;
		try{
			Action::add($group, $action, $index, function(\CakeHook\State $state){
				return 'hello';
			});
			$this->fail('PHPUnit fail');
		} catch (\Exception $ex) {
			$this->assertSame('Failed addAction over max index :' . $index, $ex->getMessage());
		}
    }
	public function testActionWithParam(){
		$group = 'ActionTestController';
		$action = 'sayHello';
		$index = 10;
		Action::add($group, $action, $index, function(\CakeHook\State $state){
			$param = $state->getParam();
			$name = $param['name'];
			return $name . ':hello';
		});
		$this->assertSame('yamada:hello', Action::action($group, $action, ['name' => 'yamada']));
	}
    public function testOverwrite(){
		$group = 'ActionTestController';
		$action = 'sayHello';
		$index = 10;
		Action::add($group, $action, $index, function(\CakeHook\State $state){
			return 'hello';
		});
		$index = 10;
		Action::overwrite($group, $action, $index, function(\CakeHook\State $state){
			return $state->getReturn() . ' world';
		});
		$this->assertSame(' world', Action::action($group, $action, []));
    }
    public function testRemove(){
		$group = 'ActionTestController';
		$action = 'sayHello';
		$index = 10;
		Action::add($group, $action, $index, function(\CakeHook\State $state){
			return 'hello';
		});
		$index = 11;
		Action::add($group, $action, $index, function(\CakeHook\State $state){
			return $state->getReturn() . ' world';
		});
		Action::remove($group, $action, 11);
		$this->assertSame('hello', Action::action($group, $action, []));
    }
    public function testIs(){
		$group = 'ActionTestController';
		$action = 'sayHello';
		$index = 10;
		Action::add($group, $action, $index, function(\CakeHook\State $state){
			return 'hello';
		});
		$this->assertTrue(Action::is($group, $action));
    }
}


