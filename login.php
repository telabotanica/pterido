<?php 
require_once('./scripts/PF.php');
require './scripts/MesFonctions.php';



/**********************************    vérification de la session   ******************************************/
session_start(); // On relaye la session
if (isset($_SESSION["authentification"])){ // vérification sur la session authentification (la session est elle enregistrée ?)
		if ($action == 'ajouter') { header("Location:ajouter.php");}
		if ($action == 'modifier') { header("Location:modifier.php");}

		// GESTION DE LA Déconnexion
				if(isset($_GET['erreur']) && $_GET['erreur'] == 'delog'){ // Test sur les paramètres d'URL qui permettront d'identifier un "contexte" de déconnexion
				session_unset("authentification");
				}
}
else { // si la session n'est pas ok, on demande de se connecter

				if (isset($_POST['login']))
				{ 
			    $login = $_POST['login']; // mise en variable du nom d'utilisateur
				$pass = $_POST['pass'];
				
				// requete sur la table contributeurs (on récupère les infos de la personne)
				mysql_select_db($database_PF, $PF);
				$verif_query="SELECT id_contributeurs, login, pass, privilege FROM contributeurs WHERE login='$login' AND pass='$pass'"; // requête sur la base administrateurs
				$verif = mysql_query($verif_query, $PF) or die(mysql_error());
				$row_verif = mysql_fetch_assoc($verif);
				$utilisateur = mysql_num_rows($verif);
				
					
					if ($utilisateur == 1) {	// On test s'il y a un utilisateur correspondant
						$_SESSION["authentification"] = array('codeencarton'); // enregistrement de la session
						
						// déclaration des variables de session
						$_SESSION['privilege'] = $row_verif['privilege']; // le privilège de l'utilisateur (permet de définir des niveaux d'utilisateur)
						$_SESSION['id_contributeurs'] = $row_verif['id_contributeurs']; // Son id
						$_SESSION['login'] = $row_verif['login']; // Son Login
						
						if ($action == 'ajouter') { header("Location:ajouter.php");} // redirection si OK
						if ($action == 'modifier') { header("Location:modifier.php");}
						if ($action == 'mail') { header("Location:mail.php?destinataire=".$destinataire);}
						
					}
					else {
						// redirection si utilisateur non reconnu
						if ($destinataire != '') { header("Location:login.php?action=".$action."&erreur=login&destinataire=".$destinataire); }
						else { header("Location:login.php?action=".$action."&erreur=login"); }
						}
				}
				
}


entete();
?>

<form action="" method="post" name="connect">

  <br><br><b><p align="center"><font color="#CC0000" face="Arial, Helvetica, sans-serif" size="-1">      
      <?php if(isset($_GET['erreur']) && ($_GET['erreur'] == "login")) { // Affiche l'erreur  ?>
      Echec d'authentification ! --> login ou mot de passe incorrect <br>  <? } ?>
      <?php if(isset($_GET['erreur']) && ($_GET['erreur'] == "intru") && (isset($destinataire))) { // Affiche l'erreur ?>
      Vous devez vous identifier pour envoyer un message à ce contributeur !<? } ?>
	  <?php if(isset($_GET['erreur']) && ($_GET['erreur'] == "intru") && (!isset($destinataire))) { // Affiche l'erreur ?>
      Echec d'authentification ! --> Aucune session n'est ouverte ou vous n'avez pas les droits pour afficher cette page<? } ?></font>
  	  <font color="#009933" face="Arial, Helvetica, sans-serif" size="-1">
	  <?php if(isset($_GET['erreur']) && ($_GET['erreur'] == "delog")) { // Affiche l'erreur ?>
      D&eacute;connexion r&eacute;ussie... A bient&ocirc;t !    <? } ?></font></p></b>
  
  <br>
  <? if(isset($_GET['erreur']) && ($_GET['erreur'] == "delog")) { echo "<br><br><br><br><br><br><br><br><br><br>";} 
  else { ?>
  <p align="center"><b><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1"><em>Cette rubrique nécessite une identification,<br>Veuillez vous identifier : </em></font></b></p>
  

    <table width="300" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" align="center">
      <tr>
        <td colspan="2"><table width="400"  border="0" cellpadding="10" cellspacing="0" bgcolor="#F5DDB8">
          <tr>
            <td width="50%"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1"><b>LOGIN </b></font></td>
            <td width="50%"><input name="login" type="text" id="login"></td>
          </tr>
          <tr>
            <td width="50%"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1"><b>MOT DE PASSE </b></font></td>
            <td width="50%"><input name="pass" type="password" id="pass"></td>
          </tr>
          <tr>
            <td height="34" colspan="2" align="center">
			    <input type="text" style="display:none" name="destinataire" value="<? echo $destinataire;?>">
                <input type="submit" name="Submit" value="Se connecter">
			</td>
          </tr>
        </table></td>
      </tr>
	  </table>
	  <br>
	  <br>
	  <table width="300" cellpadding="0" cellspacing="0" align="center">
	  <tr>
		     <td align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1"><em><a href="./inscription.php">S'inscrire</a></em></font></td>
             <td align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1"><em><a href="./envoi.php">J'ai oublié mon mot de passe...</a></em></font></td>
 		  </tr>
	</table>
	<? } // fin de l'affichage de la mire de connexion ?>
</form>
<br>
<br>
<? pied();?>
