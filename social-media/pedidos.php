<?php
	include("header.php");

	$pubs = mysql_query("SELECT * FROM amizades WHERE para='$login_cookie' AND aceite='nao' ORDER BY id desc");

	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$saberr = mysql_query("SELECT * FROM users WHERE id='$id'");
		$saber = mysql_fetch_assoc($saberr);
		$email = $saber['email'];

		$ins = "UPDATE amizades SET `aceite`='sim' WHERE `de`='$email' AND para='$login_cookie'";
		$conf = mysql_query($ins) or die(mysql_error());
		if ($conf) {
			header("Location: pedidos.php");
		}else{
			echo "<h3>Erro ao aceitar amizade...</h3>";
		}
	}

	if (isset($_GET['remove'])) {
		$id = $_GET['remove'];
		$saberr = mysql_query("SELECT * FROM users WHERE id='$id'");
		$saber = mysql_fetch_assoc($saberr);
		$email = $saber['email'];

		$ins = "DELETE FROM amizades WHERE `de`='$login_cookie' AND para='$email' OR `para`='$login_cookie' AND de='$email'";
		$conf = mysql_query($ins) or die(mysql_error());
		if ($conf) {
			header("Location: pedidos.php");
		}else{
			echo "<h3>Erro ao eliminar amizade...</h3>";
		}
	}
?>
<html>
<header>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<style type="text/css">
	h3{text-align: center; color: #007fff;}
	div.pub{width: 400px; min-height: 70px; max-height: 1000px; display: block; margin: auto; border: none; border-radius: 5px; background-color: #FFF; box-shadow: 0 0 6px #A1A1A1; margin-top: 30px; text-align: center;}
	div.pub a{color: #666; text-decoration: none;}
	div.pub a:hover{color: #111; text-decoration: none;}
	div.pub p{content: #666; text-align: center;}
	div.pub span{display: block; margin: auto; padding-top: 20px; text-align: center;}
	div.pub input{border-radius: 3px; background-color: #007fff; border: none; color: #FFF; height: 25px; padding-right: 5px; padding-left: 5px; cursor: pointer;}
	div.pub input:hover{background-color: #FFF; color: #007fff;}
	</style>
</header>
<body>
	<br />
	<br />
	<br />
	<?php
		while ($pub=mysql_fetch_assoc($pubs)) {
			$email = $pub['de'];
			$saberr = mysql_query("SELECT * FROM users WHERE email='$email'");
			$saber = mysql_fetch_assoc($saberr);
			$nome = $saber['nome']." ".$saber['apelido'];
			$id = $pub['id'];

			echo '<div class="pub" id="'.$id.'">
				<span>'.$nome.' quer ser teu amigo/a</span><br />
				<p><a href="profile.php?id='.$saber['id'].'">Ver perfil de '.$nome.'</a></p><br />
				<a href="pedidos.php?id='.$saber['id'].'"><input type="submit" value="Sim, aceito" name="add"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="pedidos.php?remove='.$saber['id'].'"><input type="submit" value="Não, obrigado" name="remove"></a>
				<br /><br />
			</div>';
		}
	?>
	<br />
	<h3>Não tens mais pedidos de amizade...</h3>
	<br />
	<div id="footer"><p>&copy; OutSide, 2016 - Todos os direitos reservados</p></div><br />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>