<?php
require_once 'php/include.php';
?>
<!doctype html>
<html lang="el-GR">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Αναζήτηση ε.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Results</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.min.css">
    <link rel="stylesheet" href="css/mdl-selectfield.min.css">
    <link rel="stylesheet" href="css/styles.css">
  </head>
<body>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">

      <?php require_once 'php/nav.php'; ?>

	<main class="mdl-layout__content">
		<div class="mdl-grid">
		  <div class="mdl-cell mdl-cell--3-col no-margin">
            <div class="resultsSideBar" id="resultsBar0">	
                 <button type="button" id="button0" onclick="SortSearchDataDistanceAsc();">Dist A</button> 
                  <button type="button" id="button1" onclick="SortSearchDataDistanceDesc();">Dist D</button>
                  <button type="button" id="button2" onclick="SortSearchDataDurationAsc();">Dur A</button>
                  <button type="button" id="button3" onclick="SortSearchDataDurationDesc();">Dur D</button>
                  <button type="button" id="button4" onclick="SortSearchDataCompanyTitleAsc();">Title A</button>
                  <button type="button" id="button5" onclick="SortSearchDataCompanyTitleDesc();">Title D</button>
                <div class="results">	
                </div>
            </div>
		  </div>
		  <div class="mdl-cell mdl-cell--9-col map-column no-margin">
			<div class="map-wrap">	
				<div id="map"></div>
				<div class="search-map">
					<form id="searchform" action="../php/login.php" method="POST">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input id="name" name="name" class="mdl-textfield__input" type="text">
						<label class="mdl-textfield__label" for="name">Όνομα</label>
					</div>
					<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label">
						<select class="mdl-selectfield__select" id="type" name="type">
							<option value=""></option>
						</select>
						<div class="mdl-selectfield__icon"><i class="material-icons">arrow_drop_down</i></div>
						<label class="mdl-selectfield__label" for="type">Κατηγορία</label>
					</div>
					<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--primary">
						<i class="material-icons">search</i> Αναζήτηση
					</button>
					</form>
				</div>	
			</div>
		  </div>
		</div>
	</main>
</div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
	<script src="js/mdl-selectfield.min.js"></script>
	<script src="js/functions.js"></script>
	<script src="js/search.js"></script>

	<script type="text/javascript">
	var userPosition,map,infoWindow,distanceService ;
	var geolocationEnabled = false;
	var user_marker;
	var markers=[]; 
	var search_data=[];
	function initMap() {
        createSearchData();
        //printSearchData();
        addDistances('DRIVING');
	}
	function initMap2() {
        map = new google.maps.Map(document.getElementById('map'), {
		  zoom: 11,
		  center: new google.maps.LatLng(32, 24),
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		
        
         if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            userPosition = new google.maps.LatLng(position.coords.latitude , position.coords.longitude);
            map.setCenter(userPosition);
            geolocationEnabled = true;
            var markerIcon = new google.maps.MarkerImage(
                    "human_icon.png",
                    null, /* size is determined at runtime */
                    null, /* origin is 0,0 */
                    null, /* anchor is bottom center of the scaled image */
                    new google.maps.Size(42, 68)
            );
                    
            user_marker = new google.maps.Marker({
				position: userPosition,
				map: map
				// ,icon:"human_icon.png"
				,icon:markerIcon
			});
          }, function() {
          	alert('error on getting position');
          });

        } else {
          alert('Browser doesnt support Geolocation');
        }
        distanceService = new google.maps.DistanceMatrixService;
	}

function createSearchData(){
        deleteSearchData();
        
        var companies = document.getElementsByClassName('company');
		var companylogo = document.getElementsByClassName('business-logo');
		var ratings = document.getElementsByClassName('insert-rating');
		var address = document.getElementsByClassName('address');
		var types = document.getElementsByClassName('type');
		var companytitle = document.getElementsByClassName('business-title');
		var details = document.getElementsByClassName('details');
		var distances = document.getElementsByClassName('distance');
		var durations = document.getElementsByClassName('duration');
		var favorites = document.getElementsByClassName('favorite');
		
		
		var cities = document.getElementsByClassName('city');
	    var marker , search_data_element;
		for (var i = 0; i < companies.length; i++) {
            var favorite = null;
            var favorite_type=null;
            if (favorites.length>0)  {
                favorite=favorites[i].href;
                favorite_type=favorites[i].getElementsByTagName("i")[0].innerHTML;
            }
			search_data_element={
                company:{
                            lat:companies[i].dataset.lat,
                            lng:companies[i].dataset.lng,
                            maptitle:companies[i].dataset.maptitle
                                },
                companylogo:companylogo[i].src,
                address:address[i].innerHTML,
                rating:ratings[i].id,
                type:types[i].innerHTML,
                city:cities[i].innerHTML,
                favorite:favorite,
                favorite_type:favorite_type,
                companytitle:companytitle[i].innerHTML,
                marker:null,
                detail:details[i].getElementsByTagName("a")[0].href,
                distance:0,
                duration:0
            };
            if (distances[i]) search_data_element.distance=distances[i].innerHTML;
            if (durations[i]) search_data_element.duration=durations[i].innerHTML;
            search_data.push(search_data_element);
	    }
	    updateMarkers();
}


function addMarkersToMap(){
console.log("addMarkersToMap()");
	    var marker, i , markerPos;
	    
		for (var i = 0; i < search_data.length; i++) {
            markerPos = new google.maps.LatLng(search_data[i].company.lat, search_data[i].company.lng);
			marker = addMarker(markerPos);
			search_data[i].marker=marker;
            var infowindow = new google.maps.InfoWindow();
            var search_data_element = search_data[i];
		google.maps.event.addListener(marker, 'click', (function(marker, search_data_element) {
			return function() {
			  infowindow.setContent('<div class="map-infowindow"><img class="img-responsive" src="'+search_data_element.companylogo+'" alt="'+search_data_element.companytitle+'" /><h4>'+search_data_element.company.maptitle+'</h4>'+'<p>Διεύθυνση: '+search_data_element.address+'</p><p><button onclick="getDirections('+search_data_element.company.lat+','+search_data_element.company.lng+')">Get Directions</button></p>');
			  infowindow.open(map, marker);
			}
		})(marker, search_data_element));
	    }
}

/**

/**/

function getDirections(lat,lng){
        console.log("getDirections caller is:"+this.name);
        if (geolocationEnabled) {
		    directionsService = new google.maps.DirectionsService,
		    directionsDisplay = new google.maps.DirectionsRenderer({
		      map: map
		    });	
            directionsDisplay.setOptions( { suppressMarkers: true } );
            map.setCenter(userPosition);
            //var pointA = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
            var pointA = new google.maps.LatLng(lat,lng);
  			calculateAndDisplayRoute(directionsService, directionsDisplay, userPosition, pointA);
			}
			else{
                alert("Geolocation is not enabled.");
			}
}
      
function updateMarkers(){
    deleteMarkers();
    addMarkersToMap();
}
// Adds a marker to the map and push to the array.
      function addMarker(location) {
        var marker = new google.maps.Marker({
          position: location,
          map: map
        });
        markers.push(marker);
        return marker;
      }

      // Sets the map on all markers in the array.
      function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
      }

      // Removes the markers from the map, but keeps them in the array.
      function clearMarkers() {
        setMapOnAll(null);
      }

      // Shows any markers currently in the array.
      function showMarkers() {
        setMapOnAll(map);
      }

      // Deletes all markers in the array by removing references to them.
      function deleteMarkers() {
        clearMarkers();
        markers = [];
      }

    function deleteSearchData() {
        deleteMarkers();
        search_data = [];
      }
    
    function SortSearchDataDistanceAsc(){
        search_data.sort(function(a, b) {
            return parseFloat(a.distance.value) - parseFloat(b.distance.value);
        });
        updateSearchResultsBar();
    }
    
    function SortSearchDataDistanceDesc(){
        search_data.sort(function(a, b) {
            return parseFloat(b.distance.value) - parseFloat(a.distance.value);
        });
        updateSearchResultsBar();
    }
    
    function SortSearchDataDurationAsc(){
        search_data.sort(function(a, b) {
            return parseFloat(a.duration.value) - parseFloat(b.duration.value);
        });
        updateSearchResultsBar();
    }
    
    function SortSearchDataDurationDesc(){
        search_data.sort(function(a, b) {
            return parseFloat(b.duration.value) - parseFloat(a.duration.value);
        });
        updateSearchResultsBar();
    }
    
    
    function SortSearchDataCompanyTitleDesc(){
        search_data.sort(function(a, b) {
            var result= b.companytitle.localeCompare(a.companytitle);
            return result;
        });
        updateSearchResultsBar();
    }
    
    function SortSearchDataCompanyTitleAsc(){
        search_data.sort(function(a, b) {
            var result= a.companytitle.localeCompare(b.companytitle);
            return result;
        });
        updateSearchResultsBar();
    }
	
function calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB) {
  directionsService.route({
    origin: pointA,
    destination: pointB,
    travelMode: google.maps.TravelMode.DRIVING
  }, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });
}


function addDistances(travelmode){
    var companiesCoord=new Array();
    for (var i = 0; i < search_data.length; i++) {
        companiesCoord.push( new google.maps.LatLng(search_data[i].company.lat, search_data[i].company.lng) );
    }
    var userCoord = new Array();
    userCoord.push(userPosition);
    distanceService.getDistanceMatrix({
          origins: userCoord,
          destinations: companiesCoord,
          travelMode: travelmode,
          unitSystem: google.maps.UnitSystem.METRIC,
          avoidHighways: false,
          avoidTolls: false
        }, function(response, status) {
          if (status !== 'OK') {
            console.log('Error was: ' + status);
          } else {
            var origins = response.originAddresses;
            var destinations = response.destinationAddresses;
            var details = document.getElementsByClassName('details');
            for (var i = 0; i < origins.length; i++) {
                var results = response.rows[i].elements;
                
                for (var j = 0; j < results.length; j++) {
                    
                    var element = results[j];
                    if(element.status=="OK"){
                        //console.log("distance:"+distance );
                        var distance = element.distance;
                        var duration = element.duration;
                        search_data[j].duration=duration;
                        search_data[j].distance=distance;
                        var innerDistance = document.createElement('p');
                        innerDistance.className = 'distance';
                        innerDistance.innerHTML = search_data[j].distance.text;
                        var innerDuration = document.createElement('p');
                        innerDuration.className = 'duration';
                        innerDuration.innerHTML = search_data[j].duration.text;
                        //details[j].appendChild(innerDuration);
                        details[j].insertBefore(innerDuration,details[j].lastElementChild);
                        //details[j].appendChild(innerDistance);
                        details[j].insertBefore(innerDistance,details[j].lastElementChild);
                    }
                }
            }
            //printSearchData();
            //SortSearchDataDistanceAsc();
            //printSearchData();
            // createSearchResultsBar();
          /**/  
          }
        });
}

function updateSearchResultsBar(){
console.log("updateSearchResultsBar");
    var html = "";
    for (var i = 0; i < search_data.length; i++) {
		var id = search_data[i].rating ;
		var lastIndex = id.lastIndexOf("-");
		var substr=id.substr(lastIndex+1);
        
    html += "<div  class='company' data-lat='"+search_data[i].company.lat+"' data-lng='"+search_data[i].company.lng+"' data-maptitle='"+search_data[i].company.maptitle+"'>";
    html +="<div id='p1-"+substr+"' class='mdl-spinner mdl-spinner--single-color mdl-js-spinner is-active'></div><div class='insert-rating' id='insert-rating-"+substr+"'></div>";
    if(search_data[i].favorite) html +=" <a class='favorite' id='fav-"+substr+"' href='javascript:addFav("+substr+")'><i class='material-icons'>"+search_data[i].favorite_type+"</i></a>";
      html +="<div class=image>";
        html +="<img class='img-responsive business-logo' src='"+search_data[i].companylogo+"'>";
      html +="</div>";
      html +="<div class=details>";
        html +="<h4 class='business-title'>"+search_data[i].companytitle+"</h4>";
        html +="<p class='type'>"+search_data[i].type+"</p>";
        html +="<p class='address'>"+search_data[i].address+"</p>";
        html +="<p class='city'>"+search_data[i].city+"</p>";
        html +="<p class='duration'>"+search_data[i].duration.text+"</p>";
        html +="<p class='distance'>"+search_data[i].distance.text+"</p>";
        html +="<a href='"+search_data[i].detail+"'>Λεπτομέριες</a>";
      html +="</div>";
    html +="</div>";

		html +="<script type='text/javascript'>";
		html += "getRating("+substr+");" ;
		html +="<\/script>";
		/**/
    }
    /**/
    //printSearchData();
    $('.results').empty();
    $('.results').html(html);
    //createSearchData();
    //printSearchData();
    //console.log("updateSearchResultsBar end");
}


	function fillFieldName(){
		if (getParameterByName("name") != null) {
			console.log(getParameterByName("name"));
			document.getElementById("name").value = getParameterByName("name");
		}
	}
	function fillFieldType(){
		if (getParameterByName("type") != null) {
			console.log(getParameterByName("type"));
			document.getElementById("type").value = getParameterByName("type");
		}
	}
	fillFieldName();
	fillFieldType();
	
	if (getParameterByName('name') != null || getParameterByName('type') != null) {
		$('#searchform').submit();
	}

	function printSearchData(){
    for (var i = 0; i < search_data.length; i++) {
        console.log("search_data["+i+"].companytitle:"+search_data[i].companytitle);
        console.log("search_data["+i+"].distance:"+search_data[i].distance.text);
        console.log("search_data["+i+"].duration:"+search_data[i].duration.text);
        if(search_data[i].marker) console.log("search_data["+i+"].marker.position:"+search_data[i].marker.position);
        console.log("search_data["+i+"].address:"+search_data[i].address);
        }
    }
	
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSzQ33eKZJ9v3FuuvaxXbiLKc5_SWPEI8&callback=initMap2" async defer></script>
</body>
</html>
