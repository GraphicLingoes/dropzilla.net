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
			$fileName = $this->request->get("fileName") . ".css";
			$css = $cssSelector . " {\n";
			foreach($properties as $key => $value)
			{
				$css .= "\t" . $key . ":" . $value . ";\n";
			}
			$css .= "}\n";
			$handle = fopen(API_USER_STYLESHEETS . DIRECTORY_SEPARATOR . $fileName, "a+");
			fwrite($handle, $css);
			fclose($handle);
			return true;
		}
		catch(Exception $e)
		{
			throw new Exception("file not found!" + $e->getMessage());
		}
		return false;
	}

	public function updateCssBySelector()
	{
		
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

}