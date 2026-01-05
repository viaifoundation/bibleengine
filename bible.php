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
	require_once(__DIR__ . '/config/dbconfig.php');
	require_once(__DIR__ . '/config.php');
	
	// Use mysqli instead of SaeMysql
	$db = new mysqli($dbhost, $dbuser, $dbpassword, $database, (int)($dbport ?? 3306));
	if ($db->connect_error) {
		error_log("Database connection error: " . $db->connect_error);
		// Don't die, just redirect without updating likes
	} else {
		$db->set_charset('utf8mb4');
		$db->query("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
		$sql = "UPDATE bible_books SET likes = likes + 1 WHERE book=" . (int)$book . " AND chapter=" . (int)$chapter . " AND verse=" . (int)$verse;
		$db->query($sql);
		$db->close();
	}
}
$url = "Location: $url";
header($url);
exit();

?>