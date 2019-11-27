<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
require("conecta.php");

extract($_POST);

$_docxml = new DOMdocument('1.0','utf-8');
$_resp = $_docxml->createElement('itens');
$_att  = $_docxml->createAttribute("id");
$_id   = $_docxml->createTextNode($_SESSION["v_id"]);

$codigo = utf8_decode($codigo);
$datainicio = utf8_decode($datainicio);
$datafim = utf8_decode($datafim);

$_att->appendChild($_id);
$_resp->appendChild($_att);
$curs = ocinewcursor($conn);
$curs_sal = ocinewcursor($conn);

$sql = "begin rh.pck_juntamed.existe_licenca(:InCodigo, :InDataIni, :InDataFim, :outresultado); end;";
$stmt = ociparse($conn,$sql);
		ocibindbyname ($stmt,":InCodigo",$codigo);
		ocibindbyname ($stmt,":InDataIni",$datainicio);
		ocibindbyname ($stmt,":InDataFim",$datafim);
		ocibindbyname ($stmt,":outresultado",$curs,-1,OCI_B_CURSOR);

		$x = $_SESSION["v_id"];

		$r = @ociexecute($stmt);
		

		if (!$r) {
			erro ($stmt);
		}
		ociexecute($curs);

		while (ocifetchinto($curs,$outresultado)){
			//MONTA XML RETORNO
            $_item = $_docxml->createElement('item');
			$t = count($outresultado);
			for ($i = 0; $i <= $t; $i++) {
	            $_cpo = $_docxml->createElement('mensagem'); 
				$_des = $_docxml->createTextNode(utf8_encode($outresultado[$i]));
	            $_cpo->appendChild($_des);
	            $_item->appendChild($_cpo);
			}	

			$_resp->appendChild($_item);
            }
			
			
			
        $_docxml->appendChild($_resp);
		
		OCIFreeStatement($stmt);
		OCIFreeCursor($curs);
		OCILogoff($conn);
Header("Content-type: application/xml; charset=utf-8");
echo $_docxml->saveXML();

?>


