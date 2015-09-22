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
    /**
     *
     * @return void
     */
    public function testAddSimple()
    {
		$group = 'ActionTestController';
		$action = 'sayHello';
		$index = 10;
		Action::add($group, $action, $index, function(\CakeHook\State $state){
			return 'hello';
		});
		$this->assertSame('hello', Action::action($group, $action, []));
    }
    public function testAddMultiIndexes()
    {
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
}
