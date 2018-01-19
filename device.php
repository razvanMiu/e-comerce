<?php
include("includes/config.php");
include("includes/classes/Constants.php");
include("includes/classes/Account.php");
include("includes/script.php");

$account = new Account($con);

include("includes/handlers/login-handler.php");

if(isset($_GET['id'])) {
    $deviceID = $_GET['id'];
    $deviceQuery = deviceDetailsQuery($con,$deviceID);
    $row = mysqli_fetch_array($deviceQuery);
    $status = getColor($row['stoc']);
} else {
    header("Location: index.php");
}
$query = mysqli_query($con,"SELECT COUNT(*) as ticketOrder FROM ticket");
$row2 = mysqli_fetch_array($query);
$ticketNumber = $row2['ticketOrder'] + 1;

if(isset($_POST['amountButton'])) {
  addCart($con,$row['id'],$_POST['quantity'],$row['price'],$ticketNumber);
}
?>

<!DOCTYPE html>
<html>

	<head>
		<title>Hai la Taraba!</title>

		<link rel="stylesheet" type="text/css" href="assets/css/style.css">

		<script src="https://ajax.googleapis.com/ajax/libs/dojo/1.13.0/dojo/dojo.js"></script>
		<script src="assets/js/script.js"></script>

	</head>

  <body>
    <?php include("./includes/header.php") ?>
		<?php include("./includes/sidebar.php") ?>

    <div class="mainViewContainer">
      <div class="mainContent">
        <div class="gridViewContainer">
          <div class="entityInfo">
            <div class="topSection">
              <h2><?php echo $row['name']; ?></h2>
              <hr class="borderStyle">
            </div>

            <div class="leftSection">
              <img src="<?php echo $row['path'] ?>">
            </div>

            <div class="rightSection">
              <p id='dStocStatus' style="background-<?php echo $status[1];?>"> <?php echo $status[0];?> </p>
              <p id='dStoc'> <?php echo $row['stoc'];?> oferte disponibile</p>
              <p id='dPrice'> <?php echo $row['price'];?> Lei</p>
              <form action="device.php?id=<?php echo $row['id'];?>" method="POST">
                  <input type="number" name="quantity" value="1" min="1" max="<?php echo $row['stoc'] ?>">
                  <button name="amountButton" type="submit">Adauga in cos</button>
              </form>
            </div>

            <div class="bottomSection">
              <h2>Specificatii</h2>
              <hr class="borderStyle">

              <table>
                  <h3>Caracteristici generale</h3>
                  <tr>
                      <th></th>
                      <th></th>
                  </tr>
                  <tr>
                      <td>Tip device</td>
                      <td><?php echo $row['deviceName']?></td>
                  </tr>
                  <tr>
                      <td>Tip SIM</td>
                      <td><?php echo $row['SIM']?></td>
                  </tr>
                  <tr>
                      <td>Model Procesor</td>
                      <td><?php echo $row['CPU']?></td>
                  </tr>
                  <tr>
                      <td>Sistem de operare</td>
                      <td><?php echo $row['OS']?></td>
                  </tr>
              </table>

              <table>
                  <h3>Memorie</h3>
                  <tr>
                      <th></th>
                      <th></th>
                  </tr>
                  <tr>
                      <td>Memorie interna</td>
                      <td><?php echo $row['mem_intern']?></td>
                  </tr>
                  <tr>
                      <td>Memorie RAM</td>
                      <td><?php echo $row['mem_ram']?></td>
                  </tr>
              </table>

              <table>
                  <h3>Multimedia</h3>
                  <tr>
                      <th></th>
                      <th></th>
                  </tr>
                  <tr>
                      <td>Redare video</td>
                      <td>MP4, M4V, 3GP, 3G2, WMV, ASF, AVI, FLV, MKV, WEBM</td>
                  </tr>
                  <tr>
                      <td>Redare audio</td>
                      <td>MP3, M4A, 3GA, AAC, OGG, OGA, WAV, WMA, AMR, AWB, FLAC, MID, MIDI, XMF, MXMF, IMY, RTTTL, RTX, OTA, DFF, DSF</td>
                  </tr>
              </table>

            </div>
          </div>
        </div>
      </div>
    </div>

  </body>

</html>
