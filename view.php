<?php 
include 'php/include.php';

$name = $_GET['company'];
$data = array();
$type = $_POST['type'];

$query="
SELECT * FROM Companies JOIN 
Address ON Address.id = Companies.id 
JOIN ( SELECT * FROM 
( SELECT company_id,GROUP_CONCAT(name) AS 'type' FROM Company_Type JOIN Types WHERE Types.id=Company_Type.type_id GROUP BY company_id )t1 
WHERE INSTR(t1.type, '".$type."')>0 )c_type 
ON c_type.company_id = Companies.id 

LEFT JOIN
(SELECT  company_id,SUM(rating)/ COUNT(rating) AS TotalRating 
FROM Company_Comments GROUP BY company_id) ratings
ON Companies.id=ratings.company_id

WHERE Companies.id = '$name'
";

$results = $mysqli->query($query);
if ($results->num_rows > 0) {
  while($row = $results->fetch_array(MYSQL_ASSOC)) {
    ?>
<!doctype html>
<html lang="el-GR">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?=$row['company_name']?> - <?php echo $row['address_name'] . ' ' . $row['number']?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title><?=$row['company_name']?></title>
<meta property="og:image" content="https://www.rigakis.info/rigakis2/php/uploads/<?=$row['photo_name']?>" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.min.css">
    <link rel="stylesheet" href="css/mdl-selectfield.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/comments.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
  </head>
<body>
<div class="demo-blog demo-blog--blogpost mdl-layout mdl-layout--fixed-header mdl-js-layout is-upgraded" >
      <?php require_once 'php/nav.php'; ?>

    <style>
.demo-blog .on-the-road-again .mdl-card__media {
  background-image: url('https://www.rigakis.info/rigakis2/php/uploads/<?=$row['photo_name']?>');
}
.demo-blog--blogpost .demo-blog__posts > .mdl-card .mdl-card__media {
  background-image: url('https://www.rigakis.info/rigakis2/php/uploads/<?=$row['photo_name']?>');
    background-position: center center;
    background-size: contain;
  background-repeat: no-repeat;
  height: 280px;
}
.mdl-card__media {
  background-color: transparent;
}
.demo-blog .mdl-card h3 {
  color :#000;
}
div.stars {
  width: 160px;
}
#comments-wrap {
  width: 100%;
  min-height: 500px;
}
input.star { display: none; }

label.star {
  float: right;
  padding: 2px;
  font-size: 27px;
  color: #444;
  transition: all .2s;
}

input.star:checked ~ label.star:before {
  content: '\E838';
  color: #FD4;
  transition: all .25s;
}

input.star-5:checked ~ label.star:before {
  color: #FE7;
  text-shadow: 0 0 20px #952;
}

input.star-1:checked ~ label.star:before { color: #F62; }

label.star:before {
  content: '\E83A';
  font-family: Material Icons;
}
.comments-text {
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-flex-direction: row;
  -ms-flex-direction: row;
  flex-direction: row;
  margin-bottom: 16px;
  -webkit-align-items: center;
  -ms-align-items: center;
  align-items: center;
}
.demo-blog--blogpost .comments > form {
  -webkit-flex-direction: column;
  -ms-flex-direction: column;
  flex-direction: column;
}
.map-wrap,#map{
  width: 100%;
  height: 600px;

}


    </style>
	<main class="mdl-layout__content">
        <div class="demo-blog__posts mdl-grid">
          <div class="company mdl-card mdl-shadow--4dp mdl-cell mdl-cell--12-col" data-compimg="<?=$row['photo_name']?>" data-lat="<?=$row['lat']?>" data-lng="<?=$row['lng']?>" data-maptitle="<?=$row['company_name']?>">
            <div class="mdl-card__media mdl-color-text--grey-50">
              <h3><?=$row['company_name']?></h3>
            </div>
            <div class="mdl-color-text--grey-700 mdl-card__supporting-text meta">
              <div class="insert-rating" id="insert-rating-<?=$row['id']?>"><div id="p1-<?=$row['id']?>" class="mdl-spinner mdl-spinner--single-color mdl-js-spinner is-active"></div></div>
              <div class="section-spacer"></div>
              <div class="meta__favorites">
              <?php if ($_SESSION['userid']): ?>
                <?php if (isFavorite($row['id'])): ?>
                  <a id="fav-<?=$row['id']?>" href="javascript:addFav(<?=$row['id']?>)"><i class="material-icons">favorite</i></a>
                  <?php else: ?>
                  <a id="fav-<?=$row['id']?>" href="javascript:addFav(<?=$row['id']?>)"><i class="material-icons">favorite_border</i></a>
                <?php endif ?>
              <?php endif ?>
              </div>
              <div>
              <?php 
$url =  "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

$escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );

               ?>
                <a class="fb-share" href="https://www.facebook.com/sharer/sharer.php?u=<?=$escaped_url?>"><i class="material-icons" role="presentation">share</i></a>
              </div>
            </div>
            <div class="mdl-color-text--grey-700 mdl-card__supporting-text">
            <p class="type">Κατηγορία: <?=$row['type']?></p>
            <p class="address">Διέθυνση: <?php echo $row['address_name'] . ' ' . $row['number']?></p>
            <p class="city">Πόλη: <?php echo $row['city']?></p>
            <p class="city">Νομός: <?php echo $row['county']?></p>
            <p class="city">Τ.Κ.: <?php echo $row['zip']?></p>
            <button onclick="getDirections('<?=$row['lat']?>','<?=$row['lng']?>')">Get Directions</button>
            <div class="map-wrap" style="margin-left: -50px;">  
              <div id="map"></div>
            </div>
            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect" onclick="toggleFullScreen()"><i class="material-icons">fullscreen</i></button>
            </div>

          </div>
          <div id="comments-wrap">
            <div id="p2" style="display: none;" class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
            
          </div>
        </div>
  </main>

    <?php
  }
    $results->close();
} else{
  echo 'Wrong company id ';
}

        ?>



</div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
	<script src="js/mdl-selectfield.min.js"></script>
	<script src="js/functions.js"></script>
	<script src="js/search.js"></script>

	<script type="text/javascript">
  function initMap(){
		var companies = document.getElementsByClassName('company');
		var companytitle = document.getElementsByClassName('business-title');
	    var marker, i;
		var map = new google.maps.Map(document.getElementById('map'), {
		  zoom: 17,
      scrollwheel: true,
		  mapTypeControl: false,
		  center: new google.maps.LatLng(companies[0].dataset.lat , companies[0].dataset.lng),
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		for (i = 0; i < companies.length; i++) {
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(companies[i].dataset.lat, companies[i].dataset.lng),
				map: map
			});
	    var infowindow = new google.maps.InfoWindow();
		google.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {
			  infowindow.setContent('<div class="map-infowindow"><h4>'+companies[i].dataset.maptitle+'</h4>'+'<p>Διεύθυνση: Μπλαμπλάμπα 22<br>Τηλ: 2810347293</p><p><button onclick="getDirections('+companies[i].dataset.lat+','+companies[i].dataset.lng+')">Get Directions</button></p>');
			  infowindow.open(map, marker);
			}
		})(marker, i));
	    }
	}
	function getDirections(lat,lng){
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
			var map = new google.maps.Map(document.getElementById('map'), {
			  zoom: 11,
			  mapTypeControl: false,
			  center: new google.maps.LatLng(position.coords.latitude , position.coords.longitude),
			  mapTypeId: google.maps.MapTypeId.ROADMAP
			});
		    directionsService = new google.maps.DirectionsService,
		    directionsDisplay = new google.maps.DirectionsRenderer({
		      map: map
		    }),			
            map.setCenter(pos);
            var pointA = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
            var pointB = new google.maps.LatLng(lat,lng);
  			calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB);
          }, function() {
          	alert('error on getting directions')
          });

        } else {
          alert('Browser doesnt support Geolocation')
        }

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


	function fillFields(name){
		if (getParameterByName(name) != null) {
			console.log(getParameterByName(name));
			document.getElementById(name).value = getParameterByName(name);
		}
	}
	fillFields('name');
	fillFields('type');
	if (getParameterByName('name') != null || getParameterByName('type') != null) {
		$('#searchform').submit();
	}
    <?php if (isset($_SESSION['userid'])) {
     $userid = $_SESSION['userid'];
    } else{
      $userid = '0';
    }?>

  $(document).ready(function(){
    getRating(<?=$_GET['company']?>);
    getComments(<?=$_GET['company']?>,<?=$userid?>);
  }); 
$('#form-insert-comment').on('submit', function(e) {
  e.preventDefault();
  var data = $(this).serialize();
  $.ajax({
    dataType: 'json',
    crossOrigin: true,
    url: 'https://www.rigakis.info/rigakis2/php/insert-rating.php',
    method: 'get',
    data: data,
    cache:false,
    success: function(data) {
      // $('#p2').css('opacity', '0');
      $('#response').empty();
      if (data['error']) { 
        $('#form-insert-comment').html('<span class="error">'+data['error']+'</span>');
      }
      if (data['success']) {
        getRating(<?=$_GET['company']?>);
      }
    },
    error: function(xhr, status, error) {
      // $('#p2').css('opacity', '0');
      alert(xhr.responseText);
    }
  });
});//submit form


$(document).ready(function() {
    $('.fb-share').click(function(e) {
        e.preventDefault();
        window.open($(this).attr('href'), 'fbShareWindow', 'height=450, width=550, top=' + ($(window).height() / 2 - 275) + ', left=' + ($(window).width() / 2 - 225) + ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
        return false;
    });
});


  </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSzQ33eKZJ9v3FuuvaxXbiLKc5_SWPEI8&libraries=places&callback=initMap&language=el&region=GR"
        async defer></script>
</body>
</html>