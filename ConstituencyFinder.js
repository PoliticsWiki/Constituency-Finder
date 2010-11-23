
var SavedMarker;
			
$(document).ready(function(){
	$( "input:submit" ).button();
	$('#popup').dialog({ autoOpen: false, width:600, title: 'Is this where you live? If not then move the red marker to where you live' });
	$( "#accordion" ).accordion({collapsible: true,autoHeight: false});
	$("#addressForm").validate({
	  rules: {
		county: {required: true},
		town: {required: true}
	  }
	});
});

function AddMarker(map, coord)
{
	
	SavedMarker = new GMarker(coord, {draggable: true});
	
	var markerText = "Where you live";
	
	GEvent.addListener(SavedMarker, "dragstart", function() {
		SavedMarker.closeInfoWindow();
	});
	GEvent.addListener(SavedMarker, "dragend", function() {
		SavedMarker.openInfoWindowHtml(markerText);
	});
	map.addOverlay(SavedMarker); 
}

function ConfirmCoordinates(coord) {
	$('#popup').dialog('open');
	// Setup the google map
	if (GBrowserIsCompatible()) {
		var map = new GMap2(document.getElementById("map"));
		map.setCenter(coord,13);
		map.setUIToDefault();
		AddMarker(map, coord);
	}
}

function GetCoordinateFromAddress() {
	if(!$("#addressForm").validate().form()) return false;
	var line1 = $('#addressLine1').val().length > 0?$('#addressLine1').val() + ", ":"";
	var line2 = $('#addressLine2').val().length > 0?$('#addressLine2').val() + ", ":"";
	var address = line1 + line2 + $('#town').val() + ", County " + $('#county').val() + ", Ireland";
	$.getJSON("http://maps.google.com/maps/geo?q="+ address+"&region=ie&sensor=false&key=ABQIAAAAVZXUw4haIbsMG3nOaLlhrBTd6_saw5G7NbyQ9jAg4rzW0CWcoBQI6jPhyQxFcmtLquX2a9j4-0hHwg&output=json&callback=?",
		function(data, textStatus){
			try
			{
				var latLng = new GLatLng(data.Placemark[0].Point.coordinates[1], data.Placemark[0].Point.coordinates[0]);
				ConfirmCoordinates(latLng);
			}
			catch(err)
			{
				alert("Unable to get coordinates from the address provided");
			}
		}
	);
	return false;
}

function IsCoordinateInPolygon(placemark, coordinate) {
	var coords = $(placemark).find('coordinates').text().split(" ");
	var points =new Array();
	for(var i = 0; i< coords.length;i++)
	{
		var coord = coords[i].split(",");
		points[i] = new GLatLng(coord[1],coord[0]);
	}
	var polygon = new GPolygon(points, "#000000", 1, 1, "#336699", 0.3);
	return polygon.containsLatLng(coordinate);
}

function FindConstituencyId(xml, coordinate)
{
	var placemarks = $(xml).find('Placemark');
	for(var j = 0; j < placemarks.length; j++)
	{
		var id = $(placemarks[j]).find('name').text();
		if(IsCoordinateInPolygon(placemarks[j],coordinate))
		{
			return id;
		}
	}
	alert("Error finding constituency");
}

function RedirectToConstituency()
{
	$.ajax({
		type: "GET",
		url: wgServer + wgScriptPath + "/extensions/ConstituencyFinder/IRE-DAIL-2012.xml",
		error: function(XMLHttpRequest, textStatus, errorThrown) 
		{
			alert(errorThrown);
		},
		success: function(xml) {
			var id = FindConstituencyId(xml, SavedMarker.getLatLng()).replace(" ","_");
			window.location = wgServer + wgScriptPath + wgArticlePath.replace("$1",id) +  "_(D%C3%A1il_%C3%89ireann_constituency)";
		}
	});
}