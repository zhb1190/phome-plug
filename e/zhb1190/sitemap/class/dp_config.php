<?php
if(!defined('InEmpireCMS'))
{
    exit();
}

//����汾
$ver=file_exists('../../config/config.php')?1:0;

//���ݱ���
$dbchar=$ver==1?$ecms_config['db']['dbchar']:$phome_db_dbchar;

//ҳ�����
$pagechar=$ver==1?$ecms_config['sets']['pagechar']:$phome_ecms_charver;

?>