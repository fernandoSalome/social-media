<?php
	include("header.php");

	$pubs = mysql_query("SELECT
			T.id, 
		    T.user, 
		    T.texto, 
		    T.imagem, 
		    T.data,
		    U.de,
		    U.para, 
		    U.aceite
		 FROM
		    pubs AS T,
		    amizades AS U 
		 WHERE
		    T.user = U.de AND U.para = '$login_cookie' AND U.aceite='sim'
		    OR T.user = U.para AND U.de = '$login_cookie' AND U.aceite='sim'
		    order by T.id DESC;");

	$saberr = mysql_query("SELECT * FROM users WHERE email='$login_cookie'");
	$saber = mysql_fetch_assoc($saberr);
	$email = $saber["email"];

	if (isset($_POST['publish'])) {
		if ($_FILES["file"]["error"] > 0) {
			$texto = $_POST["texto"];
			$hoje = date("Y-m-d");

			if ($texto == "") {
				echo "<h3>Você tem que escrever algo antes de publicar!</h3>";
			}else{
				$query = "INSERT INTO pubs (user,texto,data) VALUES ('$login_cookie','$texto','$hoje')";
				$data = mysql_query($query) or die();
				if ($data) {
					header("Location: ./");
				}else{
					echo "Alguma coisa não correu bem... Tenta outra vez mais tarde";
				}
			}
		}else{
			$n = rand(0, 1000000);
			$img = $n.$_FILES["file"]["name"];

			move_uploaded_file($_FILES["file"]["tmp_name"], "upload/".$img);

			$texto = $_POST['texto'];
			$hoje = date("Y-m-d");

			if ($texto == "") {
				echo "<h3>Você tem que escrever algo antes de publicar!</h3>";
			}else{
				$query = "INSERT INTO pubs (user,texto,imagem,data) VALUES ('$login_cookie','$texto','$img','$hoje')";
				$data = mysql_query($query) or die();
				if ($data) {
					header("Location: ./");
				}else{
					echo "Alguma coisa não correu muito bem... Tenta outra vez mais tarde";
				}
			}
		}
	}

	if (isset($_GET["love"])) {
		love();
	}

	function love() {
		$login_cookie = $_COOKIE['login'];
		$publicacaoid = $_GET['love'];
		$data = date("Y/m/d");

		$ins = "INSERT INTO loves (`user`,`pub`,`date`) VALUES ('$login_cookie','$publicacaoid','$data')";
		$conf = mysql_query($ins) or die(mysql_error());
		if ($conf) {
			header("Location: index.php#".$publicacaoid);
		}else{
			echo "<h3>Erro</h3> ".mysql_error();
		}
	}

	if (isset($_GET["unlove"])) {
		unlove();
	}

	function unlove() {
		$login_cookie = $_COOKIE['login'];
		$publicacaoid = $_GET['unlove'];
		$data = date("Y/m/d");

		$del = "DELETE FROM loves WHERE `user`='$login_cookie' AND `pub`='$publicacaoid'";
		$conf = mysql_query($del) or die(mysql_error());
		if ($conf) {
			header("Location: index.php#".$publicacaoid);
		}else{
			echo "<h3>Erro</h3> ".mysql_error();
		}
	}
?>
<html>
<header>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
	<link rel="stylesheet" href="css/ekko-lightbox.min.css">
</header>
<body>
<div class="container">
	<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6 col-xs-12">
		<div id="publish">
			<form method="POST" enctype="multipart/form-data">
				<br />
				<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-3">
					<?php
						if ($saber["img"]=="") {
							echo '
							<a href="myprofile.php" >
								<img src="img/user.png" id="profile" class="img-index center-block">
							</a>';
						}else{
							echo '
							<a href="myprofile.php">
								<img src="upload/'.$saber["img"].'" id="profile" class="img-index center-block">
							</a>';
						}
					?>
				</div>
				<div class="col-md-5" style="margin-top: 20px;"	>
				<textarea placeholder="Escreve uma publicacão nova" name="texto"></textarea>
					<label for="file-input">
						<img src="img/camera.png" title="Inserir uma fotografia"  class="camera-index "/>
					</label>
					<div class="button-hidden">
						<input type="file" id="file-input" name="file" hidden="true" />
					</div>	
					<input type="submit" value="Publicar" name="publish" />
				</DIV>
				<div class="col-md-2"></div>
			</form>
		</div>
		</div>
	<?php
		while ($pub=mysql_fetch_assoc($pubs)) {
			$email = $pub['user'];
			$saberr = mysql_query("SELECT * FROM users WHERE email='$email'");
			$saber = mysql_fetch_assoc($saberr);
			$nome = $saber['nome']." ".$saber['apelido'];
			$id = $pub['id'];
			$saberloves = mysql_query("SELECT * FROM loves WHERE pub='$id'");
			$loves = mysql_num_rows($saberloves);

			if ($pub['imagem']=="") {
				echo '<div class="pub" id="'.$id.'">
					<p><a href="profile.php?id='.$saber['id'].'">'.$nome.'</a> - '.$pub["data"].'</p>
					<span>'.$pub['texto'].'</span><br />
				</div>
				<div id="love">';
				$email_check = mysql_query("SELECT user FROM loves WHERE pub='$id' AND user='$login_cookie'");
				$do_email_check = mysql_num_rows($email_check);
				if ($do_email_check >= 1) {
					$loves = $loves - 1;
					echo '<p><a href="index.php?unlove='.$id.'">Curtir</a> | Você e mais '.$loves.' pessoas curtiram isso</p>';
				}else{
					echo '<p><a href="index.php?love='.$id.'">Curtir</a> | '.$loves.' pessoas curtiram isso</p>';
				}
				echo '</div>';
			}else{
				echo '<div class="pub" id="'.$id.'">
					<p><a href="profile.php?id='.$saber['id'].'">'.$nome.'</a> - '.$pub["data"].'</p>
					<span>'.$pub['texto'].'</span>
					  <img src="upload/'.$pub["imagem"].'" />
				</div>
				<div id="love">';
				$email_check = mysql_query("SELECT user FROM loves WHERE pub='$id' AND user='$login_cookie'");
				$do_email_check = mysql_num_rows($email_check);
				if ($do_email_check >= 1) {
					$loves = $loves - 1;
					echo '<p><a href="index.php?unlove='.$id.'">Curtir</a> | Você e mais '.$loves.' pessoas curtiram isso</p>';
				}else{
					echo '<p><a href="index.php?love='.$id.'">Curtir</a> | '.$loves.' pessoas curtiram isso</p>';
				}
				echo '</div>';
			}
		}
	?>
	<div class="pub" id="'.$id.'">
		<p>Aviso sobre as publicações...</p>
			<span>Olá	!Este texto marca a sua primeira vez no OutSide. Cada vez que a ver esta caixa, lembre deste dia.<br>
			Um abraço da sua equipe OutSide<br /><br />
	</div>'
	<br />
	<div id="footer"><p class="text-center">&copy; OutSide, 2016 - Todos os direitos reservados</p></div><br />
	</div>
	<div class="col-md-3 "></div>
	</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/lightbox-plus-jquery.min.js"></script>
	<script type="text/javascript" src="js/ekko-lightbox.min"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>