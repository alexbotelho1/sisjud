<?php

/*
 * faz a conexao ao banco
 * e seleciona a base de dados
 */

include 'conecta.php';

/*
 * monta query em SQL para insercao
 */
$sql = "INSERT INTO curso (
curs_nome, 
curs_codigo, 
curs_carga
) VALUES (
'".$_POST['curs_nome']."',
'".$_POST['curs_codigo']."',
'".$_POST['curs_carga']."'
)";

/*
 * executa a query
 */
$sql = mysql_query($sql)
or die ("Houve erro na gravação dos dados.");

header("Location: cad_curso.php");

?>

<h1>Cadastro efetuado com sucesso!</h1>
