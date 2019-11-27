<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
require("verifica.php");
require("conecta.php");


extract($_POST);

$_docxml = new DOMdocument('1.0','utf-8');
$_resp = $_docxml->createElement('itens');
$_att =  $_docxml->createAttribute("v_id");
$_id =    $_docxml->createTextNode($_SESSION["v_id"]);
$_att->appendChild($_id);
$_resp->appendChild($_att);

$id = utf8_decode($id);

$curs = ocinewcursor($conn);
$stmt = ociparse($conn,"begin rh.pck_juntamed.exibeAtestado(:InUsuario, :InCodigo, :OutResultado); end;");
		ocibindbyname ($stmt,":InUsuario",$_SESSION["v_id"]);
		ocibindbyname ($stmt,":InCodigo",$id);		
		ocibindbyname ($stmt,":OutResultado",$curs,-1,OCI_B_CURSOR);
		$r = @ociexecute($stmt);
		if (!$r) {
			erro ($stmt);
		}
		ociexecute($curs);

		while (ocifetchinto($curs,$outresultado)){
			//MONTA XML RETORNO
            $_setor = $_docxml->createElement('item');

			$_cpo = $_docxml->createElement('id_select');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[0]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('datainicio');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[1]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('datafim');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[2]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('operacao');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[3]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);	

			$_cpo = $_docxml->createElement('sit_datainicio');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[4]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);			
			
			$_cpo = $_docxml->createElement('sit_datafim');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[5]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('cid');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[6]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('base_legal');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[7]));
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
