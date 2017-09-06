<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
//验证用户
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
require("class/dp_config.php");
require("setconfig.php");
if($dp_r['isok']==0){
	exit('请先配置当前插件目录下setconfig.php文件');
}

//页面标题
$thispage='SiteMap提交网址';
//导航
$url='<a href="shch.php">SiteMap生成</a> -> '.$thispage;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$pagechar?>">
<link href="../../data/images/qcss.css" rel="stylesheet" type="text/css">
<title><?=$thispage?></title>
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
<tr bgcolor="#FFFFFF">
	<td height="25">当前位置：<?=$url?></td>
</tr>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr class="header">
	  <td colspan=2 height=25>最终提交网址</td>
    </tr>
<?
		$gs=$type==1?'.txt':'.xml';
		$file0=ECMS_PATH.$dp_r['path'].'/in'.$gs;
		if(file_exists($file0)){
			$ck0='<font color="green">已生成</font> <a href="'.$dp_r['siteurl'].'/'.$dp_r['path'].'/in'.$gs.'" target="_blank">查看</a>';
		}else{
			$ck0='<font color="gray">未生成</font>';
		}
?>
	<tr bgcolor="#FFFFFF"> 
      <td width=16%>
	  首页/栏目/专题
	  </td>
      <td height="35"><input type="text" value="<?=$dp_r['siteurl']?>/<?=$dp_r['path']?>/in<?=$gs?>" size=60> <?=$ck0?></td>
    </tr>
<?
	$sql=$empire->query("select tid,tname,tbname,isdefault from {$dbtbpre}enewstable order by tid");
	while($r=$empire->fetch($sql)){
		$file=ECMS_PATH.$dp_r['path'].'/map_'.$r[tbname].'.xml';
		if(file_exists($file)){
			$ck='<font color="green">已生成</font> <a href="'.$dp_r['siteurl'].'/'.$dp_r['path'].'/map_'.$r[tbname].'.xml" target="_blank">查看</a>';
		}else{
			$ck='<font color="gray">未生成</font>';
		}
?>
	<tr bgcolor="#FFFFFF"> 
      <td width=16%>
	  <?=$r[tname]?>
	  </td>
      <td height="35"><input type="text" value="<?=$dp_r['siteurl']?>/<?=$dp_r['path']?>/map_<?=$r[tbname]?>.xml" size=60> <?=$ck?></td>
    </tr>
<?
	}
?>
  </table>


</body>
</html>
<?
db_close();
$empire=null;
?>
