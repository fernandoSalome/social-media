<?php
	include("header.php");

	$id = $_GET["from"];

	$tudo = mysql_query("SELECT * FROM users WHERE id='$id'");
	$saber = mysql_fetch_assoc($tudo);

	$email = $saber["email"];

	$sql = mysql_query("SELECT * FROM mensagens WHERE para='$login_cookie' AND de='$email' OR de='$login_cookie' AND para='$email' ORDER BY id");

	if (isset($_POST["send"])) {
		$msg = $_POST['text'];
		$data = date("Y/m/d");

		if ($msg=="") {
			echo '<h3 class="text-center">Não podes enviar uma mensagem em branco!</h3>';
		}else{
			$query = "INSERT INTO mensagens (`de`,`para`,`texto`,`status`,`data`) VALUES ('$login_cookie','$email','".mysql_real_escape_string($msg)."',0,'$data')";
			$data = mysql_query($query);
			if ($data) {
				header("refresh:0;");
			}else{
				echo '<h3 class="text-center">Algo não correu bem ao enviar a sua mensagem... Desculpe</h3>'.mysql_error();
			}
		}
	}
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<style type="text/css">
		h2{font-size: 32px; color: #007fff;}
		h3{font-size: 25px; color: #666;}
		a{color: #007fff; text-decoration: none;}
		div#box{}
		div#send{display: block; margin: auto; width: 100%; text-align: center; font-size: 20px;}
		div#send input[name="image"]{width: 20%; height: 35px; border: none; border-radius: 3px; font-size: 16px; background: #007fff; color: #FFF; cursor: pointer;}
		div#send input[name="text"]{width: 50%; height: 35px; border: none; border-radius: 3px; font-size: 16px; padding-left: 10px;}
		div#send input[name="send"]{width: 20%; height: 35px; border: none; border-radius: 3px; font-size: 16px; background: #007fff; color: #FFF; cursor: pointer;}
		</style>
	</head>
	<body>
	<div class="container">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6 col-xs-12">
		<h2 class="text-center"><a href="profile.php?id=<?php echo $id; ?>"><?php echo $saber["nome"]; ?></a></h2><br /><br /><br />
		<form method="POST">
			<div id="box">
				<object type="text/html" data="bubble.php?from=<?php echo $id; ?>#bottom" width="	100%" height="390px"></object>
			</div>
			<br />
			<div id="send">
				<a href="image.php?id=<?php echo $id; ?>"><input value="Imagem" type="button" name="image"></a>&nbsp;&nbsp;&nbsp;<input type="text" name="text" placeholder="Escreve aqui uma mensagem..." autocomplete="off">&nbsp;&nbsp;&nbsp;<input type="submit" name="send" value="Enviar">
			</div>
		</form>
		</div>
		<div class="col-md-3"></div>		
		</div>
	</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	</body>
</html>