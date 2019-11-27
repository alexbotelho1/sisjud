<?php
include 'conecta.php';

$sql = "SELECT * FROM certificado WHERE cert_aluno_nome = 'Alex Botelho de Almeida' ORDER BY cert_curso_nome ASC";
$resultado = mysql_query($sql)
or die ("Não foi possível realizar a consulta.");

$linha=mysql_fetch_array($resultado);

?>
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
	
<BODY>

<form action="index.html">
<table width="950"><tr><td><center>
<input type="submit" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Voltar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" name="Voltar">
</tr></td></table>
</form>

  <table>
		<caption> Expedição de Certificado:</caption>
	</table>
	<table>
	<tr>
	<?php 
	if ($linha['cert_codigo'] = "0")
	{
	echo "<td width='6%'> Nome de Aluno(a):<br><input size='80' type='text' value='{$linha['cert_aluno_nome']}'></td>";
	}else{ 
	echo "<td width='6%'> Nome de Aluno(a):<br><input size='80' type='text' value='{$linha['cert_conv_nome']}'></td>";
	}
	?>
  <td width="6%"> Carga:<br><input size="5" type="text" value="<?php echo $linha['cert_carga'] ?>"></td>
  </tr>
  <tr>
	<td width="6%"> Nome de Aluno(a):<br><input size="25" type="text" value="<?php echo $linha['cert_form_prof'] ?>"></td>
  <td width="6%"> Carga:<br><input size="25" type="text" value="<?php echo $linha['cert_form_acad'] ?>"></td>
  </tr>
  </TABLE>
      <table>
		<caption> Lista de Certificados Cadastrados e Expedidos:</caption>	
	</table>

 <table border="1">

<tr>
<th>Nome do Curso:</th>
<th>Carga:</th>
<th>Opções</th>
</tr>

<?php

/*
 * mostra os dados na tela
 */
while ($linha=mysql_fetch_array($resultado))
{
   echo "<tr>";
   echo "<td width='300'>{$linha['cert_curso_nome']}</td>";
   echo "<td width='50' align='center'>{$linha['cert_carga']}</td>";
   echo "<td>| <a target='_blank' href='pub_imprimir.php?cert_id={$linha['cert_id']}'>Imprimir</a> |</td>";
   echo "</tr>";
}

echo "</table>";

?>
</BODY></HTML>