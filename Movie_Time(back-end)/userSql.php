<?php
error_reporting(0);
session_start();

// Connect the database 
$con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);

// If connect the database not successfully, output the error information
if (!$con) 
{
	die('连接失败:' . mysql_error());
}
else // If connect the database successfully
{ 
	// Select database
	mysql_select_db(SAE_MYSQL_DB, $con); 
	mysql_query("SET NAMES utf8");
}

// Function to judge user name by ajax.
if(isset($_GET["register"]) && $_GET["register"]==1) 
{
	$u_name=$_GET["name"];
	
	if($u_name=="")
	{
		echo "请输入您的用户名";
	}
	else
	{
		$res=mysql_query("SELECT * FROM user_list",$con);
				 
		while($row = mysql_fetch_array($res))
		{
			if($row['用户名']==$u_name)
			{
				echo "用户名已存在";
			}
		}			
	}
}

// Function to judge password by ajax.
if(isset($_GET["register"]) && $_GET["register"]==2)
{
	$u_password1=$_GET["password1"];
	
	if($u_password1=="")
	{
		echo "请输入您的密码";
	}
}

// Function to judge password again by ajax.
if(isset($_GET["register"]) && $_GET["register"]==3)
{	
	$u_password2=$_GET["password2"];
	$u_password1=$_GET["password1"];
	
	if($u_password2=="")
	{
		echo "请再次输入您的密码";
	}
	else if($u_password2!=$u_password1)
	{
		echo "两次密码不一致，请重新输入";
	}
}

// Function to judge email by ajax.
if(isset($_GET["register"]) && $_GET["register"]==4)
{
	$u_email=$_GET["email"];
	
	if($u_email=="")
	{
		echo "请输入您的邮箱";
	}
}


// Function to submit register information or judge infomation by ajax.
if(isset($_GET["register"]) && $_GET["register"]==5)
{			
	$u_name=$_GET["name"];
	$u_password1=$_GET["password1"];
	$u_password2=$_GET["password2"];
	$u_email=$_GET["email"];
    $u_phone=$_GET["phone"];
	$u_addresss=$_GET["address"];
	
	if($u_name=="")
	{
		echo "请输入您的用户名";
	}
	else
	{
		$hint="";
		$res=mysql_query("SELECT * FROM user_list",$con);
				 
		while($row = mysql_fetch_array($res))
		{
			if($row['用户名']==$u_name)
			{
				$hint="用户名已存在";
				echo $hint;
			}
		}
		
		if($hint=="" && $u_password1=="")
		{
			echo "请输入您的密码";
		}
		else if($hint=="" && $u_password1!="")
		{
			if($u_password2=="")
			{
				echo "请再次输入您的密码";
			}
			else if($u_password2!=$u_password1)
			{
				echo "两次密码不一致，请重新输入";
			}
			else
			{
				if($u_email=="")
				{
					echo "请输入您的邮箱";
				}
				else
				{					
					// Shore the regiser information into mysql
					$sql="INSERT INTO `user_list`(`用户名`, `密码`, `邮箱`, `联系电话`, `地址`, `管理员权限`) 
                    		VALUES ('$_GET[name]','$_GET[password2]','$_GET[email]','$_GET[phone]','$_GET[address]','0')";
                    $sql1="INSERT INTO `cinema_list`(`影院`, `地址`, `电话`) VALUES ('$_GET[name]','$_GET[address]','$_GET[phone]')";
				  
					if (!mysql_query($sql,$con))
					{
						die('Error: ' . mysql_error());
					}
                    
                    if (!mysql_query($sql1,$con))
					{
						die('Error: ' . mysql_error());
					}
 
					echo "注册成功！";					
				}
			}
		}
	}	
}

// Function to judge name by ajax.
if(isset($_GET["login"]) && $_GET["login"]==1)
{
	$u_name=$_GET["name"];
	
	if($u_name=="")
	{
		echo "请输入您的用户名";
	}
	else
	{
		$username_exist=0;
		$res=mysql_query("SELECT * FROM user_list",$con);
				 
		while($row = mysql_fetch_array($res))
		{
			if($row['用户名']==$u_name)
			{
				$username_exist=1;
			}
		}
		
		if($username_exist==0)
		{
			echo "用户名不存在";
		}
	}
}

// Function to check all information again by ajax
if(isset($_GET["login"]) && $_GET["login"]==2)
{
	$u_name=$_GET["name"];
	$u_password=$_GET["password"];
	
	if($u_name=="")
	{
		echo "请输入您的用户名";
	}
	else
	{
		$username_exist=0;
		$res=mysql_query("SELECT * FROM user_list",$con);
				 
		while($row = mysql_fetch_array($res))
		{
			if($row['用户名']==$u_name)
			{
				$username_exist=1;
			}
		}
		
		if($username_exist==0)
		{
			echo "用户名不存在";
		}
		else if($username_exist==1)
		{
			if($u_password=="")
			{
				echo "请输入您的密码";
			}
			else
			{
				$userpw_exist=0;
				$res=mysql_query("SELECT * FROM user_list",$con);
						 
				while($row = mysql_fetch_array($res))
				{
					if($row['用户名']==$u_name && $row['密码']==$u_password)
					{
						$userpw_exist=1;
					}
				}
				if($userpw_exist==0)
				{
					echo "密码错误";
				}
				else
				{
					$_SESSION['用户名']=$u_name;
					echo "登录成功！";
				}
			}
		}
	}
}

if(isset($_GET["index"]) && $_GET["index"]==1) 
{
	$sql = "UPDATE `notification` SET `通知` = '$_GET[textarea]' WHERE 1";
	if (!mysql_query($sql,$con))
	{
		die('Error: ' . mysql_error());
	}
				
	echo "修改成功！";
}

if(isset($_GET["cinemaInfo"]) && $_GET["cinemaInfo"]==1) 
{
	$u_name=$_GET["name"];
	$sql = "UPDATE `user_list` SET `邮箱` = '$_GET[email]',`联系电话` = '$_GET[phone]',`地址` = '$_GET[address]' WHERE `用户名` = '$u_name'";
    $sql1 = "UPDATE `cinema_list` SET `电话` = '$_GET[phone]',`地址` = '$_GET[address]' WHERE `影院` = '$u_name'";
	if (!mysql_query($sql,$con))
	{
		die('Error: ' . mysql_error());
	}
    
    if (!mysql_query($sql1,$con))
	{
		die('Error: ' . mysql_error());
	}
				
	echo "修改成功！";
}

if(isset($_GET["modifyPassword"]) && $_GET["modifyPassword"]==1) 
{
    $old_pw=$_GET["old_pw"];
	
	if($old_pw=="")
	{
		echo "请输入您的原密码";
	}
}

if(isset($_GET["modifyPassword"]) && $_GET["modifyPassword"]==2) 
{
    $new_pw=$_GET["new_pw"];
	
	if($new_pw=="")
	{
		echo "请输入您的新密码";
	}
}

if(isset($_GET["modifyPassword"]) && $_GET["modifyPassword"]==3) 
{
    $new_pw=$_GET["new_pw"];
	$confirm_pw=$_GET["confirm_pw"];
	
	if($confirm_pw=="")
	{
		echo "请再次输入您的密码";
	}
	else if($new_pw!=$confirm_pw)
	{
		echo "两次密码不一致，请重新输入";
	}
}

if(isset($_GET["modifyPassword"]) && $_GET["modifyPassword"]==4) 
{
    $user_name = $_SESSION['用户名'];
    $old_pw=$_GET["old_pw"];
    $new_pw=$_GET["new_pw"];
	$confirm_pw=$_GET["confirm_pw"];
    
    if($old_pw=="")
	{
		echo "请输入您的原密码";
	}
    else if($new_pw=="")
	{
		echo "请输入您的新密码";
	}
    else if($confirm_pw=="")
	{
		echo "请再次输入您的密码";
	}
	else if($new_pw!=$confirm_pw)
	{
		echo "两次密码不一致，请重新输入";
	}
    else
    {
        $res = mysql_query("SELECT 密码 FROM user_list WHERE 用户名='$user_name'",$con);
        $row = mysql_fetch_array($res);
        if($row[0] != $old_pw)
        {
            echo "原密码错误，修改密码失败！";
            echo $row[0];
            //echo $old_pw;
        }
        else
        {
            $sql = "UPDATE `user_list` SET `密码` = '$confirm_pw' WHERE `用户名` = '$user_name'";
            if (!mysql_query($sql,$con))
			{
				die('Error: ' . mysql_error());
			}
			echo "修改成功！";
        }
    }
}

if(isset($_GET["arrangement"]) && $_GET["arrangement"]==1)
{
    $user_name = $_SESSION['用户名'];
    $res1 = mysql_query("SELECT * FROM movie_arrangement_today WHERE 影院='$user_name' AND 片名='$_GET[movie]'",$con);
    $num = mysql_num_rows($res1);
    echo $num;
    
    $res2 = mysql_query("SELECT time_format(时间, '%H:%i'),播放类型,票价,编号 FROM movie_arrangement_today 
    					WHERE 片名='$_GET[movie]' AND 影院='$user_name' ORDER BY time_format(时间, '%H:%i') ASC");

    while($row2 = mysql_fetch_array($res2))
    {
    	echo "|<tr><td style='text-align:center;'>$row2[0]</td>
    	<td style='text-align:center;'>$row2[1]</td>
    	<td style='text-align:center;'>$row2[2]</td>
    	<td style='text-align:center;'><a href='javascript:;' target='_self' onclick='arrangement2($row2[3])' style='font-family:微软雅黑' >[删除]</a></td></tr>";
    }
}

if(isset($_GET["arrangement"]) && $_GET["arrangement"]==2)
{
    $num = $_GET["num"];
    $sql = "DELETE FROM app_movietimeapp.movie_arrangement_today WHERE movie_arrangement_today.编号='$num'";
    
    if (!mysql_query($sql,$con))
	{
		die('Error: ' . mysql_error());
	}
}

if(isset($_GET["arrangement"]) && $_GET["arrangement"]==3)
{
    $user_name = $_SESSION['用户名'];
        
    $sql="INSERT INTO `movie_arrangement_today`(`影院`, `片名`, `时间`, `播放类型`, `票价`) VALUES ('$user_name','$_GET[movie]','$_GET[start_time]','$_GET[show_type]','$_GET[ticket_price]')";
    
    if (!mysql_query($sql,$con))
    {
    	die('Error: ' . mysql_error());
    }
}

if(isset($_GET["arrangement"]) && $_GET["arrangement"]==4)
{
    $user_name = $_SESSION['用户名'];
    $sql1 = mysql_query("SELECT * FROM movie_list WHERE 片名='$_GET[new_movie]'",$con);  
    $sql2 = mysql_query("SELECT * FROM temp_movie_list WHERE 片名='$_GET[new_movie]'",$con);  
    
    if(!mysql_num_rows($sql1) && !mysql_num_rows($sql2))
    {
        $sql3="INSERT INTO `temp_movie_list`(`片名`) VALUES ('$_GET[new_movie]')";
    	if (!mysql_query($sql3,$con))
    	{
    		die('Error: ' . mysql_error());
    	}
    }

    $sql4="INSERT INTO `movie_arrangement_today`(`影院`, `片名`, `时间`, `播放类型`, `票价`) VALUES ('$user_name','$_GET[new_movie]','$_GET[new_start_time]','$_GET[new_show_type]','$_GET[new_ticket_price]')";
    if (!mysql_query($sql4,$con))
    {
    	die('Error: ' . mysql_error());
    }
}

if(isset($_GET["arrangement"]) && $_GET["arrangement"]==5)
{
    $user_name = $_SESSION['用户名'];
    $sql = "DELETE FROM app_movietimeapp.movie_arrangement_today WHERE movie_arrangement_today.影院='$user_name' AND 片名='$_GET[movie]'";
    if (!mysql_query($sql,$con))
	{
		die('Error: ' . mysql_error());
	}
}

if(isset($_GET["arrangement_tomorrow"]) && $_GET["arrangement_tomorrow"]==1)
{
    $user_name = $_SESSION['用户名'];
    $res1 = mysql_query("SELECT * FROM movie_arrangement_tomorrow WHERE 影院='$user_name' AND 片名='$_GET[movie]'",$con);
    $num = mysql_num_rows($res1);
    echo $num;
    
    $res2 = mysql_query("SELECT time_format(时间, '%H:%i'),播放类型,票价,编号 FROM movie_arrangement_tomorrow 
    					WHERE 片名='$_GET[movie]' AND 影院='$user_name' ORDER BY time_format(时间, '%H:%i') ASC");

    while($row2 = mysql_fetch_array($res2))
    {
    	echo "|<tr><td style='text-align:center;'>$row2[0]</td>
    	<td style='text-align:center;'>$row2[1]</td>
    	<td style='text-align:center;'>$row2[2]</td>
    	<td style='text-align:center;'><a href='javascript:;' target='_self' onclick='arrangement_tomorrow2($row2[3])' style='font-family:微软雅黑' >[删除]</a></td></tr>";
    }
}

if(isset($_GET["arrangement_tomorrow"]) && $_GET["arrangement_tomorrow"]==2)
{
    $num = $_GET["num"];
    $sql = "DELETE FROM app_movietimeapp.movie_arrangement_tomorrow WHERE movie_arrangement_tomorrow.编号='$num'";
    
    if (!mysql_query($sql,$con))
	{
		die('Error: ' . mysql_error());
	}
}

if(isset($_GET["arrangement_tomorrow"]) && $_GET["arrangement_tomorrow"]==3)
{
    $user_name = $_SESSION['用户名'];
        
    $sql="INSERT INTO `movie_arrangement_tomorrow`(`影院`, `片名`, `时间`, `播放类型`, `票价`) 
    		VALUES ('$user_name','$_GET[movie]','$_GET[start_time]','$_GET[show_type]','$_GET[ticket_price]')";
    
    if (!mysql_query($sql,$con))
    {
    	die('Error: ' . mysql_error());
    }
}

if(isset($_GET["arrangement_tomorrow"]) && $_GET["arrangement_tomorrow"]==4)
{
    $user_name = $_SESSION['用户名'];
    $sql1 = mysql_query("SELECT * FROM movie_list WHERE 片名='$_GET[new_movie]'",$con);  
    $sql2 = mysql_query("SELECT * FROM temp_movie_list WHERE 片名='$_GET[new_movie]'",$con);  
    
    if(!mysql_num_rows($sql1) && !mysql_num_rows($sql2))
    {
        $sql3="INSERT INTO `temp_movie_list`(`片名`) VALUES ('$_GET[new_movie]')";
    	if (!mysql_query($sql3,$con))
    	{
    		die('Error: ' . mysql_error());
    	}
    }

    $sql4="INSERT INTO `movie_arrangement_tomorrow`(`影院`, `片名`, `时间`, `播放类型`, `票价`) VALUES ('$user_name','$_GET[new_movie]','$_GET[new_start_time]','$_GET[new_show_type]','$_GET[new_ticket_price]')";
    if (!mysql_query($sql4,$con))
    {
    	die('Error: ' . mysql_error());
    }
}

if(isset($_GET["arrangement_tomorrow"]) && $_GET["arrangement_tomorrow"]==5)
{
    $user_name = $_SESSION['用户名'];
    $sql = "DELETE FROM app_movietimeapp.movie_arrangement_tomorrow WHERE movie_arrangement_tomorrow.影院='$user_name' AND 片名='$_GET[movie]'";
    if (!mysql_query($sql,$con))
	{
		die('Error: ' . mysql_error());
	}
}

if(isset($_GET["movieList"]) && $_GET["movieList"]==1) 
{
    $sql = "DELETE FROM app_movietimeapp.movie_list WHERE movie_list.编号='$_GET[num]'";
    if (!mysql_query($sql,$con))
	{
		die('Error: ' . mysql_error());
	}
}

if(isset($_GET["movieList"]) && $_GET["movieList"]==2) 
{
    $movie_num=$_GET["movie_num"];
	$uploadfile=$_GET["uploadfile"];
    $actor=$_GET["actor"];
    $movie_type=$_GET["movie_type"];
    $movie_time=$_GET["movie_time"];
    $introduction=$_GET["introduction"];
    
    $res = mysql_query("SELECT 片名 FROM temp_movie_list WHERE 编号='$movie_num'",$con);
    $movie_name = mysql_fetch_array($res);
	
    if($uploadfile == "")
	{
		echo "请选择要上传的图片";
	}
    else if($actor=="")
	{
		echo "请填写演员介绍";
	}
    else if($movie_type=="")
    {
        echo "请填写电影类型";
    }
	else if($movie_time=="")
    {
        echo "请填写电影时长";
    }
    else if($introduction=="")
    {
        echo "请填写影片介绍";
    }
    else
    {
        $res = mysql_query("SELECT 片名 FROM temp_movie_list WHERE 编号='$movie_num'",$con);
   	 	$movie_name = mysql_fetch_array($res);
        $sql1="INSERT INTO `movie_list`(`片名`, `演员`, `影片类型`, `电影时长`, `介绍`, `海报`) 
        		VALUES ('$movie_name[0]','$actor','$movie_type','$movie_time','$introduction','$uploadfile')";
        if (!mysql_query($sql1,$con))
		{
			die('Error: ' . mysql_error());
		}
        
        $sql2 = "DELETE FROM app_movietimeapp.temp_movie_list WHERE temp_movie_list.编号='$movie_num'";
    	if (!mysql_query($sql2,$con))
		{
			die('Error: ' . mysql_error());
		}
        
        echo "添加成功！";
    }
}

if(isset($_GET["reservation"]) && $_GET["reservation"]==1) 
{
    $user_name = $_SESSION['用户名'];
    $res1 = mysql_query("SELECT * FROM movie_arrangement_today WHERE 影院='$user_name' AND 片名='$_GET[movie]'",$con);
    $num = mysql_num_rows($res1);
    echo $num;
    
    $res2 = mysql_query("SELECT time_format(时间, '%H:%i'),播放类型,票价,编号 FROM movie_arrangement_today 
    					WHERE 片名='$_GET[movie]' AND 影院='$user_name' ORDER BY time_format(时间, '%H:%i') ASC");

    while($row2 = mysql_fetch_array($res2))
    {
    	echo "|<tr><td><a href='javascript:;' onclick='reservation2($row2[3])' style='font-family:微软雅黑' >
                    		$row2[0]&nbsp($row2[1]-票价:$row2[2]元)</a></td></tr>";
    }
}

if(isset($_GET["reservation"]) && $_GET["reservation"]==2) 
{
    $user_name = $_SESSION['用户名'];
    $num = $_GET["num"];
    $res1 = mysql_query("SELECT 片名,播放类型,time_format(时间, '%H:%i'),票价 FROM movie_arrangement_today WHERE 编号='$num'",$con);
    $row1 = mysql_fetch_array($res1);
    $time = "$row1[2]:00";
    $res2 = mysql_query("SELECT 姓名,联系电话,座位,编号 FROM reservation_list WHERE 片名='$row1[0]' AND 影院='$user_name' AND 播放类型='$row1[1]' AND 日期='今天' AND 时间='$time'",$con);

    
    echo "<table width='400' style='margin-left:50px;text-align:center;'><tr><td><font color='#D94600'>$row1[0]&nbsp&nbsp$row1[2]&nbsp($row1[1]-票价:$row1[3]元)</font></td></tr></table>
          <table id='res_table' width='360' border='1' cellspacing='2' cellpadding='2' style='margin-left:70px'>
          <tr><th scope='col' style='text-align:center;width:80px'>预约人</th>
              <th scope='col' style='text-align:center;width:130px'>联系电话</th>
              <th scope='col' style='text-align:center;width:90px'>座位</th>
              <th scope='col' style='text-align:center;width:60px'>操作</th></tr>";
    
    while($row2 = mysql_fetch_array($res2))
    {
        echo "<tr><td style='text-align:center;'>$row2[0]</td>
        			<td style='text-align:center;'>$row2[1]</td>
                    <td style='text-align:center;'>$row2[2]</td>
                    <td style='text-align:center;'><a href='javascript:;' target='_self' onclick='reservation3($row2[3],$num)' style='font-family:微软雅黑' >[删除]</a></td></tr>";
    }
    echo "</table>";
}

if(isset($_GET["reservation"]) && $_GET["reservation"]==3) 
{
    $num = $_GET["num"];
    
    $sql2 = "DELETE FROM app_movietimeapp.reservation_list WHERE reservation_list.编号='$num'";
    if (!mysql_query($sql2,$con))
	{
		die('Error: ' . mysql_error());
	}
}

if(isset($_GET["reservation"]) && $_GET["reservation"]==4) 
{
    $user_name = $_SESSION['用户名'];
    $arr_res1 = mysql_query("SELECT * FROM movie_arrangement_today WHERE 影院='$user_name' AND 片名='$_GET[movie]'",$con);
    $arr_num = mysql_num_rows($arr_res1);
    echo $arr_num;
    
    
    
    $arr_res2 = mysql_query("SELECT time_format(时间, '%H:%i'),播放类型,票价,编号 FROM movie_arrangement_today 
    					WHERE 片名='$_GET[movie]' AND 影院='$user_name' ORDER BY time_format(时间, '%H:%i') ASC");

    while($arr_row2 = mysql_fetch_array($arr_res2))
    {
    	echo "|<tr><td><a href='javascript:;' onclick='reservation2($arr_row2[3])' style='font-family:微软雅黑' >
                    		$arr_row2[0]&nbsp($arr_row2[1]-票价:$arr_row2[2]元)</a></td></tr>";
    }
    
    $res_num = $_GET["num"];
    $res_res1 = mysql_query("SELECT 片名,播放类型,time_format(时间, '%H:%i'),票价 FROM movie_arrangement_today WHERE 编号='$res_num'",$con);
    $res_row1 = mysql_fetch_array($res_res1);
    $time = "$res_row1[2]:00";
    $res_res2 = mysql_query("SELECT 姓名,联系电话,座位,编号 FROM reservation_list WHERE 片名='$res_row1[0]' AND 影院='$user_name' AND 播放类型='$res_row1[1]' AND 日期='今天' AND 时间='$time'",$con);

    
    echo "|<table width='400' style='margin-left:50px;text-align:center;'><tr><td><font color='#D94600'>$res_row1[0]&nbsp&nbsp$res_row1[2]&nbsp($res_row1[1]-票价:$res_row1[3]元)</font></td></tr></table>
          <table id='res_table' width='360' border='1' cellspacing='2' cellpadding='2' style='margin-left:70px'>
          <tr><th scope='col' style='text-align:center;width:80px'>预约人</th>
              <th scope='col' style='text-align:center;width:130px'>联系电话</th>
              <th scope='col' style='text-align:center;width:90px'>座位</th>
              <th scope='col' style='text-align:center;width:60px'>操作</th></tr>";
    
    while($res_row2 = mysql_fetch_array($res_res2))
    {
        echo "<tr><td style='text-align:center;'>$res_row2[0]</td>
        			<td style='text-align:center;'>$res_row2[1]</td>
                    <td style='text-align:center;'>$res_row2[2]</td>
                    <td style='text-align:center;'><a href='javascript:;' target='_self' onclick='reservation3($res_row2[3])' style='font-family:微软雅黑' >[删除]</a></td></tr>";
    }
    echo "</table>";
}

if(isset($_GET["reservation_tomorrow"]) && $_GET["reservation_tomorrow"]==1) 
{
    $user_name = $_SESSION['用户名'];
    $res1 = mysql_query("SELECT * FROM movie_arrangement_tomorrow WHERE 影院='$user_name' AND 片名='$_GET[movie_tomorrow]'",$con);
    $num_tomorrow = mysql_num_rows($res1);
    echo $num_tomorrow;
    
    $res2 = mysql_query("SELECT time_format(时间, '%H:%i'),播放类型,票价,编号 FROM movie_arrangement_tomorrow 
    					WHERE 片名='$_GET[movie_tomorrow]' AND 影院='$user_name' ORDER BY time_format(时间, '%H:%i') ASC");

    while($row2 = mysql_fetch_array($res2))
    {
    	echo "|<tr><td><a href='javascript:;' onclick='reservation_tomorrow2($row2[3])' style='font-family:微软雅黑' >
                    		$row2[0]&nbsp($row2[1]-票价:$row2[2]元)</a></td></tr>";
    }
}

if(isset($_GET["reservation_tomorrow"]) && $_GET["reservation_tomorrow"]==2) 
{
    $user_name = $_SESSION['用户名'];
    $num_tomorrow = $_GET["num_tomorrow"];
    $res1 = mysql_query("SELECT 片名,播放类型,time_format(时间, '%H:%i'),票价 FROM movie_arrangement_tomorrow WHERE 编号='$num_tomorrow'",$con);
    $row1 = mysql_fetch_array($res1);
    $time = "$row1[2]:00";
    $res2 = mysql_query("SELECT 姓名,联系电话,座位,编号 FROM reservation_list WHERE 片名='$row1[0]' AND 影院='$user_name' AND 播放类型='$row1[1]' AND 日期='今天' AND 时间='$time'",$con);

    
    echo "<table width='400' style='margin-left:50px;text-align:center;'><tr><td><font color='#D94600'>$row1[0]&nbsp&nbsp$row1[2]&nbsp($row1[1]-票价:$row1[3]元)</font></td></tr></table>
          <table id='res_table' width='360' border='1' cellspacing='2' cellpadding='2' style='margin-left:70px'>
          <tr><th scope='col' style='text-align:center;width:80px'>预约人</th>
              <th scope='col' style='text-align:center;width:130px'>联系电话</th>
              <th scope='col' style='text-align:center;width:90px'>座位</th>
              <th scope='col' style='text-align:center;width:60px'>操作</th></tr>";
    
    while($row2 = mysql_fetch_array($res2))
    {
        echo "<tr><td style='text-align:center;'>$row2[0]</td>
        			<td style='text-align:center;'>$row2[1]</td>
                    <td style='text-align:center;'>$row2[2]</td>
                    <td style='text-align:center;'><a href='javascript:;' target='_self' onclick='reservation_tomorrow3($row2[3],$num_tomorrow)' style='font-family:微软雅黑' >[删除]</a></td></tr>";
    }
    echo "</table>";
}

if(isset($_GET["reservation_tomorrow"]) && $_GET["reservation_tomorrow"]==3) 
{
    $num_tomorrow = $_GET["num_tomorrow"];
    
    $sql2 = "DELETE FROM app_movietimeapp.reservation_list WHERE reservation_list.编号='$num_tomorrow'";
    if (!mysql_query($sql2,$con))
	{
		die('Error: ' . mysql_error());
	}
}

if(isset($_GET["reservation_tomorrow"]) && $_GET["reservation_tomorrow"]==4) 
{
    $user_name = $_SESSION['用户名'];
    $arr_res1 = mysql_query("SELECT * FROM movie_arrangement_tomorrow WHERE 影院='$user_name' AND 片名='$_GET[movie_tomorrow]'",$con);
    $arr_num = mysql_num_rows($arr_res1);
    echo $arr_num;
    
    
    
    $arr_res2 = mysql_query("SELECT time_format(时间, '%H:%i'),播放类型,票价,编号 FROM movie_arrangement_tomorrow 
    					WHERE 片名='$_GET[movie_tomorrow]' AND 影院='$user_name' ORDER BY time_format(时间, '%H:%i') ASC");

    while($arr_row2 = mysql_fetch_array($arr_res2))
    {
    	echo "|<tr><td><a href='javascript:;' onclick='reservation_tomorrow2($arr_row2[3])' style='font-family:微软雅黑' >
                    		$arr_row2[0]&nbsp($arr_row2[1]-票价:$arr_row2[2]元)</a></td></tr>";
    }
    
    $res_num = $_GET["num_tomorrow"];
    $res_res1 = mysql_query("SELECT 片名,播放类型,time_format(时间, '%H:%i'),票价 FROM movie_arrangement_tomorrow WHERE 编号='$res_num'",$con);
    $res_row1 = mysql_fetch_array($res_res1);
    $time = "$res_row1[2]:00";
    $res_res2 = mysql_query("SELECT 姓名,联系电话,座位,编号 FROM reservation_list WHERE 片名='$res_row1[0]' AND 影院='$user_name' AND 播放类型='$res_row1[1]' AND 日期='明天' AND 时间='$time'",$con);

    
    echo "|<table width='400' style='margin-left:50px;text-align:center;'><tr><td><font color='#D94600'>$res_row1[0]&nbsp&nbsp$res_row1[2]&nbsp($res_row1[1]-票价:$res_row1[3]元)</font></td></tr></table>
          <table id='res_table' width='360' border='1' cellspacing='2' cellpadding='2' style='margin-left:70px'>
          <tr><th scope='col' style='text-align:center;width:80px'>预约人</th>
              <th scope='col' style='text-align:center;width:130px'>联系电话</th>
              <th scope='col' style='text-align:center;width:90px'>座位</th>
              <th scope='col' style='text-align:center;width:60px'>操作</th></tr>";
    
    while($res_row2 = mysql_fetch_array($res_res2))
    {
        echo "<tr><td style='text-align:center;'>$res_row2[0]</td>
        			<td style='text-align:center;'>$res_row2[1]</td>
                    <td style='text-align:center;'>$res_row2[2]</td>
                    <td style='text-align:center;'><a href='javascript:;' target='_self' onclick='reservation_tomorrow3($res_row2[3])' style='font-family:微软雅黑' >[删除]</a></td></tr>";
    }
    echo "</table>";
}

mysql_close($con);

?>