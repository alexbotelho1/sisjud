<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
require("verifica.php");
require("conecta.php");

extract($_POST);

$_docxml = new DOMdocument('1.0','utf-8');
$_resp = $_docxml->createElement('itens');
$_att  = $_docxml->createAttribute("id");
$_id   = $_docxml->createTextNode($_SESSION["v_id"]);

$chave    = utf8_decode($chave);
$processo = utf8_decode($processo);

$_att->appendChild($_id);
$_resp->appendChild($_att);
$curs = ocinewcursor($conn);
$curs_sal = ocinewcursor($conn);

$sql = "begin rh.pck_juntamed." . $processo . "(:InSessao, :InChave, :outresultado); end;";

$stmt = ociparse($conn,$sql);
		ocibindbyname ($stmt,":InSessao",$_SESSION["v_id"]);	
		ocibindbyname ($stmt,":InChave",$chave);
		ocibindbyname ($stmt,":outresultado",$curs,-1,OCI_B_CURSOR);

		$x = $_SESSION["v_id"];

		$r = @ociexecute($stmt);
		

		if (!$r) {
			erro ($stmt);
		}
		ociexecute($curs);

		while (ocifetchinto($curs,$outresultado)){
			//MONTA XML RETORNO
            $_setor = $_docxml->createElement('item');
	
			$_cpo = $_docxml->createElement('txtparecer');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[0]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('assinatura01');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[1]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('assinatura02');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[2]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);	

			$_cpo = $_docxml->createElement('assinatura03');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[3]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);			
			
			$_resp->appendChild($_setor);          
            }
        $_docxml->appendChild($_resp);
			
		
		OCIFreeStatement($stmt);
		OCIFreeCursor($curs);
		OCILogoff($conn);
Header("Content-type: application/xml; charset=utf-8");
echo $_docxml->saveXML();

?>
