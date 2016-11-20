<?php
	include("header.php");

	$saberr = mysql_query("SELECT * FROM users WHERE email='$login_cookie'");
	$saber = mysql_fetch_assoc($saberr);
	$email = $saber["email"];

	$pubs = mysql_query("SELECT * FROM pubs WHERE user='$email' ORDER BY id desc");

	if (isset($_POST['settings'])){
		header("Location: settings.php");	
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
	div#menu input{height: 40px; border: none; border-radius: 3px; background-color: #464647; cursor: pointer;color:#fff;margin-bottom: 74px;}
	div#menu input[name="settings"]{ width: 27%;transition: 1s;}
	div#menu input[name="amigos"]{ width: 27%;transition: 1s;}
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
<div class="container-fluid">
	<div class="row ">
		<div class="col-md-3"></div>
			<div class="col-md-6 col-xs-12">
			<div id="menu">
				<?php
					if ($saber["img"]=="") {
						echo '<a href="profilepic.php">sdasd<img src="img/user.png" id="profile" class="img-thumbnail"></a>';
					}else{
						echo '<a href="profilepic.php"><img src="upload/'.$saber["img"].'" id="profile" class="img-thumbnail"></a>';
					}
				?>
					<form method="POST">
						<h2 class="text-center"><?php echo $saber['nome']." ".$saber['apelido']; ?></h2><br />
						<input type="submit" value="Alterar info" name="settings">
						<input type="submit" name="amigos" value="Ver amigos">
					</form>
			</div>
			<?php
				while ($pub=mysql_fetch_assoc($pubs)) {
					$email = $pub['user'];
					$saberr = mysql_query("SELECT * FROM users WHERE email='$email'");
					$saber = mysql_fetch_assoc($saberr);
					$nome = $saber['nome']." ".$saber['apelido'];
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
			?>
			<br />
			<div id="footer"><p class="text-center">&copy; OutSide, 2016 - Todos os direitos reservados</p></div><br />
	</div>
	</div>
	<div class="col-md-3"></div>
</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/lightbox-plus-jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>