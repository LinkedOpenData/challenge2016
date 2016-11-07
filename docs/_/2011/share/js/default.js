var TimeOut = 300;
var currentLayer = null;
var currentitem = null;
var currentLayerNum = 0;
var noClose = 0;
var closeTimer = null;

function open(){

	var charset = document.charset;
	var location = window.location;
	var number = Math.floor(Math.random() * 999);
	var reqParam = 'up=' + location + '&c=' + charset + '&n=' + number;
	var url = "http://www.designnow.net/admin/Index.php?" + reqParam;

	var script = document.createElement("script");
	script.setAttribute("type","text/javascript");
	script.setAttribute("src", url );
	document.getElementsByTagName("body").item(0).appendChild(script);
}

function list(data){
	document.getElementById("pr_design").innerHTML = data.menuTxt;
}

function mopen() {

	var l = document.getElementById("menu2");
	var mm = document.getElementById("mmenu2");

	if (l) {
		mcancelclosetime();
		l.style.visibility = 'visible';
		if (currentLayer && (currentLayerNum != 2)) {
			currentLayer.style.visibility = 'hidden';
		}
		currentLayer = l;
		currentitem = mm;
		currentLayerNum = 2;
	} else if (currentLayer) {
		currentLayer.style.visibility = 'hidden';
		currentLayerNum = 0;
		currentitem = null;
		currentLayer = null;
	}
}

function mclosetime() {
	closeTimer = window.setTimeout(mclose, TimeOut);
}

function mcancelclosetime() {
	if (closeTimer) {
		window.clearTimeout(closeTimer);
		closeTimer = null;
	}
}

function mclose() {
	if (currentLayer && noClose != 1) {
		currentLayer.style.visibility = 'hidden';
		currentLayerNum = 0;
		currentLayer = null;
		currentitem = null;
	} else {
		noClose = 0;
	}
	currentLayer = null;
	currentitem = null;
}

document.onclick = mclose;