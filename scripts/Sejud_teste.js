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

	// Salta de Campo "qtdedias" ao preencher dois d�gitos.
	function JumpField(fields,destino) {
		if (fields.value.length == fields.maxLength) {
		document.getElementById(destino).focus(); }
	}
	
	function JumpField2(fields) {
		if (fields.value.length == 10) {
		// document.getElementById(destino).focus();
		listaAtestados();
		exibeParecer();
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
				  	limpa();
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
	};
	
	// Ao Lan�ar um Atestado M�dico, as op��es de Lan�amentos de Atestado (combolist, Input, button) desaparecem p/ ficar mais f�cil a Visualiza��o do Parecer.
		function someAtestado()		
	{ 	$('#table_atestado01').hide();
		$('#table_atestado02').hide();
		$('#tbfoot2').show();
	};
	
	// Faz aparecer as op��es de lan�amento de um novo atestado m�dico, op��es essas que desapareceram por motivo de est�tica, conforme fun��o someAtestado().
		function apareceAtestado()		
	{ 	$('#tbfoot2').hide();
		$('#table_atestado01').show();
		$('#table_atestado02').show();
		$('#Bt_InsereAtestado').show();
		$('#Bt_alteraAtestado').hide();
		$('#datainicio').focus();		
	};
	

	
	// Soma o n� de Dias  com Base na Data Inicial e Mostra a Data Final.
	function SomarData(DataInicial,QtdeDias) {
	  	var DataFinal;
		var d = new Date();

		d.setTime(Date.parse(DataInicial.split("/").reverse().join("/"))+(86400000*(QtdeDias)))
      		
		DataFinal = (addZero(d.getDate()).toString())+"/"+(addZero(d.getMonth()+1)).toString()+"/"+(addZero(d.getFullYear())).toString();
		return DataFinal;
	};
 

	// Inclus�o de Um ou V�rios Atestados M�dicos
	function InsereAtestado() {
			$.post("php/insereAtestado.php",
			{codigo:cd_serv, tipo:$("#tipo").val(), protocolo:$("#protocolo").val(), dtprotocolo:$("#dtprotocolo").val(), datainicio:$("#datainicio").val(), datafim:$("#datafim").val(), operacao:$("#operacao").val(), sit_datainicio:$("#sit_datainicio").val(), sit_datafim:$("#sit_datafim").val(), cid:$("#cid").val(), base_legal:$("#base_legal").val()},
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
	function listaAtestados() {		
			// d = $('#msg5');
			// d.html('<img border='0' src='imagens/ajax2.gif'> Processando.... ');
				$.post("php/ListaAtestados.php",
				{codigo:cd_serv, tipo:$("#tipo").val() ,protocolo:$("#protocolo").val(), dtprotocolo:$("#dtprotocolo").val()},
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
				d.innerHTML = 'N�o existe nenhum Atestado M�dico cadastrado';
			};
		d.style.display = 'inline';
	}

	function excluiAtestado(vid) {

		var a = new AJAX();
		a.url = "php/excluiAtestado.php";
		a.metodo = 'POST';
		a.modo = 'X';
		var op;

		if (confirm("Deseja excluir este registro?")) {

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


	// Grava Parecer no Banco de Dados e Coloca em Formato de Impress�o
	function GravaParecer()
	{
			$.post("php/gravaParecer.php",
			{codigo:cd_serv, tipo:$("#tipo").val(), processo:$("#processo").val(), protocolo:$("#protocolo").val(), dtprotocolo:$("#dtprotocolo").val(), parecer:$("#parecer").val(), ass01:$("#ass01").val(), ass02:$("#ass02").val(), ass03:$("#ass03").val()},
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
	
	// Reimpress�o do �ltimo Parecer (em caso de falha da impress�o ou na gera��o do Pdf.)
	function ReimpParecer()   
	{	// Se n�o preencer os 4 campos abaixos requeridos p/ gerar a reimpress�o de parecer: aparece uma mensagem de alerta
		if ($("#tipo").val()=='0') 
			{ 	alert('Falta Preencher o Tipo de Licen�a');
				return false; }   
		else if ($("#processo").val()=='') 
			{   alert('Falta Preencher o N�mero do Processo');
				return false; }
		else if ($("#protocolo").val()=='') 
			{   alert('Falta Preencher o N�mero do Protocolo');
				return false; }
		else if ($("#dtprotocolo").val()=='') 
			{   alert('Falta Preencher o Data do Protocolo');
				return false; }
		
		//var xurl='http://jatuarana.trt14.gov.br:9090/reports/rwservlet?report=parecer_medico.rdf&destype=CACHE&userid=juntamed/juntamed$trt14@BDTRT14&paramform=no&server=rep_producao_101&desformat=PDF&P_CD_SERV='+cd_serv+"&P_MOT_AFAST="+$("#tipo").val()+"&P_NM_PROTOCOLO="+$("#protocolo").val()+"&P_DT_PROTOCOLO="+$("#dtprotocolo").val();
		var xurl='http://localhost:8888/reports/rwservlet?report=parecer_medico2.rdf&destype=CACHE&userid=rh/rhdesenv@desenv&paramform=no&server=rep_ita027939&desformat=PDF&P_CD_SERV='+cd_serv+"&P_MOT_AFAST="+$("#tipo").val()+"&P_NM_PROTOCOLO="+$("#protocolo").val()+"&P_DT_PROTOCOLO="+$("#dtprotocolo").val();
		
		window.open(xurl);
	}	
	

	// 
	function exibeAtestado(id){
			apareceAtestado();
			$('#Bt_alteraAtestado').show();
			$('#Bt_InsereAtestado').hide();
			$.post('php/exibeAtestado.php',{id:id},
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
			$.post('php/alteraAtestado.php',
			{identificacao:$('#identificacao').val(), datainicio:$("#datainicio").val(), datafim:$("#datafim").val(), operacao:$("#operacao").val(), sit_datainicio:$("#sit_datainicio").val(), sit_datafim:$("#sit_datafim").val(), cid:$("#cid").val(), base_legal:$("#base_legal").val()},
		function(f)
		{   if ( !trataErro(f) )	
			{ return false;	}
			alert( $("msg",f).text() );
			listaAtestados();  
			someAtestado();
			limpaAtestado();			
			$('#pareceres').focus;
		}
		,"xml") ; 
	}  
		