<?php
require_once 'php/include.php';
if (!$_SESSION['userid']) {
  header('Location: login.php');
  exit;
}
?>
<!doctype html>
<html lang="el-GR">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Αναζήτηση ε.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Register</title>

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

</style>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">

<?php require_once 'php/nav.php'; ?>
  <main class="mdl-layout__content">
    <div class="mdl-card mdl-shadow--6dp">
      <div class="mdl-card__title mdl-color--primary mdl-color-text--white">
        <h2 class="mdl-card__title-text">Επεξεργασία Λογαριασμού</h2>
      </div>
        <div class="mdl-card__supporting-text">
        <form method="post" id="updateprofile-form" action="#">
          <div id="p2" style="opacity: 0" class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
          <?php 
          $uid = $_SESSION['userid'];
          $query = " SELECT fullname,userEmail FROM Users WHERE userId = '$uid'";
          $results = $mysqli->query($query);
          if ($results->num_rows > 0) {
            while($row = $results->fetch_array(MYSQL_ASSOC)) {
            ?>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty">
            <input id="fullname" name="fullname" class="mdl-textfield__input" value="<?=$row['fullname']?>" required type="fullname">
            <label class="mdl-textfield__label" for="fullname">Ονοματεπώνυμο</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty">
            <input id="email" name="email" class="mdl-textfield__input" value="<?=$row['userEmail']?>" required type="email">
            <label class="mdl-textfield__label" for="email">Email</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input id="password" name="password" class="mdl-textfield__input" required type="password">
            <label class="mdl-textfield__label" for="password">Νέος Κωδικός</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input id="passwordagain" name="passwordagain" class="mdl-textfield__input" required type="password">
            <label class="mdl-textfield__label" for="passwordagain">Επαλήθευση νέου κωδικού</label>
          </div>
    <?php
  }
    $results->close();
} else{
  echo 'Wrong User..<br>';
}
$mysqli->close();
?>
          <div id="response"></div>
          <div class="mdl-card__actions mdl-card--border" style="text-align: center;">
            <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--primary">
              <i class="material-icons">group_add</i> Ανανέωση
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
  <script src="js/register.js"></script>
</body>
</html>