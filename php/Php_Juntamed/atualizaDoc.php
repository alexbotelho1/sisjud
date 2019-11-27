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

$pasep = utf8_decode($pasep);
$ident = utf8_decode($ident);
$dt_exped = utf8_decode($dt_exped);
$org_exped = utf8_decode($org_exped);
$uf = utf8_decode($uf);
$cart_func = utf8_decode($cart_func);
$titulo = utf8_decode($titulo);
$zona = utf8_decode($zona);
$secao = utf8_decode($secao);
$reservista = utf8_decode($reservista);
$reg_militar = utf8_decode($reg_militar);
$cart_habili = utf8_decode($cart_habili);
$categ = utf8_decode($categ);


$curs = ocinewcursor($conn);
$stmt = ociparse($conn,"begin srec.atualiza_doc(:InUsuario,:InPasep,:InIdent,:InDtExped,:InOrgExpe,:InUf,:InCartFunc,:InTitulo,:InZona,:InSecao,:InReserv,:InRegMil,:InCartHab,:InCateg, :outresultado); end;");
		ocibindbyname ($stmt,":InUsuario",$_SESSION["v_id"]);
		ocibindbyname ($stmt,":InPasep",$pasep);
		ocibindbyname ($stmt,":InIdent",$ident);		
		ocibindbyname ($stmt,":InDtExped",$dt_exped);
		ocibindbyname ($stmt,":InOrgExpe",$org_exped);		
		ocibindbyname ($stmt,":InUf",$uf);
		ocibindbyname ($stmt,":InCartFunc",$cart_func);
		ocibindbyname ($stmt,":InTitulo",$titulo);
		ocibindbyname ($stmt,":InZona",$zona);
		ocibindbyname ($stmt,":InSecao",$secao);
		ocibindbyname ($stmt,":InReserv",$reservista);
		ocibindbyname ($stmt,":InRegMil",$reg_militar);
		ocibindbyname ($stmt,":InCartHab",$cart_habili);
		ocibindbyname ($stmt,":InCateg",$categ);
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
