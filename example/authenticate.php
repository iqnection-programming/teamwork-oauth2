<?php


require_once 'init.php';

// generate a random state value
$state = bin2hex(random_bytes(16));

// store the state for checking later
$_SESSION['teamwork_oauth_state'] = $state;

// create the provider
$provider = new \IQnectionProgramming\TeamworkOAuth2\Provider\Teamwork([
	'clientId'          => CLIENT_ID,
	'clientSecret'      => CLIENT_SECRET,
	'redirectUri'       => REDIRECT_URI
]);

// init the authorize redirect
$provider->authorize([
	'state'				=> $state
]);
