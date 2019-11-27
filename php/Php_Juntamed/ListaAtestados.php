<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
require("verifica.php");
require("conecta.php");

extract($_POST);

$_docxml = new DOMdocument('1.0','utf-8');
$_resp = $_docxml->createElement('itens');
$_att =  $_docxml->createAttribute("id");
$_id =    $_docxml->createTextNode($_SESSION["v_id"]);

$codigo = utf8_decode($codigo);
$tipo = utf8_decode($tipo);
$protocolo = utf8_decode($protocolo);
$dtprotocolo = utf8_decode($dtprotocolo);

$_att->appendChild($_id);
$_resp->appendChild($_att);
$curs = ocinewcursor($conn);
$stmt = ociparse($conn,"begin rh.pck_juntamed.lista_atestado(:InSessao, :InCdServ, :InCdMotAfast, :InProtocolo, :InDtProtocolo, :outresultado); end;");
		ocibindbyname ($stmt,":InSessao",$_SESSION["v_id"]);
		ocibindbyname ($stmt,":InCdServ",$codigo);
		ocibindbyname ($stmt,":InCdMotAfast",$tipo);
		ocibindbyname ($stmt,":InProtocolo",$protocolo);
		ocibindbyname ($stmt,":InDtProtocolo",$dtprotocolo);
		ocibindbyname ($stmt,":outresultado",$curs,-1,OCI_B_CURSOR);

		$x = $_SESSION["v_id"];

		$r = @ociexecute($stmt);
		

		if (!$r) {
			erro ($stmt);
		}
		ociexecute($curs);

		
		while (ocifetchinto($curs,$outresultado)){
			//MONTA XML RETORNO
            $_item = $_docxml->createElement('item');

            $_cpo = $_docxml->createElement('sequencia');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[0]));
            $_cpo->appendChild($_des);
            $_item->appendChild($_cpo);

            $_cpo = $_docxml->createElement('motivo');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[1]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);

            $_cpo = $_docxml->createElement('inicio');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[2]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);

            $_cpo = $_docxml->createElement('fim');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[3]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);

            $_cpo = $_docxml->createElement('situacao');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[4]));
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