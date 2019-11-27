<?php

/*
 * faz a conexao ao banco
 * e seleciona a base de dados
 */
 
include 'conecta.php';

/*
 * monta consulta em SQL
 * seleciona as ultimas 15 noticias ordenadas
 * decrescente por data
 * obs.: seleciona somente as noticias que foram
 * liberadas pelo webmaster
 */
$sql = "SELECT * 
FROM noticias 
WHERE ver = '1' 
ORDER BY id DESC 
LIMIT 15";

/*
 * executa e trata a consulta
 */
$resultado = mysql_query($sql) 
or die ("Não foi possível realizar a consulta");
if (@mysql_num_rows($resultado) == 0)
   die('Nenhum registro encontrado');

/*
 * fazendo um loop para mostrar os resultados
 */
?>
 <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="50%"><p align="center"><a href="inserir.php">Inserir</a></td>
    <td width="50%"><p align="center"><a href="Editar.php">Editar</a></td>
  </tr>
</table>

<?php 

while ($linha=mysql_fetch_array($resultado))
{
   $novadata = substr($linha['data'],8,2) . "/" . 
   substr($linha['data'],5,2) . "/" . 
   substr($linha['data'],0,4);

   $novahora = substr($linha['hora'],0,2) . "h" . 
   substr($linha['hora'],3,2) . "min";

   echo "<b>Código da Notícia</b>: {$linha['id']} <br />";
   echo "Autor: {$linha['nome']} {$linha['sobrenome']} <br />";
   echo "E-mail: {$linha['email']} <br />";
   echo "Cidade: {$linha['cidade']} <br />";
   echo "Estado: {$linha['estado']} <br />";
   echo "Data: $novadata - Horário: $novahora <br />";
   echo "Título: {$linha['titulo']} <br />";
   echo "Resumo: <em> {$linha['resumo']} </em> <br />";
   echo "Notícia: {$linha['texto']} <br />";
   echo "Validado pelo Webmaster: ";

   if ($linha['ver'] == 1)
      echo "Sim";
   else
      echo "Não";
   echo "<hr />";
}

?>
