<?php
if(!defined('InEmpireCMS'))
{
        exit();
}

//ɾ����
$empire->query("DROP TABLE IF EXISTS `{$dbtbpre}zhb1190_sitemap`;");

//ɾ������˵�
$menuclassr=$empire->fetch1("select classid from {$dbtbpre}enewsmenuclass where classname='$ename' limit 1");
$empire->query("delete from {$dbtbpre}enewsmenuclass where classid='$menuclassr[classid]'");
$empire->query("delete from {$dbtbpre}enewsmenu where classid='$menuclassr[classid]'");

?>