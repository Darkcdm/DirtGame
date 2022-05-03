var map;
function generateMap(type, val) {
	//parse input
	/*
	let x = sessionStorage.getItem("x");
	let y = sessionStorage.getItem("y");
	let size = sessionStorage.getItem("size");
*/
	//getting string, needs to be converted to integer
	switch (type) {
		case "x":
			x = Number(val);
			break;
		case "y":
			y = Number(val);
			break;
		case "size":
			size = Number(val);
			break;
		default:
			x = 5;
			y = 5;
			size = 10;
	}
	/*
	sessionStorage.setItem("x", x);
	sessionStorage.setItem("y", y);
	sessionStorage.setItem("size", size);
	*/
	console.log(typeof x, typeof y, typeof size);
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
	//console.log(mapData);
	var body = document.getElementsByTagName("body")[0];
	var tbl = document.createElement("table");
	tbl.id = "gameTable";
	tbl.s;
	tbl.style.width = "100%";
	tbl.setAttribute("border", "1");
	var tbdy = document.createElement("tbody");
	for (var gridY = y; gridY < size + y; gridY++) {
		var tr = document.createElement("tr");
		for (var gridX = x; gridX < size + x; gridX++) {
			//FILLING THE INDIVIDUAL CELLS HERE
			//get the right index to work with
			var index = null;
			var gridId = CalcGridID(gridX, gridY);
			for (i = 0; index == null; i++) {
				if (mapData[i][3] == gridId) {
					index = i;
					break;
				}
			}

			//make variables from DataBase data
			var terrain = mapData[index][0];
			var owner = mapData[index][1];
			var building = mapData[index][2];

			//creating elements in each cell
			var td = document.createElement("td");
			var img = document.createElement("IMG");
			var btn = document.createElement("button");

			//if there is a building on a cell, but down the icon of the building.
			if (building != null) {
				img.setAttribute("src", "Img/" + building + ".png");
			} else {
				//otherwise show terrain icon

				img.setAttribute("src", "Img/" + terrain + ".png");
			}

			//adding bloat text
			td.innerHTML = "[" + gridX + "," + gridY + "]" + "<br>" + terrain;

			//couter going up
			counter++;
			//append elements on the document
			btn.appendChild(img);
			td.appendChild(btn);
			tr.appendChild(td);
		}
		tbdy.appendChild(tr);
	}
	tbl.appendChild(tbdy);
	document.getElementById("mapArea").appendChild(tbl);
}

function CalcGridID(X, Y) {
	return 0.5 * (X + Y) * (X + Y + 1) + Y;
}
