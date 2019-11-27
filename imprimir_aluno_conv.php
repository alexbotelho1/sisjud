 <?php

include 'conecta.php';

$sql = "SELECT * FROM certificado WHERE cert_id = ".$_GET['cert_id'];
$resultado = mysql_query($sql)
or die ("Não foi possível realizar a consulta.");

?>
  <table border="0" cellpadding="0" cellspacing="0" width="804" height="557">
    <tr>
      <td width="804" height="191" colspan="3"><img src="imagens/certificado_head.jpg" border="0"></td>
    </tr>
    <tr>
      <td width="100" height="321" rowspan="4"><img src="imagens/certificado_main_right.jpg" border="0"></td>
      <td width="604" height="60" align="center">
        <p align="center" style="margin-top: 0; margin-bottom: 0"><font face="Arial" style="font-size: 16pt">O Diretor da Escola Judicial do Tribnal Regional do Trabalho</font></p>
        <p align="center" style="margin-top: 0; margin-bottom: 0"><font face="Arial" style="font-size: 16pt">da 14ª Região confere o presente Certificado a</font></p>
      </td>
      <td width="100" height="321" rowspan="4"><img src="imagens/certificado_main_left.jpg" border="0"></td>
    </tr>
    <tr>
    <?php
    while ($linha=mysql_fetch_array($resultado))
    {    
    echo "<td width='704' height='30' align='center'><font face='Times New Roman' style='font-size: 17pt' color='#007FC8'>{$linha['cert_conv_nome']},</font></td>";
    echo "</tr>";
    echo "<tr>";    
    echo "<td width='704' height='141' valign='top' align='center'><font face='Times New Roman' style='font-size: 16pt'>por sua participação no(a) {$linha['cert_curso_nome']}, realizado no período de {$linha['cert_dt_ini_dia']} de {$linha['cert_dt_ini_mes']} de {$linha['cert_dt_ini_ano']} a {$linha['cert_dt_fim_dia']} de {$linha['cert_dt_fim_mes']} de {$linha['cert_dt_fim_ano']}, com carga horária de {$linha['cert_carga']} hora(as).</font></td>";
    }
    ?>
    </tr>
    <tr>
      <td width="704" height="90" align="center">assinaturas</td>
    </tr>
    <tr>
      <td width="804" height="45" colspan="3"><img src="imagens/certificado_foot.jpg" border="0"></td>
    </tr>
  </table>