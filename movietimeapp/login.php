<!DOCTYPE HTML>
<html>
    <head>
    <title>登录</title>
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
        
		// Function to judge name by ajax.
        function login1(txt)
        {  
            loadXMLDoc("./userSql.php?name="+txt+"&login="+1,function()
            {	
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    document.getElementById("checkName").innerHTML=xmlhttp.responseText;
                }
            }); 
        }
		
		// Function to check all information again by ajax
		function login2()
		{
			var name = document.login.name.value;
			var password = document.login.password.value;
			var xmlhttp;
			var url = "./userSql.php";
			var url = "./userSql.php?name="+name+"&password="+password+"&login="+2;
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
					if(xmlhttp.responseText.indexOf("登录成功！")>-1)
					{
						window.location.assign("index.php");
                        alert("登录成功！"); 
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
    <div class="content" align=center>
        <form name="login" action="login.php" method="post">
        <br>
        <label>
        <h1 style="color:#CE0000;font-family:华文隶书">Movie Time 管理系统</h1>
        </label>
        <br>
        <br>
        用户名：
        <input name="name" type="text" style="width:250px;height:30px" onblur="login1(this.value)" />
        <br>
        <span id="checkName" style="color:#FF0000"></span><br>
        <br>
        密&nbsp&nbsp&nbsp码：
        <input name="password" type="password" style="width:250px;height:30px" />
        <br>
        <br>
        <span id="checkInfo" style="color:#FF0000"></span>
        <br>
        <button type="button" class="btn btn-primary"  style="float:center;width:100px" onclick="login2()" />
        登&nbsp&nbsp&nbsp录
        </button>
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