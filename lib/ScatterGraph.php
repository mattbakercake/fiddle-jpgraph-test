<?php
class ScatterGraph {
	
	/**
	 * Class properties
	 */
	private $_imageHandle; //stores GD image handle
	private $_dataX = array();
	private $_dataY = array();

	/**
	 * Constructor
	 */
	public function __construct($x,$y) {
		$this->setDataX($x);
		$this->setDataY($y);
		$this->createGraph($this->_dataX,$this->_dataY);
	}
	
	
	/**
	 * Generates graph a stores GD handle to image
	 */
	public function createGraph($x,$y) {

		require_once ('jpgraph/jpgraph.php');
		require_once ('jpgraph/jpgraph_scatter.php');
		
		$graph = new Graph(300,200);
		$graph->SetScale("linlin");

		$graph->img->SetMargin(40,40,40,40);		
		$graph->SetShadow();

		$graph->title->Set("A simple scatter plot");
		$graph->title->SetFont(FF_FONT1,FS_BOLD);

		$sp1 = new ScatterPlot($y,$x);

		$graph->Add($sp1);
		
		//create graph image and store handle 
		$this->_imageHandle = $graph->Stroke(_IMG_HANDLER);
	}
	
	/**
	 * Outputs graph image to browser
	 *
	 * Uses output buffering to capture raw png data into variable
	 * then encodes it into base64 and outputs to browser as an
	 * image
	 */
	public function outputGraph() {
		ob_start();
		imagepng($this->_imageHandle);
		$image = ob_get_contents();
		ob_end_clean();
		
		return '<img src="data:image/png;base64,' . base64_encode($image) . '"/>';
	}
	 
	/**
	 * Sets x axis data array from string
	 */
	 public function setDataX($data) {
		$this->_dataX = split(",",$data);
	 }

	/**
	 * Sets y axis data array from string
	 */
	 public function setDataY($data) {
		$this->_dataY = split(",",$data);
	 }
}
?>