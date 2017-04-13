<?php 
// page de modification d'une contribution


require './scripts/MesFonctions.php';
require_once('./scripts/PF.php');

/**********************************    vérification de la session   ******************************************/
session_start(); // On relaye la session
if ($_SESSION(["authentification"])){ // vérification sur la session authentification (la session est elle enregistrée ?)
// ici les éventuelles actions en cas de réussite de la connexion
}
else {
header("Location:login.php?action=modifier&erreur=intru"); // redirection en cas d'echec
}
//*************************************************************************************************************

// si c'est une suppression
if ($d == 1) {
			entete();
			
			//recherche de la contrib
			mysql_select_db($database_PF, $PF);
			$query_del = "SELECT * FROM contributions WHERE id_contributions = '$id_contributions' ";
			$del = mysql_query($query_del, $PF) or die(mysql_error());
			$row_del = mysql_fetch_assoc($del);
			$totalRows_del = mysql_num_rows($del);
			
			if ($totalRows_del == 1) { // si elle existe on la supprime
			mysql_select_db($database_PF, $PF);
			$query_del_valide = "DELETE FROM contributions WHERE id_contributions = '$id_contributions' ";
			$del_valide = mysql_query($query_del_valide, $PF) or die(mysql_error());
			
			echo "<br><br><p align='center'><font color='#009933' face='Arial, Helvetica, sans-serif' size='-1'><b><em>";
			echo "La contribution a bien été supprimée.";
			echo "</em></b></font></p>";
			echo "<br><br><br><br><br>"; 
			}
			else { //si elle n'existe pas
			echo "<br><br><p align='center'><font color='#CC0000' face='Arial, Helvetica, sans-serif' size='-1'><b><em>";
			echo "Cette contribution a déjà été supprimée.";
			echo "</em></b></font></p>";
			echo "<br><br><br><br><br>"; 
			}
			
			?>
			<table width="700" border="0" align="center">
			<tr><td align="center">
			<form name="retour" method="post" action="resultat.php">
						<input name="Famille" style="display:none" value="<? echo $Famille; ?>">
						<input name="Genre" style="display:none" value="<? echo $Genre; ?>">
						<input name="Espece" style="display:none" value="<? echo $Espece; ?>">
						<input name="Rang" style="display:none" value="<? echo $Rang; ?>">
						<input name="LivreRouge" style="display:none" value="<? echo $LivreRouge; ?>">
						<input name="Hybride" style="display:none" value="<? echo $Hybride; ?>">
						<input name="Contributeur" style="display:none" value="<? echo $Contributeur; ?>">
						<input name="dep" style="display:none" value="<? echo $dep; ?>">
						<input name="Commune" style="display:none" value="<? echo $Commune; ?>">
						 <input name="page_en_cours" style="display:none" value="<? echo $page_en_cours; ?>">
						 <input name="w" style="display:none" value="<? echo $w; ?>">
						 <input name="NumTaxon" style="display:none" value="<? echo $NumTaxon; ?>">
						<input name="date_saisie" style="display:none" value="<? echo $date_saisie; ?>">
						<INPUT name="retour" type="submit" value=" Retour à la liste ">
	 		</form>
			</td></tr>
			</table>
			<? 
			mysql_free_result($del);
			echo "<br><br><br><br><br><br><br><br>";
			pied();
}
//si c'est une modification
else { //début modification
if (isset($valider))  {
			//checkbox
			if ($herbier == '') { $herbier = 0 ;}
			if ($photo == '') { $photo = 0 ;}
			
			// récupération des sauts de ligne
			$commentaires = ereg_replace("\r", "<br>", $commentaires);
			$commentaires = ereg_replace("\"", "&quot;", $commentaires);
			
			//récupération de la date
			$date = $annee."-".$mois."-".$jour;
			
			// Mise à jour de l'observation
			mysql_select_db($database_PF, $PF);
			$query_Update = "UPDATE contributions SET date='$date', code_insee = '$CommuneContrib', id_contributeurs = '$ContributeurContrib', NumTaxon = '$NumTaxonContrib', commentaire = '$commentaires', herbier = '$herbier', photo = '$photo' where id_contributions = '$id_contributions' ";
			$Update = mysql_query($query_Update, $PF) or die(mysql_error());
			
}

mysql_select_db($database_PF, $PF);
$query_RechercherCommune = "SELECT code_insee, nom_communes FROM communes ORDER BY nom_communes ASC";
$RechercherCommune = mysql_query($query_RechercherCommune, $PF) or die(mysql_error());
$row_RechercherCommune = mysql_fetch_assoc($RechercherCommune);
$totalRows_RechercherCommune = mysql_num_rows($RechercherCommune);

mysql_select_db($database_PF, $PF);
$query_RechercherNumTaxon = "SELECT * FROM pterido ORDER BY Genre, Espece, SousEspece";
$RechercherNumTaxon = mysql_query($query_RechercherNumTaxon, $PF) or die(mysql_error());
$row_RechercherNumTaxon = mysql_fetch_assoc($RechercherNumTaxon);
$totalRows_RechercherNumTaxon = mysql_num_rows($RechercherNumTaxon);

mysql_select_db($database_PF, $PF);
$query_RechercherNumTaxon2 = "SELECT * FROM pterido where NumTaxon = '$NumTaxonContrib' ";
$RechercherNumTaxon2 = mysql_query($query_RechercherNumTaxon2, $PF) or die(mysql_error());
$row_RechercherNumTaxon2 = mysql_fetch_assoc($RechercherNumTaxon2);
$totalRows_RechercherNumTaxon2 = mysql_num_rows($RechercherNumTaxon2);

mysql_select_db($database_PF, $PF);
$query_RechercherContributeur = "SELECT id_contributeurs, prenom_contributeurs, nom_contributeurs  FROM contributeurs ORDER BY nom_contributeurs";
$RechercherContributeur = mysql_query($query_RechercherContributeur, $PF) or die(mysql_error());
$row_RechercherContributeur = mysql_fetch_assoc($RechercherContributeur);
$totalRows_RechercherContributeur = mysql_num_rows($RechercherContributeur);

mysql_select_db($database_PF, $PF);
$query_RechercherDepartement = "SELECT num_departements, nom_departements FROM departements ORDER BY num_departements";
$RechercherDepartement = mysql_query($query_RechercherDepartement, $PF) or die(mysql_error());
$row_RechercherDepartement = mysql_fetch_assoc($RechercherDepartement);
$totalRows_RechercherDepartement = mysql_num_rows($RechercherDepartement);

mysql_select_db($database_PF, $PF);
$query_RechercherEchantillon = "SELECT herbier, photo FROM contributions where id_contributions = '$id_contributions' ";
$RechercherEchantillon = mysql_query($query_RechercherEchantillon, $PF) or die(mysql_error());
$row_RechercherEchantillon = mysql_fetch_assoc($RechercherEchantillon);
$totalRows_RechercherEchantillon = mysql_num_rows($RechercherEchantillon);

$jour = substr($date,8); 
$mois = substr($date,5,2) ;
$annee = substr($date,0,4) ;
?>

<script language="JavaScript">
function ajout(valeur) 
{
//Vérification des données du formulaire

	if ((document.getElementById('jour').value != "") && (document.getElementById('mois').value != "") && (document.getElementById('annee').value != "") && (document.getElementById('NumTaxonContrib').value != "") && (document.getElementById('ContributeurContrib').value != "") && (valeur != "%"))
		{		
		
		//verification du textarea
 			y = 800;
			 x = document.getElementById('commentaires').value.length; 

 			if (x < y) {
						document.getElementById('CommuneContrib').value=valeur;
						document.getElementById('formajout').submit();
						return true;							
						}
					
					 else {
 			 		window.alert('Votre commentaire est trop long !')
			 		return false;
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
if (isset($valider)) {
		
		echo "<br><br><p align='center'><font color='#009933' face='Arial, Helvetica, sans-serif' size='-1'><b><em>";
		echo "La mise à jour de l'observation a bien été réalisée.";
		echo "</em></b></font></p>";
		echo "<br><br><br><br><br><br>"; 
		?>
		<table width="700" border="0" align="center">
		<tr>
					<td width="50"></td>
					<td width="600" align="center">
					<form name="retour" method="post" action="resultat.php">
						<input name="Famille" style="display:none" value="<? echo $Famille; ?>">
						<input name="Genre" style="display:none" value="<? echo $Genre; ?>">
						<input name="Espece" style="display:none" value="<? echo $Espece; ?>">
						<input name="Rang" style="display:none" value="<? echo $Rang; ?>">
						<input name="LivreRouge" style="display:none" value="<? echo $LivreRouge; ?>">
						<input name="Hybride" style="display:none" value="<? echo $Hybride; ?>">
						<input name="Contributeur" style="display:none" value="<? echo $Contributeur; ?>">
						<input name="dep" style="display:none" value="<? echo $dep; ?>">
						<input name="Commune" style="display:none" value="<? echo $Commune; ?>">
						 <input name="page_en_cours" style="display:none" value="<? echo $page_en_cours; ?>">
						 <input name="w" style="display:none" value="<? echo $w; ?>">
						 <input name="NumTaxon" style="display:none" value="<? echo $NumTaxon; ?>">
						<input name="date_saisie" style="display:none" value="<? echo $date_saisie; ?>">
						<INPUT name="retour" type="submit" value=" Retour à la liste ">
	  					</form>
					</td>
					<td width="50"></td>
		</tr>
		</table>
				<? echo "<br><br><br><br><br><br><br><br>";
}
//sinon affichage du formulaire
else 
{ ?>
<br>
<br>
<table width="750" border="0" align="center">


<tr>
	  	<td height="80" width="50"></td> 
      	<td colspan="2" valign="top" align="left"><img src="./images/fleche.jpg"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1"><b><u>MODIFICATION DE LA CONTRIBUTION</u></b></font></td>
     	 
		 <td width="50"></td>
    </tr>
<!-- ici le début du formulaire -->
<form method="post" id="formajout" name="formajout" action="">
<tr>
	   <td width="50"></td>
       <td width="150" align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Date* : </font></td>
       <td width="500">
	   <select name="jour" size="1" id="jour">
        	  <option value="<? echo $jour;?>"><? echo $jour;?></option>
		<? for ($j=1; $j < 32; $j++) {?>
		<? if (strlen($j) == 1) { $j = '0'.$j;}?>	  
		<option value="<? echo $j;?>"><? echo $j;?></option>
		<? }?>
		</select>
		
		<select name="mois" size="1" id="mois">
        	  <option value="<? echo $mois;?>"><? echo $mois;?></option>
		<? for ($m=1; $m < 13; $m++) {?>
		<? if (strlen($m) == 1) { $m = '0'.$m;}?>	  
		<option value="<? echo $m;?>"><? echo $m;?></option>
		<? }?>
		</select>
		
		<select name="annee" size="1" id="annee">
        	  <option value="<? echo $annee;?>"><? echo $annee;?></option>
		<? for ($a=2001; $a <= date(Y); $a++) {?>	  
		<option value="<? echo $a;?>"><? echo $a;?></option>
		<? }?>
		</select>
	   </td>
	   <td width="50"></td>
</tr>

<tr>
			 <td></td> 
     		 <td align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Taxon* :</font></td>
    		 <td>
		  
			 <select name="NumTaxonContrib" size="1" id="NumTaxonContrib" style="font-size:8pt;">
        	  <option value="<? echo $NumTaxonContrib;?>"><? echo $row_RechercherNumTaxon2['Genre']." ".$row_RechercherNumTaxon2['Espece']." ".$row_RechercherNumTaxon2['TypeSousEspece']." ".$row_RechercherNumTaxon2['SousEspece']." ".$row_RechercherNumTaxon2['TypeInfra2']." ".$row_RechercherNumTaxon2['Infra2']." ".$row_RechercherNumTaxon2['TypeInfra3'],$row_RechercherNumTaxon2['Infra3'];?></option>
          <?php
do {  
?>
          
		  <option value="<?php echo $row_RechercherNumTaxon['NumTaxon']?>"><? echo $row_RechercherNumTaxon['Genre']." ".$row_RechercherNumTaxon['Espece']." ".$row_RechercherNumTaxon['TypeSousEspece']." ".$row_RechercherNumTaxon['SousEspece']." ".$row_RechercherNumTaxon['TypeInfra2']." ".$row_RechercherNumTaxon['Infra2']." ".$row_RechercherNumTaxon['TypeInfra3'],$row_RechercherNumTaxon['Infra3'];?></option>
          <?php
} while ($row_RechercherNumTaxon = mysql_fetch_assoc($RechercherNumTaxon));
  $rows = mysql_num_rows($RechercherNumTaxon);
  if($rows > 0) {
      mysql_data_seek($RechercherNumTaxon, 0);
	  $row_RechercherNumTaxon = mysql_fetch_assoc($RechercherNumTaxon);
  }
?>
        </select> </td>
		<td width="50"></td>
</tr>

<? if ($_SESSION['privilege'] == 'admin') { // modification du contrib que si admin ?>
							<tr>
										 <td></td> 
										 <td align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Contributeur* :</font></td>
										 <td><select name="ContributeurContrib" size="1" id="ContributeurContrib">
										  <option value="<? echo $n_contributeurs;?>"><? echo $nom_contributeurs." ".$prenom_contributeurs;?></option>
									  <?php
							do {  
							?>
									  <option value="<?php echo $row_RechercherContributeur['id_contributeurs']?>"><?php echo $row_RechercherContributeur['nom_contributeurs']." ".$row_RechercherContributeur['prenom_contributeurs'];?></option>
									  <?php
							} while ($row_RechercherContributeur = mysql_fetch_assoc($RechercherContributeur));
							  $rows = mysql_num_rows($RechercherContributeur);
							  if($rows > 0) {
								  mysql_data_seek($RechercherContributeur, 0);
								  $row_RechercherContributeur = mysql_fetch_assoc($RechercherContributeur);
							  }
							?>
									</select> </td>
									<td width="50"></td>
							</tr>
							
<? } // fin modif du contrib 
else { ?>
<input type="hidden" name="ContributeurContrib" value="<? echo $n_contributeurs;?>" id="ContributeurContrib">
<? } ?>

<tr>
			 <td width="50"></td> 
     		 <td align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Département* :</font></td>
    		 <td><select name="depContrib" size="1" id="dep" onChange="window.iajout.location='imenu.php?dep=' + this.options[this.selectedIndex].value">
        	 <option value="<? echo $depContrib;?>"><? echo $depContrib." - ".$nom_dep;?></option>
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
			 <td><iframe vspace="0" hspace="0" marginwidth="0" marginheight="0" name="iajout" height="22" width="390" style="background-color:#E4CA8B" frameborder="0" scrolling="no" src="./imenu.php?Commune=<? echo $CommuneContrib;?>&nom_communes=<? echo $nom_communes;?>"></iframe></td> 
			<td width="50"></td>
</tr>

<tr> 
	 <td></td>
     <td align="right" valign="top"><p><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Echantillon :</font></p></td>
	 <td align="left">	
	<font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">
	 <input type="checkbox" name="herbier" id="herbier" value="1" <? if ($row_RechercherEchantillon['herbier'] == 1) { echo "checked"; } ?>> herbier
	 <input type="checkbox" name="photo" id="photo" value="1" <? if ($row_RechercherEchantillon['photo'] == 1) { echo "checked"; } ?> > photo
	 </font></td>
</tr>

<tr> 
	 <td></td>
     <td align="right" valign="top"><p><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Commentaires :</font></p></td>
	 <td align="left">
	 <? 
	 // récupération des sauts de ligne et apostrophes
			$commentaires = ereg_replace("<br>", "\r", $commentaires);

	 ?>
	 <textarea name="commentaires" value="" cols="55" rows="6" id="commentaires"><? echo stripslashes($commentaires);?></textarea></td>
	 <td></td>
</tr>
					
<tr>
	<td></td> 
	<td align="right"><input type="hidden" name="CommuneContrib" id="CommuneContrib"></td>
    <td align="center">
	<input type="button" name="ok" value="  Mettre à jour   " onclick="ajout(window.iajout.document.iform.Commune.value);"></td>
	<input name="valider" style="display:none" value="1">
	<input name="id_contributions" style="display:none" value="<? echo $id_contributions;?>">
	
	<input name="Famille" style="display:none" value="<? echo $Famille; ?>">
	<input name="Genre" style="display:none" value="<? echo $Genre; ?>">
	<input name="Espece" style="display:none" value="<? echo $Espece; ?>">
	<input name="Rang" style="display:none" value="<? echo $Rang; ?>">
	<input name="LivreRouge" style="display:none" value="<? echo $LivreRouge; ?>">
	<input name="Hybride" style="display:none" value="<? echo $Hybride; ?>">
	<input name="Contributeur" style="display:none" value="<? echo $Contributeur; ?>">
	<input name="dep" style="display:none" value="<? echo $dep; ?>">
	<input name="Commune" style="display:none" value="<? echo $Commune; ?>">
	<input name="page_en_cours" style="display:none" value="<? echo $page_en_cours; ?>">
	<input name="w" style="display:none" value="<? echo $w; ?>">
	<input name="NumTaxon" style="display:none" value="<? echo $NumTaxon; ?>">
	<input name="date_saisie" style="display:none" value="<? echo $date_saisie; ?>">
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
	<td colspan="2" align="justify">
	<form name="retour" method="post" action="resultat.php">
						<input name="Famille" style="display:none" value="<? echo $Famille; ?>">
						<input name="Genre" style="display:none" value="<? echo $Genre; ?>">
						<input name="Espece" style="display:none" value="<? echo $Espece; ?>">
						<input name="Rang" style="display:none" value="<? echo $Rang; ?>">
						<input name="LivreRouge" style="display:none" value="<? echo $LivreRouge; ?>">
						<input name="Hybride" style="display:none" value="<? echo $Hybride; ?>">
						<input name="Contributeur" style="display:none" value="<? echo $Contributeur; ?>">
						<input name="dep" style="display:none" value="<? echo $dep; ?>">
						<input name="Commune" style="display:none" value="<? echo $Commune; ?>">
						 <input name="page_en_cours" style="display:none" value="<? echo $page_en_cours; ?>">
						 <input name="w" style="display:none" value="<? echo $w; ?>">
						 <input name="NumTaxon" style="display:none" value="<? echo $NumTaxon; ?>">
						<input name="date_saisie" style="display:none" value="<? echo $date_saisie; ?>">
						<INPUT name="retour" type="submit" value=" << Retour à la liste ">
	 </form>
	</td>
	<td></td>
</tr>
<!-- ici la fin du formulaire -->
</table>
<? } //fin de l'affichage ?>
<? pied();?>
<?
mysql_free_result($RechercherCommune);
mysql_free_result($RechercherDepartement);
mysql_free_result($RechercherNumTaxon);
mysql_free_result($RechercherNumTaxon2);
mysql_free_result($RechercherContributeur);
mysql_free_result($RechercherEchantillon);
}//fin de la modification
?>


