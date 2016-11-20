	<?php
	include("header.php");

	$sql = mysql_query("SELECT * FROM mensagens WHERE para='$login_cookie' GROUP BY de ORDER BY id");

	$ups = mysql_query("SELECT * FROM mensagens WHERE para='$login_cookie' AND  status=0");
	$contagem = mysql_num_rows($ups);
?>
<html>
	<header>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<style type="text/css">
			a{text-decoration: none;font-size: 2em;list-style: none;}
			div#box p{cursor: pointer; color: #333;}
			div#box{min-width: 100px; max-width: 500px; display: block; margin: auto;}
			div#box:hover{box-shadow: inset 0 0 6px #AAA; border-radius: 5px;}
			div#box span{color:#fff;}
			hr{width: 80%; display: block; margin: auto; border: 1px solid #555;}
			h1{color: #464647;}
			h3{color: #AAA;}
		</style>
	</header>
	<body>
		<br />
		<div class="container ">
			<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6 col-xs-12 painel">
				<div>
		<h1 class="text-center">Conversas</h1>
		<form method="POST">
		
					<?php
						while ($msg=mysql_fetch_assoc($sql)) {
								$from = $msg["de"];
								$tudo = mysql_query("SELECT * FROM users WHERE email='$from'");
								$img = mysql_fetch_assoc($tudo);
								$conta = mysql_query("SELECT * FROM mensagens WHERE de='$from' AND para='$login_cookie' AND status=0");
								$contar = mysql_num_rows($conta);

								echo '<br /><a name="d" href="chat.php?from='.$img["id"].'">
									<div id="box">
										<br /><p class="text-center">'.$img["nome"].' '.$img["apelido"].' - '.$contar.' mensagens novas</p><br />
									</div></a><br />
										<hr />';
							}
					?>
				</div>
			</form>
			<br /><br />
			<div id="footer"><p class="text-center">&copy; OutSide, 2016 - Todos os direitos reservados</p></div><br />
			</div>
			<div class="col-md-3"></div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	</body>
</html>