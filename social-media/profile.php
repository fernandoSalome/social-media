<?php
	include("header.php");

	$id = $_GET["id"];
	$saberr = mysql_query("SELECT * FROM users WHERE id='$id'");
	$saber = mysql_fetch_assoc($saberr);
	$email = $saber["email"];

	if ($email==$login_cookie) {
		header("Location: myprofile.php");
	}

	$pubs = mysql_query("SELECT * FROM pubs WHERE user='$email' ORDER BY id desc");

	if (isset($_POST['add'])) {
		add();
	}

	function add(){
		$login_cookie = $_COOKIE['login'];
		if (!isset($login_cookie)) {
			header("Location: login.php");
		}
		$id = $_GET['id'];
		$saberr = mysql_query("SELECT * FROM users WHERE id='$id'");
		$saber = mysql_fetch_assoc($saberr);
		$email = $saber['email'];
		$data = date("Y/m/d");

		$ins = "INSERT INTO amizades (`de`,`para`,`data`) VALUES ('$login_cookie','$email','$data')";
		$conf = mysql_query($ins) or die(mysql_error());
		if ($conf) {
			header("Location: profile.php?id=".$id);
		}else{
			echo "<h3>Erro ao enviar pedido...</h3>";
		}
	}

	if (isset($_POST['cancelar'])) {
		cancel();
	}

	function cancel(){
		$login_cookie = $_COOKIE['login'];
		if (!isset($login_cookie)) {
			header("Location: login.php");
		}
		$id = $_GET['id'];
		$saberr = mysql_query("SELECT * FROM users WHERE id='$id'");
		$saber = mysql_fetch_assoc($saberr);
		$email = $saber['email'];

		$ins = "DELETE FROM amizades WHERE `de`='$login_cookie' AND para='$email'";
		$conf = mysql_query($ins) or die(mysql_error());
		if ($conf) {
			header("Location: profile.php?id=".$id);
		}else{
			echo "<h3>Erro ao cancelar pedido...</h3>";
		}
	}

	if (isset($_POST['remover'])) {
		remove();
	}

	if (isset($_POST['chat'])) {
		header("Location: chat.php?from=".$id);
	}

	function remove(){
		$login_cookie = $_COOKIE['login'];
		if (!isset($login_cookie)) {
			header("Location: login.php");
		}
		$id = $_GET['id'];
		$saberr = mysql_query("SELECT * FROM users WHERE id='$id'");
		$saber = mysql_fetch_assoc($saberr);
		$email = $saber['email'];

		$ins = "DELETE FROM amizades WHERE `de`='$login_cookie' AND para='$email' OR `para`='$login_cookie' AND de='$email'";
		$conf = mysql_query($ins) or die(mysql_error());
		if ($conf) {
			header("Location: profile.php?id=".$id);
		}else{
			echo "<h3>Erro ao eliminar amizade...</h3>";
		}
	}

	if (isset($_POST['aceitar'])) {
		aceitar();
	}

	function aceitar(){
		$login_cookie = $_COOKIE['login'];
		if (!isset($login_cookie)) {
			header("Location: login.php");
		}
		$id = $_GET['id'];
		$saberr = mysql_query("SELECT * FROM users WHERE id='$id'");
		$saber = mysql_fetch_assoc($saberr);
		$email = $saber['email'];

		$ins = "UPDATE amizades SET `aceite`='sim' WHERE `de`='$email' AND para='$login_cookie'";
		$conf = mysql_query($ins) or die(mysql_error());
		if ($conf) {
			header("Location: profile.php?id=".$id);
		}else{
			echo "<h3>Erro ao eliminar amizade...</h3>";
		}
	}
?>
<html>
<header>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/lightbox.min.css">
	<style type="text/css">
	h2{padding-top: 20px;margin-top: 50px; color: #464647;}
	img#profile{width: 248px; height: 248px; display: block; float:left;margin:auto;display: block;}
	div#menu{width: 100%; height: auto;display: block; margin: auto; border: none; border-radius: 5px; border:1px solid #ccc; text-align: center;background-color: #fff;}
	div#menu input{width: 17%;transition: 1s;height: 40px; border: none; border-radius: 3px; background-color: #464647; cursor: pointer;color:#fff;margin-bottom: 74px;}
	div#menu input:hover{height: 40px; border: none; border-radius: 3px;border:3px solid #464647; background-color: transparent; cursor: pointer; color: #464647;transition: 0.5s;font-weight: bold;}

	div.pub{width: 100%; min-height: 70px; max-height: 1000px; display: block; margin: auto; border: none; border-radius: 5px; background-color: #FFF; box-shadow: 0 0 6px #A1A1A1; margin-top: 30px;}
	div.pub a{color: #666; text-decoration: none;}
	div.pub a:hover{color: #111; text-decoration: none;}
	div.pub p{margin-left: 10px; content: #666; padding-top: 10px; font-size: 1.5em;}
	div.pub span{display: block; margin: auto; margin-top: 10px;margin-left: 2%;font-size: 1.2em;}
	div.pub img{display: block; margin: auto; width: 100%; margin-top: 10px; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;}	
	</style>
</header>
<body>
<div class="container">
	<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6 col-xs-12">
	<?php
		if ($saber["img"]=="") {
			echo '<img src="img/user.png" id="profile" class="img-thumbnail"">';
		}else{
			echo '<img src="upload/'.$saber["img"].'" id="profile">';
		}
	?>
	<div id="menu">
		<form method="POST">
		<h2><?php echo $saber['nome']." ".$saber['apelido']; ?></h2><br />
		<?php
			$amigos = mysql_query("SELECT * FROM amizades WHERE de='$login_cookie' AND para='$email' OR para='$login_cookie' AND de='$email'");
			$amigoss = mysql_fetch_assoc($amigos);
			if (mysql_num_rows($amigos)>=1 AND $amigoss["aceite"]=="sim") {
				echo '<input type="submit" value="Remover" name="remover">
						<input type="submit" name="chat" value="Conversar">	
							<input type="submit" name="denunciar" value="Denunciar">';
			}elseif (mysql_num_rows($amigos)>=1 AND $amigoss["aceite"]=="nao" AND $amigoss["para"]==$login_cookie){
				echo '<input type="submit" value="Aceitar" name="aceitar">
						<input type="submit" name="chat" value="Conversar">
							<input type="submit" name="denunciar" value="Denunciar">';
			}elseif (mysql_num_rows($amigos)>=1 AND $amigoss["aceite"]=="nao" AND $amigoss["de"]==$login_cookie){
				echo '<input type="submit" value="Cancelar" name="cancelar">
						<input type="submit" name="chat" value="Conversar">
							<input type="submit" name="denunciar" value="Denunciar">';
			}else{
				echo '<input type="submit" value="Adicionar" name="add">
						<input type="submit" name="chat" value="Conversar">
							<input type="submit" name="denunciar" value="Denunciar">';
			}
		?>
		</form>
	</div>
	<div class="menu-content">
	<?php
		$saberr = mysql_query("SELECT * FROM users WHERE email='$email'");
		$saber = mysql_fetch_assoc($saberr);
		$nome = $saber['nome']." ".$saber['apelido'];
		$amigoss = mysql_query("SELECT * FROM amizades WHERE de='$login_cookie' AND para='$email' AND aceite='sim' OR para='$login_cookie' AND de='$email' AND aceite='sim'");
		$amigos = mysql_num_rows($amigoss);
		if ($amigos==1) {
			while ($pub=mysql_fetch_assoc($pubs)) {
			$email = $pub['user'];
			$id = $pub['id'];

				if ($pub['imagem']=="") {
					echo '<div class="pub" id="'.$id.'">
						<p><a href="profile.php?id='.$saber['id'].'">'.$nome.'</a> - '.$pub["data"].'</p>
						<span>'.$pub['texto'].'</span><br />
					</div>';
				}else{
					echo '<div class="pub" id="'.$id.'">
						<p><a href="profile.php?id='.$saber['id'].'">'.$nome.'</a> - '.$pub["data"].'</p>
						<span>'.$pub['texto'].'</span>
						<img src="upload/'.$pub["imagem"].'" />
					</div>';
				}
			}
		}elseif ($amigos==0){
			echo '<div class="pub" id="'.$id.'">
						<p>Aviso sobre as amizades...</p>
						<span>Tens de ser amigo/a do/a '.$nome.' para poderes ver as suas publicações...</span><br />
					</div>';
		}
	?>
	</div>
	<br />
	</div>
	<div class="col-md-3 "></div>
	</div>
</div>
	<div id="footer"><p class="text-center">&copy; OutSide, 2016 - Todos os direitos reservados</p></div><br />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/lightbox-plus-jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>