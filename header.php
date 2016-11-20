<?php
  include("db.php");


  $login_cookie = $_COOKIE['login'];
  if (!isset($login_cookie)) {
    header("Location: login.php");
  }

  $saberr = mysql_query("SELECT * FROM users WHERE email='$login_cookie'");
  $saber = mysql_fetch_assoc($saberr);
  $email = $saber["email"];
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/hover-min.css">
  <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
  <style type="text/css">

  *{
    padding:0;
    margin:0;
  }
  body{
    background: #F6F6F6;
  }

  img.capa-fundo{
    width: 100%;
    height:100%;
    position: absolute; 
    position: fixed;
    margin-top: -100px;
    z-index:-1;
    -webkit-filter: blur(5px);
    -moz-filter: blur(5px);
    -o-filter: blur(5px);
    -ms-filter: blur(5px);
    filter: blur(5px);
  }

  nav.menu{
    border-radius: 0px;
    background-color: transparent;
    padding:10px;
    z-index: 100;
  }

  .logo{
    font-family: 'Lobster', cursive;
    font-size: 2.3em;
    color: #fff;
  }

  div#footer{
    bottom: 0; 
    text-align: center; 
    color: #fff;
  }
  </style>
</head>
<body>

  <nav class="navbar navbar-default menu">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"><span class="logo hvr-grow">OutSide</span></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
      <ul class="nav navbar-nav navbar-right">
        <li>
          <form class="navbar-form navbar-left" role="search" method="GET" action="pesquisar.php">
            <div class="form-group">
              <input type="text" placeholder="Pesquise alguém..." name="query" autocomplete="off" class="form-control search-bar" style=""><input type="submit" hidden>
            </div>
          </form> 
        </li>
        <li><a href="inbox.php"><img src="img/chat.png" width="30" name="menu" class="hvr-grow"></a></li>
        <li><a href="pedidos.php"><img src="img/notificacao.png" width="30" name="menu" class="hvr-grow"></a></li>
        <li><a href="myprofile.php"><img src="img/perfil.png" width="30" name="menu" class="hvr-grow"></a></li>
        <li><a href="logout.php"><img src="img/logout.png" width="30" name="menu" class="hvr-grow"></a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<?php
    if ($saber["capa_fundo"]=="") {
      echo '<img src="img/fundo-paisagem.jpg"  class="img-responsive capa-fundo">';
    }else{
      echo '<img src="capa_fundo/'.$saber["capa_fundo"].'" class="img-responsive capa-fundo">';
    }
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>