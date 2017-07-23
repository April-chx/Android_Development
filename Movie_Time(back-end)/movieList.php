<!DOCTYPE HTML>
<html>
    <head>
    <title>电影列表</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <!-- start plugins -->

    <link href='http://fonts.useso.com/css?family=Roboto+Condensed:100,200,300,400,500,600,700,800,900' rel='stylesheet' type='text/css'>
    <script type="text/javascript">
        var xmlhttp;
		
		// Function to initialise the xml obj
        function loadXMLDoc(url,cfunc)
		{  
			// code for IE7+, Firefox, Chrome, Opera, Safari
            if (window.XMLHttpRequest)
			{   
                xmlhttp=new XMLHttpRequest();
            }
			else // code for IE6, IE5
			{
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=cfunc;
            xmlhttp.open("GET",url,true);
            xmlhttp.send();
        }

        function movieList1(num)
        {
             loadXMLDoc("./userSql.php?num="+num+"&movieList="+1,function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    window.location.assign("movieList.php");
                }
            });
        }
		
		// Function to check all information again by ajax
		function movieList2(num,movie_num)
		{
            var path = document.getElementsByName("uploadfile[]")[num].value;
            var uploadfile = getFileName(path);
            var actor = document.getElementsByName("actor[]")[num].value;
            var movie_type = document.getElementsByName("movie_type[]")[num].value;
            var movie_time = document.getElementsByName("movie_time[]")[num].value;
            var introduction = document.getElementsByName("introduction[]")[num].value;
            var xmlhttp;
			var url = "./userSql.php";
            var url = "./userSql.php?movie_num="+movie_num+"&uploadfile="+uploadfile+"&actor="+actor+"&movie_type="+movie_type+"&movie_time="+movie_time+"&introduction="+introduction+"&movieList="+2;
			var xmlhttp = false;
			
			if(window.XMLHttpRequest) 
			{
				xmlhttp = new XMLHttpRequest();
				if (xmlhttp.overrideMimeType) 
				{
					xmlhttp.overrideMimeType("text/xml");
				}
			}
			else if (window.ActiveXObject) 
			{
				try 
				{
					xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				} 
				catch (e) 
				{
					try 
					{
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					} catch (e) {}
				}
			}
			if (!xmlhttp) 
			{
				window.alert("no instance");
				return false;
			}
		   
			xmlhttp.open("GET", url, true);		
			xmlhttp.send();
			xmlhttp.onreadystatechange = function() 
			{
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
				{
					if(xmlhttp.responseText.indexOf("添加成功！")>-1)
					{
						window.location.assign("movieList.php");
					}
					else
					{ 	   		
                        document.getElementById(num).innerHTML=xmlhttp.responseText;
					}
				}
			}
		}
        
        function getFileName(path)
        {
			var pos1 = path.lastIndexOf('/');
			var pos2 = path.lastIndexOf('\\');
			var pos  = Math.max(pos1, pos2);
			if( pos<0 )
				return path;
			else
				return path.substring(pos+1);
		}
    </script>
    </head>

    <body>
<div class="container">
      <div class="container_wrap">
    <div class="header_top">
          <div class="col-sm-3 logo"><img src="images/logo.png" alt=""/></div>
        </div>
    <img src="images/background.jpg" class="img-responsive" height="50" alt=""/>
    <div class="content">
        <form name="movieList" action="movieList.php" method="post">
        <?php
			error_reporting(0);
			session_start();
			
			$user_name=$_SESSION['用户名'];
			echo "<img src='images/logo1.png' alt=''/>";
			echo "<font style='font-family:方正姚体;font-size:20px'>欢迎，$user_name</font>";  
			echo "&nbsp&nbsp<a href='modifyPassword.php' style='font-family:微软雅黑' >[修改密码]</a>";
			echo "&nbsp<a href='register.php' style='font-family:微软雅黑' >[注册新用户]</a>";
			echo "&nbsp<a href='login.php' style='font-family:微软雅黑' >[退出]</a>";
			
			echo "<a href='cinemaList.php' style='font-family:微软雅黑;font-size:17px;float:right;margin-right:50px' >影院列表</a>";
			echo "<img src='images/logo5.png' style='float:right;margin-right:5px' alt=''/>";
			echo "<font style='font-family:微软雅黑;font-size:17px;float:right;margin-right:30px' >电影列表</font>";
			echo "<img src='images/logo6.png' style='float:right;margin-right:5px' alt=''/>";
			echo "<a href='index.php' style='font-family:微软雅黑;font-size:17px;float:right;margin-right:30px'>主页</a>";
			echo "<img src='images/logo7.png' style='float:right;margin-right:5px' alt=''/>";
			echo "<br><br><h1 class='m_2'>>>&nbsp电影列表</h1>";	
		?>
        <div class="content" align="center">
        <font style="font-family:隶书;font-size:36px;">电影列表</font>
        <table width="940" border="1" cellspacing="2" cellpadding="2">
        <tr>
            <th scope="col">海报</th>
			<th scope="col">片名</th>
            <th scope="col">演员</th>
            <th scope="col">影片类型</th>
            <th scope="col">电影时长</th>
            <th scope="col">介绍</th>
            <th scope="col">下映</th>

        </tr>
		<?php
			error_reporting();
			
			// Method to output the pictures that is not approved by administrator
			$con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
			if (!$con)
			{
				die('连接失败:' . mysql_error());
			}
			else
			{
				mysql_select_db(SAE_MYSQL_DB, $con);
				mysql_query("SET NAMES utf8");
				$res=mysql_query("SELECT * FROM movie_list",$con);
				
				while($row = mysql_fetch_array($res))
				{   
					echo "<tr>
                    <td style='text-align:center;width:55px'><img src='submissions/$row[6]' width='50' /></td>
    				<td style='width:90px'>$row[1]</td>
					<td style='width:225px'>$row[2]</td>
					<td style='width:100px'>$row[3]</td>
					<td style='width:65px'>$row[4]</td>
                    <td style='width:345px'><div style='overflow-y:scroll;width:350px;height:70px'>$row[5]</div></td>";
                    
                    $sql_exist1=mysql_query("select 片名 from movie_arrangement_today WHERE 片名='$row[1]'",$con);
                    $sql_exist2=mysql_query("select 片名 from movie_arrangement_tomorrow WHERE 片名='$row[1]'",$con);
                    if(!mysql_num_rows($sql_exist1) && !mysql_num_rows($sql_exist2))
                    {
                        echo "<td style='width:60px'><a href='javascript:;' onclick='movieList1($row[0])' style='font-family:微软雅黑' >[可删除]</a></td>";
                    }
                    else
                    {
                        echo "<td style='width:60px'></td>";
                    }
                    
					echo "</tr>";
				}
			} 
		?>
        </table>
        </div>
			<font style="margin-left:90px">待加入电影：</font><br><br>
            
            <?php
				$num=0;
				$res2=mysql_query("SELECT 编号,片名 FROM temp_movie_list",$con);
				while($row2 = mysql_fetch_array($res2))
                {
                    echo "<table style='margin-left:90px' >
                    	<tr><td style='width:150px'><font style='color:#6A6AFF' >$row2[1]</font></td>
                    		<td><font id='movie_name' name='movie_name' style='font-style:italic;color:#7B7B7B'>上传图片：</font></td>
                    		<td><input type='file' name='uploadfile[]' id='uploadfile[]'></td></tr>
                    	<tr><td></td>
                        	<td valign='top'><font style='font-style:italic;color:#7B7B7B;line-height:40px'>演员介绍：</font></td>
                            <td><textarea id='actor[]' name='actor[]' type='text' style='width:250px;height:60px;margin-top:6px'></textarea></td>
                            <td><font style='font-style:italic;color:#7B7B7B;margin-left:45px' >影片类型：</font>
                            	<input type='text' id='movie_type[]' name='movie_type[]' style='width:200px'><br>
                            	<font style='font-style:italic;color:#7B7B7B;margin-left:45px;'>电影时长：</font>
                                <input type='text' id='movie_time[]' name='movie_time[]' style='width:200px;margin-top:5px'></td>
                                <td valign='bottom'><button type='button' class='btn btn-primary'  style='margin-left:40px;width:70px;' onclick='movieList2($num,$row2[0])' />
                                添&nbsp&nbsp&nbsp&nbsp加</button><br>
                                <span id=$num style='margin-left:40px;color:#FF0000'></span></td></tr></table>
                        <table style='margin-left:240px'>
                        <tr><td valign='top'><font style='font-style:italic;color:#7B7B7B;line-height:40px' >影片介绍：</font></td>
                            <td><textarea id='introduction[]' name='introduction[]' style='width:569px;height:60px;margin-top:6px'></textarea></td></tr></table><br><br>";
                    $num++;
                }
				
			?>
            <?php
/*if(isset($_POST["submit"]))
			{
    			echo "ok";
				$img_name = $_FILES['uploadfile']['name'];
    			move_uploaded_file($_FILES['uploadfile']['tmp_name'],"1/submissions/".$img_name);
			}*/
			?>
           
      </form>
          <br>
          <br>
        </div>
  </div>
    </div>
<div class="container">
      <footer id="footer">
    <div id="footer-3d">
          <div class="gp-container"> <span class="first-widget-bend"></span> </div>
        </div>
    <div id="footer-widgets" class="gp-footer-larger-first-col">
          <div class="gp-container">
        <div class="footer-widget footer-1">
              <div class="wpb_wrapper"> <img src="images/f_logo.png" alt=""/> </div>
              <br>
              <p>————为爱电影的人而生。</p>
              <br/>
              <h6>Copyright 2015 Movie Time. All rights reserved.</h6>
            </div>
        <div class="footer_box">
              <div class="col_1_of_3 span_1_of_3">
            <h3>栏目</h3>
            <ul class="first">
                  <li><a>首页</a></li>
                  <li><a>影院</a></li>
                  <li><a>社区</a></li>
                </ul>
          </div>
              <div class="col_1_of_3 span_1_of_3">
            <h3>信息</h3>
            <ul class="first">
                  <li><a>电影热榜</a></li>
                  <li><a>新片预告</a></li>
                  <li><a>电影周刊</a></li>
                </ul>
          </div>
              <div class="col_1_of_3 span_1_of_3">
            <h3>加入我们</h3>
            <ul class="first">
                  <li><a>联系我们</a></li>
                  <li><a>问题反馈</a></li>
                  <li><a>关于我们</a></li>
                </ul>
          </div>
              <div class="clearfix"> </div>
            </div>
        <div class="clearfix"> </div>
      </div>
        </div>
  </footer>
    </div>
</body>
</html>