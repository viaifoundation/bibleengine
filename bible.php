<?php
$chapter = (int)$_REQUEST['c'];
$verse = (int)$_REQUEST['v'];
$book = (int)$_REQUEST['b'];
$cmd =  $_REQUEST['cmd'];
if(isset($_SERVER['HTTP_REFERER']))
	$url=   $_SERVER['HTTP_REFERER'];
else
	$url = "index.php?b=$book&c=$chapter&v=$verse";
if($cmd=='like' && $book && $verse && $chapter)
{
	//require('dbconfig.php');
	//$db = mysql_connect($dbhost, $dbuser, $dbpassword)
	//or die("Connection Error: " . mysql_error());

	//mysql_select_db($database) or die("Error conecting to db.");
	//mysql_query("SET NAMES utf8", $db);
	$db = new SaeMysql();
	$sql="SET NAMES utf8";
	$db->runSql( $sql );
	$sql="UPDATE bible_books set likes = likes + 1 where book=$book and chapter=$chapter and verse=$verse";

	//$result = mysql_query( $sql ) or die("Could not execute query.".mysql_error());
	$db->runSql( $sql );
}
$url = "Location: $url";
header($url);
exit();

?>