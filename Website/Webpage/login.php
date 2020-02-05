<?php
	require 'variables.php';

	//GET CODE FROM URL AND CHECK IF CODE EXISTS
	$code = $_GET['code'];
	if ($code == "") {
		//GO BACK TO HOMEPAGE IF CODE DOES NOT EXIST
		header('Location: ' . $indexLink);
		exit;
	}
	
	//POST PARAMETERS
	$postParams = [
		'client_id' => $clientId,
		'client_secret' => $clientSecret,
		'code' => $code,
		'grant_type' => "authorization_code",
		'redirect_uri' => $redirectUri,
		'scope' => $scopes
	];
	
	//GET ACCESS TOKEN FOR API CALLS
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $linkToken);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER,array('Accept: application/json'));
	$response = curl_exec($ch);
	curl_close($ch);
	$data = json_decode($response);
	
	//CHECK IF ACCESS TOKEN EXISTS
	if ($data->access_token != '') {
		session_start();
		$_SESSION['sessionaccesstoken'] = $data->access_token;
		$_SESSION['sessionactive'] = '1';
		//GO TO USER.PHP
		header('Location: ' . $userLink);
	} else {
		//GO BACK HOMEPAGE IF ACCESS TOKEN DOES NOT EXIST
		header('Location: ' . $indexLink);
	}	
?>