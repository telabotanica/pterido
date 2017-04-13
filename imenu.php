<?
// menu des communes

require_once('./scripts/PF.php');

mysql_select_db($database_PF, $PF);
$query_RechercherCommune  = "SELECT code_insee, nom_communes FROM communes where num_departements = '" . (isset($dep) ? $dep : '') . "' ORDER BY nom_communes ";
$RechercherCommune = mysql_query($query_RechercherCommune, $PF) or die(mysql_error());
$row_RechercherCommune = mysql_fetch_assoc($RechercherCommune);
$totalRows_RechercherCommune = mysql_num_rows($RechercherCommune);
?>
 
<table bgcolor="#E4CA8B" width="750" height="20" border="0" cellpadding="0" cellspacing="0">
<form name="iform" target="_top" method="post" action="resultat.php" id="iform">
<tr>
<td>
<select name="Commune" size="1" id="Commune" onchange="this.style.color = this.options[selectedIndex].style.color;">
        	  <?  
					 if (isset($type)) { 
									 if ($type == "rech") {?><option value="%" style="color:#999999;">-- Indifférent --</option><? }
									 if ($type == "ajout") { ?><option value="%" style="color:#000000;">-</option><? }
									 }	
					else { ?><option value="<? echo isset($Commune) ? $Commune : '';?>" style="color:#000000;"><? echo isset($nom_communes) ? $nom_communes : '';?></option><? }
					
				?>
          <?php 
if (! empty($dep)) 
{
			do {  
			?>
					  <option value="<?php echo $row_RechercherCommune['code_insee'];?>" style="color:#000000;"><?php echo $row_RechercherCommune['nom_communes'];?></option>
					  <?php
			} while ($row_RechercherCommune = mysql_fetch_assoc($RechercherCommune));
			  $rows = mysql_num_rows($RechercherCommune);
			  if($rows > 0) {
				  mysql_data_seek($RechercherCommune, 0);
				  $row_RechercherCommune = mysql_fetch_assoc($RechercherCommune);
			  
			  }	
}
else { ?><option value="%" style="color:#000000;">Choisissez un département</option><? }
?></select>
<script type="text/javascript">
var s11 = document.getElementById('Commune');
s11.style.color = s11.options[s11.selectedIndex].style.color;
</script>
</td>
</tr>
</form> 
</table>

<?
mysql_free_result($RechercherCommune);
?>
