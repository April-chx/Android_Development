<?php
$link=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
mysql_select_db(SAE_MYSQL_DB,$link);
mysql_query("SET NAMES utf8");

$sql=mysql_query("select 排,列 from reservation_list where 片名='".$_REQUEST['movie']."' and 影院='".$_REQUEST['cinema']."' and 日期='".$_REQUEST['date']."' and 时间='".$_REQUEST['starttime']."'",$link);
while($row=mysql_fetch_assoc($sql))
{
	$output[]=$row;
}
print(json_encode($output));

mysql_close();
?>