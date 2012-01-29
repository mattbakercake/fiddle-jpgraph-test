function checksubmit(graphDataStr) {
	if (document.getElementById('upload').value != "") {
		return true;
	} else {
		var filter = document.getElementById('filter');
		var selected = new Array();
		var count = 0;
		for (var i=0; i<filter.options.length; i++) {
			if (filter.options[i].selected) {
				selected[count] = filter.options[i].value;
				count++;
			}
		}
		
		$.post(
			'getgraph.php',
			{graphDataStr: graphDataStr, filters: selected},
			function(image) {
				$('#graphdiv').html(image);
			} 
		);
		
		return false;
	}
}