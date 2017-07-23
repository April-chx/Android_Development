<?php
$link=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
mysql_select_db(SAE_MYSQL_DB,$link);
mysql_query("SET NAMES utf8");

$sql="INSERT INTO `reservation_list`(`姓名`, `联系电话`, `片名`, `影院`, `播放类型`, `日期`, `时间`, `座位`, `票价`, `排`, `列`) 
		VALUES ('".$_REQUEST['name']."','".$_REQUEST['phone']."','".$_REQUEST['movie']."','".$_REQUEST['cinema']."','".$_REQUEST['showtype']."',
        '".$_REQUEST['date']."','".$_REQUEST['time']."','".$_REQUEST['seat']."','".$_REQUEST['ticketprice']."','".$_REQUEST['row']."','".$_REQUEST['column']."')";
if (!mysql_query($sql,$link))
{
	die('Error: ' . mysql_error());
}

mysql_close();
?>