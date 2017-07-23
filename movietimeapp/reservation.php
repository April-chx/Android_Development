<!DOCTYPE HTML>
<html>
<head>
<title>预约管理</title>
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
	
		function reservation1()
		{     
            var showToday = document.reservation.showToday.value;
            var table = document.getElementById("table");
            var info = showToday.split("|");                     
            var rowNum=table.rows.length;
            
            document.getElementById("add_table").innerHTML = "";
            document.getElementById("poster").src=info[0];
            document.cookie = 'movie_num =' + null;
            
            for ( i=1; i<rowNum; i++ )
            {
            	table.deleteRow(i);
            	rowNum=rowNum-1;
            	i=i-1;
            }
            
            loadXMLDoc("./userSql.php?movie="+info[1]+"&reservation="+1,function()
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
    
    	function reservation2(num)
		{
            document.cookie = 'movie_num =' + num;
            loadXMLDoc("./userSql.php?num="+num+"&reservation="+2,function()
            {	
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {	      
                    document.getElementById("add_table").innerHTML = xmlhttp.responseText;
            	}
            });
        }
    
    	function reservation3(reservation_num,movie_num)
		{
            r_selectIndex = document.getElementById("showToday").selectedIndex;  
            document.cookie = 'r_selectIndex =' + r_selectIndex;
            
        	loadXMLDoc("./userSql.php?num="+reservation_num+"&reservation="+3,function()
            {	
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {	      
                    window.location.assign("reservation.php");
                    alert("删除预约成功！"); 
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
        		document.getElementById("showToday").options[json.r_selectIndex].selected = true;  
                
           		var showToday=document.reservation.showToday.value;
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
            
            	loadXMLDoc("./userSql.php?movie="+info[1]+"&num="+json.movie_num+"&reservation="+4,function()
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
                        
                        document.getElementById("add_table").innerHTML = table_info[length+1];                       
            		}
            	});    
        	}  
        	else  
        		window.location.assign("reservation.php");
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
      <form name="reservation" action="reservation.php" method="post">
        <?php
			error_reporting(0);
			session_start();
			
			$user_name=$_SESSION['用户名'];
			echo "<img src='images/logo1.png' alt=''/>";
			echo "<font style='font-family:方正姚体;font-size:20px'>欢迎，$user_name</font>";  
			echo "&nbsp&nbsp<a href='login.php' style='font-family:微软雅黑' >[退出]</a>";
			
			echo "<font style='font-family:微软雅黑;font-size:17px;float:right;margin-right:50px'>预约管理</font>";
        	echo "<img src='images/logo4.png' style='float:right;margin-right:5px' alt=''/>";
        	echo "<a href='arrangement.php' style='font-family:微软雅黑;font-size:17px;float:right;margin-right:30px'>排片管理</a>";
			echo "<img src='images/logo3.png' style='float:right;margin-right:5px' alt=''/>";
			echo "<a href='cinemaInfo.php' style='font-family:微软雅黑;font-size:17px;float:right;margin-right:30px'>影院资料</a>";
			echo "<img src='images/logo2.png' style='float:right;margin-right:5px' alt=''/>";
			echo "<a href='index.php' style='font-family:微软雅黑;font-size:17px;float:right;margin-right:30px'>主页</a>";
			echo "<img src='images/logo7.png' style='float:right;margin-right:5px' alt=''/>";
			echo "<br><br><h1 class='m_2'>>>&nbsp预约管理</h1>
            		<font style='font-family:微软雅黑;font-size:16px;margin-left:70px'>今日预约</font>
                    <font style='font-size:17px'>&nbsp&nbsp|&nbsp&nbsp</font>
                    <a href='reservation_tomorrow.php' style='font-family:微软雅黑;font-size:16px;'>明日预约</a><br><br>";	
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
                
                
                echo "<font style='margin-left:210px'>今日播放：</font>
                <select name='showToday' id='showToday' onchange='reservation1()'>";
                
                $res=mysql_query("SELECT DISTINCT 片名 FROM movie_arrangement_today WHERE 影院='$user_name'",$con);
    
				while($row=mysql_fetch_array($res))
                {
                    $res_select=mysql_query("SELECT 海报 FROM movie_list WHERE 片名='$row[0]'",$con);
                    $row_select=mysql_fetch_array($res_select);
                    echo "<option value='submissions/$row_select[0]|$row[0]' >$row[0]</option>";                    
                }
                echo "</select><br><br>";
                
                echo "<div class='register-top-grid'><div><div><img id='poster' style='width:120px;margin-left:250px' src='submissions/$row_poster[0]'/><br><br><br></div>";
                
                $sql_first=mysql_query("SELECT time_format(时间, '%H:%i'),播放类型,票价,编号 FROM movie_arrangement_today 
                						WHERE 片名='$row_first[0]' AND 影院='$user_name' ORDER BY time_format(时间, '%H:%i') ASC",$con);
                
                echo "<div><table id='table' width='180' style='margin-left:150px'><tr>
                		<th scope='col'>播放时间：</th></tr>";
                while($row_info_first=mysql_fetch_array($sql_first))
            	{
                    echo "<tr><td><a href='javascript:;' onclick='reservation2($row_info_first[3])' style='font-family:微软雅黑' >
                    		$row_info_first[0]&nbsp($row_info_first[1]-票价:$row_info_first[2]元)</a></td></tr>";
            	}
                echo "</table></div></div><div id='add_table'></div><div class='clearfix'></div></div>";
            }
		?>
          <div class="register-bottom-grid"></div>
        <div class="clearfix"> </div>
      </form>
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