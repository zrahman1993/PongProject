<html>
    <head>
        <title>High Scores</title> 
        <style>
            body{
            background-image: url("http://1.bp.blogspot.com/-qaiwlEU6pfQ/Utj-iSrmFgI/AAAAAAAAGu8/XNUlVLKO_sA/s1600/pin+(2).jpg");
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            }
            
            #wrapper {
    margin-left: auto;
    margin-right: auto;
    width: 30%;
    
} 
            
    #sse1
{
    /*You can decorate the menu's container, such as adding background images through this block*/
    background-color: black;
    height: 38px;
    padding: 15px;
    border-radius: 3px;
    box-sizing: content-box;
    
}
#sses1
{
    margin:0 auto;/*This will make the menu center-aligned. Removing this line will make the menu align left.*/
}
#sses1 ul 
{ 
    position: relative;
    list-style-type: none;
    float:left;
    padding:0;margin:0;
    border-bottom:solid 1px #6C0000;
}
#sses1 li
{
    float:left;
    list-style-type: none;
    padding:0;margin:0;background-image:none;
}
/*CSS for background bubble*/
#sses1 li.highlight
{
    background-color:#800;
    top:36px;
    height:2px;
    border-bottom:solid 1px #C00;
    z-index: 1;
    position: absolute;
    overflow:hidden;
}
#sses1 li a
{
    box-sizing: content-box;
    height:30px;
    padding-top: 8px;
    margin: 0 20px;/*used to adjust the distance between each menu item. Now the distance is 20+20=40px.*/
    color: #fff;
    font: normal 12px arial;
    text-align: center;
    text-decoration: none;
    float: left;
    display: block;
    position: relative;
    z-index: 2;
}
        </style>
    </head>
    <body>
        <h1>High Scores</h1>
        <script>
  var sse1 = function () {
    var rebound = 20; //set it to 0 if rebound effect is not prefered
    var slip, k;
    return {
        buildMenu: function () {
            var m = document.getElementById('sses1');
            if(!m) return;
            var ul = m.getElementsByTagName("ul")[0];
            m.style.width = ul.offsetWidth+1+"px";
            var items = m.getElementsByTagName("li");
            var a = m.getElementsByTagName("a");

            slip = document.createElement("li");
            slip.className = "highlight";
            ul.appendChild(slip);

            var url = document.location.href.toLowerCase();
            k = -1;
            var nLength = -1;
            for (var i = 0; i < a.length; i++) {
                if (url.indexOf(a[i].href.toLowerCase()) != -1 && a[i].href.length > nLength) {
                    k = i;
                    nLength = a[i].href.length;
                }
            }

            if (k == -1 && /:\/\/(?:www\.)?[^.\/]+?\.[^.\/]+\/?$/.test) {
                for (var i = 0; i < a.length; i++) {
                    if (a[i].getAttribute("maptopuredomain") == "true") {
                        k = i;
                        break;
                    }
                }
                if (k == -1 && a[0].getAttribute("maptopuredomain") != "false")
                    k = 0;
            }

            if (k > -1) {
                slip.style.width = items[k].offsetWidth + "px";
                //slip.style.left = items[k].offsetLeft + "px";
                sse1.move(items[k]); //comment out this line and uncomment the line above to disable initial animation
            }
            else {
                slip.style.visibility = "hidden";
            }

            for (var i = 0; i < items.length - 1; i++) {
                items[i].onmouseover = function () {
                    if (k == -1) slip.style.visibility = "visible";
                    if (this.offsetLeft != slip.offsetLeft) {
                        sse1.move(this);
                    }
                }
            }

            m.onmouseover = function () {
                if (slip.t2)
                    slip.t2 = clearTimeout(slip.t2);
            };

            m.onmouseout = function () {
                if (k > -1 && items[k].offsetLeft != slip.offsetLeft) {
                    slip.t2 = setTimeout(function () { sse1.move(items[k]); }, 50);
                }
                if (k == -1) slip.t2 = setTimeout(function () { slip.style.visibility = "hidden"; }, 50);
            };
        },
        move: function (target) {
            clearInterval(slip.timer);
            var direction = (slip.offsetLeft < target.offsetLeft) ? 1 : -1;
            slip.timer = setInterval(function () { sse1.mv(target, direction); }, 15);
        },
        mv: function (target, direction) {
            if (direction == 1) {
                if (slip.offsetLeft - rebound < target.offsetLeft)
                    this.changePosition(target, 1);
                else {
                    clearInterval(slip.timer);
                    slip.timer = setInterval(function () {
                        sse1.recoil(target, 1);
                    }, 15);
                }
            }
            else {
                if (slip.offsetLeft + rebound > target.offsetLeft)
                    this.changePosition(target, -1);
                else {
                    clearInterval(slip.timer);
                    slip.timer = setInterval(function () {
                        sse1.recoil(target, -1);
                    }, 15);
                }
            }
            this.changeWidth(target);
        },
        recoil: function (target, direction) {
            if (direction == -1) {
                if (slip.offsetLeft > target.offsetLeft) {
                    slip.style.left = target.offsetLeft + "px";
                    clearInterval(slip.timer);
                }
                else slip.style.left = slip.offsetLeft + 2 + "px";
            }
            else {
                if (slip.offsetLeft < target.offsetLeft) {
                    slip.style.left = target.offsetLeft + "px";
                    clearInterval(slip.timer);
                }
                else slip.style.left = slip.offsetLeft - 2 + "px";
            }
        },
        changePosition: function (target, direction) {
            if (direction == 1) {
                //following +1 will fix the IE8 bug of x+1=x, we force it to x+2
                slip.style.left = slip.offsetLeft + Math.ceil(Math.abs(target.offsetLeft - slip.offsetLeft + rebound) / 10) + 1 + "px";
            }
            else {
                //following -1 will fix the Opera bug of x-1=x, we force it to x-2
                slip.style.left = slip.offsetLeft - Math.ceil(Math.abs(slip.offsetLeft - target.offsetLeft + rebound) / 10) - 1 + "px";
            }
        },
        changeWidth: function (target) {
            if (slip.offsetWidth != target.offsetWidth) {
                var diff = slip.offsetWidth - target.offsetWidth;
                if (Math.abs(diff) < 4) slip.style.width = target.offsetWidth + "px";
                else slip.style.width = slip.offsetWidth - Math.round(diff / 3) + "px";
            }
        }
    };
} ();

if (window.addEventListener) {
    window.addEventListener("load", sse1.buildMenu, false);
}
else if (window.attachEvent) {
    window.attachEvent("onload", sse1.buildMenu);
}
else {
    window["onload"] = sse1.buildMenu;
}
</script>
<script>
    function goBack() {
        window.history.back()
    }
</script>
<div id="sse1">
  <div id="sses1">
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="javascript:history.back()">Resume</a></li>
      <li><a href="pong.php">Restart</a></li>
      <li><a href="pause.php">Start Menu</a></li>
    </ul>
  </div>
</div>
    </body>
</html>
<?php
//$dbh= mysql_connect ("localhost", "root",'') 
//or die ('I cannot connect to the database because: ' . mysql_error());
//mysql_select_db ("high_scores");
include_once 'dbconn.php';

    $sSQL   = "SELECT * FROM scores where gameid = ".$_REQUEST["gameid"]." ORDER BY score DESC LIMIT 0,10";
if(!$result = mysql_query($sSQL)) die(mysql_error());

print "xml=<scores>";
while( $row = mysql_fetch_array($result)) {
       
	echo '<div id="wrapper">'.'<h1>' ."<name>".$row['name'].print "<br>"."</name>". '</h1>'.'</div>';
        
	print "<score>".$row['score'].print ":"."</score>";
}
print "</scores>";
mysql_close();

