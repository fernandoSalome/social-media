<?php
	include("db.php");

	if (isset($_POST['criar'])) {
		$nome = $_POST['nome'];
		$apelido = $_POST['apelido'];
		$email = $_POST['email'];
		$pass = $_POST['pass'];
		$data = date("Y/m/d");

		$email_check = mysql_query("SELECT email FROM users WHERE email='$email'");
		$do_email_check = mysql_num_rows($email_check);
		if ($do_email_check >= 1) {
			echo '<h3>Este email já está registado, faça o login <a href="login.php">aqui</a></h3>';
		}elseif ($nome == '' OR strlen($nome)<3) {
			echo '<h3>Escreve o seu nome corretamente!</h3>';
		}elseif ($email == '' OR strlen($email)<10) {
			echo '<h3>Escreve o seu email corretamente!</h3>';
		}elseif ($pass == '' OR strlen($pass)<8) {
			echo '<h3>Escreve a sua palavra-passe corretamente, deve ter mais que 8 caracteres!</h3>';
		}else{
			$query = "INSERT INTO users (`nome`,`apelido`,`email`,`password`,`data`) VALUES ('$nome','$apelido','$email','$pass','$data')";
			$data = mysql_query($query) or die(mysql_error());
			if ($data) {
				setcookie("login",$email);
				header("Location: foto-perfil.php");
			}else{
				echo "<h3>Desculpa, houve um erro ao registar-te...</h3>";
			}
		}
	}	
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
	<style type="text/css">
	*{
		font-family: 'Montserrat', cursive;
	}

	body{
		background-image: url(img/fundo-paisagem.jpg);
		background-size: cover;
	}

	.painel-login{
		background-color: #000;	
	 	margin-top: 100px;
	 	padding:50px;
	 	width: 300px;
	 	border-radius: 4px;
	 	opacity: 0.8;
	}

	form{
		text-align: center; 
		margin-top: 10px;
	}

	input[type="text"]{
		border: 1px solid #CCC; 
		margin-top: 10px; 
		border-radius: 0px;
		width: 100%;
		padding: 5px;
	}

	input[type="email"]{
		border: 1px solid #CCC; 
		margin-top: 10px; 
		border-radius: 0px;
		width: 100%;
		padding: 5px;
	}

	input[type="password"]{
		border: 1px solid #CCC; 
		margin-top: 10px; 
		border-radius: 0px;
		width: 100%;
		padding: 5px;
	}

	.aviso-senha{
		color:red;
	}
	input[type="submit"]{
		border: none; 
		width: 80%; 
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

	h2{
		font-family: 'lobster';
		font-size: 4em;
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
</head>
<body>
<div class="container painel-login">
		<div class="row">
			<div class="col-md-12">
				<h2 class="text-center">OutSide</h2>
				<h3 class="text-center">Crie uma conta!</h2>
				<form method="POST">
					<input type="text" placeholder="Primeiro nome" name="nome"><br />
					<input type="text" placeholder="Apelido" name="apelido"><br />
					<input type="email" placeholder="Endereço email" name="email"><br />
					<input type="password" placeholder="Senha" name="pass"><br />
					<p class="aviso-senha">*A senha deve ter no mínimo 8 caracteres</p>
					<input type="submit" value="Criar uma conta" name="criar">
				</form>
			</div>
		</div>
	</div>
	<h3>Já tem uma conta? <a href="login.php">Entre aqui!</a></h3>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>