<?php 
// Ensure lang.php is loaded if not already
if (!function_exists('t')) {
    require_once(__DIR__ . '/lang.php');
}
require_once("config.php")?>
<?php if(!$portable) { ?>
<center><div align="center">
<table border=0><tr>
<td><p><a href="<?php echo $long_url_base?>"><img src="<?php echo $logo?>" alt="<?php echo $title?>" longdesc="<?php echo $title?>" border="0" height="31" width="88" /></a> </td>
<td><?php echo isset($engine_name_full) ? $engine_name_full : '<b>歌珊地圣经引擎</b>——给力的圣经研读和圣经搜索引擎 <br/> <b>Goshen Bible Engine</b> -- Powerful Bible Study and Bible Search Engine'; ?></td>
</tr></table>
<br/><br/>
<a href="<?php echo $long_url_base?>"><?php echo $sitename?></a> 
|
<a href="<?php
$wiki_help_url = isset($wiki_base) ? rtrim($wiki_base, '/w') . '/wiki/BibleEngine' : 'https://bible.world/wiki/BibleEngine';
echo $wiki_help_url;
?>"><?php echo function_exists('t') ? t('help_full') : '帮助 Help'; ?></a>
|
<a href="<?php echo isset($github_url) ? $github_url : 'https://github.com/viaifoundation/bibleengine'; ?>" target="_blank"><?php echo function_exists('t') ? t('source_code_full') : '源码 Source Code'; ?></a>
|
<a href="https://viaifoundation.org" target="_blank">唯爱AI基金会 VI AI Foundation</a>
<?php if (function_exists('getLanguageSwitcher')) echo ' | ' . getLanguageSwitcher(); ?>
 
</div></center>
</p>
<?php }else{ ?>
<center><div align="center">
<table border=0><tr>
<td><p><a href="<?php echo $long_url_base?>"><img src="<?php echo $logo?>" alt="<?php echo $title?>" longdesc="<?php echo $title?>" border="0" height="31" width="88" /></a> </td>
<td><?php echo isset($engine_name_full) ? $engine_name_full : '<b>歌珊地圣经引擎</b>——给力的圣经研读和圣经搜索引擎 <br/> <b>Goshen Bible Engine</b> -- Powerful Bible Study and Bible Search Engine'; ?></td>
</tr></table>
<br/><a href="<?php echo $long_url_base?>"><?php echo $sitename?></a>
<a href="../"><?php echo function_exists('t') ? t('web_version_full') : '网页版 Web'; ?></a> |
<a href="<?php 
$wiki_help_url = isset($wiki_base) ? rtrim($wiki_base, '/w') . '/wiki/BibleEngine' : 'https://bible.world/wiki/BibleEngine';
echo $wiki_help_url;
?>"><?php echo function_exists('t') ? t('help_full') : '帮助 Help'; ?></a> |
<a href="<?php echo isset($github_url) ? $github_url : 'https://github.com/viaifoundation/bibleengine'; ?>" target="_blank"><?php echo function_exists('t') ? t('source_code_full') : '源码 Source Code'; ?></a> |
<a href="https://viaifoundation.org" target="_blank">唯爱AI基金会 VI AI Foundation</a>
<?php if (function_exists('getLanguageSwitcher')) echo ' | ' . getLanguageSwitcher(); ?>
</div></center>

<?php } ?>
