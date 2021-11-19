<?php

require_once 'init.php';

$code = $_GET['code'];
$state = $_GET['state'];

// compare the state
if ((!$_SESSION['teamwork_oauth_state']) || ($state != $_SESSION['teamwork_oauth_state'])) {
	// validation failed
	echo "Incorrect state, validation failed";
	die();
}

// create the provider
$provider = new \IQnectionProgramming\TeamworkOAuth2\Provider\Teamwork([
	'clientId'          => CLIENT_ID,
	'clientSecret'      => CLIENT_SECRET,
	'redirectUri'       => REDIRECT_URI
]);

try {
	// send the token request
	$accessTokenResponse = $provider->getAccessToken('authorization_code', [
		'code' => $code
	]);

	// make sure to store the token response in your datastore

	print_r($accessTokenResponse);

} catch (\Exception $e) {
	// report the error
	echo $e->getMessage();
}
