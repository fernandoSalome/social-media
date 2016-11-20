<?php
	include("header.php");

	$infoo = mysql_query("SELECT * FROM users WHERE email='$login_cookie'");
	$info = mysql_fetch_assoc($infoo);

	if (isset($_POST['criar'])) {
		$nome = $_POST['nome'];
		$apelido = $_POST['apelido'];
		$pass = $_POST['pass'];

		if($nome==""){
			echo "<h2>Escreve o teu nome</h2>";
		}elseif($apelido==""){
			echo "<h2>Escreve o teu apelido</h2>";
		}elseif($pass==""){
			echo "<h2>Escreve uma palavra-passe</h2>";
		}else{
			$query = "UPDATE users SET `nome`='$nome', `apelido`='$apelido', `password`='$pass' WHERE email='$login_cookie'";
			$data = mysql_query($query);
			if ($data) {
				header("Location: myprofile.php");
			}else{
				echo "<h2>Algo não correu como esperávamos...</h2>";
			}
		}
	}

	if (isset($_POST['cancel'])) {
		header("Location: myprofile.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<style type="text/css">

	h2{
		text-align: center; margin-top: 20px;
	}
	h3{
		color: #1E90FF; 
		margin-top: 15px;
	}
	a{
		text-decoration: none; 
		color: #333;
	}

	img[name="p"]{
		display: block; 
		margin: auto; 
		margin-top: 20px; 
		width: 200px;
	}

	form{text-align: center; 
		margin-top: 10px;
	}
	input[type="text"]{
		border: 1px solid #CCC; 
		margin-top: 10px; 
		border-radius: 0px;
		width: 280px;
		height: 30px;
	}

	input[type="password"]{
		border: 1px solid #CCC; 		
		border-radius: 0px;
		width: 280px;
		margin-top: 10px;
		height: 30px;
	}	

	input[type="submit"]{
		border: none; 
		width: 131px; 
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

	.mudar{
		margin-top:20px;
		font-size: 2em;
		color: red;
		font-size: 1em;	
	}

	.cancel{
		margin-right: 6px;
		margin-bottom: 30px;
	}

	.atualiza{
		margin-left: 10px;
	}

	
	</style>
</head>
<body>
	<div class="container painel">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6 col-xs-12">
			<img name="p" src="img/configuracoes.png" for=""><br />
			<h2 class="text-center">Altera as tuas definições</h2>
			<form method="POST">
				<input type="text" placeholder="Primeiro nome" value="<?php echo $info['nome']; ?>" name="nome"><br />
				<input type="text" placeholder="Apelido" value="<?php echo $info['apelido']; ?>" name="apelido"><br />
				<input type="password" placeholder="Palavra-passe" value="<?php echo $info['password']; ?>" name="pass"><br />
				<a href="atualizar-capa-fundo.php"><p class="text-center mudar">Mudar capa de fundo</p></a>
				<a href="atualizar-foto-perfil.php"><p class="text-center mudar">Mudar foto de perfil</p></a>
				<input type="submit" value="Atualizar info" name="criar" class="atualiza">&nbsp;&nbsp;&nbsp;
				<input type="submit" value="Cancelar" name="cancel" class="cancel">
			</form>
			</div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>