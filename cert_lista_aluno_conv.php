<?php

/*
 * faz a conexao ao banco
 * e seleciona a base de dados
 */

include 'conecta.php';

/*
 * monta e executa consulta em SQL
 */
$sql = "SELECT * FROM certificado WHERE cert_codigo = '0' ORDER BY cert_conv_nome ASC";
$resultado = mysql_query($sql)
or die ("Não foi possível realizar a consulta.");

?>
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
   echo "<td>{$linha['cert_conv_nome']}</td>";
   echo "<td>{$linha['cert_curso_nome']}</td>";
   echo "<td>| <a target='_blank' href='imprimir_aluno_conv.php?cert_id={$linha['cert_id']}'>Imprimir</a> |</td>";
   echo "</tr>";
}

echo "</table>";

?>
</center>