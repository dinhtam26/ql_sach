
<?php
class Validate
{
	// Error arrays
	private $errors = [];

	// Sources arrays
	private $sources = [];

	// Rule arrays
	private $rules = [];

	// Result arrays
	private $result = [];

	// Construct
	public function __construct($sources)
	{
		if (array_key_exists('submit', $sources)) unset($sources['submit']);
		if (array_key_exists('token', $sources)) unset($sources['token']);

		$this->sources = $sources;
	}

	// Add rules
	public function addRules($rules)
	{
		$this->rules = array_merge($rules, $this->rules);
	}

	// Add rule
	public function addRule($element, $type, $options = null, $required = true)
	{
		$this->rules[$element] = ['type' => $type, 'options' => $options, 'required' => $required];
		return $this;
	}

	// Hàm lấy errors
	public function getErrors()
	{
		return $this->errors;
	}

	// Hàm lấy errors
	public function getResult()
	{
		return $this->result;
	}

	public function setError($element, $message)
	{
		if (array_key_exists($element, $this->errors)) {
			$this->errors[$element] .= " - " . $message;
		} else {
			$this->errors[$element] = "<b>" . ucfirst($element) . ":</b>" . $message;
		}
	}


	// Run
	public function run()
	{
		foreach ($this->rules as $element => $value) {
			if ($value['required'] == true && trim($this->sources[$element]) == null) {
				$this->errors[$element] = "Không được để rỗng";
			} else {
				switch ($value['type']) {
					case 'int':
						$this->validateInt($element, $value['options']['min'], $value['options']['max']);
						break;
					case 'string':
						$this->validateString($element, $value['options']['min'], $value['options']['max']);
						break;
					case 'url':
						$this->validateUrl($element);
						break;
					case 'email':
						$this->validateEmail($element);
						break;
					case 'status':
						$this->validateStatus($element, $option = null);
						break;
					case 'password':
						$this->validatePassword($element);
						break;
					case 'date':
						$this->validateDate($element, $value['options']['start'], $value['options']['end']);
						break;
					case 'group':
						$this->validateGroup($element);
						break;
					case 'recordExits':
						$this->validateRecordExits($element, $value['options']);
						break;
					case 'file':
						$this->validateFile($element, $value['options']);
						break;
				}
			}

			// Kiểm tra xem các giá trị có thuộc mảng Error k. Nếu không thì cho chúng thuộc mảng Result
			if (!array_key_exists($element, $this->errors)) {
				$this->result[$element] = $this->sources[$element];
			}
		}
		$elementNotValidate = array_diff_key($this->sources, $this->errors);
		$this->result = array_merge($elementNotValidate, $this->result);
	}



	private function validateInt($element, $min, $max)
	{
		if (!filter_var($this->sources[$element], FILTER_VALIDATE_INT, ["options" => ["min_range" => $min, "max_range" => $max]])) {
			$this->errors[$element] = $this->sources[$element] . " is an in valid integer";
		}
	}

	private function validateString($element, $min, $max)
	{
		if (!is_string($this->sources[$element])) {
			$this->errors[$element] = $this->sources[$element] . " is an invalid string";
		} else {
			if (strlen($this->sources[$element]) < $min) {
				$this->errors[$element] = $this->sources[$element] . " is too short";
			} else if (strlen($this->sources[$element]) > $max) {
				$this->errors[$element] = $this->sources[$element] . " is too long";
			}
		}
	}

	private function validateUrl($element)
	{

		if (!filter_var($this->sources[$element], FILTER_VALIDATE_URL)) {
			$this->errors[$element] = $this->sources[$element] . " is invalid Url";
		}
	}

	private function validateEmail($element)
	{

		if (!filter_var($this->sources[$element], FILTER_VALIDATE_EMAIL)) {
			$this->errors[$element] = $this->sources[$element] . " is invalid Email";
		}
	}

	private function validateStatus($element, $option)
	{


		// 0 unpublish, 1 publish, default 
		if ($this->sources[$element] == "default") {
			$this->errors[$element] =  "Vui lòng chọn $element";
		}
	}

	private function validatePassword($element)
	{
		$patternPassword = '#^(?=.*\d)(?=.*[A-Z])(?=.*\W).{8,}$#i';
		if (!preg_match($patternPassword, $this->sources[$element])) {
			$this->errors[$element] =  "Password bao gồm ký tự viết hoa, số, ký tự đặc biệt và 8 ký tự";
		}
	}

	private function validateDate($element, $start, $end)
	{
		// Start 
		$arrDateStart = date_parse_from_format('d/m/Y', $start);
		$tsStart      = mktime(0, 0, 0, $arrDateStart['month'], $arrDateStart['day'], $arrDateStart['year']) . "<br/>";

		// Current
		$arrDateCurrent = date_parse_from_format('d/m/Y', $this->sources[$element]);
		$tsCurrent      = mktime(0, 0, 0, $arrDateCurrent['month'], $arrDateCurrent['day'], $arrDateCurrent['year']);

		// End
		$arrDateEnd = date_parse_from_format('d/m/Y', $end);
		$tsEnd      = mktime(0, 0, 0, $arrDateEnd['month'], $arrDateEnd['day'], $arrDateEnd['year']) . "<br/>";

		if ($tsEnd <= $tsCurrent) {
			$this->errors[$element] = $this->sources[$element] . " is an invalid date";
		}
	}

	private function validateGroup($element)
	{
		if ($this->sources[$element] <= 0) {
			$this->errors[$element] =  "Select Group";
		}
	}

	private function validateRecordExits($element, $options)
	{
		$database = $options['database'];
		$query    = $options['query'];

		if ($database->exits($query)) {
			$this->errors[$element] = "record is exits";
		}
	}

	public function isValid()
	{
		if (count($this->errors) > 0) {
			return false;
		}
		return true;
	}

	public function validateFile($element, $options)
	{

		if (isset($this->sources[$element]) && $this->sources[$element]['error'] == 0) {
			if (!filter_var($this->sources[$element]['size'], FILTER_VALIDATE_INT, ["options" => ["min_range" => $options['min'], "max_range" => $options['max']]])) {
				$this->setError($element, " kick thước không phù hợp");
			}

			$ext = strtolower(pathinfo($this->sources[$element]['name'], PATHINFO_EXTENSION));

			if (!in_array($ext, $options['extension'])) {
				$this->setError($element, " Phần mở rộng không phù hợp");
			}
		} else {
			$this->setError($element, " Không được để trống");
		}
	}
}
