<?php
	require 'db.php';
	$tempId = $_POST['pointid'];

	addPoints($tempId, $dbConnect);
?>