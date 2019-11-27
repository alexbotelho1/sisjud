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

$cod_curso = utf8_decode($cpf);
$nome_curso = utf8_decode($nome_agraciado);
$nome_curso = utf8_decode($nome_ins_conv);
$nome_curso = utf8_decode($setor_ins_conv);
$nome_curso = utf8_decode($classif);
$dt_inicio = utf8_decode($cod_curso);
$dt_fim = utf8_decode($nome_curso);
$dt_fim = utf8_decode($form_prof);
$dt_fim = utf8_decode($form_acad);
/*$dt_fim = utf8_decode($codigo);
    $dt_fim = utf8_decode($cargo);
    $dt_fim = utf8_decode($tit_classe);
    $dt_fim = utf8_decode($posse);
    $dt_fim = utf8_decode($exercicio);
    $dt_fim = utf8_decode($setor);
    $dt_fim = utf8_decode($tit_funcao);
    $dt_fim = utf8_decode($ramal);*/

$curs = ocinewcursor($conn);
/* $stmt = ociparse($conn,"begin rh.srec.atualiza_doc(:InUsuario,:Incod_cpf,:Innome_instrutor,:Inclassif, :Incod_curso, :Innome_curso, :Inform_prof, :Inform_acad, :outresultado); end;"); */
/* $stmt = ociparse($conn,"begin rh.srec.atualiza_doc(:InUsuario,:Incod_cpf,:Innome_instrutor,:Inclassif, :Incod_curso, :Innome_curso, :Inform_prof, :Inform_acad, :outresultado); end;"); */
/* $stmt = ociparse($conn,"begin sisjud.atualizaInstrutor(:InUsuario,:Incpf,:Innome_agraciado,:Innome_ins_conv,:Insetor_ins_conv,:Inclassif,:Incod_curso,:Innome_curso,:Inform_prof,:Inform_acad,Incodigo,:Incargo,:Intit_classe,:Inposse,:Inexercicio,:Insetor,:Intit_funcao,:Inramal,:outresultado); end;");*/
  $stmt = ociparse($conn,"begin sisjud.atualizaInstrutor(:InUsuario,:Incpf,:Innome_agraciado,:Innome_ins_conv,:Insetor_ins_conv,:Inclassif,:Incod_curso,:Innome_curso,:Inform_prof,:Inform_acad,:outresultado); end;");
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
