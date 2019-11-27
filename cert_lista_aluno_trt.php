<?php

/*
 * faz a conexao ao banco
 * e seleciona a base de dados
 */

include 'conecta.php';

/*
 * monta e executa consulta em SQL
 */
$sql = "SELECT * FROM certificado WHERE cert_conv_cpf = '0' ORDER BY cert_aluno_nome ASC";
$resultado = mysql_query($sql)
or die ("Não foi possível realizar a consulta.");

?>
<html><head><title>Nova pagina 1</title></head>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<body>
<form action="imprimir.php" method="post">
<center>
<table border="1">

<tr>
<th>Nome do Aluno:</th>
<th>Nome do Curso:</th>
<th>Opções</th>
</tr>

<?php

/*
 * mostra os dados na tela
 */
while ($linha=mysql_fetch_array($resultado))
{
   echo "<tr>";
   echo "<td>{$linha['cert_aluno_nome']}</td>";
   echo "<td>{$linha['cert_curso_nome']}</td>";
   echo "<td>| <a target='_blank' href='imprimir_aluno_trt.php?cert_id={$linha['cert_id']}'>Imprimir</a> |</td>";
   echo "</tr>";
}

echo "</table>";

?>
</center>
</form>
</body></html>