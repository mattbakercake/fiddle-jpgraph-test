<?php
class ScatterGraph {
	
	/**
	 * Class properties
	 */
	private $_imageHandle; //stores GD image handle

	/**
	 * Constructor
	 */
	public function __construct($graphData) {
		$this->createGraph($graphData);
		print_r($graphData);//### where we're at = csv data ########
	}
	
	/**
	 * Generates graph a stores GD handle to image
	 */
	public function createGraph() {
		require_once ('jpgraph/jpgraph.php');
		require_once ('jpgraph/jpgraph_scatter.php');

		$datax = array(3.5,3.7,3,4,6.2,6,3.5,8,14,8,11.1,13.7);
		$datay = array(20,22,12,13,17,20,16,19,30,31,40,43);

		$graph = new Graph(300,200);
		$graph->SetScale("linlin");

		$graph->img->SetMargin(40,40,40,40);		
		$graph->SetShadow();

		$graph->title->Set("A simple scatter plot");
		$graph->title->SetFont(FF_FONT1,FS_BOLD);

		$sp1 = new ScatterPlot($datay,$datax);

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
		
		echo '<img src="data:image/png;base64,' . base64_encode($image) . '"';
	}
	
}
?>