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

function preencheComHash(processo,chave,seletor,selecionado,vazio) {
var url = "./php/listahash.php";
v_vazio='...';
if (vazio) {v_vazio=vazio} ;
var parametros = 'processo='+encodeURI(processo);
    parametros = parametros + '&chave='+encodeURI(chave);

	$.post('php/listahash.php',{processo:processo,chave:chave},  
	function(data){
		 var xmldoc = data;
         if (!trataErro(xmldoc)){
                  return false;
         }
         var nos = xmldoc.getElementsByTagName('item');
         var selm = $('#'+seletor)[0];
         selm.options.length = 0;
         selm.size = 0;
  		 
         var cod = 0;
         var des = v_vazio;
         var opt = new Option(des,cod);
         selm.options.add(opt,selm.options.length);

         if(xmldoc.hasChildNodes()&&nos.length>0){
   
         for(var i=0;i<nos.length;i++){
               var no = nos[i];
               var cod = no.childNodes[0].firstChild.nodeValue;
               var des = no.childNodes[1].firstChild.nodeValue;
               var opt = new Option(des,cod);
               if (cod==selecionado || des==selecionado){
                  opt.selected = true;
                  }
               
               selm.options.add(opt,selm.options.length);
               }
         selm.size = 1;
         }
	}, "xml");

	};
