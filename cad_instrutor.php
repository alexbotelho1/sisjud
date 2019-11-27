<?php
include 'conecta.php';
?>
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
		<caption> Cadastro de Instrutor:</caption>
	</table>

<form action="instrutor_add.php" method="post">

	<table>
	
	<td width="6%"> Nome do Instrutor(ra) do TRT da 14a. Região:<br>
		<input class="campo" type="text" id="inst_nome" name="inst_nome" size="80"/>
		<td width="6%"> Código:<br>
		<INPUT type="text" name="inst_codigo" id="inst_codigo" size="10" maxlength='6'></td>	
	</table>
	<table>						
			<td width="6%"> Nome do Curso:<br>
 <?php
$sql1 = "SELECT * FROM curso ORDER BY curs_nome ASC";

$resultado1 = mysql_query($sql1) 
or die ("Não foi possível realizar a consulta");
if (@mysql_num_rows($resultado1) == 0)
   die('Nenhum registro encontrado');
?>

<select name="inst_curso_id" id="inst_curso_id">
    <option value='0' selected></option>
<?php 

while ($linha1=mysql_fetch_array($resultado1))
{
   echo "<option value='{$linha1['curs_nome']}'>{$linha1['curs_nome']}</option>";   
}

?>
</select>
		</TABLE><p>		
		
		<TABLE>
		
<right>(*) Preencher se o(a) INstrutor <b>NÃO</b> for do TRT da 14a. Região</right><BR><P>

        <td width="2%"> CPF: (*)<br> 
		<input class="campo" type="text"  id="inst_conv_cpf" name="inst_conv_cpf" size="13" onKeyPress="return soNumero(event);" maxlength='11'/></td>
			
		<td width="6%"> Nome do Instrutor(ra) Convidado(a): (*)<br>
		<input class="campo" type="text" border="0" cellspacing="0" id="inst_conv_nome" name="inst_conv_nome" size="45" border="#FFFFFF" bgcolor="#FFFF00"/></td>	
		
		<td width="6%"> Local de Trabalho do Instrutor(ra) Convidado(a): (*)<br>
		<input class="campo" type="text" border="0" cellspacing="0" id="inst_conv_local" name="inst_conv_local" size="50" border="#FFFFFF" bgcolor="#FFFF00"/></td>

        </TD>
		</TABLE><P>	

        <TABLE>		
              <td width="6%"> Formação Profissional:<br>
			  <select name="inst_form_prof" id="inst_form_prof">
				<option value=''></option>
				<option value='Magistrado(a)'> Magistrado(a)</option>
				<option value='Servidor(a)'> Servidor(a)</option>
				<option value='Outros'>  Outros</option>
				
			  <td width="6%"> Formação Acadêmica:<br>
			  <select name="inst_form_acad" id="inst_form_acad">
				<option value=''></option>
				<option value='Pós-Doutorado'> Pós-Doutorado</option>
				<option value='Doutorado'> Doutorado</option>
				<option value='Mestrado'> Mestrado</option>
				<option value='Pós-Graduação'>  Pós-Graduação</option>
				<option value='Graduação'>  Graduação</option>
				<option value='Ensino Técnico'>  Ensino Técnico</option>
				</TD>
		</TABLE>       
	
<!-- Mostra a foto e os dados do agraciado -->
	
<DIV id="foto">

<TABLE>
	 <TR>
		<TD>
			<br><img id="imgfoto" class='foto'/><BR> &nbsp; 
			<b id='codigo'> Código:</b><BR>
		</TD>
		<TD>
			<br><P id='dados' >
					<b>Cargo</b><BR>
					<SPAN id='cargo'></SPAN><BR>
					<SPAN>
				<TABLE>
					<TR><BR>
						<TD>
							<b id='tit_classe'>Classe / Padrão</b><BR>
							<SPAN id='classe'></SPAN><BR>
						</TD>
					<TD >
						<b>Posse</b><BR>
						<SPAN id='posse'></SPAN>
					</TD>
						<TD>
							<b>Exercício</b><BR>
							<SPAN id='exercicio'></SPAN><BR><BR>
						</TD>
					</TR>
				</TABLE>			
				</SPAN>	
				<SPAN>	
				<table>
					<TR>						
							<B>Setor</B><BR>
							<SPAN id='setor'></SPAN><BR><BR>
						
							<TD>
								<b id='tit_funcao'>Cargo/Função</b><BR>
								<SPAN id='funcao'></SPAN><BR>
							</TD>
							<TD>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Ramal</b><BR>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <SPAN id='ramal'></SPAN><BR>
							</TD>
						
					</TR>
					</table>
</SPAN>	
			</P>
		</TD>
	 </TR>	   
</TABLE>
</DIV>
<table width="950"><tr><td><center>
<input type="submit" id = "atualizar" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cadastrar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"/>
</tr></td><tr><td><br><br>
<div id="rodape"><center>	&copy; 2009 - Secretaria de Tecnologia da Informação </center></div>
</tr></td></table></form></BODY></HTML>