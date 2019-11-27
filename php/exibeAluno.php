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
/* $stmt = ociparse($conn,"begin srec.retorna_Dados(:InUsuario, :outresultado2); end;"); */
/* $stmt = ociparse($conn,"begin sisjud.exibeAluno(:InUsuario, :Incod_curso,:Incpf,:Innome_curso,:Innome_agraciado,:Innome_ins_conv,:Insetor_ins_conv,:Innome_al_conv,:Insetor_al_conv,:Indt_inicio,:Indt_fim,:Incarga,:Inlocalidade,:Indt_exp,:Incodigo,:Incargo,:Intit_classe,:Inposse,:Inexercicio,:Insetor,:Intit_funcao,:Inramal,:outresultado); end;"); */	
  $stmt = ociparse($conn,"begin sisjud.exibeAluno(:InUsuario, :Incod_curso,:Incpf,:Innome_curso,:Innome_agraciado,:Innome_al_conv,:Insetor_al_conv,:Inform_prof,:Inform_acad,:outresultado); end;"); 
		ocibindbyname ($stmt,":InUsuario",$_SESSION["sisjud"]);
		ocibindbyname ($stmt,":Incod_curso",$cod_curso);
		ocibindbyname ($stmt,":Incpf",$cpf);
		ocibindbyname ($stmt,":Innome_curso",$cod_curso);		
		ocibindbyname ($stmt,":Innome_agraciado",$nome_agraciado);
		ocibindbyname ($stmt,":Innome_al_conv",$nome_al_conv);
		ocibindbyname ($stmt,":Insetor_al_conv",$setor_al_conv);
		ocibindbyname ($stmt,":Inform_prof",$form_prof);
		ocibindbyname ($stmt,":Inform_acad",$form_acad);
		/* ocibindbyname ($stmt,":Incodigo",$codigo);
		ocibindbyname ($stmt,":Incargo",$cargo);
		ocibindbyname ($stmt,":Intit_classe",$tit_classe);
		ocibindbyname ($stmt,":Inposse",$posse);
		ocibindbyname ($stmt,":Inexercicio",$exercicio);
		ocibindbyname ($stmt,":Insetor",$setor);
		ocibindbyname ($stmt,":Intit_funcao",$tit_funcao);
		ocibindbyname ($stmt,":Inramal",$ramal);  */
		ocibindbyname ($stmt,":outresultado",$curs,-1,OCI_B_CURSOR);
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
			
			$_cpo = $_docxml->createElement('cpf');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[1]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('nome_curso');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[2]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('nome_agraciado');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[3]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);	

			$_cpo = $_docxml->createElement('nome_al_conv');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[4]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);			
			
			$_cpo = $_docxml->createElement('setor_al_conv');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[5]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('form_prof');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[6]));
            $_cpo->appendChild($_des);
            $_setor->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('form_acad');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado2[7]));
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
