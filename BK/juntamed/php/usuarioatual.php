<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
/*if(!isset($_SESSION[v_id]))
   Header("Location: ../index.html");*/
require("verifica.php");
require("conecta.php");

	$curs = ocinewcursor($conn);
	$stmt = ociparse($conn,"begin srec.retorna_useratual(:InUsuario, :outresultado); end;");
		ocibindbyname ($stmt,":InUsuario",$_SESSION["v_id"]);
		ocibindbyname ($stmt,":outresultado",$curs,-1,OCI_B_CURSOR);
		$r = @ociexecute($stmt);
		if (!$r) {
             erro ($stmt);
		}
		ociexecute($curs);
		$_docxml = new DOMdocument('1.0','utf-8');
        
		while (ocifetchinto($curs,$outresultado)){
		$_resp = $_docxml->createElement('login');
	      
            $_att =  $_docxml->createAttribute("usuario");
            $_id =    $_docxml->createTextNode(utf8_encode($outresultado[0]));
            $_att->appendChild($_id);
            $_resp->appendChild($_att);

			}
        $_docxml->appendChild($_resp);
        OCIFreeStatement($stmt);
		OCIFreeCursor($curs);
		OCILogoff($conn);

Header("Content-type: application/xml; charset=utf-8");
echo $_docxml->saveXML();

?>
