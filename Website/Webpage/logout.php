<?php
	require 'variables.php';
	require 'db.php';
	
	session_start();

	//VARIABLES FOR SIMPLICITY
	$userId = $_SESSION['userid'];
	$accessToken = $_SESSION['sessionaccesstoken'];
	
	//POST PARAMETERS
	$postParams = [
		'client_id' => $clientId,
		'token' => $accessToken,
	];
	
	//REVOKE TWITCH ACCESS TOKEN https://dev.twitch.tv/docs/authentication#revoking-access-tokens
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $linkLogout);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
	
	//SETS USERS ACTIVE VALUE TO 0 IN DATABASE
	profileActive($userId, 0, $dbConnect);
	
	session_unset();
	session_destroy();
	
	//STARTS A NEW SESSION AND SETS ACCESS TOKEN AND ACTIVE STATUS TO DEFAULT JUST IN CASE
	session_start();
	$_SESSION['sessionaccesstoken'] = '';
	$_SESSION['sessionactive'] = '0';
	
	//GO BACK TO HOMEPAGE
	header('Location:' . $indexLink);
?>