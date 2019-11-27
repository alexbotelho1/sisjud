<?php

function erro_conexao(){
            $_docxml = new DOMdocument('1.0','utf-8');
            $_resp = $_docxml->createElement('ERRO');
            $_cpo = $_docxml->createElement('descricao');
            $_des = $_docxml->createTextNode('Erro ao conectar no Banco de Dados');
            $_cpo->appendChild($_des);
            $_resp->appendChild($_cpo);
            $_docxml->appendChild($_resp);
            Header("Content-type: application/xml; charset=utf-8");
            echo $_docxml->saveXML();
            exit;
}

//$conn = @OCILogon ("rel_rh", "rel\$trt14", "bdtrt14") or erro_conexao();
$conn = @OCILogon ("rh", "rhdesenv", "desenv") or erro_conexao();
//$conn = @OCILogon ("juntamed", "juntamed\$trt14", "bdtrt14") or erro_conexao();

$r = @ociexecute($stmt);


function erro ($stmt) {
            $_docxml = new DOMdocument('1.0','utf-8');
            $e = ocierror($stmt);
			$m = $e['message'];
			$m = substr(strstr($m,'*'),12);
			$p = strpos($m,'*');
			$m = substr($m,0,$p);
			$_resp = $_docxml->createElement('ERRO');
            $_cpo = $_docxml->createElement('descricao');
            if ($m == ""){
               $_des = $_docxml->createTextNode(utf8_encode($e['message']));
            }else
            {
               $_des = $_docxml->createTextNode(utf8_encode($m));
            }
            
			$_cpo->appendChild($_des);
            $_resp->appendChild($_cpo);
            $_docxml->appendChild($_resp);
            OCIFreeStatement($stmt);
			if ($curs != null) {
		      OCIFreeCursor($curs);
			  }
			if ($conn != null) {
  		       OCILogoff($conn);
			  }
            Header("Content-type: application/xml; charset=utf-8");
            echo $_docxml->saveXML();
            exit;
		}


?>
