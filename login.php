<?php
	include("db.php");

	if (isset($_POST['entrar'])) {
		$email = $_POST['email'];
		$pass = $_POST['pass'];
		$verifica = mysql_query("SELECT * FROM users WHERE email = '$email' AND password='$pass'");
		if (mysql_num_rows($verifica)<=0) {
			echo '<div class="alert alert-danger alert-dismissible" role="alert">
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  						<span aria-hidden="true">&times;</span>
  					</button>
  					<strong>Ops! Digite o email ou a senha corretamente!</strong> 
  				 .</div>';
		}else{
			setcookie("login",$email);
			header("location: index.php");
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
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

	.painel-login{
		background-color: #000;	
	 	margin-top: 120px;
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

	input[type="email"]{
		border: 1px solid #CCC; 		
		border-radius: 0px;
		width: 100%;
	}

	input[type="password"]{
		border: 1px solid #CCC; 
		margin-top: 10px; 
		border-radius: 0px;
		width: 100%;
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
	h2{
		font-family: 'lobster';
		font-size: 4em;
		margin-top:0px;
		margin-bottom: 30px;
		color:#fff;
	}
	h3{
		font-size: 1.3em;
		color: #1E90FF; 
		margin-top: 15px;
	}
	a{
		text-decoration: none; 
		color: #333;
	}

	h3.created-by{
		margin-top: 100px;
		
	}

	</style>
</head>
<body>
	<div class="container painel-login">
		<div class="row">
			<div class="col-md-12">
				<h2 class="text-center">OutSide</h2>
				<form method="POST">
					<div class="input-group">
						<input type="email" placeholder="Email	" name="email" class="form-control" aria-describedby="basic-addon1"><br />
					</div>
					<div class="input-group">	
						<input type="password" placeholder="Senha" name="pass" class="form-control" aria-describedby="basic-addon1"><br />
					</div>
					<input type="submit" value="Entrar" name="entrar">
				</form>
			</div>
		</div>
	</div>
	<h3 class="text-center">Ainda não tem conta? <a href="registar.php">Crie uma hoje!</a></h3>	
	<h3 class="created-by text-center"><a href="#" style="color:#fff;font-size: 1.0em;">Created by : @FSalome</a></h3>	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>