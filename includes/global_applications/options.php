<?php 

include_once($GLOBALS['includes_root']."/classes/location.class.php");
include_once($GLOBALS['includes_root']."/global_applications/location_view.php");

function options($option_id, $radius = 10)
{
	list($latitude, $longitude) = explode(',', $_SESSION['last_location']);
	$location = new Location();
	$info = $location->get_by_options($latitude, $longitude, $option_id);
	if(!is_array())
	{
		if($radius < 50)
			options($option_id, $radius + 5);
		else
		{
			echo '<h3 class="error">Unable to find anything....</h3>';
			include_once($GLOBALS['includes_root']."/global_applications/location_search.php");
			location_search();
		}
		return;
	}
	foreach($info as $value)
	{
		location_view($value['id']);
		echo '<hr class="space" />';
	}
}

function options_list()
{
	$location = new Location();
	$options = $location->get_all_options();
	foreach($options as $option)
	{
		echo '<div class="span-3"><a class="button" href="options.php?option_id='.$option['option_id'].'" >'.$option['name'].'</a></div>';
	}
}
