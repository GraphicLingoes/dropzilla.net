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
		// 
		$handle = $model->openFile(parent::$request->get("fileName"), "a+");
		$css = $model->buildCss();
			
		if($model->writeToFile($handle, $css))
		{
			$response->set('result', array(
				"passed" => 1
			));
		}
		else
		{
			$response->set('error', "1");
		}
		$model->closeFile($handle);
		$response->renderResonse();
		
		/*
		
		{"fileName": "test", "cssSelector": "#testSelector","properties":{"float":"left","padding":"9px","border":"1px solid #000"}}
		 */
	}

	public function action_update () {

		//TODO: Figure out how to get regex to match CSS selector for both update and delete actions



		$response = parent::$response;
		$request = parent::$request;
		$fileName = $request->get("fileName") . ".css";
		$cssSelector = $request->get("cssSelector");
		$fileContents = file_get_contents(API_USER_STYLESHEETS . DIRECTORY_SEPARATOR . $fileName);
		//$regex = "/^(?P<class>" . $cssSelector . "\s*{\n*\r*(?:\n*\r*\t.*\n*\r*)+})/";
		$regex = "/^" . "\\" .$cssSelector . "\s*{.*?(?:.*\\n)+}/s";
		$test = preg_match($regex, $fileContents, $matches);
		echo $regex;
		echo '<pre>' . print_r($matches, 1) . '</pre>';
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