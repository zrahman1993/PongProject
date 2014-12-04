<?php
// insert score into scores database
//
include_once 'dbconn.php';
error_reporting(0);
$gameid = $_REQUEST["gameid"];
$name   = $_REQUEST["name"];
$score  = $_REQUEST["score"];
$ip     = $_SERVER["REMOTE_ADDR"];
$agent  = $_SERVER["HTTP_USER_AGENT"];


//$dbh=mysql_connect ("localhost", "root") 
//        or die ('I cannot connect to the database because: ' . mysql_error());
//mysql_select_db ("high_scores");

$sSQL = "insert into scores(gameid, name, score, ip, agent, time) 
    values ($gameid, '$name', $score, '$ip', '$agent', now())";
mysql_query($sSQL) or die (mysql_error());

mysql_close();


