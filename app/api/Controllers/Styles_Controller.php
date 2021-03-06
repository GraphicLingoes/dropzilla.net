<?
class Styles_Controller extends Base_Controller {

	public function action_index () {
		echo 'made it to action index';

	}

	public function action_aggregate () {
		// Check if css file exist
		// Check if selector exist
		// If selector exist call update
		// If not call add
		// 
		// 
		// TODO: Add logic for adding link css properties
		// a new property has been added to the request called isLink
		// if this property is set then logic needs to be added
		// to handle adding each link property to the css file separately
		
		$response = parent::$response;
		$request = parent::$request;
		$model = parent::getModel('Styles', 'Styles');
		// Check to see if file exists
		if ($model->checkFile()) {
			// Check to see if selector exists to determine what to do.
			if ($model->findCssSelector($request->get("cssSelector"))) {
				$this->action_update();
			} else {
				$this->action_add();
			}
		}
	}

	public function action_add () {
		$response = parent::$response;
		$request = parent::$request;
		$model = parent::getModel('Styles', 'Styles');
		// Attempt to build css
		$handle = $model->openFile(parent::$request->get("fileName"), "a+");
		$css = $model->buildCss();
			
		if ($model->writeToFile($handle, $css))
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
		$response = parent::$response;
		$request = parent::$request;
		$model = parent::getModel('Styles', 'Styles');
		$updatedCss = $model->updateCssBySelector();
		$handle = $model->openFile(parent::$request->get("fileName"), "w");
		if ($model->writeToFile($handle, $updatedCss))
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
	}

	public function action_delete () {
		$response = parent::$response;
		$request = parent::$request;
		$model = parent::getModel('Styles', 'Styles');
		$updatedCss = $model->removeCssBySelector();
		$handle = $model->openFile(parent::$request->get("fileName"), "w");
		if ($model->writeToFile($handle, $updatedCss))
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
	}

};