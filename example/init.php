<?php


require_once 'vendor/autoload.php';

const CLIENT_ID = 'my-client-id';
const CLIENT_SECRET = 'my-client-secret';
const REDIRECT_URI = 'https://example.com/my-redirect-uri';


// init the session
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
