
jQuery().ready(function(){
	var lastsel = -1;			
jQuery("#text").jqGrid({

  	url:'http://bible.world/bible.php?cmd=text',
    //editurl: 'http://bible.world/go.php',
    datatype: 'json',
    mtype: 'GET',
   	colNames:['ID','圣经经文'],
   	colModel:[
   		{name:'id',index:'id', width:10,editable:false, edittype:"text", hidden: true},
   		{name:'text',index:'text', width:600, editable:false, edittype:"text"}
  		
   	],

   	onSelectRow: function(id){
   	/*
    	websiteid=jQuery('#sites').jqGrid('getCell',id,'id');
    	//alert(websiteid);
		jQuery("#website").jqGrid('setGridParam',{url:'/go.php?cmd=detail&id=' + websiteid}).trigger('reloadGrid');
		flag = jQuery("#detail").css('visibility');
    	if(flag == "hidden")
      		jQuery("#detail").css('visibility' , 'visible');
      	else if(id == lastsel)
      		jQuery("#detail").css('visibility' , 'hidden');
      	lastsel = id;
	*/	
    },

    rowNum:-1,
   	autowidth: false,
   	//rowList:[20,40,60,80,100,150,200,500],
   	pager: jQuery('#pager'),
   	sortname: 'rank',
    sortorder: "desc",
    viewrecords: true,
    caption:"神同在读经工具",
    height:400,
  	recordtext:"{0} - {1}\u3000共 {2} 条",emptyrecords:"无数据显示",loadtext:"读取中...",pgtext:" {0} 共 {1} 页",

}); //jqgrid


jQuery("#text").navGrid('#pager',{
refresh: true, edit: false, add: false, del: false, search: true
});//navGrid

jQuery("#chapter").jqGrid({

	hiddengrid:false,

  	url:'http://bible.world/bible.php?cmd=chapter',
    datatype: 'json',
    mtype: 'GET',
   	colNames:['ID', '点击选择',''],
   	colModel:[
   		{name:'id',index:'id', width:10,editable:false, edittype:"text", hidden: true},
   		{name:'class',index:'class', width:80,editable:false, edittype:"select"},
   		{name:'count',index:'count', width:40,editable:false, edittype:"select"}
   	],
    onSelectRow: function(id){
    	classid=jQuery('#classes').jqGrid('getCell',id,'id');
		jQuery("#sites").jqGrid('setGridParam',{url:'/sites.php?cmd=json&cid=' + classid}).trigger('reloadGrid');
    },
     height:400,
  	recordtext:"{0} - {1}\u3000共 {2} 条",emptyrecords:"无数据显示",loadtext:"读取中...", pgtext: " {0} 共 {1} 页",
     
   	rowNum:-1,
   	autowidth: false,
   	pager: jQuery('#chapterpager'),
	viewrecords: true,
    caption:"章/篇",
    //recordtext:"{0} - {1}\u3000共 {2} 条",emptyrecords:"无数据显示",loadtext:"读取中...",pgtext:" {0} 共 {1} 页",
    recordtext:"",pgtext:"",
	page:1,pgbuttons:false,pginput:false,pgtext:"",recordtext:""

}); //jqgrid

jQuery("#chapterpager").navGrid('#chapter',{
refresh: true, edit: false, add: false, del: false, search: true
});//navGrid

jQuery("#book").jqGrid({

	hiddengrid:false,

    url:'http://bible.world/bible.php?cmd=book',
    datatype: 'json',
    mtype: 'GET',
   	colNames:['ID', '点击选择',''],
   	colModel:[
   		{name:'id',index:'id', width:10,editable:false, edittype:"text", hidden: true},
   		{name:'class',index:'class', width:80,editable:false, edittype:"select"},
   		{name:'count',index:'count', width:40,editable:false, edittype:"select"}
   	],
    onSelectRow: function(id){
    	classid=jQuery('#classes').jqGrid('getCell',id,'id');
		jQuery("#sites").jqGrid('setGridParam',{url:'/sites.php?cmd=json&cid=' + classid}).trigger('reloadGrid');
    },
     height:400,
  	recordtext:"{0} - {1}\u3000共 {2} 条",emptyrecords:"无数据显示",loadtext:"读取中...", pgtext: " {0} 共 {1} 页",
     
   	rowNum:-1,
   	autowidth: false,
   	pager: jQuery('#bookpager'),
	viewrecords: true,
    caption:"书/卷",
    //recordtext:"{0} - {1}\u3000共 {2} 条",emptyrecords:"无数据显示",loadtext:"读取中...",pgtext:" {0} 共 {1} 页",
    recordtext:"",pgtext:"",
	page:1,pgbuttons:false,pginput:false,pgtext:"",recordtext:""

}); //jqgrid

jQuery("#bookpager").navGrid('#book',{
refresh: true, edit: false, add: false, del: false, search: true
});//navGrid


function addresult(data)
{
	alert("运行结果：" + data.responseText);
	return true;
}



});//jQuery
function saveresult(data)
{
	alert("运行结果：" + data.responseText);
	return false;
}

function go(cmd,id)
{
	if(cmd == "go")
	{
		window.open("http://bible.world/go.php?cmd=go&id=" + id);
		jQuery("#sites").jqGrid().trigger('reloadGrid');
	}else if(cmd =="dig" || cmd =='bury'){
		//alert(id);
		//jQuery("#sites").jqGrid('setGridParam',{editurl:'/go.php?cmd=' + cmd + '&id=' + id});
		url = 'http://bible.world/go.php?cmd=' + cmd + '&id=' + id;
		/*
		jQuery("#sites").editRow(id,false);
		jQuery("#sites").saveRow(id,saveresult,url);
		*/

		newwin=window.open(url,'newwin', 'width=0,height=0');
		newwin.close();
		jQuery("#sites").jqGrid().trigger('reloadGrid');

	//}else if(cmd =="bury"){
		//newwin=window.open("go.php?cmd=bury&id=" + id);
		//newwin.close();
	}
}

function godwithusbible()
{
	host = window.location.hostname.toLowerCase();
	if( host != "bible.world" && host != "www.bible.world")
		return;
	jQuery("#godwithusbible").html("<center><div align=center><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"930\" align=\"center\">\
		<tr align=center>\
		<td align=center width=\"120\" aligh=right>\
		<table id=\"book\" align=center></table>\
		<div id=\"bookpager\"></div>\
		</td>\
		<td>\
		<table id=\"chapter\" align=center></table>\
		<div id=\"chapterpager\"></div>\
		</td>\
		<td width=\"*\" align=left>\
		<table id=\"text\" align=cener></table>\
		<div id=\"pager\"></div>\
		</td>\
		</tr>\
		</table>\
		<p align=center><small>Powered by <a href=http://bible.world target=_blank>Godwithus.cc</a> (C) 2004-2010</small></p></div></center>");
}
//godwithussites();
