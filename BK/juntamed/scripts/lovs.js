// Objeto AJAX para comunicação Assincrona com um servidor de aplicações WEB


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



function preencheComHash(processo,chave,seletor,selecionado) {
var url = "../php/listahash.php";

var parametros = 'processo='+encodeURI(processo);
    parametros = parametros + '&chave='+encodeURI(chave);

	
var myAjax = new Ajax.Request(
	url, 
	{
		method: 'post', 
		parameters: '', 
		onComplete:function (originalRequest)
		{
		mostralov(originalRequest,seletor,selecionado)
		}
	});
	
 m.innerHTML = "";

}


function carrega_lov(tabela, div, sel){
var url = "php/lov.php";
var parametros = 'tabela='+encodeURI(tabela);
var myAjax = new Ajax.Request(
			url, 
			{
				method: 'post', 
				parameters: parametros, 
				onComplete:function (originalRequest)
				{
				mostralov(originalRequest,div,sel)
				}
			});

}

function mostralov(requisicaoOriginal,div, sel){
		 var xmldoc = requisicaoOriginal.responseXML;
         if (!trataErro(xmldoc)){
                  return false;
         }
         var nos = xmldoc.getElementsByTagName('tabela');
         var selm = document.getElementById(div);
         selm.options.length = 0;
         selm.size = 0;
  		 
         var cod = 0;
         var des = '...';
         var opt = new Option(des,cod);
         selm.options.add(opt,selm.options.length);

         if(xmldoc.hasChildNodes()&&nos.length>0){
   
         for(var i=0;i<nos.length;i++){
               var no = nos[i];
               var cod = no.childNodes[0].firstChild.nodeValue;
               var des = no.childNodes[1].firstChild.nodeValue;
               var opt = new Option(des,cod);
               if (cod==sel){
                  opt.selected = true;
                  }
				  
               
               selm.options.add(opt,selm.options.length);
               }
         selm.size = 1;
         }

}

function carrega_lov2(tabela, div, sel,v_param){
var url = "php/lov.php";
var parametros = 'tabela='+encodeURI(tabela);
var parametros = parametros + '&'+encodeURI('parametro='+v_param);

var myAjax = new Ajax.Request(
			url, 
			{
				method: 'post', 
				parameters: parametros, 
				onComplete:function (originalRequest)
				{
				mostralov(originalRequest,div,sel)
				}
			});

}



