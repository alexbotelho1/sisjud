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
or die ("Erro ao remover not�cia.");

header("Location: editar.php");

?>

<h1>A not�cia foi exclu�da com �xito!</h1>
