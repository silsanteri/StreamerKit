const tmi = require('tmi.js');
const mysql = require('mysql');

// MYSQL CONNECTION
const con = mysql.createConnection({
  host: "x",
  user: "x",
  password: "x",
  database: "x"
});

con.connect(function(err) {
  if (err) throw err;
  console.log("* MySQL connection successful!");
});

// DEFINE CONFIGURATION OPTIONS
const opts = {
  identity: {
    username: "x",
    password: "x"
  },
  channels: [
    "x"
  ]
};

// CREATE CLIENT WITH OPTIONS FROM ABOVE
const client = new tmi.client(opts);

client.on('message', onMessageHandler);
client.on('connected', onConnectedHandler);

// CONNECT TO TWITCH
client.connect();

// CALLED WHEN MESSAGE COMES IN
function onMessageHandler (target, tags, msg, self) {
	if (self) { return; }

	// WEBSITE URL VARIABLES
	const website = "x";
	const websiteleaderboard = "x";

	// TRIMS THE MESSAGE
	const commandName = msg.trim();

	// COMMANDS
	if (commandName === '!points') {
		console.log(`* Executed ${commandName} command`);
		
		var pointsName = tags.username;
			
		printPoints(pointsName, function(result){
			client.say(target, `${result}`);
		});
		
	} else if (commandName === '!coinflip') {
		console.log(`* Executed ${commandName} command`);
		
		var gambleName = tags.username;
			
		gamblePoints(gambleName, function(result){
			client.say(target, `${result}`);
		});	
		
	} else if (commandName === '!pepega') {
		console.log(`* Executed ${commandName} command`);
		
		var userName = tags.username;
		var pointsUsed = 100;

		usePoints(userName, pointsUsed, function(result){
			if (result >= pointsUsed) {
				var deductedresult = result - pointsUsed;
				client.say(target, `${userName} used ${pointsUsed} points for emoticon. ${userName}'s remaining point(s): ${deductedresult}`);
				client.say(target, `⠁⠁⠁⠁⠁⠁⠐⢶⣶⣶⣶⣤⣤⡀⠁⠁⣠⣀⣀⠁⠁⠁⠁⠁⠁⠁⠁⠁⠁⠁ ⠁⠁⠁⠁⠁⠁⠁⠁⠙⢿⣯⣠⣶⣦⣤⣤⣌⣛⠻⢇⣠⣤⣤⠁⠁⠁⠁⠁⠁⠁ ⠁⠁⠁⠁⠁⠁⠁⠁⠁⠁⠻⣿⣿⣿⡟⢉⡤⢤⣤⣤⡍⠛⢡⢖⣥⣶⣦⣀⠁⠁ ⠁⠁⠁⠁⠁⠁⠁⠁⠁⠁⣠⣿⣿⣿⡏⣭⣶⣿⣿⠟⢿⣦⡡⣿⣿⡇⠁⡙⣷⡀ ⠁⠁⠁⠁⠁⠁⠁⣀⣴⣿⣿⣿⣿⣿⣿⡞⣿⣿⡟⢀⡀⣿⣿⢻⣿⣿⣀⣁⣿⠏ ⠁⠁⠁⢀⣠⣶⣿⣿⣿⣿⣿⣿⣿⣿⣟⢰⢻⣿⣇⣈⣴⣿⠟⢨⣛⠛⠛⠉⠁⠁ ⠁⣠⣶⣿⣿⡟⢋⠤⣤⠘⢿⣿⣧⡙⠻⠌⠒⠙⠛⢛⣫⣥⣿⣦⡈⠉⣡⣴⣾⠇ ⢰⣿⣿⣿⣿⠁⡇⠁⠙⠷⣤⡙⠻⢿⣿⣶⣶⣶⣿⣿⣿⣿⣿⣿⣿⠿⠟⠋⠁⠁ ⠘⣿⣿⣿⣿⣆⠻⣄⠁⣀⡀⠉⠙⠒⠂⠉⠍⠉⠉⠉⠉⣩⣍⣁⣂⡈⠠⠂⠁⠁ ⠁⠘⢿⣿⣿⣿⣦⡉⠳⢬⣛⠷⢦⡄⠁⠁⠁⠁⠁⣀⣼⣿⣿⠿⠛⠋⠁⠁⠁⠁ ⠁⠁⠁⠉⠻⢿⣿⣿⣷⣦⣬⣍⣓⡒⠒⣒⣂⣠⡬⠽⠓⠂⠁⠁⠁⠁⠁⠁`);
			} else if (result < 0) {
				client.say(target, `${userName} has not registered to x's Website! Register with Twitch to start gaining points here: ${website}`);
			} else {
			client.say(target, `${commandName} costs ${pointsUsed} points, but ${userName} only has ${result} point(s)!`);
			}
		
		});
		
	} else if (commandName === '!leaderboard') {
		console.log(`* Executed ${commandName} command`);
		
		client.say(target, `You can view the point leaderboard here: ${websiteleaderboard}`);
		
	} else if (commandName === '!bot') {
		console.log(`* Executed ${commandName} command`);
		
		client.say(target, `Bot is a bot used with x's Website. Register with Twitch and watch the stream through x's Website to start gaining points! ${website}`);
		client.say(target, `Available commands: "!bot", "!points", "!leaderboard", "!coinflip" (Gambles all of your points with 50% chance to double them) and "!pepega" (Price: 100 Points)`);	
		
	} else {
		console.log(`* Unknown command ${commandName}`);
	}
}

// PRINTS USERS POINTCOUNT FROM DATABASE
function printPoints(printname, callback) {
	const website = "x";
		con.query("SELECT name, points FROM users WHERE EXISTS (SELECT name FROM users WHERE name = ?)", [printname], function(err, result, fields) {
			if (result[0] !== undefined) {
				if (result[0].points === 0) {
					var creply = printname + " has 0 points! --- Watch the stream through x's Website to start gaining points! " + website;
					console.log("* Printed  ", printname, "'s points");
					return callback(creply);
				} else {
					var creply = printname + "'s point(s): " + result[0].points;
					console.log("* Printed ", printname, "'s points");
					return callback(creply);
				}
			} else {
				var wreply = printname + " has not registered to x's Website! Register with Twitch to start gaining points! " + website;
				console.log("* Tried to print ", printname, "'s points, but couldn't find user with name '", printname, "' from database");
				return callback(wreply);
			}
	});
}

// USES POINTS WHEN COMMAND IS CALLED
function usePoints(pointname, pointused, callback) {
	con.query("SELECT name, points FROM users WHERE EXISTS (SELECT name FROM users WHERE name = ?)", [pointname], function(err, result, fields) {
		if (result[0] !== undefined) {
			if (result[0].points >= 100) {
				con.query("UPDATE users SET points = points - ?, points_profit = points_profit - ? WHERE name = ? AND points >= ?", [pointused, pointused, pointname, pointused], function(err, updateresult, fields) {
					console.log("* Used ", pointused, " out of ", result[0].points, "of", pointname, "'s points");
					var re = result[0].points;
					return callback(re);
				});
			} else {
				console.log("* ", pointname, "does not have enough points for emoticon");
				var re = result[0].points;
				return callback(re);
			}
		} else {
			console.log("* Tried to use ", pointname, "'s points, but couldn't find user with name '", pointname, "' from database");
			var re = -1;
			return callback(re);
		}
	});
}

// GAMBLES POINTS WHEN COMMAND IS CALLED
function gamblePoints(gamblename, callback) {
	const website = "x";
	con.query("SELECT name, points FROM users WHERE EXISTS (SELECT name FROM users WHERE name = ?)", [gamblename], function(err, result, fields) {
		if (result[0] !== undefined) {
			var gambleValue = Math.round(Math.random());
			var currentPoints = result[0].points;
			if (currentPoints >= 10) {
				if (gambleValue === 1) {
					con.query("UPDATE users SET points = points + ?, points_profit = points_profit + ? WHERE name = ?", [currentPoints, currentPoints, gamblename], function(err, updateresult, fields) {
						console.log("* ", gamblename, " gambled and doubled his/her points");
						var reply = gamblename + " gambled all of his/her points and won "+ currentPoints + " points!";
						return callback(reply);
					});
				} else {
					con.query("UPDATE users SET points = points - ?, points_profit = points_profit - ? WHERE name = ?", [currentPoints, currentPoints, gamblename], function(err, updateresult, fields) {
						console.log("* ", gamblename, " gambled and lost all of his/her points");
						var reply = gamblename + " gambled all of his/her points and lost everything! KEKW";
						return callback(reply);
					});
				}
			} else {
				console.log("* Tried to gamble", gamblename, "'s points but he/she does not have enough points to gamble");
				var reply = "!coinflip requires at least 10 points! " + gamblename + "'s current points: " + currentPoints;
				return callback(reply);
			}
		} else {
			console.log("* Tried to gamble ", gamblename, "'s points, but couldn't find user with name '", gamblename, "' from database");
			var reply = gamblename + " has not registered to x's Website! Register with Twitch to start gaining points! " + website;
			return callback(reply);
		}
	});
}

// CALLED WHEN BOT CONNECTS TO TWITCH
function onConnectedHandler (addr, port) {
  console.log(`* Connected to ${addr}:${port}`);
}