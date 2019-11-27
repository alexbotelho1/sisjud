<?php

/*
 * faz a conexao ao banco
 * e seleciona a base de dados
 */

include 'conecta.php';

/*
 * monta e executa consulta em SQL
 */
$sql = "DELETE FROM noticias WHERE id = ".$_GET['id'];

$resultado = mysql_query($sql)
or die ("Erro ao remover notícia.");

header("Location: editar.php");

?>

<h1>A notícia foi excluída com êxito!</h1>
