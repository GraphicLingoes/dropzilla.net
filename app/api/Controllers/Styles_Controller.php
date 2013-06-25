<?
class Styles_Controller extends Base_Controller {

	public function action_index () {
		echo 'made it to action index';

	}

	public function action_add () {
		$response = parent::$response;
		$request = parent::$request;
		$model = parent::getModel('Styles', 'Styles');
		// Attempt to build css
		if($model->buildCss())
		{
			$response->set('result', array(
				"passed" => 1
			));
			$response->renderResonse();
		}
		else
		{
			$response->set('error', "1");
		}
		
		/*
		
		{"fileName": "test", "cssSelector": "#testSelector","properties":{"float":"left","padding":"9px","border":"1px solid #000"}}
		 */
	}

	public function action_update () {
		$response = parent::$response;
		$request = parent::$request;
		$fileName = $request->get("fileName") . ".css";
		$cssSelector = $request->get("cssSelector");
		$fileContents = file_get_contents(API_USER_STYLESHEETS . DIRECTORY_SEPARATOR . $fileName);
		$regex = "/^(?P<class>" . $cssSelector . "\s*{\n*\r*(?:\n*\r*\t.*\n*\r*)+})/";
		$newFileContents = preg_replace($regex, "", $fileContents);
		echo trim($newFileContents, "\n");
	}

	public function action_delete () {
		$response = parent::$response;
		$request = parent::$request;
		$fileName = $request->get("fileName") . ".css";
		$cssSelector = $request->get("cssSelector");
		//$fileContents = file(API_USER_STYLESHEETS . DIRECTORY_SEPARATOR . $fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		$fileContents = file_get_contents(API_USER_STYLESHEETS . DIRECTORY_SEPARATOR . $fileName);
		$regex = "/^(?P<class>" . $cssSelector . "\s*{\n*\r*(?:\n*\r*\t.*\n*\r*)+})/";
		$newFileContents = preg_replace($regex, "", $fileContents);
		echo trim($newFileContents, "\n");

	}

};