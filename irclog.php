<?php

require_once 'dbclass.php';

$fromuser = $_GET['fromuser'];
$touser = $_GET['touser'];
$msg = $_GET['msg'];
$when = date('Y-m-d H:i:s');

DB::$user = 'username';
DB::$password = 'password';
DB::$dbName = 'database';

DB::insert('irclog', array(
         'id' => NULL,
         'fromuser' => $fromuser,
         'touser' => $touser,
	 'msg' => $msg,
         'whattime' => $when
));
?>

