<!DOCTYPE HTML>
<html>
<head>
<title>注册</title>
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
	
	// Function to judge user name by ajax.
	function userinfo1(txt) 
	{  
		loadXMLDoc("./userSql.php?name="+txt+"&register="+1,function()
		{	
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById("checkName").innerHTML=xmlhttp.responseText;
			}
		}); 
	}
	
	// Function to judge password by ajax.
	function userinfo2(txt) 
	{  
		loadXMLDoc("./userSql.php?password1="+txt+"&register="+2,function()
		{	
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById("checkPassword1").innerHTML=xmlhttp.responseText;
			}
		}); 
	}
	
	// Function to judge password again by ajax.
	function userinfo3(txt) 
	{  
		var password1=document.getElementById("password1").value;
	
		loadXMLDoc("./userSql.php?password2="+txt+"&password1="+password1+"&register="+3,function()
		{	
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById("checkPassword2").innerHTML=xmlhttp.responseText;
			}
		}); 
	}
	
	// Function to judge email by ajax.
	function userinfo4(txt)
	{  
		loadXMLDoc("./userSql.php?email="+txt+"&register="+4,function()
		{	
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById("checkEmail").innerHTML=xmlhttp.responseText;
			}
		}); 
	}
	
	// Function to submit register information or judge infomation by ajax.
	function userinfo5() 
	{
		var name = document.register.name.value;
		var password1 = document.register.password1.value;
		var password2 = document.register.password2.value;
		var email = document.register.email.value;
		var phone = document.register.phone.value;
		var address = document.register.address.value;
		var xmlhttp;
		var url = "./userSql.php";
		var url = "./userSql.php?name="+name+"&password1="+password1+"&password2="+password2+"&email="+email+"&phone="+phone+"&address="+address+"&register="+5;
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
				if(xmlhttp.responseText.indexOf("注册成功！")>-1)
				{
			 		window.location.assign("index.php"); 
                    alert("注册成功！"); 
		   		}
		   		else
		   		{ 	   		
					document.getElementById("checkInfo").innerHTML=xmlhttp.responseText;
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
		<form name="register" action="register.php" method="post">
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
			echo "<a href='movieList.php' style='font-family:微软雅黑;font-size:17px;float:right;margin-right:30px' >电影列表</a>";
			echo "<img src='images/logo6.png' style='float:right;margin-right:5px' alt=''/>";
			echo "<a href='index.php' style='font-family:微软雅黑;font-size:17px;float:right;margin-right:30px'>主页</a>";
			echo "<img src='images/logo7.png' style='float:right;margin-right:5px' alt=''/>";
			echo "<br><br><h1 class='m_2'>>>&nbsp注册新用户</h1>";	
		?>
    <div class="content" align="center">
      <br>
      <br>
      <form name="register" action="register.php" method="post">
        <font style="font-size:15px;margin-right:130px;" >用户名(请输入影院名)：</font><br>
        <input name="name" type="text" style="width:300px;height:35px;margin-left:70px;" onblur="userinfo1(this.value)" />
        <br>
        <span id="checkName" style="color:#FF0000"></span><br>
        <font style="font-size:15px;margin-right:245px;" >密码：</font><br>
        <input name="password1" type="password" id="password1" style="width:300px;height:35px;margin-left:70px;" onblur="userinfo2(this.value)" />
        <br>
        <span id="checkPassword1" style="color:#FF0000;"></span><br>
        <font style="font-size:15px;margin-right:220px;" >确认密码：</font><br>
        <input name="password2" type="password" style="width:300px;height:35px;margin-left:70px;" onblur="userinfo3(this.value)" />
        <br>
        <span id="checkPassword2" style="color:#FF0000;"></span><br>
        <font style="font-size:15px;margin-right:245px;" >邮箱：</font><br>
        <input name="email" type="text" style="width:300px;height:35px;margin-left:70px;" onblur="userinfo4(this.value)" />
        <br>
        <span id="checkEmail" style="color:#FF0000;"></span><br>
        <font style="font-size:15px;margin-right:220px;" >联系电话：</font><br>
        <input type="text" name="phone" style="width:300px;height:35px;margin-left:70px;" />
        <br>
        <br>
        <font style="font-size:15px;margin-right:245px;" >地址：</font><br>
        <textarea type="text" name="address" style="width:300px;height:80px;margin-left:70px;" ></textarea>
        <br>
        <br>
        <span id="checkInfo" style="color:#FF0000;"></span><br>
        <button type="button" class="btn btn-primary" style="margin-left:50px;width:70px" onclick="userinfo5()" />
        提交
        </button>
        <button type="button" class="btn btn-default float_r" style="margin-left:50px;width:70px" onclick="location.href='index.php';" />
        取消
        </button>
      </form>
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