<div class="mainViewContainer">
  <div class="mainContent">
    <div class="pageHeading">
      <span>Order by</span>
      <div class="dropdown">
        <span id="dropLabel">
          <?php
            if(isset($_GET['risingButton'])) {
              echo "Rising price";
            } else {
              echo "Decreasing price";
            }
          ?>
        </span>
        <button onclick="showToggle('orderDropdown')" class="dropbtn"></button>
        <div id="orderDropdown" class="dropdown-content">
          <form id="orderForm2" action="index.php" method="GET">
            <button name="risingButton">Rising price</button>
            <button name="decreasingButton">Decreasing price</button>
          </form>
        </div>
      </div>
    </div>

    <div class="gridViewContainer">
      <?php include("gridview.php");?>
    </div>

  </div>
</div>
