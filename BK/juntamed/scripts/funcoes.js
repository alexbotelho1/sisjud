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

function abrePesquisa(obj0,obj,obj2,arq){
		objeto0 = obj0;
		objeto = obj;
		objeto2 = obj2;
		window.open(arq,'Pesquisa','width=420,height=400,scrollbars=yes');
	}

function abrePesquisaG(obj0,obj,obj2,arq){
		objeto0 = obj0;
		objeto = obj;
		objeto2 = obj2;
		window.open(arq,'Pesquisa','width=600,height=400,scrollbars=yes');
	}

function abrePesquisaP(obj0,obj,obj2,arq){
		objeto0 = obj0;
		objeto = obj;
		objeto2 = obj2;
		window.open(arq,'Pesquisa','width=550,height=250,scrollbars=yes');
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

function JumpField(fields,destino) {
if (fields.value.length == fields.maxLength) {
   document.getElementById(destino).focus();
}}

function getVar(name)
         {
         get_string = document.location.search;
         return_value = '';

         do { //This loop is made to catch all instances of any get variable.
            name_index = get_string.indexOf(name + '=');

            if(name_index != -1)
              {
              get_string = get_string.substr(name_index + name.length + 1, get_string.length - name_index);

              end_of_value = get_string.indexOf('&');
              if(end_of_value != -1)
                value = get_string.substr(0, end_of_value);
              else
                value = get_string;

              if(return_value == '' || value == '')
                 return_value += value;
              else
                 return_value += ', ' + value;
              }
            } while(name_index != -1)

         //Restores all the blank spaces.
         space = return_value.indexOf('+');
         while(space != -1)
              {
              return_value = return_value.substr(0, space) + ' ' +
              return_value.substr(space + 1, return_value.length);

              space = return_value.indexOf('+');
              }

         return(return_value);
         }


function carrega_lov(tabela, div, sel){
var a = new AJAX();
a.url = "../php/lov.php";
a.metodo = 'POST';
a.modo = 'X';
a.params = 'tabela='+encodeURI(tabela);

a.addHeader("Content-type", "application/x-www-form-urlencoded");
	a.processaresultado = function(xmldoc){
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
	a.conectar();

}

//Incluído para seleção com dependência - em 09/04/2008
function carrega_lov2(tabela, div, sel,v_param){
var a = new AJAX();
a.url = "../php/lov.php";
a.metodo = 'POST';
a.modo = 'X';
a.params = 'tabela='+encodeURI(tabela);
//Incluído para seleção com dependência - em 09/04/2008
a.params = a.params + '&'+encodeURI('parametro='+v_param);

a.addHeader("Content-type", "application/x-www-form-urlencoded");
	a.processaresultado = function(xmldoc){
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
	a.conectar();

}




function showCalendar(id, format, showsTime, showsOtherMonths) {
  var el = document.getElementById(id);
  if (_dynarch_popupCalendar != null) {
    // we already have some calendar created
    _dynarch_popupCalendar.hide();                 // so we hide it first.
  } else {
    // first-time call, create the calendar.
    var cal = new Calendar(0, null, selected, closeHandler);
    // uncomment the following line to hide the week numbers
    // cal.weekNumbers = false;
    if (typeof showsTime == "string") {
      cal.showsTime = true;
      cal.time24 = (showsTime == "24");
    }
    if (showsOtherMonths) {
      cal.showsOtherMonths = true;
    }
    _dynarch_popupCalendar = cal;                  // remember it in the global var
    cal.setRange(1900, 2070);        // min/max year allowed.
    cal.create();
  }
  _dynarch_popupCalendar.setDateFormat(format);    // set the specified date format
  _dynarch_popupCalendar.parseDate(el.value);      // try to parse the text in field
  _dynarch_popupCalendar.sel = el;                 // inform it what input field we use

  // the reference element that we pass to showAtElement is the button that
  // triggers the calendar.  In this example we align the calendar bottom-right
  // to the button.
  _dynarch_popupCalendar.showAtElement(el.nextSibling, "Br");        // show the calendar

  return false;
}


// This function gets called when the end-user clicks on some date.
function selected(cal, date) {
  cal.sel.value = date; // just update the date in the input field.
  if (cal.dateClicked && (cal.sel.id == "sel1" || cal.sel.id == "sel3"))
    // if we add this call we close the calendar on single-click.
    // just to exemplify both cases, we are using this only for the 1st
    // and the 3rd field, while 2nd and 4th will still require double-click.
    cal.callCloseHandler();
}

function closeHandler(cal) {
  cal.hide();                        // hide the calendar
//  cal.destroy();
  _dynarch_popupCalendar = null;
}
