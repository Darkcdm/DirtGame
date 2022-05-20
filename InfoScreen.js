function loadHeader() {
	console.log("test");
	const queryString = window.location.search;
	console.log(queryString);
	const urlParams = new URLSearchParams(queryString);
	const gridID = urlParams.get("gridID");
	console.log(gridID);

	let gridData = pullGridData(gridID);

	renderHeader(gridData);
}

function pullGridData(gridID) {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.responseText);
			console.log(JSON.parse(this.responseText));
			return JSON.parse(this.responseText);
		}
	};
	xhttp.open("POST", "action/PullGridData.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	var header = "gridID=" + gridID;
	console.log(header);
	xhttp.send(header);
}
function renderHeader(gridData) {
	console.log(gridData);

	let gridID = document.createElement("h");
	gridID.innerText = "GridID: " + gridData[0];
	document.getElement("body").appendChild(gridID);

	let X = document.createElement("h");
	X.innerText = "X: " + gridData[1];
	document.getElement("body").appendChild(X);

	let Y = document.createElement("h");
	Y.innerText = "Y: " + gridData[2];
	document.getElement("body").appendChild(Y);

	let terrainType = document.createElement("h");
	Y.innerText = "TerrainType: " + gridData[3];
	document.getElement("body").appendChild(terrainType);

	let buildingOwner = document.createElement("h");
	Y.innerText = "BuildingOwner: " + gridData[4];
	document.getElement("body").appendChild(buildingOwner);

	let buildingType = document.createElement("h");
	Y.innerText = "BuildingType: " + gridData[5];
	document.getElement("body").appendChild(buildingType);
}
