<?php
//INICIALIZA A SESS�O
session_start();

//DESTR�I AS VARI�VEIS
unset($_SESSION["v_id"]);

//REDIRECIONA PARA A TELA DE LOGIN
Header("Location: ../index.html");
?>
