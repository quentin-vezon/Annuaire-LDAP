function prenom_nom() {
    switch(document.getElementById("ou").value) {
         
          case('SIC'):
              document.getElementById('mail').value=document.getElementById("givenname").value.toLowerCase() +'.' + document.getElementById("sn") .value.toLowerCase() + '@' + document.getElementById("ou").value.toLowerCase() + '.montp.cnrs.fr';
              break;
          default:
              document.getElementById('mail').value=document.getElementById("givenname").value.toLowerCase() +'.' + document.getElementById("sn") .value.toLowerCase() + '@' + document.getElementById("ou").value.toLowerCase() + '.cnrs.fr';
              break;
  }
      document.getElementById('mail').value = document.getElementById('mail').value.replace(/ /gi, '-');
}

function funct_email(){ 
    document.getElementById('mail').value  = document.getElementById("givenname").value.toLowerCase() +'.' + document.getElementById("sn") .value.toLowerCase() + '@cnrs.fr';
}




//Script pour initier les nom de groupe --> labo_
function groupe() {
    switch(document.getElementById("description").value) {
        default:
            document.getElementById('cn').value=document.getElementById("description").value.toLowerCase() +'_';
            break;
    }
}

//script pour initier les identifiants 
function identifiant() {
    var first_letter = document.getElementById("givenname").value.toLowerCase().slice(0,1);
    document.getElementById('cn').value=first_letter+document.getElementById("sn").value.toLowerCase() ;
    document.getElementById('cn').value = document.getElementById('cn').value.replace(/ /gi, '-');
}

//Script initier les notes en NOLIST
function no_list(description,texte){
   
    if(typeof description=="string"  ) { 
        description = document.getElementById(description); 
    }
    description.value += texte;
}

function yes_list(description){
   
    if(typeof description=="string"  ) { 
        description = document.getElementById(description); 
    }
    description.value = "";
}



function required_shadow(){
    if(document.getElementById('radio2').checked){
        document.getElementById("datefin").required = true;
    } else if(!(document.getElementById('radio2').checked)) {
        document.getElementById("datefin").required = false;
    }
}


function printDiv(divId,
  title) {

  let mywindow = window.open('', 'PRINT', 'height=650,width=900,top=100,left=150');

  mywindow.document.write(`<html><head><title>${title}</title>`);
  mywindow.document.write('</head><body >');
  mywindow.document.write(document.getElementById(divId).innerHTML);
  mywindow.document.write('</body></html>');

  mywindow.document.close(); // necessary for IE >= 10
  mywindow.focus(); // necessary for IE >= 10*/

  mywindow.print();
  mywindow.close();

  return true;
}


function init(){
    var stretchers = document.getElementsByClassName('box');
    var toggles = document.getElementsByClassName('tab');
    var myAccordion = new fx.Accordion(
        toggles, stretchers, {opacity: false, height: true, duration: 600}
    );
    //hash functions
    var found = false;
    toggles.each(function(h3, i){
        var div = Element.find(h3, 'nextSibling');
            if (window.location.href.indexOf(h3.title) > 0) {
                myAccordion.showThisHideOpen(div);
                found = true;
            }
        });
        if (!found) myAccordion.showThisHideOpen(stretchers[0]);
}

//Pour les masks des dates début et fin de contrat
document.addEventListener('DOMContentLoaded', () => {
    for (const el of document.querySelectorAll("[placeholder][data-slots]")) {
        const pattern = el.getAttribute("placeholder"),
            slots = new Set(el.dataset.slots || "_"),
            prev = (j => Array.from(pattern, (c,i) => slots.has(c)? j=i+1: j))(0),
            first = [...pattern].findIndex(c => slots.has(c)),
            accept = new RegExp(el.dataset.accept || "\\d", "g"),
            clean = input => {
                input = input.match(accept) || [];
                return Array.from(pattern, c =>
                    input[0] === c || slots.has(c) ? input.shift() || c : c
                );
            },
            format = () => {
                const [i, j] = [el.selectionStart, el.selectionEnd].map(i => {
                    i = clean(el.value.slice(0, i)).findIndex(c => slots.has(c));
                    return i<0? prev[prev.length-1]: back? prev[i-1] || first: i;
                });
                el.value = clean(el.value).join``;
                el.setSelectionRange(i, j);
                back = false;
            };
        let back = false;
        el.addEventListener("keydown", (e) => back = e.key === "Backspace");
        el.addEventListener("input", format);
        el.addEventListener("focus", format);
        el.addEventListener("blur", () => el.value === pattern && (el.value=""));
    }
});



