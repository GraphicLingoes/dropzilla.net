<?
// Dropzilla Main index
// Set App Path
$appPath = 'app';

// Define constants
define('SYS_DEBUG', TRUE);
define('SYS_ROUTER', 'RouterRegex');
define('SYS_ROUTES', 'Routes');
define('SYS_REGISTRY', 'Registry');
define('SYS_CONTROLLERS', $appPath . '/controllers');
define('SYS_MODELS', $appPath . '/models');
define('SYS_VIEWS', $appPath . '/views');
define('SYS_TEMPLATES', SYS_VIEWS . '/templates');
define('SYS_DEFAULT_CONTROLLER', SYS_CONTROLLERS . '/Default_Controller.php');

// Include necessary app files
include_once($appPath . DIRECTORY_SEPARATOR . "Debugger.php");
include_once($appPath . DIRECTORY_SEPARATOR . SYS_ROUTER . ".php");
include_once($appPath . DIRECTORY_SEPARATOR . SYS_ROUTES . ".php");
include_once($appPath . DIRECTORY_SEPARATOR . SYS_REGISTRY . ".php");
// Set Debugger
Debugger::setMode(SYS_DEBUG);
// Instantiate Router and set routes
$routerName = SYS_ROUTER;
$routes = SYS_ROUTES;
$router = new $routerName;
$routes::addRoutes($router);
$url = $_SERVER['REQUEST_URI'];
// Determine if route exists
// TODO: figure out if this whole setup is dynamic
if($router->getRoute($url)) {
	if (!file_exists(SYS_DEFAULT_CONTROLLER)) {
		throw new Exception("Class not found!");
	} else {
		require_once SYS_CONTROLLERS . "/" . 'Base_Controller.php';
		Base_Controller::setRouter($router);
		require_once SYS_DEFAULT_CONTROLLER;
		$defaultController = new Default_Controller;
		$defaultController->dispatch($url, array("testVariable" => "This came from test variable"));

	}
}
// Create reference to registry as a global store for persistant data
$registry = SYS_REGISTRY;


// TODO: parse uri to see if the word "api" exists. If it does grab the request and route it appropriately
// Otherwise route the request to the default router



// Clean up necessary variables for next request
unset($appPath);
unset($routerName);
unset($routes);