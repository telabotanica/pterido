<?php 
// formulaire d'envoi


require './scripts/MesFonctions.php';
require_once('./scripts/PF.php');

if (isset($login))  {
			
			
			//verification du login (le login existe-t-il?)
			
			$login = trim($login);
			
			mysql_select_db($database_PF, $PF);
			$query_doublon = "SELECT prenom_contributeurs, nom_contributeurs, login, pass, mail FROM contributeurs WHERE login = '$login' ";
			$doublon = mysql_query($query_doublon, $PF) or die(mysql_error());
			$row_doublon = mysql_fetch_assoc($doublon);
			$totalRows_doublon = mysql_num_rows($doublon);
			
			if ($totalRows_doublon == 1) {
			
			$password = $row_doublon['pass'];
			$recipient = $row_doublon['mail'];
			$prenom = $row_doublon['prenom_contributeurs'];
			$nom = $row_doublon['nom_contributeurs'];
			
			$msg = "Bonjour ".$prenom." ".$nom.",\n\n";
			$msg .= "Votre login : \n";
			$msg .= $login."\n\n";
			$msg .= "Votre mot de passe : \n";
			$msg .= "****************************************************\n";
			$msg .= $password."\n";
			$msg .= "****************************************************\n\n";
			$msg .= "Rendez-vous sur : http://pterido.tela-botanica.org/ \n";
			$msg .= "\n\n\n Bien cordialement,";
			
			$subject = "Votre mot de passe pour le site web PTERIDO";
			
			$mailheaders = "From: pterido@free.fr";
			
			
			mail($recipient, $subject, $msg, $mailheaders);
			}
			

}

?>

<script language="JavaScript">
function ajout() 
{
//Vérification des données du formulaire

	if ( (document.getElementById('login').value != "") )
		{													
		document.getElementById('formajout').submit();
		return true;									
		}
		
 
	else {
	window.alert('Entrez votre login !')
	return false;
 		 }
		


} 
</script> 
<? entete();?>
<? 
//affichage du message de validation
if (isset($login)) {
		if ($totalRows_doublon == 1) {
		echo "<br><br><p align='center'><font color='#009933' face='Arial, Helvetica, sans-serif' size='-1'><b><em>";
		echo "Votre mot de passe vous a été envoyé par mail.";
		echo "</em></b></font></p>"; 
		echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
		}
		else {
			echo "<br><br><p align='center'><font color='#CC0000' face='Arial, Helvetica, sans-serif' size='-1'><b><em>";
			echo "Le login &quot; ".$login."&quot;  n'existe pas, veuillez vérifier votre login.";
			echo "</em></b></font></p>";
			}

}

// ou affichage du formulaire
if ((!isset($login)) || ($totalRows_doublon == 0)) {
?>
<br>
<br>

<table width="750" border="0" align="center">


<tr>
	  	<td height="50" width="50"></td> 
      	<td width="250" valign="top" align="left"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1"><b><u>Mot de passe oublié ...</u></b></font></td>

<tr>
	<td height="50"></td>
    <td align="left"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Entrez votre login, et cliquez sur "envoyer" pour recevoir votre mot de passe par e-mail :</font></td>
	<td></td>
</tr>
     	 
		 <td width="50"></td>
    </tr>
<!-- ici le début du formulaire -->
<form method="post" id='formajout' name="formajout" action="">
<tr>
			 <td></td> 
     		 <td align="center"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Tapez votre login :</font>
    		 <input type="text" name="login" value="<? echo isset($login) ? $login : '';?>" size=30 maxlength="50" id="login">
		<td width="50"></td>
</tr>
		
<tr>
	<td height="50"></td>
    <td align="center"><input type="button" name="valider" value="  Envoyer   " onclick="ajout();"></td>
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
if (! empty($totalRows_doublon)) { mysql_free_result($doublon); }
?>


