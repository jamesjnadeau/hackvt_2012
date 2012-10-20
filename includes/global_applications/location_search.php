<?php 

include_once($GLOBALS['includes_root']."/classes/location.class.php");

function location_search($radius = 10)
{
	$display_form = location_search_process($radius);
	
	if($display_form)
	{
		
		location_search_form();
	}
	
}

function location_search_form()
{
	$GLOBALS['site_js_footer']['geolocate'] = "/global_js/location.js";
	echo '<div class="error hidden geolocate_notification" ></div>';
	
	echo '<hr class="clear space" />';
	
	echo '<form class="location_form"  action="/" >';
		
		echo '<div class="">';
			echo '<input type="submit" class="green button large" name="change_milage" value="Search Around Me"  />';
		echo '</div>';
		
		echo '<input type="hidden" name="description" value="" />';
		echo '<input type="hidden" class="location_current_form" name="location_current" value="" />';
		echo '<input type="hidden" class="location_accuracy_form" name="location_accuracy" value="" />';
	echo '</form>';
	echo '<hr class="clear space" />';
}


function location_search_process($radius)
{
	if(isset($_REQUEST['location_current']))
	{
		$_SESSION['last_location'] = $_REQUEST['location_current'];
		$location = new Location();
		list($latitude, $longitude) = explode(',', $_REQUEST['location_current']);
		$info = $location->search($latitude, $longitude, $radius);
		
		foreach($info as $value)
		{
			$output[] = array(
				'Name'=> '<a href="location_view.php?id='.$value['id'].'" >'.$value['name'].'</a>',
				'Distance' => number_format($value['distance'], 2).' miles',
				'Description'=>substr($value['description'], 0,300).'<a href="location_view.php?id='.$value['id'].'" > view more...</a>',
				'Hours' => $value['hours'],
				'Address' => '<a href="https://maps.google.com/?q='.urlencode($value['address']).'" >'.$value['address'].'</a>',
				'URL' => '<a href="'.$value['url'].'" >'.$value['url'].'</a>'
				
				);
			$locations[] = array( 'info' => "<a href='".$url."' >".$value['name']."</a><br/>".
										"<a class='button blue' href='tel:".$value['phone']."' >".$value['phone'].'</a>',
								'lat' => $value['latitude'],
								'long' => $value['longitude'],
							);
		}
		//echo '<hr/>';
		echo '<div class="mobile_map" class="span-23">';
			//show_map($locations, $latitude.', '.$longitude, 'map', '100%', '400px', 'true', true, 12);
			include_once($GLOBALS['includes_root']."/global_applications/google_maps.php");
			app_google_my_location_map($locations, $_REQUEST['location_current'], 'map', '100%', '400px', 'true', true, 14);
			//show_map($locations, $_REQUEST['location_current'], 'map', '100%', '400px', 'true', true, 14);
		echo '</div>';
		echo '<hr class="space" />';
		html_table($output);
		return false;
	}
	return true;
}
