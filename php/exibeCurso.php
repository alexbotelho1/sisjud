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
/* $stmt = ociparse($conn,"begin rh.srec.retorna_Documentos(:InUsuario, :outresultado2); end;"); */
$stmt = ociparse($conn,"begin sisjud.exibeCurso(:InUsuario,:Incod_curso,:Incpf,:Innome_curso,:Innome_agraciado,:Innome_ins_conv,:Insetor_ins_conv,:Indt_inicio,:Indt_fim,:Incarga,:Inlocalidade,:Indt_exp,:Incodigo,:Incargo,:Intit_classe,:Inposse,:Inexercicio,:Insetor,:Intit_funcao,:Inramal,:outresultado2); end;"); 
		ocibindbyname ($stmt,":InUsuario",$_SESSION["v_ids"]);		
		ocibindbyname ($stmt,":outresultado2",$curs,-1,OCI_B_CURSOR);
		$r = @ociexecute($stmt);
		if (!$r) {
			erro ($stmt);
		}
		ociexecute($curs);

		while (ocifetchinto($curs,$outresultado2)){
			//MONTA XML RETORNO
            $_setor = $_docxml->createElement('item');

            $_cpo = $_docxml->createElement('cod_curso');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[0]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('nome_curso');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[1]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('nome_instrutor');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[2]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);

                  $_cpo = $_docxml->createElement('dt_inicio');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[3]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);

                  $_cpo = $_docxml->createElement('dt_fim');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[4]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);


			
			
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
