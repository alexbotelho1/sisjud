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

$nome = utf8_decode($nome);
$sexo = utf8_decode($sexo);
$nasc = utf8_decode($nasc);
$cpf = utf8_decode($cpf);
$parent = utf8_decode($parent);


$curs = ocinewcursor($conn);
$stmt = ociparse($conn,"begin rh.srec.insere_Familiar(:InUsuario,:InNome,:InSexo,:InNasc,:InCpf,:InParent, :outresultado); end;");
		ocibindbyname ($stmt,":InUsuario",$_SESSION["v_ids"]);
		ocibindbyname ($stmt,":InNome",$nome);
		ocibindbyname ($stmt,":InSexo",$sexo);		
		ocibindbyname ($stmt,":InNasc",$nasc);		
		ocibindbyname ($stmt,":InCpf",$cpf);
		ocibindbyname ($stmt,":InParent",$parent);
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
