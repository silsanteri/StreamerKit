<?php
	require 'session.php';
?>

	<!DOCTYPE html>
	<html lang="en-US">
		<head>
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>x's Website</title>
			<link rel="icon" type="image/png" href="logo.png">
			<link rel="stylesheet" type="text/css" href="styles.css">
		</head>
		<body>
			<div id="page-container">
				<div id="topnav">
					<a href="index.php">Watch</a>
					<a class="active "href="#">Leaderboard</a>
					<div id="profile">
					<?php
						if (empty($accessToken)) {
							echo '<div id="profilelogin"><a href="' . $authorizationUrl . '">Connect with Twitch</a><img src="twitch.png" height="47" width="47" href="' . $authorizationUrl . '" class="profileimg"></div>';
						} else {
							echo '<div id="profilecontent">';
							echo '<img src="' . $userPicture . '" height="47" width="47" class="profileimg"><a>Welcome <b>' . $userName . '</b> - Points: <b>' . $userPoints . '</b></a>';
							echo '</div>';
							echo '<div id="profilelogout"><a href="logout.php">Log Out</a></div>';
						}
					?>
					</div>
				</div>
			
				<div id="leaderboard">
					<h1>x Points Leaderboard</h1>
					<p><b>Top 10</b></p>
					<div id="leaderboardcontent">
						<table>
							<tr>
								<th>Username</th>
								<th>Points</th>
							</tr>
							<?php
								leaderboardPrint($dbConnect);
							?>
						</table>
					</div>
				</div>
				
				<footer id="footer">
					<?php
						if (empty($accessToken)) {
							echo '<div style="width: 100%"><a href="' . $authorizationUrl . '"><img src="twitch.png" height="30" width="30"></a></div>';
							echo '<div style="width: 100%"><a href="' . $authorizationUrl . '">Connect with Twitch</a></div>';
							echo '<div style="width: 100%"><p><b>Not Logged In</b></p></div>';
						} else {
							echo '<div style="width: 100%"><a href="logout.php"><b>Log Out</b></a></div>';
							echo '<div style="width: 100%"><p>Logged in as: <b>' . $userName . '</b></p></div>';
						}
						echo '<div style="width: 100%"><a href="' . $subscribeLink . '"><img src="subscribe.jpg" alt="Subscribe to x" height="35" width="100"></a></div>';
						echo '<div style="width: 100%"><p>' . $disclaimer . '</p></div>';
					?>
				</footer>
			</div>
		</body>
	</html>