<?php
// Define $img_url before requiring common.php since it uses it
if (!isset($img_url)) {
    $img_url = "https://engine.bible.world";
}
require_once("common.php");
require_once("dbconfig.php");
if (!isset($long_url_base)) {
    $long_url_base = "https://engine.bible.world";
}
//$short_url_base="http://ymnl.org";
//$short_url_base=$long_url_base;
if (!isset($img_url)) {
    $img_url = "https://engine.bible.world";
}
if (!isset($wiki_base)) {
    $wiki_base = "https://Bible.World";
}
if (!isset($max_book_count)) {
    $max_book_count = 7;
}
if (!isset($max_record_count)) {
    $max_record_count = 500;
}
if (!isset($sitename)) {
    $sitename = "@歌珊地圣经引擎 Wechat 微信号 CCBible/DBible/BibleEngine";
}
?>
