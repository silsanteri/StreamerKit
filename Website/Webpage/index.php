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
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
		</head>
		<body>
			<div id="page-container">
				<div id="topnav">
					<a class="active" href="#">Watch</a>
					<a href="leaderboard.php">Leaderboard</a>
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
			
				<div id="streamelements">
				<!-- TWITCH STREAM -->
					<div id="stream">
						<iframe
							src="https://player.twitch.tv/?channel=x"
							frameborder="0"
							scrolling="no"
							allowfullscreen="true">
						</iframe> 
					</div>
					<!-- TWITCH CHAT -->
					<div id="chat">
						<iframe
							frameborder="0"
							scrolling="no"
							id="chat_embed"
							src="https://www.twitch.tv/embed/x/chat?darkpopout"
							>
						</iframe>
					</div>
				</div>
			
				<footer id="footer">
					<?php
						if (empty($accessToken)) {
							echo '<div style="width: 100%"><a href="' . $authorizationUrl . '"><img src="twitch.png" height="35" width="35"></a></div><br>';
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
			
			<!-- POINT SYSTEM -->
			<?php if (isset($_SESSION['sessionaccesstoken']) && ($_SESSION['sessionactive'] == 1)) : ?>
				<script>
					$(document).ready(function(){
						setInterval(givePoints, 60000);
						function givePoints() {
							$.post("points.php", {pointid: "<?php echo $_SESSION['userid']; ?>"}, function(data){});
						}
					});
				</script>
			<?php endif; ?>
			
		</body>
	</html>