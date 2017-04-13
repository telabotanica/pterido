<?php 
// page d'ajout d'une contribution


require './scripts/MesFonctions.php';
require_once('./scripts/PF.php');


/**********************************    vérification de la session   ******************************************/
session_start(); // On relaye la session
if (isset($_SESSION["authentification"])){ // vérification sur la session authentification (la session est elle enregistrée ?)
// ici les éventuelles actions en cas de réussite de la connexion
}
else {
header("Location:login.php?action=ajouter&erreur=intru"); // redirection en cas d'echec
}
//*************************************************************************************************************

if (!isset($NumTaxon))  { $type = "ajout";}

if (isset($NumTaxon))  {
			//checkbox
			if ($herbier == '') { $herbier = 0 ;}
			if ($photo == '') { $photo = 0 ;}
			
			// récupération des sauts de ligne et apostrophes
			$commentaires = ereg_replace("\r", "<br>", $commentaires);
			$commentaires = ereg_replace("\"", "&quot;", $commentaires);
			
			//récupération de la date
			$date = $annee."-".$mois."-".$jour;
			$date_saisie = date("Y-m-d");
			
			//identification du contributeur
			$id_session = $_SESSION['id_contributeurs'];
			
			
			// Ajout de l'observation
			mysql_select_db($database_PF, $PF);
			$query_Ajouter = "INSERT INTO contributions VALUES ('', '$date', '$Commune', '$id_session', '$NumTaxon', '$commentaires', '$date_saisie', '$herbier', '$photo')";
			$Ajouter = mysql_query($query_Ajouter, $PF) or die(mysql_error());
			
			
			//réaffichage du nom du dep et du nom de la commune
			mysql_select_db($database_PF, $PF);
			$query_RechercherDepartement2 = "SELECT nom_departements FROM departements where num_departements = '$dep'";
			$RechercherDepartement2 = mysql_query($query_RechercherDepartement2, $PF) or die(mysql_error());
			$row_RechercherDepartement2 = mysql_fetch_assoc($RechercherDepartement2);
			$totalRows_RechercherDepartement2 = mysql_num_rows($RechercherDepartement2);
			
			mysql_select_db($database_PF, $PF);
			$query_RechercherCommune  = "SELECT nom_communes FROM communes where code_insee = '$Commune' ";
			$RechercherCommune = mysql_query($query_RechercherCommune, $PF) or die(mysql_error());
			$row_RechercherCommune = mysql_fetch_assoc($RechercherCommune);
			$totalRows_RechercherCommune = mysql_num_rows($RechercherCommune);
			
			

}

mysql_select_db($database_PF, $PF);
$query_RechercherNumTaxon = "SELECT * FROM pterido ORDER BY Genre, Espece, SousEspece";
$RechercherNumTaxon = mysql_query($query_RechercherNumTaxon, $PF) or die(mysql_error());
$row_RechercherNumTaxon = mysql_fetch_assoc($RechercherNumTaxon);
$totalRows_RechercherNumTaxon = mysql_num_rows($RechercherNumTaxon);

mysql_select_db($database_PF, $PF);
$query_RechercherDepartement = "SELECT num_departements, nom_departements FROM departements ORDER BY num_departements";
$RechercherDepartement = mysql_query($query_RechercherDepartement, $PF) or die(mysql_error());
$row_RechercherDepartement = mysql_fetch_assoc($RechercherDepartement);
$totalRows_RechercherDepartement = mysql_num_rows($RechercherDepartement);
?>
<? entete();?>

<script language="JavaScript">

function ajout(valeur) 
{

//Vérification des données du formulaire

	if ((document.getElementById('jour').value != "") && (document.getElementById('mois').value != "") && (document.getElementById('annee').value != "") && (document.getElementById('NumTaxon').value != "") && (valeur != "%"))
		{		
		
		//verification du textarea
 			y = 800;
			 x = document.getElementById('commentaires').value.length; 

 			if (x < y) {
						document.getElementById('Commune').value=valeur;
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


<? 
//affichage du message de validation
if (isset($NumTaxon)) {
		
		echo "<br><br><p align='center'><font color='#009933' face='Arial, Helvetica, sans-serif' size='-1'><b><em>";
		echo "Votre observation concernant le taxon &quot; ".$NumTaxon." &quot; a bien a été ajoutée.";
		echo "</em></b></font></p>"; 

}

// ou affichage du formulaire

?>
<br>
<br>

<table width="750" border="0" align="center">

<!-- ici le début du formulaire -->
<form method="post" id='formajout' name="formajout" action="">
<tr>
	  	<td height="80" width="50"></td> 
      	<td colspan="2" valign="top" align="left"><img src="./images/fleche.jpg">
		<? if (isset($NumTaxon)) {?><em><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1"><b><u>AUTRE AJOUT</u></b></font></em><? } //titre 
		else {?>
		<em><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1"><b><u>AJOUTER UNE OBSERVATION</u></b></font></em>
     	 <? } ?>
		 </td>
		 <td width="50"></td>
    </tr>
<tr>
	   <td width="50"></td>
       <td width="150" align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Date d'observation* : </font></td>
       <td width="500">
	   <select name="jour" size="1" id="jour">
        	  <? if (isset($jour)) {?><option value="<? echo $jour;?>"><? echo $jour;?></option><? } else {?><option value="">-</option><? } ?>
		<? for ($j=1; $j < 32; $j++) {?>
		<? if (strlen($j) == 1) { $j = '0'.$j;}?>	  
		<option value="<? echo $j;?>"><? echo $j;?></option>
		<? }?>
		</select>
		
		<select name="mois" size="1" id="mois">
        	  <? if (isset($mois)) {?><option value="<? echo $mois;?>"><? echo $mois;?></option><? } else {?><option value="">-</option><? } ?>
		<? for ($m=1; $m < 13; $m++) {?>
		<? if (strlen($m) == 1) { $m = '0'.$m;}?>	  
		<option value="<? echo $m;?>"><? echo $m;?></option>
		<? }?>
		</select>
		
		<select name="annee" size="1" id="annee">
        	  <? if (isset($annee)) {?><option value="<? echo $annee;?>"><? echo $annee;?></option><? } else {?><option value="">-</option><? } ?>
		<? for ($a=2000; $a <= date(Y); $a++) {?>	  
		<option value="<? echo $a;?>"><? echo $a;?></option>
		<? }?>
		</select>
	   </td>
	   <td width="50"></td>
</tr>

<tr>
			 <td></td> 
     		 <td align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Taxon observé* :</font></td>
    		 <td><select name="NumTaxon" size="1" id="NumTaxon" style="font-size:8pt;">
        	  <option value="">-</option>	  
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

<tr>
			 <td width="50"></td> 
     		 <td align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Département* :</font></td>
    		 <td><select name="dep" size="1" id="dep" onChange="window.iajout.location='imenu.php?dep=' + this.options[this.selectedIndex].value + '&type=ajout'">
        	 <? if (isset($dep)) {?><option value="<? echo $dep;?>"><? if (strlen($dep) == 1) { $dep = '0'.$dep;}?><? echo $dep." - ".$row_RechercherDepartement2['nom_departements'];?></option><? } else {?><option value="">-</option><? } ?>
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
			 <td><iframe id="iajout" vspace="0" hspace="0" marginwidth="0" marginheight="0" name="iajout" height="22" width="390" style="background-color:#E4CA8B" frameborder="0" scrolling="no" src="./imenu.php?Commune=<? echo $Commune;?>&nom_communes=<? echo $row_RechercherCommune['nom_communes'];?>&dep=<? echo $dep;?><? if (isset($type)) {echo "&type=ajout";}?>"></iframe></td> 
			<td width="50"></td>
    </tr>

<tr> 
	 <td></td>
     <td align="right" valign="top"><p><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Echantillon :</font></p></td>
	 <td align="left">
	 <font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">
	 <input type="checkbox" name="herbier" id="herbier" value="1"> herbier
	 <input type="checkbox" name="photo" id="photo" value="1"> photo
	 </font></td>
	 <td></td>
</tr>

<tr> 
	 <td></td>
     <td align="right" valign="top"><p><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Commentaire :</font></p></td>
	 <td align="left"><textarea name="commentaires" cols="55" rows="6" id="commentaires"></textarea></td>
	 <td></td>
</tr>
					
<tr>
	<td></td> 
	<td align="right">
	<input type="hidden" name="Commune" id="Commune">
	</td>
    <td align="left"><input type="button" name="ok" value="  Ajouter   " onclick="ajout(window.iajout.document.iform.Commune.value);"></td>
	<td></td>
</tr>

<tr>
	<td></td>
	<td colspan="2" align="justify"><br><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">* <em>Champs obligatoires</em></font><br><br></td>

	<td></td>
</tr>
</form>
<!-- ici la fin du formulaire -->
</table>
<? pied();?>
<?
mysql_free_result($RechercherNumTaxon);
mysql_free_result($RechercherDepartement);
if (isset($NumTaxon)) { mysql_free_result($RechercherDepartement2); mysql_free_result($RechercherCommune);}
?>


