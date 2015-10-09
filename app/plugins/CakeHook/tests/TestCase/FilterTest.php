<?php
namespace Community\Test\TestCase\Controller;

use CakeHook\Filter;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\ArticleImagesController Test Case
 */
class FilterTest extends IntegrationTestCase
{
	public function setUp() {
		parent::setUp();
		Filter::clear();
	}
    /**
     * @return void
     */
    public function testAddSimple(){
		$label = 'admin_menu_list';
		$index = 101;
		Filter::add($label, $index, function(\CakeHook\FilterState $state){
			$menuList = [
				(object)[
					'name' => 'Dashboard',
					'url' => '/mochi/',
				],
			];
			return $menuList;
		});
		$menuList = Filter::filter($label);
		$this->assertSame('Dashboard', $menuList[0]->name);
		$this->assertSame('/mochi/', $menuList[0]->url);
    }
    public function testAddMutliIndes_pt1(){
		$label = 'admin_menu_list';
		$index = 101;
		Filter::add($label, $index, function(\CakeHook\FilterState $state){
			$beforeMenuList = $state->getReturn();
			$menuList = [
				(object)[
					'name' => 'Dashboard',
					'url' => '/mochi/',
				],
			];
			if(is_array($beforeMenuList)){
				$menuList = array_merge($beforeMenuList, $menuList);
			}
			return $menuList;
		});
		$index = 102;
		Filter::add($label, $index, function(\CakeHook\FilterState $state){
			$beforeMenuList = $state->getReturn();
			$menuList = [
				(object)[
					'name' => 'プラグイン',
					'url' => '/mochi/plugins',
				],
				(object)[
					'name' => 'プラグインインストール',
					'url' => '/mochi/plugins_install',
				],
			];
			if(is_array($beforeMenuList)){
				$menuList = array_merge($beforeMenuList, $menuList);
			}
			return $menuList;
		});
		$menuList = Filter::filter($label);
		$this->assertSame('Dashboard', $menuList[0]->name);
		$this->assertSame('/mochi/', $menuList[0]->url);
		$this->assertSame('プラグイン', $menuList[1]->name);
		$this->assertSame('/mochi/plugins', $menuList[1]->url);
		$this->assertSame('プラグインインストール', $menuList[2]->name);
		$this->assertSame('/mochi/plugins_install', $menuList[2]->url);
    }
	/**
	 * 同じindexを指定した場合自動で次のindexで登録されているか
	 */
    public function testAddMutliIndes_pt2(){
		$label = 'admin_menu_list';
		$index = 101;
		Filter::add($label, $index, function(\CakeHook\FilterState $state){
			$beforeMenuList = $state->getReturn();
			$menuList = [
				(object)[
					'name' => 'Dashboard',
					'url' => '/mochi/',
				],
			];
			if(is_array($beforeMenuList)){
				$menuList = array_merge($beforeMenuList, $menuList);
			}
			return $menuList;
		});
		$index = 101;
		Filter::add($label, $index, function(\CakeHook\FilterState $state){
			$beforeMenuList = $state->getReturn();
			$menuList = [
				(object)[
					'name' => 'プラグイン',
					'url' => '/mochi/plugins',
				],
				(object)[
					'name' => 'プラグインインストール',
					'url' => '/mochi/plugins_install',
				],
			];
			if(is_array($beforeMenuList)){
				$menuList = array_merge($beforeMenuList, $menuList);
			}
			return $menuList;
		});
		$menuList = Filter::filter($label);
		$this->assertSame('Dashboard', $menuList[0]->name);
		$this->assertSame('/mochi/', $menuList[0]->url);
		$this->assertSame('プラグイン', $menuList[1]->name);
		$this->assertSame('/mochi/plugins', $menuList[1]->url);
		$this->assertSame('プラグインインストール', $menuList[2]->name);
		$this->assertSame('/mochi/plugins_install', $menuList[2]->url);
    }
    public function testAddMaximumIndex(){
		$label = 'sayHello';
		$index = 1000000;
		try{
			Filter::add($label, $index, function(\CakeHook\FilterState $state){
				return 'hello';
			});
			$this->fail('PHPUnit fail');
		} catch (\Exception $ex) {
			$this->assertSame('Failed add in Filter class over max index. Not Index :' . $index, $ex->getMessage());
		}
    }
	public function testAddWithParam(){
		$label = 'sayHello';
		$index = 101;
		Filter::add($label, $index, function(\CakeHook\FilterState $state){
			$param = $state->getParam();
			$name = $param['name'];
			return $name . ':hello';
		});
		$this->assertSame('yamada:hello', Filter::filter($label, ['name' => 'yamada']));
	}
    public function testOverwrite(){
		$label = 'sayHello';
		$index = 100;
		Filter::add($label, $index, function(\CakeHook\FilterState $state){
			return 'hello';
		});
		$index = 100;
		Filter::overwrite($label, $index, function(\CakeHook\FilterState $state){
			return $state->getReturn() . ' world';
		});
		$this->assertSame(' world', Filter::filter($label));
    }
    public function testRemove(){
		$label = 'sayHello';
		$index = 10;
		Filter::add($label, $index, function(\CakeHook\FilterState $state){
			return 'hello';
		});
		$index = 11;
		Filter::add($label, $index, function(\CakeHook\FilterState $state){
			return $state->getReturn() . ' world';
		});
		Filter::remove($label, 11);
		$this->assertSame('hello', Filter::filter($label));
    }
    public function testIs(){
		$label = 'sayHello';
		$index = 10;
		Filter::add($label, $index, function(\CakeHook\FilterState $state){
			return 'hello';
		});
		$this->assertTrue(Filter::is($label));
    }
}


