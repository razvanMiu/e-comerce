<?php
include("includes/config.php");
include("includes/classes/Constants.php");
include("includes/classes/Account.php");
include("includes/script.php");

$account = new Account($con);

include("includes/handlers/login-handler.php");
logoutFunction();
?>

<!DOCTYPE html>
<html>

	<head>
		<title>Hai la Taraba!</title>

		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<script src="https://ajax.googleapis.com/ajax/libs/dojo/1.13.0/dojo/dojo.js"></script>
		<script src="assets/js/script.js"></script>

	</head>

	<body>

		<?php include("./includes/header.php") ?>
		<?php include("./includes/sidebar.php") ?>

    <div class="mainViewContainer">
      <div class="mainContent profileDiv">
          <h1>Details</h1>
          <?php
            $ui = $_SESSION['userID'];

            $q = mysqli_query($con,"SELECT U.firstName, U.lastName,U.adresa
                            FROM users U WHERE U.id = $_SESSION[userID]");
            $r = mysqli_fetch_array($q);
            echo "<p><span>First name:</span> ".$r['firstName']."</p>
                  <p><span>Last name:</span> ".$r['lastName']."</p>
                  <p><span>Adress:</span> ".$r['adresa']."</p>";
           ?>
          <hr class="borderStyle">
          <h1>Istoric comenzi</h1>
          <?php
            // Selecteaza comenziule utilizatorul autentificat
            $q2 = mysqli_query($con, "SELECT U.id, U.firstName, U.lastName,U.adresa,T.id,T.date,T.total
                                    FROM users U JOIN ticket T ON (T.users_ID = U.id)
                                    WHERE T.total not in (SELECT T1.total from ticket T1 Where T1.total = 0) AND U.id = $ui");
            while($r2 = mysqli_fetch_array($q2)) {
              echo "<p><span>Data comenzii:</span> ".$r2['date']."</p>
                    <p><span>Total:</span> ".$r2['total']." Lei</p>
                    <div class='produse'>";
              $t = $r2['id'];
              // Selecteaza produsele din cadrul unei comenzi efectuate de utilizatorul autentificat
              $q3 = mysqli_query($con, "SELECT T.id, sum(C.amount) as amount, C.price * sum(C.amount) as total, D.name
                                        FROM ticket T JOIN cart C ON (C.ticket_ID = T.id) JOIN devices D ON (D.id = C.devices_ID)
                                        WHERE T.users_ID in (SELECT U.id FROM users U WHERE U.id = $ui) AND T.id = $t
                                        GROUP BY T.id,C.devices_ID");
             while($r3 = mysqli_fetch_array($q3)) {
               echo "<div class='pComandat'>
                      <p><span>Nume produs:</span> ".$r3['name']."</p>
                      <p><span>Cantitate:</span> ".$r3['amount']."</p>
                      <p><span>Total:</span> ".$r3['total']."</p>
                    </div>";
             }
             echo "</div>";
            }
          ?>
          <hr class="borderStyle">
      </div>
    </div>

	</body>

</html>
