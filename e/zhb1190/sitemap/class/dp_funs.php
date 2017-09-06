<?php

//取得表记录数
function eRowNum($tbname){
	global $empire,$dbtbpre;
	$total_r=$empire->fetch1("SHOW TABLE STATUS LIKE '".$tbname."';");
	return $total_r['Rows'];
}

function ShCh($tbname,$sid,$i,$n,$ehashvar,$ehash){
	global $empire,$dbtbpre,$dp_r,$ver;
	if(!$tbname){
		printerror("链接不存在","",1,0,1);
	}
	$i=(int)$i;
	$n=(int)$n;
	$sid=(int)$sid;
	if(!$sid){
		$sid=1;
	}
	$where='';
	$where0='';
	$classin=ClassIn($dp_r['class_0']);
	if($classin){
		$where=' and classid not in ('.$classin.')';
		$where0=' where classid not in ('.$classin.')';
	}
	if(!$i){
		DelS($tbname);
		//需要调取的信息总数
		$n=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$tbname." ".$where0.";");
	}	
	if(!$n){
		printerror("不存在信息，不需要生成","",1,0,1);
	}
	$filepath=ECMS_PATH.$dp_r['path'].'/';
	DoMkdir($filepath);
	$num=$dp_r['num'];
	if($dp_r['num']>49999 || $dp_r['num']<1){
		$num=1000;
	}
	$p=ceil($n/$num);
	$allfile='';
	$i+=1;
	if($i<=$p){
		$str='';
		if($i==1){
			$shu=$empire->fetch1("select id from {$dbtbpre}ecms_".$tbname." ".$where0." order by id limit $num,1");
		}else{
			$shu=$empire->fetch1("select id from {$dbtbpre}ecms_".$tbname." where id>=$sid ".$where." order by id limit $num,1");
		}
		$eid=$shu['id'];
		if($i==$p){
			$wh=' where id>='.$sid;
		}else{
			$wh=' where id>='.$sid.' and id<'.$eid;
		}
		$isurl='';
		if($ver){
			$isurl=',isurl';
		}
		$sql=$empire->query("select id,titleurl,newstime,classid,newspath,filename,groupid".$isurl." from {$dbtbpre}ecms_".$tbname." ".$wh.$where." order by id desc");
		while($r=$empire->fetch($sql)){
			if(($ver&&empty($r['isurl']))||(!$ver&&empty($r['titleurl']))){
				$str.=ReturnSitemapStr($r,3);
			}
		}
		$filename=$filepath.$tbname.'_'.$i.$dp_r['type'];
		//加载地图文件页头和页尾
		$str=ReturnSitemapAll($str);
		WriteFiletext_n($filename,$str);
		TableLu($tbname);
		echo "<meta http-equiv=\"refresh\" content=\"".$dp_r['time'].";url=shch.php?enews=shch&tbname=".$tbname."&sid=".$eid."&i=".$i."&n=".$n."&".$ehashvar."=".$ehash."\">一个地图文件生成成功(<font color=red><b>".$i."</b></font>)";
		exit();
	}
	else{
		$allfilename=$filepath.'map_'.$tbname.'.xml';
		for($x=1;$x<=$p;$x++){
			$allfile.=ReturnSitemapSyOneStr($x,$tbname);
		}
		$allfile=ReturnSitemapSyStr($allfile);
		WriteFiletext_n($allfilename,$allfile);
		TableLu($tbname);
		printerror("生成Sitemap完成","shch.php?".$ehashvar."=".$ehash,1,0,1);
	}
}

//首页、栏目、专题地图文件生成
function InCcZt($ehashvar,$ehash){
	global $empire,$dbtbpre,$dp_r;
	$where='';
	$where2='';
	$classin=ClassIn($dp_r['class_1']);
	if($classin){
		$where=' where classid not in ('.$classin.')';
	}
	$classin2=ClassIn($dp_r['zt']);
	if($classin2){
		$where2=' where ztid not in ('.$classin2.')';
	}
	$filepath=ECMS_PATH.$dp_r['path'].'/';
	DoMkdir($filepath);
	DelS('000');
	$cstr='';
	$zstr='';
	//首页
	$istr=ReturnSitemapStr('000',0);
	//栏目
	$sql=$empire->query("select classid,classpath,wburl from {$dbtbpre}enewsclass ".$where." order by classid desc");
	while($r=$empire->fetch($sql)){
		if(empty($r['wburl'])){
			$cstr.=ReturnSitemapStr($r,1);
		}
	}
	//专题
	$zsql=$empire->query("select ztid,ztpath,zttype from {$dbtbpre}enewszt ".$where." order by ztid desc");
	while($zr=$empire->fetch($zsql)){
		$zstr.=ReturnSitemapStr($zr,2);
	}
	//文件名
	$filename=$filepath.'in'.$dp_r['type'];
	//加载地图文件页头和页尾
	$str=ReturnSitemapAll($istr.$cstr.$zstr);
	//写文件
	WriteFiletext_n($filename,$str);
	//写记录
	TableLu('000');
	printerror("生成Sitemap完成","shch.php?".$ehashvar."=".$ehash,1,0,1);
}

//写入生成记录
function TableLu($tbname){
	global $empire,$dbtbpre;
	if($tbname=='000'){
		$num=0;
	}else{
		$infotbname=$dbtbpre.'ecms_'.$tbname;
		$num=eRowNum($infotbname);
	}
	$time=time();
	$empire->query("replace into {$dbtbpre}zhb1190_sitemap(tbname,time,num) values('$tbname','$time','$num')");
}

//删除旧文件
function DelS($tbname){
	global $dp_r;
	$tmppath=ECMS_PATH.$dp_r['path'];
	$hand=@opendir($tmppath);
	while($file=@readdir($hand))
	{
		$nm=$tbname.'_';
		if($tbname=='000'){
			$nm='in.';
		}
		$filename=$tmppath.'/'.$file;
		$pos=strpos($file,$nm);
		if($pos!==false){
			if(!is_dir($filename)){
				DelFiletext($filename);
			}
		}
	}
}

// 索引文件正文
function ReturnSitemapSyOneStr($i,$tbname){
	global $dp_r;
	$u='/'.$dp_r['path'].'/'.$tbname.'_'.$i.$dp_r['type'];
	$mapurl=$dp_r['siteurl'].$u;
	$str.='
  <sitemap>
	<loc>'.$mapurl.'</loc>
	<lastmod>'.date('Y-m-d').'</lastmod>
  </sitemap>
';
	return $str;
}

//索引文件的页头和页尾
function ReturnSitemapSyStr($str){
	$str='<?xml version="1.0"  encoding="UTF-8" ?> 
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
		'.$str.'
</sitemapindex>
';
	return $str;
}

//写地图文件头尾
function ReturnSitemapAll($r){
	global $dp_r;
	if($dp_r['type']=='.txt'){
		return $r;
	}
	$str.='<?xml  version="1.0" encoding="utf-8"?>
<urlset>
'.$r.'
</urlset>
';
	return $str;
}

//地图文件核心代码
function ReturnSitemapStr($r,$dp){
	global $dp_r,$ver;
	$time=time();
	if($dp==0){ //首页
		$pr=1;
		$ch='daily';
		$la=date('Y-m-d',$time);
		$titleurl=$dp_r['siteurl'];
	}
	elseif($dp==1){ //栏目页
		$pr=0.9;
		$ch='daily';
		$la=date('Y-m-d',$time);
		$classurl=sys_ReturnBqClassname($r,9);
		$titleurl=$dp_r['siteurl'].$classurl;
	}
	elseif($dp==2){ //专题页
		$pr=0.9;
		$ch='daily';
		$la=date('Y-m-d',$time);
		$u='/'.$r['ztpath'].'/';
		$titleurl=$dp_r['siteurl'].$u;
	}
	elseif($dp==3){ //信息页
		$pr=0.8;
		$ch='weekly';
		$la=date('Y-m-d',$r['newstime']);
		$u=$ver==1?$r['titleurl']:sys_ReturnBqTitleLink($r);
		if($dp_r['linktype']){
			$titleurl=$u;
		}else{
			$titleurl=$dp_r['siteurl'].$u;
		}
		$titleurl=str_replace('&','&amp;',$titleurl);
	}
	if($dp_r['type']=='.txt'){ //txt形式
		$str.=$titleurl."\r\n";
	}else{ //xml形式
		$str.='	<url>
		<loc>'.$titleurl.'</loc>
		<lastmod>'.$la.'</lastmod>
		<changefreq>'.$ch.'</changefreq>
		<priority>'.$pr.'</priority>
	</url>
';
	}
	return $str;
}

//返回排除的id
function ClassIn($str){
	if(empty($str)){
		return '';
	}
	$c='';
	$re='';
	$classzk=explode('|',$str);
	$count=count($classzk);
	if(!$count){
		return '';
	}
	for($i=0;$i<$count;$i++){
		$cid=(int)$classzk[$i];
		if($cid){
			$re.=$c.$cid;
			$c=',';
		}
	}
	return $re;
}

?>