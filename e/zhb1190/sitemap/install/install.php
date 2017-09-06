<?php
if(!defined('InEmpireCMS'))
{
        exit();
}


$empire->query(SetCreateTable("CREATE TABLE `{$dbtbpre}zhb1190_sitemap` (
  `tbname` varchar(60) NOT NULL default '',
  `time` int(10) unsigned NOT NULL default '0',
  `num` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`tbname`)
) TYPE=MyISAM;",$phome_db_dbchar));

$empire->query("insert into `{$dbtbpre}enewsmenuclass`(`classname`,`issys`,`myorder`,`classtype`) values('$ename','0','0','2');");
$menuclassid=$empire->lastid();
$empire->query("insert into `{$dbtbpre}enewsmenu`(`menuname`,`menuurl`,`myorder`,`classid`,`addhash`) values('开始生成 ','../zhb1190/sitemap/shch.php','1','$menuclassid',1);");
$empire->query("insert into `{$dbtbpre}enewsmenu`(`menuname`,`menuurl`,`myorder`,`classid`,`addhash`) values('提交网址','../zhb1190/sitemap/url.php','2','$menuclassid',1);");


$fp=@fopen("install.off","w");
@fclose($fp);
?>