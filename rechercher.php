<?php
// page de recherche
session_start();

require './scripts/MesFonctions.php';
require_once('./scripts/PF.php');

$w = isset($_REQUEST['w']) ? $_REQUEST['w'] : null;
 
mysql_select_db($database_PF, $PF);
$query_RechercherFamille = "SELECT distinct Famille FROM pterido ORDER BY Famille ASC";
$RechercherFamille = mysql_query($query_RechercherFamille, $PF) or die(mysql_error());
$row_RechercherFamille = mysql_fetch_assoc($RechercherFamille);
$totalRows_RechercherFamille = mysql_num_rows($RechercherFamille);

mysql_select_db($database_PF, $PF);
$query_RechercherContributeur = "SELECT id_contributeurs, prenom_contributeurs, nom_contributeurs FROM contributeurs ORDER BY nom_contributeurs ASC";
$RechercherContributeur = mysql_query($query_RechercherContributeur, $PF) or die(mysql_error());
$row_RechercherContributeur = mysql_fetch_assoc($RechercherContributeur);
$totalRows_RechercherContributeur = mysql_num_rows($RechercherContributeur);

mysql_select_db($database_PF, $PF);
$query_RechercherDepartement = "SELECT num_departements, nom_departements FROM departements ORDER BY num_departements";
$RechercherDepartement = mysql_query($query_RechercherDepartement, $PF) or die(mysql_error());
$row_RechercherDepartement = mysql_fetch_assoc($RechercherDepartement);
$totalRows_RechercherDepartement = mysql_num_rows($RechercherDepartement);

mysql_select_db($database_PF, $PF);
$query_RechercherNumTaxon = "SELECT * FROM pterido ORDER BY Genre, Espece, SousEspece";
$RechercherNumTaxon = mysql_query($query_RechercherNumTaxon, $PF) or die(mysql_error());
$row_RechercherNumTaxon = mysql_fetch_assoc($RechercherNumTaxon);
$totalRows_RechercherNumTaxon = mysql_num_rows($RechercherNumTaxon);

entete();?>

<STYLE type="text/css">  
#Genre {color: #999999}
#Espece {color: #999999}
</STYLE>

<SCRIPT language="javascript">
function valide(valeur)
{ 
	document.getElementById('Commune').value=valeur; 
}

function effaceGenre()
{
document.getElementById('Genre').value = '';
document.getElementById('Genre').id = '';
}

function effaceEspece()
{
document.getElementById('Espece').value = '';
document.getElementById('Espece').id = '';
}
</script>

<form name="form_recherche" method="post" action="resultat.php">

<table width="750" align="center">
	<tr>
	  	<td height="100" width="50"></td> 
      	<td valign="middle" align="left" colspan="2"><img src="./images/fleche.jpg"><em><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1"><b><u>
		<? if ($w == 1) {
						echo "QUELLE(S) OBSERVATION(S) SOUHAITEZ VOUS MODIFIER ?"; 
						}
			else {
			echo "RECHERCHE D'OBSERVATIONS PAR CRITERES";
			}
		$type = "rech" ; //déclaration de variable ?>
		   </u></b></font></em></td>
		 <td width="50"></td>
    </tr>
    
	<tr>
			 <td></td> 
     		 <td align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Taxon :</font></td>
    		 <td><select name="NumTaxon" size="1" id="NumTaxon" style="font-size:8pt;" onchange="this.style.color = this.options[selectedIndex].style.color;">
        	  <option value="" style="color:#999999;">-- Indifférent --</option>	  
						  <?php
				do {  
				?>
						  <option title="<?php echo $row_RechercherNumTaxon['FormuleHybridation']?>" value="<?php echo $row_RechercherNumTaxon['NumTaxon']?>" style="color:#000000;"><? echo $row_RechercherNumTaxon['Genre']." ".$row_RechercherNumTaxon['Espece']." ".$row_RechercherNumTaxon['TypeSousEspece']." ".$row_RechercherNumTaxon['SousEspece']." ".$row_RechercherNumTaxon['TypeInfra2']." ".$row_RechercherNumTaxon['Infra2']." ".$row_RechercherNumTaxon['TypeInfra3'],$row_RechercherNumTaxon['Infra3'];?></option>
						  <?php
				} while ($row_RechercherNumTaxon = mysql_fetch_assoc($RechercherNumTaxon));
				  $rows = mysql_num_rows($RechercherNumTaxon);
				  if($rows > 0) {
					  mysql_data_seek($RechercherNumTaxon, 0);
					  $row_RechercherNumTaxon = mysql_fetch_assoc($RechercherNumTaxon);
				  }
				?>
						</select> </td>
			<td></td>
	</tr>
	
	<tr>
	  <td width="50"></td> 
      <td height="30"></td>
      <td><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">&nbsp;</font></td>
	  <td width="50"></td>
    </tr>
	
    <tr>
			 <td width="50"></td> 
     		 <td width="170" align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Famille :</font></td>
    		 <td width="480"><select name="Famille" size="1" id="Famille" onchange="this.style.color = this.options[selectedIndex].style.color;">
           <option value="%" style="color:#999999;">-- Indifférent --</option>
          <?php
do {  
?>
           <option value="<?php echo $row_RechercherFamille['Famille']?>" style="color:#000000;"><?php echo $row_RechercherFamille['Famille']?></option>
          <?php
} while ($row_RechercherFamille = mysql_fetch_assoc($RechercherFamille));
  $rows = mysql_num_rows($RechercherFamille);
  if($rows > 0) {
      mysql_data_seek($RechercherFamille, 0);
	  $row_RechercherFamille = mysql_fetch_assoc($RechercherFamille);
  }
?>
        </select> </td>
		<td width="50"></td>
    </tr>
    <tr>
	  <td width="50"></td> 
      <td align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Genre :</font></td>
      <td><input name="Genre" type="text" id="Genre" value="-- Indifférent --" onFocus="effaceGenre()"></td>
	  <td width="50"></td>
    </tr>
    <tr>
	  <td width="50"></td> 
      <td align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Esp&egrave;ce :</font></td>
      <td><input name="Espece" type="text" id="Espece" value="-- Indifférent --" onFocus="effaceEspece()"></td>
	  <td width="50"></td>
    </tr>
    <tr>
	  <td width="50"></td> 
      <td align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Rang : </font></td>
      <td><select name="Rang" id="Rang" onchange="this.style.color = this.options[selectedIndex].style.color;">
          <option value="1112" style="color:#999999;">-- Indifférent --</option>
          <option value="1" style="color:#000000;">Esp&egrave;ce seulement</option>
          <option value="11" style="color:#000000;">Esp&egrave;ce et Sous-esp&egrave;ce</option>
          <option value="111" style="color:#000000;">Esp&egrave;ce, Sous-esp&egrave;ce et Vari&eacute;t&eacute;</option>
          <option value="1111" style="color:#000000;">Esp&egrave;ce, Sous-esp&egrave;ce, Vari&eacute;t&eacute; 
          et Forme</option>
        </select></td>
		<td width="50"></td>
    </tr>
    <tr>
	  <td width="50"></td> 
      <td align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Livre rouge :</font></td>
      <td><select name="LivreRouge" id="LivreRouge" onchange="this.style.color = this.options[selectedIndex].style.color;">
          <option value="%" style="color:#999999;">-- Indifférent --</option>
          <option value="1" style="color:#000000;">Tome 1</option>
          <option value="2" style="color:#000000;">Tome 2</option>
        </select></td>
		<td width="50"></td>
    </tr>
    <tr>
	  <td width="50"></td> 
      <td align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Hybride : </font></td>
      <td><select name="Hybride" id="Hybride" onchange="this.style.color = this.options[selectedIndex].style.color;">
          <option value="%" style="color:#999999;">-- Indifférent --</option>
		  <option value="" style="color:#000000;">non hybrides</option>
          <option value="x" style="color:#000000;">hybrides</option>
        </select></td>
		<td width="50"></td>
    </tr>
   
   <tr>
	  <td width="50"></td> 
      <td height="30"></td>
      <td><font color="#663300" face="Arial, Helvetica, sans-serif" size="-2">&nbsp;</font></td>
	  <td width="50"></td>
    </tr>
   
   <tr>
			 <td width="50"></td> 
     		 <td align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Contributeur :</font></td>
    		 <td><select name="Contributeur" size="1" id="Contributeur" onchange="this.style.color = this.options[selectedIndex].style.color;">
        	 <option value="%" style="color:#999999;">-- Indifférent --</option>
          <?php
do {  
?>
          <option value="<?php echo $row_RechercherContributeur['id_contributeurs']?>" style="color:#000000;"><?php echo $row_RechercherContributeur['nom_contributeurs']." ".$row_RechercherContributeur['prenom_contributeurs']?></option>
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
 
<tr>
			 <td width="50"></td> 
     		 <td align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Département :</font></td>
    		 <td><select name="dep" size="1" id="Departement" onChange="window.imenu.location='imenu.php?dep=' + this.options[this.selectedIndex].value + '&type=rech'; this.style.color = this.options[selectedIndex].style.color;">
        	 <option value="%" style="color:#999999;">-- Indifférent --</option>
          <?php
do {  
?>
          <option value="<?php echo $row_RechercherDepartement['num_departements'];?>" style="color:#000000;"><? if (strlen($row_RechercherDepartement['num_departements']) == 1) { $row_RechercherDepartement['num_departements'] = '0'.$row_RechercherDepartement['num_departements'];}?><?php echo $row_RechercherDepartement['num_departements']." - ".$row_RechercherDepartement['nom_departements'];?></option>
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
     		 <td align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Commune :</font></td>
			 <td>
			 <iframe id="imenu" vspace="0" hspace="0" marginwidth="0" marginheight="0" name="imenu" height="22" width="390" style="background-color:#E4CA8B" frameborder="0" scrolling="no" src="./imenu.php?type=<? echo $type;?>"></iframe></td> 
		<td width="50"></td>
    </tr>
	
	<tr>
	  <td width="50"></td> 
      <td align="right"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Ajoutées depuis le : </font></td>
      <td>
	  <select name="jour" size="1" id="jour" onchange="this.style.color = this.options[selectedIndex].style.color;">
        	  <option value="" style="color:#999999;">-</option>
		<? for ($j=1; $j < 32; $j++) {?>
		<? if (strlen($j) == 1) { $j = '0'.$j;}?>	  
		<option value="<? echo $j;?>" style="color:#000000;"><? echo $j;?></option>
		<? }?>
		</select>
		
		<select name="mois" size="1" id="mois" onchange="this.style.color = this.options[selectedIndex].style.color;">
        	  <option value="" style="color:#999999;">-</option>
		<? for ($m=1; $m < 13; $m++) {?>
		<? if (strlen($m) == 1) { $m = '0'.$m;}
		?>	  
		<option value="<? echo $m;?>" style="color:#000000;"><? echo $m;?></option>
		<? }?>
		</select>
		
		<select name="annee" size="1" id="annee" onchange="this.style.color = this.options[selectedIndex].style.color;">
        	  <option value="" style="color:#999999;">-</option>
		<? for ($a=2005; $a <= date(Y); $a++) {?>	  
		<option value="<? echo $a;?>" style="color:#000000;"><? echo $a;?></option>
		<? }?>
		</select>
	  </td>
	  <td width="50"></td>
    </tr>
	
	<tr>
	  <td width="50"></td> 
      <td height="30"></td>
      <td></td>
	  <td width="50"></td>
    </tr>
	
	 <tr>
	  <td width="50"></td>
      <td align="center">&nbsp;</td>
      <td align="left">
	  <input name="w" style="display:none" value="<? echo $w; ?>">
	  <input type="hidden" name="Commune" id="Commune">
	  <input type="hidden" name="similitude" id="similitude" value="1">
	  <input type="Submit" name="Submit" value="Lancer la recherche" onClick="valide(window.imenu.document.iform.Commune.value)"></td>
	  <td width="50"></td>
    </tr>	
  </table>
<script type="text/javascript">
var s1 = document.getElementById('NumTaxon');
s1.style.color = s1.options[s1.selectedIndex].style.color;
var s2 = document.getElementById('Famille');
s2.style.color = s2.options[s2.selectedIndex].style.color;
var s3 = document.getElementById('Rang');
s3.style.color = s3.options[s3.selectedIndex].style.color;
var s4 = document.getElementById('LivreRouge');
s4.style.color = s4.options[s4.selectedIndex].style.color;
var s5 = document.getElementById('Hybride');
s5.style.color = s5.options[s5.selectedIndex].style.color;
var s6 = document.getElementById('Contributeur');
s6.style.color = s6.options[s6.selectedIndex].style.color;
var s7 = document.getElementById('Departement');
s7.style.color = s7.options[s7.selectedIndex].style.color;
var s8 = document.getElementById('jour');
s8.style.color = s8.options[s8.selectedIndex].style.color;
var s9 = document.getElementById('mois');
s9.style.color = s9.options[s9.selectedIndex].style.color;
var s10 = document.getElementById('annee');
s10.style.color = s10.options[s10.selectedIndex].style.color;
</script>
</form>
<br><br><br><br>

<? pied();?>

<?
mysql_free_result($RechercherDepartement);
mysql_free_result($RechercherFamille);
mysql_free_result($RechercherNumTaxon);
mysql_free_result($RechercherContributeur);
?>
