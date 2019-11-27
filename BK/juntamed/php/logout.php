<?php
//INICIALIZA A SESSÃO
session_start();

//DESTRÓI AS VARIÁVEIS
unset($_SESSION["v_id"]);

//REDIRECIONA PARA A TELA DE LOGIN
Header("Location: ../index.html");
?>
