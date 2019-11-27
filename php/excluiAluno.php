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

$codigo = utf8_decode($codigo);

$curs = ocinewcursor($conn);
/* $stmt = ociparse($conn,"begin sisjud.Exclui_Certificado(:InUsuario, :InCodigo, :outresultado); end;"); */
/* $stmt = ociparse($conn,"begin sisjud.atualizaAluno(:InUsuario, :Incpf,:Innome_agraciado,:Innome_al_conv,:Insetor_al_conv,:Incod_curso,:Innome_curso,:Inform_prof,:Inform_acad,:Incodigo,:Incargo,:Intit_classe,:Inposse,:Inexercicio,:Insetor,:Intit_funcao,:Inramal,:outresultado); end;"); */
  $stmt = ociparse($conn,"begin sisjud.excluiAluno(:InUsuario, :Incpf,:Innome_agraciado,:Innome_al_conv,:Insetor_al_conv,:Incod_curso,:Innome_curso,:Inform_prof,:Inform_acad,:outresultado); end;");
	    ocibindbyname ($stmt,":Incod_curso",$_SESSION["sisjud"]);
		$cpf = utf8_decode($cpf);
        $nome_agraciado = utf8_decode($nome_agraciado);
        $nome_al_conv = utf8_decode($nome_al_conv);
        $setor_al_conv = utf8_decode($setor_al_conv);
        $cod_curso = utf8_decode($cod_curso);
        $nome_curso = utf8_decode($nome_curso);
        $form_prof = utf8_decode($form_prof);
        $form_prof = utf8_decode($form_acad);
      /* $codigo = utf8_decode($codigo);
                     $cargo = utf8_decode($cargo);
                     $tit_classe = utf8_decode($tit_classe);
                     $posse = utf8_decode($posse);
                     $exercicio = utf8_decode($exercicio);
                     $setor = utf8_decode($setor);
                     $tit_funcao = utf8_decode($tit_funcao);
                     $ramal = utf8_decode($ramal); */
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
