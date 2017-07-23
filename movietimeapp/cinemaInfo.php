<!DOCTYPE HTML>
<html>
<head>
<title>影院资料</title>
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
	
	function cinemaInfo1()
	{  	  
		document.getElementById("email").disabled=false;
		document.getElementById("phone").disabled=false;
		document.getElementById("address").disabled=false;
	}
	function cinemaInfo2()
	{  
		document.getElementById("email").disabled=true;
		document.getElementById("phone").disabled=true;
		document.getElementById("address").disabled=true;
		
		var name = document.cinemaInfo.name.value;
		var email = document.cinemaInfo.email.value;
		var phone = document.cinemaInfo.phone.value;
		var address = document.cinemaInfo.address.value;
		var url = "./userSql.php";
		var url = "./userSql.php?name="+name+"&email="+email+"&phone="+phone+"&address="+address+"&cinemaInfo="+1;
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
                    window.location.assign("cinemaInfo.php");
			 		alert("修改成功！"); 
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
      <form name="cinemaInfo" action="cinemaInfo.php" method="post">
        <?php
			error_reporting(0);
			session_start();
			
			$user_name=$_SESSION['用户名'];
			echo "<img src='images/logo1.png' alt=''/>";
			echo "<font style='font-family:方正姚体;font-size:20px'>欢迎，$user_name</font>";  
			echo "&nbsp&nbsp<a href='login.php' style='font-family:微软雅黑' >[退出]</a>";
			
			echo "<a href='reservation.php' style='font-family:微软雅黑;font-size:17px;float:right;margin-right:50px'>预约管理</a>";
        	echo "<img src='images/logo4.png' style='float:right;margin-right:5px' alt=''/>";
        	echo "<a href='arrangement.php' style='font-family:微软雅黑;font-size:17px;float:right;margin-right:30px'>排片管理</a>";
			echo "<img src='images/logo3.png' style='float:right;margin-right:5px' alt=''/>";
			echo "<font style='font-family:微软雅黑;font-size:17px;float:right;margin-right:30px'>影院资料</font>";
			echo "<img src='images/logo2.png' style='float:right;margin-right:5px' alt=''/>";
			echo "<a href='index.php' style='font-family:微软雅黑;font-size:17px;float:right;margin-right:30px'>主页</a>";
			echo "<img src='images/logo7.png' style='float:right;margin-right:5px' alt=''/>";
			echo "<br><br><h1 class='m_2'>>>&nbsp影院资料&nbsp&nbsp&nbsp</h1><a href='modifyPassword.php' style='font-family:微软雅黑' >[修改密码]</a><br><br>";	
			?>
		<div class="content" align="center">
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
				$res=mysql_query("SELECT * FROM user_list WHERE 用户名='$user_name'",$con);
				$row=mysql_fetch_array($res);
			
        		echo "<font style='font-size:15px;margin-right:230px;' >用户名：</font><br>
        <input id='name' name='name' type='text' style='width:300px;height:35px;margin-left:70px;' disabled='disabled' value='$row[1]'/>
        <br><br>
        <font style='font-size:15px;margin-right:245px;' >邮箱：</font><br>
        <input id='email' name='email' type='text' style='width:300px;height:35px;margin-left:70px;'  disabled='disabled'  value='$row[3]'/>
        <br><br>
        <font style='font-size:15px;margin-right:220px;' >联系电话：</font><br>
        <input id='phone' type='text' name='phone' style='width:300px;height:35px;margin-left:70px;' disabled='disabled' value='$row[4]'/>
        <br>
        <br>
        <font style='font-size:15px;margin-right:245px;' >地址：</font><br>
        <textarea id='address' type='text' name='address' style='width:300px;height:80px;margin-left:70px;' disabled='disabled' >$row[5]</textarea>";
			}
		?>
          <br>
          <button type="button" class="btn btn-primary" style="margin-left:50px;width:70px" onclick="cinemaInfo1()" />
          修改
          </button>
          <button type="button" class="btn btn-default float_r" style="margin-left:50px;width:70px" onclick="cinemaInfo2()" />
          确定
          </button>
          <br>
          <br>
      </div>
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