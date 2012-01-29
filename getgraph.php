<?php
/**
 *
 * Script called via AJAX via index.html to return re-plotted
 * graph for display if filters selected.  Checks required
 * post variables are set before executing
 *
 */ 
if (isset($_POST['graphDataStr']) && isset($_POST['filters'])) {
	require_once("lib/ScatterGraph.php");
	require_once("lib/HandleCSV.php");
	
	$graphDataStr = $_POST['graphDataStr'];
	$types = $_POST['filters'];
	
	/**
	 * Reform string containing graph data into
	 * multidimensional array containing type and
	 * x & y axis for each data row
	 */
	$graphData = array();
	$graphDataStr = split(",",$graphDataStr);
	$group = array();
	$count = 0;
	foreach ($graphDataStr as $value) {
		$group[$count] = $value;
		if ($count > 1) {
			array_push($graphData,$group);
			$count = 0;
		} else {
			$count++;
		}
	}
	
	//instantiate new CSV object and get x & y data back
	$data = new HandleCSV();
	$data->graphData = $graphData;
	$x = $data->getDataXStr($types);
	$y = $data->getDataYStr($types);
	
	//instantiate new graph object with data
	$graph = new ScatterGraph($x,$y);
	
	//return the graph image to calling function
	return print($graph->outputGraph());
}
?>