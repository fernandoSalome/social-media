<?php
	include("db.php");

	$login_cookie = $_COOKIE['login'];
  if (!isset($login_cookie)) {
    header("Location: login.php");
  }

	if (isset($_POST['save'])) {
		if ($_FILES["file"]["error"]>0) {
			echo "<script language='javascript' type='text/javascript'>alert('Você tem que selecionar uma foto');</script>";
		}else{
			$n = rand (0, 10000000);
			$capa_fundo = $n.$_FILES["file"]["name"];

			move_uploaded_file($_FILES['file']['tmp_name'], "capa_fundo/".$capa_fundo);
			echo "Já está!";

			$query = "UPDATE users SET `capa_fundo`='$capa_fundo' WHERE `email`='$login_cookie'";
			$data = mysql_query($query);
			if ($data) {
				header("Location:index.php");
			}else{
				echo "<script language='javascript' type='text/javascript'>alert('Ocorreu um erro ao colocar sua foto de perfil...');</script>";
			}
		}
	}
?>
<html>
	<header>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
	<style type="text/css">

	.logo-style{
		color:#1E90FF;
		font-family: 'lobster';
	}

	body{
		background-image: url(img/fundo-paisagem.jpg);
		background-size: cover;
	}

	.button-hidden{
		display: none;
	}

	.painel-login{
		background-color: #000;	
	 	margin-top: 80px;
	 	padding:50px;
	 	width: 300px;
	 	border-radius: 4px;
	 	opacity: 0.8;
	}

	form{
		text-align: center; 
		margin-top: 20px;
		opacity: 1;
	}


	input[type="submit"]{
		border: none; 
		width: 50%; 
		height: 40px;
		margin-top: 20px; 
		font-size: 1.3em;
		color: #fff;
		background-color: #1E90FF;
	}

	input[type="submit"]:hover{
		background-color: transparent; 
		border:1px solid #1E90FF;
		color: #FFF; 
		cursor: pointer;
		font-size: 1.3em;
		transition: 0.5s;
	}

	p{
		font-size: 1.5em;
		color:#fff;
		margin-bottom: 50px;
	}

	h2{
		font-size: 2.4em;
		margin-top:0px;
		margin-bottom: 30px;
		color:#fff;
	}
	h3{
		font-size: 1.3em;
		text-align: center; 
		color: #1E90FF; 
		margin-top: 15px;
	}
	a{
		text-decoration: none; 
		color: #333;
	}

	</style>
	</header>
	<body>
	<div class="container painel-login">
		<div class="row">
			<div class="col-md-12">
				<h2 class="text-center">Adicione uma foto de fundo</h2>
				<form method="POST" enctype="multipart/form-data" id="perfil">
					<label for="foto-perfil">
						<img src="img/camera.png" title="Inserir uma fotografia"  class="camera-index"/>
					</label>
					<div class="button-hidden">
						<input type="file" name="file" id="foto-perfil" hidden/><br /><br />
					</div>
					<input type="submit" value="Salvar" name="save" /><br>
					<a href="index.php" style="color:#fff;position: relative;top:20px;">pular</a>
					<br /><br />
				</form>
			</div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	</body>
</html>	