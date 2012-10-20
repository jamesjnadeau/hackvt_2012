<?php
//Set www_includes directory location
if(php_sapi_name() == 'cli' && empty($_SERVER['REMOTE_ADDR'])) 
	$GLOBALS['includes_root'] = '/var/www/vttodo/includes';
else
	$GLOBALS['includes_root'] = $_SERVER['DOCUMENT_ROOT'].'/includes';

include_once($GLOBALS['includes_root']."/global_applications/debug.php");

//global functions
include_once($GLOBALS['includes_root']."/global_applications/global_functions.php");

//if it's a mypoint employee, use our error handler
$old_error_handler = set_error_handler("mypointnow_error_handler");

//setup DB info
$GLOBALS['db_host']		= "localhost";
$GLOBALS['db_user']		= "root";
$GLOBALS['db_password']	= "";
$GLOBALS['db_name']		= "vttodo";
$GLOBALS['db_connection'] = mysql_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_password']);
mysql_select_db($GLOBALS['db_name'], $GLOBALS['db_connection']);

//CSS files
$GLOBALS['site_css'] = array( 
	"grid" => array(
		"media" => "all",
		"source" => "/global_css/fluid-grid.css"
	),
	
	"default" => array(
		"media" => "all",
		"source" => "/global_css/default.css"
	),
	
	"ui" => array(
		"media" => "all",
		"source" => "/global_css/ui/smoothness/jquery-ui.css"
	),
	"site" => array(
		"media" => "all",
		"source" => "/site.css"
	),
	"support" => array(
		"media" => "all",
		"source" => "/global_css/applications/support.css"
	),
	
	);


//Javascript files
$GLOBALS['site_js_header'] = array( 
									);
									
$GLOBALS['site_js_footer'] = array( "global" => "/js/global.js", 
									"superfish" => "/global_js/jquery/jquery.superfish.min.js", 
									"hoverIntent" => "/global_js/jquery/jquery.hoverIntent.min.js", 
									#"bgiframe" => "/global_js/jquery/bgiframe.min.js", 
									#"analytics" => "/global_js/applications/analytics-bosch.js"
									);
$GLOBALS['site_js_external'] = array( "jquery" => "//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js",
									  "jquery.ui" => "//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"
									  );
										//"phpdefault" =>"/global_js/php.default.min.js"

$GLOBALS['google_api_key'] = 'AIzaSyB9SqulpFeIvspiIEwVqLYp34Nqwp-wIJ8';

$GLOBALS['footer_output'] = "

<footer id='footer'>

    <p>Made by Byte IT<br /></p>
    <p>Copyright &copy; James Nadeau " . date('Y') . "</p>
    ";



$GLOBALS['footer_output'] .="</footer>\n\n";
