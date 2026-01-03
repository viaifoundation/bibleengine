
</p>

<p align=right><div align=right><?php echo isset($engine_name_en) ? $engine_name_en : 'Goshen Bible Engine'; ?> <?php echo isset($engine_name_cn) ? $engine_name_cn : '歌珊地圣经引擎'; ?> 微信 订阅号 iGeshandi 服务号 BibleEngine <a href="http://BibleEngine.com">BibleEngine.com</a> <a href="http://bible.geshandi.com">bible.geshandi.com</a>  <a href="http://bible.farm">bible.farm</a><br/>
 © <?php 
$copyright_display = isset($copyright_text) ? $copyright_text : '2004-2024 歌珊地科技 Goshen Tech, 2025-2026 唯爱AI基金会 VI AI Foundation';
$copyright_display = str_replace('歌珊地科技 Goshen Tech', '<a href="https://geshandi.com" target="_blank">歌珊地科技 Goshen Tech</a>', $copyright_display);
$copyright_display = str_replace('唯爱AI基金会 VI AI Foundation', '<a href="https://viaifoundation.org" target="_blank">唯爱AI基金会 VI AI Foundation</a>', $copyright_display);
echo $copyright_display;
?>
<br/><small><a href="http://www.miitbeian.gov.cn/">(浙ICP备06038725号-1 辽ICP备12006535号-1)</a></small></div></p>
