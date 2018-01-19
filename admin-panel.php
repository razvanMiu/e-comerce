<?php
include("includes/config.php");
include("includes/classes/Constants.php");
include("includes/classes/Account.php");
include("includes/script.php");

$account = new Account($con);

include("includes/handlers/login-handler.php");
?>

<!DOCTYPE html>
<html>

	<head>
		<title>Hai la Taraba!</title>

		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="assets/css/style-admin-panel.css">

		<script src="https://ajax.googleapis.com/ajax/libs/dojo/1.13.0/dojo/dojo.js"></script>
		<script src="assets/js/script-admin-panel.js"></script>
	</head>

  <body>
    <header>
    </header>
<!--- HEADER --->
    <nav>
			<div class="scroll-div">
				<img id="logo" src="assets/images/icons/admin-panel.png" alt="admin-panel">
	      <ul>
					<li id="dashboard" class="liItem greenBorder">
						<img src="assets/images/icons/dashboard.png" alt="dashboard">
						<span>Dashboard</span>
					</li>
	 		</div>

    </nav>
<!--- NAVIGATION --->
    <main>
			<div id="dashboard" class="dropdown-content content show">
				<div class="comenziEsuate">
					<h1>Comenzi esuate</h1>
					<?php

						$q4 = mysqli_query($con, "SELECT U.username,T.date
																			FROM users U JOIN ticket T ON (T.users_ID = U.id)
																			WHERE T.id in (SELECT T2.id FROM ticket T2 WHERE T2.total = 0)");
						while($r4 = mysqli_fetch_array($q4)) {
							echo "<div class='fail'>
											<p><span>User: </span>".$r4['username']."</p>
											<p><span>Date: </span>".$r4['date']."</p>
										</div>";
						}
					 ?>
				</div>
				<div class="produseBD">
					<hr class="borderStyle"></hr>
					<h1>Produse in baza de date</h1>
					<table>
						<thead>
							<tr>
								<th>#</th>
								<th>Nume</th>
								<th>Pret</th>
								<th>Cantitate</th>
							</tr>
						</thead>
					 <tbody>
						<?php
							 $query = mysqli_query($con,"SELECT id,name,price,stoc FROM devices");
							 while($row = mysqli_fetch_array($query)) {
								 echo "<tr>
								 				<th>".$row['id']."</th>
												<th>".$row['name']."</th>
												<td>".$row['price']."</td>
												<td>".$row['stoc']."</td>
											</tr>";
							 }
						?>
					 </tbody>
				</table>
				</div>
				<hr class="borderStyle"></hr>
				<div class="deleteDevice">
					<h1>Stergeti produs</h1>
					<form class="" action="admin-panel.php" method="GET">
						<label for="id">Device ID
							<input type="number" name="id" value="0">
						</label>
						<button type="submit" name="deleteButton">Delete</button>
					</form>
					<?php
						if(isset($_GET['deleteButton'])) {
							$id = $_GET['id'];
							mysqli_query($con,"DELETE FROM devices WHERE id = '$id'");
						}
					 ?>
				</div>
				<hr class="borderStyle"></hr>

				<div class="Update">
					<h1>Update user</h1>
					<form class="" action="admin-panel.php" method="GET">
						<label for="id5">User ID
							<input type="number" name="id5" value="0">
						</label>

						<label for="fn">First name
							<input type="text" name="fn">
						</label>

						<button type="submit" name="updateButton2">Update</button>
					</form>
					<?php

						if(isset($_GET['updateButton2'])) {
							$iddd = $_GET['id5'];
							$fn   = $_GET['fn'];
							mysqli_query($con,"UPDATE users U
																SET firstName = '$fn'
																WHERE id = '$iddd'" );
						}
					?>
				</div>
			</div>

      <!-- <div id="updateUsers" class="dropdown-content">

      </div>
      <div id="addDevice" class="dropdown-content content">
				<form class="addDeviceForm" action="admin-panel.php" method="post">

					<div id="device" class="divFormContent">
						<h3>Device type</h3>
						<label>
							<input type="radio" name="device" value="Smartphones" class="option-input radio" checked>Smartphones
						</label>
						<label>
							<input type="radio" name="device" value="Tablets" class="option-input radio">Tablets
						</label>
					</div>

					<div id="brand" class="divFormContent">
						<h3>Brand</h3>
						<label>
							<input type="radio" name="brand" value="Samsung" class="option-input radio" checked>Samsung
						</label>
						<label>
							<input type="radio" name="brand" value="Apple" class="option-input radio">Apple
						</label>
						<label>
							<input type="radio" name="brand" value="Lenovo" class="option-input radio">Lenovo
						</label>
						<label>
							<input type="radio" name="brand" value="Huawei" class="option-input radio">Huawei
						</label>
						<label>
							<input type="radio" name="brand" value="Allview" class="option-input radio">Allview
						</label>
						<label>
							<input type="radio" name="brand" value="Vonino" class="option-input radio">Vonino
						</label>
					</div>

					<div id="cpu" class="divFormContent">
						<h3>CPU</h3>
						<label>
							<input type="radio" name="cpu" value="Quad-core 1.2 GHz" class="option-input radio" checked>Quad-core 1.2 GHz
						</label>
						<label>
							<input type="radio" name="cpu" value="Quad-core 1.3 GHz" class="option-input radio">Quad-core 1.3 GHz
						</label>
						<label>
							<input type="radio" name="cpu" value="Quad-core 1.4 GHz" class="option-input radio">Quad-core 1.4 GHz
						</label>
						<label>
							<input type="radio" name="cpu" value="Cortex A53" class="option-input radio">Cortex A53
						</label>
						<label>
							<input type="radio" name="cpu" value="A9" class="option-input radio">A9
						</label>
					</div>

					<div id="os" class="divFormContent">
						<h3>OS</h3>
						<label>
							<input type="radio" name="os" value="Android 5.1" class="option-input radio" checked>Android 5.1
						</label>
						<label>
							<input type="radio" name="os" value="Android 7.0" class="option-input radio">Android 7.0
						</label>
						<label>
							<input type="radio" name="os" value="IOS 10" class="option-input radio">IOS 10
						</label>
					</div>

					<div id="sim" class="divFormContent">
						<h3>SiM</h3>
						<label>
							<input type="radio" name="sim" value="none" class="option-input radio" checked>none
						</label>
						<label>
							<input type="radio" name="sim" value="Nano-SIM" class="option-input radio">Nano-SIM
						</label>
						<label>
							<input type="radio" name="sim" value="Nano-SIM" class="option-input radio">Nano-SIM
						</label>
					</div>

					<div class="details divFormContent">
						<span>
							<h3>Name</h3>
							<input type="text" name="name" placeholder="e.g Samsung Galaxy S5">
						</span>

						<span>
							<h3 for="price">Price</h3>
							<input type="text" name="price" placeholder="e.g 200">
						</span>

						<span>
							<h3 for="stoc">Stoc</h3>
							<input type="text" name="stoc" placeholder="e.g 15">
						</span>

						<span>
							<h3 for="diagonala">Diagonala</h3>
							<input type="text" name="diagonala" placeholder="e.g 5''">
						</span>

						<span>
							<h3>Image</h3>
							<input type="file" name="imageUpload" id="iamgeUpload" class="inputFile" multiple onchange="myFunction()">
							<label for="imageUpload">Chose image</label>
							<img src="" id="deviceImage" style="display:none" onchange="destroyInput()">
						</span>
					</div>
					<button type="submit" name="addDeviceButton">Add</button>
				</form>
      </div>

      <div id="updateDevice" class="dropdown-content">

      </div>

      <div id="deleteDevice" class="dropdown-content">

      </div> -->

    </main>
<!--- MAIN --->

	<script src="assets/js/script-admin-panel.js"></script>
  </body>

</html>
