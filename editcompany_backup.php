<?php
require_once 'php/include.php';
if (!$_SESSION['userid']) {
  header('Location: login.php');
  exit;
}
$uid = $_SESSION['userid'];
$cid = $_GET['id'];
$query = "SELECT * FROM User_Owned_Companies WHERE uid ='$uid' AND cid = '$cid'";

$results = $mysqli->query($query);
if ($results->num_rows != 1) {
  header('Location: '.$_SERVER['HTTP_REFERER']);
}
?>
<!doctype html>
<html lang="el-GR">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Αναζήτηση ε.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Επεξεργασία Επιχείρησης</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.min.css">
    <link rel="stylesheet" href="css/mdl-selectfield.min.css">
    <link rel="stylesheet" href="css/styles.css">
  </head>
<body class="register-login">
<style>
.mdl-layout__content {
  padding: 24px;
  flex: none;
} 
@media (min-width: 700px){
.mdl-shadow--6dp.mdl-card{
  min-width: 500px;
  text-align: center;
}
}
#photo_name{
  margin-top: 25px;
}
/* 
TODO:
File restriction of user is logged in  
*/

</style>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">

      <?php require_once 'php/nav.php'; ?>

  <main class="mdl-layout__content">
    <div class="mdl-card mdl-shadow--6dp">
      <div class="mdl-card__title mdl-color--primary mdl-color-text--white">
        <h2 class="mdl-card__title-text">Επεξεργασία Επιχείρησης</h2>
      </div>
        <div class="mdl-card__supporting-text">
        <form  accept-charset="utf-8" method="post" id="insert-form" action=""  enctype="multipart/form-data">
          <?php 
          $query = " SELECT fullname,userEmail FROM Users WHERE userId = '$uid'";
          $results = $mysqli->query($query);
          if ($results->num_rows > 0) {
            while($row = $results->fetch_array(MYSQL_ASSOC)) {
            ?>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input id="company_name" name="company_name" class="mdl-textfield__input" type="text" value="<?=$row['company_name']?>">
            <label class="mdl-textfield__label" for="company_name">Όνομα επιχείρησης</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <label style="text-align: left;display: inline-block;width: 100%;" for="type">Κατηγορία επιχείρησης</label>
            <select class="mdl-selectfield__select" id="type" multiple="multiple" size="10" name="type[]">
              <option value=""></option>
            </select>
          </div>
          <div id="addresswrap" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input id="route" name="route" class="mdl-textfield__input" type="text" value="<?=$row['company_name']?>">
            <label class="mdl-textfield__label" for="route">Διέυθυνση</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input id="street_number" name="street_number" class="mdl-textfield__input" type="text" value="<?=$row['company_name']?>">
            <label class="mdl-textfield__label" for="street_number">Αριθμός</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input id="locality" name="locality" class="mdl-textfield__input" type="text" value="<?=$row['company_name']?>">
            <label class="mdl-textfield__label" for="locality">Πόλη</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input id="postal_code" name="postal_code" class="mdl-textfield__input" type="text" value="<?=$row['company_name']?>">
            <label class="mdl-textfield__label" for="postal_code">Τ.Κ.</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input id="county" name="county" class="mdl-textfield__input" type="text" value="<?=$row['company_name']?>">
            <label class="mdl-textfield__label" for="county">Νομός</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input id="lat" name="lat" class="mdl-textfield__input" type="text" value="<?=$row['company_name']?>">
            <label class="mdl-textfield__label" for="lat">Γεωγραφικό πλάτος</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input id="lng" name="lng" class="mdl-textfield__input" type="text" value="<?=$row['company_name']?>">
            <label class="mdl-textfield__label" for="lng">Γεωγραφικό μήκος</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input id="photo_name" name="photo_name" class="mdl-textfield__input" type="file">
            <input id="userid" name="userid" value="<?=$_SESSION['userid']?>" type="hidden">
            <label class="mdl-textfield__label" for="photo_name">Εικόνα επιχείρησης</label>
          </div>
          <div id="map" style="width:400px;height:400px;">
          </div>
          <div id="p2" style="opacity: 0" class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
    <?php
  }
    $results->close();
} else{
  echo 'Wrong Company..<br>';
}
$mysqli->close();
?>
          <div id="response"></div>
          <div class="mdl-card__actions mdl-card--border" style="text-align: center;">
            <a href="index.php" class="mdl-button mdl-js-button mdl-button--primary">Άκυρο</a>
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--primary">
              <i class="material-icons">add_circle</i> Εισαγωγή
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
  <script src="js/functions.js"></script>
  <script src="js/insert.js"></script>
    <script>

      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        postal_code: 'short_name'
      };

      function initGoogleMapApi() {

        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        autocomplete.addListener('place_changed', fillInAddress);
        
        map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 37.726233, lng: 23.8021978},
                zoom: 5
            });
        
      }

      function fillInAddress() {
        $('#autocompletewrap').hide();
        $('#addresswrap').css('display', 'inline-block');;
        var place = autocomplete.getPlace();
        var lat = place.geometry.location.lat();
        var lng = place.geometry.location.lng();
        document.getElementById("lng").value = lng;
            $('#lng').parent().addClass('is-dirty');
        //$('#'+"lng").parent().addClass('is-dirty');
        //$('#'+"lat").parent().addClass('is-dirty');
        document.getElementById("lat").value = lat;
            $('#lat').parent().addClass('is-dirty');
        centerMap(lat,lng);
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
            $('#'+addressType).parent().addClass('is-dirty');
          }
        }
      }
      var map;
        var marker;
      function centerMap(lat , lng) {
          var title = $('#company_name').val();
            var newLatLng = new google.maps.LatLng(lat, lng);
            marker = new google.maps.Marker({
                position: newLatLng,
                zoom:16,
                map: map,
                title: title
            });
            map.setZoom(15);
            map.setCenter(newLatLng);
        }

    </script>
    
    
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSzQ33eKZJ9v3FuuvaxXbiLKc5_SWPEI8&libraries=places&callback=initGoogleMapApi&language=el&region=GR"
        async defer></script>
</body>
</html>
