<?php
	include("db.php");

	$login_cookie = $_COOKIE['login'];

	$infoo = mysql_query("SELECT * FROM users WHERE email='$login_cookie'");
	$info = mysql_fetch_assoc($infoo);

	$id = $_GET['from'];

	$tudo = mysql_query("SELECT * FROM users WHERE id='$id'");
	$saber = mysql_fetch_assoc($tudo);

	$email = $saber['email'];

	$sql = mysql_query("SELECT * FROM mensagens WHERE para='$login_cookie' AND de='$email' OR de='$login_cookie' AND para='$email'");

	$mysql = "UPDATE mensagens SET status=1 WHERE para='$login_cookie' AND de='$email'";
	$update = mysql_query($mysql);
?>
<html>
<head>
    <meta http-equiv="refresh" content="5;">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<style type="text/css">
		html{
			-webkit-animation: fadein 0s;
			-moz-animation: fadein 0s;
			-ms-animation: fadein 0s;
			-o-animation: fadein 0s;
			animation: fadein 0s;
		}

		body{
			z-index: 100;
		}

		.bubble{
			position: relative;
			margin-left: 300px;
			width: 50%;
			min-height: 120px;
			padding: 0px;
			background: #007fff;
			border-radius: 20px 20px 0px 20px;
		}
		.bubble span{display: block; margin-left: auto; font-size: 18px;margin-left: 30px; color: #FFF;}
		.bubble img{display: block; margin: auto; max-width: 95%;}
		.bubble p{display: block; margin: auto; font-size: 16px; text-align: center; color: #FFF;}

		.bubble2{
			position: relative;
			width: 50%;
			min-height: 120px;
			
			background: #CCC;
			border-radius: 20px 20px 20px 0px;
		}
		.bubble2 span{display: block; margin-left: auto; font-size: 18px; margin-left: 30px; color: #333;}
		.bubble2 img{display: block; margin: auto; max-width: 95%;}
		.bubble2 p{display: block; margin: auto; font-size: 16px; text-align: center; color: #333;}
	</style>
</head>
<body>
	<div class="container">
	<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6 col-xs-12">
	<?php
		while ($msg=mysql_fetch_assoc($sql)) {
			if ($msg['de']==$login_cookie) {
				if ($msg["imagem"]=="") {
					echo '<div class="bubble">
						<br />
						<span name="msg1">'.$msg["texto"].'</span>
						<br /><br />
						<p>'.$msg["data"].'</p>
						<br />
					</div><br />';
				}else{
					echo '<div class="bubble">
						<br />
						<span name="msg1">'.$msg["texto"].'</span>
						<br />
						<img src="upload/'.$msg["imagem"].'" />
						<br />
						<p>'.$msg["data"].'</p>
						<br />
					</div><br />';
				}
			}else{
				if ($msg["imagem"]=="") {
					echo '<div class="bubble2">
						<br />
						<span name="msg1">'.$msg["texto"].'</span>
						<br /><br />
						<p>'.$msg["data"].'</p>
						<br />
					</div><br />';
				}else{
					echo '<div class="bubble2">
						<br />
						<span name="msg1">'.$msg["texto"].'</span>
						<br />
						<img src="upload/'.$msg["imagem"].'" />
						<br />
						<p>'.$msg["data"].'</p>
						<br />
					</div><br />';
				}
			}
		}
	?>
	<a href="#" id="bottom"></a>
	</div>
	<div class="col-md-3"></div>
	</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>