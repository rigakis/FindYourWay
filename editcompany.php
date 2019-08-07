<?php
require_once 'php/include.php';
if (!$_SESSION['userid']) {
  header('Location: login.php');
  exit;
}
$uid = $_SESSION['userid'];
$cid = $_GET['id'];
$query1 = "SELECT * FROM User_Owned_Companies WHERE uid ='$uid' AND cid = '$cid'";

$results1 = $mysqli->query($query1);
if ($results1->num_rows != 1) {
  header('Location: '.$_SERVER['HTTP_REFERER']);
}





$categories = array();
$query2 = "SELECT id, name FROM Types";
$results2 = $mysqli->query($query2);
if ($results2->num_rows > 0) {
	while($row2 = $results2->fetch_array(MYSQL_ASSOC)) {
		$categories['id'][] .= $row2['id'];
		$categories['name'][] .= $row2['name'];
		$categories['class'][] .= null;
	}
}




$company_categories = array();
$query3 = "SELECT company_id, type_id FROM Company_Type WHERE company_id = '$cid'";
$results3 = $mysqli->query($query3);
if ($results3->num_rows > 0) {
	while($row3 = $results3->fetch_array(MYSQL_ASSOC)) {


		$company_categories[] .= $row3['type_id'];
	}
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

#current-img-text {
	color: #3f51b5;
	text-align: left;
	line-height: 18px;
	margin-bottom: 0px;
}
#current-img {
	max-width: 100%;
	height: auto;
}
</style>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">

      <?php require_once 'php/nav.php'; ?>

  <main class="mdl-layout__content">
    <div class="mdl-card mdl-shadow--6dp">
      <div class="mdl-card__title mdl-color--primary mdl-color-text--white">
        <h2 class="mdl-card__title-text">Επεξεργασία Επιχείρησης</h2>
      </div>
        <div class="mdl-card__supporting-text">
        <form  accept-charset="utf-8" method="post" id="update-company-form" action=""  enctype="multipart/form-data">
          <?php 
$query="
SELECT * FROM Companies JOIN 
Address ON Address.id = Companies.id 


WHERE Companies.id = '$cid'
";
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
            <select class="mdl-selectfield__select" id="edittype" multiple="multiple" size="10" name="type[]">
				<?php 
				 
				for ($i=0; $i <= count($categories['id']); $i++) {
					if (in_array($categories['id'][$i], $company_categories)) {
						echo '<option value="'.$categories['name'][$i].'" selected >'.$categories['name'][$i].'</option>';
					}else{ 
						echo '<option value="'.$categories['name'][$i].'">'.$categories['name'][$i].'</option>';
					}
				}
				 ?>
            </select>
          </div>
          <div id="autocompletewrap" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input id="route" name="route" class="mdl-textfield__input" type="text" value="<?=$row['address_name']?>">
            <label class="mdl-textfield__label" for="route">Διέυθυνση</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input id="street_number" name="street_number" class="mdl-textfield__input" type="text" value="<?=$row['number']?>">
            <label class="mdl-textfield__label" for="street_number">Αριθμός</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input id="locality" name="locality" class="mdl-textfield__input" type="text" value="<?=$row['city']?>">
            <label class="mdl-textfield__label" for="locality">Πόλη</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input id="postal_code" name="postal_code" class="mdl-textfield__input" type="text" value="<?=$row['zip']?>">
            <label class="mdl-textfield__label" for="postal_code">Τ.Κ.</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input id="county" name="county" class="mdl-textfield__input" type="text" value="<?=$row['county']?>">
            <label class="mdl-textfield__label" for="county">Νομός</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input id="lat" name="lat" class="mdl-textfield__input" type="text" value="<?=$row['lat']?>">
            <label class="mdl-textfield__label" for="lat">Γεωγραφικό πλάτος</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input id="lng" name="lng" class="mdl-textfield__input" type="text" value="<?=$row['lng']?>">
            <label class="mdl-textfield__label" for="lng">Γεωγραφικό μήκος</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
          	<div id="map" style="width:100%;height:400px;"></div>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
	
            <input id="photo_name" name="photo_name" class="mdl-textfield__input" type="file">
            <input id="cid" name="cid" value="<?=$cid?>" type="hidden">
            <label class="mdl-textfield__label" for="photo_name">Αλλαγή εικόνας επιχείρησης</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty">
          	<div id="img-wrap">
            	<p id="current-img-text">Υπάρχουσα Εικόνα</p>
          		<img id="current-img" src="php/uploads/<?=$row['photo_name']?>" alt="<?=$row['company_name']?>">
          	</div>
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
            <button name="submit" value="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--primary">
              <i class="material-icons">add_circle</i> Επεξεργασία
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


    <script>
      	var clat = parseFloat(document.getElementById('lat').value);
      	var clng = parseFloat(document.getElementById('lng').value);
      	console.log(clat);
      	console.log(clng);
      	var title = document.getElementById('company_name').value;


var marker;

function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 17,
    center: {lat: clat, lng: clng}
  });

  marker = new google.maps.Marker({
    map: map,
    draggable: true,
    animation: google.maps.Animation.DROP,
    position: {lat: clat, lng: clng}
  });
  marker.addListener('position_changed', printMarkerLocation);
}

function printMarkerLocation(){
	document.getElementById('lat').value = marker.position.lat();
	document.getElementById('lng').value = marker.position.lng();
}



    


    </script>
<script>
	$(document).ready(function() {
		$('.company-image').addClass('is-dirty');
		$('#photo_name').change(function() {
			var name = $('#photo_name').val();
			$('#current-img').hide();
			$('#current-img-text').text('Η εικόνα '+name+' έχει επιλεχθεί. Η προεπισκόπηση της θα πραγματοποιηθή μετά την επιτυχή επεξεργασία.')
		});
	});

</script>
    
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSzQ33eKZJ9v3FuuvaxXbiLKc5_SWPEI8&libraries=places&callback=initMap&language=el&region=GR"
        async defer></script>
</body>
</html>
