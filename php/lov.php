<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
require("verifica.php");
require("conecta.php");

extract($_POST);

$_docxml = new DOMdocument('1.0','utf-8');
$_resp = $_docxml->createElement('resposta');
$_att =  $_docxml->createAttribute("id");
$_id =    $_docxml->createTextNode($_SESSION["v_id"]);
$_att->appendChild($_id);
$_resp->appendChild($_att);


$tabela = utf8_decode($tabela);
$parametro = utf8_decode($parametro);
//$uf = utf8_decode($uf);
//$uflog = utf8_decode($uflog);

$curs = ocinewcursor($conn);
$stmt = ociparse($conn,"begin srec.retorna_Lov(:InUsuario, :InTabela, :InParametro, :outresultado); end;");
		ocibindbyname ($stmt,":InUsuario",$_SESSION["v_id"]);
		ocibindbyname ($stmt,":InTabela",$tabela);
		ocibindbyname ($stmt,":InParametro",$parametro);		
		//ocibindbyname ($stmt,":InUf",$InUf);		
		//ocibindbyname ($stmt,":InUflog",$InUflog);		
		ocibindbyname ($stmt,":outresultado",$curs,-1,OCI_B_CURSOR);
		$r = @ociexecute($stmt);
		if (!$r) {
			erro ($stmt);
		}
		ociexecute($curs);

		while (ocifetchinto($curs,$outresultado)){
			//MONTA XML RETORNO
            $_tabela = $_docxml->createElement('tabela');
			
			$_cpo = $_docxml->createElement('id');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[0]));
            $_cpo->appendChild($_des);
            $_tabela->appendChild($_cpo); 
			
            $_cpo = $_docxml->createElement('descricao');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[1]));
            $_cpo->appendChild($_des);
            $_tabela->appendChild($_cpo);          
            

            $_resp->appendChild($_tabela);
            }
        $_docxml->appendChild($_resp);

		OCIFreeStatement($stmt);
		OCIFreeCursor($curs);
		OCILogoff($conn);
Header("Content-type: application/xml; charset=utf-8");
echo $_docxml->saveXML();

?>
