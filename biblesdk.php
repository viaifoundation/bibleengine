<?php
class BibleEngine {

function show_example()
{
	$txt="\n【使用示例】\n\n";
	$txt .="在输入框内输入空格分隔的关键词例如“耶稣 保羅 Christ”，或者输入标准的圣经书卷名索引例如“约 3:16-18；Mt 5:10;1 John 2:1-2;羅馬書 1:2-4,7,9-11”";
	$txt .="约 3:16-18;太 5:10;1 John 2:1-2;羅馬書 1:2-4,7,9-11\n";
	$txt .="约 3:16-19,21-23,26;提後 3:13,15-17;Rom 5:20\n";
	$txt .="可以搜索“上帝爱世人”也可以“神爱世人”\n";
	$txt .="例如：耶稣 基督 保罗；又如：上帝说 要 光；再如：眼睛 神 拉结；还如：上帝爱世人。中英文混合：God Paul 基督 耶穌\n";
	$txt .= "\n可选择书卷范围 例如搜索摩西五经“神 说 @创-申” 或 “神 说 @1-5” 或搜索新约“以赛亚 @40-66”或“以赛亚 @太-启”，搜索福音书“是就说是 @40-43”或“是就说是 @太-约”（支持所有中英文简繁体书卷名和缩写格式和数字序号），需要将这个选项放在最后\n";
	$txt .= "请直接发送感叹号开头的查询关键词组合查阅词条，例如“!马太” “！问答 要理”（不含括号）\n";
	$txt .= "输入@数字表示阅读第几页，默认是第一页，例如 “！基督徒百科@2”表示词条“基督徒百科”的第二页。请讲该选项放到所有关键词之后。\n";
	$txt .= "因为有些词条标题可能还有空格，所以如果搜索可以考虑调换多个关键词的次序，例如“圣灵 果子”可能是一个词条标题，则输入“！果子 圣灵”是搜索。";
	$txt .=  this->show_hint() . this->show_banner();
	return $txt;
}
function show_help()
{
	$txt="\n【使用帮助】\n\n";
	$txt .="(接收#每日真道圣言#推送请关注歌珊地iGeshandi和基督徒百科CCBible)\n\n";
	$txt .="请发送圣经搜索关键词或圣经章节索引查询(请不要输入标点符号)。支持中文简体繁体和英文大小写的混合输入，兼容半角和全角的标点符号。\n";
	$txt .= "\n可选择书卷范围 例如“神 说 @创” 或 “神 说 @出-利” 或“以赛亚 @40-66”\n";
	$txt .= "\n可使用斜线设定输出选项，例如 /E /EN 发送英文 /C /CN 简体中文 /T /TW 繁体中文 /P /PINYIN 拼音译本 /NCVS /LCVS /BBE /KJV1611 /UKJV  不同译本，/s 显示原文编码\n";
	$txt .= "查询百科词条请直接发送感叹号开头的查询关键词组合，例如“!马太” “！问答 要理”\n";
	$txt .= "输入@数字表示阅读第几页，默认是第一页，例如 “！基督徒百科@2”表示词条“基督徒百科”的第二页。\n";
	$txt .= "发送的信息将在百科词条标题中搜索，如果直接存在该词条则显示词条内容，否则显示搜索到的词条列表。\n";
	$txt .= "\n发送问号 ? 开头的信息不自动回复，将保存并由同工手动回复，欢迎发送问题、代祷需求或反馈建议。\n";
	$txt .= "\n发送数字0开头的信息进入歌珊地圣经问答模块。\n";
	$txt .= "\n附圣经书卷编号 创1, 出2, 利3, 民4, 申5, 书6, 士7, 得8, 撒上9, 撒下10, 王上11, 王下12, 代上13, 代下14, 拉15, 尼16, 斯17, 伯18, 诗19, 箴20, 传21, 歌22, 赛23, 耶24, 哀25, 结26, 但27, 何28, 珥29, 摩30, 俄31, 拿32, 弥33, 鸿34, 哈35, 番36, 该37, 亚38, 玛39, 太40, 可41, 路42, 约43, 徒44, 罗45, 林前46, 林后47, 加48, 弗49, 腓50, 西51, 帖前52, 帖后53, 提前54, 提后55, 多56, 门57, 来58, 雅59, 彼前60, 彼后61, 约一62, 约二63, 约三64, 犹65, 启66\n";
	$txt .=  $this->show_hint() . $this->show_banner();
	return $txt;
}
function show_about()
{
	$txt="\n【关于我们】\n\n基督徒百科和歌珊地圣经引擎微信公众版\n\n";
	$txt .= "\n我们的信条：威斯敏斯特信条（西敏信条） wcf，威斯敏斯特大要理问答（大要理问答）wlc，威斯敏斯特小要理问答（小要理问答）wsc";
    $txt .= "\n我们也认信：使徒信经 尼西亚信经 亚他那修信经 海德堡要理问答hc 比利时信条bc 多特法典cd 芝加哥圣经无误宣言";
	$txt .= "\n\n我们的微信公众号：基督徒百科 CCBible  歌珊地 iGeshandi 歌珊地圣经引擎服务号 BibleEngine";
    $txt .= "\n\n我们的微博：@基督徒百科@歌珊地科技";
    $txt .= "\n\n我们的信望爱团契千人QQ群：福音群4619600 　学习群226112909 　团契群89857902 　神学群81591230 　商务群226112700";
    $txt .= "\n\n详细帮助请参阅基督徒百科的歌珊地圣经引擎词条 http://baike.jidutu.org/wiki/BibleEngine\n";
	$txt .= "\n\n基督徒百科微信公众版词条 http://baike.jidutu.org/wiki/ccbible\n";
    $txt .= "\n\n联系方式：微博 @如鹰展翼而上@歌珊地圣经引擎 微信脸书推特领英 michaelhuo 电邮 huo@live.cn QQ 38799316\n";
	$txt .=  $this->show_hint() . $this->show_banner();
	return $txt;
}
function show_banner()
{

	$txt =  "\n基督徒百科 CCBible 歌珊地 iGeshandi 歌珊地圣经引擎 BibleEngine\n@基督徒百科@歌珊地科技";
	return $txt;
}
function show_hint()
{

	$txt =  "\n回复1查看帮助 回复2查看示例 回复0查看介绍";
	return $txt;
}

function search($q)
{

	if($q=="")
	{
		$txt="欢迎关注，愿上帝赐福！" . $this->show_hint() . $this->show_banner();
		$txt .=  "可发送搜索关键词或经文章节号查询检索，欢迎您的意见或改进建议"  . $this->show_hint() . $this->show_banner();
		return $txt;	
	}else{
		return "您说: " . $q;
	}
}

}//class BibleEngine

class Bible {
    
function show_example()
{
	$txt="\n【使用示例】\n\n";
	$txt .="在输入框内输入空格分隔的关键词例如“耶稣 保羅 Christ”，或者输入标准的圣经书卷名索引例如“约 3:16-18；Mt 5:10;1 John 2:1-2;羅馬書 1:2-4,7,9-11”";
	$txt .="约 3:16-18;太 5:10;1 John 2:1-2;羅馬書 1:2-4,7,9-11\n";
	$txt .="约 3:16-19,21-23,26;提後 3:13,15-17;Rom 5:20\n";
	$txt .="可以搜索“上帝爱世人”也可以“神爱世人”\n";
	$txt .="例如：耶稣 基督 保罗；又如：上帝说 要 光；再如：眼睛 神 拉结；还如：上帝爱世人。中英文混合：God Paul 基督 耶穌\n";
	$txt .= "\n可选择书卷范围 例如搜索摩西五经“神 说 @创-申” 或 “神 说 @1-5” 或搜索新约“以赛亚 @40-66”或“以赛亚 @太-启”，搜索福音书“是就说是 @40-43”或“是就说是 @太-约”（支持所有中英文简繁体书卷名和缩写格式和数字序号），需要将这个选项放在最后\n";
	$txt .= "请直接发送感叹号开头的查询关键词组合查阅词条，例如“!马太” “！问答 要理”（不含括号）\n";
	$txt .= "输入@数字表示阅读第几页，默认是第一页，例如 “！基督徒百科@2”表示词条“基督徒百科”的第二页。请讲该选项放到所有关键词之后。\n";
	$txt .= "因为有些词条标题可能还有空格，所以如果搜索可以考虑调换多个关键词的次序，例如“圣灵 果子”可能是一个词条标题，则输入“！果子 圣灵”是搜索。";
	$txt .=  show_hint() . show_banner();
	return $txt;
}
function show_help()
{
	$txt="\n【使用帮助】\n\n";
	$txt .="(接收#每日真道圣言#推送请关注歌珊地iGeshandi和基督徒百科CCBible)\n\n";
	$txt .="请发送圣经搜索关键词或圣经章节索引查询(请不要输入标点符号)。支持中文简体繁体和英文大小写的混合输入，兼容半角和全角的标点符号。\n";
	$txt .= "\n可选择书卷范围 例如“神 说 @创” 或 “神 说 @出-利” 或“以赛亚 @40-66”\n";
	$txt .= "\n可使用斜线设定输出选项，例如 /E /EN 发送英文 /C /CN 简体中文 /T /TW 繁体中文 /P /PINYIN 拼音译本 /NCVS /LCVS /BBE /KJV1611 /UKJV  不同译本，/s 显示原文编码\n";
	$txt .= "查询百科词条请直接发送感叹号开头的查询关键词组合，例如“!马太” “！问答 要理”\n";
	$txt .= "输入@数字表示阅读第几页，默认是第一页，例如 “！基督徒百科@2”表示词条“基督徒百科”的第二页。\n";
	$txt .= "发送的信息将在百科词条标题中搜索，如果直接存在该词条则显示词条内容，否则显示搜索到的词条列表。\n";
	$txt .= "\n发送问号 ? 开头的信息不自动回复，将保存并由同工手动回复，欢迎发送问题、代祷需求或反馈建议。\n";
	$txt .= "\n发送数字0开头的信息进入歌珊地圣经问答模块。\n";
	$txt .= "\n附圣经书卷编号 创1, 出2, 利3, 民4, 申5, 书6, 士7, 得8, 撒上9, 撒下10, 王上11, 王下12, 代上13, 代下14, 拉15, 尼16, 斯17, 伯18, 诗19, 箴20, 传21, 歌22, 赛23, 耶24, 哀25, 结26, 但27, 何28, 珥29, 摩30, 俄31, 拿32, 弥33, 鸿34, 哈35, 番36, 该37, 亚38, 玛39, 太40, 可41, 路42, 约43, 徒44, 罗45, 林前46, 林后47, 加48, 弗49, 腓50, 西51, 帖前52, 帖后53, 提前54, 提后55, 多56, 门57, 来58, 雅59, 彼前60, 彼后61, 约一62, 约二63, 约三64, 犹65, 启66\n";
	$txt .=  show_hint() . show_banner();
	return $txt;
}
function show_about()
{
	$txt="\n【关于我们】\n\n基督徒百科和歌珊地圣经引擎微信公众版\n\n";
	$txt .= "\n我们的信条：威斯敏斯特信条（西敏信条） wcf，威斯敏斯特大要理问答（大要理问答）wlc，威斯敏斯特小要理问答（小要理问答）wsc";
    $txt .= "\n我们也认信：使徒信经 尼西亚信经 亚他那修信经 海德堡要理问答hc 比利时信条bc 多特法典cd 芝加哥圣经无误宣言";
	$txt .= "\n\n我们的微信公众号：基督徒百科 CCBible  歌珊地 iGeshandi 歌珊地圣经引擎服务号 BibleEngine";
    $txt .= "\n\n我们的微博：@基督徒百科@歌珊地科技";
    $txt .= "\n\n我们的信望爱团契千人QQ群：福音群4619600 　学习群226112909 　团契群89857902 　神学群81591230 　商务群226112700";
    $txt .= "\n\n详细帮助请参阅基督徒百科的歌珊地圣经引擎词条 http://baike.jidutu.org/wiki/BibleEngine\n";
	$txt .= "\n\n基督徒百科微信公众版词条 http://baike.jidutu.org/wiki/ccbible\n";
    $txt .= "\n\n联系方式：微博 @如鹰展翼而上@歌珊地圣经引擎 微信脸书推特领英 michaelhuo 电邮 huo@live.cn QQ 38799316\n";
	$txt .=  show_hint() . show_banner();
	return $txt;
}
function show_banner()
{

	$txt =  "\n基督徒百科 CCBible 歌珊地 iGeshandi 歌珊地圣经引擎 BibleEngine\n@基督徒百科@歌珊地科技";
	return $txt;
}
function show_hint()
{

	$txt =  "\n回复1查看帮助 回复2查看示例 回复0查看介绍";
	return $txt;
}
function save_log($MsgID,$fromUsername,$toUsername,$time,$msgType,$keyword)
{

	require_once("config.php");
	require('dbconfig.php');
	$db = mysql_connect($dbhost_w.":".$dbport, $dbuser, $dbpassword);
	if(!$db)
		return "Connection Error: " . mysql_error();
		
	mysql_select_db($database,$db);
	mysql_query("SET NAMES utf8", $db);
	if($keyword && ctype_digit($keyword))
	{
		$id=(int)$keyword;
		$sql="SELECT Question, Answer, AnswerTime FROM wechat_log WHERE ID=$id AND FromUserName='$fromUsername' AND NOT Answer IS NULL";
		//return $sql;
		$result = mysql_query( $sql );
		if(!$result)
		{
			$return=  mysql_error();	
			//
		}else{
			$row = mysql_fetch_array($result);
			if(!$row)
				$return = "我们的同工尚未回答您查询的 $keyword 号问题，或者该问题不是您问的。";
			else
				$return = "\n问题:\n" . $row["Question"] . "\n\n回答：\n" . $row["Answer"] . "\n(". $row["AnswerTime"] . ")";
		}
	}else{
		if(strlen($keyword)<7)
		{
			$return="为避免系统被恶意使用或者您的误操作，本次问题没有记录。请修改并发送更具体的问题。谢谢";
			mysql_close($db);
			return $return;
		}
		$sql="SELECT Question, ID FROM wechat_log WHERE Question='$keyword' AND FromUserName='$fromUsername'";
		//return $sql;
		$result = mysql_query( $sql );
		if(!$result)
		{
			$return=  mysql_error();	
			//
		}else{
			$row = mysql_fetch_array($result);
			if($row)
			{
				$return = "\n您的问题:\n" . $row["Question"] . "\n已经记录，请发送“?" .  $row["ID"] ."”查看解答或者耐心等待同工回复。请勿重复提交。\n";
				mysql_close($db);
				return $return;
			}
		}

		$sql="INSERT INTO wechat_log (MsgID, ToUserName, FromUserName, CreateTime, MsgType, Content, Question) VALUES ($MsgID,'$toUsername','$fromUsername','$time','$msgType','$keyword','$keyword')";
		$result = mysql_query( $sql );
		if(!$result)
			$return=  mysql_error();
		else{
			$id=mysql_insert_id();
			$return= "您的问题已经收到，请等候同工回复，愿上帝赐福！请记住您的问题编号： $id 。" . "\n若问题已经回答，则您发送\"?$id\"则可以直接获得答案。";
		}
	}
	mysql_close($db);
	return $return;
	
}
function save_user($Username,$subscribe=true)
{
	require_once("config.php");
	require('dbconfig.php');
	$db = mysql_connect($dbhost_w.":".$dbport, $dbuser, $dbpassword);
	if(!$db)
		return "Connection Error: " . mysql_error();
		
	mysql_select_db($database,$db);
	mysql_query("SET NAMES utf8", $db);
	//$time=();
	if($subscribe)
		$sql="INSERT INTO wechat_users(UserName) VALUES ('$Username')";
	else
		$sql="DELETE FROM wechat_users WHERE UserName='$Username'";
	$result = mysql_query( $sql );
	if(!$result)
		$return=  mysql_error();
	else
		$return= "OK";
	mysql_close($db);
	return $return;
}
function str_sensitive($text)
{
	$search_str = array('奸淫','淫妇','行淫','卖淫','妓女');
	$replace_str = array('奸x淫','淫x妇','行x淫','卖x淫','妓x女');
	$text  = str_replace($search_str, $replace_str, $text);
	return $text;
}
function show_debug($text,$replace)
{
	//return "测试";
	mb_internal_encoding("UTF-8");
	if(!$replace)
		return $text;
	else
		return mb_substr($text,0,1) . "x" . mb_substr($text,1);
}

function search_wiki($q,$p=1)
{
	if($p<1)
		$p=1;
	$block_size=1800;
	//$url="http://www.google.com/search?start=0&num=1&q=allinlinks%3A$q&client=google-csbe&output=json&cx=013709217911230285018:1botswmgae4&ie=utf8&oe=utf8";
    //$url="http://godwithus.cn/w/api.php?action=query&prop=revisions&rvprop=content|size&format=xml&redirects&titles=$q";	
    $url="http://baike.jidutu.org/w/api.php?action=query&prop=revisions&rvprop=content|size&format=xml&redirects&titles=$q";	
	$ch = curl_init($url); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	$response = curl_exec($ch);
	//return substr($response,0,2000);
	$xml = simplexml_load_string($response);
	//if(!$xml)
	//$txt = print_r($xml,true);
	$size=(int)($xml->query->pages[0]->page->revisions[0]->rev["size"]);
	$page_count =ceil($size / $block_size);
	if($p > $page_count)
	{
		$p = $page_count;
	}
	return $q;
	
	$txt = (string)$xml->query->pages[0]->page->revisions[0]->rev;
	//$size = $attributes["size"];;
	//$txt = $size . " " . $txt;
	if(strlen($txt)>$block_size)
	{
		//mb_internal_encoding("UTF-8");
		$start = ($p -1) * $block_size;
		//return $start . " " . $size;
		$txt=mb_strcut($txt,$start, $block_size, 'utf-8') . "\n\n(第" . $p . "/" . $page_count . "页)";
		//$txt = mb_substr($txt,0,$block_size);
	}
	curl_close($ch);
	if(!$txt)
	{
	
		$url ="http://godwithus.cn/w/api.php?action=query&list=search&format=xml&srlimit=max&srsearch=$q";
		$ch = curl_init($url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$response = curl_exec($ch);
		curl_close($ch);
		//return substr($response,0,2000);
		$xml = simplexml_load_string($response);
		//$txt = print_r($xml,true);
		$count=count($xml->query->search->p);
		if($count>0)
			$txt .= "$q 共搜索到$count 个词条，请发送完整的词条标题查看内容：\n";
		for($i=0; $i<$count; $i++)
		{
			$txt .= "\n " . $xml->query->search->p[$i]["title"] . "\n";
		}

		if(strlen($txt)>2000)
			$txt=mb_strcut($txt,0,2000,'utf-8') . "\n\n内容太长有删节";
	}
	if(!$txt)
		$txt = "没有查到搜索的词条，请更换关键词再搜索。"  . show_hint() . show_banner();
	return $txt ;
	//return "OK";
}

function search($q)
{

	if($q=="")
	{
		$txt="欢迎关注，愿上帝赐福！" . show_hint() . show_banner();
		$txt .=  "可发送搜索关键词或经文章节号查询检索，欢迎您的意见或改进建议"  . show_hint() . show_banner();
		return $txt;	
	}else{
		return "You sent: " . $q;
	}
	
$book_short=array("", "Gen", "Exod", "Lev", "Num", "Deut", "Josh", "Judg", "Ruth", "1Sam", "2Sam", "1Kgs", "2Kgs", "1Chr", "2Chr", "Ezra", "Neh", "Esth", "Job", "Ps", "Prov", "Eccl", "Song", "Isa", "Jer", "Lam", "Ezek", "Dan", "Hos", "Joel", "Amos", "Obad", "Jonah", "Mic", "Nah", "Hab", "Zeph", "Hag", "Zech", "Mal", "Matt", "Mark", "Luke", "John", "Acts", "Rom", "1Cor", "2Cor", "Gal", "Eph", "Phil", "Col", "1Thess", "2Thess", "1Tim", "2Tim", "Titus", "Phlm", "Heb", "Jas", "1Pet", "2Pet", "1John", "2John", "3John", "Jude", "Rev");
//$book_index=array(""=>0, "Gen"=>1, "Exod"=>2, "Lev"=>3, "Num"=>4, "Deut"=>5, "Josh"=>6, "Judg"=>7, "Ruth"=>8, "1Sam"=>9, "2Sam"=>10, "1Kgs"=>11, "2Kgs"=>12, "1Chr"=>13, "2Chr"=>14, "Ezra"=>15, "Neh"=>16, "Esth"=>17, "Job"=>18, "Ps"=>19, "Prov"=>20, "Eccl"=>21, "Song"=>22, "Isa"=>23, "Jer"=>24, "Lam"=>25, "Ezek"=>26, "Dan"=>27, "Hos"=>28, "Joel"=>29, "Amos"=>30, "Obad"=>31, "Jonah"=>32, "Mic"=>33, "Nah"=>34, "Hab"=>35, "Zeph"=>36, "Hag"=>37, "Zech"=>38, "Mal"=>39, "Matt"=>40, "Mark"=>41, "Luke"=>42, "John"=>43, "Acts"=>44, "Rom"=>45, "1Cor"=>46, "2Cor"=>47, "Gal"=>48, "Eph"=>49, "Phil"=>50, "Col"=>51, "1Thess"=>52, "2Thess"=>53, "1Tim"=>54, "2Tim"=>55, "Titus"=>56, "Phlm"=>57, "Heb"=>58, "Jas"=>59, "1Pet"=>60, "2Pet"=>61, "1John"=>62, "2John"=>63, "3John"=>64, "Jude"=>65, "Rev"=>66);
$book_english=array( "", "Genesis", "Exodus", "Leviticus", "Numbers", "Deuteronomy", "Joshua", "Judges", "Ruth", "1 Samuel", "2 Samuel", "1 Kings", "2 Kings", "1 Chronicles", "2 Chronicles", "Ezra", "Nehemiah", "Esther", "Job", "Psalms", "Proverbs", "Ecclesiastes", "Song of Solomon", "Isaiah", "Jeremiah", "Lamentations", "Ezekiel", "Daniel", "Hosea", "Joel", "Amos", "Obadiah", "Jonah", "Micah", "Nahum", "Habakkuk", "Zephaniah", "Haggai", "Zechariah", "Malachi", "Matthew", "Mark", "Luke", "John", "Acts", "Romans", "1 Corinthians", "2 Corinthians", "Galatians", "Ephesians", "Philippians", "Colossians", "1 Thessalonians", "2 Thessalonians", "1 Timothy", "2 Timothy", "Titus", "Philemon", "Hebrews", "James", "1 Peter", "2 Peter", "1 John", "2 John", "3 John", "Jude", "Revelation");
$book_english2=array( "", "Genesis", "Exodus", "Leviticus", "Numbers", "Deuteronomy", "Joshua", "Judges", "Ruth", "1 Samuel", "2 Samuel", "1 Kings", "2 Kings", "1 Chronicles", "2 Chronicles", "Ezra", "Nehemiah", "Esther", "Job", "Psalm", "Proverbs", "Ecclesiastes", "Song of Songs", "Isaiah", "Jeremiah", "Lamentations", "Ezekiel", "Daniel", "Hosea", "Joel", "Amos", "Obadiah", "Jonah", "Micah", "Nahum", "Habakkuk", "Zephaniah", "Haggai", "Zechariah", "Malachi", "Matthew", "Mark", "Luke", "John", "Acts", "Romans", "1 Corinthians", "2 Corinthians", "Galatians", "Ephesians", "Philippians", "Colossians", "1 Thessalonians", "2 Thessalonians", "1 Timothy", "2 Timothy", "Titus", "Philemon", "Hebrews", "James", "1 Peter", "2 Peter", "1 John", "2 John", "3 John", "Jude", "Revelation");
$book_en=array("", "Gen", "Ex", "Lev", "Num", "Deut", "Josh", "Judg", "Ruth", "1 Sam", "2 Sam", "1 Kin", "2 Kin", "1 Chr", "2 Chr", "Ezra", "Neh", "Esth", "Job", "Ps", "Prov", "Eccl", "Song", "Is", "Jer", "Lam", "Ezek", "Dan", "Hos", "Joel", "Amos", "Obad", "Jon", "Mic", "Nah", "Hab", "Zeph", "Hag", "Zech", "Mal", "Matt", "Mark", "Luke", "John", "Acts", "Rom", "1 Cor", "2 Cor", "Gal", "Eph", "Phil", "Col", "1 Thess", "2 Thess", "1 Tim", "2 Tim", "Titus", "Philem", "Heb", "James", "1 Pet", "2 Pet", "1 John", "2 John", "3 John", "Jude", "Rev");
$book_en2=array("", "Ge", "Ex", "Le", "Nu", "De", "Jos", "Jud", "Ru", "1Sa", "2Sa", "1Ki", "2Ki", "1Ch", "2Ch", "Ezr", "Ne", "Es", "Job", "Psalm", "Pr", "Ec", "So", "Isa", "Jer", "La", "Eze", "Da", "Ho", "Joe", "Am", "Ob", "Jon", "Mic", "Na", "Hab", "Zep", "Hag", "Zec", "Mal", "Mt", "Mr", "Lu", "Joh", "Ac", "Ro", "1Co", "2Co", "Ga", "Eph", "Php", "Col", "1Th", "2Th", "1Ti", "2Ti", "Tit", "Phm", "Heb", "Jas", "1Pe", "2Pe", "1Jo", "2Jo", "3Jo", "Jude", "Re");
$book_en3=array("", "Gen", "Exo", "Lev", "Num", "Deu", "Jos", "Jdg", "Rut", "1Sa", "2Sa", "1Ki", "2Ki", "1Ch", "2Ch", "Ezr", "Neh", "Est", "Job", "Psa", "Pro", "Ecc", "Son", "Isa", "Jer", "Lam", "Eze", "Dan", "Hos", "Joe", "Amo", "Oba", "Jon", "Mic", "Nah", "Hab", "Zep", "Hag", "Zec", "Mal", "Mat", "Mar", "Luk", "Joh", "Act", "Rom", "1Co", "2Co", "Gal", "Eph", "Phi", "Col", "1Th", "2Th", "1Ti", "2Ti", "Tit", "Phm", "Heb", "Jam", "1Pe", "2Pe", "1Jo", "2Jo", "3Jo", "Jud", "Rev");
$book_chinese=array("", "创世记", "出埃及记", "利未记", "民数记", "申命记", "约书亚记", "士师记", "路得记", "撒母耳记上", "撒母耳记下", "列王纪上", "列王纪下", "历代志上", "历代志下", "以斯拉记", "尼希米记", "以斯帖记", "约伯记", "诗篇", "箴言", "传道书", "雅歌", "以赛亚书", "耶利米书", "耶利米哀歌", "以西结书", "但以理书", "何西阿书", "约珥书", "阿摩司书", "俄巴底亚书", "约拿书", "弥迦书", "那鸿书", "哈巴谷书", "西番雅书", "哈该书", "撒迦利亚书", "玛拉基书", "马太福音", "马可福音", "路加福音", "约翰福音", "使徒行传", "罗马书", "哥林多前书", "哥林多后书", "加拉太书", "以弗所书", "腓立比书", "歌罗西书", "帖撒罗尼迦", "帖撒罗尼迦", "提摩太前书", "提摩太后书", "提多书", "腓利门书", "希伯来书", "雅各书", "彼得前书", "彼得后书", "约翰一书", "约翰二书", "约翰三书", "犹大书", "启示录");
$book_cn=array("", "创", "出", "利", "民", "申", "书", "士", "得", "撒上", "撒下", "王上", "王下", "代上", "代下", "拉", "尼", "斯", "伯", "诗", "箴", "传", "歌", "赛", "耶", "哀", "结", "但", "何", "珥", "摩", "俄", "拿", "弥", "鸿", "哈", "番", "该", "亚", "玛", "太", "可", "路", "约", "徒", "罗", "林前", "林后", "加", "弗", "腓", "西", "帖前", "帖后", "提前", "提后", "多", "门", "来", "雅", "彼前", "彼后", "约一", "约二", "约三", "犹", "启");
$book_taiwan=array("", "創世記", "出埃及記", "利未記", "民數記", "申命記", "約書亞記", "士師記", "路得記", "撒母耳記上", "撒母耳記下", "列王紀上", "列王紀下", "歷代志上", "歷代志下", "以斯拉記", "尼希米記", "以斯帖記", "約伯記", "詩篇", "箴言", "傳道書", "雅歌", "以賽亞書", "耶利米書", "耶利米哀歌", "以西結書", "但以理書", "何西阿書", "約珥書", "阿摩司書", "俄巴底亞書", "約拿書", "彌迦書", "那鴻書", "哈巴谷書", "西番雅書", "哈該書", "撒迦利亞書", "瑪拉基書", "馬太福音", "馬可福音", "路加福音", "約翰福音", "使徒行傳", "羅馬書", "哥林多前書", "哥林多後書", "加拉太書", "以弗所書", "腓立比書", "歌羅西書", "帖撒羅尼迦", "帖撒羅尼迦", "提摩太前書", "提摩太後書", "提多書", "腓利門書", "希伯來書", "雅各書", "彼得前書", "彼得後書", "約翰一書", "約翰二書", "約翰三書", "猶大書", "啟示錄");
$book_tw=array("", "創", "出", "利", "民", "申", "書", "士", "得", "撒上", "撒下", "王上", "王下", "代上", "代下", "拉", "尼", "斯", "伯", "詩", "箴", "傳", "歌", "賽", "耶", "哀", "結", "但", "何", "珥", "摩", "俄", "拿", "彌", "鴻", "哈", "番", "該", "亞", "瑪", "太", "可", "路", "約", "徒", "羅", "林前", "林後", "加", "弗", "腓", "西", "帖前", "帖後", "提前", "提後", "多", "門", "來", "雅", "彼前", "彼後", "約一", "約二", "約三", "猶", "啟");
$book_short_index=array(""=>0, 
"Gen"=>1, "Exod"=>2, "Lev"=>3, "Num"=>4, "Deut"=>5, 
"Josh"=>6, "Judg"=>7, "Ruth"=>8, "1Sam"=>9, "2Sam"=>10, "1Kgs"=>11, "2Kgs"=>12, "1Chr"=>13, "2Chr"=>14, 
"Ezra"=>15, "Neh"=>16, "Esth"=>17, "Job"=>18, "Ps"=>19, "Prov"=>20, "Eccl"=>21, "Song"=>22, 
"Isa"=>23, "Jer"=>24, "Lam"=>25, "Ezek"=>26, "Dan"=>27, 
"Hos"=>28, "Joel"=>29, "Amos"=>30, "Obad"=>31, "Jonah"=>32, "Mic"=>33, "Nah"=>34, "Hab"=>35, "Zeph"=>36, "Hag"=>37, "Zech"=>38, "Mal"=>39, 
"Matt"=>40, "Mark"=>41, "Luke"=>42, "John"=>43, "Acts"=>44, 
"Rom"=>45, "1Cor"=>46, "2Cor"=>47, "Gal"=>48, "Eph"=>49, "Phil"=>50, "Col"=>51, "1Thess"=>52, "2Thess"=>53, "1Tim"=>54, "2Tim"=>55, "Titus"=>56, "Phlm"=>57, 
"Heb"=>58, "Jas"=>59, "1Pet"=>60, "2Pet"=>61, "1John"=>62, "2John"=>63, "3John"=>64, "Jude"=>65, "Rev"=>66);
$book_count=array(0, 
50, 40, 27, 36, 34, 
24, 21, 4, 31, 24, 22, 25, 29, 36, 
10, 13, 10, 42, 150, 31, 12, 8, 
66, 52, 5, 48, 12, 
14, 3, 9, 1, 4, 7, 3, 3, 3, 2, 14, 4, 
28, 16, 24, 21, 28, 
16, 16, 13, 6, 6, 4, 4, 5, 3, 6, 4, 3, 1, 
13, 5, 5, 3, 5, 1, 1, 1, 22);
$book_offset=array(0, 
0, 50, 90, 117, 153, 
187, 211, 232, 236, 267, 291, 313, 338, 367, 
403, 413, 426, 436, 478, 628, 659, 671, 
679, 745, 797, 802, 850, 
862, 876, 879, 888, 889, 893, 900, 903, 906, 909, 911, 925, 
929, 957, 973, 997, 1018, 
1046, 1062, 1078, 1091, 1097, 1103, 1107, 1111, 1116, 1119, 1125, 1129, 1132, 
1133, 1146, 1151, 1156, 1159, 1164, 1165, 1166, 1167);

$book_index=array(
"1Ch" => 13,
"1 Chr" => 13,
"1Chr" => 13,
"1 Chronicles" => 13,
"1Co" => 46,
"1 Cor" => 46,
"1Cor" => 46,
"1 Corinthians" => 46,
"1J" => 62,
"1Jn" => 62,
"1Jo" => 62,
"1 John" => 62,
"1John" => 62,
"1K" => 11,
"1Kgs" => 11,
"1Ki" => 11,
"1 Kin" => 11,
"1 Kings" => 11,
"1P" => 60,
"1Pe" => 60,
"1 Pet" => 60,
"1Pet" => 60,
"1 Peter" => 60,
"1S" => 9,
"1Sa" => 9,
"1 Sam" => 9,
"1Sam" => 9,
"1 Samuel" => 9,
"1Th" => 52,
"1 Th" => 52,
"1 Thess" => 52,
"1Thess" => 52,
"1 Thessalonians" => 52,
"1Ti" => 54,
"1 Tim" => 54,
"1Tim" => 54,
"1 Timothy" => 54,
"1Tm" => 54,
"2Ch" => 14,
"2 Chr" => 14,
"2Chr" => 14,
"2 Chronicles" => 14,
"2Co" => 47,
"2 Cor" => 47,
"2Cor" => 47,
"2 Corinthians" => 47,
"2J" => 63,
"2Jn" => 63,
"2Jo" => 63,
"2 John" => 63,
"2John" => 63,
"2K" => 12,
"2Kgs" => 12,
"2Ki" => 12,
"2 Kin" => 12,
"2 Kings" => 12,
"2P" => 61,
"2Pe" => 61,
"2 Pet" => 61,
"2Pet" => 61,
"2 Peter" => 61,
"2S" => 10,
"2Sa" => 10,
"2 Sam" => 10,
"2Sam" => 10,
"2 Samuel" => 10,
"2Th" => 53,
"2 Th" => 53,
"2 Thess" => 53,
"2Thess" => 53,
"2 Thessalonians" => 53,
"2Ti" => 55,
"2 Tim" => 55,
"2Tim" => 55,
"2 Timothy" => 55,
"2Tm" => 55,
"3J" => 64,
"3Jn" => 64,
"3Jo" => 64,
"3 John" => 64,
"3John" => 64,
"Ac" => 44,
"Act" => 44,
"Acts" => 44,
"Am" => 30,
"Amo" => 30,
"Amos" => 30,
"Cs" => 51,
"Col" => 51,
"Colossians" => 51,
"Da" => 27,
"Dan" => 27,
"Daniel" => 27,
"De" => 5,
"Deu" => 5,
"Deut" => 5,
"Deuteronomy" => 5,
"Dn" => 27,
"Dt" => 5,
"Ec" => 21,
"Ecc" => 21,
"Eccl" => 21,
"Ecclesiastes" => 21,
"Ep" => 49,
"Eph" => 49,
"Ephesians" => 49,
"Es" => 17,
"Est" => 17,
"Esth" => 17,
"Esther" => 17,
"Ex" => 2,
"Exo" => 2,
"Exod" => 2,
"Exodus" => 2,
"Eze" => 26,
"Ezek" => 26,
"Ezekiel" => 26,
"Ezr" => 15,
"Ezra" => 15,
"Ga" => 48,
"Gal" => 48,
"Galatians" => 48,
"Ge" => 1,
"Gen" => 1,
"Genesis" => 1,
"Gn" => 1,
"Hab" => 35,
"Habakkuk" => 35,
"Hag" => 37,
"Haggai" => 37,
"Hb" => 58,
"Heb" => 58,
"Hebrews" => 58,
"Hg" => 37,
"Ho" => 28,
"Hos" => 28,
"Hosea" => 28,
"Hs" => 28,
"Is" => 23,
"Isa" => 23,
"Isaiah" => 23,
"Jam" => 59,
"James" => 59,
"Jas" => 59,
"Jb" => 18,
"Jd" => 65,
"Jdg" => 7,
"Jer" => 24,
"Jeremiah" => 24,
"Jg" => 7,
"Jl" => 29,
"Jm" => 59,
"Jn" => 43,
"Jnh" => 32,
"Job" => 18,
"Joe" => 29,
"Joel" => 29,
"Joh" => 43,
"John" => 43,
"Jon" => 32,
"Jonah" => 32,
"Jos" => 6,
"Josh" => 6,
"Joshua" => 6,
"Jr" => 24,
"Jud" => 65,
"Jude" => 65,
"Judg" => 7,
"Judges" => 7,
"La" => 25,
"Lam" => 25,
"Lamentations" => 25,
"Le" => 3,
"Lev" => 3,
"Leviticus" => 3,
"Lk" => 42,
"Lm" => 25,
"Lu" => 42,
"Luk" => 42,
"Luke" => 42,
"Lv" => 3,
"Mal" => 39,
"Malachi" => 39,
"Mar" => 41,
"Mark" => 41,
"Mat" => 40,
"Matt" => 40,
"Matthew" => 40,
"Mi" => 33,
"Mic" => 33,
"Micah" => 33,
"Mk" => 41,
"Mr" => 41,
"Mt" => 40,
"Na" => 34,
"Nah" => 34,
"Nahum" => 34,
"Ne" => 16,
"Neh" => 16,
"Nehemiah" => 16,
"Nm" => 4,
"No" => 4,
"Nu" => 4,
"Num" => 4,
"Numbers" => 4,
"Ob" => 31,
"Oba" => 31,
"Obad" => 31,
"Obadiah" => 31,
"Phi" => 50,
"Phil" => 50,
"Philem" => 57,
"Philemon" => 57,
"Philippians" => 50,
"Phlm" => 57,
"Phm" => 57,
"Php" => 50,
"Pm" => 57,
"Pp" => 50,
"Pr" => 20,
"Pro" => 20,
"Prov" => 20,
"Proverbs" => 20,
"Ps" => 19,
"Psa" => 19,
"Psalm" => 19,
"Psalms" => 19,
"Re" => 66,
"Rev" => 66,
"Rev" => 66,
"Revelation" => 66,
"Ro" => 45,
"Rom" => 45,
"Romans" => 45,
"Rm" => 45,
"Rt" => 8,
"Ru" => 8,
"Rut" => 8,
"Ruth" => 8,
"Rv" => 66,
"Sg" => 22,
"So" => 22,
"Son" => 22,
"Song" => 22,
"Song of Solomon" => 22,
"Song of Songs" => 22,
"SS" => 22,
"Tit" => 56,
"Titus" => 56,
"Tt" => 56,
"Zc" => 38,
"Zec" => 38,
"Zech" => 38,
"Zechariah" => 38,
"Zep" => 36,
"Zeph" => 36,
"Zephaniah" => 36,
"Zp" => 36,
"书" => 6,
"亚" => 38,
"亞" => 38,
"代上" => 13,
"代下" => 14,
"以弗所书" => 49,
"以弗所書" => 49,
"以斯帖記" => 17,
"以斯帖记" => 17,
"以斯拉記" => 15,
"以斯拉记" => 15,
"以西結書" => 26,
"以西结书" => 26,
"以賽亞書" => 23,
"以赛亚书" => 23,
"传" => 21,
"传道书" => 21,
"伯" => 18,
"但" => 27,
"但以理书" => 27,
"但以理書" => 27,
"何" => 28,
"何西阿书" => 28,
"何西阿書" => 28,
"使徒行传" => 44,
"使徒行傳" => 44,
"來" => 58,
"俄" => 31,
"俄巴底亚书" => 31,
"俄巴底亞書" => 31,
"傳" => 21,
"傳道書" => 21,
"出" => 2,
"出埃及記" => 2,
"出埃及记" => 2,
"列王紀上" => 11,
"列王紀下" => 12,
"列王纪上" => 11,
"列王纪下" => 12,
"创" => 1,
"创世记" => 1,
"利" => 3,
"利未記" => 3,
"利未记" => 3,
"創" => 1,
"創世記" => 1,
"加" => 48,
"加拉太书" => 48,
"加拉太書" => 48,
"历代志上" => 13,
"历代志下" => 14,
"可" => 41,
"启" => 66,
"启示录" => 66,
"哀" => 25,
"哈" => 35,
"哈巴谷书" => 35,
"哈巴谷書" => 35,
"哈該書" => 37,
"哈该书" => 37,
"哥林多前书" => 46,
"哥林多前書" => 46,
"哥林多后书" => 47,
"哥林多後書" => 47,
"啟" => 66,
"啟示錄" => 66,
"士" => 7,
"士师记" => 7,
"士師記" => 7,
"多" => 56,
"太" => 40,
"尼" => 16,
"尼希米記" => 16,
"尼希米记" => 16,
"希伯來書" => 58,
"希伯来书" => 58,
"帖前" => 52,
"帖后" => 53,
"帖後" => 53,
"帖撒罗尼迦" => 52,
"帖撒罗尼迦" => 53,
"帖撒羅尼迦" => 52,
"帖撒羅尼迦" => 53,
"弗" => 49,
"弥" => 33,
"弥迦书" => 33,
"彌" => 33,
"彌迦書" => 33,
"彼前" => 60,
"彼后" => 61,
"彼後" => 61,
"彼得前书" => 60,
"彼得前書" => 60,
"彼得后书" => 61,
"彼得後書" => 61,
"徒" => 44,
"得" => 8,
"拉" => 15,
"拿" => 32,
"提前" => 54,
"提后" => 55,
"提多书" => 56,
"提多書" => 56,
"提後" => 55,
"提摩太前书" => 54,
"提摩太前書" => 54,
"提摩太后书" => 55,
"提摩太後書" => 55,
"摩" => 30,
"撒上" => 9,
"撒下" => 10,
"撒母耳記上" => 9,
"撒母耳記下" => 10,
"撒母耳记上" => 9,
"撒母耳记下" => 10,
"撒迦利亚书" => 38,
"撒迦利亞書" => 38,
"斯" => 17,
"書" => 6,
"来" => 58,
"林前" => 46,
"林后" => 47,
"林後" => 47,
"歌" => 22,
"歌罗西书" => 51,
"歌羅西書" => 51,
"歷代志上" => 13,
"歷代志下" => 14,
"民" => 4,
"民数记" => 4,
"民數記" => 4,
"犹" => 65,
"犹大书" => 65,
"猶" => 65,
"猶大書" => 65,
"王上" => 11,
"王下" => 12,
"玛" => 39,
"玛拉基书" => 39,
"珥" => 29,
"瑪" => 39,
"瑪拉基書" => 39,
"申" => 5,
"申命記" => 5,
"申命记" => 5,
"番" => 36,
"箴" => 20,
"箴言" => 20,
"約" => 43,
"約一" => 62,
"約壹" => 62,
"約三" => 64,
"約叁" => 64,
"約二" => 63,
"約貳" => 63,
"約伯記" => 18,
"約拿書" => 32,
"約書亞記" => 6,
"約珥書" => 29,
"約翰一書" => 62,
"約翰壹書" => 62,
"約翰三書" => 64,
"約翰叁書" => 64,
"約翰二書" => 63,
"約翰貳書" => 63,
"約翰福音" => 43,
"結" => 26,
"约" => 43,
"约一" => 62,
"约壹" => 62,
"约三" => 64,
"约叁" => 64,
"约书亚记" => 6,
"约二" => 63,
"约贰" => 63,
"约伯记" => 18,
"约拿书" => 32,
"约珥书" => 29,
"约翰一书" => 62,
"约翰壹书" => 62,
"约翰三书" => 64,
"约翰叁书" => 64,
"约翰二书" => 63,
"约翰贰书" => 63,
"约翰福音" => 43,
"结" => 26,
"罗" => 45,
"罗马书" => 45,
"羅" => 45,
"羅馬書" => 45,
"耶" => 24,
"耶利米书" => 24,
"耶利米哀歌" => 25,
"耶利米書" => 24,
"腓" => 50,
"腓利門書" => 57,
"腓利门书" => 57,
"腓立比书" => 50,
"腓立比書" => 50,
"西" => 51,
"西番雅书" => 36,
"西番雅書" => 36,
"詩" => 19,
"詩篇" => 19,
"該" => 37,
"诗" => 19,
"诗篇" => 19,
"该" => 37,
"賽" => 23,
"赛" => 23,
"路" => 42,
"路加福音" => 42,
"路得記" => 8,
"路得记" => 8,
"那鴻書" => 34,
"那鸿书" => 34,
"門" => 57,
"门" => 57,
"阿摩司书" => 30,
"阿摩司書" => 30,
"雅" => 59,
"雅各书" => 59,
"雅各書" => 59,
"雅歌" => 22,
"馬可福音" => 41,
"馬太福音" => 40,
"马可福音" => 41,
"马太福音" => 40,
"鴻" => 34,
"鸿" => 34
);
krsort($book_index); //reversely sort by keys
$books=$_REQUEST['b'];
$options=$_REQUEST['o'];
list($book,$book2) = explode("-", $books);
//$range = $_REQUEST['r'];
$name = $_REQUEST['n'];
$portable=$_REQUEST['p'];
$portable=1;
//$query=trim($_REQUEST['q']);
$query=$q;

/*
if(preg_match('/index/i',$query))
{
	$query = ""; 
}
*/
//replace chinese space, semi-comma, comma into english version
$search=array('　','：','，','.','—','－','–','；','／','？');
$replace=array(' ',':',',',':','-','-','-',';','/','?');
$query=str_replace($search,$replace,$query);
preg_match("/@(.+)/", $query, $query_book_array);
//print_r($query_option_array);
$query_books=$query_book_array[1];
//ltrim($query_options, "@");
$query=preg_replace("/@.+/","",$query);
//preg_match("/\/([a-zA-Z0-9]*)/", $query, $query_option_array);
preg_match_all("/\/([a-zA-Z0-9]+)/", $query, $query_option_array);
//return print_r($query_option_array,true);
//$query=preg_replace("/\/[a-zA-Z0-9]*/","",$query);
$query=preg_replace("/\/[a-zA-Z0-9]+/","",$query);
if($query_books)
{
	//echo $query_options;
	if(strstr($query_books,"-"))
		list($query_book,$query_book2)=explode("-",$query_books);
	else
		$query_book=$query_books;
	//echo $query_option . " " . $query_option2;
	if((int)$query_book)
		$book=(int)$query_book;
	elseif($book_index[$query_book])
		$book=$book_index[$query_book];
	//echo $book_index[$query_option];
	//echo "Book=$book";
	if((int)$query_book)
		$book2=(int)$query_book2;
	else if($book_index[$query_book2])
		$book2=$book_index[$query_book2];
	//echo "Book2=$book2";
}	

$queries=explode(" ",$query);
//$queries=explode(" ",$query);
$multi_verse=$_REQUEST['m'];
if(!$multi_verse)
	$multi_verse=0;
$extend=isset($_REQUEST['e'])?(int)$_REQUEST['e']:2;
$extend=0;
$search_table = 'bible_search';
$language = strtolower($_REQUEST['l']); //cn, tw, en

$wiki= $_REQUEST['w'];
$wiki= 0;
$api = $_REQUEST['api'];
$script =  $_SERVER['PHP_SELF'];
$script = "index.php";

/*
$cuvs=$_REQUEST['cuvs'];
$cuvt=$_REQUEST['cuvt'];
$cuvc=$_REQUEST['cuvc'];
$ncvs=$_REQUEST['ncvs'];
$pinyin=$_REQUEST['pinyin'];
$lcvs=$_REQUEST['lcvs'];
$ccsb=$_REQUEST['ccsb'];
$clbs=$_REQUEST['clbs'];
$kjv=$_REQUEST['kjv'];
$nasb=$_REQUEST['nasb'];
$ukjv=$_REQUEST['ukjv'];
$kjv1611=$_REQUEST['kjv1611'];
$bbe=$_REQUEST['bbe'];
$tr=$_REQUEST['tr'];
$wlc=$_REQUEST['wlc'];
$ckjvs=$_REQUEST['ckjvs'];
$ckjvt=$_REQUEST['ckjvt'];
*/
$cuvs=isset($_REQUEST['cuvs'])?"cuvs":"";
$cuvt=isset($_REQUEST['cuvt'])?"cuvt":"";
$cuvc=isset($_REQUEST['cuvc'])?"cuvc":"";
$ncvs=isset($_REQUEST['ncvs'])?"ncvs":"";
$pinyin=isset($_REQUEST['pinyin'])?"pinyin":"";
$lcvs=isset($_REQUEST['lcvs'])?"lcvs":"";
$ccsb=isset($_REQUEST['ccsb'])?"ccsb":"";
$clbs=isset($_REQUEST['clbs'])?"clbs":"";
$kjv=isset($_REQUEST['kjv'])?"kjv":"";
$nasb=isset($_REQUEST['nasb'])?"nasb":"";
$esv=isset($_REQUEST['esv'])?"esv":"";
$ukjv=isset($_REQUEST['ukjv'])?"ukjv":"";
$kjv1611=isset($_REQUEST['kjv1611'])?"kjv1611":"";
$bbe=isset($_REQUEST['bbe'])?"bbe":"";
$tr=isset($_REQUEST['tr'])?"tr":"";
$wlc=isset($_REQUEST['wlc'])?"wlc":"";
$ckjvs=isset($_REQUEST['ckjvs'])?"ckjvs":"";
$ckjvt=isset($_REQUEST['ckjvt'])?"ckjvt":"";
$cn=isset($_REQUEST['cn'])?1:0;
$en=isset($_REQUEST['en'])?1:0;
$tw=isset($_REQUEST['tw'])?1:0;
$debug=isset($_REQUEST['d'])?1:0;
$strongs=$_REQUEST['strongs'];


foreach ($query_option_array[1] as $query_option)
{
	switch(strtolower($query_option)){
		case "en": 
		case "e": $en=1;break;
		case "cn": 
		case "c": $cn=1;break;
		case "tw": 
		case "t": $tw=1;break;
		case "cuvs": $cuvs="cuvs";break;
		case "cuvc": $cuvc="cuvc";break;
		case "cuvt": $cuvt="cuvt";break;
		case "ncvs": $cuvs="ncvs";break;
		case "pinyin": 
		case "py": 
		case "p": $pinyin="pinyin";break;
		case "lcvs": $lcvs="lcvs";break;
		case "ccsb": $ccsb="ccsb";break;
		case "clbs": $clbs="clbs";break;
		case "kjv": $kjv="kjv";break;
		case "nasb": $nasb="nasb";break;
		case "esv": $esv="esv";break;
		case "ukjv": $ukjv="ukjv";break;
		case "kjv1611": $kjv1611="kjv1611";break;
		case "bbe": $bbe="bbe";break;
		case "tr": $tr="tr";break;
		case "wlc": $wlc="wlc";break;
		case "ckjvs": $ckjvs="ckjvs";break;
		case "ckjvt": $ckjvt="ckjvt";break;
		case "m": $multi_verse=1;break;
		case "e1": $extend=1;break;
		case "e2": $extend=2;break;
		case "e3": $extend=3;break;
		case "s": $strongs=1;break;
		case "d": $debug=1;break;
		case "h":case "?":case "？":case "help":case "帮助":case "幫助": $help=1;break;
	}
	
}

if($strongs && !($cuvs || $cuvt || $kjv || $nasb)) $cuvs = "cuvs";
	
if($help)
{
	return show_help();
}

/*
if(!$language)  
	$language="cn";
*/

if(!($cn || $en || $tw))
{
	$cn=1;
	//$pinyin="pinyin";
}

/*
if($en)
	$nasb="nasb";
*/
$bible_books=array($cuvs,$cuvt,$kjv,$esv,$nasb,$ncvs,$cuvc,$lcvs,$pinyin,$ccsb,$ckjvs,$ckjvt,$clbs,$ukjv,$kjv1611,$bbe);


//echo "book=" . $book . " chapter=" . $chapter . " chapter2="  . $chapter2 . " verse=" . $verse . " verse2=" .$verse2;


require_once("config.php");
require_once('dbconfig.php');
//print_r($book_index);
$max_record_count=10;
//$init=false;
if(!$mode && !$book && !$query && !$wiki)
{ 
	if(!$name){
		$name = "John";
		$chapter=3;
		$verse=16;
	}
	//echo "name=$name";
	
	//echo "book=$book";
	$mode = "READ";
}
if(!$query && $mode=="READ")
{
	$book =$book_index[$name];
	if($book<=0 || $book > 66)
		$book=43;	
}


if(!$wiki && (!$chapter || $chapter < 1))
	$chapter = 1;
if($chapter>$book_count[$book])
	$chapter=$book_count[$book];
if(!$verse) $verse=1;	


$db = mysql_connect($dbhost.":".$dbport, $dbuser, $dbpassword) or die("Connection Error: " . mysql_error());
mysql_select_db($database,$db) or die("Error conecting to db.");
mysql_query("SET NAMES utf8", $db);
$do_query = true;
//to search bible
$querystr="";
$sql="";
$count=0;
if($query)
{ //search

	//echo $query . "<br/>\n";
	$pattern="/[0-9]/";
	//$pattern="/\:/"; //use semicomma instead of digit in distinguage between reference or search
	//query string is verse indeces
	if(preg_match($pattern, $query))
	{
		//echo $query . "<br/>\n";
		$query=str_replace(" ","",$query);
		$segments=explode(";",strtolower($query));
		foreach($segments as $segment){
			//$segment=trim($segment);
			$book_number = 0;
			$sql_where ="";
			$found=false;
			foreach($book_index as $book_name => $ii)
			{
				//$pos=stripos($segment,$book_name);
				//$book_name=ltrim($book_name);
				$pattern="/^$book_name ?[0-9]+/i";
				if(preg_match($pattern,$segment))
				//if($pos !== false)
				{
					$found=true;
					//echo $book_name;
					$book=$ii;
					$sql_where = " (book = $ii) ";
					$references = str_replace(" ","",substr($segment, strlen($book_name)));
					//echo $references;
					list($reference1, $reference2) = explode("-", $references);
					list($r1,$r2)=explode(":",$reference1);
					list($r3,$r4)=explode(":",$reference2);
					list($ir1,$ir2,$ir3,$ir4)=array((int)($r1),(int)($r2),(int)($r3),(int)($r4));
					//echo "r1=$r1, r2=$r2, r3=$r3, r4=$r4<br/>\n";
					//echo "ir1=$ir1, ir2=$ir2, ir3=$ir3, ir4=$ir4";
					if(!$reference2)
					{
						//$chapter=$r1;
						if($ir1){
						
							$sql_where .= " AND (chapter=$ir1) ";
							$chapter=$ir1;
						}else
							$echo_string="章节格式错误，可能章号不正确，正确格式参考： John 3";
						if($r2) //only one whole chapter
						{ 
						
								//$verse = $r1;
					
								$verses_temp = explode(",",$r2);
								if((int)$verses_temp[0])
								{
									$verse=$verse2=$verses_temp[0];

									//$sql_where .= " AND ((verse=" . (int)$verses_temp[0] .  " )";
									$sql_where .= " AND (verse BETWEEN (" . (int)$verses_temp[0] .  " - $extend) AND ("  . (int)$verses_temp[0] . " + $extend)";
									$index_temp=count($verses_temp);
									for($iii=1;$iii<$index_temp;$iii++)
									{
										//$sql_where .= " OR (verse=" . (int)$verses_temp[$iii] . ") ";
										$sql_where .= " OR verse BETWEEN (" . (int)$verses_temp[$iii] . " - $extend) AND ("  . (int)$verses_temp[$iii] . " + $extend) ";
										$verse=$verse2=$verses_temp[$iii];

									}
									$sql_where .= ") ";
								}
								else
									$echo_string="章节格式错误，可能节号不正确，正确格式参考： John 3:16或者 John 3:16,19";
							/*			
							//$verse = $r1;
							if($ir2)
								$sql_where .= " AND (verse=$ir2)";
							else
								$echo_string="章节格式错误，可能节号不正确，正确格式参考： John 3:16";
							//echo $sql_where;
							*/
						}
					}else{ //$reference2 is not null
						if(!$r2 && !$r4){  // John 1-3
							if($ir1 && $ir3){
								$sql_where .= " AND (chapter BETWEEN $ir1 AND $ir3)";
								$chapter=$ir1;
							}else 
								$echo_string="章节格式错误，可能章号不正确，正确格式参考： John 3-4";

						}elseif($r2 && !$r4){ //John 3:16-18
							/*	
							if(($ir1) && ($ir2) && ($ir3))
								$sql_where .= " AND (chapter = $ir1) AND ( verse  BETWEEN $ir2 AND $ir3)";							
							else
								$echo_string="章节格式错误，可能章号或者节号不正确，正确格式参考：John 3:16-18";
							*/
								//with references, only one chapter $ir1
								//John 3:16-18,20    or Johen 3:16-18,19-21
								
							list($chapter_temp,$verse_string_temp)=explode(":",$references);
							$verse_array_temp = explode(",",$verse_string_temp);
							if(count($verse_array_temp)>0)
							{
								$sql_where .= "AND (chapter = " . (int)$chapter_temp . ") AND ( (1 = 0) ";
								$chapter=$chapter_temp;
								foreach ($verse_array_temp as $verse_temp)
								{
									list($verse1_temp,$verse2_temp)=explode("-",$verse_temp);
									$verse=$verse1_temp;
									$verse2=$verse2_temp;
									if((int)$verse2_temp)
									{
										$sql_where .= " OR (verse BETWEEN " . (int)$verse1_temp . " AND  " . (int)$verse2_temp . ") ";
									}else{
										$sql_where .= " OR (verse = " . (int)$verse1_temp . ") ";
									}
								}
								$sql_where .= ") ";
							}else{
							
								$echo_string="章节格式错误，可能章号或者节号不正确，正确格式参考：John 3:16-18 或 John 3:16-18,19-21 或 John 3:16-18,20";
							//echo "HELLOHELLO " . 	$sql_where;
							}

						}elseif(!$r2){
							if(($ir3) && ($ir4))
							{//John 3-5:6
								$irr=0 + $ir3 - 1;
								$sql_where .= " AND ( (chapter BETWEEN $ir1 AND $irr) OR ( (chapter = $ir3) AND (verse BETWEEN 1 AND $ir4)))";
								$chapter=$ir1;
								$verse=1;
								$verse2=$ir4;
							}
							else
								$echo_string="章节格式错误，可能章号不正确，正确格式参考：John 3-5:6";

						}
					}
					//$break=true;
					break;//break foreach book_index
				}//if preg_match	
				//if($break)
				//	break;
			} //foreach book_index
			if(!$found)
				$echo_string="未找到书卷名称";			
			if($sql_where && !$echo_string)
			{
				$count=0;
				//$echo_string=""; //ignore minor errors
				$sql= "SELECT book, chapter, verse FROM bible_books WHERE $sql_where";
				$result = mysql_query($sql) or die(" $sql Could not execute query." . mysql_error());
				//$result = $db->getData( $sql );

				while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
					$count++;
					$bid = $row[book];
					$cid = $row[chapter];
					$vid = $row[verse];
					$querystr .=  $bid . ":" . $cid . ":" . $vid . ",";
					if($count>5000)
					{
						$echo_string="索引经文章节超过 5000 条，请缩小范围后重新索引";
						//$querystr ="";
						break;
					}
				}
				$mode='INDEX';
			}
			
		}//foreach segment			

	
			

		$querystr = rtrim($querystr,",");
		$index=$querystr;
//					echo $querystr;
			
		$do_query=false;
		$mode='INDEX';
	}else{
	//search
        $mode='QUERY';
		
		$count = count($queries);

		if($count > 10){
			$echo_string ="至多10个关键词，请缩小关键词的数量以降低服务器的开销。";
			$do_query =false;
		}

		if($multi_verse)
			$search_table = 'bible_multi_search';
		else
			$search_table = 'bible_search';
		
		
		//echo "range=" . $range . "\n";
		//echo "book=" . $book;
		$sql_where = "";

		if($book2)
				$sql_where =  " book BETWEEN $book AND $book2 ";
		elseif($book)
			$sql_where = " book = $book";
		else
			$sql_where = " 1=1 ";			


		if($do_query)
		{	
			//print_r($queries);
			$sql="select book,chapter,verse from $search_table WHERE txt LIKE '%" . $queries[0] . "%'";
			for($i=1; $i < $count; ++$i)
			{
				$sql = $sql . " AND txt LIKE '%" . $queries[$i] . "%' ";
			}
			if($sql_where)
				$sql = $sql . " AND (" . $sql_where . " ) ";
				
			//echo $sql;

			$result = mysql_query( $sql ) or die(" $sql Could not execute query.".mysql_error());
			//$result = $db->getData( $sql );

			$i=0;
			$count=0;
			if(!$result){
				return("-3 No query result");
				exit(-3);
			}	
				
			$querystr = "";
			$querystrtext = "";
			while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			//foreach($result as $row){
				$bid = $row[book];
				$cid = $row[chapter];
				$vid = $row[verse];
				$querystr = $querystr . $bid . ":" . $cid . ":" . $vid . ",";
				if($language == "tw")
					$querystrtext= $querystrtext . $book_tw[$bid] . ":" . $cid . ":" . $vid . ",";
				elseif($language == "en")
					$querystrtext= $querystrtext . $book_en[$bid] . ":" . $cid . ":" . $vid . ",";
				else
					$querystrtext= $querystrtext . $book_cn[$bid] . ":" . $cid . ":" . $vid . ",";
				// $response->verses[$i]['book'] = $bid;
				// $response->verses[$i]['chapter'] = $cid;
				// $response->verses[$i]['verse'] = $vid;
				$response[$i]= array($bid,$cid,$vid);
				if($language == "tw")
					$responsetext[$i] = array($book_tw[$bid],$cid,$vid);
				elseif($language == "en")
					$responsetext[$i] = array($book_en[$bid],$cid,$vid);
				else
					$responsetext[$i] = array($book_cn[$bid],$cid,$vid);
				//echo $query;
				$i++;
				$count=$i;
				if($i >= $max_record_count){
					$echo_string .= "结果超出 $max_record_count 条记录，请增加关键词或者设定查询范围来准确查询";
					break;
				}
				
			}
			$querystr = rtrim($querystr,",");
			//$search = $querystr;
			if($querystr){ //there are result
				$index = $querystr;
				//$echo_string .="共查到 $count 条记录：\n";
			}else{
				$index = '';
				$echo_string .= "没有查到记录，请修改搜索条件重新搜索，可查询书卷章节也可查询多关键词，空格分隔";
			}
			
		}
	}
}	




//echo $index;
//echo $querystr;

$count = 0;

$english_title = $book_chinese[$book]  . " " . $book_enlish[$book];
$short_url_title = $short_url_base . "/" . $book_short[$book];
if($chapter)
{
	$english_title .= " " . $chapter;
	$short_url_title .=  "." . $chapter;
}
if($verse)
{
	$english_title = $english_title . ":$verse";
	$short_url_title .= "." . $verse;
	$show_verse = true;
}else
	$show_verse = false;




if($index)
{
		$sql = "SELECT bible_books.* ";
		
		$book_count = 0;
		foreach ($bible_books as $bible_book) {
			if($bible_book)
			{
				$sql .= ", $bible_book.Scripture as text_$bible_book ";
				$book_count ++;
				if($book_count > $max_book_count){
						$echo_string .= "\n选择查询的圣经译本超出 $max_book_count 个，请缩减同时查询的译本个数以降低服务器开销\n";
						break;
				}
			}
		}
		
		$sql .= " FROM bible_books ";
		
		foreach ($bible_books as $bible_book) {
			if($bible_book)
				$sql .= ", bible_book_$bible_book as $bible_book";
		}
			
		$sql .= " WHERE (1=1 "; 
		
		foreach ($bible_books as $bible_book) {
			if($bible_book)
				$sql .= " AND (bible_books.book=$bible_book.book AND bible_books.chapter=$bible_book.chapter AND bible_books.verse=$bible_book.verse) ";
		}

		$sql .= " ) AND ( 1=0 "; 
		
		$verses=explode(",",$index);
		$verse_count = count($verses);
		for($i=0; $i< $verse_count; $i++)
		{
			list($verse_book,$verse_chapter,$verse_verse)=explode(":",$verses[$i]);
			//echo $verse_book . "," . $verse_chapter . "," . $verse_verse . "\n";
			$sql = $sql . " OR (bible_books.book=$verse_book AND bible_books.chapter=$verse_chapter AND bible_books.verse=$verse_verse)";
		}
		$sql .= " ) "; 
		
}else{ //not index but search
	if($mode=='QUERY' || $mode=='READ')
	{
		$sql = "SELECT bible_books.* ";

		foreach ($bible_books as $bible_book) {
			if($bible_book)
				$sql .= ", $bible_book.Scripture as text_$bible_book ";
		}
		
		$sql .= " FROM bible_books";
		
		foreach ($bible_books as $bible_book) {
			if($bible_book)
				$sql .= ", bible_book_$bible_book as $bible_book ";
		}
			
		$sql .= " WHERE 1=1 "; 
		
		foreach ($bible_books as $bible_book) {
			if($bible_book)
				$sql .= " AND (bible_books.book=$bible_book.book AND bible_books.chapter=$bible_book.chapter AND bible_books.verse=$bible_book.verse) ";
		}
	}
	if($chapter)
	{
		//$sql = "SELECT * FROM bible_books WHERE  book = $book AND chapter=$chapter";
		$sql .= " AND  bible_books.book = $book AND bible_books.chapter=$chapter";
		if($verse)
			if($verse2)
				$sql = $sql . " AND bible_books.verse >= $verse AND bible_books.verse <=$verse2";
			else
				$sql = $sql . " AND bible_books.verse >= $verse - 3 AND bible_books.verse <=$verse + 3";
		
	}
}
if(!$index)
		$sql = $sql . " ORDER BY bible_books.book,bible_books.chapter,bible_books.verse";
	//echo "book=$book<br/>\n";
	//echo $sql;
	//exit;
if($index || !$echo_string)
{	
	$result = mysql_query( $sql ) or die(" $sql Could not execute query.".mysql_error());
	//$result = $db->getData( $sql );

	//echo $result;
	//$line=0;
	// $text_cmp = "<div id=words>";
	// $text_tw = "<div id=words>";
	// $text_cn = "<div id=words>";
	// $text_en = "<div id=words>";
	if(!$index)
	{
		$text_tw = $txt_tw . "<b>" . $book_taiwan[$book] . " (" . $book_tw[$book] . ") " . $chapter . "</b>\n";
		$text_cn = $txt_cn . "<b>" . $book_chinese[$book] . " (" . $book_cn[$book] . ") " . $chapter . "</b>\n";
		$text_en = $txt_en . "<b>" . $book_english[$book] . " (" . $book_en[$book] . ") " . $chapter . "</b>\n";
		//$text_py = $txt_py . "<b>" . $book_english[$book] . " (" . $book_en[$book] . ") " . $chapter . "</b>\n";
	}
    $wiki_text = "<p>&nbsp;</p> ==" . $book_chinese[$book] . " " . $chapter . "目录==<p>&nbsp;</p>\n";
	$verse_number = 0;
	//$text_cmp .= "<table border=0>";
	while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
	//foreach($result as $row){
		$bid=$row['book'];
		$cid=$row['chapter'];
		$vid = $row['verse'];
		$likes=$row['likes'];
		$txt_tw = $row['txt_tw'];
		$txt_cn = $row['txt_cn'];
		$txt_en = $row['txt_en'];
		foreach ($queries as $query_word){
			/*
			$pattern = "/($query_word)/";
			$replacement = "<strong>${1}</strong>";
			$txt_tw= preg_replace($pattern, $replacement, $txt_tw);
			$txt_cn= preg_replace($pattern, $replacement, $txt_cn);
			$txt_en= preg_replace($pattern, $replacement, $txt_en);
			*/
			/*
			$txt_tw= str_replace($query_word, "<strong>" . $query_word . "</strong>", $txt_tw);
			$txt_cn= str_replace($query_word, "<strong>" . $query_word . "</strong>", $txt_cn);
			$txt_en= str_ireplace($query_word, "<strong>" . $query_word . "</strong>", $txt_en);
			*/
		}
		//$txt_py = $row['txt_py'];
		if(false && $vid == $verse && ($mode=='READ' || $mode=='INDEX'))
		{
			$txt_tw = "<strong>" . $txt_tw . "</strong>";
			$txt_cn = "<strong>" . $txt_cn . "</strong>";
			$txt_en = "<strong>" . $txt_en . "</strong>";
			$txt_py = "<strong>" . $txt_py . "</strong>";
		}
//		$book_short = $row['short'];
		$osis_cn = $book_cn[$bid] . " " . $cid;
		$osis=$book_short[$bid] . "." . $cid;
		if($vid){
			$osis = $osis . "." . $vid;
			$osis_cn = $osis_cn . ":" .$vid;
		}
		/*
		
		need further work
		*/
		if($portable)
		{
			$text_tw = $text_tw . $book_tw[$bid] . " " . $cid . ":" . $vid . " " .  $txt_tw . "\n\n"; 
			$text_cn = $text_cn . $book_cn[$bid] . " " .$cid . ":" . $vid . " " .  $txt_cn . "\n\n";
			$text_en = $text_en . $book_short[$bid] . " " . $cid . ":" . $vid . " " .  $txt_en . "\n\n";
			//$text_py = $text_py . " <sup>" . $book_short[$bid] . " " . $cid . ":" . $vid . "</sup> " .  $txt_py . "\n";
		
		}else if($short_url_base)
		{
			$text_tw = $text_tw . " <sup><a href=\"$short_url_base/" . $osis . ".htm\">" . $book_tw[$bid] . " " . $cid . ":" . $vid . "</a></sup> " .  $txt_tw . "\n"; 
			$text_cn = $text_cn . " <sup><a href=\"$short_url_base/" . $osis . ".htm\">" . $book_cn[$bid] . " " .$cid . ":" . $vid . "</a></sup> " .  $txt_cn . "\n";
			$text_en = $text_en . " <sup><a href=\"$short_url_base/" . $osis . ".htm\">" . $book_short[$bid] . " " . $cid . ":" . $vid . "</a></sup> " .  $txt_en . "\n";
			//$text_py = $text_py . " <sup><a href=\"Bible." . $osis . "\">" . $book_short[$bid] . " " . $cid . ":" . $vid . "</a></sup> " .  $txt_py . "\n";
		}else{
			$text_tw = $text_tw . " <sup><a href=\"$script?q=" . $book_short[$bid] . " " . $cid . ":" . $vid . "\">" . $book_tw[$bid] . " " . $cid . ":" . $vid . "</a></sup> " .  $txt_tw . "\n"; 
			$text_cn = $text_cn . " <sup><a href=\"$script?q=" . $book_short[$bid] . " " . $cid . ":" . $vid . "\">" . $book_cn[$bid] . " " .$cid . ":" . $vid . "</a></sup> " .  $txt_cn . "\n";
			$text_en = $text_en . " <sup><a href=\"$script?q=" . $book_short[$bid] . " " . $cid . ":" . $vid . "\">" . $book_short[$bid] . " " . $cid . ":" . $vid . "</a></sup> " .  $txt_en . "\n";
			//$text_py = $text_py . " <sup><a href=\"$script?q=" . $book_short[$bid] . " " . $cid . ":" . $vid . "\">" . $book_short[$bid] . " " . $cid . ":" . $vid . "</a></sup> " .  $txt_py . "\n";
		}
		if($verse_number %2)
			$background= " class=light";
		else
			$background= " class=dark";
		//$text_cmp .= "\n";
		
		if($cn){
		
		//$text_cmp = $text_cmp . "\n";
		
		$cv= $book_cn[$bid] . " " . $cid . ":" . $vid;
		if($portable)
		{
			$text_cmp =  $text_cmp . " " . $cv .  " ";
		}
		else if($short_url_base)
		{
			$text_cmp = $text_cmp .  "<sup><a href=\"$short_url_base/" . $osis . ".htm\"";
			$text_cmp = $text_cmp .   " title=\"" .  $book_chinese[$bid] . " " . $cid . ":" . $vid .  "\">";
			$text_cmp = $text_cmp .  $cv .  "</a></sup> ";
		}
		else{
		
			$text_cmp = $text_cmp .  "<sup><a href=\"$script?q=" . $book_short[$bid] . " " . $cid . ":" . $vid . "\"";
			$text_cmp = $text_cmp .   " title=\"" .  $book_chinese[$bid] . " " . $cid . ":" . $vid .  "\">";
			$text_cmp = $text_cmp .  $cv .  "</a></sup> ";
		}

		
		$text_cmp = $text_cmp .  $txt_cn . " ";
	
		$text_cmp = $text_cmp .  "\n";
		}
		if($tw){
			
		//$text_cmp = $text_cmp . "\n";

		$cv= $book_tw[$bid] . " " . $cid . ":" . $vid;
		if($portable)
		{
			$text_cmp =  $text_cmp . " " . $cv .  " ";
		}
		else if($short_url_base)
		{
			$text_cmp = $text_cmp .  "<sup><a href=\"$short_url_base/" . $osis . ".htm\"";
			$text_cmp = $text_cmp .   " title=\"" .  $book_taiwan[$bid] . " " . $cid . ":" . $vid .  "\">";
			$text_cmp = $text_cmp .  $cv .  "</a></sup> ";
		}
		else{
		
			$text_cmp = $text_cmp .  "<sup><a href=\"$script?q=" . $book_short[$bid] . " " . $cid . ":" . $vid . "\"";
			$text_cmp = $text_cmp .   " title=\"" .  $book_taiwan[$bid] . " " . $cid . ":" . $vid .  "\">";
			$text_cmp = $text_cmp .  $cv .  "</a></sup> ";
		}

		
		$text_cmp = $text_cmp .  $txt_tw . " (CUVT)";
	
		$text_cmp = $text_cmp .  "\n";
		}

/*
		//for pinyin
		$text_cmp = $text_cmp . "<p>\n";
		$text_cmp = $text_cmp .  "<sup><a href=\"Bible." . $osis . "\"";
		$text_cmp = $text_cmp .   " title=\"" .  $book_english[$bid] . " " . $cid . ":" . $vid .  "\">";
		$cv= $book_en[$bid] . " " . $cid . ":" . $vid;
		$text_cmp = $text_cmp .  $cv .  "</a></sup> ";
		$text_cmp = $text_cmp .  $txt_py;		
		$text_cmp = $text_cmp .  "</p>\n";
*/		
		
	
		if($en){
		//$text_cmp = $text_cmp . "\n";

		
		$cv= $book_en[$bid] . " " . $cid . ":" . $vid;
		if($portable)
		{
			$text_cmp =  $text_cmp . " " . $cv .  " ";
		}
		else if($short_url_base)
		{
			$text_cmp = $text_cmp .  "<sup><a href=\"$short_url_base/" . $osis . ".htm\"";
			$text_cmp = $text_cmp .   " title=\"" .  $book_english[$bid] . " " . $cid . ":" . $vid .  "\">";
			$text_cmp = $text_cmp .  $cv .  "</a></sup> ";
		}
		else{
		
			$text_cmp = $text_cmp .  "<sup><a href=\"$script?q=" . $book_short[$bid] . " " . $cid . ":" . $vid . "\"";
			$text_cmp = $text_cmp .   " title=\"" .  $book_english[$bid] . " " . $cid . ":" . $vid .  "\">";
			$text_cmp = $text_cmp .  $cv .  "</a></sup> ";
		}

		$text_cmp = $text_cmp .  $txt_en . " (KJV)";		
		$text_cmp = $text_cmp .  "\n";
		
		}
		foreach ($bible_books as $bible_book) {
				if($bible_book)
				{
					$text_string= $row["text_$bible_book"];
					if($bible_book == "cuvs" || $bible_book=="cuvt" || $bible_book == "kjv" || $bible_book == "nasb"){
							$search_str = array('<FR>','<Fr>');
							$replace_str = array('','');
							$text_string  = str_replace($search_str, $replace_str, $text_string);
							if(!$strongs) 
							{
								$pattern = '/<WH(\w+)>/i';
								$replacement = '';
								$text_string= preg_replace($pattern, $replacement, $text_string);
								$pattern = '/<WG(\w+)>/i';
								$replacement = '';
								$text_string= preg_replace($pattern, $replacement, $text_string);
							}else{
								$pattern = '/<WH(\w+)>/i';
								$replacement = '<H${1}>';
								$text_string= preg_replace($pattern, $replacement, $text_string);
								$pattern = '/<WG(\w+)>/i';
								$replacement = '<G${1}>';
								$text_string= preg_replace($pattern, $replacement, $text_string);
								
							}
						
							
						}
					$text_cmp .= "\n" . $text_string . "(" . strtoupper($bible_book) . ")\n";
				}
		}

/*
		$key = "3208dfea819fa015";
//			 $key= "IP";
			  //$passage = urlencode("john 3:16");
			  //$options = "include-passage-references=true&include-passage-horizontal-line=false&include-footnotes=true&include-heading-horizontal-lines=false&include-headings=false&include-subheadings=true&include-surrounding-chapters=false&include-word-ids=true";
		$options = "include-passage-references=false&include-passage-horizontal-line=false&include-footnotes=false&include-heading-horizontal-lines=false&include-headings=false&include-subheadings=false&include-surrounding-chapters=false&include-word-ids=true";			  
			  //$url = "http://www.esvapi.org/v2/rest/passageQuery?key=$key&passage=$passage&$options";
			 $url="http://www.esvapi.org/v2/rest/passageQuery?key=$key&$options&q=" . $book_en[$bid] . "+" . $cid . "+" . $vid; 
			  $ch = curl_init($url); 
			  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			  $response = curl_exec($ch);
			  curl_close($ch);
			 $text_cmp = $text_cmp . "<P>" . $response . "</p>\n";
*/
			
		
		/*
		$text_com = $text_cmp . " <p><small><a href=\"Bible." . $osis . "\"";
		$text_cmp = $text_cmp .   " title=\"" .  $book_english[$bid] . " " . $cid . ":" . $vid .  "\">";
		$text_cmp = $text_cmp .   $book_short[$bid] . " " . $cid . ":" . $vid .  "</a></small>";
		*/
	if(!$portable){
		$quick_link_text = "直达 Quick Link: ";
		$text_cmp = $text_cmp .  "<p>本节研经资料 Bible Study ";
		$text_cmp .= "<select name=\"$osis\" onchange=\"javascript:handleSelect(this)\">\n<option value=\"\">请选择 Please Select</option>\n";
		//$text_cmp = $text_cmp .  " <a href=\"http://www.blueletterbible.org/Bible.cfm?b=" . $book_en[$bid] . "&c=$cid&v=$vid\" target=_blank>BlueLetter</a> | \n";
		$option_url = "http://www.blueletterbible.org/Bible.cfm?b=" . $book_en[$bid] . "&c=$cid&v=$vid";
		$option_name = "Blue Letter Bible";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
		
		//$text_cmp = $text_cmp .  " <a href=\"http://www.yawill.com/modonline.php?book=$bid&chapter=$cid&node=$vid\" target=_blank>多版本对照</a>\n | ";

		$option_url = "http://www.yawill.com/modonline.php?book=$bid&chapter=$cid&node=$vid";
		$option_name = "Yawill.com多版本对照";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
		
		//$text_cmp = $text_cmp .  " <a href=\"http://bible.cc/" . $book_english[$bid] . "/$cid-$vid.htm" . "\" target=_blank>Parallel Bible</a>\n | ";
		//$option_url = "http://bible.cc/" . $book_english[$bid] . "/$cid-$vid.htm";
		//$option_name = "Bible.cc Parallel Bible";
		//$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";

		
		//$text_cmp = $text_cmp .  "<a href=\"http://bible.fhl.net/new/read.php?VERSION1=unv&strongflag=2&TABFLAG=1&chineses=" . $book_tw[$bid] . "&chap=$cid&sec=$vid&VERSION2=kjv\" target=_blank>信望爱原文和词典</a> | \n";
		$option_url = "http://bible.fhl.net/new/read.php?VERSION1=unv&strongflag=2&TABFLAG=1&chineses=" . $book_tw[$bid] . "&chap=$cid&sec=$vid&VERSION2=kjv";
		$option_name = "原文词典";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
		$quick_link_text .= "<a href=$option_url target=_blank>$option_name</a>&nbsp; ";
		
//		$text_cmp = $text_cmp .  "<a href=\"http://jidutu-wiki.org/wiki/圣经:" . $osis_cn . "\" target=_blank>百科网研经</a>\n";
//		$text_cmp = $text_cmp .  "<a href=\"http://jidutu-wiki.org/wiki/Bible:" . $osis . "\" target=_blank>(OSIS)</a>\n";
//		$text_cmp = $text_cmp .  "<a href=\"http://ccwiki.org/wiki/圣经:" . $osis_cn . "\" target=_blank>CCWIKI研经</a>\n";
//		$text_cmp = $text_cmp .  "<a href=\"http://ccwiki.org/wiki/Bible:" . $osis . "\" target=_blank>(OSIS)</a>\n";

		//$text_cmp = $text_cmp .  "<a href=\"/wiki/Bible:" . $osis_cn . "\" target=_blank>圣经百科</a>\n";
		////$text_cmp = $text_cmp .  "<!-- <a href=\"/wiki/Bible:" . $osis . "\" target=_blank>(OSIS)</a> -->| \n";
		$option_url = "$wiki_base/圣经:" . $book_chinese[$bid] . " " . $cid . ":" . $vid; //$osis_cn;
		$option_name = "圣经百科";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
		$quick_link_text .= "<a href=\"$option_url\" target=_blank>$option_name</a>&nbsp; ";
		
		//$text_cmp = $text_cmp .  "<a href=\"/wiki/MHC:" . $book_chinese[$bid] . " " . $cid . "\" target=_blank title=\"亨利马太圣经注释\">MHC</a> <!-- (<a href=\"/wiki/MHC:" . $osis_cn . "\" target=_blank>中</a>\n";
		//$text_cmp = $text_cmp .  "<a href=\"/wiki/MHC:" . $osis . "\" target=_blank>英</a>) -->|\n";
		$option_url = "$wiki_base/MHC:" . $book_chinese[$bid] . " " . $cid;
		$option_name = "圣经注释";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
		$quick_link_text .= "<a href=\"$option_url\" target=_blank>$option_name</a>&nbsp; ";
		
		

		//$text_cmp = $text_cmp .  "<a href=\"/wiki/MHCC:" . $book_chinese[$bid] . " " . $cid  .  "\" target=_blank title=\"亨利马太简明圣经注释\">MHCC</a> <!--(<a href=\"/wiki/MHCC:" . $osis_cn . "\" target=_blank>中</a>\n";
		//$text_cmp = $text_cmp .  "<a href=\"/wiki/MHCC:" . $osis . "\" target=_blank>英</a>) -->|\n";
		$option_url = "$wiki_base/MHCC:" . $book_chinese[$bid] . " " . $cid;
		$option_name = "MHCC 亨利马太简明圣经注释";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";


		//$text_cmp = $text_cmp .  "<a href=\"https://www.51zanmei.net/bibleindex-$bid-$cid\" target=_blank>赞美圣经</a> |\n";
		$option_url = "https://www.51zanmei.net/bibleindex-$bid-$cid.html";
		$option_name = "51zanmei.net 赞美圣经";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
		
		
		//$text_cmp = $text_cmp .  "<a href=\"http://www.almega.com.hk/bible/bible.asp?langid=1&BibleID=NCB&Site=wbs&BCVNo=". sprintf("%d%03d%03d", $bid, $cid, $vid) . "\" target=_blank>新译本</a>\n";
		$option_url = "http://www.almega.com.hk/bible/bible.asp?langid=1&BibleID=NCB&Site=wbs&BCVNo=". sprintf("%d%03d%03d", $bid, $cid, $vid);
		$option_name = "Chinese New Version 简体新译本";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
		
		//$text_cmp = $text_cmp .  "<a href=\"http://www.almega.com.hk/bible/bible.asp?langid=0&BibleID=NCB&Site=wbs&BCVNo=". sprintf("%d%03d%03d", $bid, $cid, $vid) . "\" target=_blank>(正體)</a>\n | ";
		$option_url = "http://www.almega.com.hk/bible/bible.asp?langid=0&BibleID=NCB&Site=wbs&BCVNo=". sprintf("%d%03d%03d", $bid, $cid, $vid);
		$option_name = "Chinese New Version 繁體新譯本";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
			
		//$text_cmp = $text_cmp .  "<a href=\"http://www.dbsbible.org/ct50/Bible/LZZ/gb/" . strtolower($book_en3[$bid]) . "/" . $cid . ".htm\">吕振中译本(LZZ)</a> |\n";
		$option_url = "http://www.dbsbible.org/ct50/Bible/LZZ/gb/" . strtolower($book_en3[$bid]) . "/" . $cid . ".htm";
		$option_name = "吕振中译本(LZZ)";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
	
		//$text_cmp = $text_cmp .  "<a href=\"http://www.esvapi.org/v2/rest/passageQuery?key=IP&q=" . $book_en[$bid] . "+" . $cid . "+" . $vid . "\" target=_blank>ESVAPI</a> \n";
		//$text_cmp = $text_cmp .  "(<a href=\"http://www.esvapi.org/v2/rest/passageQuery?key=IP&q=" . $book_en[$bid] . "+" . $cid . "\" target=_blank>Chapter</a>) | \n";

		

		//$text_cmp = $text_cmp .  "<a href=\"http://www.esvbible.org/search/" . $book_en[$bid] . "+" . $cid . ":" . $vid . "\" target=_blank>ESVBible</a> \n";
		$option_url = "http://www.esvbible.org/search/" . $book_en[$bid] . "+" . $cid . ":" . $vid;
		$option_name = "ESV Bible";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
	
		
		//$text_cmp = $text_cmp .  "(<a href=\"http://www.esvbible.org/search/" . $book_en[$bid] . "+" . $cid . "\" target=_blank>Chapter</a>) | \n";
		
		//$text_cmp = $text_cmp .  "<a href=\"http://www.biblegateway.com/passage/?version=ESV&search=" .  $book_en[$bid] . "+" . $cid . ":" . $vid . "\" target=_blank>BibleGateway</a> | \n";
		$option_url = "http://www.biblegateway.com/passage/?version=ESV&search=" .  $book_en[$bid] . "+" . $cid . ":" . $vid;
		$option_name = "Bible Gateway";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";

		//$text_cmp = $text_cmp .  "<a href=\"http://biblia.com/books/esv/" .  $book_en[$bid] . "" . $cid . "." . $vid . "\" target=_blank>Biblia</a> | \n";
		$option_url = "http://biblia.com/books/esv/" .  $book_en[$bid] . "" . $cid . "." . $vid;
		$option_name = "Biblia";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";

		
		//$text_cmp = $text_cmp .  "<a href=\"http://www.bible.is/ENGESV/" .  $book_short[$bid] . "/" . $cid  . "\" target=_blank>圣经朗读</a> | \n";
		$option_url = "http://www.bible.is/CHNUN1/" .  $book_short[$bid] . "/" . $cid;
		$option_name = "圣经朗读";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
		$quick_link_text .= "<a href=$option_url target=_blank>$option_name</a>&nbsp; ";
		//$text_cmp = $text_cmp .  "<a href=\"http://www.youversion.com/zh-CN/bible/" .  $book_short[$bid] . "." . $cid  . "." . $vid  . ".cunpss\" target=_blank>优训读经</a>\n";
		$option_url = "https://www.youversion.com/zh-CN/bible/" .  $book_short[$bid] . "." . $cid  . "." . $vid  . ".cunpss";
		$option_name = "优训读经";
		$text_cmp .= "<option value=\"$option_url\">$option_name</option>\n";
		$quick_link_text .= "<a href=$option_url target=_blank>$option_name</a>&nbsp; ";
		//$text_cmp = $text_cmp .  "(<a href=\"http://www.youversion.com/zh-CN/bible/" .  $book_short[$bid] . "." . $cid  . "." . $vid  . ".cnvs\" target=_blank>新译本</a> | \n";
		
		//$text_cmp = $text_cmp .  "<a href=\"http://www.youversion.com/zh-CN/bible/" .  $book_short[$bid] . "." . $cid  . "." . $vid . ".esv\" target=_blank>ESV</a>)\n";
				
		//$text_cmp = $text_cmp .  "<a href=\"http://api.preachingcentral.com/bible.php?passage=" . $book_short[$bid] . "" . $cid . ":" . $vid . "&version=chinese-ncv-simplifi\" target=_blank>新译本</a> | \n";

	
	if($verse==$vid)
		{
			  /*
			 $url="http://api.preachingcentral.com/bible.php?passage=" . $book_short[$bid] . "" . $cid . ":" . $vid . "&version=chinese-ncv-simplifi";
			  $ch = curl_init($url); 
			  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			  $response = curl_exec($ch);
			  curl_close($ch);
			 $text_cmp = $text_cmp . "<p>&nbsp;</p><P>" . $response . "(新译本 CNVS)</p>\n";
			 
			 $url="http://api.preachingcentral.com/bible.php?passage=" . $book_short[$bid] . "" . $cid . ":" . $vid . "&version=chinese-ncv-traditio";
			  $ch = curl_init($url); 
			  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			  $response = curl_exec($ch);
			  curl_close($ch);
			 $text_cmp = $text_cmp . "<P>" . $response . "(新譯本 CNV)</p><p>&nbsp;</p>\n";
			*/
			
			/*
			 $key = "3208dfea819fa015";
			 $key= "IP";
			  $passage = urlencode("john 3:16");
			  $options = "include-passage-references=true&include-passage-horizontal-line=false&include-footnotes=true&include-heading-horizontal-lines=false&include-headings=false&include-subheadings=true&include-surrounding-chapters=false&include-word-ids=true";
			  //$url = "http://www.esvapi.org/v2/rest/passageQuery?key=$key&passage=$passage&$options";
			  $url="http://www.esvapi.org/v2/rest/passageQuery?key=$key&$options&q=" . $book_en[$bid] . "+" . $cid . "+" . $vid; 
			  $ch = curl_init($url); 
			  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			  $response = curl_exec($ch);
			  curl_close($ch);
			 $text_cmp = $text_cmp . "<P>" . $response . "</p>\n";
			 */
		
			 
		}
		$text_cmp = $text_cmp . "</select>";
		$text_cmp .= $quick_link_text;
		$reported = $row['reported'];
		$likes = (int)$row['likes'];
		$text_cmp = $text_cmp .  " <small><a href=\"bible.php?cmd=like&b=$bid&c=$cid&v=$vid\"><img src='like.png' width=14 height=14 border=0 alt = Like/>喜爱本节 Like the Verse</a>"; 
		if($likes>0)
			$text_cmp = $text_cmp . " ($likes)\n";
		$text_cmp .= "</small>";
			/*
		if($reported)
			$text_cmp = $text_cmp .  "<small><font color=red> " . $reported . "报错 Report </font></small>\n";
		else
			$text_cmp = $text_cmp .  " <small><a href=\"bible.php?cmd=report&b=$bid&c=$cid&v=$vid\" target=_blank title=\"报告这节经文电子版有错误\" onclick=\"return confirm('您确定这节经文电子版有错误且要提交错误报告？')\">报错</a></small>\n";
		$text_cmp = $text_cmp .  "<small>更新 Updated " . $row['updated'] . "</small>\n";
			
		//echo "</span>\n";
		$text_cmp = $text_cmp .  "]</p>\n";
		*/
	
		$text_cmp .= "</p>\n";
	}//portable

	    $wiki_text = $wiki_text . "<p>[[MHC:" . $book_chinese[$bid] . " " . $cid . ":" . $vid . " | " . $book_chinese[$bid] . " " . $cid . ":" . $vid .  "]]</p>\n";
		$verse_number ++;
		if(!$chapter && !($verse_number % 5 ) )
		{
			//$text_cmp = $text_cmp .  "\n";
			$wiki_text = $wiki_text . "<p>&nbsp;</p>\n";
		}
		if($chapter && !($verse_number % 10 ) )
		{
			//$text_cmp = $text_cmp .  "\n";
			$wiki_text = $wiki_text . "<p>&nbsp;</p>\n";
		}
		
		$text_cmp = $text_cmp .  "\n";	
	}

	$text_tw = $text_tw . " (繁體和合本 CUVT) \n";
	//$text_cn = $text_cn . " (和合本 CUV) \n";
	$text_en = $text_en . " (King James Version KJV) \n";
//$text_py = "<p>" . $text_py . " (Pinyin) </p>";
}

//$txt=" $q \n ";
	$txt="";

	/*
	if($cn)
		$txt .= $text_cn . "\n";
	if($tw)
		$txt .= $text_tw . "\n";
	if($en)
		$txt .= $text_en . "\n";
	*/	
	$txt .=  $text_cmp;
	if($query && $echo_string)
		$txt .=  "\n" . $echo_string . show_hint();
    //$txt = htmlspecialchars($txt);
	$txt=str_sensitive($txt);
	if(strlen($txt)>1980){
		$txt=mb_strcut($txt,0,1980,'utf-8') ;
		if(strlen($txt)>1980){
			$txt=substr($txt,0,1980);
		}
		$txt .= "\n\n内容有删节\n";	
	}
	$txt .= show_banner();
	return $txt;
}
    
}//class Bible

?>