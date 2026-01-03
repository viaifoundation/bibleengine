<?php require_once("config.php")?>
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
?>">帮助 Help</a>
|
<a href="<?php echo isset($github_url) ? $github_url : 'https://github.com/viaifoundation/bibleengine'; ?>" target="_blank">源码 Source Code</a>
|
<a href="https://viaifoundation.org" target="_blank">唯爱AI基金会 VI AI Foundation</a>
 
</div></center>
</p>
<?php }else{ ?>
<center><div align="center">
<table border=0><tr>
<td><p><a href="<?php echo $long_url_base?>"><img src="<?php echo $logo?>" alt="<?php echo $title?>" longdesc="<?php echo $title?>" border="0" height="31" width="88" /></a> </td>
<td><?php echo isset($engine_name_full) ? $engine_name_full : '<b>歌珊地圣经引擎</b>——给力的圣经研读和圣经搜索引擎 <br/> <b>Goshen Bible Engine</b> -- Powerful Bible Study and Bible Search Engine'; ?></td>
</tr></table>
<br/><a href="<?php echo $long_url_base?>"><?php echo $sitename?></a>
<a href="../">网页版 Web</a> |
<a href="<?php 
$wiki_help_url = isset($wiki_base) ? rtrim($wiki_base, '/w') . '/wiki/BibleEngine' : 'https://bible.world/wiki/BibleEngine';
echo $wiki_help_url;
?>">帮助 Help</a> |
<a href="<?php echo isset($github_url) ? $github_url : 'https://github.com/viaifoundation/bibleengine'; ?>" target="_blank">源码 Source Code</a> |
<a href="https://viaifoundation.org" target="_blank">唯爱AI基金会 VI AI Foundation</a>
</div></center>

<?php } ?>
