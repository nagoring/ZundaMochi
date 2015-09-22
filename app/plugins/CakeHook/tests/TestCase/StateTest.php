<?php
namespace Community\Test\TestCase\Controller;

use CakeHook\State;
use App\Controller\ArticleImagesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\ArticleImagesController Test Case
 */
class StateTest extends IntegrationTestCase
{
    /**
     * Test index method
     *
     * @return void
     */
    public function testReturn()
    {
		$state = new State([
				'_this' => null,
				'sample' => 'hello state',
			]);
		$state->setReturn('Cream');
		$this->assertSame($state->getReturn(), 'Cream');
		$state->setReturn([]);
		$this->assertSame($state->getReturn(), []);
    }
    public function testParam()
    {
		$std = new \stdClass();
		$std->a = 'Apple';
		$std->b = 'Ringo';
		$state = new State([
				'_this' => $std,
				'sample' => 'hello state',
			]);
		$param = $state->getParam();
		$this->assertFalse(isset($param['_this']->a));
		$this->assertFalse(isset($param['_this']->b));
		$this->assertSame ('hello state', $param['sample']);
    }
    public function testThis()
    {
		$std = new \stdClass();
		$std->a = 'Apple';
		$std->b = 'Ringo';
		$state = new State([
				'_this' => $std,
				'sample' => 'hello state',
			]);
		$ctrl = $state->getThis();
		$this->assertSame('Apple', $ctrl->a);
		$this->assertSame('Ringo', $ctrl->b);
    }
}
