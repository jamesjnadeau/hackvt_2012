<?php

//include default settings for this location
include_once($_SERVER['DOCUMENT_ROOT']."/settings.php");


//start displaying an html page
include_once($GLOBALS['includes_root']."/global_applications/html_page.php");
app_html_page_header("Welcome");

//banner and menu
include('banner.php');
include('menu.php');

include_once($GLOBALS['includes_root']."/global_applications/location_search.php");
location_search();

//end the html page
app_html_page_footer();
