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
	/**
	 * [buildCss Builds style from provided properties array]
	 * @return [string] [Returns build style]
	 */
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
			throw new Exception("Styles model, buildCss => " + $e->getMessage());
		}
		return false;
	}
	/**
	 * [rebuildCss Iterates through new CSS properties and adds or updates existing css]
	 * 
	 * @return [array] [Returns array with CSS property names as keys and properties as values.]
	 */
	public function rebuildCss() {
		try
		{
			$innerCssArray = $this->request->get("innerCssArray");
			$properties = $this->request->get("properties");

			foreach($properties as $key => $value)
			{
				$innerCssArray[$key] = $value;
			}

			return $innerCssArray;

		}
		catch(Exception $e)
		{
			throw new Exception("Styles model, rebuildCss => " + $e->getMessage());
		}
	}
	/**
	 * [updateCssBySelector This method uses file_get_contents to load css file into string. Using preg_match
	 * the existing CSS for given selector is extracted and loaded into an array. From there the new CSS is
	 * add and/or updated. This method does not delete any existing CSS, it only updates or adds.]
	 * 
	 * @return [mixed] [Returns false if match is not found. Returns a string if match is found.]
	 */
	public function updateCssBySelector()
	{
		try
		{
			$fileContents = file_get_contents(API_USER_STYLESHEETS . DIRECTORY_SEPARATOR . $this->request->get('fileName') . ".css");
			$regex = "/(" . $this->request->get('cssSelector') . "{1}\s{(?<innerCss>(\s\t.*?){1,}\s)}){1}/";
			
			if(!$this->findCssSelector($this->request->get('cssSelector'), $fileContents))
			{
				// No match is found, return false.
				return false;
			}
			else
			{
				$innerCssArray = array();
				
				$innerCss = explode("\n", $matches['innerCss']);
				foreach($innerCss as $row)
				{
					$rowExplode = explode(":", $row);
					if($row != "")
					{
						$innerCssArray[trim($rowExplode[0], "\t")] = rtrim($rowExplode[1], ";");
					}
				}
				// store this value in $request object
				$this->request->set("innerCssArray", $innerCssArray);
				// Rebuild CSS
				$rebuiltCssArray = $this->rebuildCss();
				if(is_array($rebuiltCssArray))
				{
					$this->request->set("properties", $rebuiltCssArray);
					$replacementCss = $this->buildCss();
					$updateCssFile = preg_replace($regex, rtrim($replacementCss, "\n"), $fileContents);
					return $updateCssFile;

				} else {
					return false;
				}

			}
		}
		catch (Exception $e)
		{
			throw new Exception("Styles Model, updateCssBySelector => " . $e.getMessage());
		}
	}
	/**
	 * [removeCssBySelector This method searches for CSS style within given filename and removes it.
	 *  Then it will return updated CSS string.]
	 * @return [mixed] [Returns false if no match is found or a string with updated content if match is found.]
	 */
	public function removeCssBySelector()
	{
		try
		{
			$fileContents = file_get_contents(API_USER_STYLESHEETS . DIRECTORY_SEPARATOR . $this->request->get('fileName') . ".css");
			$regex = "/(" . $this->request->get('cssSelector') . "{1}\s{(?<innerCss>(\s\t.*?){1,}\s)}){1}/";
			
			if(!$this->findCssSelector($this->request->get('cssSelector'), $fileContents))
			{
				// No match is found, return false.
				return false;
			}
			else
			{
				$updatedCSS = preg_replace($regex, "", $fileContents);
				return $updatedCSS;
			}

		}
		catch (Exception $e)
		{
			throw new Exception("Styles Model, removeCssBySelector => " . $e.getMessage());
		}
	}
	/**
	 * [findCssSelector utility method used to find given CSS selector in current CSS file.
	 * You can pass in the file contents or leave it null and the current request fileName
	 * will be used to retrieve the file contents.]
	 * @param  [string] $selectorName [CSS Selector]
	 * @param  [string] $fileContents [Optional CSS file contents to match selector name in.]
	 * @return [boolean]               [True if selector is found, otherwise false.]
	 */
	public function findCssSelector($selectorName, $fileContents = NULL) {
		$_fileContents = $fileContents != NULL ? $fileContents : file_get_contents(API_USER_STYLESHEETS . DIRECTORY_SEPARATOR . $this->request->get('fileName') . ".css");
		$regex = "/(" . $this->request->get('cssSelector') . "{1}\s{(?<innerCss>(\s\t.*?){1,}\s)}){1}/";
		$matchFound = preg_match($regex, $_fileContents, $matches);
		if($matchFound === false ||  $matchFound == 0)
			{
				// No match is found, return false.
				return false;
			}
			else
			{
				return true;
			}
	}

	/**
	 * [checkFile Checks to see if provided stylesheet exists in the user_content directory.]
	 * @return [boolean] [True if file exists, false if it does not.]
	 */
	public function checkFile()
	{
		if(file_exists(API_USER_STYLESHEETS . DIRECTORY_SEPARATOR . $this->request->get("fileName") . ".css"))
		{
			return true;
		}
		return false;
	}
	/**
	 * [openFile Helper method to open given file name.]
	 * @param  [string] $fileName [File name for given user style sheet]
	 * @param  [string] $flag     [PHP fopen flag]
	 * @return [handle]           [fopen handle]
	 */
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
	/**
	 * [closeFile Closes open handle created by PHP function fopen.]
	 * @param  [type] $handle [PHP handle created by fopen.]
	 * @return [boolean]         [If handle closes return true.]
	 */
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
	/**
	 * [writeToFile Helper method to use PHP fwrite function to write data to file.]
	 * @param  [handle] $handle [PHP handle created by fopen function.]
	 * @param  [string] $data   [styles to write to file]
	 * @return [boolean]        [Returns true if content successfully writes to file.]
	 */
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