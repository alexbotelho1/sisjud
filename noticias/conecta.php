<?php

$conexao = mysql_connect("localhost", "root", "")
or die ("Erro na conex�o ao banco de dados.");
$db = mysql_select_db("sisjud")
or die ("Erro ao selecionar a base de dados.");

?>