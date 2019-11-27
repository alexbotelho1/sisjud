<?php

/*
 * faz a conexao ao banco
 * e seleciona a base de dados
 */

include 'conecta.php';

/*
 * monta e executa consulta em SQL
 */
$sql = "SELECT * FROM aluno ORDER BY alun_id DESC";
$resultado = mysql_query($sql)
or die ("Não foi possível realizar a consulta.");

?>

<table>

<tr>
<th>ID:</th>
<th>Nome:</th>
</tr>

<?php

/*
 * mostra os dados na tela
 */
while ($linha=mysql_fetch_array($resultado))
{
   echo "<tr>";
   echo "<td>{$linha['alun_id']}</td>";
   echo "<td>{$linha['alun_nome']}</td>";
   echo "<td><a href='alterar.php?id={$linha['alun_id']}'>Alterar</a> / ";
   echo "<a href='excluir.php?id={$linha['alun_id']}'>Excluir</a></td>";
   echo "</tr>";
}

echo "</table>";

?>
<form action="index.php"><input type="submit" value=" Voltar "></form>

