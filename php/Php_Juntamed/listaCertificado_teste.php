<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
require("verifica.php");
require("conecta.php");

extract($_POST);

$_docxml = new DOMdocument('1.0','utf-8');
$_resp = $_docxml->createElement('itens');
$_att =  $_docxml->createAttribute("id");
$_id =    $_docxml->createTextNode($_SESSION["sisjud"]);

$codigo = utf8_decode($codigo);
$tipo = utf8_decode($tipo);
$protocolo = utf8_decode($protocolo);
$dtprotocolo = utf8_decode($dtprotocolo);

$_att->appendChild($_id);
$_resp->appendChild($_att);
$curs = ocinewcursor($conn);
/* $stmt = ociparse($conn,"begin rh.pck_juntamed.lista_atestado(:InSessao, :Incod_curso,:Incpf,:Innome_curso,:Innome_agraciado,:Innome_ins_conv,:Insetor_ins_conv,:Innome_al_conv,:Insetor_al_conv,:Indt_inicio,:Indt_fim,:Incarga,:Inlocalidade,:Indt_exp,:Incodigo,:Incargo,:Intit_classe,:Inposse,:Inexercicio,:Insetor,:Intit_funcao,:Inramal,:outresultado); end;"); */
$stmt = ociparse($conn,"begin sisjud.listaCertificado(:InSessao, :Incod_curso,:Incpf,:Innome_curso,:Innome_agraciado,:Innome_ins_conv,:Insetor_ins_conv,:Innome_al_conv,:Insetor_al_conv,:Indt_inicio,:Indt_fim,:Incarga,:Inlocalidade,:Indt_exp,:Incodigo,:Incargo,:Intit_classe,:Inposse,:Inexercicio,:Insetor,:Intit_funcao,:Inramal,:outresultado); end;");
		ocibindbyname ($stmt,":InSessao",$_SESSION["sisjud"]);
		ocibindbyname ($stmt,":Incod_curso",$cod_curso);
		ocibindbyname ($stmt,":Incpf",$cpf);
		ocibindbyname ($stmt,":Innome_curso",$cod_curso);		
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
		/* ocibindbyname ($stmt,":Incodigo",$codigo);
		ocibindbyname ($stmt,":Incargo",$cargo);
		ocibindbyname ($stmt,":Intit_classe",$tit_classe);
		ocibindbyname ($stmt,":Inposse",$posse);
		ocibindbyname ($stmt,":Inexercicio",$exercicio);
		ocibindbyname ($stmt,":Insetor",$setor);
		ocibindbyname ($stmt,":Intit_funcao",$tit_funcao);
		ocibindbyname ($stmt,":Inramal",$ramal);  */
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

            $_cpo = $_docxml->createElement('curso');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[1]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);

            $_cpo = $_docxml->createElement('agraciado');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[2]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);

            $_cpo = $_docxml->createElement('dt_inicio');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[3]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);

            $_cpo = $_docxml->createElement('dt_fim');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[4]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('carga');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[5]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('localidade');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[6]));
			$_cpo->appendChild($_des);
            $_item->appendChild($_cpo);
			
			$_cpo = $_docxml->createElement('dt_exp');
			$_des = $_docxml->createTextNode(utf8_encode($outresultado[7]));
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