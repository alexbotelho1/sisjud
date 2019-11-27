<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
require("verifica.php");
require("conecta.php");

extract($_POST);

$_docxml = new DOMdocument('1.0','utf-8');
$_resp = $_docxml->createElement('itens');
$_att  = $_docxml->createAttribute("id");
$_id   = $_docxml->createTextNode($_SESSION["v_id"]);


$codigo 	= utf8_decode($codigo);
$tipo 		= utf8_decode($tipo);
$processo 	= utf8_decode($processo);
$protocolo 	= utf8_decode($protocolo);
$dtprotocolo= utf8_decode($dtprotocolo);
$parecer 	= utf8_decode($parecer);
$ass01 		= utf8_decode($ass01);
$ass02 		= utf8_decode($ass02);
$ass03 		= utf8_decode($ass03);


$_att->appendChild($_id);
$_resp->appendChild($_att);
$curs = ocinewcursor($conn);
$curs_sal = ocinewcursor($conn);

Header("Content-type: application/xml; charset=utf-8");

$sql = "begin rh.pck_juntamed.gravaParecer(:InSessao, :InCdServ, :InCdMotAfast, :InNmProcesso , :InProtocolo, :InDtProtocolo,:InParecer, :InAss01 , :InAss02 , :InAss03 , :outresultado); end;";

$stmt = ociparse($conn,$sql);
		ocibindbyname ($stmt,":InSessao",$_SESSION["juntamed"]);
		ocibindbyname ($stmt,":InCdServ",$codigo);
		ocibindbyname ($stmt,":InCdMotAfast",$tipo);
		ocibindbyname ($stmt,":InNmProcesso",$processo);
		ocibindbyname ($stmt,":InProtocolo",$protocolo);
		ocibindbyname ($stmt,":InDtProtocolo",$dtprotocolo);
		ocibindbyname ($stmt,":InParecer",$parecer);
		ocibindbyname ($stmt,":InAss01",$ass01);
		ocibindbyname ($stmt,":InAss02",$ass02);
		ocibindbyname ($stmt,":InAss03",$ass03);		
		ocibindbyname ($stmt,":OutResultado",$curs,-1,OCI_B_CURSOR);

		// $x = $_SESSION["v_id"];

		$r = @ociexecute($stmt);
		
		if (!$r) {
			erro ($stmt);
		}
		ociexecute($curs);

		while (ocifetchinto($curs,$outresultado)){
			//MONTA XML RETORNO
			$_item = $_docxml->createElement('item');
            $_cpo = $_docxml->createElement('msg3');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[0]));
            $_cpo->appendChild($_des);
            $_item->appendChild($_cpo);			
			
    $_resp->appendChild($_item);
            }
        $_docxml->appendChild($_resp);

		OCIFreeStatement($stmt);
		OCIFreeCursor($curs);
		OCILogoff($conn);
Header("Content-type: application/xml; charset=utf-8");
echo $_docxml->saveXML();

?>

		