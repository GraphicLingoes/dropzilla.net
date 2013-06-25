<?
class Default_Controller extends Base_Controller {
	/**
	 * Run our request
	 *
	 * @param  string $url
	 */
	public function dispatch($url, $default_data = array())
	{
		try {
			if (!parent::$router) {
				throw new Exception("Router not set");
			}
			$route = parent::$router->getRoute($url);

			$controller = ucfirst($route['controller']);
			$action = ucfirst($route['action']);
			unset($route['controller']);
			unset($route['action']);

			// Get our model
			//$model = $this->getModel($controller);

			//$data = $model->{$action}($route);
			//$data = $data + $default_data;
			//extract($default_data, EXTR_SKIP);
			// Get our view
			parent::setViewVars(array(
					"testVariable" => "set from dispatch",
					"innerArray" => array("testing" => "Inner Array", "anotherIndex" => "Testing")
				));
			parent::setTemplate('DropzillaMain');
			parent::getView($controller, $action);
			parent::render();

		} catch (Exception $e) {
			echo $e->getMessage();
			try {
				if ($url != '/error') {
					$data = array('message' => $e->getMessage());
					$this->dispatch("/error", $data);
				} else {
					throw new Exception("Error Route undefined");
				}
			} catch (Exception $e) {
				echo "<h1>An unknown error occurred.</h1>";
			}

		}
	}
}