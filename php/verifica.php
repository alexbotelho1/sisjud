<?php
// muda o escopo do cookie e do cache
//session_cache_limiter("public");

session_cache_limiter('public');

/* Define o limite de tempo do cache em 30 minutos */
//session.timeout=1;

//INICIALIZA A SESS�O
session_start();

//SE N�O TIVER VARI�VEIS REGISTRADAS
//RETORNA PARA A TELA DE LOGIN
if(!isset($_SESSION["sisjud"]))
   header("Location: ../index.html");
?>
