<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
require("conecta.php");

$q = strtolower($_GET["q"]);


$chave    = utf8_decode($codigo);
$processo = 'foto';

$curs = ocinewcursor($conn);

$sql = "SELECT foto FROM rh.tb_serv_foto WHERE cd_serv='$q'";

$stmt = oci_parse($conn, $sql);

oci_execute($stmt)
    or die ("Unable to execute query\n");

	
while ( $row = oci_fetch_assoc($stmt) ) {
    // Call the load() method to get the contents of the LOB
    $image = $row['FOTO']->load();
}
if ($image === false) { die ('Unable to open image'); }


// Print image
header('Content-type: image/jpeg');
print $image;
		
		OCIFreeStatement($stmt);
		OCIFreeCursor($curs);
		OCILogoff($conn);

?>
