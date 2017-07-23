<?php
$link=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
mysql_select_db(SAE_MYSQL_DB,$link);
mysql_query("SET NAMES utf8");
$sql=mysql_query("select distinct 影院,片名 from movie_arrangement_today ",$link);
while($row=mysql_fetch_assoc($sql))
{
$output[]=$row;
}
print(json_encode($output));
mysql_close();
?>