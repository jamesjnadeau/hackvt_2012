
position_accuracy_fails = 0;
position_required_accuracy = 75;
position_request_time = 0;
position_timeout = 2000;
// this is called when the browser has shown support of navigator.geolocation
function location_accepted(position) 
{
	my_lat_long =  position.coords.latitude + ',' + position.coords.longitude;
	
	//console.log(position);
	
	if(position_accuracy_fails > 20)
	{
		$('.loading').hide();
		$('.geolocate_notification').html(
			'GPS accuracy only '  + position.coords.accuracy + ' meters'
			);
		$('.geolocate_notification').removeClass('hidden');
		$('.location_form :submit').removeAttr("disabled");
		//take lat and long and inject in form
		position_request_time = position.timestamp;
		$('.location_current_form').val(my_lat_long);
		$('.location_accuracy_form').val(position.coords.accuracy);
		$('#location_current_link').attr('href', 'http://maps.google.com/?q='+my_lat_long);
		console.log('geolocaiton failed too many times');
	}
	else if(position.coords.accuracy > position_required_accuracy)
	{
		position_accuracy_fails++;
		$('.geolocate_notification').html(
			'Unable to get geolocation accurracy within ' 
			+ position_required_accuracy + ' Meters<br/>'
			+ 'Actual ' + position.coords.accuracy + ', Try' + position_accuracy_fails
			//+ my_lat_long + '<br/>' + position.coords.accuracy
			);
		$('.geolocate_notification').removeClass('hidden');
		setTimeout(mypoint_location_get_position(), position_timeout);
	}
	else
	{
		position_request_time = position.timestamp;
		//take lat and long and inject in form
		$('.location_current_form').val(my_lat_long);
		$('.location_accuracy_form').val(position.coords.accuracy);
		
		//create google maps link
		$('#location_current_link').attr('href', 'http://maps.google.com/?q='+my_lat_long);
		$('.geolocate_notification').hide();
		$('.loading').hide();
		$('.location_form :submit').removeAttr("disabled");
	}
}

position_declined_error_count = 1;
function location_declined(error) 
{
	$('.loading').hide();
	$('.location_form :submit').attr("disabled", "disabled");
	position_declined_error_count++;
	$('.geolocate_notification').html(
		//'Error: ' + error.message
		//+ '<br/> Trying again after ' + position_declined_error_count + ' errors'
		'Unable to get your location<br/><br/>Please make sure your location services are enabled<br/><br/>If asked, please allow this site to get your location'
		);
	$('.geolocate_notification').removeClass('hidden');
	
	if (position_declined_error_count < 10)
		mypoint_location_get_position();
}

function mypoint_location_get_position()
{
	navigator.geolocation.getCurrentPosition(location_accepted, location_declined, {enableHighAccuracy:true, maximumAge:1000, timeout:10000});
}

$(document).ready(function() 
{
	//disable set location button
	$('.location_form :submit').attr("disabled", "disabled");
	
	if (navigator.geolocation) 
	{
		$('.geolocate_notification').html(
			'Trying get location this may take up to 10 seconds'
			//+ '<br/> Try number ' + position_accuracy_fails
			);
		$('.geolocate_notification').removeClass('hidden');
		mypoint_location_get_position();
	}
	else
	{
		$('#geolocate_notification').html('Your browser does not support geolocation.');
	}
	
	$('.location_form :submit').click(function() 
	{
		var current_time = new Date().getTime();
		var diff = current_time - position_request_time;
		if(diff < 10000)
		{
			console.log('time check failed with ' + diff + ' < 10000 ');
			mypoint_location_get_position();
		}
	}
	);
});
