<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
require("conecta.php");

$q = strtolower($_GET["q"]);


$chave    = utf8_decode($q);
$processo = 'lista_servidores3';

$curs = ocinewcursor($conn);
$curs_sal = ocinewcursor($conn);

$sql = "begin rh.pck_relatorios." . $processo . "(:InSessao, :InChave, :outresultado); end;";

$stmt = ociparse($conn,$sql);
		ocibindbyname ($stmt,":InSessao",$_SESSION["v_id"]);
		ocibindbyname ($stmt,":InChave",$chave);
		ocibindbyname ($stmt,":outresultado",$curs,-1,OCI_B_CURSOR);

		$x = $_SESSION["v_id"];

		$r = @ociexecute($stmt);
		

		if (!$r) {
			erro ($stmt);
		}
		ociexecute($curs);

		while (ocifetchinto($curs,$outresultado)){
			//MONTA XML RETORNO
			$key=$outresultado[0];
			$value=utf8_encode($outresultado[1]);
  		    echo "$key|$value\n";
            }
			
			
			
		OCIFreeStatement($stmt);
		OCIFreeCursor($curs);
		OCILogoff($conn);

?>
