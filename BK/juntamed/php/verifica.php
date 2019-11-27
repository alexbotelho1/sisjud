<?php
// muda o escopo do cookie e do cache
session_cache_limiter("public");
//INICIALIZA A SESSÃO
session_start();

//SE NÃO TIVER VARIÁVEIS REGISTRADAS
//RETORNA PARA A TELA DE LOGIN
if(!isset($_SESSION["juntamed"]))
   header("Location: index.html");
?>
