var servidores = Array();
var cd_serv = '00000';

// Objeto AJAX para comunicação Assincrona com um servidor de aplicações WEB
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

	/* // Salta de Campo "qtdedias" ao preencher dois dígitos.
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
	
$(document).ready(function()
{
	
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

	 $('input#nome_agraciado').result(function(event, data, formatted) {
	 	 !data ? Alert("Não encontrado!") : cd_serv = formatted;    
		 
	            $('#foto').html(dadosfoto);
				img = document.getElementById('imgfoto');
				img.src='php/foto.php?q='+cd_serv;
				img.alt=cd_serv;
				
				// Exibe dados referente aos Certificados
	
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
					  $('#codigo')[0].innerHTML 	= 'Código: '+no.childNodes[7].firstChild.nodeValue;
					  $('#ramal')[0].innerHTML 	= no.childNodes[8].firstChild.nodeValue;
				}
				    // Limpa os Dados após escolher outro servidor
				  	//limpa();
			}
			, "xml");
			

		
	});

 

    // Adiciona evento de autocompletar meses do ano
		$("#nome_agraciado").autocomplete('php/autocomplehash.php', {
		minChars: 2,
		multiple: false,
		matchContains: true,
		matchSubset: true,
		cacheLength:10,
		formatItem: formatItem,
		formatResult: formatResult,
		highlight: 	highlight
	});  
		 
});

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
	 
	
	/* // Limpa os campos de preenchimento do Atestado Médico
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
	
	// Ao Lançar um Certificado, as opções de Lançamentos de Certificado (combolist, Input, button) desaparecem p/ ficar mais fácil a Visualização do Parecer.
		function someAtestado()		
	{ 	$('#table_certificado01').hide();
		$('#table_certificado02').hide();
		$('#tbfoot2').show();
	};
	
	// Faz aparecer as opções de lançamento de um novo Certificado, opções essas que desapareceram por motivo de estética, conforme função someCertificado().
		function exibeCertificado()		
	{ 	$('#tbfoot2').hide();
		$('#table_certificado01').show();
		$('#table_certificado02').show();
		$('#Bt_InsereCertificado').show();
		$('#Bt_alteraCertificado').hide();
		$('#datainicio').focus();		
	};
	

	
	/* // Soma o nº de Dias  com Base na Data Inicial e Mostra a Data Final.
	function SomarData(DataInicial,QtdeDias) {
	  	var DataFinal;
		var d = new Date();

		d.setTime(Date.parse(DataInicial.split("/").reverse().join("/"))+(86400000*(QtdeDias)))
      		
		DataFinal = (addZero(d.getDate()).toString())+"/"+(addZero(d.getMonth()+1)).toString()+"/"+(addZero(d.getFullYear())).toString();
		return DataFinal;
	};
   */

	// Inclusão de Um ou Vários Certificados
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
 
	// Inclusão de Um ou Vários Certificados
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
                                'Data Início',
                                'Data Fim',
                                'Situação',
                                'Exclusão');
         var d = document.getElementById("lista2_div");
         d.innerHTML = 'Carregando Lista... ';
		 var nos = xmldoc.getElementsByTagName('item');
         var tab = document.createElement("table");
         tab.className = 'tab_lista';
         var tbo = document.createElement("tbody");
         tab.appendChild(tbo);
        // cabeçalho da tabela
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
				d.innerHTML = 'Não existe nenhum certificado cadastrado!';
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
					limpaAtestado();
					someAtestado();
				}
			a.conectar();
		}	
	}


	// Grava registro de Certificado no Banco de Dados e Coloca em Formato de Impressão
	function GravaParecer()
	{
			$.post("php/gravaCertificado.php",
			/* {codigo:cd_serv, tipo:$("#tipo").val(), processo:$("#processo").val(), protocolo:$("#protocolo").val(), dtprotocolo:$("#dtprotocolo").val(), parecer:$("#parecer").val(), ass01:$("#ass01").val(), ass02:$("#ass02").val(), ass03:$("#ass03").val()}, */
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
			// window.location.reload();
			montafocus();
		}	,"xml");
	}
	
	// Reimpressão do ùltimo Certificado (em caso de falha da impressão ou na geração do Pdf.)
	function ReimpParecer()   
	{	// Se não preencer os 5 campos abaixos requeridos p/ gerar a reimpressão de Certificado: aparece uma mensagem de alerta
		if ($("#cod_curso").val()=='0') 
			{ 	alert('Falta Preencher o CÓDIGO DO CURSO!');
				return false; }   
		else if ($("#dt_inicio").val()=='') 
			{   alert('Falta Preencher a DATA DE INÍCIO DO CURSO!');
				return false; }
		else if ($("#dt_fim").val()=='') 
			{   alert('Falta Preencher a DATA DE TÉRMINO DO CURSO!');
				return false; }
		else if ($("#carga").val()=='') 
			{   alert('Falta Preencher a CARGA HORÁRIA DO CURSO!');
		else if ($("#dt_exp").val()=='') 
			{   alert('Falta Preencher a a DATA DE EXPEDIÇÃO DO CERTIFICADO DE CURSO!');
				return false; }
		
		//var xurl='http://jatuarana.trt14.gov.br:9090/reports/rwservlet?report=parecer_medico.rdf&destype=CACHE&userid=juntamed/juntamed$trt14@BDTRT14&paramform=no&server=rep_producao_101&desformat=PDF&P_CD_SERV='+cd_serv+"&P_MOT_AFAST="+$("#tipo").val()+"&P_NM_PROTOCOLO="+$("#protocolo").val()+"&P_DT_PROTOCOLO="+$("#dtprotocolo").val();
		var xurl='http://localhost:8888/reports/rwservlet?report=parecer_medico2.rdf&destype=CACHE&userid=rh/rhdesenv@desenv&paramform=no&server=rep_ita027939&desformat=PDF&P_CD_SERV='+cd_serv+"&P_MOT_AFAST="+$("#tipo").val()+"&P_NM_PROTOCOLO="+$("#protocolo").val()+"&P_DT_PROTOCOLO="+$("#dtprotocolo").val();
		
		window.open(xurl);
	}	
	

	// 
	function exibeAtestado(id){
			apareceAtestado();
			$('#Bt_alteraCertificado').show();
			$('#Bt_InsereCertificado').hide();
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

	
	// Insere os Certificados
	function insereCertificado(){
			$.post('php/insereCertificado.php',
			{cod_curso:$('#cod_curso').val(), cpf:$("#cpf").val(), nome_curso:$("#nome_curso").val(), nome_agraciado:$("#nome_agraciado").val(), nome_ins_conv:$("#nome_ins_conv").val(), setor_ins_conv:$("#setor_ins_conv").val(), nome_al_conv:$("#nome_al_conv").val(), setor_al_conv:$("#setor_al_conv").val(), dt_inicio:$("#dt_inicio").val(), dt_fim:$("#dt_fim").val(), carga:$("#carga").val(), localidade:$("#localidade").val(), dt_exp:$("#dt_exp").val()},
		function(f)
		{   if ( !trataErro(f) )	
			{ return false;	}
			alert( $("msg",f).text() );
			listaCertificado();  
		}
		,"xml") ; 
	}  
		