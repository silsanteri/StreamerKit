<?php
	require 'variables.php';
	require 'db.php';

	session_start();
	
	//ACCESS TOKEN FROM SESSION
	$accessToken = $_SESSION['sessionaccesstoken'];
	
	//AUTHENTICATION HEADER FOR CHECKS
	$authHeader = 'Authorization: Bearer ' . $accessToken;

	//GET BASIC USER DATA
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $linkApi);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER,array('Accept: application/json', $authHeader));
	$response = curl_exec($ch);
	curl_close($ch);
	$userData = json_decode($response);
	
	//CHECK BASIC USER DATA
	if ($userData->data[0] != "") {
		//GET DATA TO SESSION AND VARIABLES FOR SIMPLICITY
		$_SESSION['userid'] = $userData->data[0]->id;
		$_SESSION['username'] = $userData->data[0]->login;
		$_SESSION['userpicture'] = $userData->data[0]->profile_image_url;
		$userId = $_SESSION['userid'];
		$userName = $_SESSION['username'];
		$userPicture = $_SESSION['userpicture'];
		$userActive = $_SESSION['sessionactive'];
		
		//CHECK FOLLOW STATUS
		$followLink = $linkApi . '/follows?to_id=' . $xId . '&from_id=' . $userId;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $followLink);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER,array('Accept: application/json', $authHeader));
		$response = curl_exec($ch);
		curl_close($ch);
		$followData = json_decode($response);
		
		//GET DATA TO SESSION AND VARIABLE FOR SIMPLICITY
		$_SESSION['userfollow'] = $followData->total;
		$userFollow = $_SESSION['userfollow'];
		
		//SAVE TO DATABASE
		profileCommand($userId, $userName, $userPicture, $userActive, $userFollow, $dbConnect);
		
		//GO BACK TO HOMEPAGE AFTER SAVING TO DATABASE
		header('Location: ' . $indexLink);
	} else {
		//GO BACK TO HOMEPAGE
		header('Location: ' . $indexLink);
	}
?>