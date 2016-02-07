<?php
// ------------------------------------------------------------------------->
// define static variables
// ------------------------------------------------------------------------->
define('PATH', dirname(__FILE__));


// ------------------------------------------------------------------------->
// get page contents
// ------------------------------------------------------------------------->
ob_start();
    include get_page_path(PATH . '/pages/');
    $bodyContent = ob_get_contents();
ob_end_clean();


// ------------------------------------------------------------------------->
// render output
// ------------------------------------------------------------------------->
if (@$htmlHeader == '') $htmlHeader = 'html-header';
if (@$htmlFooter == '') $htmlFooter = 'html-footer';

require PATH . '/parts/' . $htmlHeader .  '.php';
echo $bodyContent;
require PATH . '/parts/' . $htmlFooter .  '.php';


// ------------------------------------------------------------------------->
// path functions
// ------------------------------------------------------------------------->
function get_page_path($templatePath) {
    $uri_string = get_uri_string();
    if (substr($uri_string, 1) != '/') $uri_string = substr($uri_string, 1, strlen($uri_string));
    if ($uri_string != '') {
    	if (substr($uri_string, -1) != '/') $uri_string .= '/';
    } else {
    	$uri_string = 'home/';
    }
    $site_array = explode('/', $uri_string);

    if (is_array($site_array)) {
    	$page_test = $templatePath;
        $trigger = FALSE;
    	foreach ($site_array as $page_name) {
    		if (file_exists($page_test . $page_name . '.php') && $trigger == FALSE) {
    			$page_test .= $page_name . '.';
                $trigger = true;
                break;
    		} else {
                $page_test .= $page_name . '/';
            }
    	}
        if ($trigger) {
            return $page_test . 'php';
        } else {
            return $templatePath . 'index.php';
        }
    }
}

function get_uri_string() {
	// If the URL has a question mark then it's simplest to just
	// build the URI string from the zero index of the $_GET array.
	// This avoids having to deal with $_SERVER variables, which
	// can be unreliable in some environments
	$self = pathinfo(__FILE__, PATHINFO_BASENAME);

	if (is_array($_GET) && count($_GET) == 1 && trim(key($_GET), '/') != '')
	{
		return key($_GET);
	}

	// Is there a PATH_INFO variable?
	// Note: some servers seem to have trouble with getenv() so we'll test it two ways
	$path = (isset($_SERVER['PATH_INFO'])) ? $_SERVER['PATH_INFO'] : @getenv('PATH_INFO');
	if (trim($path, '/') != '' && $path != "/".$self)
	{
		return $path;
	}

	// No PATH_INFO?... What about QUERY_STRING?
	$path =  (isset($_SERVER['QUERY_STRING'])) ? $_SERVER['QUERY_STRING'] : @getenv('QUERY_STRING');
	if (trim($path, '/') != '')
	{
		return $path;
	}

	// No QUERY_STRING?... Maybe the ORIG_PATH_INFO variable exists?
	$path = str_replace($_SERVER['SCRIPT_NAME'], '', (isset($_SERVER['ORIG_PATH_INFO'])) ? $_SERVER['ORIG_PATH_INFO'] : @getenv('ORIG_PATH_INFO'));
	if (trim($path, '/') != '' && $path != "/".$self)
	{
		// remove path and script information so we have good URI data
		return $path;
	}

	// We've exhausted all our options...
	return '';
}
