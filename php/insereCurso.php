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

$cod_curso = utf8_decode($cod_curso);
$cpf = utf8_decode($cpf);
$nome_curso = utf8_decode($nome_curso);
$nome_agraciado = utf8_decode($nome_agraciado);
$nome_ins_conv = utf8_decode($nome_ins_conv);
$setor_ins_conv = utf8_decode($setor_ins_conv);
$dt_inicio = utf8_decode($dt_inicio);
$dt_fim = utf8_decode($dt_fim);
$carga = utf8_decode($carga);
$localidade = utf8_decode($localidade);
$dt_exp = utf8_decode($dt_exp);
$codigo = utf8_decode($codigo);
$cargo = utf8_decode($cargo);
$tit_classe = utf8_decode($tit_classe);
$posse = utf8_decode($posse);
$exercicio = utf8_decode($exercicio);
$setor = utf8_decode($setor);
$tit_funcao = utf8_decode($tit_funcao);
$ramal = utf8_decode($ramal);

$curs = ocinewcursor($conn);
$stmt = ociparse($conn,"begin sisjus.insere_Tabela(:Incod_curso,:Incpf,:Innome_curso,:Innome_agraciado,:Innome_ins_conv,:Insetor_ins_conv,:Indt_inicio,:Indt_fim,:Incarga,:Inlocalidade,:Indt_exp,:Incodigo,:Incargo,:Intit_classe,:Inposse,:Inexercicio,:Insetor,:Intit_funcao,:Inramal,:outresultado); end;");
		ocibindbyname ($stmt,":Incod_curso",$_SESSION["sisjud"]);
		ocibindbyname ($stmt,":Incpf",$cpf);
		ocibindbyname ($stmt,":Innome_curso",$nome_curso);
		ocibindbyname ($stmt,":Innome_agraciado",$nome_agraciado);
		ocibindbyname ($stmt,":Innome_ins_conv",$nome_ins_conv);
		ocibindbyname ($stmt,":Insetor_ins_conv",$setor_ins_conv);
		ocibindbyname ($stmt,":Indt_inicio",$dt_inicio);		
		ocibindbyname ($stmt,":Indt_fim",$dt_fim);		
		ocibindbyname ($stmt,":Incarga",$carga);
		ocibindbyname ($stmt,":Inlocalidade",$localidade);
		ocibindbyname ($stmt,":Indt_exp",$dt_exp);
		ocibindbyname ($stmt,":Incodigo",$codigo);
		ocibindbyname ($stmt,":Incargo",$cargo);
		ocibindbyname ($stmt,":Intit_classe",$tit_classe);
		ocibindbyname ($stmt,":Inposse",$posse);
		ocibindbyname ($stmt,":Inexercicio",$exercicio);
		ocibindbyname ($stmt,":Insetor",$setor);
		ocibindbyname ($stmt,":Intit_funcao",$tit_funcao);
		ocibindbyname ($stmt,":Inramal",$ramal);
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
