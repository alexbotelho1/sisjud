
// exibe mandado

function exibeMandado(idmandado){
   var tab = document.createElement("table");
   tab.className = 'tab_lista';
   var tbo = document.createElement("tbody");
   tab.appendChild(tbo);

   var tr = document.createElement("tr");
       var th = document.createElement("th");
       th.className = 'th_lista';
       th.colSpan = 2;
       var tx = document.createTextNode("TRIBUNAL REGIONAL DO TRABALHO 14ª REGIÃO");
       th.appendChild(tx);
       var br = document.createElement("br");
       th.appendChild(br);
       var tx = document.createTextNode("Central de Mandados");
       th.appendChild(tx);
       tr.appendChild(th);
   tbo.appendChild(tr);

   var a = new AJAX();
   a.url = "../php/retornaMandado.php";
   a.metodo = 'POST';
   a.modo = 'X';
   a.params = 'idmandado='+encodeURI(idmandado);
   a.addHeader("Content-type", "application/x-www-form-urlencoded");
   a.processaresultado = function(r){
              if (!trataErro(r)){
                  return false;
              }
                var nos = r.getElementsByTagName('item');
                var no = nos[0];
                
                var tr = document.createElement("tr");
                var td = document.createElement("td");
                td.className = 'td_lista';
                var tx = document.createTextNode(" ");
                td.appendChild(tx);
                tr.appendChild(td);
                var td = document.createElement("td");
                td.className = 'td_listaR';
                var tx = document.createTextNode("Mandado: " + no.childNodes[1].firstChild.nodeValue);
                td.appendChild(tx);
                tr.appendChild(td);
                tbo.appendChild(tr);

                var tr = document.createElement("tr");
                var th = document.createElement("th");
                th.className = 'th_listaL';
                var tx = document.createTextNode("Processo: ");
                th.appendChild(tx);
                tr.appendChild(th);
                var td = document.createElement("td");
                td.className = 'td_lista';
                var tx = document.createTextNode(no.childNodes[2].firstChild.nodeValue);
                td.appendChild(tx);
                tr.appendChild(td);
                tbo.appendChild(tr);

                var tr = document.createElement("tr");
                var th = document.createElement("th");
                th.className = 'th_listaL';
                var tx = document.createTextNode("Origem: ");
                th.appendChild(tx);
                tr.appendChild(th);
                var td = document.createElement("td");
                td.className = 'td_lista';
                var tx = document.createTextNode(no.childNodes[3].firstChild.nodeValue);
                td.appendChild(tx);
                tr.appendChild(td);
                tbo.appendChild(tr);

                var tr = document.createElement("tr");
                var th = document.createElement("th");
                th.className = 'th_listaL';
                var tx = document.createTextNode("Tipo: ");
                th.appendChild(tx);
                tr.appendChild(th);
                var td = document.createElement("td");
                td.className = 'td_lista';
                var tx = document.createTextNode(no.childNodes[4].firstChild.nodeValue);
                td.appendChild(tx);
                tr.appendChild(td);
                tbo.appendChild(tr);

                var tr = document.createElement("tr");
                var th = document.createElement("th");
                th.className = 'th_listaL';
                var tx = document.createTextNode("Prazo: ");
                th.appendChild(tx);
                tr.appendChild(th);
                var td = document.createElement("td");
                td.className = 'td_lista';
                var tx = document.createTextNode(no.childNodes[5].firstChild.nodeValue);
                td.appendChild(tx);
                tr.appendChild(td);
                tbo.appendChild(tr);
                
                var tr = document.createElement("tr");
                var th = document.createElement("th");
                th.className = 'th_listaL';
                var tx = document.createTextNode("Área: ");
                th.appendChild(tx);
                tr.appendChild(th);
                var td = document.createElement("td");
                td.className = 'td_lista';
                var tx = document.createTextNode(no.childNodes[6].firstChild.nodeValue);
                td.appendChild(tx);
                tr.appendChild(td);
                tbo.appendChild(tr);
                
                var tr = document.createElement("tr");
                var th = document.createElement("th");
                th.className = 'th_listaL';
                var tx = document.createTextNode("Carga: ");
                th.appendChild(tx);
                tr.appendChild(th);
                var td = document.createElement("td");
                td.className = 'td_lista';
                var tx = document.createTextNode(no.childNodes[7].firstChild.nodeValue);
                td.appendChild(tx);
                tr.appendChild(td);
                tbo.appendChild(tr);
                
                                
                if(no.childNodes[8].firstChild.nodeValue != 'x'){
                var tr = document.createElement("tr");
                var th = document.createElement("th");
                th.className = 'th_listaL';
                var tx = document.createTextNode("Observação: ");
                th.appendChild(tx);
                tr.appendChild(th);
                var td = document.createElement("td");
                td.className = 'td_lista';
                var tx = document.createTextNode(no.childNodes[8].firstChild.nodeValue);
                td.appendChild(tx);
                tr.appendChild(td);
                tbo.appendChild(tr);
                }
                
 	           
                var tr = document.createElement("tr");
                var td = document.createElement("td");
                td.className = 'td_lista';
                td.colSpan = 2;
                var tx = document.createTextNode(" ");
                td.appendChild(tx);
                tr.appendChild(td);
                tbo.appendChild(tr);

                var b = new AJAX();
                b.url = "../php/arquivosMandado.php";
                b.metodo = 'POST';
                b.modo = 'X';
                b.params = 'idmandado='+encodeURI(no.childNodes[0].firstChild.nodeValue);
                b.addHeader("Content-type", "application/x-www-form-urlencoded");

                b.processaresultado = function(s){
                if (!trataErro(s)){
                  return false;
                  }
                  var nos2 = s.getElementsByTagName('item');

                  var tr = document.createElement("tr");
                  var th = document.createElement("th");
                  th.className = 'th_lista';
                  th.colSpan = 2;
                  var tx = document.createTextNode("DOCUMENTOS");
                  th.appendChild(tx);
                  tr.appendChild(th);
                  tbo.appendChild(tr);

                  if(s.hasChildNodes()&&nos2.length>0){
                  for(var i=0;i<nos2.length;i++){
                  var no2 = nos2[i];
                  var tr = document.createElement("tr");
                  var td = document.createElement("td");
                  td.className = 'td_lista';
                  var tx = document.createTextNode(no2.childNodes[1].firstChild.nodeValue);
                  td.appendChild(tx);
                  tr.appendChild(td);
                  var td = document.createElement("td");
                  td.className = 'td_lista';
                                    
                  var ta = document.createElement("a");
                  ta.id = no2.childNodes[0].firstChild.nodeValue;
                  ta.onclick = function(){
                             detalheArquivo(this.id);
                             }
                  ta.href = "#";
                  var tx = document.createTextNode(no2.childNodes[2].firstChild.nodeValue);
                  ta.appendChild(tx);
                  td.appendChild(ta);
                  tr.appendChild(td);
                                  
                  tbo.appendChild(tr);
                 }
              }

                  /*
                var tr = document.createElement("tr");
                  var th = document.createElement("th");
                  th.className = 'th_listaL';
                  th.colSpan = 2;
                  var tx = document.createTextNode(" ");
                  th.appendChild(tx);
                  tr.appendChild(th);
                  tbo.appendChild(tr);

                var c = new AJAX();
                c.url = "transportadorJT.php";
                c.metodo = 'POST';
                c.modo = 'X';
                c.params = 'idjt='+encodeURI(no.childNodes[0].firstChild.nodeValue);
                c.addHeader("Content-type", "application/x-www-form-urlencoded");

                c.processaresultado = function(s){
                if (!trataErro(s)){
                  return false;
                  }
                  var nos3 = s.getElementsByTagName('item');
                  if(s.hasChildNodes()&&nos3.length>0){

                  var tr = document.createElement("tr");
                  var th = document.createElement("th");
                  th.className = 'th_lista';
                  th.colSpan = 2;
                  var tx = document.createTextNode("TRANSPORTADORES");
                  th.appendChild(tx);
                  tr.appendChild(th);
                  tbo.appendChild(tr);

                  for(var i=0;i<nos3.length;i++){
                  var no3 = nos3[i];
                  var tr = document.createElement("tr");

                  var td = document.createElement("td");
                  td.className = 'td_lista';
                  var tx = document.createTextNode(no3.childNodes[3].firstChild.nodeValue);
                  td.appendChild(tx);
                  tr.appendChild(td);

                  var td = document.createElement("td");
                  td.className = 'td_lista';
                  var ta = document.createElement("a");
                  ta.id = no3.childNodes[0].firstChild.nodeValue;
                  ta.onclick = function(){
                             detalheTransportador(this.id);
                             }
                  ta.href = "#";
                  var tx = document.createTextNode(no3.childNodes[2].firstChild.nodeValue);
                  ta.appendChild(tx);
                  td.appendChild(ta);
                  tr.appendChild(td);

                  tbo.appendChild(tr);
                 }
                  var tr = document.createElement("tr");
                  var th = document.createElement("th");
                  th.className = 'th_listaL';
                  th.colSpan = 2;
                  var tx = document.createTextNode(" ");
                  th.appendChild(tx);
                  tr.appendChild(th);
                  tbo.appendChild(tr);

              }

*/
                  var tr = document.createElement("tr");
                  var th = document.createElement("th");
                  th.className = 'th_listaL';
                  var tx = document.createTextNode("Data do Envio: ");
                  th.appendChild(tx);
                  tr.appendChild(th);
                  var td = document.createElement("td");
                  td.className = 'td_lista';
                  var tx = document.createTextNode(no.childNodes[10].firstChild.nodeValue);
                  td.appendChild(tx);
                  tr.appendChild(td);
                  tbo.appendChild(tr);

                  var tr = document.createElement("tr");
                  var th = document.createElement("th");
                  th.className = 'th_listaL';
                  var tx = document.createTextNode("Usuário Envio: ");
                  th.appendChild(tx);
                  tr.appendChild(th);
                  var td = document.createElement("td");
                  td.className = 'td_lista';
                  var tx = document.createTextNode(no.childNodes[11].firstChild.nodeValue);
                  td.appendChild(tx);
                  tr.appendChild(td);
                  tbo.appendChild(tr);

                  var tr = document.createElement("tr");
                  var th = document.createElement("th");
                  th.className = 'th_listaL';
                  var tx = document.createTextNode("Situação: ");
                  th.appendChild(tx);
                  tr.appendChild(th);
                  var td = document.createElement("td");
                  td.className = 'td_listaB';
                  var tx = document.createTextNode(no.childNodes[9].firstChild.nodeValue);
                  td.appendChild(tx);
                  tr.appendChild(td);
                  tbo.appendChild(tr);

                  var tr = document.createElement("tr");
                  var td = document.createElement("td");
                  td.className = 'td_listaL';
                  td.colSpan = 2;
                  var tx = document.createTextNode("OBS:. As informações acima exibidas estão gravados no banco de dados, imprimir apenas se necessário.");
                  td.appendChild(tx);
                  tr.appendChild(td);
                  tbo.appendChild(tr);
 //                }
 //    c.conectar();
     
			    }
	b.conectar();

			}
	a.conectar();



return tab;

}

function detalheArquivo(vid){
		  window.open('../php/exibeArquivo.php?vid=' + vid);
}