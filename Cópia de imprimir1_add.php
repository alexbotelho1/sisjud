 <?php

/*
 * faz a conexao ao banco
 * e seleciona a base de dados
 */

include 'conecta.php';

/*
 * monta query em SQL para insercao
 */
$sql = "INSERT INTO certificado (
cert_aluno_nome, 
cert_curso_id, 
cert_carga, 
cert_form_prof, 
cert_form_acad, 
cert_dt_ini_dia,
cert_dt_ini_mes,
cert_dt_ini_ano,
cert_dt_fim_dia, 
cert_dt_fim_mes, 
cert_dt_fim_ano, 
cert_local, 
cert_ass
) VALUES (
'".$_POST['cert_aluno_nome']."',
'".$_POST['cert_curso_id']."',
'".$_POST['cert_carga']."',
'".$_POST['cert_form_prof']."', 
'".$_POST['cert_form_acad']."', 
'".$_POST['cert_dt_ini_dia']."',
'".$_POST['cert_dt_ini_mes']."',
'".$_POST['cert_dt_ini_ano']."', 
'".$_POST['cert_dt_fim_dia']."', 
'".$_POST['cert_dt_fim_mes']."', 
'".$_POST['cert_dt_fim_ano']."', 
'".$_POST['cert_local']."',
'".$_POST['cert_ass']."'
)";

/*
 * executa a query
 */
$sql = mysql_query($sql)
or die ("Houve erro na gravação dos dados.");

header("Location: cert_aluno_trt.php");

?>

<h1>Cadastro efetuado com sucesso!</h1>
