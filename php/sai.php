<?php
//INICIALIZA A SESS�O
session_start();

//DESTR�I AS VARI�VEIS
session_destroy();
//unset($_SESSION["sejud"]);

//REDIRECIONA PARA A TELA DE LOGIN
Header("Location:../index.html");
//Header("Location:http://www.trt14.jus.br");
?>