var servidores = Array();
var cd_serv = '00000';

// Objeto AJAX para comunica��o Assincrona com um servidor de aplica��es WEB
function AJAX(url,metodo,params,processa,modo) {
	this.url = url;
	this.metodo = (metodo) ? metodo : 'GET';
	this.params  = (metodo='GET') ? null : params;
	this.processaresultado = processa;
	this.Header = new Array();
	this.modo = (modo) ? modo : 'T';
	if(this.modo!='T'&&this.modo!='X') {
		this.modo = 'T';
	}
	this.conectar();
}
AJAX.prototype = {
	addHeader:	function(h,v) {
					this.Header[h] = v;
				},
	delHeader:	function(h) {
					delete(this.Header[h]);
				},
	setHeader:	function() {
					if(this.httprequest==null) { return;}
					for(h in this.Header) {
						this.httprequest.setRequestHeader(h,this.Header[h]);
					}
				},
	conectar:			function() {
							if(this.url==undefined||this.url=='') {
								return;
							}
							this.httprequest = null;
						   	if (window.XMLHttpRequest) { // Mozilla, Safari,...
					         	this.httprequest = new XMLHttpRequest();
				        	} else if (window.ActiveXObject) { // IE
					         	try {
							     	 this.httprequest = new ActiveXObject("Msxml2.XMLHTTP");
				    	     	} catch (e) {
				               		try {
		        		           	 this.httprequest = new ActiveXObject("Microsoft.XMLHTTP");
									} catch (e) {}
								}
							}
							if(this.httprequest!=null&&this.httprequest!=undefined) {
								var obj = this;
								this.httprequest.onreadystatechange = 	function() {
																			obj.processaretorno.call(obj);
																		}
								if(this.metodo==undefined||this.metodo=='') { this.metodo = 'GET';}
					        	this.httprequest.open(this.metodo,this.url, true);
								this.setHeader();
						        this.httprequest.send(this.params);
							}
						},
	processaretorno:	function() {
							if(this.httprequest.readyState==4) {
								if(this.httprequest.status==200) {
									var resp = (this.modo=='T') ?
												this.httprequest.responseText :
												this.httprequest.responseXML;
									if(this.processaresultado!=null) {
										this.processaresultado(resp);
									} else {
										document.write(resp);
									}
								} else {
									this.processaerro();
								}
							}
						},
	processaerro:		function() {
							alert(this.httprequest.status + '-' + this.httprequest.statusText + ' :-> ' + this.url);
						}
}

function validaBranco(campo){
		if (campo == "")
		{
			return false;
		} else
	{
		return true;
		}

}

function trataErro(xmldoc){
        var nos = xmldoc.getElementsByTagName('ERRO');
        var no = nos[0];
        if(no!=null){
                  var err = no.childNodes[0].firstChild.nodeValue;
                  alert(err);
                  return false;
               }
        else{
		     return true;
        }
}

var dadosfoto;

    function exibefreq(cd,a,m) {
	m=String(100+parseInt(m)).substr(1);
	var xurl='http://jatuarana.trt14.gov.br:9090/reports/rwservlet?report=rh_ponto.rdf&destype=CACHE&userid=rel_rh/rel$trt14@BDTRT14&paramform=no&server=rep_producao_101&desformat=pdf&P_COD='+cd+'&P_ANO='+a+'&P_MES='+m;
	window.open(xurl)
	}

	// Adiciona Zeros nas Datas menores que 10.
	function addZero(vNumber){
	return ((vNumber < 10) ? "0" : "") + vNumber
	}	

/* 	// Salta de Campo "qtdedias" ao preencher dois d�gitos.
	function JumpField(fields,destino) {
		if (fields.value.length == fields.maxLength) {
		document.getElementById(destino).focus(); }
	} */
	
	function JumpField2(fields) {
		if (fields.value.length == 10) {
		// document.getElementById(destino).focus();
		listaCertificado();
		exibeCertificado();
	}}
	
	// Apresenta uma mensagem de Erro
	function trataErro(xmldoc){
        var nos = xmldoc.getElementsByTagName('ERRO');
        var no = nos[0];
        if(no!=null){
            var err = no.childNodes[0].firstChild.nodeValue;
            alert(err);
            return false;
		}
        else	{
		return true;
				}
	}
	
	function soNumero(e) {
		var keynum
		var keychar
		var numcheck

		if(window.event) // IE
	{
		keynum = e.keyCode
	}
		else if(e.which) // Netscape/Firefox/Opera
	{
		keynum = e.which
	}
		keychar = String.fromCharCode(keynum)
		numcheck = /[^A-Za-z.-]/
		return numcheck.test(keychar)
	}
	
$(document).ready(function(){


	/* // Masc�ra no Campo de Preencimento do N�mero de Processo Administrativo
	jQuery(function($) { 
		$("#processo").mask("9999.9999.999.99.99-9",{placeholder:"_"} );
		$("#dtprotocolo").mask("99/99/9999",{placeholder:" "});
	});
    
	// Preenche a lista dos Modelos de Parecer
	preencheComHash('lista_pareceres','todos','pareceres','...');
		
	// Preenche as tr�s caixas de lista com o nome dos m�dicos.
	preencheComHash('lista_junta','todos','ass01','...');
	preencheComHash('lista_junta','todos','ass02','...');
	preencheComHash('lista_junta','todos','ass03','...');
	
	$('#tbfoot2').hide();
	$('#Bt_alteraAtestado').hide(); */
	
	function prepara(s) {
	    return encodeURI($(s).val());
	} 
 
   	function formatItem(row) {
		return row[1];
	}
	function formatResult(row) {
		return row[1];
	}
	
	function  highlight(value, term) {
		return value.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + term.replace(/([\^\$\(\)\[\]\{\}\*\.\+\?\|\\])/gi, "\\$1") + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<strong>$1</strong>");
	}
	
	var df = $('#foto');
	dadosfoto = df.html();
	df.html('');

	$('input#achaservidor').result(function(event, data, formatted) {
	 	 !data ? Alert("N�o encontrado!") : cd_serv = formatted;
		 
	            $('#foto').html(dadosfoto);
				img = document.getElementById('imgfoto');
				img.src='php/foto.php?q='+cd_serv;
				img.alt=cd_serv;
				// Exibe dados referente as licen�as.
	
				$.post("php/dados.php", { codigo:cd_serv },
			function(xmldoc){
				  nos = $('item',xmldoc);
				  if(nos.length>0)
				{
				   var no = nos[0];
				   $('#cargo')[0].innerHTML 	= no.childNodes[1].firstChild.nodeValue;
				   var classe = no.childNodes[2].firstChild.nodeValue;
				   if (classe == ' ') {
				      $('#tit_classe').hide();
				      $('#classe').hide();
				   } else {
				      $('#tit_classe').show();
				      $('#classe').show();				   
					  $('#classe')[0].innerHTML = classe;
				   }
				   $('#posse')[0].innerHTML 	= no.childNodes[3].firstChild.nodeValue;
				   $('#exercicio')[0].innerHTML = no.childNodes[4].firstChild.nodeValue;
				   $('#setor')[0].innerHTML 	= no.childNodes[5].firstChild.nodeValue;
				   var classe2 = no.childNodes[6].firstChild.nodeValue;
					 if (classe2 == ' ') {
				      $('#tit_funcao').hide();
				      $('#funcao').hide();
				   } else {
				      $('#tit_funcao').show();
				      $('#funcao').show();
					  $('#funcao')[0].innerHTML = classe2;
				   }				   		   
					  $('#codigo')[0].innerHTML 	= 'C�digo: '+no.childNodes[7].firstChild.nodeValue;
					  $('#ramal')[0].innerHTML 	= no.childNodes[8].firstChild.nodeValue;
				}
				    // Limpa os Dados ap�s escolher outro servidor
				  	//limpa();
			}
			, "xml");
			
	
			/* // Aciona o (N� do Processo) e as (Requisi��es) referentes ao tipo de licen�a (LTS, LTS-PF ou LG) escolhida.
			$('#tipo').change(function () {
			$.post('php/pegavalor.php',{processo:'pega_processo',chave:cd_serv+$("#tipo").val()},
				function(data){				
					if ($('#tipo').val()=='0')	 { // Se Escolher a Op��o ("..."), Ent�o o N� de Processo e Tipos de Requisi��es em Branco.
						$("#processo").val('');									
				}  else { // Sen�o, Se escolher Qualquer dos Tipo de Licen�a, Ent�o Mostre os Respecitvos N� do Processo e Requisic��es Dispon�vel.
						$('#processo').val($("valor",data).text());
				}
			}, "xml");
			})

			
			// Aciona se escolheu um assinante
			$('#ass01').change(function() {
			$('#impparecer').removeAttr("disabled"); 
			});
			
			 				
	        // Aciona quando escohe uma situa��o ou tipo de opera��o
			$('#operacao').change(function () {
				if ($("#operacao").val()=='H') { // Se foi homolgado (ou vai homolgar)
				   $("#ds_periodo").html('Per�odo Homologado');
				   $("#sit_datainicio").val($("#datainicio").val());
				   $("#sit_datafim").val($("#datafim").val());
				}

				if ($("#operacao").val()=='N') { // N�o Homologado 
				   $("#ds_periodo").html('Per�odo N�o Homologado');
				   $("#sit_datainicio").val($("#datainicio").val());
				   $("#sit_datafim").val($("#datafim").val());
				}
				

				if ($("#operacao").val()=='S') { // Se foi sobrestado
				   $("#ds_periodo").html('Per�odo Sobrestado');
				   $("#sit_datainicio").val($("#datainicio").val());
				   $("#sit_datafim").val($("#datafim").val());
				}
			})
			
			// Exibe o Total em "Dias" de Licen�as M�dicas (LTS)  no Ano Corrente, para efeito de Controle pela Junta M�dica.
			$("#tipo").change(function () {
				if ($('#tipo').val()=='1')	 {
					$.post('php/pegavalor.php',{processo:'pega_total',chave:cd_serv},  
			function(a) {
					d = $('#msg');
					d.html($("valor",a).text()); }
					, "xml"); }
					else {
					$('#msg').html(''); }
			})
			
		
			// Colocar n� de dias de licen�a com base na data inicial para apresentar automaticamente a data final do per�odo
			// Ref: Fun��o "SomarData" na Linha 300.
			$('#qtdedias').change(function calculaData()  {
				if 	 ($('#qtdedias').val() != '00')  {
					 $('#datafim').val(SomarData($('#datainicio').val(),($('#qtdedias').val())-1));
				}
			})	
			
			$('#pareceres').change(function () {
				$.post('php/pegavalor.php',{processo:'pega_parecer',chave:$("#pareceres").val()},  
					function(data){
					$('#parecer').val( $("valor",data).text() );
					}, "xml");
			})

			$('#ass02').html($('#ass01').html());
			$('#ass03').html($('#ass01').html());
		
	});

 
   // Preenche Tipos  de Licen�a: LTS, LTS-PF e Licen�a-Gestante.
   preencheComHash('lista_operacao','todos','operacao','...');
   
   // Preenche Tipos  de Base Legal (artigos de Norma, Lei,..)
   preencheComHash('lista_base_legal','todos','base_legal','...');

    // Adiciona evento de autocompletar meses do ano
		$("#achaservidor").autocomplete('php/autocomplehash.php', {
		minChars: 2,
		multiple: false,
		matchContains: true,
		matchSubset: true,
		cacheLength:10,
		formatItem: formatItem,
		formatResult: formatResult,
		highlight: 	highlight
	});
		 
}); */

	function montafocus(){
		document.getElementById("achaservidor").focus();
	}

	function preenche_body(xmldoc,tbo) {
			for(var i = tbo.rows.length; i > 0;i--)
			{
			tbo.deleteRow(i -1);
			}
         var nos = xmldoc.getElementsByTagName('item');
         if(xmldoc.hasChildNodes()&&nos.length>0){
            for(var i=0;i<nos.length;i++){
               var no = nos[i];
                 var tr = document.createElement("tr");
                 for(var ii=0;ii<3;ii++){
                   var td = document.createElement("td");
				   var sub_no2 = '';	
				   if (no.childNodes[ii].firstChild != null) {	
				      sub_no2 = no.childNodes[ii].firstChild.nodeValue;
				   }
                   var tx = document.createTextNode(sub_no2)	;
                   td.appendChild(tx);
                   tr.appendChild(td);
                  }
				  var td = document.createElement("td");
                  var ta = document.createElement("checkbox");
                  ta.id = no.childNodes[0].firstChild.nodeValue;
                  ta.onclick = function(){
                             exibeextra(this.id);
                             }
                  ta.href = "#";
                  var ti = document.createElement("img");
                  ti.border = 0;
              tbo.appendChild(tr);
              }
		}	  
	};
	 
	/* // Fun��o Para Limpar os Dados do Formul�rio
	function limpa() {
		$('#achaservidor').html('');
	 	$('#tipo').val('0');
		$("#processo").val('');
		$('#protocolo').val('');
		$('#dtprotocolo').val('');
		$('#operacao').val('0');
		$('#base_legal').val('0');
		$('#datainicio').val('');
		$('#datafim').val('');
		$('#qtdedias').val('');
		$("#sit_datainicio").val('');
		$("#sit_datafim").val('');
		$('#pareceres').val('0');
		$("#parecer").val('');
		$('#cid').val('');
		$('#msg').html('');
		$('#msg2').html('');
		$('#lista2_div').html('');
		preencheComHash('lista_junta','todos','ass01','...');
		preencheComHash('lista_junta','todos','ass02','...');
		preencheComHash('lista_junta','todos','ass03','...');
	};
	
	// Limpa os campos de preenchimento do Atestado M�dico
	function limpaAtestado()		
	{ 	$('#datainicio').val('');
		$('#datafim').val('');
		$('#qtdedias').val('');
		$('#operacao').val('0');
		$("#sit_datainicio").val('');
		$("#sit_datafim").val('');
		$('#base_legal').val('0');
		$('#cid').val('');
	}; */
	
	// Ao Lan�ar um Atestado M�dico, as op��es de Lan�amentos de Atestado (combolist, Input, button) desaparecem p/ ficar mais f�cil a Visualiza��o do Parecer.
		function someAtestado()		
	{ 	$('#table_certificado01').hide();
		$('#table_certificado02').hide();
		$('#tbfoot2').show();
	};
	
	// Faz aparecer as op��es de lan�amento de um novo atestado m�dico, op��es essas que desapareceram por motivo de est�tica, conforme fun��o someAtestado().
		function apareceAtestado()		
	{ 	$('#tbfoot2').hide();
		$('#table_certificado01').show();
		$('#table_certificado02').show();
		$('#datainicio').focus();		
	};
	

	
	/* // Soma o n� de Dias  com Base na Data Inicial e Mostra a Data Final.
	function SomarData(DataInicial,QtdeDias) {
	  	var DataFinal;
		var d = new Date();

		d.setTime(Date.parse(DataInicial.split("/").reverse().join("/"))+(86400000*(QtdeDias)))
      		
		DataFinal = (addZero(d.getDate()).toString())+"/"+(addZero(d.getMonth()+1)).toString()+"/"+(addZero(d.getFullYear())).toString();
		return DataFinal;
	};
 
	// Verifica se j� Existe algum Tipo de Licen�a/Afastamento no Per�odo Solicitado em Nova Requisi��o
	function ExisteLicenca() {
		$.post('php/pegavalor.php',{processo:'existe_licenca',chave:cd_serv+$("#datainicio").val()+$("#datafim").val()},  
			function(r){
			d = $("#msg2");		
			d.html( $("valor",r).text() );
			}, "xml");
	}
 */
	// Inclus�o de Um ou V�rios Atestados M�dicos
	function InsereCertificado() {
			$.post("php/insereCertificado.php",
			{cod_curso:$('#cod_curso').val(), cpf:$("#cpf").val(), nome_curso:$("#nome_curso").val(), nome_agraciado:$("#nome_agraciado").val(), nome_ins_conv:$("#nome_ins_conv").val(), setor_ins_conv:$("#setor_ins_conv").val(), nome_al_conv:$("#nome_al_conv").val(), setor_al_conv:$("#setor_al_conv").val(), dt_inicio:$("#dt_inicio").val(), dt_fim:$("#dt_fim").val(), carga:$("#carga").val(), localidade:$("#localidade").val(), dt_exp:$("#dt_exp").val()},
		function(a)
		{	if ( !trataErro(a) )	
			{ return false;	}
			alert( $("msg4",a).text() );
			listaAtestados();  
			limpaAtestado();
			someAtestado();
			$('#pareceres').focus;
		}	,"xml") ;		
	}
 
	// Inclus�o de Um ou V�rios Atestados M�dicos
	function listaCertificado() {		
			// d = $('#msg5');
			// d.html('<img border='0' src='imagens/ajax2.gif'> Processando.... ');
				$.post("php/ListaCertificado.php",
				{cod_curso:$('#cod_curso').val(), cpf:$("#cpf").val(), nome_curso:$("#nome_curso").val(), nome_agraciado:$("#nome_agraciado").val(), nome_ins_conv:$("#nome_ins_conv").val(), setor_ins_conv:$("#setor_ins_conv").val(), nome_al_conv:$("#nome_al_conv").val(), setor_al_conv:$("#setor_al_conv").val(), dt_inicio:$("#dt_inicio").val(), dt_fim:$("#dt_fim").val(), carga:$("#carga").val(), localidade:$("#localidade").val(), dt_exp:$("#dt_exp").val()},
		function(k)
		{	if ( !trataErro(k) )	
					{ return false;	}
				exibeResultado(k);				
		}	,"xml") ;
	}
	
	function exibeResultado(xmldoc) {
         var titulo = new Array('Alterar',
								'Motivo',
                                'Data In�cio',
                                'Data Fim',
                                'Situa��o',
                                'Exclus�o');
         var d = document.getElementById("lista2_div");
         d.innerHTML = 'Carregando Lista... ';
		 var nos = xmldoc.getElementsByTagName('item');
         var tab = document.createElement("table");
         tab.className = 'tab_lista';
         var tbo = document.createElement("tbody");
         tab.appendChild(tbo);
        // cabe�alho da tabela
         var tr = document.createElement("tr");
         for(t in titulo){
               var th = document.createElement("th");
              th.className = 'th_lista';
               var tx = document.createTextNode(titulo[t]);
               th.appendChild(tx);
               tr.appendChild(th);
               }
         tbo.appendChild(tr);
         if(xmldoc.hasChildNodes()&&nos.length>0){
            for(var i=0;i<nos.length;i++){
               var no = nos[i];
               
               var tr = document.createElement("tr");
			   
			    var td = document.createElement("td");
                  td.className = 'td_listaC';
                  var ta = document.createElement("a");
                  ta.id = no.childNodes[0].firstChild.nodeValue;				  				  				  				  			  
                  ta.onclick = function(){
                             exibeAtestado(this.id);
                             }
                  ta.href = "#";
                  var ti = document.createElement("img");
                  ti.border = 0;
                  ti.src = "imagens/edit.png";
                  ti.title = "Clique para exibir os detalhes.";
                  ta.appendChild(ti);
                  
                  td.appendChild(ta);
                  tr.appendChild(td);   
              
                 for(var ii=1;ii<no.childNodes.length;ii++){
                   var td = document.createElement("td");
                   if (ii==1){
                      td.className = 'td_lista'}
                   else{
                      td.className = 'td_listaC'};

                   var tx = document.createTextNode(no.childNodes[ii].firstChild.nodeValue);
                   td.appendChild(tx);
                   tr.appendChild(td);
                   }
                   
                 var td = document.createElement("td");
                  td.className = 'td_listaC';
                  var ta = document.createElement("a");
                  ta.id = no.childNodes[0].firstChild.nodeValue;
                  ta.onclick = function(){
                             excluiAtestado(this.id);
                             }
                  ta.href = "#";
                  var ti = document.createElement("img");
                  ti.border = 0;
                 ti.src = "imagens/trashcan.png";
                  ti.title = "Desativar .....";
                   ta.appendChild(ti);
                  
                  td.appendChild(ta);
                  tr.appendChild(td);      
 
			                    
              tbo.appendChild(tr);
              }
            d.innerHTML = '';
		 	d.appendChild(tab);
			someAtestado();
        }		 
		else
			{
				d.innerHTML = 'N�o existe nenhum certificado cadastrado!';
			};
		d.style.display = 'inline';
	}

	function excluiAtestado(vid) {

		var a = new AJAX();
		a.url = "php/excluiCertificado.php";
		a.metodo = 'POST';
		a.modo = 'X';
		var op;

		if (confirm("Deseja excluir este registro de certificado?")) {

		a.params = 'codigo='+encodeURI(vid);
		a.addHeader("Content-type", "application/x-www-form-urlencoded");
		var d = document.getElementById("lista2_div");
		d.innerHTML = "<img border='0' src='imagens/ajax2.gif'> Processando.... ";
	
				a.processaresultado = function(r) {
	              var d = document.getElementById("lista2_div");
	              d.innerHTML = '';
	              if (!trataErro(r)){
	                  return false;
	              }
	   				var nos = r.getElementsByTagName('item');
	                var no = nos[0];
	                alert(no.childNodes[0].firstChild.nodeValue);
	                listaAtestados();
					someAtestado();
				}
			a.conectar();
		}	
	}

	/* // Exibe o texto de Parecer e as Assinaturas dos M�dicos registradas no Banco de Dados
	function exibeParecer() {
		$.post('php/pegaparecer.php',{processo:'exibe_parecer',chave:cd_serv+$("#tipo").val()+$("#protocolo").val()+$("#dtprotocolo").val()},
		function(data)
		{ 
			{	$('#parecer').val($("txtparecer",data).text());
				$('#ass01').val($("assinatura01",data).text());
				$('#ass02').val($("assinatura02",data).text());
				$('#ass03').val($("assinatura03",data).text());
			}
		}
		,"xml") ; 
	} */

	// Grava Parecer no Banco de Dados e Coloca em Formato de Impress�o
	function GravaParecer()
	{
			$.post("php/gravaCertificado.php",
			{cod_curso:$('#cod_curso').val(), cpf:$("#cpf").val(), nome_curso:$("#nome_curso").val(), nome_agraciado:$("#nome_agraciado").val(), nome_ins_conv:$("#nome_ins_conv").val(), setor_ins_conv:$("#setor_ins_conv").val(), nome_al_conv:$("#nome_al_conv").val(), setor_al_conv:$("#setor_al_conv").val(), dt_inicio:$("#dt_inicio").val(), dt_fim:$("#dt_fim").val(), carga:$("#carga").val(), localidade:$("#localidade").val(), dt_exp:$("#dt_exp").val()},
		function(a)
		{	if ( !trataErro(a) )	
			{ return false;	}
			alert( $("msg3",a).text() );
			//var xurl='http://jatuarana.trt14.gov.br:9090/reports/rwservlet?report=parecer_medico.rdf&destype=CACHE&userid=juntamed/juntamed$trt14@BDTRT14&paramform=no&server=rep_producao_101&desformat=PDF&P_CD_SERV='+cd_serv+"&P_MOT_AFAST="+$("#tipo").val()+"&P_NM_PROTOCOLO="+$("#protocolo").val()+"&P_DT_PROTOCOLO="+$("#dtprotocolo").val();
			var xurl='http://localhost:8888/reports/rwservlet?report=parecer_medico2.rdf&destype=CACHE&userid=rh/rhdesenv@desenv&paramform=no&server=rep_ita027939&desformat=PDF&P_CD_SERV='+cd_serv+"&P_MOT_AFAST="+$("#tipo").val()+"&P_NM_PROTOCOLO="+$("#protocolo").val()+"&P_DT_PROTOCOLO="+$("#dtprotocolo").val();
			window.open(xurl);
			limpa();
			$('#foto').html('');
		}	,"xml") ;		
	}
	
	// Reimpress�o do �ltimo Certificado (em caso de falha da impress�o ou na gera��o do Pdf.)
	function ReimpParecer()   
	{	// Se n�o preencer os 5 campos abaixos requeridos p/ gerar a reimpress�o de Certificado: aparece uma mensagem de alerta
		if ($("#cod_curso").val()=='0') 
			{ 	alert('Falta Preencher o C�DIGO DO CURSO!');
				return false; }   
		else if ($("#dt_inicio").val()=='') 
			{   alert('Falta Preencher a DATA DE IN�CIO DO CURSO!');
				return false; }
		else if ($("#dt_fim").val()=='') 
			{   alert('Falta Preencher a DATA DE T�RMINO DO CURSO!');
				return false; }
		else if ($("#carga").val()=='') 
			{   alert('Falta Preencher a CARGA HOR�RIA DO CURSO!');
				return false; }
		else if ($("#dt_exp").val()=='') 
			{   alert('Falta Preencher a a DATA DE EXPEDI��O DO CERTIFICADO DE CURSO!');
				return false; }
	

	// 
	function exibeCertificado(id){
			apareceCertificado();
			$('#Bt_alteraCertificado').show();
			$('#Bt_insereCertificado').hide();
			$.post('php/exibeCertificado.php',{id:id},
		function(data)	{
				$('#identificacao').val($("id_select:first",data).text());		
				$('#datainicio').val($("datainicio:first",data).text());
				$('#datafim').val($("datafim:first",data).text());
				$('#operacao').val($("operacao:first",data).text());
				$('#sit_datainicio').val($("sit_datainicio:first",data).text());
				$('#sit_datafim').val($("sit_datafim:first",data).text());
				$('#base_legal').val($("base_legal:first",data).text());

				a=$("cid",data);
				texto = '';
				
				for (var i = 0; i < a.length; i++) {
					   var obj = a[i];						
				       if (typeof obj.textContent != 'undefined') {
						texto =texto+obj.textContent+'\n';
					   } else {
						texto =texto+obj.text+'\n';
					   } 	
				 }
				$('#cid').val(texto);
		
		}
		,"xml") ; 
	}	

	
	// Altera o atestado m�dico.
	function alteraAtestado(){
			$.post('php/alteraCertificado.php',
			{cod_curso:$('#cod_curso').val(), cpf:$("#cpf").val(), nome_curso:$("#nome_curso").val(), nome_agraciado:$("#nome_agraciado").val(), nome_ins_conv:$("#nome_ins_conv").val(), setor_ins_conv:$("#setor_ins_conv").val(), nome_al_conv:$("#nome_al_conv").val(), setor_al_conv:$("#setor_al_conv").val(), dt_inicio:$("#dt_inicio").val(), dt_fim:$("#dt_fim").val(), carga:$("#carga").val(), localidade:$("#localidade").val(), dt_exp:$("#dt_exp").val()},
		function(f)
		{   if ( !trataErro(f) )	
			{ return false;	}
			alert( $("msg",f).text() );
			listaCertificado();  
			//someAtestado();
			//limpaAtestado();			
			$('#pareceres').focus;
		}
		,"xml") ; 
	    }