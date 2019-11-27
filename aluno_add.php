<?php

/*
 * faz a conexao ao banco
 * e seleciona a base de dados
 */

include 'conecta.php';

/*
 * monta query em SQL para insercao
 */
$sql = "INSERT INTO aluno (
alun_codigo, 
alun_nome, 
alun_curso_id, 
alun_conv_cpf, 
alun_conv_nome, 
alun_conv_local, 
alun_form_prof, 
alun_form_acad
) VALUES (
'".$_POST['alun_codigo']."',
'".$_POST['alun_nome']."',
'".$_POST['alun_curso_id']."',
'".$_POST['alun_conv_cpf']."', 
'".$_POST['alun_conv_nome']."', 
'".$_POST['alun_conv_local']."', 
'".$_POST['alun_form_prof']."', 
'".$_POST['alun_form_acad']."'
)";

/*
 * executa a query
 */
$sql = mysql_query($sql)
or die ("Houve erro na gravação dos dados.");

header("Location: cad_aluno.php");

?>

<h1>Cadastro efetuado com sucesso!</h1>
