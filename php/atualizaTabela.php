<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
require("verifica.php");
require("conecta.php");

extract($_POST);

$_docxml = new DOMdocument('1.0','utf-8');
$_resp = $_docxml->createElement('itens');
$_att =  $_docxml->createAttribute("id");
$_id =    $_docxml->createTextNode($_SESSION["v_ids"]);
$_att->appendChild($_id);
$_resp->appendChild($_att);

$cod_curso = utf8_decode($cod_curso);
$nome_curso = utf8_decode($nome_curso);
$nome_instrutor = utf8_decode($nome_instrutor);
$dt_inicio = utf8_decode($dt_inicio);
$dt_fim = utf8_decode($dt_fim);


$curs = ocinewcursor($conn);
$stmt = ociparse($conn,"begin rh.srec.atualiza_doc(:InUsuario,:Incod_curso,:Innome_curso,:Innome_instrutor, :Indt_inicio, :Indt_fim, :outresultado); end;");
		ocibindbyname ($stmt,":InUsuario",$_SESSION["v_ids"]);
		ocibindbyname ($stmt,":Incod_curso",$cod_curso);
		ocibindbyname ($stmt,":Innome_curso",$nome_curso);		
		ocibindbyname ($stmt,":Innome_instrutor",$nome_instrutor);
            ocibindbyname ($stmt,":Indt_inicio",$dt_inicio);
            ocibindbyname ($stmt,":Indt_fim",$dt_fim);	
		ocibindbyname ($stmt,":outresultado",$curs,-1,OCI_B_CURSOR);
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
