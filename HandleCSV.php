<?php
Class HandleCSV {

	public $mimeError = false;
	public $dataError = false;
	private $_uploadedFile;
	public $graphData = array();
	
	public function __construct() {
		$this->checkFile();
		//if the file type is valid
		if (!$this->mimeError) {
			$this->processCSV();
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
			$this->_uploadedFile = $file['tmp_name'];
		}
	}
	
	private function processCSV() {
		$handle = fopen($this->_uploadedFile, "r") or die("couldn't open CSV file");
		//grab all lines of CSV file
		$count = 0;
		while (!feof($handle)) {
			$data = fgetcsv($handle,0,",");
			//add current line of data if valid or flag error
			if (is_array($data)) {
				if (is_string($data[0]) && is_numeric($data[1]) && is_numeric($data[2])) {
					$data[1] = (int)$data[1];
					$data[2] = (int)$data[2];
					array_push ($this->graphData,$data);
				} else {
					$this->dataError = true;
				}
			}
		}
	}

}
?>