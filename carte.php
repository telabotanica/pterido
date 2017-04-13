<?
//recherche des départements du taxon
require_once('./scripts/PF.php');

$NumTaxon = isset($_REQUEST['NumTaxon']) ? $_REQUEST['NumTaxon'] : null;

mysql_select_db($database_PF, $PF);
$query_RechercherDepartement = "SELECT distinct num_departements FROM communes, contributions where communes.code_insee = contributions.code_insee and NumTaxon = '$NumTaxon'";
$RechercherDepartement = mysql_query($query_RechercherDepartement, $PF) or die(mysql_error());
$row_RechercherDepartement = mysql_fetch_assoc($RechercherDepartement);
$totalRows_RechercherDepartement = mysql_num_rows($RechercherDepartement);
//création de la carte de france
$im = ImageCreateFromGIF("./images/france.gif"); 


do { 

$dep = $row_RechercherDepartement['num_departements'];

// on compte les observations pour le dep
mysql_select_db($database_PF, $PF);
$query_NumObs = "SELECT count(*) FROM communes, contributions where communes.code_insee = contributions.code_insee and NumTaxon = '$NumTaxon' and num_departements = '$dep'";
$NumObs = mysql_query($query_NumObs, $PF) or die(mysql_error());
$row_NumObs = mysql_fetch_assoc($NumObs);
$totalRows_NumObs = mysql_num_rows($NumObs);


// definition de la couleur
// vert foncé
if ($row_NumObs['count(*)'] > 15) {
$red = 0;
$green = 153;
$blue = 51;
$color = ImageColorAllocate( $im, $red, $green, $blue ); 
}
// vert clair
if ( (5 < $row_NumObs['count(*)']) && ($row_NumObs['count(*)'] < 16)) {
$red = 123;
$green = 205;
$blue = 93;
$color = ImageColorAllocate( $im, $red, $green, $blue ); 
}
//vert pale
if ($row_NumObs['count(*)'] < 6) {
$red = 201;
$green = 245;
$blue = 180;
$color = ImageColorAllocate( $im, $red, $green, $blue ); 
}

switch ($dep)
		{
		case "1": $x = 306; $y = 230; imagefill($im, $x,$y, $color); $x = 304; $y = 224; imagefill($im, $x,$y, $color); break;
	    case "2": $x = 251; $y = 77; imagefill($im, $x,$y, $color); $x = 244; $y = 71; imagefill($im, $x,$y, $color); $x = 248; $y = 63; imagefill($im, $x,$y, $color); break;
	    case "3": $x = 253; $y = 209; imagefill($im, $x,$y, $color); $x = 236; $y = 209;  imagefill($im, $x,$y, $color); break;
	    case "4": $x = 341; $y = 313; imagefill($im, $x,$y, $color); $x = 344; $y = 302; imagefill($im, $x,$y, $color); $x = 336; $y = 312; imagefill($im, $x,$y, $color); break;
	    case "5": $x = 353; $y = 284; imagefill($im, $x,$y, $color); $x = 336; $y = 285; imagefill($im, $x,$y, $color); $x = 342; $y = 286; imagefill($im, $x,$y, $color); break;
	    case "6": $x = 365; $y = 323;  imagefill($im, $x,$y, $color); $x = 368; $y = 315;  imagefill($im, $x,$y, $color); $x = 374; $y = 317;  imagefill($im, $x,$y, $color); break;
	    case "7": $x = 285; $y = 280;  imagefill($im, $x,$y, $color); $x = 276; $y = 287;  imagefill($im, $x,$y, $color); break;
	    case "8": $x = 284; $y = 59;  imagefill($im, $x,$y, $color); $x = 278; $y = 67;  imagefill($im, $x,$y, $color); $x = 285; $y = 66;  imagefill($im, $x,$y, $color); $x = 284; $y = 69;  imagefill($im, $x,$y, $color); break;
	    case "9": $x = 200; $y = 362;  imagefill($im, $x,$y, $color); $x = 185; $y = 364;  imagefill($im, $x,$y, $color); $x = 191; $y = 362;  imagefill($im, $x,$y, $color); break;
	    case "10": $x = 281; $y = 130;  imagefill($im, $x,$y, $color); $x = 271; $y = 128;  imagefill($im, $x,$y, $color); break;
	    case "11": $x = 230; $y = 355;  imagefill($im, $x,$y, $color); break;
	    case "12": $x = 213; $y = 301;  imagefill($im, $x,$y, $color); break;
	    case "13": $x = 293; $y = 334;  imagefill($im, $x,$y, $color); break;
	    case "14": $x = 150; $y = 88;  imagefill($im, $x,$y, $color); $x = 138; $y = 92;  imagefill($im, $x,$y, $color); break;
	    case "15": $x = 237; $y = 268;  imagefill($im, $x,$y, $color); break;
	    case "16": $x = 150; $y = 247;  imagefill($im, $x,$y, $color); $x = 155; $y = 239;  imagefill($im, $x,$y, $color); break;
	    case "17": $x = 124; $y = 246;  imagefill($im, $x,$y, $color); break;
	    case "18": $x = 220; $y = 168;  imagefill($im, $x,$y, $color); $x = 225; $y = 180;  imagefill($im, $x,$y, $color); $x = 225; $y = 183;  imagefill($im, $x,$y, $color); break;
	    case "19": $x = 210; $y = 252;  imagefill($im, $x,$y, $color); $x = 202; $y = 256;  imagefill($im, $x,$y, $color); break;
	    case "20": $x = 395; $y = 374;  imagefill($im, $x,$y, $color); $x = 388; $y = 379;  imagefill($im, $x,$y, $color); break;
	    case "21": $x = 282; $y = 156;  imagefill($im, $x,$y, $color); break;
	    case "22": $x = 74; $y = 121;  imagefill($im, $x,$y, $color); break;
	    case "23": $x = 213; $y = 231;  imagefill($im, $x,$y, $color); break;
	    case "24": $x = 171; $y = 259;  imagefill($im, $x,$y, $color); $x = 170; $y = 270;  imagefill($im, $x,$y, $color); break;
	    case "25": $x = 347; $y = 168;  imagefill($im, $x,$y, $color); break;
	    case "26": $x = 299; $y = 296;  imagefill($im, $x,$y, $color); $x = 310; $y = 288;  imagefill($im, $x,$y, $color); break;
	    case "27": $x = 177; $y = 100;  imagefill($im, $x,$y, $color); break;
	    case "28": $x = 187; $y = 135;  imagefill($im, $x,$y, $color); $x = 191; $y = 123;  imagefill($im, $x,$y, $color); $x = 191; $y = 126;  imagefill($im, $x,$y, $color); break;
	    case "29": $x = 25; $y = 127;  imagefill($im, $x,$y, $color); $x = 31; $y = 116;  imagefill($im, $x,$y, $color); break;
	    case "30": $x = 280; $y = 322;  imagefill($im, $x,$y, $color); $x = 278; $y = 315;  imagefill($im, $x,$y, $color); break;
	    case "31": $x = 173; $y = 344;  imagefill($im, $x,$y, $color); break;
	    case "32": $x = 142; $y = 326;  imagefill($im, $x,$y, $color); break;
	    case "33": $x = 128; $y = 288;  imagefill($im, $x,$y, $color); break;
	    case "34": $x = 236; $y = 340;  imagefill($im, $x,$y, $color); $x = 253; $y = 335;  imagefill($im, $x,$y, $color); break;
	    case "35": $x = 97; $y = 138;  imagefill($im, $x,$y, $color); break;
	    case "36": $x = 193; $y = 202;  imagefill($im, $x,$y, $color); $x = 197; $y = 194;  imagefill($im, $x,$y, $color); break;
	    case "37": $x = 154; $y = 170;  imagefill($im, $x,$y, $color); break;
	    case "38": $x = 307; $y = 248;  imagefill($im, $x,$y, $color); $x = 318; $y = 253;  imagefill($im, $x,$y, $color); $x = 318; $y = 256;  imagefill($im, $x,$y, $color); break;
	    case "39": $x = 320; $y = 204;  imagefill($im, $x,$y, $color); $x = 322; $y = 195;  imagefill($im, $x,$y, $color); break;
	    case "40": $x = 106; $y = 316;  imagefill($im, $x,$y, $color); $x = 122; $y = 317;  imagefill($im, $x,$y, $color); $x = 116; $y = 317;  imagefill($im, $x,$y, $color); break;
	    case "41": $x = 178; $y = 150;  imagefill($im, $x,$y, $color); $x = 186; $y = 160;  imagefill($im, $x,$y, $color); break;
	    case "42": $x = 265; $y = 236;  imagefill($im, $x,$y, $color);$x = 272; $y = 244;  imagefill($im, $x,$y, $color); break;
	    case "43": $x = 261; $y = 274;  imagefill($im, $x,$y, $color); $x = 260; $y = 268;  imagefill($im, $x,$y, $color); break;
	    case "44": $x = 98; $y = 173;  imagefill($im, $x,$y, $color); $x = 97; $y = 164;  imagefill($im, $x,$y, $color); $x = 103; $y = 164;  imagefill($im, $x,$y, $color); break;
	    case "45": $x = 204; $y = 144;  imagefill($im, $x,$y, $color); $x = 214; $y = 144;  imagefill($im, $x,$y, $color); break;
	    case "46": $x = 182; $y = 295;  imagefill($im, $x,$y, $color); $x = 189; $y = 287;  imagefill($im, $x,$y, $color); $x = 195; $y = 288;  imagefill($im, $x,$y, $color); break;
	    case "47": $x = 148; $y = 300;  imagefill($im, $x,$y, $color); $x = 154; $y = 302;  imagefill($im, $x,$y, $color); break;
	    case "48": $x = 250; $y = 302;  imagefill($im, $x,$y, $color); $x = 251; $y = 294;  imagefill($im, $x,$y, $color); $x = 257; $y = 292;  imagefill($im, $x,$y, $color); $x = 257; $y = 294;  imagefill($im, $x,$y, $color); break;
	    case "49": $x = 132; $y = 173;  imagefill($im, $x,$y, $color); $x = 130; $y = 165;  imagefill($im, $x,$y, $color); $x = 135; $y = 163;  imagefill($im, $x,$y, $color); break;
	    case "50": $x = 107; $y = 102;  imagefill($im, $x,$y, $color); $x = 112; $y = 89;  imagefill($im, $x,$y, $color); break;
	    case "51": $x = 281; $y = 107;  imagefill($im, $x,$y, $color); break;
	    case "52": $x = 303; $y = 143;  imagefill($im, $x,$y, $color); break;
	    case "53": $x = 125; $y = 140;  imagefill($im, $x,$y, $color); break;
	    case "54": $x = 341; $y = 112;  imagefill($im, $x,$y, $color); $x = 333; $y = 110;  imagefill($im, $x,$y, $color); break;
	    case "55": $x = 302; $y = 107;  imagefill($im, $x,$y, $color); break;
	    case "56": $x = 50; $y = 138;  imagefill($im, $x,$y, $color); $x = 66; $y = 145;  imagefill($im, $x,$y, $color); break;
	    case "57": $x = 347; $y = 100;  imagefill($im, $x,$y, $color); break;
	    case "58": $x = 246; $y = 187;  imagefill($im, $x,$y, $color); $x = 253; $y = 176;  imagefill($im, $x,$y, $color); $x = 253; $y = 179;  imagefill($im, $x,$y, $color); break;
	    case "59": $x = 236; $y = 27;  imagefill($im, $x,$y, $color); $x = 254; $y = 39;  imagefill($im, $x,$y, $color); break;
	    case "60": $x = 224; $y = 82;  imagefill($im, $x,$y, $color); $x = 220; $y = 75;  imagefill($im, $x,$y, $color); $x = 215; $y = 77;  imagefill($im, $x,$y, $color); $x = 235; $y = 90;  imagefill($im, $x,$y, $color); break;
	    case "61": $x = 163; $y = 113;  imagefill($im, $x,$y, $color); $x = 149; $y = 110;  imagefill($im, $x,$y, $color); break;
	    case "62": $x = 205; $y = 27;  imagefill($im, $x,$y, $color); $x = 212; $y = 34;  imagefill($im, $x,$y, $color); break;
	    case "63": $x = 235; $y = 247;  imagefill($im, $x,$y, $color); $x = 238; $y = 241;  imagefill($im, $x,$y, $color);  break;
	    case "64": $x = 111; $y = 350;  imagefill($im, $x,$y, $color); $x = 118; $y = 349;  imagefill($im, $x,$y, $color); $x = 128; $y = 345;  imagefill($im, $x,$y, $color); break;
	    case "65": $x = 142; $y = 349;  imagefill($im, $x,$y, $color); $x = 140; $y = 359;  imagefill($im, $x,$y, $color); break;
	    case "66": $x = 230; $y = 374;  imagefill($im, $x,$y, $color); $x = 220; $y = 378;  imagefill($im, $x,$y, $color); $x = 226; $y = 379;  imagefill($im, $x,$y, $color); break;
	    case "67": $x = 365; $y = 113;  imagefill($im, $x,$y, $color); $x = 367; $y = 105;  imagefill($im, $x,$y, $color); break;
	    case "68": $x = 361; $y = 134;  imagefill($im, $x,$y, $color); $x = 359; $y = 143;  imagefill($im, $x,$y, $color); $x = 365; $y = 140;  imagefill($im, $x,$y, $color); $x = 365; $y = 142;  imagefill($im, $x,$y, $color); break;
	    case "69": $x = 288; $y = 242;  imagefill($im, $x,$y, $color); $x = 284; $y = 237;  imagefill($im, $x,$y, $color); $x = 290; $y = 234;  imagefill($im, $x,$y, $color); break;
	    case "70": $x = 319; $y = 160;  imagefill($im, $x,$y, $color); $x = 332; $y = 154;  imagefill($im, $x,$y, $color); $x = 347; $y = 153;  imagefill($im, $x,$y, $color); break;
	    case "71": $x = 278; $y = 207;  imagefill($im, $x,$y, $color); break;
	    case "72": $x = 148; $y = 146;  imagefill($im, $x,$y, $color); break;
	    case "73": $x = 334; $y = 247;  imagefill($im, $x,$y, $color);  break;
	    case "74": $x = 333; $y = 228;  imagefill($im, $x,$y, $color); $x = 348; $y = 222;  imagefill($im, $x,$y, $color); break;
	    case "75": $x = 213; $y = 107;  imagefill($im, $x,$y, $color); $x = 323; $y = 23;  imagefill($im, $x,$y, $color); break;
	    case "76": $x = 166; $y = 69; imagefill($im, $x,$y, $color); $x = 178; $y = 68; imagefill($im, $x,$y, $color); break;
	    case "77": $x = 227; $y = 120;  imagefill($im, $x,$y, $color); break;
	    case "78": $x = 201; $y = 110;  imagefill($im, $x,$y, $color); $x = 203; $y = 101;  imagefill($im, $x,$y, $color); $x = 203; $y = 105;  imagefill($im, $x,$y, $color); break;
	    case "79": $x = 135; $y = 210;  imagefill($im, $x,$y, $color); $x = 138; $y = 199;  imagefill($im, $x,$y, $color); break;
	    case "80": $x = 202; $y = 52;  imagefill($im, $x,$y, $color); $x = 218; $y = 55;  imagefill($im, $x,$y, $color); $x = 212; $y = 54;  imagefill($im, $x,$y, $color); $x = 212; $y = 56;  imagefill($im, $x,$y, $color); break;
	    case "81": $x = 196; $y = 322;  imagefill($im, $x,$y, $color); $x = 204; $y = 324;  imagefill($im, $x,$y, $color); $x = 204; $y = 326;  imagefill($im, $x,$y, $color); break;
	    case "82": $x = 173; $y = 322;  imagefill($im, $x,$y, $color); $x = 175; $y = 313;  imagefill($im, $x,$y, $color); $x = 175; $y = 315;  imagefill($im, $x,$y, $color); break;
	    case "83": $x = 333; $y = 344;  imagefill($im, $x,$y, $color); $x = 337; $y = 337;  imagefill($im, $x,$y, $color); $x = 337; $y = 339;  imagefill($im, $x,$y, $color); break;
	    case "84": $x = 306; $y = 320;  imagefill($im, $x,$y, $color); $x = 303; $y = 312;  imagefill($im, $x,$y, $color); $x = 303; $y = 314;  imagefill($im, $x,$y, $color); $x = 309; $y = 314;  imagefill($im, $x,$y, $color); break;
	    case "85": $x = 113; $y = 205;  imagefill($im, $x,$y, $color); $x = 104; $y = 196;  imagefill($im, $x,$y, $color); $x = 104; $y = 198;  imagefill($im, $x,$y, $color); break;
	    case "86": $x = 153; $y = 204;  imagefill($im, $x,$y, $color); $x = 159; $y = 202;  imagefill($im, $x,$y, $color); $x = 159; $y = 204;  imagefill($im, $x,$y, $color); $x = 165; $y = 204;  imagefill($im, $x,$y, $color); break;
	    case "87": $x = 178; $y = 228;  imagefill($im, $x,$y, $color); $x = 177; $y = 236;  imagefill($im, $x,$y, $color); $x = 177; $y = 238;  imagefill($im, $x,$y, $color); break;
	    case "88": $x = 325; $y = 129;  imagefill($im, $x,$y, $color); $x = 334; $y = 129;  imagefill($im, $x,$y, $color); $x = 334; $y = 131;  imagefill($im, $x,$y, $color); $x = 340; $y = 129;  imagefill($im, $x,$y, $color); $x = 340; $y = 131;  imagefill($im, $x,$y, $color); break;
	    case "89": $x = 240; $y = 149;  imagefill($im, $x,$y, $color); $x = 250; $y = 147;  imagefill($im, $x,$y, $color); $x = 250; $y = 149;  imagefill($im, $x,$y, $color); $x = 256; $y = 147;  imagefill($im, $x,$y, $color); break;
	    case "90": $x = 351; $y = 149; imagefill($im, $x,$y, $color); $x = 354; $y = 154; imagefill($im, $x,$y, $color); break;
	    case "91": $x = 213; $y = 122; imagefill($im, $x,$y, $color); $x = 209; $y = 117; imagefill($im, $x,$y, $color); break;
	    case "92": $x = 209; $y = 107; imagefill($im, $x,$y, $color); $x = 312; $y = 24; imagefill($im, $x,$y, $color); $x = 307; $y = 15; imagefill($im, $x,$y, $color); break;
	    case "93": $x = 221; $y = 105; imagefill($im, $x,$y, $color); $x = 216; $y = 103; imagefill($im, $x,$y, $color); $x = 331; $y = 10; imagefill($im, $x,$y, $color); $x = 337; $y = 11; imagefill($im, $x,$y, $color); break;
	    case "94": $x = 218; $y = 112; imagefill($im, $x,$y, $color); $x = 338; $y = 24; imagefill($im, $x,$y, $color); $x = 333; $y = 28; imagefill($im, $x,$y, $color); $x = 340; $y = 30; imagefill($im, $x,$y, $color); break;
		case "95": $x = 204; $y = 92; imagefill($im, $x,$y, $color); $x = 210; $y = 93; imagefill($im, $x,$y, $color); break;
		}
} while ($row_RechercherDepartement = mysql_fetch_assoc($RechercherDepartement));		

header("Content-type: image/jpeg");	

	Imagejpeg($im, null, 80);
	ImageDestroy($im);

mysql_free_result($RechercherDepartement);
mysql_free_result($NumObs);
?>
