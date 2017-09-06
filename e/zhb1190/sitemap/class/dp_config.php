<?php
if(!defined('InEmpireCMS'))
{
    exit();
}

//程序版本
$ver=file_exists('../../config/config.php')?1:0;

//数据编码
$dbchar=$ver==1?$ecms_config['db']['dbchar']:$phome_db_dbchar;

//页面编码
$pagechar=$ver==1?$ecms_config['sets']['pagechar']:$phome_ecms_charver;

?>