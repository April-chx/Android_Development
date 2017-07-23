<!DOCTYPE HTML>
<html>
<head>
<title>主页</title>
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
	
	function index1()
	{  	  
		document.getElementById("changeText").disabled=false;   
	}
	function index2()
	{
		document.getElementById("changeText").disabled=true;
		
		var textarea = document.index.textarea.value;
		var url = "./userSql.php";
		var url = "./userSql.php?textarea="+textarea+"&index="+1;
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
				if(xmlhttp.responseText.indexOf("修改成功！")>-1)
				{
			 		document.getElementById("checkChange").innerHTML=xmlhttp.responseText; 
		   		}
			}
		}
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
      <form name="index" action="index.php" method="post">
        <?php
			error_reporting(0);
			session_start();
			
			$user_name=$_SESSION['用户名'];
			echo "<img src='images/logo1.png' alt=''/>";
			echo "<font style='font-family:方正姚体;font-size:20px'>欢迎，$user_name</font>";  
						
			$con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
			if (!$con)
			{
				die('连接失败:' . mysql_error());
			}
			else
			{
				mysql_select_db(SAE_MYSQL_DB, $con);
				mysql_query("SET NAMES utf8");
				$res=mysql_query("SELECT 管理员权限 FROM user_list WHERE 用户名='$user_name'",$con);
				$res_noti=mysql_query("SELECT * FROM notification",$con);
				$row=mysql_fetch_array($res);
				$row_noti=mysql_fetch_array($res_noti);
				
				if($row[0] == 1)
				{
                    echo "&nbsp&nbsp<a href='modifyPassword.php' style='font-family:微软雅黑' >[修改密码]</a>";
                    echo "&nbsp<a href='register.php' style='font-family:微软雅黑' >[注册新用户]</a>";
                    echo "&nbsp<a href='login.php' style='font-family:微软雅黑' >[退出]</a>";
					echo "<a href='cinemaList.php' style='font-family:微软雅黑;font-size:17px;float:right;margin-right:50px' >影院列表</a>";
					echo "<img src='images/logo5.png' style='float:right;margin-right:5px' alt=''/>";
					echo "<a href='movieList.php' style='font-family:微软雅黑;font-size:17px;float:right;margin-right:30px' >电影列表</a>";
					echo "<img src='images/logo6.png' style='float:right;margin-right:5px' alt=''/>";
					echo "<font style='font-family:微软雅黑;font-size:17px;float:right;margin-right:30px'>主页</font>";
					echo "<img src='images/logo7.png' style='float:right;margin-right:5px' alt=''/>";
				}
				else
				{
                    echo "&nbsp&nbsp<a href='login.php' style='font-family:微软雅黑' >[退出]</a>";
					echo "<a href='reservation.php' style='font-family:微软雅黑;font-size:17px;float:right;margin-right:50px'>预约管理</a>";
        			echo "<img src='images/logo4.png' style='float:right;margin-right:5px' alt=''/>";
        			echo "<a href='arrangement.php' style='font-family:微软雅黑;font-size:17px;float:right;margin-right:30px'>排片管理</a>";
					echo "<img src='images/logo3.png' style='float:right;margin-right:5px' alt=''/>";
					echo "<a href='cinemaInfo.php' style='font-family:微软雅黑;font-size:17px;float:right;margin-right:30px'>影院资料</a>";
					echo "<img src='images/logo2.png' style='float:right;margin-right:5px' alt=''/>";
					echo "<font style='font-family:微软雅黑;font-size:17px;float:right;margin-right:30px'>主页</font>";
					echo "<img src='images/logo7.png' style='float:right;margin-right:5px' alt=''/>";		
				}
			}
			mysql_close($con);
		?>
        <div class="content" align="center"> <font style="font-family:隶书;font-size:40px;" color="#333366">通&nbsp&nbsp&nbsp知</font><br>
        <?php
      	echo "<textarea id='changeText' name='textarea' style='width:800px;height:300px;font-family:黑体;font-size:20px;' disabled='disabled'>$row_noti[0]</textarea><br><br>";
	  	if($row[0] == 1)
	  	{
            echo "<span id='checkChange' style='color:#FF0000'></span><br>";
			echo "<button type='button' class='btn btn-primary' style='margin-right:50px;width:70px' onclick='index1()' />修改</button>";
        	echo "<button type='button' class='btn btn-default float_r' style='margin-left:50px;width:70px' onclick='index2()' />确定</button>";
	  	}
	  ?>
        </div>
      </form>
    </div>
    <div class="clearfix"> </div>
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