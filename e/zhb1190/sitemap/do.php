<?php
require('../../class/connect.php');
require('../../class/db_sql.php');
require('../../class/functions.php'); //�����뺯��
require('../../data/dbcache/class.php'); //��Ŀ����
$link=db_connect();
$empire=new mysqlquery();
//��֤�û�
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];

$ehashvar=$ecms_adminloginr['ehashname'];
$ehash=$ecms_adminloginr['ehash'];

require('setconfig.php');
require('class/dp_config.php');
require('class/dp_funs.php');

$enews=$_POST['enews'];
if(empty($enews))
{
	$enews=$_GET['enews'];
}


if($enews=='shch'){
	$tbname=$_GET['tbname'];
	if($tbname=='000'){
		InCcZt($ehashvar,$ehash);
	}else{
		$sid=(int)$_GET['sid'];
		$i=(int)$_GET['i'];
		$n=(int)$_GET['n'];
		ShCh($tbname,$sid,$i,$n,$ehashvar,$ehash);
	}
}
else
{
	exit();
}

db_close();
$empire=null;
?>