<?php
require_once("config.php");
$host = isset($_SERVER['HTTP_HOST']) ? strtolower($_SERVER['HTTP_HOST']) : '';	
$https = isset($_SERVER['HTTPS']) ? strtolower($_SERVER['HTTPS']) : '';	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-cn">
<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<meta content="zh-cn" http-equiv="Content-Language"/>
	<link rel="shortcut icon" href="<?php echo $img_url?>/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" href="<?php echo $img_url?>/favicon.png" type="image/png" />
	<link rel="icon" href="<?php echo $img_url?>/favicon.ico" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $img_url?>/css/css.css" />
	<meta name="description" content="歌珊地圣经引擎——给力的圣经研读和搜索引擎 Geshandi Bible Engine -- Powerful Bible Study and Search Engine " />
	<meta name="keywords" content="圣经,研读,研经,搜索,引擎, Bible, Study, Search, Engine"/>
	<title><?php echo $title?></title>
