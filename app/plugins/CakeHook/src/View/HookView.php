<?php
namespace CakeHook\View;
use Cake\View\View;
use Cake\Utility\Inflector;

class HookView extends View  
{
	public function implementedEvents() {
		return array(
			'View.beforeRender' => 'beforeRender',
		);
	}
//	public function __construct(Controller $controller = null) {
//		parent::__construct($controller);
//		
//		CakeEventManager::instance()->attach($this);
//	}
	public function beforeRender(){
//		$path = Lang::getInstance()->getBasePath();
//		array_splice($this->_paths, 1, 0, $path);
//		echo "beforeREnder<br>";ore
//		var_dump($this->_paths);
	}
    protected function _getViewFileName($name = null)
    {
        $viewPath = $subDir = '';

        if ($this->subDir !== null) {
            $subDir = $this->subDir . DS;
        }
        if ($this->viewPath) {
            $viewPath = $this->viewPath . DS;
        }

        if ($name === null) {
            $name = $this->view;
        }
        list($plugin, $name) = $this->pluginSplit($name);
        $name = str_replace('/', DS, $name);

        if (strpos($name, DS) === false && $name[0] !== '.') {
            $name = $viewPath . $subDir . Inflector::underscore($name);
        } elseif (strpos($name, DS) !== false) {
            if ($name[0] === DS || $name[1] === ':') {
                if (is_file($name)) {
                    return $name;
                }
                $name = trim($name, DS);
            } elseif (!$plugin || $this->viewPath !== $this->name) {
                $name = $viewPath . $subDir . $name;
            } else {
                $name = DS . $subDir . $name;
            }
        }
		$paths = $this->initThemeBasePath($this->_paths($plugin));
        foreach ($paths as $path) {
            if (file_exists($path . $name . $this->_ext)) {
                return $this->_checkFilePath($path . $name . $this->_ext, $path);
            }
        }
        throw new Exception\MissingTemplateException(['file' => $name . $this->_ext]);
    }
	protected function initThemeBasePath($paths){
		return array_merge(\CakeHook\TemplatePath::get(), $paths);
	}
	/**
	 * コントローラー時の呼び出しはelementではなくこの関数を使う
	 * @param type $name
	 * @param type $data
	 * @param type $options
	 * @return type
	 */
	public function elementForController($name, $data = array(), $options = array()){
		$this->initThemeBasePath();
		return $this->element($name, $data, $options);
	}
	public function hello(){
		echo "hello";
	}
}
