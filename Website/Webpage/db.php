<?php
	//DATABASE ACCESS VARIABLES
	$dbServername = "x";
	$dbUsername = "x";
	$dbPassword = "x";
	$dbName = "x";
	$dbConnect = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

	//CREATES USER IF USER DOESNT EXIST IN DATABASE -- IF USER EXISTS UPDATE VALUES INSTEAD
	function profileCommand($id, $name, $pic, $act, $foll, $con) {
		$result = mysqli_query($con, "SELECT COUNT(*) FROM users WHERE id='" . $id . "'");
		$row = $result->fetch_assoc();
		if ($row['COUNT(*)'] == 0) {
			$sqlInsert = mysqli_query($con, "INSERT INTO users (id, name, picture, active, points, points_profit, follower, subscriber, admin)
			VALUES ('$id', '$name', '$pic', '$act', '0', '0', '$foll', '0', '0')");
			$result->free();
		} else {
			$sqlUpdate = mysqli_query($con, "UPDATE users 
			SET name = '$name', picture = '$pic', active = '$act', follower = '$foll'
			WHERE id = $id;");
			$result->free();
		}
	}

	//UPDATES ACTIVE STATUS
	function profileActive($id, $act, $con) {
		$sql = mysqli_query($con, "UPDATE users
		SET active = '$act'
		WHERE id = $id;");
	}
	
	//PRINTS OUT TOP 10 OF POINTS
	function leaderboardPrint ($con) {
		$top10points = mysqli_query($con, "SELECT * FROM users
		ORDER BY points DESC
		LIMIT 10;");
		while($row = mysqli_fetch_array($top10points)) {
			echo '<tr>';
			echo '<td><b>' . $row['name'] . '</b></td>';
			echo '<td><b>' . $row['points'] . '</b></td>';
			echo '</tr>';
		}
	}
	
	//SETS USERS POINTS COUNT TO SESSION
	function getPoints ($id, $con) {
		$ptResult = mysqli_query($con, "SELECT points FROM users WHERE id='" . $id . "'");
		$row = mysqli_fetch_array($ptResult);
		$_SESSION['userpoints'] = $row['points'];
		$ptResult->free();
	}
	
	//GIVES USERS A POINT
	function addPoints($id, $con) {
		$ptUpdate = mysqli_query($con, "UPDATE users 
			SET points = points + 1, points_profit = points_profit + 1
			WHERE id = $id;");
	}
?>