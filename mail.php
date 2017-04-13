<?php 
// formulaire de mail


require './scripts/MesFonctions.php';
require_once('./scripts/PF.php');

/**********************************    vérification de la session   ******************************************/
session_start(); // On relaye la session
if (isset($_SESSION["authentification"])){ // vérification sur la session authentification (la session est elle enregistrée ?)
// ici les éventuelles actions en cas de réussite de la connexion
}
else {
header("Location:login.php?action=mail&erreur=intru&destinataire=".$destinataire); // redirection en cas d'echec
}
//*************************************************************************************************************			
			
			//récupération des infos du contributeur
			mysql_select_db($database_PF, $PF);
			$query_Dest = "SELECT * FROM contributeurs WHERE id_contributeurs = '$destinataire'";
			$Dest = mysql_query($query_Dest, $PF) or die(mysql_error());
			$row_Dest = mysql_fetch_assoc($Dest);
			$totalRows_Dest = mysql_num_rows($Dest);

			//récupération des infos de l'expediteur
			$expediteur = $_SESSION['id_contributeurs'];
			
			mysql_select_db($database_PF, $PF);
			$query_Exp = "SELECT * FROM contributeurs WHERE id_contributeurs = '$expediteur'";
			$Exp = mysql_query($query_Exp, $PF) or die(mysql_error());
			$row_Exp = mysql_fetch_assoc($Exp);
			$totalRows_Exp = mysql_num_rows($Exp);


if (isset($valider))  {
			
			//envoi du mail
			
			$commentaires = stripslashes($commentaires);
			$msg = $commentaires ;
			// Dans le cas où nos lignes comportent plus de 70 caractères, nous les coupons en utilisant wordwrap()
     		$msg = wordwrap($msg, 70);

			
			$recipient = $row_Dest['mail'];
			
			$subject = $sujet." - Site PTERIDO" ;

			// En-têtes additionnels
			 $headers = "From: ".$row_Exp['prenom_contributeurs']." ".$row_Exp['nom_contributeurs']." <".$row_Exp['mail'].">";

			
			mail($recipient, $subject, $msg, $headers);
			
			}
			

?>

<script language="JavaScript">
function envoi() 
{
//Vérification des données du formulaire

	if (document.getElementById('sujet').value != "")
		{													
				if (document.getElementById('commentaires').value != "") {
					return true;
					}
					else
					{
					window.alert('Entrez un message !')
					return false;
					}
		}
		
	else {
	window.alert('Entrez un sujet !')
	return false;
 		 }
		


} 
</script> 
<? entete();?>
<? 
//affichage du message de validation
if (isset($valider)) {

		echo "<br><br><p align='center'><font color='#009933' face='Arial, Helvetica, sans-serif' size='-1'><b><em>";
		echo "Votre message a bien été envoyé à ".$row_Dest['prenom_contributeurs']." ".$row_Dest['nom_contributeurs'];
		echo "</em></b></font></p>"; 
		echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
}

// ou affichage du formulaire
if (!isset($valider)) {
?>
<br>
<br>

<table width="750" border="0" align="center">


<tr>
	  	<td height="50" width="50"></td> 
      	<td valign="top" align="left" colspan="2"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1"><b><u>Envoyer un message à <? echo $row_Dest['prenom_contributeurs']." ".$row_Dest['nom_contributeurs'];?></u> : </b></font></td>
     	 
		 <td width="50"></td>
    </tr>
<!-- ici le début du formulaire -->
<form method="post" name="formenvoi" action="" onSubmit="return envoi()">
<tr>
			 <td width="50"></td> 
     		 <td align="right" width="200"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Sujet :</font>
    		 <td width="450"><input type="text" name="sujet" id="sujet" value="" size=60 maxlength="60"></td>
			<td width="50"></td>
</tr>

<tr>
			 <td></td> 
     		 <td valign="top" align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Votre message :</font>
    		 <td><textarea name="commentaires" id="commentaires" cols="60" rows="8"></textarea></td>
			<td width="50"></td>
</tr>
		
<tr>
	<td height="50"></td>
    <td align="center" colspan="2">
	<input type="hidden" name="destinataire" id="destinataire" value="<? echo $destinataire;?>">
	<input type="hidden" name="valider" id="valider" value="1">
	<input type="submit" name="valider" value="Envoyer le message"></td>
	<td></td>
</tr>
</form>
<!-- ici la fin du formulaire -->
</table>
<br>
<br>
<br>
<br>
<? } // fin du formulaire?>
<? pied();?>
<?
mysql_free_result($Dest); 
mysql_free_result($Exp); 
?>


