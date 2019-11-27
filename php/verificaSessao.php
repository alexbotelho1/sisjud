<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
require("verifica.php");



$_docxml = new DOMdocument('1.0','utf-8');
$_resp = $_docxml->createElement('resposta');
$_att =  $_docxml->createAttribute("id");
$_id =    $_docxml->createTextNode($_SESSION["sisjud"]);
$_att->appendChild($_id);
$_resp->appendChild($_att);



Header("Content-type: application/xml; charset=utf-8");
echo $_docxml->saveXML();

?>
