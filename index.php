<?php

// Initialisierung
$error = $message = '';
$firstname = $lastname = $email = $username = '';

// Wurden Daten mit "POST" gesendet?
if($_SERVER['REQUEST_METHOD'] == "POST"){
  /** Ausgabe des gesamten $_POST Arrays zum debuggen
   * muss vor der Verwendung auskommentiert werden! */ 
  echo "<pre>";
  print_r($_POST);
  echo "</pre>";

  $firstname = isset($_POST['firstname']) ? trim($_POST['firstname']) : '' ;
  if ($firstname == "") {
    $error .= "Bitte geben Sie Ihren Vornamen ein.";
  } elseif (strlen($firstname) < 2) {
    $error .= "Der Vorname muss mindestens 2 Zeichen lang sein.";
  } elseif (strlen($firstname) > 30) {
    $error .= "Der Vorname darf maximal 30 Zeichen lang sein.";
  }
  $lastname = isset($_POST['lastname']) ? trim($_POST['lastname']) : '' ;
  if ($lastname == "") {
    $error .= "Bitte geben Sie Ihren Nachnamen ein.";
  } elseif (strlen($lastname) < 2) {
    $error .= "Der Nachname muss mindestens 2 Zeichen lang sein.";
  } elseif (strlen($lastname) > 30) {
    $error .= "Der Nachname darf maximal 30 Zeichen lang sein.";
  }
  $email = isset($_POST['email']) ? trim($_POST['email']) : '' ;
  if ($email == "") {
    $error .= "Bitte geben Sie Ihre Email-Adresse ein.";
  } elseif (strlen($email) < 5) {
    $error .= "Die Email-Adresse muss mindestens 5 Zeichen lang sein.";
  } elseif (strlen($email) > 100) {
    $error .= "Die Email-Adresse darf maximal 100 Zeichen lang sein.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error .= "Bitte geben Sie eine gültige Email-Adresse ein.";
  }
  $username = isset($_POST['username']) ? trim($_POST['username']) : '' ;
  if ($username == "") {
    $error .= "Bitte geben Sie Ihren Benutzernamen ein.";
  } elseif (strlen($username) < 6) {
    $error .= "Der Benutzername muss mindestens 6 Zeichen lang sein.";
  } elseif (strlen($username) > 30) {
    $error .= "Der Benutzername darf maximal 30 Zeichen lang sein.";
  } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
    $error .= "Der Benutzername darf nur aus Gross- und Kleinbuchstaben sowie Zahlen bestehen.";
  }
  $password = isset($_POST['password']) ? trim($_POST['password']) : '' ;
  if ($password == "") {
    $error .= "Bitte geben Sie Ihr Passwort ein.";
  } elseif (strlen($password) < 8) {
    $error .= "Das Passwort muss mindestens 8 Zeichen lang sein.";
  } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/', $password)) {
    $error .= "Das Passwort muss Gross- und Kleinbuchstaben, Zahlen und Sonderzeichen enthalten.";
  }



  /** TODO: Alle Benutzereingaben in Variablen speichern, damit sie im Formular wieder angezeigt werden können.z
   * alle Benutzereingaben gemäss Auftrag validieren
   * Variable vorhanden
   * nicht leer
   * minimale Länge
   * maximale Länge
   * 
   * sonst Fehlermeldung an Variable $error anhängen.
   * $error .= "Geben Sie bitte einen korrekten Vornamen ein";
   */

  // keine Fehler vorhanden
  if(empty($error)){
    $message = "Keine Fehler vorhanden";
  }
}



?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrierung</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  </head>
  <body>

    <div class="container">
      <h1>Registrierung</h1>
      <p>
        Bitte registrieren Sie sich, damit Sie diesen Dienst benutzen können.
      </p>
      <?php
        // Ausgabe der Fehlermeldungen
        if(strlen($error)){
          echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
        } elseif (strlen($message)){
          echo "<div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
        }
      ?>
      <form action="" method="post">
        <!-- TODO: Clientseitige Validierung: vorname -->
        <div class="form-group">
          <label for="firstname">Vorname *</label>
          <input type="text" name="firstname" class="form-control" id="firstname"
                  value="<?php echo htmlspecialchars($firstname) ?>" maxlength="30" required
                  placeholder="Geben Sie Ihren Vornamen an.">
        </div>
        <!-- TODO: Clientseitige Validierung: nachname -->
        <div class="form-group">
          <label for="lastname">Nachname *</label>
          <input type="text" name="lastname" class="form-control" id="lastname"
                  value="<?php echo htmlspecialchars($lastname) ?>" maxlength="30" required
                  placeholder="Geben Sie Ihren Nachnamen an">
        </div>
        <!-- TODO: Clientseitige Validierung: email -->
        <div class="form-group">
          <label for="email">Email *</label>
          <input type="email" name="email" class="form-control" id="email"
                  value="<?php echo htmlspecialchars($email) ?>" maxlength="100" required
                  placeholder="Geben Sie Ihre Email-Adresse an.">
        </div>
        <!-- TODO: Clientseitige Validierung: benutzername -->
        <div class="form-group">
          <label for="username">Benutzername *</label>
          <input type="text" name="username" class="form-control" id="username"
                  value="<?php echo htmlspecialchars($username) ?>" maxlength="30" required
                  placeholder="Gross- und Keinbuchstaben, min 6 Zeichen.">
        </div>
        <!-- TODO: Clientseitige Validierung: password -->
        <div class="form-group">
          <label for="password">Password *</label>
          <input type="password" name="password" class="form-control" id="password"
                  pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$"
                  minlength="8" required
                  placeholder="Gross- und Kleinbuchstaben, Zahlen, Sonderzeichen, min. 8 Zeichen, keine Umlaute">
        <button type="submit" name="button" value="submit" class="btn btn-info">Senden</button>
        <button type="reset" name="button" value="reset" class="btn btn-warning">Löschen</button>
      </form>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
</html>