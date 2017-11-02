function sortByDate() {
	$( '.position_sorting' ).change(function() {
	  	pos = 'sort=' + $('.position_sorting').val();
  		window.location.href = '?' + pos;
	});
}

function filterMarketplace() {
	$( '.position_marketplace' ).change(function() {
		pos = 'position_marketplace=' + $('.position_marketplace').val();
		pos += '&position_brand=' + $('.position_brand').val();
		pos += '&position_sent_amazon=' + $('.position_sent_amazon').val();
		window.location.href = '?' + pos;
	});
}

function filterBrand() {
	$( '.position_brand' ).change(function() {
		pos = 'position_marketplace=' + $('.position_marketplace').val();
		pos += '&position_brand=' + $('.position_brand').val();
		pos += '&position_sent_amazon=' + $('.position_sent_amazon').val();
		window.location.href = '?' + pos;
	});
}

function filterSentAmazon() {
	$( '.position_sent_amazon' ).change(function() {
		pos = 'position_marketplace=' + $('.position_marketplace').val();
		pos += '&position_brand=' + $('.position_brand').val();
		pos += '&position_sent_amazon=' + $('.position_sent_amazon').val();
		window.location.href = '?' + pos;
	});
}

function getAndUpdateOrders() {
	
	$('#wait').show();

	console.clear();
	var datepickerCreatedAfter = $("#datepickerCreatedAfter").datepicker("getDate");
	var datepickerLastUpdatedAfter = $("#datepickerLastUpdatedAfter").datepicker("getDate");
	
	var dateCreatedAfter = $.datepicker.formatDate("yy-mm-dd", datepickerCreatedAfter);
	var dateLastUpdatedAfter = $.datepicker.formatDate("yy-mm-dd", datepickerLastUpdatedAfter);
	
	$.getJSON("amazonintegration/save-amazon-orders?dateCreatedAfter=" + dateCreatedAfter + "&dateLastUpdatedAfter=" + dateLastUpdatedAfter)
	     .done(function (data) {
	    	 console.log(data);
	    	 $('#wait').hide();
//	    	 location.reload();
	     })
	     .fail(function (data) {
	    	 console.log(data.responseText);
	    	 $('#wait').hide();
//	    	 location.reload();
	     })     
}

function initDatepiker() {
	$( function() {
	    
		$( "#datepickerCreatedAfter" ).datepicker({
	    		onSelect: function(date) {
	    			$( "#datepickerLastUpdatedAfter" ).val('');
			     }});
		
		$('#datepickerCreatedAfter').datepicker('setDate', 'today');
	   
		$( "#datepickerLastUpdatedAfter" ).datepicker({
    		onSelect: function(date) {
    			$( "#datepickerCreatedAfter" ).val('');
		     }});
	  });
}


