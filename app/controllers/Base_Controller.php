<?
Abstract class Base_Controller {
	/**
	 * @var  RouterAbstract
	 */
	static protected $router = false;
	/**
	 * [puesdo global variable store for current view]
	 * @var array
	 */
	static protected $_globalVars = array();
	/**
	 * [static protected template store for template name to be used in view rendering]
	 * @var mixed
	 */
	static protected $_template = false;
	/**
	 * [static protected store for compiled view to be used in static render method]
	 * @var mixed
	 */
	static protected $_viewStore = "";

	/**
	 * Set the router
	 *
	 * @param  RouterAbstract $router
	 */
	static public function setRouter(RouterRegex $router)
	{
		self::$router = $router;
		//echo '<pre>' . print_r(self::$router, 1) . '</pre>';
	}

	static public function setTemplate($template) {
		if(isset($template)) {
			self::$_template = $template;
		}
	}

	/**
	 * Get an instantiated model class
	 *
	 * @param string $name
	 * @return mixed
	 */
	static protected function getModel($name)
	{
		$name .= '_Model';

		self::includeClass($name);
		return new $name;
	}

	/**
	 * Get an instantiated view class
	 *
	 * @param string $name
	 * @param string $action
	 * @return mixed
	 */
	static protected function getView($name, $action)
	{
		// Check to see if template should be used.
		if(self::$_template !== false) {
			$name .= '_' . $action . 'View';
			$contentTemplate = $name;
			$name = "templates_" . self::$_template;
			self::$_viewStore = self::includeClass($name, $contentTemplate);
		} else {
			// Otherwise template is not being used.
			$name .= '_' . $action . 'View';
			self::$_viewStore = self::includeClass($name);
		}
	}

	/**
	 * Include a class using PEAR naming scheme
	 *
	 * @param string $name
	 * @return  void
	 * @throws Exception
	 */
	static protected function includeClass($name, $templateContent = null)
	{
		$file = SYS_VIEWS . "/";
		$file .= str_replace('_', DIRECTORY_SEPARATOR, $name) . '.php';

		if($templateContent !== null) {
			$content = SYS_VIEWS . DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $templateContent) . '.php';
		}

		if (!file_exists($file)) {
			throw new Exception("View file not found!");
		}

		if(!empty(self::$_globalVars)) {
			extract(self::$_globalVars, EXTR_SKIP);
		}
		//self::$_viewStore = file_get_contents($file);
		require_once $file;
		//return file_get_contents($file);
	}
	/**
	 * [set description]
	 * static method used to store global access to view variables
	 * @param array $data [description]
	 */
	static protected function setViewVars($data = array()) {
		if(is_array($data)){
			if(empty(self::$_globalVars)){
				self::$_globalVars = $data;	
			} else {
				foreach ($data as $key => $val) {
					self::$_globalVars[$key] = $val;
				}
			}
		}
	}
	/**
	 * [render static protected method called from child controller to render compiled view]
	 * 
	 */
	static protected function render() {
		if(isset(self::$_viewStore)) {
			echo self::$_viewStore;
		}
	}
}