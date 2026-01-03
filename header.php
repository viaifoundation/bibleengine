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
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes" />
	<link rel="shortcut icon" href="<?php echo $img_url?>/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" href="<?php echo $img_url?>/favicon.png" type="image/png" />
	<link rel="icon" href="<?php echo $img_url?>/favicon.ico" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $img_url?>/css/css.css" />
	<meta name="description" content="<?php 
$engine_name_cn_meta = function_exists('t') ? t('engine_name') : (isset($engine_name_cn) ? $engine_name_cn : '歌珊地圣经引擎');
$engine_tagline_cn_meta = function_exists('t') ? t('engine_tagline') : '给力的圣经研读和搜索引擎';
$engine_name_en_meta = isset($engine_name_en) ? $engine_name_en : 'Goshen Bible Engine';
$engine_tagline_en_meta = 'Powerful Bible Study and Search Engine';
echo htmlspecialchars($engine_name_cn_meta) . '——' . htmlspecialchars($engine_tagline_cn_meta) . ' ' . htmlspecialchars($engine_name_en_meta) . ' -- ' . htmlspecialchars($engine_tagline_en_meta);
?> " />
	<meta name="keywords" content="圣经,研读,研经,搜索,引擎, Bible, Study, Search, Engine"/>
	<title><?php echo $title?></title>
