<html>
  <head>
    <script src="pong.js"></script>
    <style>
           body{
            background-image: url("http://1.bp.blogspot.com/-qaiwlEU6pfQ/Utj-iSrmFgI/AAAAAAAAGu8/XNUlVLKO_sA/s1600/pin+(2).jpg");
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            }
            
      </style>
        
  </head>
  <body>
     
     <input type="button" value="Start Menu" style="float: right;" onclick="location='Pause.php'">
     <h1 style="float: right;"><time>00:00:00</time></h1>
<button style="float: right;" id="start">start</button>
<button style="float: right;" id="stop">stop</button>
<button style="float: right;" id="clear">clear</button>
     <script>
         var aHighName = new Array();
var aHighScore = new Array();

function getHighScores(returnFrame:String, id:Number) {
	var hstGetUrl  = "localhost/PongProject/getscores.php";
	var hstID      = id;
	
	var lvGet:LoadVars = new LoadVars();
	
	lvGet.onLoad = function(success:Boolean) {
		if (success) {
			// parse the XML
			parseXML(lvGet.xml);
			gotoAndPlay(returnFrame);
		} else {
			trace("failed to fetch hiscores");
			gotoAndPlay(returnFrame);
		}
	}
	lvGet.gameid = hstID;
	LVgET.uid    = getTimer();
	lvGet.sendAndLoad(hstGetUrl, lvGet, "POST");
	
	stop();
}

function parseXML(text:String) {
	var xmlData:XML = new XML(text);

	var aXMLNames = mx.xpath.XPathAPI.selectNodeList(xmlData.firstChild, "/scores/name");
	var aXMLScores = mx.xpath.XPathAPI.selectNodeList(xmlData.firstChild, "/scores/score");

	for ( var i:Number = 0; i < 10; i++ ) {
		aHighName[i] = "";
		aHighScore[i] = 0;
	}

	for ( var i:Number = 0; i < aXMLNames.length; i++ ) {
		aHighName[i] = aXMLNames[i].firstChild.nodeValue;
		aHighScore[i] = aXMLScores[i].firstChild.nodeValue;
	}
}

function addHighScore(returnFrame:String, name:String, score:Number, id:Number) {
	var hstGetUrl  = "localhost/PongProject/savescore.php";
	var hstID      = id;
	var lvSend:LoadVars = new LoadVars();
	
	lvSend.onLoad = function(success:Boolean) {
		if (success) {
			gotoAndPlay(returnFrame);
		} else {
			trace("failed");
			gotoAndPlay(returnFrame);
		}
	}
	lvSend.gameid = hstID;
	lvSend.name   = name;
	lvSend.score  = score;
	lvSend.sendAndLoad(hstGetUrl, lvSend, "POST");
	
	stop();
        
        submitButton.onRelease = function() {
	addHighScore("enterscorecontinue", highscoreName.text, score, 1); 
} 
}

     </script>
     <script>
         var h1 = document.getElementsByTagName('h1')[0],
    start = document.getElementById('start'),
    stop = document.getElementById('stop'),
    clear = document.getElementById('clear'),
    seconds = 0, minutes = 0, hours = 0,
    t;

function add() {
    seconds++;
    if (seconds >= 60) {
        seconds = 0;
        minutes++;
        if (minutes >= 60) {
            minutes = 0;
            hours++;
        }
    }
    
    h1.textContent = (hours ? (hours > 9 ? hours : "0" + hours) : "00") + ":" + (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") + ":" + (seconds > 9 ? seconds : "0" + seconds);

    timer();
}
function timer() {
    t = setTimeout(add, 1000);
}
timer();


/* Start button */
start.onclick = timer;

/* Stop button */

stop.onclick = function() {
    clearTimeout(t);
}

/* Clear button */
clear.onclick = function() {
    h1.textContent = "00:00:00";
    seconds = 0; minutes = 0; hours = 0;
}
     </script>
      <script type="text/javascript">
          var clicks = 0;
    function onClick() {
        clicks += 1;
        document.getElementById('stop').innerHTML = clicks;
    };
          
	var animate = window.requestAnimationFrame ||
  	window.webkitRequestAnimationFrame ||
 	 window.mozRequestAnimationFrame ||
  	function(callback) { window.setTimeout(callback, 1000/60) };	

	var canvas = document.createElement('canvas');
	var width = 400;
	var height = 600;
	canvas.width = width;
	canvas.height = height;
	var context = canvas.getContext('2d');
	
	window.onload = function() 
	{
  	document.body.appendChild(canvas);
  	animate(step);
	};
	
	var step = function() 
	{
  	update();
  	render();
  	animate(step);
	};
	
	var update = function() {
	};

	var render = function() {
  	context.fillStyle = "#FF00FF";
  	context.fillRect(0, 0, width, height);
	};

	//Adding paddles and ball
	function Paddle(x, y, width, height) {
  	this.x = x;
  	this.y = y;
  	this.width = width;
  	this.height = height;
  	this.x_speed = 0;
  	this.y_speed = 0;
        this.score = 0;
	}

	Paddle.prototype.render = function() {
 	 context.fillStyle = "red";
 	 context.fillRect(this.x, this.y, this.width, this.height);
	};
	
	function Player() {
   	this.paddle = new Paddle(175, 580, 50, 10);
	}

	function Computer() {
	  this.paddle = new Paddle(175, 10, 50, 10);
	}

	Player.prototype.render = function() {
  	this.paddle.render();
	};

	Computer.prototype.render = function() {
 	 this.paddle.render();
	};

	function Ball(x, y) {
  	this.x = x;
 	 this.y = y;
  	this.x_speed = 0;
  	this.y_speed = 3;
  	this.radius = 5;
	}

	Ball.prototype.render = function() {
  	context.beginPath();
  	context.arc(this.x, this.y, this.radius, 2 * Math.PI, false);
  	context.fillStyle = "white";
  	context.fill();
	};

	var player = new Player();
	var computer = new Computer();
	var ball = new Ball(200, 300);

	var render = function() {
  	context.fillStyle = "black";
  	context.fillRect(0, 0, width, height);
  	player.render();
  	computer.render();
  	ball.render();
	};

	//Animation
	var update = function() {
  	ball.update();
	};

	Ball.prototype.update = function() {
  	this.x += this.x_speed;
  	this.y += this.y_speed;
	};

	var update = function() {
  	ball.update(player.paddle, computer.paddle);
	};

	Ball.prototype.update = function(paddle1, paddle2) {
  	this.x += this.x_speed;
  	this.y += this.y_speed;
  	var top_x = this.x - 5;
  	var top_y = this.y - 5;
  	var bottom_x = this.x + 5;
  	var bottom_y = this.y + 5;

  	if(this.x - 5 < 0) { // hitting the left wall
    	this.x = 5;
    	this.x_speed = -this.x_speed;
  	} else if(this.x + 5 > 400) { // hitting the right wall
    	this.x = 395;
    	this.x_speed = -this.x_speed;
  	}

  	if(this.y < 0 || this.y > 600) { // a point was scored
    	this.x_speed = 0;
    	this.y_speed = 3;
    	this.x = 200;
    	this.y = 300;
        onClick();
        
        clearTimeout(t);
    }

  	if(top_y > 300) {
    	if(top_y < (paddle1.y + paddle1.height) && bottom_y > paddle1.y && top_x < (paddle1.x + paddle1.width) && bottom_x > paddle1.x) {
      	// hit the player's paddle
      	this.y_speed = -3;
      	this.x_speed += (paddle1.x_speed / 2);
      	this.y += this.y_speed;
    	}
  	} else {
    	if(top_y < (paddle2.y + paddle2.height) && bottom_y > paddle2.y && top_x < (paddle2.x + paddle2.width) && bottom_x > paddle2.x) {
      	// hit the computer's paddle
      	this.y_speed = 3;
      	this.x_speed += (paddle2.x_speed / 2);
      	this.y += this.y_speed;
    	}
  	}
	};	
	
	var keysDown = {};

	window.addEventListener("keydown", function(event) {
  	keysDown[event.keyCode] = true;
	});

	window.addEventListener("keyup", function(event) {
  	delete keysDown[event.keyCode];
	});

	var update = function() {
  	player.update();
 	 ball.update(player.paddle, computer.paddle);
	};

	Player.prototype.update = function() {
  	for(var key in keysDown) {
    	var value = Number(key);
    	if(value == 37) { // left arrow
      this.paddle.move(-4, 0);
    	} else if (value == 39) { // right arrow
      this.paddle.move(4, 0);
   	 } else {
      this.paddle.move(0, 0);
    	}
  	}
	};

	Paddle.prototype.move = function(x, y) {
  	this.x += x;
  	this.y += y;
  	this.x_speed = x;
  	this.y_speed = y;
  	if(this.x < 0) { // all the way to the left
    	this.x = 0;
    	this.x_speed = 0;
  	} else if (this.x + this.width > 400) { // all the way to the right
    	this.x = 400 - this.width;
    	this.x_speed = 0;
  	}
	}

	//AI
	var update = function() {
  player.update();
  computer.update(ball);
  ball.update(player.paddle, computer.paddle);
};

Computer.prototype.update = function(ball) {
  var x_pos = ball.x;
  var diff = -((this.paddle.x + (this.paddle.width / 2)) - x_pos);
  if(diff < 0 && diff < -4) { // max speed left
    diff = -5;
  } else if(diff > 0 && diff > 4) { // max speed right
    diff = 5;
  }
  this.paddle.move(diff, 0);
  if(this.paddle.x < 0) {
    this.paddle.x = 0;
  } else if (this.paddle.x + this.paddle.width > 400) {
    this.paddle.x = 400 - this.paddle.width;
  }
};

Game.prototype.update = function()
{
    // [...]
    if (this.ball.x >= this.width)
        this.score(this.p1);
    else if (this.ball.x + this.ball.width <= 0)
        this.score(this.p2);
};
 
Game.prototype.score = function(p)
{
    // player scores
    p.score++;
    var player = p == this.p1 ? 0 : 1;
 
    // set ball position
    this.ball.x = this.width/2;
    this.ball.y = p.y + p.height/2;
 
    // set ball velocity
    this.ball.vy = Math.floor(Math.random()*12 - 6);
    this.ball.vx = 7 - Math.abs(this.ball.vy);
    if (player == 1)
        this.ball.vx *= -1;
};

function Display(x, y) {
    this.x = x;
    this.y = y;
    this.value = 0;
}
 
Display.prototype.draw = function(p)
{
    p.fillText(this.value, this.x, this.y);
};
function Game() {
    // [...]
 
    this.p1 = new Paddle(5, 0);
    this.p1.y = this.height/2 - this.p1.height/2;
    this.display1 = new Display(this.width/4, 25);
    this.p2 = new Paddle(this.width - 5 - 2, 0);
    this.p2.y = this.height/2 - this.p2.height/2;
    this.display2 = new Display(this.width*3/4, 25);
}
 
Game.prototype.draw = function()
{
    // [...]
    this.display1.draw(this.context);
    this.display2.draw(this.context);
};
 
Game.prototype.update = function()
{
    if (this.paused)
        return;
 
    this.ball.update();
    this.display1.value = this.p1.score;
    this.display2.value = this.p2.score;
    // [...]
};
    
    
   

    //<input type="button">


	</script>
        
        
        
        <?php
           /*$form = newt_form();

            $ok_button = newt_button(5, 12, "Run Tool");

            newt_form_add_component($form, $ok_button);*/
        ?>
  </body>
</html>