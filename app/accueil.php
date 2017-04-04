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
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
	<script src="../js/jquery.min.js"></script>
    <title></title>
</head>
<body>
	<div id="container">
		<h1 class="titreCompte">Mon compte</h1>
		<hr width="75%">
		<?php
			$selectEleve = $mysqli->query("SELECT nom, prenom, sexe, dateNais, lieuNais, nvoEtude, profession, residence, numeroTel, grpwhatsApp, matricule, code FROM eleves WHERE code = '".$_SESSION['code']."'");
			//$resultatEleve = $selectEleve->fetch();
			$eleve = $selectEleve->fetch();
		?>
		
		<div id="presentation-eleve">
			<div class="row info-eleve surbrille-line">        
				<div class="col-lg-4">
					<span class="libelle-fr">Matricule:</span>
				</div>
				<div class="col-lg-4">        
					<span class="renseignement"><?php echo $eleve['matricule'];?></span>
				</div> 
				<div class="col-lg-4">        
					<span class="libelle-ar">الرقم</span>
				</div>      
			</div> 
		</div>
		
		<div id="presentation-eleve">
			<div class="row info-eleve">        
				<div class="col-lg-4">
					<span class="libelle-fr">Nom:</span>
				</div>
				<div class="col-lg-4">        
					<span class="renseignement"><?php echo $eleve['nom'];?></span>
				</div> 
				<div class="col-lg-4">        
					<span class="libelle-ar">اللقب</span>
				</div>      
			</div>
		</div>
		
		<div id="presentation-eleve">
			<div class="row info-eleve surbrille-line">        
				<div class="col-lg-4">
					<span class="libelle-fr">Prénom:</span>
				</div>
				<div class="col-lg-4">        
					<span class="renseignement"><?php echo $eleve['prenom'];?></span>
				</div> 
				<div class="col-lg-4">        
					<span class="libelle-ar">الاسم</span>
				</div>      
			</div> 
		</div>
		
		<div id="presentation-eleve">
			<div class="row info-eleve">        
				<div class="col-lg-4">
					<span class="libelle-fr">Sexe:</span>
				</div>
				<div class="col-lg-4">        
					<span class="renseignement"><?php echo $eleve['sexe'];?></span>
				</div> 
				<div class="col-lg-4">        
					<span class="libelle-ar">الجنس</span>
				</div>      
			</div> 
		</div>
		
		<div id="presentation-eleve">
			<div class="row info-eleve surbrille-line">        
				<div class="col-lg-4">
					<span class="libelle-fr">Date de naissance:</span>
				</div>
				<div class="col-lg-4">        
					<span class="renseignement"><?php echo $eleve['dateNais'];?></span>
				</div> 
				<div class="col-lg-4">        
					<span class="libelle-ar">تلخ الميااد</span>
				</div>      
			</div>
		</div>
		
		<div id="presentation-eleve">
			<div class="row info-eleve">        
				<div class="col-lg-4">
					<span class="libelle-fr">Lieu de naissance:</span>
				</div>
				<div class="col-lg-4">        
					<span class="renseignement"><?php echo $eleve['lieuNais'];?></span>
				</div> 
				<div class="col-lg-4">        
					<span class="libelle-ar">مكان الميلاد</span>
				</div>      
			</div> 
		</div>
		
		<div id="presentation-eleve">
			<div class="row info-eleve surbrille-line">        
				<div class="col-lg-4">
					<span class="libelle-fr">Niveau d'étude:</span>
				</div>
				<div class="col-lg-4">        
					<span class="renseignement"><?php echo $eleve['nvoEtude'];?></span>
				</div> 
				<div class="col-lg-4">        
					<span class="libelle-ar">المستوى الدراسي</span>
				</div>      
			</div> 
		</div>
		
		<div id="presentation-eleve">
			<div class="row info-eleve">        
				<div class="col-lg-4">
					<span class="libelle-fr">Profession:</span>
				</div>
				<div class="col-lg-4">        
					<span class="renseignement"><?php echo $eleve['profession'];?></span>
				</div> 
				<div class="col-lg-4">        
					<span class="libelle-ar">الموظف</span>
				</div>      
			</div>
		</div>
		
		<div id="presentation-eleve">
			<div class="row info-eleve surbrille-line">        
				<div class="col-lg-4">
					<span class="libelle-fr">Résidence:</span>
				</div>
				<div class="col-lg-4">        
					<span class="renseignement"><?php echo $eleve['residence'];?></span>
				</div> 
				<div class="col-lg-4">        
					<span class="libelle-ar">مكان الاقامة</span>
				</div>      
			</div> 
		</div>
		
		<div id="presentation-eleve">
			<div class="row info-eleve">        
				<div class="col-lg-4">
					<span class="libelle-fr">Numéro de téléphone:</span>
				</div>
				<div class="col-lg-4">        
					<span class="renseignement"><?php echo $eleve['numeroTel'];?></span>
				</div> 
				<div class="col-lg-4">        
					<span class="libelle-ar">رقم الجوال</span>
				</div>      
			</div>
		</div>
		
		<div id="presentation-eleve">
			<div class="row info-eleve surbrille-line">        
				<div class="col-lg-4">
					<span class="libelle-fr">Groupe WhatsApp:</span>
				</div>
				<div class="col-lg-4">        
					<span class="renseignement"><?php echo $eleve['grpwhatsApp'];?></span>
				</div> 
				<div class="col-lg-4">        
					<span class="libelle-ar">WhatsApp مجموعة في</span>
				</div>      
			</div>
		</div>
		<br />
		<form action="" method="post">
			<div class="row titreCompte">
				<a href="compo.php" title="  Commencer la composition  " class="lienCompo">
					<button type="button" class="btn btn-primary btn-lg btn-cnx" name="commencerCompo">
						Cliquez ici pour commencer la composition
					</button>
				</a>
			</div>
		</form>
		
	</div>
</body>
</html>