<!DOCTYPE HTML>
<html>
    <head>
    <title>影院列表</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <!-- start plugins -->

    <link href='http://fonts.useso.com/css?family=Roboto+Condensed:100,200,300,400,500,600,700,800,900' rel='stylesheet' type='text/css'>
    </head>

    <body>
<div class="container">
      <div class="container_wrap">
    <div class="header_top">
          <div class="col-sm-3 logo"><img src="images/logo.png" alt=""/></div>
        </div>
    <img src="images/background.jpg" class="img-responsive" height="50" alt=""/>
    <div class="content">
		<form name="cinemaList" action="cinemaList.php" method="post">
        <?php
			error_reporting(0);
			session_start();
			
			$user_name=$_SESSION['用户名'];
			echo "<img src='images/logo1.png' alt=''/>";
			echo "<font style='font-family:方正姚体;font-size:20px'>欢迎，$user_name</font>"; 
			echo "&nbsp&nbsp<a href='modifyPassword.php' style='font-family:微软雅黑' >[修改密码]</a>";
			echo "&nbsp<a href='register.php' style='font-family:微软雅黑' >[注册新用户]</a>";
			echo "&nbsp<a href='login.php' style='font-family:微软雅黑' >[退出]</a>";
			
			echo "<font style='font-family:微软雅黑;font-size:17px;float:right;margin-right:50px' >影院列表</font>";
			echo "<img src='images/logo5.png' style='float:right;margin-right:5px' alt=''/>";
			echo "<a href='movieList.php' style='font-family:微软雅黑;font-size:17px;float:right;margin-right:30px' >电影列表</a>";
			echo "<img src='images/logo6.png' style='float:right;margin-right:5px' alt=''/>";
			echo "<a href='index.php' style='font-family:微软雅黑;font-size:17px;float:right;margin-right:30px'>主页</a>";
			echo "<img src='images/logo7.png' style='float:right;margin-right:5px' alt=''/>";
			echo "<br><br><h1 class='m_2'>>>&nbsp影院列表</h1>";	
		?>
        <div class="content" align="center">
        <font style="font-family:隶书;font-size:36px;">影院列表</font>
        <table width="800" border="1" cellspacing="2" cellpadding="2">
        <tr>
			<th scope="col">影院</th>
            <th scope="col">邮箱</th>
            <th scope="col">联系电话</th>
            <th scope="col">地址</th>

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
				$res=mysql_query("SELECT * FROM user_list",$con);
				
				while($row = mysql_fetch_array($res))
				{
					if($row['管理员权限'] == 0)
					{
						echo "<tr>
    					<td>$row[1]</td>
						<td>$row[3]</td>
						<td>$row[4]</td>
						<td>$row[5]</td>
						</tr>";
					}
				}
			} 
		?>
        </table>
        </div>
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