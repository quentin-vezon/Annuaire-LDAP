
function createObject() {
	var request_type;
	var browser = navigator.appName;
	if(browser == "Microsoft Internet Explorer"){
	request_type = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		request_type = new XMLHttpRequest();
	}
		return request_type;
}

var http = createObject();


function autosuggest() {
if(document.getElementById("search_type").value=="search_nom"){
q = document.getElementById('search-q').value;
nocache = Math.random();
http.open('get', 'search_nom.php?q='+q+'&nocache = '+nocache);
http.onreadystatechange = autosuggestReply;
http.send(null);
}else if(document.getElementById("search_type").value=="search_bureau"){
	q = document.getElementById('search-q').value;
	nocache = Math.random();
	http.open('get', 'search_bureau.php?q='+q+'&nocache = '+nocache);
	http.onreadystatechange = autosuggestReply;
http.send(null);
}else if(document.getElementById("search_type").value=="search_groupe"){
	q = document.getElementById('search-q').value;
	nocache = Math.random();
	http.open('get', 'search_groupe.php?q='+q+'&nocache = '+nocache);
	http.onreadystatechange = autosuggestReply;
http.send(null);
}else if(document.getElementById("search_type").value=="search_date"){
	q = document.getElementById('search-q').value;
	nocache = Math.random();
	http.open('get', 'search_date.php?q='+q+'&nocache = '+nocache);
	http.onreadystatechange = autosuggestReply;
http.send(null);
}
}

function autosuggestce() {
	q = document.getElementById('search-q').value;
	nocache = Math.random();
	http.open('get', 'search-ce.php?q='+q+'&nocache = '+nocache);
	http.onreadystatechange = autosuggestReply;
	http.send(null);
}

function autosuggestReply() {
if(http.readyState == 4){
	var response = http.responseText;
	e = document.getElementById('results');
	if(response!=""){
		e.innerHTML=response;
		e.style.display="block";
	} else {
		e.style.display="none";
		print();
	}
}
}