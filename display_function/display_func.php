<?php
	function do_index_header() {
?>		
<html>
<head>
<title>牛B的第一次尝试 ！  碉堡了！</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<meta name="Keywords" content="在搜索引擎上， 搜索这句话能查到"/>
<meta name="Description" content="也是为了查询 估计"/>

<meta HTTP-EQUIV="Pragma" CONTENT="no-cache" />
<meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache" />
<meta HTTP-EQUIV="Expires" CONTENT="0" />
<script type="text/javascript" src="../javascript/main.js"></script>
<script type="text/javascript" src="../javascript/jquery.min.js"></script>
<script type="text/javascript" src="../javascript/jquery.cycle.all.latest.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
        $(".slideshow").cycle({ fx: "scrollLeft" });
    });
</script>
</head>

<body>

<div id="container" style="width:1200; margin-left: auto; margin-right: auto">

<div id="header" style="background-image: padding: 0; margin: 0; width: 100%; ">
	<div style="width: 100%; height: 25; float: left; background-color: white"></div>
	<div style="width: 400; height: 100; float: left; background-color: green">
	<a href="test.php"><img alt="" src="../img/logo.jpg"></a></div>
	<div style="width: 200; height: 100; float: left; background-color: yellow">
	<a href="test.php"><img alt="" src="../img/shouye.jpg"></a></div>
	<div style="width: 200; height: 100; float: left; background-color: blue">
	<a href="http://www.google.com"><img alt="" src="../img/aboutus.jpg"></a></div>
	<div style="width: 200; height: 100; float: left; background-color: pink">
	<a href="http://www.google.com"><img alt="" src="../img/fahuo.jpg"></a></div>
	<div style="width: 200; height: 100; float: left; background-color: black">
	<a href="http://www.google.com"><img alt="" src="../img/contact.jpg"></a></div>
</div>

<div id="ads" style="background-color:grey; width:100%; float:left;">
	<div class="slideshow" id="ad1" style="background-color: grey; width: 798; height: 300; float: left; margin-right: 2px;">
		<a href="http://www.google.com"><img alt="" src="../img/slideshow1.jpg" width="800" height="300"></a>
		<a href="http://www.baidu.com"><img alt="" src="../img/slideshow2.jpg" width="800" height="300"></a>
		<a href="http://www.iit.edu"><img alt="" src="../img/slideshow3.jpg" width="800" height="300"></a>
	</div>
	<div id="ad2" style="background-color: #ffd755; width: 400; height: 300; float: left">
		<a href="http://my.iit.edu"><img alt="" src="../img/ad2.jpg"></a>
	</div>
</div>

<div id="todo" style="background-color:#EEEEEE;height:300px; width:100%; float:left;">
	<div id="login" style="background-color: peach; width: 400; height: 300; float: left">
		<div></div>
	</div>
	<div id="news" style="background-color: silver; width: 400; height: 300; float: left"></div>
	<div id="track" style="background-color: grey; width: 400; height: 300; float: left"></div>
</div>

<div id="footer" style="background-color: blue; clear:both; text-align:center;">
	<div id="link1" style="background-color: red; width: 200; height: 100; float: left"></div>
	<div id="link1" style="background-color: blue; width: 200; height: 100; float: left"></div>
	<div id="link1" style="background-color: yellow; width: 200; height: 100; float: left"></div>
	<div id="link1" style="background-color: green; width: 200; height: 100; float: left"></div>
	<div id="link1" style="background-color: peach; width: 200; height: 100; float: left"></div>
	<div id="link1" style="background-color: purple; width: 200; height: 100; float: left"></div>

</div>

</div>
 
</body>
</html>

	
	
<?php 
}
?>
	