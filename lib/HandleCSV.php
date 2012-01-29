<?php
Class HandleCSV {

	public $uploadedFile;
	public $mimeError = false;
	public $dataError = false;
	public $graphData = array();
	public $uniqueTypes = array();
	
	public function __construct() {
		
	}
	
	public function processCSV() {
		$this->checkFile();
		//if the file type is valid
		if (!$this->mimeError) {
			$this->parseCSV();
		}
	}
	
	private function checkFile() {
		$validMimes = array(
			'text/csv',
			'text/comma-separated-values',
			'application/csv',
			'application/vnd.ms-excel'
		);
		
		$file = $_FILES['upload'];
		
		//if mime type or file extension is invalid flag error
		if (!in_array($file['type'], $validMimes) || pathinfo($file['name'],PATHINFO_EXTENSION) != 'csv') {
			$this->mimeError = true;
		//otherwise store reference to temp file location
		} else {
			$this->uploadedFile = $file['tmp_name'];
		}
	}
	
	private function parseCSV() {
		$handle = fopen($this->uploadedFile, "r") or die("couldn't open CSV file");
		//grab all lines of CSV file
		$count = 0;
		while (!feof($handle)) {
			$data = fgetcsv($handle,0,",");
			//add current line of data if valid or flag error
			if (is_array($data) && count($data) == 3) {
				if (is_string($data[0]) && is_numeric($data[1]) && is_numeric($data[2])) {
					if (!in_array($data[0],$this->uniqueTypes)) {
						array_push($this->uniqueTypes,$data[0]);
					}
					$data[1] = (int)$data[1];
					$data[2] = (int)$data[2];
					array_push ($this->graphData,$data);
				} else {
					$this->dataError = true;
				}
			} 
		}
	}
	
	/**
	 * Returns x axis data for type as a string
	 */
	 public function getDataXStr($types = null) {
		$x = array();
		foreach ($this->graphData as $row) {
			if ($types == null || in_array($row[0],$types)) {
				array_push($x,$row[1]);
			}
		}
		$xStr = implode(",",$x);
		
		return $xStr;
	 }
	 
	/**
	 * Returns y axis data for type as a string
	 */
	 public function getDataYStr($types = null) {
		$y = array();
		foreach ($this->graphData as $row) {
			if ( $types == null || in_array($row[0],$types)) {
				array_push($y,$row[2]);
			}
		}
		$yStr = implode(",",$y);
		
		return $yStr;
	 }
	 
	 /**
	 * Returns graph data for as a string
	 */
	 public function getGraphDataStr() {
		$dataStr = "";
		foreach ($this->graphData as $row) {
			$dataStr .= implode(",",$row) . ",";
			
		}
		$dataStr = substr($dataStr, 0, -1);
		
		return $dataStr;
	 }

}
?>