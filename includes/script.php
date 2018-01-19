<?php

function addCart($con,$id,$amount,$price,$ticket) {
  $sql = "INSERT INTO cart VALUES (DEFAULT, '$ticket','$id','$amount','$price')";
  $query = mysqli_query($con,$sql);
}

function logoutFunction () {
  if(isset($_GET['logoutButton'])) {
    unset($_SESSION['userLoggedIn']);
  }
}

function getSearchQuery($con) {
  $query = $_GET['search'];

  // changes characters used in html to their equivalents, for example: < to &gt;
  $query = htmlspecialchars($query);

  // makes sure nobody uses SQL injection
  $query = mysqli_real_escape_string($con, $query);

  $raw_results = mysqli_query($con, "SELECT id, name, price, path, stoc, device_ID
  FROM devices WHERE (`name` LIKE '%".$query."%')
  GROUP BY name") or die(mysqli_error($con));

  return $raw_results;
}

function getQuery($con, $device, $order) {

  /* PRICE SESSION */
  if(isset($_GET['price1'])) {
      $_SESSION['priceCategory'] = 1;
  } else if(isset($_GET['price2'])) {
      $_SESSION['priceCategory'] = 2;
  } else if(isset($_GET['price3'])) {
      $_SESSION['priceCategory'] = 3;
  } else if(isset($_GET['price4'])) {
      $_SESSION['priceCategory'] = 4;
  } else if(isset($_GET['price5'])) {
      $_SESSION['priceCategory'] = 5;
  }
  /* BRAND SESSION */
  if(isset($_GET['brand1'])) {
      $_SESSION['brandCategory'] = 1;
  } else if(isset($_GET['brand2'])) {
      $_SESSION['brandCategory'] = 2;
  } else if(isset($_GET['brand3'])) {
      $_SESSION['brandCategory'] = 3;
  } else if(isset($_GET['brand4'])) {
      $_SESSION['brandCategory'] = 4;
  } else if(isset($_GET['brand5'])) {
      $_SESSION['brandCategory'] = 5;
  } else if(isset($_GET['brand6'])){
      $_SESSION['brandCategory'] = 6;
  }
  /* OS SESSION */
  if(isset($_GET['os1'])) {
      $_SESSION['osCategory'] = 1;
  } else if(isset($_GET['os2'])) {
      $_SESSION['osCategory'] = 2;
  } else if(isset($_GET['os3'])) {
      $_SESSION['osCategory'] = 3;
  }
  /* CPU SESSION */
  if(isset($_GET['cpu1'])) {
      $_SESSION['cpuCategory'] = 1;
  } else if(isset($_GET['cpu2'])) {
      $_SESSION['cpuCategory'] = 2;
  } else if(isset($_GET['cpu3'])) {
      $_SESSION['cpuCategory'] = 3;
  } else if(isset($_GET['cpu4'])) {
      $_SESSION['cpuCategory'] = 4;
  } else if(isset($_GET['cpu5'])) {
      $_SESSION['cpuCategory'] = 5;
  }
  /* SIM SESSION */
  if(isset($_GET['sim1'])) {
      $_SESSION['simCategory'] = 1;
  } else if(isset($_GET['sim2'])) {
      $_SESSION['simCategory'] = 2;
  } else if(isset($_GET['sim3'])) {
      $_SESSION['simCategory'] = 3;
  }

  switch($_SESSION['priceCategory']) {
      case 1:
          $minPrice = 0;
          $maxPrice = 100;
          break;
      case 2:
          $minPrice = 100;
          $maxPrice = 300;
          break;
      case 3:
          $minPrice = 300;
          $maxPrice = 1000;
          break;
      case 4:
          $minPrice = 1000;
          $maxPrice = 2000;
          break;
      case 5:
          $minPrice = 2000;
          $maxPrice = 6000;
          break;
      default:
          $minPrice = 0;
          $maxPrice = 6000;
          break;
  }

  switch($_SESSION['brandCategory']) {
      case 1:
          $brand = " AND B.brand LIKE 'Samsung'";
          break;
      case 2:
          $brand = " AND B.brand LIKE 'Apple'";
          break;
      case 3:
          $brand = " AND B.brand LIKE 'Lenovo'";
          break;
      case 4:
          $brand = " AND B.brand LIKE 'Huawei'";
          break;
      case 5:
          $brand = " AND B.brand LIKE 'SamAllviewsung'";
          break;
      case 6:
          $brand = " AND B.brand LIKE 'Vonino'";
          break;
      default :
          $brand = "";
          break;
  }

  switch($_SESSION['osCategory']) {
      case 1:
          $os = " AND O.OS LIKE 'Android 5.1'";
          break;
      case 2:
          $os = " AND O.OS LIKE 'Android 7.0'";
          break;
      case 3:
          $os = " AND O.OS LIKE 'IOS 10'";
          break;
      default:
          $os = "";
          break;
  }

  switch($_SESSION['cpuCategory']) {
      case 1:
          $cpu = " AND C.CPU LIKE 'Quad-core 1.2 GHz'";
          break;
      case 2:
          $cpu = " AND C.CPU LIKE 'Quad-core 1.3 GHz'";
          break;
      case 3:
          $cpu = " AND C.CPU LIKE 'Quad-core 1.4 GHz'";
          break;
      case 4:
          $cpu = " AND C.CPU LIKE 'Cortex A53'";
          break;
      case 5:
          $cpu = " AND C.CPU LIKE 'A9";
          break;
      default:
          $cpu = "";
          break;
  }

  switch($_SESSION['simCategory']) {
      case 1:
          $sim = " AND S.SIM LIKE 'none'";
          break;
      case 2:
          $sim = " AND S.SIM LIKE 'Nano-SIM'";
          break;
      case 3:
          $sim = " AND S.SIM LIKE 'Micro-SIM'";
          break;
      default:
          $sim = "";
          break;
  }

  $tabletQuery = mysqliQuery($con, $device, $brand, $os, $cpu, $sim, " D.price > $minPrice AND D.price < $maxPrice", $order);
  return $tabletQuery;
}

function mysqliQuery($con, $device, $brand, $cpu, $os, $sim, $price, $order) {
  $sql = "SELECT D.id,D.name,D.price,D.stoc,D.path,D.device_ID,B.brand,C.CPU,O.OS,S.SIM
  FROM devices D
    JOIN brand B
        ON (D.brand_ID = B.id)
    JOIN cpu C
        ON (D.CPU_ID = C.id)
    JOIN os O
        ON (D.OS_ID = O.id)
    JOIN sim S
        ON (D.SIM_ID = S.id)
  WHERE D.device_ID = $device AND " . $price . $brand . $cpu . $os . $sim . $order;

  $tabletQuery = mysqli_query($con, $sql);

  return $tabletQuery;
}

function deviceDetailsQuery($con,$deviceID) {
  $sql ="SELECT D.id,D.name,D.diagonala,D.price,D.mem_ram,D.mem_intern,D.path,D.stoc,B.brand,C.CPU,O.OS,S.SIM,CTG.name as deviceName
  FROM devices D
    JOIN brand B
        ON (D.brand_ID = B.id)
    JOIN cpu C
        ON (D.CPU_ID = C.id)
    JOIN os O
        ON (D.OS_ID = O.id)
    JOIN sim S
        ON (D.SIM_ID = S.id)
    JOIN category CTG
    	  ON (D.device_ID = CTG.id)
   WHERE D.id = $deviceID";

   $query = mysqli_query($con, $sql);

   return $query;
}

function destroySessions() {
  unset($_SESSION['search']);
  $_SESSION['priceCategory'] = false;
	$_SESSION['brandCategory'] = false;
	$_SESSION['osCategory'] = false;
	$_SESSION['cpuCategory'] = false;
	$_SESSION['simCategory'] = false;
}

function startSessions() {
  if(!isset($_SESSION['priceCategory'])) {
    $_SESSION['priceCategory'] = false;
  }

  if(!isset($_SESSION['brandCategory'])) {
    $_SESSION['brandCategory'] = false;
  }

  if(!isset($_SESSION['osCategory'])) {
    $_SESSION['osCategory'] = false;
  }

  if(!isset($_SESSION['cpuCategory'])) {
    $_SESSION['cpuCategory'] = false;
  }

  if(!isset($_SESSION['simCategory'])) {
    $_SESSION['simCategory'] = false;
  }
}

function getColor($val) {
  if($val > 3) {
      $status = array("In stoc", "color:#090");
  } else if($val >= 1 ) {
      $status = array("Stoc limitat", "color:#f50");
  } else {
      $status = array("Stoc epuizat", "color:#ef2809");
  }

  return $status;
}
?>
