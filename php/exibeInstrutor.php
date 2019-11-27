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


$curs = ocinewcursor($conn);
/* $stmt = ociparse($conn,"begin rh.srec.retorna_documentos(:inusuario, :outresultado2); end;"); */
/* $stmt = ociparse($conn,"begin sisjud.exibeInstrutor(:InUsuario,:Incpf,:Innome_agraciado,:Innome_ins_conv,:Insetor_ins_conv,:Inclassif,:Incod_curso,:Innome_curso,:Inform_prof,:Inform_acad,Incodigo,:Incargo,:Intit_classe,:Inposse,:Inexercicio,:Insetor,:Intit_funcao,:Inramal,:outresultado); end;");*/
  $stmt = ociparse($conn,"begin sisjud.exibeInstrutor(:InUsuario,:Incpf,:Innome_agraciado,:Innome_ins_conv,:Insetor_ins_conv,:Inclassif,:Incod_curso,:Innome_curso,:Inform_prof,:Inform_acad,:outresultado); end;");
		ocibindbyname ($stmt,":InUsuario",$_SESSION["sisjud"]);
		ocibindbyname ($stmt,":Incpf",$cpf);
		ocibindbyname ($stmt,":Innome_instrutor",$Innome_instrutor);		
		ocibindbyname ($stmt,":Inclassif",$classif);
        ocibindbyname ($stmt,":Incod_curso",$cod_curso);
        ocibindbyname ($stmt,":Innome_curso",$nome_curso);	
        ocibindbyname ($stmt,":Inform_prof",$form_prof);	
		ocibindbyname ($stmt,":Inform_acad",$form_acad);
		/* ocibindbyname ($stmt,":Incodigo",$codigo);
		ocibindbyname ($stmt,":Incargo",$cargo);
		ocibindbyname ($stmt,":Intit_classe",$tit_classe);
		ocibindbyname ($stmt,":Inposse",$posse);
		ocibindbyname ($stmt,":Inexercicio",$exercicio);
		ocibindbyname ($stmt,":Insetor",$setor);
		ocibindbyname ($stmt,":Intit_funcao",$tit_funcao);
		ocibindbyname ($stmt,":Inramal",$ramal); */
		ocibindbyname ($stmt,":outresultado2",$curs,-1,OCI_B_CURSOR);
		$r = @ociexecute($stmt);
		if (!$r) {
			erro ($stmt);
		}
		ociexecute($curs);

		while (ocifetchinto($curs,$outresultado2)){
			//MONTA XML RETORNO
            $_setor = $_docxml->createElement('item');

            $_cpo = $_docxml->createElement('cpf');
	        $_des = $_docxml->createTextNode(utf8_encode($outresultado2[0]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
		    $_cpo = $_docxml->createElement('nome_instrutor');
		    $_des = $_docxml->createTextNode(utf8_encode($outresultado2[1]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
		    $_cpo = $_docxml->createElement('classif');
		    $_des = $_docxml->createTextNode(utf8_encode($outresultado2[2]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);

            $_cpo = $_docxml->createElement('cod_curso');
		    $_des = $_docxml->createTextNode(utf8_encode($outresultado2[3]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);

            $_cpo = $_docxml->createElement('nome_curso');
		    $_des = $_docxml->createTextNode(utf8_encode($outresultado2[4]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);

            $_cpo = $_docxml->createElement('form_prof');
		    $_des = $_docxml->createTextNode(utf8_encode($outresultado2[5]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
            $_cpo = $_docxml->createElement('form_acad');
		    $_des = $_docxml->createTextNode(utf8_encode($outresultado2[6]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
		   /*$_cpo = $_docxml->createElement('codigo');
		            $_des = $_docxml->createTextNode(utf8_encode($outresultado2[7]));
                                 $_cpo->appendChild($_des);
                                 $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('cargo');
		           $_des = $_docxml->createTextNode(utf8_encode($outresultado2[8]));
                                $_cpo->appendChild($_des);
                                $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('tit_classe');
		           $_des = $_docxml->createTextNode(utf8_encode($outresultado2[9]));
                                $_cpo->appendChild($_des);
                                $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('posse');
		           $_des = $_docxml->createTextNode(utf8_encode($outresultado2[10]));
                                $_cpo->appendChild($_des);
                                $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('exercicio');
		           $_des = $_docxml->createTextNode(utf8_encode($outresultado2[11]));
                                $_cpo->appendChild($_des);
                                $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('setor');
		           $_des = $_docxml->createTextNode(utf8_encode($outresultado2[12]));
                                $_cpo->appendChild($_des);
                                $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('tit_funcao');
		          $_des = $_docxml->createTextNode(utf8_encode($outresultado2[13]));
                               $_cpo->appendChild($_des);
                               $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('ramal');
		          $_des = $_docxml->createTextNode(utf8_encode($outresultado2[14]));
                               $_cpo->appendChild($_des);
                               $_setor->appendChild($_cpo);*/

			
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
