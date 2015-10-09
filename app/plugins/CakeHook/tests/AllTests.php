<?php
namespace Community\Test;


class AllTests extends \PHPUnit_Framework_TestCase{ 
//		$dir = new Folder(__DIR__);
//		$dirs = $dir->findRecursive('All.*Test.php',true);
//		
//		foreach($dirs as $filepath){
//			if(strpos($filepath, 'AllTestsTest.php') !== false) continue;
//			$suite->addTestFile($filepath);
//		}
	

  public static function suite() {
	$suite = new \PHPUnit_Framework_TestSuite( 'all tests' );
		$folder = dirname( __FILE__ ) . '/';
		$fileList = self::list_files($folder);
		foreach($fileList as $filepath){
			if(preg_match("/.*AllTests.php$/", $filepath))continue;
			echo "filepath:" . $filepath . PHP_EOL;
			$suite->addTestFile( $filepath );
		}
//		$suite->addTestFile( $folder . 'lib/model/moreTest.php' );
		return $suite;	

    return $suite;
  }
	static function list_files($dir){
		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator(
				$dir,
				\FilesystemIterator::SKIP_DOTS
				| \FilesystemIterator::KEY_AS_PATHNAME
				| \FilesystemIterator::CURRENT_AS_FILEINFO
			), \RecursiveIteratorIterator::LEAVES_ONLY
		);

		$list = array();
		foreach($iterator as $pathname => $info){
			$list[] = $pathname;
		}
		return $list;
	}
}
