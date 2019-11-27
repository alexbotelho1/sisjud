<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
require("verifica.php");
require("conecta.php");

extract($_POST);

$_docxml = new DOMdocument('1.0','utf-8');
$_resp = $_docxml->createElement('itens');
$_att =  $_docxml->createAttribute("id");
$_id =    $_docxml->createTextNode($_SESSION["sisjud"]);
$_att->appendChild($_id);
$_resp->appendChild($_att);

$cod_curso = utf8_decode($identificacao);
$datainicio = utf8_decode($datainicio);
$datafim = utf8_decode($datafim);
$operacao = utf8_decode($operacao);
$sit_datainicio = utf8_decode($sit_datainicio);
$sit_datafim = utf8_decode($sit_datafim);
$cid = utf8_decode(strtoupper($cid));
$base_legal = utf8_decode($base_legal);


$curs = ocinewcursor($conn);
$stmt = ociparse($conn,"begin sisjud.AlteraCertificado(:InUsuario, :InCodigo, :InDataIni, :InDataFim, :InSituacao, :InDataIniOp, :InDataFimOp, :InCdCid, :InCdBaseLegal, :OutResultado); end;");
		ocibindbyname ($stmt,":InSessao",$_SESSION["sisjud"]);
		ocibindbyname ($stmt,":Incod_curso",$codigo);
		ocibindbyname ($stmt,":Innome_curso",$tipo);
		ocibindbyname ($stmt,":Innome_agraciado",$processo);
		ocibindbyname ($stmt,":Indt_inicio",$protocolo);
		ocibindbyname ($stmt,":Indt_fim",$dtprotocolo);
		ocibindbyname ($stmt,":Incarga",$parecer);
		ocibindbyname ($stmt,":Inlocal",$ass01);
		ocibindbyname ($stmt,":Indt_exp",$ass02);
		ocibindbyname ($stmt,":OutResultado",$curs,-1,OCI_B_CURSOR);
		$r = @ociexecute($stmt);
		if (!$r) {
			erro ($stmt);
		}
		ociexecute($curs);

		while (ocifetchinto($curs,$outresultado)){
			//MONTA XML RETORNO
            $_item = $_docxml->createElement('item');

            $_cpo = $_docxml->createElement('msg');
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
