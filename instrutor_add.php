<?php

/*
 * faz a conexao ao banco
 * e seleciona a base de dados
 */

include 'conecta.php';

/*
 * monta query em SQL para insercao
 */
$sql = "INSERT INTO instrutor (
inst_codigo, 
inst_nome, 
inst_curso_id, 
inst_conv_cpf, 
inst_conv_nome, 
inst_conv_local, 
inst_form_prof, 
inst_form_acad
) VALUES (
'".$_POST['inst_codigo']."',
'".$_POST['inst_nome']."',
'".$_POST['inst_curso_id']."',
'".$_POST['inst_conv_cpf']."', 
'".$_POST['inst_conv_nome']."', 
'".$_POST['inst_conv_local']."', 
'".$_POST['inst_form_prof']."', 
'".$_POST['inst_form_acad']."'
)";

/*
 * executa a query
 */
$sql = mysql_query($sql)
or die ("Houve erro na gravação dos dados.");

header("Location: cad_instrutor.php");

?>

<h1>Cadastro efetuado com sucesso!</h1>
