<?php
// Define $img_url before requiring common.php since it uses it
if (!isset($img_url)) {
    $img_url = "https://engine.bible.world";
}
require_once(__DIR__ . "/common.php");
// Load dbconfig.php with error handling
$dbconfig_path = __DIR__ . "/config/dbconfig.php";
if (!file_exists($dbconfig_path)) {
    // Try alternative location for backward compatibility
    $dbconfig_path_alt = __DIR__ . "/dbconfig.php";
    if (file_exists($dbconfig_path_alt)) {
        require_once($dbconfig_path_alt);
    } else {
        error_log("Error: Database config file not found. Expected: " . __DIR__ . "/config/dbconfig.php");
        throw new Exception("Database configuration file not found. Please create config/dbconfig.php with database credentials.");
    }
} else {
    require_once($dbconfig_path);
}
if (!isset($long_url_base)) {
    $long_url_base = "https://engine.bible.world";
}
//$short_url_base="http://ymnl.org";
//$short_url_base=$long_url_base;
// $img_url should be set by index.php, only set default if not already set
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
if (!isset($engine_name_en)) {
    $engine_name_en = 'Goshen Bible Engine';
}
if (!isset($engine_name_cn)) {
    $engine_name_cn = function_exists('t') ? t('engine_name') : '歌珊地圣经引擎';
}
if (!isset($engine_name_full)) {
    // engine_name_full will be set from translations if lang.php is loaded
    if (function_exists('t')) {
        $engine_name_full = t('engine_name_full');
    } else {
        $engine_name_full = $engine_name_cn . '——给力的圣经研读和圣经搜索引擎 <br/> <b>' . $engine_name_en . '</b> -- Powerful Bible Study and Bible Search Engine';
    }
}
if (!isset($copyright_text)) {
    $copyright_text = '2004-2024 歌珊地科技 Goshen Tech, 2025-2026 唯爱AI基金会 VI AI Foundation';
}
if (!isset($github_url)) {
    $github_url = 'https://github.com/viaifoundation/bibleengine';
}
?>
