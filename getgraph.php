<?php
if (isset($_POST['graphDataStr']) && isset($_POST['filters'])) {
	require_once("lib/ScatterGraph.php");
	require_once("lib/HandleCSV.php");
	
	$graphDataStr = $_POST['graphDataStr'];
	$types = $_POST['filters'];
	
	//recreate graphData Multi-dimensional array
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
	
	$data = new HandleCSV();
	$data->graphData = $graphData;
	$x = $data->getDataXStr($types);
	$y = $data->getDataYStr($types);
	
	$graph = new ScatterGraph($x,$y);
	
	return print($graph->outputGraph());
}
?>