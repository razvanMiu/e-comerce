<?php

$GLOBALS['total'] = 0;
$GLOBALS['ok'] = true;

if(isset($_GET['abortButton'])) mysqli_query($con,"DELETE FROM cart WHERE ticket_ID = $ticketNumber");

?>



<div class="header">

  <div class="leftContainer">
    <div class="searchBar">
      <form action="index.php" method="GET">
        <input type="text" name="search" id="search" placeholder="Search">
        <button type="submit" id="searchButton"></button>
      </form>
    </div>
  </div>

  <div class="rightContainer">
    <?php
    $dropdownDiv = "accountDropdown";
    $dropdownDiv = json_encode($dropdownDiv, JSON_HEX_TAG, JSON_HEX_AMP);
    if(isset($_SESSION['userLoggedIn'])) {
      echo "<button id='accountButton' onclick='showToggle($dropdownDiv)'>
              <img src='assets/images/icons/user.png'>
              <p id='username'>Welcome " . $_SESSION['userLoggedIn'] . "</p>
              <img id='userArrow' src='assets/images/icons/dropdown-arrow.png'>
            </button>
            <div id='accountDropdown' class='dropdown-content'>
            " . (($_SESSION['userPrivilege'] == "Admin")?"<a href='admin-panel.php' id='adminPanel'>Admin Panel</a>":"") . "
              <a href='profile.php?id=".$_SESSION['userID']."' id='profilePanel'>Profile</a>
              <form action='index.php' method='GET'>

                <button name='logoutButton' id='logoutButton'>Log out</button>
              </form>
            </div>";

    } else {
      echo "<button id='accountButton' onclick='showToggle($dropdownDiv)'>
              <img src='assets/images/icons/user.png'>
              <p id='username'>My account</p>
              <img id='userArrow' src='assets/images/icons/dropdown-arrow.png'>
            </button>
            <div id='accountDropdown' class='dropdown-content'>
              <form id='loginForm' action='index.php' method='POST'>
                <h2>Log in to your account</h2>
                <p>
                  <label for='loginUsername'>Username</label>
                  <input type='text' name='loginUsername' placeholder='Username' id='loginUsername'></input>
                </p>

                <p>
                  <label for='loginPassword'>Password</label>
                  <input type='password' name='loginPassword' placeholder='Password' id='loginPassword'></input>
                </p>
                <button type='submit' name='loginButton'>LOG IN</button>
                <div class='hasAccountText'>
                  <a href='register.php'>Don't have an account yet? Signup here.</a>
                </div>
              </form>
            </div>";
    }
    ?>

    <button id="cart" name="cart" onclick="showToggle('cartDropdown')">
      <img src="assets/images/icons/cart.png">
    </button>
    <div id="cartDropdown" class="dropdown-content relative cartDiv">
      <ul>
      <?php
          //  Selectez produsele din cos pentru ticketul curent
          $query = mysqli_query($con,"SELECT D.name, C.price, sum(C.amount) as amount
                                      FROM cart C JOIN devices D ON (C.devices_ID = D.id)
                                      WHERE ticket_ID = '$ticketNumber'
                                      GROUP BY D.name");
          while($row3 = mysqli_fetch_array($query)) {
            echo "<li>
                    <p>".$row3['name']."</p><p>".$row3['amount']." Produse</p>
                  </li>";
            $total = $total + $row3['amount'] * $row3['price'];
          }
          //  Verific daca cantitatea excede stocul produselor din Cos
          $query2 = mysqli_query($con,"SELECT C.id,C.ticket_ID,C.devices_ID,sum(C.amount) as amount, C.price FROM cart C
                                      WHERE C.ticket_ID = $ticketNumber
                                      GROUP BY C.devices_ID
                                      HAVING SUM(C.amount) >ALL (SELECT D.stoc
                                                                 FROM devices D
                                                                 WHERE C.devices_ID = D.id)");
          if(mysqli_num_rows($query2)) {
            $ok = false;
          }
          echo "<p id='total'>Total: ".$total."</p>";
       ?>
     </ul>
     <form action="index.php" method="GET">
       <button type="submit" name="abortButton" id="abortButton">Abort</button>
       <button type="submit" name="buyButton" id="buyButton">Trimite comanda</button>
     </form>
    </div>
  </div>

</div>

<?php
  if(isset($_GET['buyButton'])) {
    $idd    = $_SESSION['userID'];
    $date   = date("Y-m-d h:i:s");

    if($ok) {
      //  Modifica stocul produselor comandate
      mysqli_query($con,"UPDATE devices D
                        SET stoc = stoc - (SELECT sum(C.amount) FROM cart C WHERE D.id = C.devices_ID AND C.ticket_ID = $ticketNumber group by C.devices_ID)
                        WHERE D.id in (SELECT C.devices_ID FROM cart C WHERE C.ticket_ID = $ticketNumber group by C.devices_ID)");
      mysqli_query($con,"INSERT INTO ticket VALUES (DEFAULT, '$idd', '$total', '$date')");
    } else {
        mysqli_query($con,"DELETE FROM cart WHERE ticket_ID = $ticketNumber");
        echo "<script>
              alert('Not enought devices in stoc!');
              window.location.reload();
            </script>";
    }
  }
?>
