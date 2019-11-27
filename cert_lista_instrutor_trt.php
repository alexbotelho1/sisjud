<?php

/*
 * faz a conexao ao banco
 * e seleciona a base de dados
 */

include 'conecta.php';

/*
 * monta e executa consulta em SQL
 */
$sql = "SELECT * FROM instrutor ORDER BY inst_nome ASC";
$resultado = mysql_query($sql)
or die ("Não foi possível realizar a consulta.");

?>
<center>
<table border="1">

<tr>
<th>Nome do Instrutor:</th>
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
   echo "<td>{$linha['inst_nome']}</td>";
   echo "<td>{$linha['inst_curso_nome']}</td>";
   echo "<td>| <a href='imrpimir_instrutor_trt.php?cert_id={$linha['inst_id']}'>Alterar</a> |</td>";
   echo "</tr>";
}

echo "</table>";

?>
</center>