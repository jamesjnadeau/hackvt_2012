<?php 

include_once($GLOBALS['includes_root']."/classes/location.class.php");

function location_view($id)
{
	$location = new Location();
	$info = $location->get($id);
	$options = $location->get_options($id);
	echo '<div class="span-14">';
		echo '<a href="location_view.php?id='.$id.'" ><h2>'.$info['name'].'</h2></a>';
		echo '<h4>'.$info['hours'].'</h4>';
		echo '<h6><a href="'.$info['url'].'" >'.$info['url'].'</a></h6>';
		echo '<p>';
		foreach($options as $option)
			echo '<a href="options.php?option_id='.$option['option_id'].'" >'.$option['name'].'</a> ';
		echo '</p>';
		echo '<a class="button right large" href="https://maps.google.com/?q='.urlencode($info['address']).'" >'.$info['address'].'</a>';
		echo '<p>'.$info['latitude'].','.$info['longitude'].'</p>';
	echo '</div>';
	echo '<div class="span-9 last" >';
	if($info['latitude'] == NULL || $info['latitude'] == 0)
	{
		$location->geocode_fix($id, $info['address']);
		$info = $location->get($id);
	}
	
	if($info['latitude'] != NULL)
	{
		$locations[] = array( 'info' => $info['name']."<br/>".
									"<a class='button blue' href='tel:".$info['phone']."' >".$info['phone'].'</a>',
							'lat' => $info['latitude'],
							'long' => $info['longitude'],
						);
		show_map($locations, $info['latitude'].','.$info['longitude'], 'map_'.$id, '100%', '300px', 'false', false, 14) ;
	}
	else
		echo '<h3 class="error" >Unable to find coordinates</h3>';
	
	
	echo '</div>';
	echo '<p class="span-12 first">'.$info['description'].'</p>';
	//echo '<p class="span-12  last"></p>';
	
}
