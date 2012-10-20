<?php

//include default settings for this location
include_once($_SERVER['DOCUMENT_ROOT']."/settings.php");


//start displaying an html page
include_once($GLOBALS['includes_root']."/global_applications/html_page.php");
app_html_page_header("Welcome");

//banner and menu
include('banner.php');
include('menu.php');
echo '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key='.$GLOBALS['google_api_key'].'&sensor=false"></script>';
include_once($GLOBALS['includes_root']."/global_applications/options.php");
options($_REQUEST['option_id']);

//end the html page
app_html_page_footer();
