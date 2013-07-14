<?
class StylesModel {
	/**
	 * [$request private data store for request body content]
	 * @var boolean
	 */
	private $request = false;

	/**
	 * [__construct Constructor method for Styles Model class. Set request body content to private member for easy access.]
	 * @param Request $request [Data store object that contains request body content.]
	 */
	public function __construct(Request $request)
	{
		if(is_a($request, 'Request'))
		{
			$this->request = $request;
		}
	}

	public function buildCss()
	{
		try
		{
			$cssSelector = $this->request->get("cssSelector");
			$properties = $this->request->get("properties");
			$css = $cssSelector . " {\n";
			foreach($properties as $key => $value)
			{
				$css .= "\t" . $key . ":" . $value . ";\n";
			}
			$css .= "}\n";
		 	return $css;
		}
		catch(Exception $e)
		{
			throw new Exception("file not found!" + $e->getMessage());
		}
		return false;
	}

	public function updateCssBySelector($params)
	{
		// Find css and extract it from selector
		// Iterate throuh extracted css to update or add css without getting rid of what exists already
		// Use preg_replace to update selector in same position it was originally in
		// Write update content back to file
		if(is_array)
		{
			$fileContents = file_get_contents($params['fileName']);
			
		}
		
	}

	public function removeCssBySelector()
	{

	}

	private function checkFile()
	{
		if(file_exists(API_USER_STYLESHEETS . DIRECTORY_SEPARATOR . $this->request->get("fileName") . ".css"))
		{
			return true;
		}
		return false;
	}

	public function openFile($fileName, $flag)
	{
		try
		{
			$handle = fopen(API_USER_STYLESHEETS . DIRECTORY_SEPARATOR . $fileName . ".css", $flag);
			return $handle;
		}
		catch(Exception $e)
		{
			throw new Exception("Error opening user style sheet: " + $e->getMessage());
		}
	}

	public function closeFile($handle)
	{
		try
		{
			fclose($handle);
			return true;
		}
		catch(Exception $e)
		{
			throw new Exception("Error closing user style sheet: " + $e->getMessage());
		}
	}

	public function writeToFile($handle, $data)
	{
		try
		{
			fwrite($handle, $data);
			return true;
		}
		catch(Exception $e)
		{
			throw new Exception("Error writing user style sheet: " + $e->getMessage());
		}
	}

}