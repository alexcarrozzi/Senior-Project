<?php
	session_start();
	require_once '../../utilities/common.php';
	
	require_once '../../google-api-php-client/autoload.php';

	$scriptUri = 'http://scheduleit.cs.unh.edu/';

	$client = new Google_Client();
	$client->setAccessType('online'); // default: offline
	$client->setApplicationName('ScheduleIt');
	$client->setClientId('191668664245-k6apjlo3hojik7rphq9aet58hiu4pc26.apps.googleusercontent.com');
	$client->setClientSecret('t86-1-Msaw9C7wuPKZ-dvLYK');
	$client->setRedirectUri($scriptUri);
	$client->setDeveloperKey('AIzaSyDzsF1TFKgiX1YVx7oBdmorGrkwIiFah88'); // API key
	$client->setScopes('https://www.googleapis.com/auth/userinfo.profile'); // API key


	if (isset($_GET['logout'])) { // logout: destroy token
		unset($_SESSION['token']);
		die('Logged out.');
	}

	if (isset($_GET['code'])) { // we received the positive auth callback, get the token and store it in session
		$client->authenticate();
		$_SESSION['token'] = $client->getAccessToken();
	}

	if (isset($_SESSION['token'])) { // extract token from session and configure client
		$token = $_SESSION['token'];
		$client->setAccessToken($token);
	}

	if (!$client->getAccessToken()) { // auth call to google
		$authUrl = $client->createAuthUrl();
		header("Location: ".$authUrl);
		die;
	}
	echo 'Hello, world.';
?>
