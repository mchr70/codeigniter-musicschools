// Librairie javascript qui permet l'auto complétion du nom de ville via le code postal (avec 3, 4 ou les 5 chiffres)
// Créer le 24/05/2017 par MICHENEAU Simon (Fukotaku)


// Variables globaux
var url_api = "https://data.opendatasoft.com/api/records/1.0/search/?dataset=code-postal-code-insee-2015%40public";
var params = "";
var paramsPlus = "&rows=100";
var codes_postaux = {};


// Fonction qui génère le paramètre utilisé pour la recherche dans l'API
function GenerateParam(value){
  params = "";
  if(value.length >= 3 && value.length <= 5 && isNaN(value) === false){
    if(value.length === 3){
      params = params+"code_postal+>%3D+"+value+"00+AND+code_postal+<+";
      value++;
      params = params+value+"00";;
      SearchData(params);
    }else if(value.length === 4){
      params = params+"code_postal+>%3D+"+value+"0+AND+code_postal+<+";
      value++;
      params = params+value+"0";;
      SearchData(params);
    }else if(value.length === 5){
      params = params+"code_postal+%3D+"+value;
      SearchData(params);
    }
  }else{
    closeSuggestBox();
  }
}


// Fonction qui recherche dans l'API en prenant en compte le paramètre de recherche
function SearchData(query){
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      results = JSON.parse(this.responseText);
      if(results.nhits > 0){
        suggestBox(results);
      }
    }
  };
  xmlhttp.open("GET", url_api+"&q=" + query + paramsPlus, true);
  xmlhttp.send();
}


// Fonction de tri tableau associatif gérer en mapping
function sortMapByValue(map){
    var tupleArray = [];
    for (var key in map) tupleArray.push([key, map[key]]);
    tupleArray.sort(function (a, b) { return a[1] - b[1] });
    return tupleArray;
}


// Fonction qui génère et affiche la liste des suggestions
function suggestBox(results){
  codes_postaux = {};
  if (results.nhits > 1) {
    // On rend visible la balise dédié à la liste des suggestions
    document.getElementById('suggestBoxElement').style.visibility = 'visible';
    document.getElementById('suggestBoxElement').style.height = '80px';
    var suggestBoxHTML  = '';
    for (i=0; i < 100; i++) {
      // On génère le code html de la liste des suggestions
      if(typeof(results.records[i]) != "undefined"){
        codes_postaux[results.records[i].fields.nom_com] = results.records[i].fields.code_postal;
      }
    }

    // On tri la liste par code postal
    codes_postaux = sortMapByValue(codes_postaux);
    for (var i = 0; i < codes_postaux.length; i++) {
      suggestBoxHTML += "<div class='suggestions' id=pcId" + i + " onmousedown='suggestBoxMouseDown(" + i +
      ")' onmouseover='suggestBoxMouseOver(" +  i +")' onmouseout='suggestBoxMouseOut(" + i +")'>"+
      codes_postaux[i][1] +" "+ codes_postaux[i][0] +'</div>';
    }

    // On écrit le code html de la liste dess suggestions générer précédement dans le balise dédié
    document.getElementById('suggestBoxElement').innerHTML = suggestBoxHTML;
  } else {
    // Si il n'y a qu'une seule suggestion disponible, alors on l'ajoute automatiquement dans le champ "ville"
    if (results.nhits === 1) {
      var placeInput = document.getElementById("ville");
      placeInput.value = results.records[0].fields.nom_com;
      var postalInput = document.getElementById("code_postal");
      postalInput.value = results.records[0].fields.code_postal;
    }
    closeSuggestBox();
  }
}


// fonction qui ferme la liste des suggestions
function closeSuggestBox() {
  document.getElementById('suggestBoxElement').innerHTML = '';
  document.getElementById('suggestBoxElement').style.visibility = 'hidden';
  document.getElementById('suggestBoxElement').style.height = '0px';
}


// On retire le surligne de la suggestion quand la souris n'est plus dessus
function suggestBoxMouseOut(obj) {
  document.getElementById('pcId'+ obj).className = 'suggestions';
}


// On place la suggestion dans le champ "ville" si il est sélectionné, et on ferme la liste des suggestions
function suggestBoxMouseDown(obj) {
  closeSuggestBox();
  var placeInput = document.getElementById("ville");
  placeInput.value = codes_postaux[obj][0];
  var postalInput = document.getElementById("code_postal");
  postalInput.value = codes_postaux[obj][1];
}


// On surligne la suggestion quand la souris est dessus
function suggestBoxMouseOver(obj) {
  document.getElementById('pcId'+ obj).className = 'suggestionMouseOver';
}
