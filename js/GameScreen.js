var map;
function generateMap(type, val) {
	//parse input
	var x = 5;
	var y = 5;
	var size = 5;
	switch (type) {
		case "x":
			x = val;
			break;
		case "y":
			y = val;
			break;
		case "size":
			size = val;
			break;
		default:
			x = 5;
			y = 5;
			size = 10;
	}

	console.log(x, y, size);
	//get map data from database
	PullDataAndRender(x, y, size);
}

function saveSessionVar(type, val) {
	sessionStorage.setItem(type, val);
	console.log("Session:#" + type + "# Has value:#" + val + "#");
}

function loadSessionVar(type) {
	return sessionStorage.getItem(type);
}

function PullDataAndRender(x, y, size) {
	//send userdata to server to check if the user exists
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			let mapData = JSON.parse(this.responseText);
			renderMap(mapData, x, y, size);
		}
	};
	xhttp.open("POST", "action/PullMapData.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	var header = "X=" + x + "&Y=" + y + "&size=" + size;
	console.log(header);
	xhttp.send(header);
}

function renderMap(mapData, x, y, size) {
	//Clean the gameArea
	if (document.getElementById("gameTable")) {
		document.getElementById("gameTable").remove();
	}

	//Create the table
	var counter = 0;

	var body = document.getElementsByTagName("body")[0];
	var tbl = document.createElement("table");
	tbl.id = "gameTable";
	tbl.s;
	tbl.style.width = "100%";
	tbl.setAttribute("border", "1");
	var tbdy = document.createElement("tbody");
	for (var gridY = y; gridY < size + y; gridY++) {
		var tr = document.createElement("tr");
		for (var gridX = x; gridX < size + y; gridX++) {
			//FILLING THE INDIVIDUAL CELLS HERE
			var td = document.createElement("td");
			td.innerHTML =
				"[" + gridX + "," + gridY + "]" + "<br>" + mapData[counter][0];
			counter++;
			tr.appendChild(td);
		}
		tbdy.appendChild(tr);
	}
	tbl.appendChild(tbdy);
	document.getElementById("mapArea").appendChild(tbl);
}
