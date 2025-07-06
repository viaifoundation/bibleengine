<?php
header('Content-Type: text/html; charset=UTF-8');

//anyuapp
//define( "WB_AKEY" , '1368678258' );
//define( "WB_SKEY" , 'e7939dae58c7d75a3966b1c359cf3147' );

//godwithus web
//define( "WB_AKEY" , '562992484' );
//define( "WB_SKEY" , '6ed5037713a7a40e4423e1fa2a7b0669' );

//ymnl
//define( "WB_AKEY" , '2191680098' );
//define( "WB_SKEY" , 'c4092093890f71aa391dc1d15c8ee47a' );

//miyu
//define( "WB_AKEY" , '1935399572' );
//define( "WB_SKEY" , '5897390a8c1acf968a00a75aa8afcd31' );

//godwithus app
//define( "WB_AKEY" , '1257169297' );
//define( "WB_SKEY" , '7c9eb0e0e569c02cbb2f4bacc91724bf' );

//define( "WB_CALLBACK_URL" , 'http://anyu.sinaapp.com/index.php' );
//define( "CANVAS_PAGE" , "http://anyu.sinaapp.com/index.php" );

$path=$_SERVER['PHP_SELF'];
$path=$_SERVER['SCRIPT_FILENAME'];
$path=$_SERVER['REQUEST_URI'];
$path=$_SERVER['HTTP_REFERER'];
/*
if(strstr($path,"godwithus"))
{
define( "WB_AKEY" , '3332444905' );
define( "WB_SKEY" , '3b020fce459bc4b624dc78381f2f9d49' );
define( "CANVAS_PAGE" , "http://apps.weibo.com/godwithus/index.php" );
define( "APPNAME" , "神同在应用" );
}
elseif(strstr($path,"ccwiki"))
{
define( "WB_AKEY" , '674736183' );
define( "WB_SKEY" , 'a2ae1982c55372acdce5909fd3bf4866' );
define( "CANVAS_PAGE" , "http://apps.weibo.com/ccwikiapp/index.php" );
define( "APPNAME" , "基督徒百科应用" );
}
elseif(strstr($path,"geshandi"))
{
define( "WB_AKEY" , '3190523623' );
define( "WB_SKEY" , '08254042bcd6cfbdc01bc93f3a980713' );
define( "CANVAS_PAGE" , "http://apps.weibo.com/ccwikiapp/index.php" );
define( "APPNAME" , "歌珊地应用" );
}
elseif(strstr($path,"miyu"))
{
define( "WB_AKEY" , '1935399572' );
define( "WB_SKEY" , '5897390a8c1acf968a00a75aa8afcd31' );
define( "CANVAS_PAGE" , "http://apps.weibo.com/miyuapp/index.php" );
define( "APPNAME" , "密语App" );
}
elseif(strstr($path,"pianyu"))
{
define( "WB_AKEY" , '1807791897' );
define( "WB_SKEY" , 'fc5139ca15cab93ac4ad16dc494a8522' );
define( "CANVAS_PAGE" , "http://apps.weibo.com/pianyuapp/index.php" );
define( "APPNAME" , "片语App" );
}
elseif(strstr($path,"buyu"))
{
define( "WB_AKEY" , '769998912' );
define( "WB_SKEY" , 'cf39442ecd4d79e5bf3defa9ec753154' );
define( "CANVAS_PAGE" , "http://apps.weibo.com/buyuapp/index.php" );
define( "APPNAME" , "不语App" );
}
elseif(strstr($path,"wanyu"))
{
define( "WB_AKEY" , '51281' );
define( "WB_SKEY" , 'd83a5f7a0155cc93f64a3f35861290ed' );
define( "CANVAS_PAGE" , "http://apps.weibo.com/wanyuapp/index.php" );
define( "APPNAME" , "万语App" );
}
elseif(strstr($path,"suiyu"))
{
define( "WB_AKEY" , '770467570' );
define( "WB_SKEY" , '40c149630342bd1ad76c61459618c3af' );
define( "CANVAS_PAGE" , "http://apps.weibo.com/suiyuapp/index.php" );
define( "APPNAME" , "随语App" );
}else
{//anyuapp
//anyuapp
define( "WB_AKEY" , '1368678258' );
define( "WB_SKEY" , 'e7939dae58c7d75a3966b1c359cf3147' );
define( "CANVAS_PAGE" , "http://apps.weibo.com/anyuapp/index.php" );
define( "APPNAME" , "暗语App" );
}
*/
define( "WB_AKEY" , '2389213214' );
define( "WB_SKEY" , '245508eb698f47a1af998178c161ba7d' );
define( "CANVAS_PAGE" , "http://apps.weibo.com/biblestudy/index.php" );
//echo $path . " <br/> " . WB_AKEY . " <br/> " . WB_SKEY . " <br/> " . CANVAS_PAGE;
/*

Tencent BibleStudy
App Key:801260250          
App Secret:58de863a338d3858eb123a0cc2862010
*/
if(strstr($path,"weibo"))
{
define( "APP_KEY" , '2389213214' );
define( "APP_SKEY" , '245508eb698f47a1af998178c161ba7d' );
define( "CALLBACK_URL" , "http://apps.weibo.com/biblestudy/index.php" );
define( "APP_WEIBO", 1);
}
else if(strstr($path,"qq"))
{
define( "APP_KEY",'801260250');
define( "APP_SKEY" , '58de863a338d3858eb123a0cc2862010' );
define( "CALLBACK_URL" , "http://app.t.qq.com/app/playtest/801260250" );
define( "APP_QQ", 1);
}
else
{
define( "APP_KEY",'801260250');
define( "APP_SKEY" , '58de863a338d3858eb123a0cc2862010' );
define( "CALLBACK_URL" , "http://bible.geshandi.com/app" );
define( "APP_WEIBO", 0);
define( "APP_QQ", 0);
}
