<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
require("verifica.php");
require("conecta.php");

extract($_POST);

$_docxml = new DOMdocument('1.0','utf-8');
$_resp = $_docxml->createElement('itens');
$_att =  $_docxml->createAttribute("id");
$_id =    $_docxml->createTextNode($_SESSION["sisjud"]);

$cod_curso = utf8_decode($cod_curso);
$cpf = utf8_decode($cpf);
$nome_curso = utf8_decode($nome_curso);
$nome_agraciado = utf8_decode($nome_agraciado);
$nome_ins_conv = utf8_decode($nome_ins_conv);
$setor_ins_conv = utf8_decode($setor_ins_conv);
$nome_al_conv = utf8_decode($nome_al_conv);
$setor_al_conv = utf8_decode($setor_al_conv);
$dt_inicio = utf8_decode($dt_inicio);
$dt_fim = utf8_decode($dt_fim);
$carga = utf8_decode($carga);
$localidade = utf8_decode($localidade);
$dt_exp = utf8_decode($dt_exp);

$_att->appendChild($_id);
$_resp->appendChild($_att);
$curs = ocinewcursor($conn);
$stmt = ociparse($conn,"begin sisjud.listaCertificado(:InSessao,:Incod_curso,:Incpf,:Innome_curso,:Innome_agraciado,:Innome_ins_conv,:Insetor_ins_conv,:Innome_al_conv,:Insetor_al_conv,:Indt_inicio,:Indt_fim,:Incarga,:Inlocalidade,:Indt_exp,:outresultado); end;");
		ocibindbyname ($stmt,":InSessao",$_SESSION["sisjud"]);
		ocibindbyname ($stmt,":Incod_curso",$cod_curso);
		/* ocibindbyname ($stmt,":Incpf",$cpf); */
		ocibindbyname ($stmt,":Incpf",0);
		ocibindbyname ($stmt,":Innome_curso",$nome_curso);		
		ocibindbyname ($stmt,":Innome_agraciado",$nome_agraciado);
		ocibindbyname ($stmt,":Innome_ins_conv",$nome_ins_conv);
		ocibindbyname ($stmt,":Insetor_ins_conv",$setor_ins_conv);
		ocibindbyname ($stmt,":Innome_al_conv",$nome_al_conv);
		ocibindbyname ($stmt,":Insetor_al_conv",$setor_al_conv);
		ocibindbyname ($stmt,":Indt_inicio",$dt_inicio);
		ocibindbyname ($stmt,":Indt_fim",$dt_fim);
		ocibindbyname ($stmt,":Incarga",$carga);
		ocibindbyname ($stmt,":Inlocalidade",$localidade);
		ocibindbyname ($stmt,":Indt_exp",$dt_exp);
		ocibindbyname ($stmt,":outresultado",$curs,-1,OCI_B_CURSOR);

		$x = $_SESSION["sisjud"];

		$r = @ociexecute($stmt);
		

		if (!$r) {
			erro ($stmt);
		}
		ociexecute($curs);

		
		while (ocifetchinto($curs,$outresultado)){
			//MONTA XML RETORNO
            $_item = $_docxml->createElement('item');

            $_cpo = $_docxml->createElement('cod_curso');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[0]));
            $_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('cpf');
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
			
			$_cpo = $_docxml->createElement('nome_al_conv');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[6]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('setor_al_conv');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[7]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);

            $_cpo = $_docxml->createElement('dt_inicio');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[8]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);

            $_cpo = $_docxml->createElement('dt_fim');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[9]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('carga');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[10]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('localidade');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[11]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('dt_exp');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[12]));
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