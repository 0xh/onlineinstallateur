function getAndUpdateOrders() {

	console.clear();
	var datepickerCreatedAfter = $("#datepickerCreatedAfter").datepicker("getDate");
	var datepickerLastUpdatedAfter = $("#datepickerLastUpdatedAfter").datepicker("getDate");
	
	var dateCreatedAfter = $.datepicker.formatDate("yy-mm-dd", datepickerCreatedAfter);
	var dateLastUpdatedAfter = $.datepicker.formatDate("yy-mm-dd", datepickerLastUpdatedAfter);
	
	  $.getJSON("amazonintegration/save-amazon-orders?dateCreatedAfter=" + dateCreatedAfter + "&dateLastUpdatedAfter=" + dateLastUpdatedAfter)
	     .done(function (data) {
	    	 console.log(data);
	     })
	     .fail(function (data) {
	    	 console.log(data.responseText);
		     })
}

function initDatepiker() {
	$( function() {
	    
		$( "#datepickerCreatedAfter" ).datepicker({
	    		onSelect: function(date) {
	    			$( "#datepickerLastUpdatedAfter" ).val('');
			     }});
	   
		$( "#datepickerLastUpdatedAfter" ).datepicker({
    		onSelect: function(date) {
    			$( "#datepickerCreatedAfter" ).val('');
		     }});
	  });
}


