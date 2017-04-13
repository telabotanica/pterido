<?php

require_once('./scripts/PF.php');


mysql_select_db($database_PF, $PF);
$query_RechercherCommune = "SELECT * FROM communes, contributions where communes.code_insee = contributions.code_insee and NumTaxon = '$NumTaxon'";
$RechercherCommune = mysql_query($query_RechercherCommune, $PF) or die(mysql_error());
$row_RechercherCommune = mysql_fetch_assoc($RechercherCommune);
$totalRows_RechercherCommune = mysql_num_rows($RechercherCommune);

$image = ImageCreateFromJPEG("./images/france_wgs84_dep.jpg"); 
 
$red = 0;
$green = 153;
$blue = 51;
$color = ImageColorAllocate( $image, $red, $green, $blue ); 


do { 

		if ($row_RechercherCommune['longitude'] < 0) {
		$x = 27 * $row_RechercherCommune['longitude'];
		$x = $x + 146;
		}
		if ($row_RechercherCommune['longitude'] > 0) {
		$x = 27 * $row_RechercherCommune['longitude'];
		$x = $x + 146;
		}
		
		
		$y = 51.16 - $row_RechercherCommune['latitude'];
		$y = $y * 41.48;

			
		// on dessine l'ellipse
		imagefilledellipse($image, $x, $y, 4, 4, $color);
	

} while ($row_RechercherCommune = mysql_fetch_assoc($RechercherCommune));


// on affiche l'image
header("Content-type: image/jpeg");	

	Imagejpeg($image, "", 90);
	ImageDestroy($image);


mysql_free_result($RechercherCommune);
?> 