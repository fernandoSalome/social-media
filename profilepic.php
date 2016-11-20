<?php
	include("header.php");

	if (isset($_POST['save'])) {
		if ($_FILES["file"]["error"]>0) {
			echo "<script language='javascript' type='text/javascript'>alert('Você tem que selecionar uma foto');</script>";
		}else{
			$n = rand (0, 10000000);
			$img = $n.$_FILES["file"]["name"];

			move_uploaded_file($_FILES['file']['tmp_name'], "upload/".$img);
			echo "Já está!";

			$query = "UPDATE users SET `img`='$img' WHERE `email`='$login_cookie'";
			$data = mysql_query($query);
			if ($data) {
				header("Location: myprofile.php");
			}else{
				echo "<script language='javascript' type='text/javascript'>alert('Ocorreu um erro ao atualizar a sua foto...');</script>";
			}
		}
	}
?>
<html>
	<header>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<style type="text/css">
			body{background-color: #007fff;}
			h2{margin-top: 50px; text-align: center; color: #FFF; font-size: 49px;}
			form#perfil{display: block; margin: auto; text-align: center; width: 100%; margin-top: 20px; background-color: #FFF; box-shadow: 0 0 10px #666; border-radius: 5px;}
			input[type="submit"]{width: 100px; height: 25px; border: none; border-radius: 3px; background-color: #007fff; cursor: pointer; color: #FFF;}
			div.button-hidden{display: none;}
			p{color: #FFF;}
		</style>
	</header>
	<body>
	<div class="container">
	<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6">
		<h2 class="text-center">Alterar foto de perfil</h2>
		<form method="POST" enctype="multipart/form-data" id="perfil">
			<br /> 
			<h3>Atualize sua foto de perfil</h3><br />
			<label for="foto-perfil">
				<img src="img/camera.png" title="Atualizar a fotografia"  class="camera-index"/>
			</label>
			<div class="button-hidden">
				<input type="file" name="file" id="foto-perfil" hidden/><br /><br />
			</div>
			<br/><br/>
			<input type="submit" value="Salvar" name="save" />
			<br /><br />
		</form>
		</div>
		<div class="col-md-3"></div>
		</div>
	</div>
		<br /><br /><br />
		<p class="text-center">&copy; OutSide, 2016 - Todos os direitos reservados</p>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	</body>
</html>	