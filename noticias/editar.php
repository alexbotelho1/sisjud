<?php

/*
 * faz a conexao ao banco
 * e seleciona a base de dados
 */

include 'conecta.php';

/*
 * monta e executa consulta em SQL
 */
$sql = "SELECT * FROM noticias ORDER BY id DESC";
$resultado = mysql_query($sql)
or die ("Não foi possível realizar a consulta.");

?>

<table>

<tr>
<th>ID:</th>
<th>Nome:</th>
<th>Sobrenome:</th>
<th>Cidade:</th>
<th>UF:</th>
<th>Email:</th>
<th>Data:</th>
<th>Hora:</th>
<th>Título:</th>
<th>Disponível?</th>
<th>Opções</th>
</tr>

<?php

/*
 * mostra os dados na tela
 */
while ($linha=mysql_fetch_array($resultado))
{
   $novadata = substr($linha['data'],8,2) . "/" .
   substr($linha['data'],5,2) . "/" . 
   substr($linha['data'],0,4);

   $novahora = substr($linha['hora'],0,2) . "h" .
   substr($linha['hora'],3,2) . "min";

   echo "<tr>";
   echo "<td>{$linha['id']}</td>";
   echo "<td>{$linha['nome']}</td>";
   echo "<td>{$linha['sobrenome']}</td>";
   echo "<td>{$linha['cidade']}</td>";
   echo "<td>{$linha['estado']}</td>";
   echo "<td>{$linha['email']}</td>";
   echo "<td>$novadata</td>";
   echo "<td>$novahora</td>";
   echo "<td>{$linha['titulo']}</td>";
   echo "<td>{$linha['ver']}</td>";
   echo "<td><a href='alterar.php?id={$linha['id']}'>Alterar</a> / ";
   echo "<a href='excluir.php?id={$linha['id']}'>Excluir</a></td>";
   echo "</tr>";
}

echo "</table>";

?>
<form action="index.php"><input type="submit" value=" Voltar "></form>

