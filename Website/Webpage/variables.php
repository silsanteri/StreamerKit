<?php
	//DISCLAIMER FOR PAGE FOOTERS
	$disclaimer = 'This site is not affiliated with, nor is it the official site of "Twitch.tv" or "Amazon.com, Inc."';

	//LINKS FOR SIMPLICITY
	$indexLink = 'x';
	$userLink = 'x';
	$addpointsLink = 'x';
	$subscribeLink = 'https://www.twitch.tv/x/subscribe';

	//TWITCH ID OF THE STREAMER
	$xId = 'x';

	//VARIABLES FOR AUTHENTICATION
	$clientId = 'x';
	$clientSecret = 'x';
	$redirectUri = 'x';
	$scopes = '';

	//LINKS FOR AUTHENTICATION
	$linkAuth = 'https://id.twitch.tv/oauth2/authorize';
	$linkToken = 'https://id.twitch.tv/oauth2/token';
	$linkApi = 'https://api.twitch.tv/helix/users';
	$linkLogout = 'https://id.twitch.tv/oauth2/revoke';
	
	//FULL URL FOR AUTHENTICATION
	$authorizationUrl = $linkAuth . "?client_id=" . $clientId . "&redirect_uri=" . $redirectUri . "&response_type=code&scope=" . $scopes;
?>