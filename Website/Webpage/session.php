<?php
	require 'db.php';
	require 'variables.php';
	session_start();
	
	//CHECKS IF ACCESS TOKEN IS SET AND SESSION IS ACTIVE
	if (isset($_SESSION['sessionaccesstoken']) && ($_SESSION['sessionactive'] == 1)) {
		//SETS VARIABLES FOR SIMPLICITY AND GETS USER POINT COUNT FROM DATABASE
		$accessToken = $_SESSION['sessionaccesstoken'];
		$userId = $_SESSION['userid'];
		getPoints($userId, $dbConnect);
		$userName = $_SESSION['username'];
		$userPicture = $_SESSION['userpicture'];
		$userActive = $_SESSION['sessionactive'];
		$userPoints = $_SESSION['userpoints'];
		//URL FOR LOGOUT BUTTONS
		$logoutUrl = $linkLogout . '?client_id=' . $clientId . '&token=' . $accessToken;
	} else {
		//SETS ACCESS TOKEN AND ACTIVE STATUS TO DEFAULT JUST IN CASE
		$_SESSION['sessionaccesstoken'] = '';
		$_SESSION['sessionactive'] = '0';
	}
?>