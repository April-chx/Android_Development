<!DOCTYPE HTML>
<html>
    <head>
    <title>今日排片管理</title>
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
        
		function arrangement1()
		{     
            var showToday = document.arrangement.showToday.value;
            var table = document.getElementById("table");
            var info = showToday.split("|");                     
            var rowNum=table.rows.length;
            
            document.getElementById("poster").src=info[0];
            
            for ( i=1; i<rowNum; i++ )
            {
            	table.deleteRow(i);
            	rowNum=rowNum-1;
            	i=i-1;
            }
            
            loadXMLDoc("./userSql.php?movie="+info[1]+"&arrangement="+1,function()
            {	
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {	               
                    var response = xmlhttp.responseText;
                    var table_info = response.split("|");
            		var length=parseInt(table_info[0]);
           	     

                	for(i=1; i<=length; i++)
                	{
                    	var table_tr = table.insertRow(-1);
                    	document.getElementsByTagName("tr")[i].innerHTML=table_info[i];
            		}
            	}
            });
        }
        
        function arrangement2(num)
        {
            selectIndex = document.getElementById("showToday").selectedIndex;  
            document.cookie = 'selectIndex =' + selectIndex;

            loadXMLDoc("./userSql.php?num="+num+"&arrangement="+2,function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    window.location.assign("arrangement.php");
                }
            });	
        }
        
        function arrangement3()
        {
            var start_time = document.arrangement.start_time.value;
            var show_type = document.arrangement.show_type.value;
            var ticket_price = document.arrangement.ticket_price.value;
            var showToday = document.arrangement.showToday.value;
            var info = showToday.split("|");  
            
            selectIndex = document.getElementById("showToday").selectedIndex;  
            document.cookie = 'selectIndex =' + selectIndex;
            
            loadXMLDoc("./userSql.php?movie="+info[1]+"&start_time="+start_time+"&show_type="+show_type+"&ticket_price="+ticket_price+"&arrangement="+3,function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    window.location.assign("arrangement.php");
                }
            });
        }
        
        function arrangement4()
        {
            var new_movie = document.arrangement.new_movie.value;
            var new_start_time = document.arrangement.new_start_time.value;
            var new_show_type = document.arrangement.new_show_type.value;
            var new_ticket_price = document.arrangement.new_ticket_price.value;
            
            selectIndex = document.getElementById("showToday").selectedIndex;  
            document.cookie = 'selectIndex =' + selectIndex;
            
            loadXMLDoc("./userSql.php?new_movie="+new_movie+"&new_start_time="+new_start_time+"&new_show_type="+new_show_type+"&new_ticket_price="+new_ticket_price+"&arrangement="+4,function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    window.location.assign("arrangement.php");
                }
            });
            
        }
        
        function arrangement5()
        {
            var showToday = document.arrangement.showToday.value;
            var info = showToday.split("|");   
            
            loadXMLDoc("./userSql.php?movie="+info[1]+"&arrangement="+5,function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    window.location.assign("arrangement.php");
                }
            });
        }
        
        window.onload = function () 
        {  
        	var cooki = document.cookie;  
        	if (cooki != "") 
        	{  
        		cooki = "{\"" + cooki + "\"}";  
        		cooki = cooki.replace(/\s*/g, "").replace(/=/g, '":"').replace(/;/g, '","'); 
                
       			var json = eval("(" + cooki + ")"); //将coolies转成json对象  
        		document.getElementById("showToday").options[json.selectIndex].selected = true;  
                
           		var showToday=document.arrangement.showToday.value;
                var table = document.getElementById("table");
            	var info = showToday.split("|");
            	var rowNum=table.rows.length;
                
                document.getElementById("poster").src=info[0];
                
            	for ( i=1; i<rowNum; i++ )
            	{
            		table.deleteRow(i);
            		rowNum=rowNum-1;
            		i=i-1;
            	}
            
            	loadXMLDoc("./userSql.php?movie="+info[1]+"&arrangement="+1,function()
            	{	
                	if (xmlhttp.readyState==4 && xmlhttp.status==200)
                	{	
                    	var response = xmlhttp.responseText;
                    	var table_info = response.split("|");
            			var length=parseInt(table_info[0]);

                		for(i=1; i<=length; i++)
                		{
                    		var table_tr = table.insertRow(-1);
                    		document.getElementsByTagName("tr")[i].innerHTML=table_info[i];
            			}
            		}
            	});                        
        	}  
        	else  
        		window.location.assign("arrangement.php");
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
        <form name="arrangement" action="arrangement.php" method="post">
        <?php
			error_reporting(0);
			session_start();
			
			$user_name=$_SESSION['用户名'];
			echo "<img src='images/logo1.png' alt=''/>";
			echo "<font style='font-family:方正姚体;font-size:20px'>欢迎，$user_name</font>";  
			echo "&nbsp&nbsp<a href='login.php' style='font-family:微软雅黑' >[退出]</a>";
			
			echo "<a href='reservation.php' style='font-family:微软雅黑;font-size:17px;float:right;margin-right:50px'>预约管理</a>";
        	echo "<img src='images/logo4.png' style='float:right;margin-right:5px' alt=''/>";
        	echo "<font style='font-family:微软雅黑;font-size:17px;float:right;margin-right:30px'>排片管理</font>";
			echo "<img src='images/logo3.png' style='float:right;margin-right:5px' alt=''/>";
			echo "<a href='cinemaInfo.php' style='font-family:微软雅黑;font-size:17px;float:right;margin-right:30px'>影院资料</a>";
			echo "<img src='images/logo2.png' style='float:right;margin-right:5px' alt=''/>";
			echo "<a href='index.php' style='font-family:微软雅黑;font-size:17px;float:right;margin-right:30px'>主页</a>";
			echo "<img src='images/logo7.png' style='float:right;margin-right:5px' alt=''/>";
			echo "<br><br><h1 class='m_2'>>>&nbsp排片管理</h1>
            		<font style='font-family:微软雅黑;font-size:16px;margin-left:70px'>今日排片</font>
                    <font style='font-size:17px'>&nbsp&nbsp|&nbsp&nbsp</font>
                    <a href='arrangement_tomorrow.php' style='font-family:微软雅黑;font-size:16px;'>明日排片</a>";	
			echo "<font style='margin-left:100px'>添加新片：</font>
                	<input name='new_movie' type='text' value='片名' style='width:200px;height:25px;font-style:italic;color:#7B7B7B' onfocus=this.value=''; onblur=if (this.value == '') {this.value ='';}>
                    <input name='new_start_time' type='text' value='时间' style='width:60px;height:25px;font-style:italic;color:#7B7B7B' onfocus=this.value=''; onblur=if (this.value == '') {this.value ='';}>
                	<input name='new_show_type' type='text' value='播放类型' style='width:100px;height:25px;font-style:italic;color:#7B7B7B' onfocus=this.value=''; onblur=if (this.value == '') {this.value ='';}>
                	<input name='new_ticket_price' type='text' value='票价' style='width:60px;height:25px;font-style:italic;color:#7B7B7B' onfocus=this.value=''; onblur=if (this.value == '') {this.value ='';}>
                    <a href='javascript:;' onclick='arrangement4()' style='margin-left:5px;font-family:微软雅黑' >[添加]</a><br><br><br>";
			?>
            
		<?php
			$con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);

			if (!$con)
			{
				die('连接失败:' . mysql_error());
			}
			else
			{
				mysql_select_db(SAE_MYSQL_DB, $con);
				mysql_query("SET NAMES utf8");
				
                $res_temp=mysql_query("SELECT DISTINCT 片名 FROM movie_arrangement_today WHERE 影院='$user_name'",$con);
                $row_first=mysql_fetch_array($res_temp);
                $res_first=mysql_query("SELECT 海报 FROM movie_list WHERE 片名='$row_first[0]'",$con);
                $row_poster=mysql_fetch_array($res_first);
                
                
                echo "<font style='margin-left:200px'>今日播放：</font>
                <select name='showToday' id='showToday' onchange='arrangement1()'>";
                
                $res=mysql_query("SELECT DISTINCT 片名 FROM movie_arrangement_today WHERE 影院='$user_name'",$con);
    
				while($row=mysql_fetch_array($res))
                {
                    $res_select=mysql_query("SELECT 海报 FROM movie_list WHERE 片名='$row[0]'",$con);
                    $row_select=mysql_fetch_array($res_select);
                    echo "<option value='submissions/$row_select[0]|$row[0]' >$row[0]</option>";                    
                }
                echo "</select><a href='javascript:;' onclick='arrangement5()' style='margin-left:10px;font-family:微软雅黑' >[删除该片]</a><br><br>";
                
                echo "<div class='register-top-grid'><div><img id='poster' style='width:150px;margin-left:265px' src='submissions/$row_poster[0]'/></div>";

				$sql_first=mysql_query("SELECT time_format(时间, '%H:%i'),播放类型,票价,编号 FROM movie_arrangement_today 
                						WHERE 片名='$row_first[0]' AND 影院='$user_name' ORDER BY time_format(时间, '%H:%i') ASC",$con);

                echo "<div><table id='table' width='300' border='1' cellspacing='2' cellpadding='2' style='margin-left:20px'><tr>
                		<th scope='col'style='text-align:center;'>时间</th>
            			<th scope='col'style='text-align:center;'>播放类型</th>
            			<th scope='col'style='text-align:center;'>票价</th>
                    	<th scope='col'style='text-align:center;'>操作</th></tr>";
                    
                while($row_info_first=mysql_fetch_array($sql_first))
            	{
                    echo "<tr><td style='text-align:center;'>$row_info_first[0]</td>
						<td style='text-align:center;'>$row_info_first[1]</td>
						<td style='text-align:center;'>$row_info_first[2]</td>
                        <td style='text-align:center;'><a href='javascript:;' onclick='arrangement2($row_info_first[3])' style='font-family:微软雅黑' >[删除]</a></td></tr>";
            	}
                echo "</table><br>";
                
                echo "<font>添加场次：</font>
                <input name='start_time' type='text' value='时间' style='width:60px;height:25px;font-style:italic;color:#7B7B7B' onfocus=this.value=''; onblur=if (this.value == '') {this.value ='';}>
                <input name='show_type' type='text' value='播放类型' style='width:100px;height:25px;font-style:italic;color:#7B7B7B' onfocus=this.value=''; onblur=if (this.value == '') {this.value ='';}>
                <input name='ticket_price' type='text' value='票价' style='width:60px;height:25px;font-style:italic;color:#7B7B7B' onfocus=this.value=''; onblur=if (this.value == '') {this.value ='';}>
                <a href='javascript:;' onclick='arrangement3()' style='margin-left:5px;font-family:微软雅黑' >[添加]</a></div><div class='clearfix'> </div></div>";
            }
			?>
           <div class="register-bottom-grid">
            </div>
            <div class="clearfix"> </div>
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