<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
require("verifica.php");
require("conecta.php");

extract($_POST);

$_docxml = new DOMdocument('1.0','utf-8');
$_resp = $_docxml->createElement('itens');
$_att =  $_docxml->createAttribute("id");
$_id =    $_docxml->createTextNode($_SESSION["sisjud"]);


$codigo = utf8_decode($codigo);
$nome_agraciado = utf8_decode($nome_agraciado);
$nome_curso = utf8_decode($nome_curso);
$dt_inicio = utf8_decode($dt_inicio);
$dt_fim = utf8_decode($dt_fim);
$dt_exp = utf8_decode($dt_exp); 


$_att->appendChild($_id);
$_resp->appendChild($_att);
$curs = ocinewcursor($conn);
//$stmt = ociparse($conn,"begin sisjud.listaCertificado(:InSessao,:Incodigo,:outresultado); end;");
$stmt = ociparse($conn,"begin sisjud.listaCertificado(:InSessao,:Incodigo,:Innome_agraciado,:Innome_curso,:Indt_inicio,:Indt_fim,:Indt_exp,:outresultado); end;"); 
    	ocibindbyname ($stmt,":InSessao",$_SESSION["sisjud"]);				
		ocibindbyname ($stmt,":Incodigo",$codigo);	
		ocibindbyname ($stmt,":Innome_agraciado",$nome_agraciado);	
        ocibindbyname ($stmt,":Innome_curso",$nome_curso);			
		ocibindbyname ($stmt,":Indt_inicio",$dt_inicio);	
		ocibindbyname ($stmt,":Indt_fim",$dt_fim);	
		ocibindbyname ($stmt,":Indt_exp",$dt_exp); 
		ocibindbyname ($stmt,":outresultado",$curs,-1,OCI_B_CURSOR);

		$x = $_SESSION["sisjud"];

		$r = @ociexecute($stmt);
		

		if (!$r) {
			erro ($stmt);
		}
		ociexecute($curs);

		
		while (ocifetchinto($curs,$outresultado)){
			//MONTA XML RETORNO
            $_item = $_docxml->createElement('item');
			
			$_cpo = $_docxml->createElement('codigo');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[0]));
            $_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
     		$_cpo = $_docxml->createElement('nome_agraciado');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[1]));
            $_cpo->appendChild($_des);
            $_item->appendChild($_cpo);	

            $_cpo = $_docxml->createElement('nome_curso');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[2]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);			
			
			$_cpo = $_docxml->createElement('dt_inicio');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[3]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);

            $_cpo = $_docxml->createElement('dt_fim');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[4]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('dt_exp');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[5]));
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