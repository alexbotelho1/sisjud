<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
require("conecta.php");

	extract($_POST);
	$curs = ocinewcursor($conn);
	$stmt = ociparse($conn,"begin sisjud.retorna_Login(:InLogin, :InSenha, :outresultado); end;");
		ocibindbyname ($stmt,":InLogin",$usuario);
		ocibindbyname ($stmt,":InSenha",$senha);
		ocibindbyname ($stmt,":outresultado",$curs,-1,OCI_B_CURSOR);
		$r = @ociexecute($stmt);
		if (!$r) {
             erro ($stmt);
		}
		ociexecute($curs);
		$_docxml = new DOMdocument('1.0','utf-8');
        $_resp = $_docxml->createElement('login');
        //INICIALIZA A SESSÃO
        session_start();
		while (ocifetchinto($curs,$outresultado)){
			//GRAVA AS VARIÁVEIS NA SESSÃO
			$_SESSION["sisjud"]    =   $outresultado[0];
            
	        $_att =  $_docxml->createAttribute("cdserv");
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
