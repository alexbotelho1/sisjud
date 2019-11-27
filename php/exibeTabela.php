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


$curs = ocinewcursor($conn);
$stmt = ociparse($conn,"begin rh.srec.retorna_Documentos(:InUsuario, :outresultado2); end;");
		ocibindbyname ($stmt,":InUsuario",$_SESSION["v_ids"]);		
		ocibindbyname ($stmt,":outresultado2",$curs,-1,OCI_B_CURSOR);
		$r = @ociexecute($stmt);
		if (!$r) {
			erro ($stmt);
		}
		ociexecute($curs);

		while (ocifetchinto($curs,$outresultado)){
			//MONTA XML RETORNO
            $_item = $_docxml->createElement('item');

            $_item = $_docxml->createElement('cod_curso');
            $_des = $_docxml->createTextNode(utf8_encode($outresultado[0]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_item = $_docxml->createElement('cpf');
            $_des = $_docxml->createTextNode(utf8_encode($outresultado[1]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
            
            $_cpo = $_docxml->createElement('nome_curso');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[2]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);

            $_cpo = $_docxml->createElement('nome_agraciado');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[3]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('nome_ins_conv');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[4]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('setor_ins_conv');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[5]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			/* $_cpo = $_docxml->createElement('nome_al_conv');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[6]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('setor_al_conv');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[7]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo); */

            $_cpo = $_docxml->createElement('dt_inicio');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[6]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('dt_fim');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[7]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('carga');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[8]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('localidade');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[9]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('dt_exp');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[10]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('codigo');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[11]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('cargo');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[12]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('tit_classe');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[13]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('posse');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[14]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('exercicio');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[15]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('setor');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[16]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('tit_funcao');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[17]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('ramal');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[18]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
					
			
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			
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
