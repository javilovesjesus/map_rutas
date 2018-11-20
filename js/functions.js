
var geocoder;
var map;
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();

if(document.getElementById("primero") && document.getElementById("segundo") && document.getElementById("tercero")){
	var locations = [
		[ciuA, latA, lngA, 1],
		[ciuB, latB, lngB, 2],
		[ciuC, latC, lngC, 3],
	];
}
else{            
	var locations = ['Ecuador', -2.0000000, -77.5000000, 1];
}

function initialize() {
	directionsDisplay = new google.maps.DirectionsRenderer();
	
	var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 7,
		center: new google.maps.LatLng(-2.0000000, -77.5000000),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	directionsDisplay.setMap(map);
	var infowindow = new google.maps.InfoWindow();

	var marker, i;
	var request = {
		travelMode: google.maps.TravelMode.DRIVING
	};
	for (i = 0; i < locations.length; i++) {
		marker = new google.maps.Marker({
		position: new google.maps.LatLng(locations[i][1], locations[i][2]),
		map: map
		});

		google.maps.event.addListener(marker, 'click', (function(marker, i) {
		return function() {
			infowindow.setContent(locations[i][0]);
			infowindow.open(map, marker);
		}
		})(marker, i));
		if (i == 0) request.origin = marker.getPosition();
		else if (i == locations.length - 1) request.destination = marker.getPosition();
		else {
		if (!request.waypoints) request.waypoints = [];
		request.waypoints.push({
			location: marker.getPosition(),
			stopover: true
		});
		}

	}
	directionsService.route(request, function(result, status) {
		if (status == google.maps.DirectionsStatus.OK) {
		directionsDisplay.setDirections(result);
		}
	});
}
google.maps.event.addDomListener(window, "load", initialize);

function graficar(){
	punto1 = $('#primero').val();
	punto2 = $('#segundo').val();
	punto3 = $('#tercero').val();
	recargarMapa(punto1,punto2,punto3);
	$('#tabla').load('tabla.php');
}

function recargarMapa(punto1,punto2,punto3){
	var puntoA = punto1.split('::');
	idA = puntoA[0];
	latA = puntoA[1];
	lngA = puntoA[2];
	ciuA = puntoA[3];

	var puntoB = punto2.split('::');
	idB = puntoB[0];
	latB = puntoB[1];
	lngB = puntoB[2];
	ciuB = puntoB[3];

	var puntoC = punto3.split('::');
	idC = puntoC[0];
	latC = puntoC[1];
	lngC = puntoC[2];
	ciuC = puntoC[3];

	var locations = [
		[ciuA, latA, lngA, 1, idA],
		[ciuB, latB, lngB, 2, idB],
		[ciuC, latC, lngC, 3, idC],
	];

	directionsDisplay = new google.maps.DirectionsRenderer();
	var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 7,
		center: new google.maps.LatLng(-2.0000000, -77.5000000),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});

	directionsDisplay.setMap(map);
	var infowindow = new google.maps.InfoWindow();

	var marker, i;
	var request = {
		travelMode: google.maps.TravelMode.DRIVING
	};
	for (i = 0; i < locations.length; i++) {
		marker = new google.maps.Marker({
		position: new google.maps.LatLng(locations[i][1], locations[i][2]),
		map: map
		});

		google.maps.event.addListener(marker, 'click', (function(marker, i) {
		return function() {
			infowindow.setContent(locations[i][0]);
			infowindow.open(map, marker);
		}
		})(marker, i));
		if (i == 0) request.origin = marker.getPosition();
		else if (i == locations.length - 1) request.destination = marker.getPosition();
		else {
		if (!request.waypoints) request.waypoints = [];
		request.waypoints.push({
			location: marker.getPosition(),
			stopover: true
		});
		}

	}
	directionsService.route(request, function(result, status) {
		if (status == google.maps.DirectionsStatus.OK) {
		directionsDisplay.setDirections(result);
		}
	});
	$.ajax({
		type: 'POST',
		url: 'guardar.php',
		data: {location: locations },
		dataType: 'html',
		success: function(respuesta) {
			//Accion 1
			//console.log(respuesta);
			//console.log("hola");
		}
	});	
	
	
}
$(document).ready(function(){
	$('#tabla').load('tabla.php');
});

function recargaTabla(){
	$('#tabla').load('tabla.php');
}


$(document).ready(function(){
	$('#actualiza').load('actualiza.php');
});
/*
function agregaForm(datos){
	d=datos.split('||');
	//alert();
	$('#primero1').val(d[0]);
	$('#segundo1').val(d[1]);
	$('#tercero1').val(d[2]);
	
	var pnt = {
		"primero1" : d[0],
		"segundo1" : d[1],
		"tercero1" : d[2],
	}

	

	$.ajax({
		type: 'GET',
		url: 'actualiza.php?p=1',
		data: { data: datos },
		dataType: 'html',
		success: function(respuesta) {
			//Accion 1
			console.log(respuesta);
			//console.log("hola");
		}
	});	
}*/

function modificaRuta(rutaId){
	$('#tabla').load('tabla.php?actualiza=1&rutaId='+rutaId);
}
function actualizaRuta(rutaId){

	punto1 = $('#primeroU').val();
	punto2 = $('#segundoU').val();
	punto3 = $('#terceroU').val();
	var ruta = {
		"ruta" : rutaId,
		"punto1" : punto1,
		"punto2" : punto2,
		"punto3" : punto3,
	}
	$.ajax({
		type: 'POST',
		url: 'actualiza.php',
		data: {rutas: ruta },
		dataType: 'html',
		success: function(respuesta) {
			//Accion 1
			//console.log(respuesta);
			//console.log("hola");
		}
	});
	$('#tabla').load('tabla.php');
}


function preguntaSiNo(id){
	alertify.confirm('Eliminar Ruta', '¿Esta seguro de eliminar esta ruta?', 
		function(){ eliminarDatos(id) }
	, function(){ alertify.error('Se canceló')});
}

function eliminarDatos(id){

	cadena="idRuta=" + id;

		$.ajax({
			type:"POST",
			url:"elimina.php",
			data:cadena,
			success:function(respuesta){
				//console.log(respuesta);
				if(respuesta==1){
					$('#tabla').load('tabla.php');
					alertify.success("Eliminado con exito!");
				}else{
					alertify.error("Fallo el servidor :(");
				}
			}
		});
}