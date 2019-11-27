<?php

/*
 * faz a conexao ao banco
 * e seleciona a base de dados
 */

include 'conecta.php';

/*
 * monta query em SQL para insercao
 */
$sql = "INSERT INTO noticias (
nome, 
sobrenome, 
cidade, 
estado, 
email, 
data,
hora, 
titulo, 
resumo, 
texto
) VALUES (
'".$_POST['nome']."', 
'".$_POST['sobrenome']."', 
'".$_POST['cidade']."', 
'".$_POST['estado']."', 
'".$_POST['email']."', 
NOW(), 
NOW(), 
'".$_POST['titulo']."',
'".$_POST['resumo']."',
'".$_POST['texto']."'
)";

/*
 * executa a query
 */
$sql = mysql_query($sql)
or die ("Houve erro na gravação dos dados.");

header("Location: index.php");

?>

<h1>Cadastro efetuado com sucesso!</h1>
