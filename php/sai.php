<?php
//INICIALIZA A SESSÃO
session_start();

//DESTRÓI AS VARIÁVEIS
session_destroy();
//unset($_SESSION["sejud"]);

//REDIRECIONA PARA A TELA DE LOGIN
Header("Location:../index.html");
//Header("Location:http://www.trt14.jus.br");
?>