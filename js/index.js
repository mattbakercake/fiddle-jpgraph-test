/**
 * JavaScript functions for index.html
 */
function checksubmit(graphDataStr) {
	//If a file has been chosen to upload - allow form to submit
	if (document.getElementById('upload').value != "") {
		return true;
	} else {
		//grab multiple selected filter items
		var filter = document.getElementById('filter');
		var selected = new Array();
		var count = 0;
		for (var i=0; i<filter.options.length; i++) {
			if (filter.options[i].selected) {
				selected[count] = filter.options[i].value;
				count++;
			}
		}
		
		/**
		 * jQuery function to get reformatted graph using AJAX
		 * and replace current one in page
		 */
		$.post(
			'getgraph.php',
			{graphDataStr: graphDataStr, filters: selected},
			function(image) {
				$('#graphdiv').html(image);
			} 
		);
		
		//prevent form submitting
		return false;
	}
}