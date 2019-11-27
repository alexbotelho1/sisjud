<?php

/*
 * faz a conexao ao banco
 * e seleciona a base de dados
 */
 
include 'conecta.php';

/*
 * monta e executa consulta em SQL
 */
$ver = ($_POST['ver']) ? $_POST['ver'] : '0';
$sql = "UPDATE noticias SET 
nome='".$_POST['nome']."', 
sobrenome='".$_POST['sobrenome']."', 
cidade='".$_POST['cidade']."', 
estado='".$_POST['estado']."', 
email='".$_POST['email']."', 
data=NOW(), 
hora=NOW(), 
titulo='".$_POST['titulo']."', 
resumo='".$_POST['resumo']."', 
texto='".$_POST['texto']."', 
ver=".$ver." "."
WHERE id = ".$_GET['id'];

$resultado = mysql_query($sql)
or die ("Erro ao alterar notícia.");

header("Location: editar.php");

?>
<html>
<h1>Notícia alterada com sucesso!</h1>