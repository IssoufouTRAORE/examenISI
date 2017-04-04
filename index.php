<?php

define("HOST", "localhost"); 			// The host you want to connect to.
define("USER", "root"); 			// The database username.
define("PASSWORD", ""); 	// The database password.
define("DATABASE", "markaz");             // The database name.


define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "user");

/**
 * Is this a secure connection?  The default is FALSE, but the use of an
 * HTTPS connection for logging in is recommended.
 *
 * If you are using an HTTPS connection, change this to TRUE
 */
define("SECURE", FALSE);    // For development purposes only!!!!
$pdo_option[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
$mysqli = new PDO('mysql:host=localhost;dbname=markaz', 'root', '', $pdo_option);
$mysqli->exec('SET NAMES utf8');
$link = mysql_connect("localhost","roo");
mysql_query("SET CHARACTER SET 'utf8';", $link) or die(mysql_error());
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
	<script src="js/jquery.min.js"></script>
    <title></title>
</head>
	<body bgcolor="orange">
		<div id="container">
			<div id="containerImageLogo">
				<div id="imageLogo">
					<p>
						<img src="images/logoISI.png" alt="Institut des Sciences Islamiques" width="40%" height="40%" align="center" />
					</p>
				</div>
			</div>
			<h1 class="titre-ar">WhatsApp الاتصال لللإختبار الطلاب المجموعة مركز في</h1>
			<hr width="40%">
			<h1 class="titre-fr">Connexion pour le test des élèves du groupe Markaz sur WhatsApp</h1>
			<br />
			<div ="formConnexion">
				<form method="post" action="">
					<div class="row boutonsConnection">    
						<div class="form-group">      
							<label for="code" class="col-lg-3">Code</label>
							<div class="col-lg-9">        
								<input type="text" name="code" id="code" style="width:400px" class="input-sm form-control form-control input-lg" placeholder="Entrez votre code ici pour vous connecter !" />     
							</div>    
						</div>  
					</div> 	
					<div id="positionBoutonsCnx">
						<button class="btn btn-primary" type="submit" name="cnx">
							<span class="glyphicon glyphicon-ok-sign"></span> Se connecter
						</button>
						<button type="reset" class="btn btn-custom">Annuler</button>
					</div>
				</form>
					<?php
						if(isset($_POST['cnx'])){
							if(empty($_POST['code'])){
								echo"<script type='text/javascript'>";
								echo"alert('Les champs sont vides')";
								echo"</script>";
							}
							else{
								$code = $_POST['code'];
								$selectEleve = $mysqli->query("SELECT nom, prenom, sexe, numeroTel, matricule, code FROM eleves");
								//$eleve = $selectEleve->fetch(PDO::FETCH_ASSOC);
								$resultatEleve = $selectEleve->fetchall();
								//$stateConnexion traduit l'état de la connexion
								$stateConnexion = 0;
								foreach($resultatEleve as $eleve){
									if($eleve['code'] == $code){
										$stateConnexion = 1;
										$_SESSION["code"] = $code;
										header("location:app/accueil.php");
									}
								}
								if($stateConnexion == 0){
								echo"<script type='text/javascript'>";
								echo"alert('Les paramètres de connexion saisis sont incorrectes.')";
								echo"</script>";
								}
							}
						}
					?>
			</div>
		</div>
	</body>
</html>

<!--
LOAD DATA LOCAL INFILE 'C:/Users/Issoufou TRAORE/Desktop/eleves.csv' 
INTO TABLE markaz.eleves 
FIELDS TERMINATED BY ';' 
ENCLOSED BY '' 
LINES TERMINATED BY '\r\n';
UPDATE eleves SET sexe = 'زكر' WHERE sexe = '???'
-->

