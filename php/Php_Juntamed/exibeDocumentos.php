<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
require("verifica.php");
require("conecta.php");


extract($_POST);

$_docxml = new DOMdocument('1.0','utf-8');
$_resp = $_docxml->createElement('itens');
$_att =  $_docxml->createAttribute("id");
$_id =    $_docxml->createTextNode($_SESSION["v_id"]);
$_att->appendChild($_id);
$_resp->appendChild($_att);


$curs = ocinewcursor($conn);
$stmt = ociparse($conn,"begin srec.retorna_Documentos(:InUsuario, :outresultado2); end;");
		ocibindbyname ($stmt,":InUsuario",$_SESSION["v_id"]);		
		ocibindbyname ($stmt,":outresultado2",$curs,-1,OCI_B_CURSOR);
		$r = @ociexecute($stmt);
		if (!$r) {
			erro ($stmt);
		}
		ociexecute($curs);

		while (ocifetchinto($curs,$outresultado2)){
			//MONTA XML RETORNO
            $_setor = $_docxml->createElement('item');

            $_cpo = $_docxml->createElement('pis_pasep');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[0]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('cpf');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[1]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('cat_ident');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[2]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('dt_exped');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[3]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);	

			$_cpo = $_docxml->createElement('org_exped');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[4]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);			
			
			$_cpo = $_docxml->createElement('uf');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[5]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('cart_func');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[6]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('tit_eleitor');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[7]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('zona');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[8]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('secao');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[9]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('reservista');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[10]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('rm');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[11]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('cart_habili');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[12]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('categ');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[13]));
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
