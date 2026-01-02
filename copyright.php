<?php

header("Location: https://bible.world/wiki/圣经版权");

$search = trim($_REQUEST['s'] ?? '');
$chapter = (int)($_REQUEST['c'] ?? 0);
$verse = (int)($_REQUEST['v'] ?? 0);
$book = $_REQUEST['b'] ?? '';
$name = $_REQUEST['n'] ?? '';
$query = $_REQUEST['q'] ?? '';
$multi_verse = $_REQUEST['m'] ?? '';
$verse2 = (int)($_REQUEST['v2'] ?? 0);
$search_table = 'bible_cuv_search';
$language = $_REQUEST['l'] ?? '';
if($language)
	$search_table = 'bible_cuvt_search';
if($multi_verse)
	$search_table = 'bible_cuvm_search';	
//$filename = $_SERVER['SCRIPT_NAME'];
if(!$name)
	$name = "John";
if($chapter < 1)
	$chapter = 1;
	
$count = 0;
$title = "$name.$chapter";
if($verse)
$title = $title . ".$verse";
if($verse)
	$show_verse = true;
else
	$show_verse = false;
if($search)
		$show_verse = true;
if($verse2)
$title = $title . "-$verse2";

$title = $title . " Godwithus Bible Search 神同在圣经";
$logo= "/logos/logo_bible.png";

?>


<?php 
// Skip header includes since this file redirects
?>
<script type="text/javascript" charset="gb2312-80"  >
var momourl = " http://zhsw.org/bk";
var momoid = "";
var momolength = "16";
var momotype = "0";
</script>
<script type="text/javascript" src=" http://zhsw.org/bk/plugins/momo/momo.js"></script>
</head>
<body>
<h1 id="firstHeading" class="firstHeading">神同在圣经</h1>
		<div id="bodyContent">
			<h3 id="siteSub">出自Godwithus Wiki</h3>
			<div id="contentSub"></div>
									<div id="jump-to-nav">跳转到： <a href="#column-one">导航</a>, <a href="#searchInput">搜索</a></div>			<!-- start content -->

			<p>神同在圣经使用帮助
</p><p>神与我们同在网站圣经阅读、查询和定位工具
</p><p>本页网址 <a href="http://wiki.godwithus.cc/wiki/%E7%A5%9E%E5%90%8C%E5%9C%A8%E5%9C%A3%E7%BB%8F" class="external free" title="http://wiki.godwithus.cc/wiki/神同在圣经" rel="nofollow">http://wiki.godwithus.cc/wiki/神同在圣经</a> 
</p><p><br>
使用说明：
</p><p>1 网址 中国镜像 <a href="http://godwithus.cn/bible/" class="external free" title="http://godwithus.cn/bible/" rel="nofollow">http://godwithus.cn/bible/</a> 或者 美国镜像 <a href="http://godwithus.cc/bible/" class="external free" title="http://godwithus.cc/bible/" rel="nofollow">http://godwithus.cc/bible/</a>
</p><p>2 版本 因为版权原因，只提供中文和合本CUV和英文英王钦定本KJV的在线阅读，但是同时提供指定章节到其他网站不同圣经版本译本的链接。等获得授权后会在线提供多版本的圣经对比阅读
</p><p>3 阅读 可以选择不同的书卷，按照章阅读，同时提供中英文经文，每一节提供到节的链接，连过去后简体中文、繁体中文和合本和英文KJV版本对比阅读，提供该节的上下文经文。每一章或者每一节均提供到其他圣经网站对应章节的资链接料。
</p><p>3.1 与圣经词典集成

</p>
<pre>目前神同在圣经与中华圣网百科辞典集成，您只要划词，就可以查看或者创建选中的词的词典信息。
</pre>
<p>3.2 电子版经文在线报错
</p>
<pre>神同在圣经增加电子版经文错误在线提交报告功能，如果发现某节经文有错误，只要点击一下即可提交错误报告，同时提供经文最新版更新日期，供差错使用。
</pre>
<p>4 搜索 
</p><p>4.1 搜索说明 
</p>
<pre>使用关键词，空格分隔最多10个关键词，为了更加精确请增加搜索关键词或者限定查询范围。<b>同时使用简体中文“上帝”版和“神”版和合本经文搜索，例如可以搜索“上帝爱世人”也可以“神爱世人”</b>。过滤了标点符号，例如搜索“是就说是”，可以同时返回“是，就说是”和“是就说是”。可以选择搜索范围，正本圣经、全部旧约、全部新约、某一个或者几个类别的书卷和某个书卷。同時支持簡體中文和繁體中文的搜索，如果要搜索繁體中文（只限神版），選中複選框即可。支持多节搜索，即可以在连续三节之内搜索需要的关键词组合。
</pre>
<p>4.2 搜索示例
</p>
<pre>例如：耶稣 基督 保罗；又如：上帝说 要 光；再如：眼睛 神 拉结；还如：上帝爱世人。

</pre>
<p>4.3 搜索建议
</p>
<pre>当记不清楚一节经文的确切内容，但是记得大概内容时，可以把可以确定的一些词作为关键词输入搜索。如果确定大概经文在那部分书卷，可以搜索时限定搜索范围。当返回结果过多的时候尽量增加关键词，而结果过少则减少关键词进行搜索。
</pre>
<p>4.3 增加章节定位功能
</p>
<pre>支持经文定位搜索，例如可以搜索 "约 3"则直接查看约翰福音3章，"约翰福音 3:16"为约翰福音3章16节，而 "John 3:16-18"为约翰福音3章16-18节。支持简体、翻译和英文的书卷名全称和缩写。
</pre>
<p>5 意见建议反馈 本网络模块旨在方便主内牧者和肢体查经服务，希望尽量满足肢体的需求和方便使用，如果您有任何的意见建议请发电邮反馈给Michael HUO  godwithus[AT]godwithus.cc。谢谢，感谢神。
</p>
<P>&nbsp;</P>
<?php 
if (file_exists(__DIR__ . "/footer.php")) {
    include(__DIR__ . "/footer.php");
}
?>
