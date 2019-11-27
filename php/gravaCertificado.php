<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
require("verifica.php");
require("conecta.php");

extract($_POST);

$_docxml = new DOMdocument('1.0','utf-8');
$_resp = $_docxml->createElement('itens');
$_att  = $_docxml->createAttribute("id");
$_id   = $_docxml->createTextNode($_SESSION["sejud"]);


$codigo = utf8_decode($codigo);
$cod_curso = utf8_decode($cod_curso)
$nome_curso = utf8_decode($nome_curso);
$nome_agraciado = utf8_decode($nome_agraciado);
/* $nome_ins_conv = utf8_decode($nome_ins_conv);
$setor_ins_conv = utf8_decode($setor_ins_conv);
$nome_al_conv = utf8_decode($nome_al_conv);
$setor_al_conv = utf8_decode($setor_al_conv); */
$dt_inicio = utf8_decode($dt_inicio);
$dt_fim = utf8_decode($dt_fim);
$carga = utf8_decode($carga);
$localidade = utf8_decode($localidade);
$dt_exp = utf8_decode($dt_exp);


$_att->appendChild($_id);
$_resp->appendChild($_att);
$curs = ocinewcursor($conn);
$curs_sal = ocinewcursor($conn);

Header("Content-type: application/xml; charset=utf-8");

$sql = "begin sejud.gravaParecer(:InSessao,:Incodigo,:Incod_curso,:Innome_curso,:Innome_agraciado,:Indt_inicio,:Indt_fim,:Incarga,:Inlocalidade,:Indt_exp,:outresultado); end;");

$stmt = ociparse($conn,$sql);
		ocibindbyname ($stmt,":InSessao",$_SESSION["sejud"]);
		ocibindbyname ($stmt,":Incodigo",$codigo);
		ocibindbyname ($stmt,":Incod_curso",$cod_curso);
		/* ocibindbyname ($stmt,":Incpf",0); */
		//ocibindbyname ($stmt,":Incpf",$cpf);
		ocibindbyname ($stmt,":Innome_curso",$nome_curso);		
		ocibindbyname ($stmt,":Innome_agraciado",$nome_agraciado);
		/* ocibindbyname ($stmt,":Innome_ins_conv",$nome_ins_conv);
		ocibindbyname ($stmt,":Insetor_ins_conv",$setor_ins_conv);
		ocibindbyname ($stmt,":Innome_al_conv",$nome_al_conv);
		ocibindbyname ($stmt,":Insetor_al_conv",$setor_al_conv); */
		ocibindbyname ($stmt,":Indt_inicio",$dt_inicio);
		ocibindbyname ($stmt,":Indt_fim",$dt_fim);
		ocibindbyname ($stmt,":Incarga",$carga);
		ocibindbyname ($stmt,":Inlocalidade",$localidade);
		ocibindbyname ($stmt,":Indt_exp",$dt_exp);	
		ocibindbyname ($stmt,":OutResultado",$curs,-1,OCI_B_CURSOR);

		// $x = $_SESSION["v_id"];

		$r = @ociexecute($stmt);
		
		if (!$r) {
			erro ($stmt);
		}
		ociexecute($curs);

		while (ocifetchinto($curs,$outresultado)){
			//MONTA XML RETORNO
			$_item = $_docxml->createElement('item');
            $_cpo = $_docxml->createElement('msg3');
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

		