<?php
// muda o escopo do cookie e do cache
session_cache_limiter("public");
//INICIALIZA A SESS�O
session_start();

//SE N�O TIVER VARI�VEIS REGISTRADAS
//RETORNA PARA A TELA DE LOGIN
if(!isset($_SESSION["juntamed"]))
   header("Location: index.html");
?>
