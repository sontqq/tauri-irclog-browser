<?php
	require_once 'dbclass.php';
	ob_start();
	//DB::debugMode();
	DB::$user = 'user';
	DB::$password = 'pass';
	DB::$dbName = 'db';
	
	define("_BBC_PAGE_NAME", "IRCSeeker"); 
	define("_BBCLONE_DIR", "bbclone/"); 
	define("COUNTER", _BBCLONE_DIR."mark_page.php"); 
	if(is_readable(COUNTER)){
		include_once(COUNTER);
	} else { echo "Counter fail."; };
	
?>

<html>
<head>
<title>Tauri IRC Log seeker</title>
<style>
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
}
#alsav{
        background-color:#FF5733;
        border-radius: 10px;
        padding: 5px;
        border: 2px dashed black;
        transition: background-color 1s;
        -webkit-transition: background-color 1s;
}
#alsav:hover{
        background-color:#FFC300;
}
#keret{
	border-radius: 10px;
	padding: 5px;
	border: 2px dashed black;
}
#keret:hover{
	border: 2px dashed black;
    transition: background-color 3s;
    -webkit-transition: background-color 3s;
	background-color:rgba(0, 0, 0, 0.7);
}
#keret2{
	border-radius: 10px;
	padding: 5px;
	border: 2px dashed black;
	background-color:#ededed;
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
	#cim { font-color: red; font-size: 300%; }
	#date { text-align: center; width: 50%; margin: 0 auto; }
	input { width: 100%; height: 5%; margin: 5px; font-size: 40px; }
	#footer { display: none; }
	#lebeg { transform: scale(2, 2); right: 15%; }
	#lebeg2 { transform: scale(2, 2); right: 15%; }
}
#mai{
	font-color: white;
	font-size: 150%;
	border-radius: 3px;
}
#mai:hover{
	background-color: lightgrey;
	font-size: 150%;
	border-radius: 3px;
}
.osztaly{
	
}
.osztaly:hover{
	
}
</style>
 <link rel="stylesheet" type="text/css" href="tooltip.css">
</head>
<body>
<div id=keret>
<center id=mai><h2 id=cim>Tauri IRClog browser</h2></center>
<a href="chart2.png"><div id=lebeg><span class="tool" data-tip="2018-09-29 óta gyűjtött adatok alapján.">ALL TIME STAT</span></div></a>
<div id=lebeg2><span class="tool" data-tip="Előzmények 2018-09-29 után érhetőek el hiánytalanul.">INFO</span>
</div><center><img src="chart.png" alt="chart" height="15%" width="50%"></center><br>
<div id=mai><center><b>
<?php
	$msgdarab = DB::query("SELECT COUNT(*) from irclog where whattime >= CURDATE() group by WEEKDAY(whattime) order by WEEKDAY(whattime);");
	foreach ($msgdarab as $row) { echo $row['COUNT(*)']; }
?> Üzenet érkezett ma
</b></center></div><br>
<div id=header style="width: 99%">
	<form action="" method="post">
	<br>
	<div id=date><b id=cim>Keyword</b></div>
	<input id=meret type="text" name="msg" value="<?php echo $_POST["msg"]; ?>">
	<input type="submit" class=button>
	</form>
</div><br>
<div id=alsav style="width: 99%">
	<form action="" method="post">
	<br>
	<div id=date><b id=cim>Date from</b></div>
	<input type="date" name="datefrom" value=""><!--<input type="time" name="timefrom" value="">--><br>
	<div id=date><b id=cim>Date until</b></div>
	<input type="date" name="dateto" value=""><!--<input type="time" name="timefrom" value="">-->
	<input id=meret type="submit" class=button>
	</form>
</div>
<br>
<div id=keret2>
<?php

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
<div id=footer>Created by: Sontii | 2018
Armory link: <b><a href="https://tauriwow.com/armory#character-sheet.xml?r=%5BHU%5D%20Tauri%20WoW%20Server&n=S%C3%B8ntii">KATT!</a></b>
</div>
</body>

</html>
