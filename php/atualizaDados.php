<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
require("verifica.php");
require("conecta.php");

extract($_POST);

$_docxml = new DOMdocument('1.0','utf-8');
$_resp = $_docxml->createElement('itens');
$_att =  $_docxml->createAttribute("id");
$_id =    $_docxml->createTextNode($_SESSION["v_id"]);
$_att->appendChild($_id);
$_resp->appendChild($_att);

$nome = utf8_decode($nome);
$cor = utf8_decode($cor);
$tp_sangue = utf8_decode($tp_sangue);
$fator = utf8_decode($fator);
$est_civil = utf8_decode($est_civil);
$nacion = utf8_decode($nacion);
$uf = utf8_decode($uf);
$natural = utf8_decode($natural);
$lograd = utf8_decode($lograd);
$bairro = utf8_decode($bairro);
$uflog = utf8_decode($uflog);
$cidade = utf8_decode($cidade);
$cep = utf8_decode($cep);
$dddtel = utf8_decode($dddtel);
$tel = utf8_decode($tel);
$dddcel = utf8_decode($dddcel);
$cel = utf8_decode($cel);
$email = utf8_decode($email);


$curs = ocinewcursor($conn);
$stmt = ociparse($conn,"begin srec.atualiza_dados(:InUsuario,:InNome,:InCor,:InSangue,:InFator,:InEstCivil,:InNacion,:InUf,:InNatural,:InLograd,:InBairro,:InUfLog,:InCidade,:InCep,:InDddTel,:InTel,:InDddCel,:InCel,:InEmail, :outresultado); end;");
		ocibindbyname ($stmt,":InUsuario",$_SESSION["v_id"]);
		ocibindbyname ($stmt,":InNome",$nome);
		ocibindbyname ($stmt,":InCor",$cor);		
		ocibindbyname ($stmt,":InSangue",$tp_sangue);
		ocibindbyname ($stmt,":InFator",$fator);		
		ocibindbyname ($stmt,":InEstCivil",$est_civil);
		ocibindbyname ($stmt,":InNacion",$nacion);
		ocibindbyname ($stmt,":InUf",$uf);
		ocibindbyname ($stmt,":InNatural",$natural);
		ocibindbyname ($stmt,":InLograd",$lograd);
		ocibindbyname ($stmt,":InBairro",$bairro);
		ocibindbyname ($stmt,":InUfLog",$uflog);
		ocibindbyname ($stmt,":InCidade",$cidade);
		ocibindbyname ($stmt,":InCep",$cep);
		ocibindbyname ($stmt,":InDddTel",$dddtel);
		ocibindbyname ($stmt,":InTel",$tel);
		ocibindbyname ($stmt,":InDddCel",$dddcel);
		ocibindbyname ($stmt,":InCel",$cel);
		ocibindbyname ($stmt,":InEmail",$email);
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
