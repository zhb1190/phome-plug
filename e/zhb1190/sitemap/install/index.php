<?php
error_reporting(E_ALL ^ E_NOTICE);

@set_time_limit(10000);

define('EmpireCMSAdmin','1');
require('../../../class/connect.php');
require('../../../class/db_sql.php');
require('../../../class/functions.php');
$link=db_connect();
$empire=new mysqlquery();

//程序版本
$ver=file_exists('../../../config/config.php')?1:0;

//数据编码
$dbchar=$ver==1?$ecms_config['db']['dbchar']:$phome_db_dbchar;

//页面编码
$pagechar=$ver==1?$ecms_config['sets']['pagechar']:$phome_ecms_charver;

//插件名称
$ename='百度SiteMap文件生成插件(zhb1190)';


if(file_exists("install.off"))
{
	echo"安装程序已锁定。如果要重新安装，请删除<b>install.off</b>文件！";
	exit();
}

if($_GET['ecms']=="install")
{
	$phome_db_dbchar=$dbchar;
	$doinstall=$_GET['doinstall'];
	if($doinstall=='install')//安装操作
	{
		include('install.php');
		$word='已安装完毕!</br>建议您立即删除安装文件。';
	}
	elseif($doinstall=='uninstall')//卸载操作
	{
		include('uninstall.php');
		$word='已卸载完毕!';
	}
	echo $ename.$word;
	exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$pagechar?>">
<title><?=$ename?> 安装/卸载程序</title>
<style>
a:link     { COLOR: #000000; TEXT-DECORATION: none }
a:visited   { COLOR: #000000 ; TEXT-DECORATION: none }
a:active   { COLOR: #000000 ; TEXT-DECORATION: underline }
a:hover    { COLOR: #000000 ; TEXT-DECORATION:underline }
.home_top { border-top:2px solid #4798ED; }
.home_path { background:#4798ED; padding-right:10px; color:#F0F0F0; font-size: 11px; }
td, th, caption { font-family:  "宋体"; font-size: 14px; color:#000000;  LINE-HEIGHT: 165%; }
.hrLine{MARGIN: 0px 0px; BORDER-BOTTOM: #807d76 1px dotted;}
</style>
<script>
function CheckUpdate(obj){
	if(confirm('确认操作?'))
	{
		obj.updatebutton.disabled=true;
		return true;
	}
	return false;
}
</script>
</head>
<body>
<form method="GET" action="index.php" name="formupdate" onsubmit="return CheckUpdate(document.formupdate);">
  <br>
  <br>
  <br>
  <table width="500" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#4FB4DE">
    <tr> 
      <td height="30" colspan="2"> <div align="center"><strong><font color="#FFFFFF"><?=$ename?> 安装/卸载程序</font></strong></div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="141" height="36"> 
        <div align="right">选择操作：</div></td>
      <td width="344"> <input name="doinstall" type="radio" value="install" checked>
        安装 
        <input type="radio" name="doinstall" value="uninstall">
        卸载</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="30"> 
        <div align="center"></div></td>
      <td> <input type=submit name=updatebutton value="提交操作"> <input name="ecms" type="hidden" id="ecms" value="install"> 
      </td>
    </tr>
  </table>
  </form>
  </body>
  </html>