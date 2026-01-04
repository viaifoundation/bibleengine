<?php
$data = <<< EOD
{   "button":[
    {	
          "type":"view",
          "name":"Mobile",
          "url":"http://bible.geshandi.com/m"
      },
	{	
          "type":"view",
          "name":"Weibo",
          "url":"http://weibo.com/landofgoshen"
      },	  
      {
           "type":"view",
           "name":"Help",
           "url":"http://bible.world/wiki/BibleEngine"
      }]
}
EOD;

header("Content-type:text/plain");                                           
//$data_string = json_encode($data);                                                                                   
$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET";
$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx31df7509da616078&secret=51c1a62d1598e8ff8bb47fa263277f7a";
$ch=curl_init($url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$response = curl_exec($ch);
//echo $response;
$result = json_decode($response,true);
$access_token=$result["access_token"];
//$access_token = "GOAv7sZdTvBFd8HbIXRV-Ngv0UKjrbUuB8ZDxLg8S8g2VgsfOwP720MyEvlV_JXGQLFODv7dfIjVh5B_wyMrLiP9HfNxdWXBCtL8qltHzwix_80qO2Yv0b0ay6hWIttKcgEFuaJuPbwgCCmKjsmkzw";
echo "\nToken:$access_token\n";
curl_close($ch);

$url="https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=$access_token";
$ch=curl_init($url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$response = curl_exec($ch);
echo "\n$response\n";
curl_close($ch);

$data=utf8_encode($data);
$url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token";
$ch = curl_init($url);                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data))                                                                       
);                                                                                                                   
$result = curl_exec($ch);
curl_close($ch); 

echo "\n$result\n";

?>