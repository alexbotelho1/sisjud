 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 STRict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-sTRict.dTD"> 

 <HTML xmlns="http://www.w3.org/1999/xhtml" lang="pt-BR" xml:lang="pt-BR"> 
 
<HEAD>

<meta http-equiv="Pragma" content="no-cache" />
<meta name="language" content="pt-BR" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<TITLE> </TITLE>


<link rel="stylesheet" type="text/css" href="/juntamed/css/principal2.css"> 
<link rel="stylesheet" type="text/css" href="/sejud/css/principal.css">
<link rel="stylesheet" type="text/css" href="/lib/scripts/geral/autocomplete/jquery.autocomplete.css" />
<link rel="stylesheet" type="text/css" href="/lib/css/ui.datepicker.css"/>

<script src="/lib/scripts/geral/jquery.js" type="text/javascript" ></script>
<script src="/lib/scripts/geral/jquery.maskedinput.js" type="text/javascript" ></script>
<script src="/lib/scripts/geral/ui.datepicker.js" type="text/javascript" ></script>
<script src="/lib/scripts/geral/ui.datepicker-pt-BR.js" type="text/javascript" ></script>
<script src="/lib/scripts/geral/autocomplete/lib/jquery.bgiframe.min.js" type="text/javascript" ></script>
<script src="/lib/scripts/geral/autocomplete/lib/jquery.dimensions.min.js" type="text/javascript" ></script>
<script src="/lib/scripts/geral/autocomplete/jquery.autocomplete.min.js" type="text/javascript" ></script>
<script src="/lib/scripts/TRT14/dataehoras.js" type="text/javascript" ></script>

<script src="scripts/comhash.js" type="text/javascript" ></script>
<script src="scripts/Sejud.js" type="text/javascript" ></script>
<script src="/scripts/funcoes.js" type="text/javascript" ></script>

<style  type="text/css">
 #outter {
	width : 983px;	
	height : 179px; 	
	padding : 0;
	margin : 0;
	background-image: url(imagens/top_site_sf.png);
	border : 0px solid green;
	position : relative;
}
#inner {
	position:absolute;
	z-index : 2;
	left: 37%;
	top: 50%;
	border : 0px solid blue;
	margin-top : 20px;
	margin-left : 0px;
    font-size:22px;
}
</style>

</HEAD>

	<div id="outter">
		<div id="inner"> Sistema da Ejud - Sejud</div>
	</div>
	
<BODY onload="listaCertificado()">
          <onload="montafocus();">

<form method="POST" action="menu.html">
<table width="950"><tr><td><center>
<input type="submit" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Voltar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" name="Voltar">
</tr></td></table>
</form>

   <table>
		<caption> Cadastro de Cursos e Palestras:</caption>
	</table>

<form action="curso_add.php" method="post">

	<table>
	
	<td width="6%"> Nome do Curso e da Palestra:<br>
		<input class="campo" type="text" id="curs_nome" name="curs_nome" size="80"/>
		<td width="6%"> Código do Curso ou da Palestra:<br>
		<INPUT type="text" name="curs_codigo" id="curs_codigo" size="10" maxlength='5'></td>	
	</table>
	<table>						
			<td width="6%"> Carga Horária:<br>
		<INPUT type="text" name="curs_carga" id="curs_carga" size="10" maxlength='3'></td>	
		</TABLE><p>		
<table width="950"><tr><td><center>
<input type="submit" id = "atualizar" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cadastrar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"/>
</tr></td><tr><td><br><br>
<div id="rodape"><center>	&copy; 2009 - Secretaria de Tecnologia da Informação </center></div>
</tr></td></table></form></BODY></HTML>