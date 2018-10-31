<?php
	header('Content-type: text/html; charset=utf-8');
	header ("Cache-Control: max-age=200");
	require_once 'dbclass.php';
	ob_start();
	//DB::debugMode();
	DB::$user = '';
	DB::$password = '';
	DB::$dbName = '';
	
	define("_BBC_PAGE_NAME", "IRCSeeker"); 
	define("_BBCLONE_DIR", "bbclone/"); 
	define("COUNTER", _BBCLONE_DIR."mark_page.php"); 
	if(is_readable(COUNTER)){
		include_once(COUNTER);
	} else { echo "Counter fail."; };
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="Cache-control" content="no-cache">
<meta name="description" content="You can browse previous chat messages on Tauri-Wow">
<meta name="google-site-verification" content="kh-AodzZ4P9UAWZaIy7ubpXhphv38MgU1nYPE7dhzto" />

<script>
window.onload = function() {
if (!document.location.hash){
    document.location.hash = 'teto';
	}
}
</script>
<script>
var TxtRotate = function(el, toRotate, period) {
  this.toRotate = toRotate;
  this.el = el;
  this.loopNum = 0;
  this.period = parseInt(period, 10) || 2000;
  this.txt = '';
  this.tick();
  this.isDeleting = false;
};

TxtRotate.prototype.tick = function() {
  var i = this.loopNum % this.toRotate.length;
  var fullTxt = this.toRotate[i];

  if (this.isDeleting) {
    this.txt = fullTxt.substring(0, this.txt.length - 1);
  } else {
    this.txt = fullTxt.substring(0, this.txt.length + 1);
  }

  this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

  var that = this;
  var delta = 300 - Math.random() * 100;

  if (this.isDeleting) { delta /= 2; }

  if (!this.isDeleting && this.txt === fullTxt) {
    delta = this.period;
    this.isDeleting = true;
  } else if (this.isDeleting && this.txt === '') {
    this.isDeleting = false;
    this.loopNum++;
    delta = 500;
  }

  setTimeout(function() {
    that.tick();
  }, delta);
};

window.onload = function() {
  var elements = document.getElementsByClassName('txt-rotate');
  for (var i=0; i<elements.length; i++) {
    var toRotate = elements[i].getAttribute('data-rotate');
    var period = elements[i].getAttribute('data-period');
    if (toRotate) {
      new TxtRotate(elements[i], JSON.parse(toRotate), period);
    }
  }
  // INJECT CSS
  var css = document.createElement("style");
  css.type = "text/css";
  css.innerHTML = ".txt-rotate > .wrap { border-right: 0.08em solid #666 }";
  document.body.appendChild(css);
};
</script>
<title>Tauri IRC Log Browser</title>
<style>
.glitch-window{
	position: absolute;
	top: 0;
	left: -2px;
	width: 100%;
	color: $headline-color;
	text-shadow: 2px 0 $background-color, -1px 0 yellow, -2px 0 green;
	overflow: hidden;
	animation: crt-me 2500ms infinite linear alternate-reverse;
}

@keyframes crt-me {
	 0% {
        clip: rect(31px, 9999px, 94px, 0)
    }
    10% {
        clip: rect(112px, 9999px, 76px, 0)
    }
    20% {
        clip: rect(85px, 9999px, 77px, 0)
    }
    30% {
        clip: rect(27px, 9999px, 97px, 0)
    }
    40% {
        clip: rect(64px, 9999px, 98px, 0)
    }
    50% {
        clip: rect(61px, 9999px, 85px, 0)
    }
    60% {
        clip: rect(99px, 9999px, 114px, 0)
    }
    70% {
        clip: rect(34px, 9999px, 115px, 0)
    }
    80% {
        clip: rect(98px, 9999px, 129px, 0)
    }
    90% {
        clip: rect(43px, 9999px, 96px, 0)
    }
    100% {
        clip: rect(82px, 9999px, 64px, 0)
    }    
}

a{
	color: black;
}

#header{
	background-color:#C3D7DF;
	border-radius: 10px;
	padding: 5px;
	border: 2px dashed black;
	transition: background-color 1s;
	-webkit-transition: background-color 1s;
}
#header:hover{
	background-color:#F17D80;
	transition: background-color 3s;
    -webkit-transition: background-color 3s;
}
#alsav{
    background-color:#FFC300;
    border-radius: 10px;
    padding: 5px;
    border: 2px dashed black;
    transition: background-color 1s;
    -webkit-transition: background-color 1s;
}
#alsav:hover{
    background-color:#FF5733;
}
#cim{
	font-size: 150%;
}
#keret{
	border-radius: 10px;
	padding: 5px;
	border: 2px dashed black;
	transition: background-color 3s;
    -webkit-transition: background-color 3s;
}
#keret:hover{
	border: 2px dashed black;
    transition: background-color 3s;
    -webkit-transition: background-color 3s;
	background-color:#43ABC9;
	/* B5C689 EFD469 F58B4C <-- YES THIS IS AN URL --> viget.com/articles/color-contrast */
}
#keret2{
	border-radius: 10px;
	padding: 5px;
	border: 2px dashed black;
	background-color:#ededed;
	transition: background-color 3s;
    -webkit-transition: background-color 3s;
}
#footer{
	opacity: 0.8;
	border: 2px dashed black;
	border-radius: 10px;
	border-color: grey;
    position: fixed;
    left: 0;
    bottom: 0;
    width: 99%;
	height: 3%;
    background-color: black;
    color: white;
    text-align: center;
	display: inline-block;

}
#footer:hover{ opacity: 0.2; }
#lebeg{
	position: fixed;
	top: 15%;
	right: 10%;
	display: block;
	cursor: pointer;
	padding: 2% 2%;
	font-size: 100%;
	border: 3px solid #DEDEDE;
	z-index: 999999999999;
	color: black;
	background-color: white;
	-webkit-border-radius: 3px;
	border-radius: 3px;
}
#lebeg2{
	position: fixed;
	top: 35%;
	right: 10%;
	display: block;
	cursor: pointer;
	padding: 2% 2%;
	font-size: 100%;
	border: 3px solid #DEDEDE;
	z-index: 999999999999;
	color: black;
	background-color: white;
	-webkit-border-radius: 3px;
	border-radius: 3px;
}
body{

}
@media only screen and (max-device-width: 480px) {
    img { width: 100%; height: 20%; }
	body { background-color: white; }
	#cim { font-size: 300%; }
	#date { text-align: center; width: 50%; margin: 0 auto; }
	input { width: 100%; height: 5%; margin: 5px; font-size: 40px; }
	select { width: 100%; height: 5%; margin: 5px; font-size: 40px; }
	#footer { display: none; }
	#lebeg { transform: scale(2, 2); right: 15%; }
	#lebeg2 { transform: scale(2, 2); right: 15%; }
	#focim { font-size: 18px; }
	#mai { font-size: 48px; }
	#csaktelon { opacity: 1; }
}
#mai{
	//color: white;
	font-size: 200%;
	border-radius: 3px;
	transition: background-color 3s;
    -webkit-transition: background-color 3s;
}
#mai:hover{
	background-color: lightgrey;
	font-size: 200%;
	border-radius: 3px;
	transition: background-color 3s;
    -webkit-transition: background-color 3s;
}
#feher{
	color: white;
}
.osztaly{
	color: black;
	//font-size: 118px;
}
.osztaly:hover{
	color: black;
}
#nextto{
	display: inline-block;
}

#focim{
	font-family: 'Raleway', sans-serif;
	font-weight: 200;
	  margin: 0.4em 0;
font-size: 3.5em;
	//font-size: 48px;
}

@-webkit-keyframes pop-in {
	0% { opacity: 0; -webkit-transform: scale(0.5); }
	100% { opacity: 1; -webkit-transform: scale(1); }
}
@-moz-keyframes pop-in {
	0% { opacity: 0; -moz-transform: scale(0.5); }
	100% { opacity: 1; -moz-transform: scale(1); }
}
@keyframes pop-in {
	0% { opacity: 0; transform: scale(0.5); }
	100% { opacity: 1; transform: scale(1); }
}

#csaktelon { opacity: 0; }

@font-face {
    font-family: bariol;
    src: url('bariol.otf') format("opentype");
	url('bariol.otf');
}

.font{
	font-family: bariol;
}
.fontbold{
	font-family: bariol;
	font-weight: bold;
	font-style: bold;
}
h1{ display: inline; font-size: 68px; }
h2{ display: inline; }
h3{ display: inline; font-weight: normal; }
</style>
<link rel="stylesheet" type="text/css" href="tooltip.css">
<link rel="shortcut icon" type="image/png" href="/favicon.png"/>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-4051604993335718",
          enable_page_level_ads: true
     });
</script>
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-128048345-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-128048345-1');
</script>
</head>
<body>
<div name="teto" id=container>
<div id=content>
<div id=keret>
<a class="osztaly" href="https://sont.sytes.net/ircseeker.php" style="text-decoration:none">
	<div id=focim><h1>
	<center><b>
		<span style="-webkit-animation:pop-in 0.5s;" class="txt-rotate fontbold" data-period="2000"
			data-rotate='[ "Tauri IRClog browser " ]'>
		</span>
	</b></center></h1>
	</div>
	<center style="-webkit-animation:pop-in 0.5s;"><i>beta.</i><hr id=csaktelon></center>
</a>
<a style="-webkit-animation:pop-in 5s;" href="chart2.png"><div id=lebeg><div>ALL TIME CHART<br><center>(click for image)</center></div></div></a>
<center><div><a href="https://sont.sytes.net/ircseeker.php"><img style="-webkit-animation:pop-in 0.5s;" src="chart.png" alt="chart" height="15%" width="50%"></a></div></center><br>
<div id=mai style="-webkit-animation:pop-in 0.5s;"><center><b><div class="font">
<h2>
<?php
	$msgdarab = DB::query("SELECT COUNT(*) from irclog where whattime >= CURDATE() group by WEEKDAY(whattime) order by WEEKDAY(whattime);");
	foreach ($msgdarab as $row) { echo $row['COUNT(*)']; }
?>  messages sent today</h2></div>
</b></center></div><br>
<center>
<div id=header style="width: 99%">
	<form action="" method="post">
	<br>
	<div style="-webkit-animation:pop-in 0.5s;" id=date><b id=cim>Keyword</b></div>
	<input id="key" style="-webkit-animation:pop-in 0.5s;" type="text" name="msg" value="<?php echo $_POST["msg"]; ?>">
	<br><input style="-webkit-animation:pop-in 0.5s;" type="submit" class=button>
	</form>
	<form action="" method="post">
	<br>
	<div style="-webkit-animation:pop-in 0.5s;" id=date><b id=cim>Last Hours</b></div>
	<select style="-webkit-animation:pop-in 0.5s;" name="lasthr">
			<option value="1">1</option>
			<option value="3">3</option>
			<option value="6">6</option>
			<option value="12">12</option>
			<option value="24">24</option>
	</select>
	<br><input style="-webkit-animation:pop-in 0.5s;" type="submit" class=button>
	</form>
</div><br>

<div id=alsav style="width: 99%">
	<form action="" method="post">
	<br>
	<div style="-webkit-animation:pop-in 0.5s;" id=date><b id=cim>From</b></div>
	<input style="-webkit-animation:pop-in 0.5s;" type="date" name="datefrom" value="<?php echo date('Y-m-d',strtotime("-1 days")); ?>"><!--<input type="time" name="timefrom" value="">--><br>
	<div style="-webkit-animation:pop-in 0.5s;" id=date><b id=cim>Until</b></div>
	<input style="-webkit-animation:pop-in 0.5s;" type="date" name="dateto" value="<?php echo date('Y-m-d'); ?>"><!--<input type="time" name="timefrom" value="">-->
	<br><input style="-webkit-animation:pop-in 0.5s;" type="submit" class=button>
	</form>
</div>
</center>
<br>
<div id=keret2><div style="-webkit-animation:pop-in 0.5s;">
<br>
<h3>
<?php

if(isset($_POST["lasthr"])){
	$howlast = $_POST["lasthr"];
	$messages = DB::query("select * from irclog where whattime >= NOW()- INTERVAL $howlast HOUR");
	foreach ($messages as $row) {
		echo "[" . $row['id'] . "] ";
		echo "<i>" . $row['whattime'] . "</i>" . " -> ";
		echo "<b>" . $row['fromuser'] . "</b>" . " -> ";
		echo $row['msg'];
		echo "<br>";
	}
}

if(isset($_POST["msg"])) {
	$msg = $_POST["msg"];
	if(empty($msg) == true){echo "Adj meg valamit!"; die;}
	$messages = DB::query("select * from `irclog` where `msg` like %ss order by whattime asc", $msg);
	foreach ($messages as $row) {
		echo "[" . $row['id'] . "] ";
		echo "<i>" . $row['whattime'] . "</i>" . " -> ";
		echo "<b>" . $row['fromuser'] . "</b>" . " -> ";
		echo highlight($row['msg'],$msg);
		echo "<br>";
	}
}

if(isset($_POST["datefrom"])) {
	$datefrom = $_POST["datefrom"];
	$dateto = $_POST["dateto"];
	$messages = DB::query("select * from irclog where whattime between '$datefrom' and '$dateto'");
	foreach ($messages as $row) {
        echo "[" . $row['id'] . "] ";
        echo "<i>" . $row['whattime'] . "</i>" . " -> ";
        echo "<b>" . $row['fromuser'] . "</b>" . " -> ";
        echo $row['msg'];
        echo "<br>";
    }
}

function highlight($wholetext, $substr){
	$replaced = preg_replace("/\w*?".preg_quote($substr)."\w*/i","<font color='#ff4444'><b>$0</b></font>", $wholetext);
	return $replaced;
}
?>
</h3>
</div>
</div>
</div>
<div id=footer style="-webkit-animation:pop-in 2s;">Made and maintained by: Sontii | 2018 |
Armory: https://tauriwow.com/armory#character-sheet.xml?r=%5BHU%5D%20Tauri%20WoW%20Server&n=S%C3%B8ntii</div></b>
</div>
</div>

<!--
This site is written and maintained by: Sont/Sonti/Sontii/Sontika/Sontex (ok u got it).
Source code can be found on: https://github.com/sontqq/tauri-irclog-browser
Database behind: MySQL

CHANGELOG

2018.10.27.
major
	-now properly saves and shows messages longer than 255 characters. new limit is: 8196
	-new pop-in animation on page load
minor
	-graphical fixes
idea
	-language selector or single lang(full)
	-userinfo, userstat
	-fix for special characters

2018.10.26.
major
	-added last 1/3/6/12/24 hour button for fast access to the last messages
minor
	-graphical tune
idea
	-somekind of banner of new title
	-order buttons and labels into table for better look

-->
<div>
<br/>
<center>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/hu_HU/i/scr/pixel.gif" width="1" height="1">
</form>
<i>Based on data since: 2018-09-29</i>
</center>
<br/><br/>
</div>
</body>
</html>
