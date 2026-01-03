<p>&nbsp;</p>

<p align=right><div align=right><?php echo isset($engine_name_en) ? $engine_name_en : 'Goshen Bible Engine'; ?> <?php echo isset($engine_name_cn) ? $engine_name_cn : '歌珊地圣经引擎'; ?> © <?php 
$copyright_display = isset($copyright_text) ? $copyright_text : '2004-2024 歌珊地科技 Goshen Tech, 2025-2026 唯爱AI基金会 VI AI Foundation';
$copyright_display = str_replace('歌珊地科技 Goshen Tech', '<a href="https://geshandi.com" target="_blank">歌珊地科技 Goshen Tech</a>', $copyright_display);
$copyright_display = str_replace('唯爱AI基金会 VI AI Foundation', '<a href="https://viaifoundation.org" target="_blank">唯爱AI基金会 VI AI Foundation</a>', $copyright_display);
echo $copyright_display;
?> <a href="<?php echo isset($long_url_base) ? $long_url_base : 'https://bibleengine.ai'; ?>"><?php echo isset($long_url_base) ? $long_url_base : 'https://bibleengine.ai'; ?></a> | <a href="<?php echo isset($github_url) ? $github_url : 'https://github.com/viaifoundation/bibleengine'; ?>" target="_blank"><?php echo function_exists('t') ? t('source_code_full') : '源码 Source Code'; ?></a></div></p>
<?php
include("blogroll.php");
?>
<!-- RefTagger from Logos. Visit http://www.logos.com/reftagger. This code should appear directly before the </body> tag. -->
