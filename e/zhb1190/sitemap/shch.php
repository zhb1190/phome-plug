<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");

$link=db_connect();
$empire=new mysqlquery();
$editor=1;
//��֤�û�
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];

$ehashvar=$ecms_adminloginr['ehashname'];
$ehash=$ecms_adminloginr['ehash'];

require("class/dp_config.php");
require("class/dp_funs.php");
require("setconfig.php");
if($dp_r['isok']==0){
	exit('�������õ�ǰ���Ŀ¼��setconfig.php�ļ�');
}

$bgcolor="#ffffff";
$sql=$empire->query("select tid,tname,tbname,isdefault from {$dbtbpre}enewstable order by tid");

//ҳ�����
$thispage='SiteMap����';
//����
$url='<a href="shch.php">SiteMap����</a>';
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
<tr>
	<td height="25">��ǰλ�ã�<?=$url?></td>
</tr>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="5%" height="25"><div align="center">ID</div></td>
    <td height="25"><div align="center">������</div></td>
    <td width="15%"><div align="center">������Ϣ��</div></td>
	<td width="20%"><div align="center">�ϴ�����ʱ��</div></td>
    <td width="15%" height="25"><div align="center">����</div></td>
  </tr>
<?
	$ccnum=eRowNum($dbtbpre.'enewsclass');
	$ztnum=eRowNum($dbtbpre.'enewszt');
	$t0=$empire->fetch1("select * from {$dbtbpre}zhb1190_sitemap where tbname='000' limit 1");
	$sct0='δ����';
	if($t0['time']){
		$sct0=date('Y-m-d H:i:s',$t0['time']);
	}
?>
  <tr bgcolor="<?=$bgcolor?>"<?=$movejs?>> 
    <td height="32"><div align="center"> 
        0
      </div></td>
    <td height="25"> 
      ��ҳ / ��Ŀ / ר��</td>
    <td align="center">1 / <?=$ccnum?> / <?=$ztnum?></td>
	<td align="center"><?=$sct0?></td>
    <td align="center"><a href="do.php?enews=shch&tbname=000&<?=$ehashvar?>=<?=$ehash?>">����</a></td>
  </tr>
  <?php
  while($r=$empire->fetch($sql))
  {
	$infotbname='ecms_'.$r['tbname'];
	$tbinfos=eRowNum($dbtbpre.$infotbname);
	$tbinfos=(int)$tbinfos;
	$t=$empire->fetch1("select * from {$dbtbpre}zhb1190_sitemap where tbname='".$r['tbname']."' limit 1");
	$sct='δ����';
	if($t['time']){
		$sct=date('Y-m-d H:i:s',$t['time']);
	}
	if($t['tbname']&&$t['num']==$tbinfos){
		$color='green';
	}elseif($t['tbname']){
		$color='red';
	}else{
		$color='#000000';
	}
  ?>
  <tr bgcolor="<?=$bgcolor?>"> 
    <td height="32"><div align="center"> 
        <?=$r[tid]?>
      </div></td>
    <td height="25"> 
      <?=$r[tname]?>
      &nbsp;( <?=$dbtbpre?>ecms_<b><?=$r[tbname]?></b> ) </td>
    <td align="center" title="�ϴ�����ʱ����Ϣ����<?=$t['num']?>"><span style="color:<?=$color?>"><?=$tbinfos?></span></td>
	<td align="center"><?=$sct?></td>
    <td align="center"><a href="do.php?enews=shch&tbname=<?=$r[tbname]?>&<?=$ehashvar?>=<?=$ehash?>">����</a></td>
  </tr>
  <?php
	}
	?>
</table>
<br>
<span style="color:#333">��Ϣ����ɫ���壺��ɫ�������ϴ�����ʱ��Ϣ�ޱ仯����ɫ������Ϣ���б䶯����ɫ����δ����</span>

</body>
</html>
<?
db_close();
$empire=null;
?>
