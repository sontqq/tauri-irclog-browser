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

<html>
<head>
<title>Tauri IRC Log Browser</title>
<style>
a{
	color: black;
}
input {
   //
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
	//background-color:rgba(0, 0, 0, 0.7);
	background-color:#43ABC9;
	// B5C689 EFD469 F58B4C <-- YES THIS IS AN URL --> viget.com/articles/color-contrast
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
}
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
	font-color: black;
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
	font-color: black;
	background-color: white;
	-webkit-border-radius: 3px;
	border-radius: 3px;
}
@media only screen and (max-device-width: 480px) {
    img { width: 100%; height: 20%; }
	body { background-color: white; }
	#cim { font-size: 300%; }
	#date { text-align: center; width: 50%; margin: 0 auto; }
	input { width: 100%; height: 5%; margin: 5px; font-size: 40px; }
	#footer { display: none; }
	#lebeg { transform: scale(2, 2); right: 15%; }
	#lebeg2 { transform: scale(2, 2); right: 15%; }
}
#mai{
	font-color: white;
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
	font-color: white;
}
.osztaly{
	font-color: black;
}
.osztaly:hover{
	font-color: black;
}
#nextto{
	display: inline-block;
}
#date{
	display: inline-block;
}
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
</head>
<body>
<div id=keret>
<a class="osztaly" href="https://sont.sytes.net/ircseeker.php" style="text-decoration:none">
	<div id=cim>
	<center><h2>Tauri IRClog browser</h2></center>
	</div>
</a>
<a href="chart2.png"><div id=lebeg><span class="tool" data-tip="2018-09-29 óta gyűjtött adatok alapján.">ALL TIME STAT</span></div></a>
<div id=lebeg2><span class="tool" data-tip="Előzmények 2018-09-29 után érhetőek el hiánytalanul.">INFO</span>
</div><center><div><img src="chart.png" alt="chart" height="15%" width="50%"></div></center><br>
<div id=mai><center><b>
<?php
	$msgdarab = DB::query("SELECT COUNT(*) from irclog where whattime >= CURDATE() group by WEEKDAY(whattime) order by WEEKDAY(whattime);");
	foreach ($msgdarab as $row) { echo $row['COUNT(*)']; }
?> üzenet érkezett ma
</b></center></div><br>
<center>
<div id=header style="width: 99%">
	<form action="" method="post">
	<br>
	<div id=date><b id=cim>Keyword</b></div>
	<input id=meret type="text" name="msg" value="<?php echo $_POST["msg"]; ?>">
	<br><input type="submit" class=button>
	</form>
	<form action="" method="post">
	<br>
	<div id=date><b id=cim>Last Hours</b></div>
	<select id=meret name="lasthr">
			<option value="1">1</option>
			<option value="3">3</option>
			<option value="6">6</option>
			<option value="12">12</option>
			<option value="24">24</option>
	</select>
	<br><input type="submit" class=button>
	</form>
</div><br>

<div id=alsav style="width: 99%">
	<form action="" method="post">
	<br>
	<div id=date><b id=cim>From</b></div>
	<input type="date" name="datefrom" value="<?php echo date('Y-m-d',strtotime("-1 days")); ?>"><!--<input type="time" name="timefrom" value="">--><br>
	<div id=date><b id=cim>Until</b></div>
	<input type="date" name="dateto" value="<?php echo date('Y-m-d'); ?>"><!--<input type="time" name="timefrom" value="">-->
	<br><input id=meret type="submit" class=button>
	</form>
</div>
</center>
<br>
<div id=keret2>
<br>

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
</div>
<div id=footer>Created by: Sontii | 2018 |
Armory: https://tauriwow.com/armory#character-sheet.xml?r=%5BHU%5D%20Tauri%20WoW%20Server&n=S%C3%B8ntii</div></b>
</div>
<!--
This site is written and maintained by: Sont/Sonti/Sontii/Sontika/Sontex (ok u got it).
Source code can be found on: https://github.com/sontqq/tauri-irclog-browser

CHANGELOG
2018.10.26
major
-added last 1/3/6/12/24 hour button for fast access to the last messages
minor
-graphical tune
idea
-somekind of banner of new title
-order buttons and labels into table for better look

-->
</body>

</html>
