<?php
include 'conecta.php';
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
	
<BODY onload="listaCertificado()">
          <onload="montafocus();">

<form method="POST" action="cad_certificado.php">
<table width="950"><tr><td><center>
<input type="submit" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Voltar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" name="Voltar">
</tr></td></table>
</form>

  <table>
		<caption> Expedição de Certificado - Participação de Aluno(a) em Curso Presencial:</caption>
	</table>

<iframe src="cert_lista_aluno_trt.php" marginwidth="1" marginheight="1" name="certificado_lista" width="980" height="200"></iframe>

<form action="cert_aluno_trt_add.php" method="post">
	<table>
	<td width="6%"> Nome de Aluno(a) do TRT da 14a. Região:<br>
	
 <?php
$sql1 = "SELECT * FROM curso ORDER BY curs_nome ASC";

$resultado1 = mysql_query($sql1) 
or die ("Não foi possível realizar a consulta");
if (@mysql_num_rows($resultado1) == 0)
   die('Nenhum registro encontrado');

$sql2 = "SELECT * FROM aluno WHERE alun_codigo > '0' ORDER BY alun_id ASC LIMIT 15";

$resultado2 = mysql_query($sql2) 
or die ("Não foi possível realizar a consulta");
if (@mysql_num_rows($resultado2) == 0)
   die('Nenhum registro encontrado');
?>
<select name="cert_aluno_nome" id="cert_aluno_nome">
    <option value='0' selected>Selecione o aluno convidado</option>
<?php 

while ($linha2=mysql_fetch_array($resultado2))
{
   echo "<option value='{$linha2['alun_nome']}'>{$linha2['alun_nome']}</option>";   
}

?>
</select>
</table>
<table>
			<td width="6%"> Nome do Curso:<br>
<select name="cert_curso_nome" id="cert_curso_nome">
    <option value='0' selected></option>
<?php 

while ($linha1=mysql_fetch_array($resultado1))
{
   echo "<option value='{$linha1['curs_nome']}'>{$linha1['curs_nome']}</option>";   
}

?>
</select>
	<td width="6%"> Carga horária do curso:<br>
			<select name="cert_carga" id="cert_carga">
				<option value=''></option>
				<option value='1'> 1h</option>
				<option value='2'> 2hs</option>
				<option value='3'>  4hs</option>
				<option value='5'>  5hs</option>
				<option value='6'> 6hs</option>
				<option value='7'> 7hs</option>
				<option value='8'> 8hs</option>
				<option value='9'> 9hs</option>
				<option value='10'> 10hs</option>
				<option value='15'> 15hs</option>
				<option value='20'> 20hs</option>
				<option value='25'> 25hs</option>
				<option value='30'> 30hs</option>
				<option value='35'> 35hs</option>
				<option value='40'> 40hs</option>
				<option value='45'> 45hs</option>
				<option value='50'> 50hs</option>
				<option value='55'> 55hs</option>
				<option value='60'> 60hs</option>
				<option value='65'> 65hs</option>
				<option value='70'> 70hs</option>
				<option value='75'> 75hs</option>
				<option value='80'> 80hs</option>
				<option value='85'> 85hs</option>
				<option value='90'> 90hs</option>
				<option value='95'> 95hs</option>
				<option value='100'> 100hs</option>
				<option value='110'> 110hs</option>
				<option value='120'> 120hs</option>
				<option value='130'> 130hs</option>
				<option value='140'> 140hs</option>
				<option value='150'> 150hs</option>
				<option value='160'> 160hs</option>
				<option value='170'> 170hs</option>
				<option value='180'> 180hs</option>
				<option value='190'> 190hs</option>
				<option value='200'> 200hs</option>
				<option value='300'> 300hs</option>
				<option value='310'> 310hs</option>
				<option value='320'> 320hs</option>
				<option value='330'> 330hs</option>
				<option value='340'> 340hs</option>
				<option value='350'> 350hs</option>
				<option value='360'> 360hs</option>
					       			
		</TABLE><p>		

        <TABLE>		
              <td width="6%"> Formação Profissional:<br>
			  <select name="cert_form_prof" id="cert_form_prof">
				<option value='0'></option>
				<option value='Magistrado(a)'> Magistrado(a)</option>
				<option value='Servidor(a)'> Servidor(a)</option>
				<option value='Outros'>  Outros</option>
				
			  <td width="6%"> Formação Acadêmica:<br>
			  <select name="cert_form_acad" id="cert_form_acad">
				<option value='0'></option>
				<option value='Pós-Doutorado'> Pós-Doutorado</option>
				<option value='Doutorado'> Doutorado</option>
				<option value='Mestrado'> Mestrado</option>
				<option value='Pós-Graduação'>  Pós-Graduação</option>
				<option value='Graduação'>  Graduação</option>
				<option value='Ensino Técnico'>  Ensino Técnico</option>
				</TD>
		</TABLE>
		<br>
<table border="0" cellpadding="0" cellspacing="0" width="760">
  <tr>
    <td width="200" align="center">&nbsp;</td>
    <td width="180" colspan="3" align="center">Data Início</td>
    <td width="200" align="center">&nbsp;</td>
    <td width="180" colspan="3" align="center">Data Término</td>
  </tr>
  <tr>
    <td width="200">&nbsp;</td>
    <td width="40">
    	<select name="cert_dt_ini_dia" id="cert_dt_ini_dia">
			<option value='0'>Dia</option>
			<option value='01'>01</option>
			<option value='02'>02</option>
			<option value='03'>03</option>
			<option value='04'>04</option>
			<option value='05'>05</option>
			<option value='06'>06</option>
			<option value='07'>07</option>
			<option value='08'>08</option>
			<option value='09'>09</option>
			<option value='10'>10</option>
			<option value='11'>11</option>
			<option value='12'>12</option>
			<option value='13'>13</option>
			<option value='14'>14</option>
			<option value='15'>15</option>
			<option value='16'>16</option>
			<option value='17'>17</option>
			<option value='18'>18</option>
			<option value='19'>19</option>
			<option value='20'>20</option>
			<option value='21'>21</option>
			<option value='22'>22</option>
			<option value='23'>23</option>
			<option value='24'>24</option>
			<option value='25'>25</option>
			<option value='26'>26</option>
			<option value='27'>27</option>
			<option value='28'>28</option>
			<option value='29'>29</option>
			<option value='30'>30</option>
			<option value='31'>31</option>
    </td>
    <td width="90">
        <select name="cert_dt_ini_mes" id="cert_dt_ini_mes">
			<option value='0'>Mês</option>
			<option value='01'>Janeiro</option>
			<option value='02'>Fevereiro</option>
			<option value='03'>Março</option>
			<option value='04'>Abril</option>
			<option value='05'>Maio</option>
			<option value='06'>Junho</option>
			<option value='07'>Julho</option>
			<option value='08'>Agosto</option>
			<option value='09'>Setembro</option>
			<option value='10'>Outubro</option>
			<option value='11'>Novembro</option>
			<option value='12'>Dezembro</option>
        </select></td>
    <td width="50">
    	<select name="cert_dt_ini_ano" id="cert_dt_ini_ano">
			<option value='0'>Ano</option>
			<option value='2009'>2009</option>
			<option value='2010'>2010</option>
			<option value='2011'>2011</option>
			<option value='2012'>2012</option>
			<option value='2013'>2013</option>
			<option value='2014'>2014</option>
			<option value='2015'>2015</option>
    </td>
    <td width="200">&nbsp;</td>
    <td width="40">
        <select name="cert_dt_fim_dia" id="cert_dt_fim_dia">
			<option value='0'>Dia</option>
			<option value='01'>01</option>
			<option value='02'>02</option>
			<option value='03'>03</option>
			<option value='04'>04</option>
			<option value='05'>05</option>
			<option value='06'>06</option>
			<option value='07'>07</option>
			<option value='08'>08</option>
			<option value='09'>09</option>
			<option value='10'>10</option>
			<option value='11'>11</option>
			<option value='12'>12</option>
			<option value='13'>13</option>
			<option value='14'>14</option>
			<option value='15'>15</option>
			<option value='16'>16</option>
			<option value='17'>17</option>
			<option value='18'>18</option>
			<option value='19'>19</option>
			<option value='20'>20</option>
			<option value='21'>21</option>
			<option value='22'>22</option>
			<option value='23'>23</option>
			<option value='24'>24</option>
			<option value='25'>25</option>
			<option value='26'>26</option>
			<option value='27'>27</option>
			<option value='28'>28</option>
			<option value='29'>29</option>
			<option value='30'>30</option>
			<option value='31'>31</option>
    </td>
    <td width="90">
    <select name="cert_dt_fim_mes" id="cert_dt_fim_mes">
			<option value='0'>Mês</option>
			<option value='01'>Janeiro</option>
			<option value='02'>Fevereiro</option>
			<option value='03'>Março</option>
			<option value='04'>Abril</option>
			<option value='05'>Maio</option>
			<option value='06'>Junho</option>
			<option value='07'>Julho</option>
			<option value='08'>Agosto</option>
			<option value='09'>Setembro</option>
			<option value='10'>Outubro</option>
			<option value='11'>Novembro</option>
			<option value='12'>Dezembro</option>    
    </td>
    <td width="50">
    	<select name="cert_dt_fim_ano" id="cert_dt_fim_ano">
			<option value='0'>Ano</option>
			<option value='2009'>2009</option>
			<option value='2010'>2010</option>
			<option value='2011'>2011</option>
			<option value='2012'>2012</option>
			<option value='2013'>2013</option>
			<option value='2014'>2014</option>
			<option value='2015'>2015</option>    
    </td>
  </tr>
</table>
		<br>
		<TABLE>						
		<td width="6%"> Localidade:<br>
			<select name="cert_local" id="cert_local">
				<option value='0'></option>
				<option value='Porto Velho/RO'>Porto Velho/RO</option>
				<option value='Rio Branco/AC'>Rio Branco/AC</option>
				<option value='Ariquemes/RO'>Ariquemes/RO</option>
				<option value='Buritis/RO'>Buritis/RO</option>
				<option value='Cacoal/RO'>Cacoal/RO</option>
				<option value='Colorado do Oeste/RO'>Colorado do Oeste/RO</option>
				<option value='Costa Marques/RO'>Costa Marques/RO</option>			
				<option value='Guajará-Mirim/RO'>Guajará-Mirim/RO</option>
				<option value='Jaru/RO'>Jaru/RO</option>
				<option value='Ji-Paraná/RO'>Ji-Paraná/RO</option>			
				<option value='Machadinho do Oeste/RO'>Machadinho do Oeste/RO</option>
				<option value='Ouro Preto do Oeste/RO'>Ouro Preto do Oeste/RO</option>
				<option value='Pimenta Bueno/RO'>Pimenta Bueno/RO</option>
				<option value='Rolim de Moura/RO'>Rolim de Moura/RO</option>
				<option value='São Miguel do Guaporé/RO'>São Miguel do Guaporé/RO</option>
				<option value='Vilhena/RO'>Vilhena/RO</option>
				<option value='Epitaciolândia/AC'>Epitaciolândia/AC</option>
				<option value='Cruzeiro do Sul/AC'>Cruzeiro do Sul/AC</option>
				<option value='Feijó/AC'>Feijó/AC</option>
				<option value='Plácido de Castro/AC'>Plácido de Castro/AC</option>
				<option value='Sena Madureira/AC'>Sena Madureira/AC</option>
				</select>
			</p>
			
			<td width="6%"> Assinatura:<br>
			<select name="cert_ass" id="cert_ass">
				<option value='0'></option>
				<option value='ass1'> Assinatura do Diretor e do Vice-Diretor</option>
				<option value='ass2'> Assinatura somente do Diretor</option>
				<option value='ass3'> Assinatura somente do Vice-Diretor</option>
</TABLE>
<table width="950"><tr><td><center>
<input type="submit" id = "atualizar" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cadastrar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"/>
</tr></td><tr><td><br><br>
<div id="rodape"><center>	&copy; 2009 - Secretaria de Tecnologia da Informação </center></div>
</tr></td></table></form></BODY></HTML>