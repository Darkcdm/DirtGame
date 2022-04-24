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
	var test = 0;

	//Clean the gameArea
	if (document.getElementById("gameTable")) {
		document.getElementById("gameTable").remove();
	}

	//Create the table
	//check that the table hasn't been drawn yet

	var body = document.getElementsByTagName("body")[0];
	var tbl = document.createElement("table");
	tbl.id = "gameTable";
	tbl.s;
	tbl.style.width = "100%";
	tbl.setAttribute("border", "1");
	var tbdy = document.createElement("tbody");
	for (var i = 0; i < size; i++) {
		var tr = document.createElement("tr");
		for (var j = 0; j < size; j++) {
			var td = document.createElement("td");
			td.innerText = test;
			test++;
			tr.appendChild(td);
		}
		tbdy.appendChild(tr);
	}
	tbl.appendChild(tbdy);
	document.getElementById("mapArea").appendChild(tbl);
}

function saveSessionVar(type, val) {
	sessionStorage.setItem(type, val);
	console.log("Session:#" + type + "# Has value:#" + val + "#");
}
function loadSessionVar(type) {
	return sessionStorage.getItem(type);
}
