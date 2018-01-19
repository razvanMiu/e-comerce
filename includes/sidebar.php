<div class="sidebarContainer">

  <div class="sidebarHead">
    <a href="index.php" class="logo">
      <img src="assets/images/icons/logo.png">
    </a>
    <hr class="borderStyle2">
    <div class="filterCategory">
      <form action="index.php" method="GET">
        <button name="smartphones">
          <span class="filterName">Smartphones</span>
        </button>
        <button name="tablets">
          <span class="filterName">Tablets</span>
        </button>
      </form>
    </div>
  </div>

  <div class="sidebarBody">
    <hr class="borderStyle2">
    <div class="filterCategory">

    <button onclick="showToggle('priceDropdown')">
      <span class="filterName">Price</span>
    </button>
    <div id="priceDropdown" class="dropdown-content relative">
      <form class="orderForm" action="index.php" method="GET">
        <button name="price1">0 - 100 Lei</button>
        <button name="price2">100 - 300 Lei</button>
        <button name="price3">300 - 1000 Lei</button>
        <button name="price4">1000 - 2000 Lei</button>
        <button name="price5">2000 - 6000 Lei</button>
      </form>
    </div>

    <button name="brand" onclick="showToggle('brandDropdown')">
      <span class="filterName">Brand</span>
    </button>
    <div id="brandDropdown" class="dropdown-content relative">
        <form class="orderForm" action="index.php" method="GET">
          <button name="brand1">Samsung</button>
          <button name="brand2">Apple</button>
          <button name="brand3">Lenovo</button>
          <button name="brand4">Huawei</button>
          <button name="brand5">Allview</button>
          <button name="brand6">Vonino</button>
        </form>
      </div>

      <button name="os" onclick="showToggle('osDropdown')">
        <span class="filterName">OS</span>
      </button>
      <div id="osDropdown" class="dropdown-content relative">
        <form class="orderForm" action="index.php" method="GET">
          <button name="os1">Android 5.1</button>
          <button name="os2">Android 7.0</button>
          <button name="os3">IOS 10</button>
        </form>
      </div>

      <button name="cpu" onclick="showToggle('cpuDropdown')">
        <span class="filterName">CPU</span>
      </button>
      <div id="cpuDropdown" class="dropdown-content relative">
        <form class="orderForm" action="index.php" method="GET">
          <button name="cpu1">Quad-core 1.2 GHz</button>
          <button name="cpu2">Quad-core 1.3 GHz</button>
          <button name="cpu3">Quad-core 1.4 GHz</button>
          <button name="cpu4">Cortex A53</button>
          <button name="cpu5">A9</button>
        </form>
      </div>

      <button name="sim" onclick="showToggle('simDropdown')">
        <span class="filterName">SIM</span>
      </button>
      <div id="simDropdown" class="dropdown-content relative">
        <form class="orderForm" action="index.php" method="GET">
          <button name="sim1">None</button>
          <button name="sim2">Nano-SIM</button>
          <button name="sim3">Micro-SIM</button>
        </form>
      </div>
    </div>
  </div>
</div>
