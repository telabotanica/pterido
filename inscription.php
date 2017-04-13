<?php 
// formulaire d'inscription


require './scripts/MesFonctions.php';
require_once('./scripts/PF.php');

if (isset($nom))  {
			
			$nom = trim($nom);
			$prenom = trim($prenom);
			$mail = trim($mail);
			$login = trim($login);
			
			//traitement du prenom
				$prenom = trim($prenom);
				// (-) --> esp
				$prenom = ereg_replace("-", " ", $prenom);
				//min
				$prenom = strtolower ($prenom);
				//maj de chaque mot
				$prenom = ucwords($prenom);
				//  esp --> (-)
				$prenom = ereg_replace(" ", "-", $prenom);
			
			//nom en majuscules
			$nom = strtoupper($nom);
			$nom = ereg_replace("é", "&Eacute;", $nom);
			$nom = ereg_replace("è", "&Egrave;", $nom);
			
			//verification pour eviter doublon (le login existe-t-il?)
			mysql_select_db($database_PF, $PF);
			$query_doublon = "SELECT login FROM contributeurs WHERE login = '$login' ";
			$doublon = mysql_query($query_doublon, $PF) or die(mysql_error());
			$row_doublon = mysql_fetch_assoc($doublon);
			$totalRows_doublon = mysql_num_rows($doublon);
			
			if ($totalRows_doublon == 0) {
			
			// Ajout du nouveau contributeur
			mysql_select_db($database_PF, $PF);
			$query_Ajouter = "INSERT INTO contributeurs VALUES ('', '$nom', '$prenom', '$Commune', '$mail', '$login', '$pwd', 'user' )";
			$Ajouter = mysql_query($query_Ajouter, $PF) or die(mysql_error());
			
			/*$expire = 365*24*3600; // on définit la durée du cookie, 1 an
			setcookie("pterido", $login, time()+$expire);  // on l'envoi*/
			}
			

}

mysql_select_db($database_PF, $PF);
$query_RechercherCommune = "SELECT code_insee, nom_communes FROM communes ORDER BY nom_communes ASC";
$RechercherCommune = mysql_query($query_RechercherCommune, $PF) or die(mysql_error());
$row_RechercherCommune = mysql_fetch_assoc($RechercherCommune);
$totalRows_RechercherCommune = mysql_num_rows($RechercherCommune);

mysql_select_db($database_PF, $PF);
$query_RechercherDepartement = "SELECT num_departements, nom_departements FROM departements ORDER BY num_departements";
$RechercherDepartement = mysql_query($query_RechercherDepartement, $PF) or die(mysql_error());
$row_RechercherDepartement = mysql_fetch_assoc($RechercherDepartement);
$totalRows_RechercherDepartement = mysql_num_rows($RechercherDepartement);
?>

<script language="JavaScript">
function ajout(valeur) 
{
//Vérification des données du formulaire

	if ((document.getElementById('nom').value != "") && (document.getElementById('prenom').value != "") && (valeur != "%") && (document.getElementById('mail').value != "") && (document.getElementById('login').value != "") && (document.getElementById('pwd').value != "") && (document.getElementById('pwd2').value != ""))
		{		
		
		//verification de l'@ mail
								adresse_email = document.getElementById('mail').value;
								arobase = adresse_email.indexOf("@");
								point = adresse_email.indexOf(".",arobase);
								mauvais_endroit_point = arobase+1;
								double_point = adresse_email.indexOf("..",arobase);
								nbre_carac = adresse_email.length - point;
								double_arobase = adresse_email.indexOf("@",arobase+1);
								
															   
													// dans l'ordre:         
													// si l'arobase est absente ou en 1ere position
													// ou si le . suivant l'arobase est juste derriere ou absent
													// si la longueur de l'adresse est inferieure a 5 (grand minimum -> x@x.x)
													// si il ya pas 2 . qui se suive deriere l'arobase
													// si il y a bien 2 caractere minimum apres le . situe derriere l'arobase
													// si il y a pas une arobase deriere la premiere arobase
													if ( (arobase < 1) ||  
														(point <= mauvais_endroit_point) || 
														(adresse_email.length < 5) || 
														(double_point >= 0) ||
														(nbre_carac < 3) ||
														(double_arobase >= 0) )
													   {
													   window.alert ("L'adresse email est invalide.");
													   return false;
														}
													else {
																				
																				//verification du password
																				if (document.getElementById('pwd').value == document.getElementById('pwd2').value) {
																				
																									$long_pwd = document.getElementById('pwd').value;
																									if ( $long_pwd.length < 4 ) {
																									window.alert ("Votre mot de passe est trop court!");
																									return false;
																									}
																									else { 
																									document.getElementById('Commune').value=valeur;
																									document.getElementById('formajout').submit();
																									return true;
																									}
																				
																				
																				}
																				else {
																				window.alert ("Votre mot de passe n'est pas identique dans la confirmation !");
																				return false;
																				}
													
													}
													
										
		}
		
 
	else {
	window.alert('Tous les champs obligatoires doivent être renseignés !')
	return false;
 		 }
		


} 
</script> 
<? entete();?>
<? 
//affichage du message de validation
if (isset($nom)) {
		if ($totalRows_doublon == 0) {
		echo "<br><br><p align='center'><font color='#009933' face='Arial, Helvetica, sans-serif' size='-1'><b><em>";
		echo "Bonjour ".$prenom." ".$nom.", votre inscription est validée.";
		echo "</em></b></font></p>"; 
		echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
		}
		else {
			echo "<br><br><p align='center'><font color='#CC0000' face='Arial, Helvetica, sans-serif' size='-1'><b><em>";
			echo "Ce login est déjà utilisé, veuillez en choisir un autre.";
			echo "</em></b></font></p>";
			}

}

// ou affichage du formulaire
if ((!isset($nom)) || ($totalRows_doublon != 0)) {
?>
<br>
<br>

<table width="750" border="0" align="center">


<tr>
	  	<td height="80" width="50"></td> 
      	<td width="250" colspan="2" valign="top" align="left"><img src="./images/fleche.jpg"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1"><b><u><em>VOTRE INSCRIPTION</em></u></b></font></td>
     	 
		 <td width="50"></td>
    </tr>
<!-- ici le début du formulaire -->
<form method="post" id='formajout' name="formajout" action="">
<tr>
			 <td></td> 
     		 <td align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Prénom* :</font></td>
    		 <td><input type="text" name="prenom" value="<? echo isset($prenom) ? $prenom : '';?>" size=30 maxlength="30" id="prenom"></td>
		<td width="50"></td>
</tr>

<tr>
	   <td width="50"></td>
       <td width="300" align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Nom* : </font></td>
       <td width="350"><input type="text" name="nom" value="<? echo isset($nom) ? $nom : '';?>" size=30 maxlength="30" id="nom">
	   </td>
	   <td width="50"></td>
</tr>

<tr>
			 <td width="50"></td> 
     		 <td align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Département* :</font></td>
    		 <td><select name="dep" size="1" id="dep" onChange="window.iajout.location='imenu.php?dep=' + this.options[this.selectedIndex].value + '&type=ajout'">
        	 <option value="%">-</option>
          <?php
do {  
?>
          <option value="<?php echo $row_RechercherDepartement['num_departements'];?>"><? if (strlen($row_RechercherDepartement['num_departements']) == 1) { $row_RechercherDepartement['num_departements'] = '0'.$row_RechercherDepartement['num_departements'];}?><?php echo $row_RechercherDepartement['num_departements']." - ".$row_RechercherDepartement['nom_departements'];?></option>
          <?php
} while ($row_RechercherDepartement = mysql_fetch_assoc($RechercherDepartement));
  $rows = mysql_num_rows($RechercherDepartement);
  if($rows > 0) {
      mysql_data_seek($RechercherDepartement, 0);
	  $row_RechercherDepartement = mysql_fetch_assoc($RechercherDepartement);
  }
  
  
?>
        </select>
        </td>
		<td width="50"></td>
</tr>

<tr>
			 <td width="50"></td> 
     		 <td align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Commune* :</font></td>
			 <td><iframe vspace="0" hspace="0" marginwidth="0" marginheight="0" name="iajout" height="22" width="390" style="background-color:#E4CA8B" frameborder="0" scrolling="no" src="./imenu.php?&type=ajout"></iframe></td> 
			<td width="50"></td>
    </tr>

<tr> 
	 <td></td>
     <td align="right" valign="top"><p><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Adresse e-mail* :</font></p></td>
	 <td align="left"><input type="text" name="mail" value="<? echo isset($mail) ? $mail : '';?>" size=50 maxlength="50" id="mail"></td>
	 <td></td>
</tr>
	
<tr> 
	 <td></td>
     <td align="right" valign="top"><p><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">login* :</font></p></td>
	 <td align="left"><input type="text" name="login" value="<? echo isset($login) ? $login : '';?>" size=50 maxlength="50" id="login"></td>
	 <td></td>
</tr>

<tr> 
	 <td></td>
     <td align="right" valign="top"><p><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Mot de passe (au moins 4 caractères)* :</font></p></td>
	 <td align="left"><input type="password" name="pwd" value="<? echo isset($pwd) ? $pwd : '';?>" size=20 maxlength="20" id="pwd"></td>
	 <td></td>
</tr>

<tr> 
	 <td></td>
     <td align="right" valign="top"><p><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Confirmation Mot de passe* :</font></p></td>
	 <td align="left"><input type="password" name="pwd2" value="<? echo isset($pwd2) ? $pwd2 : '';?>" size=20 maxlength="20" id="pwd2"></td>
	 <td></td>
</tr>
				
<tr>
	<td></td> 
	<td align="right"><input type="hidden" name="Commune" id="Commune"></td>
    <td align="left"><input type="button" name="valider" value="  Valider   " onclick="ajout(window.iajout.document.iform.Commune.value);"></td>
	<td></td>
</tr>
</form>
<tr>
	<td></td>
	<td colspan="2" align="justify"><br><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">* <em>Champs obligatoires</em></font><br><br></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td colspan="2" align="justify"><br><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1"><em>Ces informations personnelles seront utilisées exclusivement pour l'identification sur la base de données.</em></font><br><br></td>
	<td></td>
</tr>
<!-- ici la fin du formulaire -->
</table>
<? } // fin du formulaire?>
<? pied();?>
<?
mysql_free_result($RechercherCommune);
mysql_free_result($RechercherDepartement);
if ($totalRows_doublon != 0) { mysql_free_result($doublon); }
?>


