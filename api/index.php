<?php

if( !session_id() ){
	session_start();
}

require '../start.php';

use Lulucode\Post;
use Lulucode\Github_Oauth_Client;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$requestMethod = $_SERVER["REQUEST_METHOD"];
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$uriParts = explode('/', $uri);

if ( isset($uriParts[1]) && trim($uriParts[1]) !== 'post' ) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

if ( isset($uriParts[2]) && $uriParts[2] == 'logout' ) {
    logout();
}

if( !isset($_SESSION['access_token']) ){
	// echo 'Unauthorized';
    doAuthenticate();
}else{
	// echo 'Authorized';
	$controller = new Post($requestMethod);
	$controller->processRequest();
}

function logout(){
	unset($_SESSION['access_token']);
	unset($_SESSION['state']);
	echo 'Logged Out';
	exit();
}

function doAuthenticate(){
	$clientID       = getenv('GITHUB_CLIENT_ID');
	$clientSecret   = getenv('GITHUB_SECRET');
	$redirectURL 	= getenv('GITHUB_REDIRECT_URL');

	$gitClient = new Github_OAuth_Client(array(
	    'client_id' => $clientID,
	    'client_secret' => $clientSecret,
	    'redirect_uri' => $redirectURL,
	));

	if( isset($_SESSION['access_token']) ){
		$gitUser = $gitClient->apiRequest($accessToken);
		
		if( !empty($gitUser) ){
			$_SESSION['userData'] = $gitUserData;
		}else{
			$output = 'Some problem occured, please try again.';
		}
	}else if( isset($_GET['code']) ){
		$accessToken = $gitClient->getAccessToken($_GET['state'], $_GET['code']);
		$_SESSION['access_token'] = $accessToken;
	}else{
		unset($_SESSION['access_token']);
		unset($_SESSION['userData']);
		unset($_SESSION['state']);

		$_SESSION['state'] = hash('sha256', microtime(TRUE) . rand() . $_SERVER['REMOTE_ADDR']);

		$loginURL = $gitClient->getAuthorizeURL($_SESSION['state']);
		$output = htmlspecialchars($loginURL);
		
	}
	
	if( isset($output) ){
		echo 'Copy & Hit This URL To Login: '.$output;
	}
}