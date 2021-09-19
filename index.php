<?php
  session_start();

  require_once 'dbconnect.php';

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $file = './users.txt';
  $lines = file($file);

  if (!isset($_SESSION["is_logged_in"])) {
    header("location: login.php");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kiddocare Assignment</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages': ['bar', 'corechart']});
    google.charts.setOnLoadCallback(drawSalesByCustomersBar);
    google.charts.setOnLoadCallback(drawSalesByEmployeesBar);
    google.charts.setOnLoadCallback(drawDailySalesBar);
    google.charts.setOnLoadCallback(drawSalesByProductCategoriesChart);

    function drawDailySalesBar() {
      var data = google.visualization.arrayToDataTable([
        ["Day", "Total Sales"],
        <?php
        $sql = "SELECT DATE_FORMAT(orders.OrderDate, '%d-%b-%Y') date,
       SUM((order_details.UnitPrice * order_details.Quantity) -
           (order_details.Discount * order_details.Quantity)) as TotalSales
FROM orders
         JOIN order_details ON orders.OrderID = order_details.OrderID
WHERE orders.OrderDate >= '1995-05-01'
  and orders.OrderDate < '1995-06-01'
GROUP BY orders.OrderDate";

        $fire = mysqli_query($conn, $sql);

        while ($result = mysqli_fetch_assoc($fire)) {
          echo "['" . $result['date'] . "', " . $result['TotalSales'] . "],";
        }
        ?>
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1]);

      var options = {
        // title: "Daily Sales",
        width: 1000,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: {position: "none"},
        hAxis: {
          title: 'Order Date'
        },
        vAxis: {
          title: 'Total Gross Sales ($)'
        }
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("daily_sales"));
      var formatter = new google.visualization.NumberFormat(
        {prefix: '$'});
      formatter.format(data, 1); // Apply formatter to second column

      chart.draw(view, options);
    }

    function drawSalesByProductCategoriesChart() {
      var data = google.visualization.arrayToDataTable([
        ['Product Category', 'Total Sales ($)'],
        <?php
        $sql = "SELECT categories.CategoryID,
       categories.CategoryName,
       SUM((order_details.UnitPrice * order_details.Quantity) -
           (order_details.Discount * order_details.Quantity)) as TotalSales
FROM orders
         JOIN order_details ON orders.OrderID = order_details.OrderID
         JOIN products ON order_details.ProductID = products.ProductID
         JOIN categories ON products.CategoryID = categories.CategoryID
WHERE orders.OrderDate >= '1995-05-01'
  and orders.OrderDate <= '1995-06-01'
GROUP BY categories.CategoryID
ORDER BY TotalSales";

        $fire = mysqli_query($conn, $sql);

        while ($result = mysqli_fetch_assoc($fire)) {
          echo "['" . $result['CategoryName'] . "', " . $result['TotalSales'] . "],";
        }
        ?>
      ]);

      var options = {
        // title: 'Sales by Product Categories',
        pieHole: 0.4,
      };

      var chart = new google.visualization.PieChart(document.getElementById('salesByProductCategories'));
      chart.draw(data, options);
    }

    function drawSalesByCustomersBar() {
      var data = new google.visualization.arrayToDataTable([
        ['Customer Name', 'Sales'],
        <?php
        $sql = "SELECT *
FROM (SELECT customers.CustomerID,
             customers.ContactName,
             SUM((order_details.UnitPrice * order_details.Quantity) -
                 (order_details.Discount * order_details.Quantity)) as TotalSales
      FROM orders
               JOIN order_details ON orders.OrderID = order_details.OrderID
               JOIN customers ON orders.CustomerID = customers.CustomerID
      WHERE orders.OrderDate >= '1995-05-01'
        and orders.OrderDate < '1995-06-01'
      GROUP BY customers.CustomerID
      ORDER BY TotalSales DESC
      LIMIT 9) a
ORDER BY a.TotalSales";

        $fire = mysqli_query($conn, $sql);

        while ($result = mysqli_fetch_assoc($fire)) {
          echo "['" . $result['ContactName'] . "', " . $result['TotalSales'] . "],";
        }
        ?>
      ]);

      var options = {
        title: 'Sales by Customers',
        width: 320,
        height: 320,
        legend: {position: 'none'},
        chart: {
          // title: 'Sales by Customers',
          // subtitle: 'Showing top 10 sales'
        },
        bars: 'horizontal', // Required for Material Bar Charts.
        axes: {
          x: {
            0: {side: 'top', label: 'Total Sales ($)'} // Top x-axis.
          }
        },
        bar: {groupWidth: "90 % "}
      };

      var chart = new google.charts.Bar(document.getElementById('sales_by_customers'));
      chart.draw(data, options);
    };

    function drawSalesByEmployeesBar() {
      var data = new google.visualization.arrayToDataTable([
        ['Employee Name', 'Sales'],
        <?php
        $sql = "SELECT employees.EmployeeID,
       CONCAT(employees.FirstName, ' ', employees.LastName)   AS FullName,
       SUM((order_details.UnitPrice * order_details.Quantity) -
           (order_details.Discount * order_details.Quantity)) as TotalSales
FROM orders
         JOIN order_details ON orders.OrderID = order_details.OrderID
         JOIN employees ON orders.EmployeeID = employees.EmployeeID
WHERE orders.OrderDate >= '1995-05-01'
  AND orders.OrderDate < '1995-06-01'
GROUP BY employees.EmployeeID
ORDER BY TotalSales";

        $fire = mysqli_query($conn, $sql);

        while ($result = mysqli_fetch_assoc($fire)) {
          echo "['" . $result['FullName'] . "', " . $result['TotalSales'] . "],";
        }
        ?>
      ]);

      var options = {
        title: 'Sales by Employees',
        width: 320,
        height: 320,
        legend: {position: 'none'},
        chart: {
          // title: 'Sales by Customers',
          // subtitle: 'popularity by percentage'
        },
        bars: 'horizontal', // Required for Material Bar Charts.
        axes: {
          x: {
            0: {side: 'top', label: 'Total Sales ($)'} // Top x-axis.
          }
        },
        bar: {groupWidth: "90 % "}
      };

      var chart = new google.charts.Bar(document.getElementById('sales_by_employees'));
      chart.draw(data, options);
    }
  </script>
</head>
<body>
<nav>
  <div class="wrapper header-wrapper">
    <a href="index.php"></a>
    <ul>
      <li><a href="index.php" class="nav-link font-bold">Home</a></li>

      <?php if (isset($_SESSION["is_logged_in"])): ?>
        <li><a href="logout.php" class="nav-link">Log out</a></li>
      <?php else: ?>
        <li><a href="login.php" class="nav-link">Log in</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>


<div class="wrapper body-wrapper">
  <section class="index-title">
    <h1 class="text-2xl">Sales Dashboard</h1>
    <p class="subtitle">Showing Data for <strong>May 1995</strong></p>
  </section>

  <section class="index-content">
    <div class="total-container">
      <div class="card card-half">
        <h4 class="font-bold text-xl">Total Sales</h4>
        <p class="total-value">
          <?php
            $sql = "SELECT ROUND(SUM((order_details.UnitPrice * order_details.Quantity) -
           (order_details.Discount * order_details.Quantity)), 2) as TotalSales
FROM orders
         JOIN order_details ON orders.OrderID = order_details.OrderID
WHERE orders.OrderDate >= '1995-05-01'
  and orders.OrderDate < '1995-06-01'";

            $fire = mysqli_query($conn, $sql);

            while ($result = mysqli_fetch_assoc($fire)) {
              echo "\$", number_format($result['TotalSales'], 2);
            }
          ?>

        </p>
      </div>
      <div class="card card-half">
        <h4 class="font-bold text-xl">Total Orders</h4>
        <p class="total-value">
          <?php
            $sql = "SELECT COUNT(orders.OrderID) AS TotalOrder
from orders
WHERE orders.OrderDate >= '1995-05-01'
  and orders.OrderDate < '1995-06-01'";

            $fire = mysqli_query($conn, $sql);

            while ($result = mysqli_fetch_assoc($fire)) {
              echo $result['TotalOrder'];
            }
          ?>
        </p>
      </div>
    </div>

    <div class="card card-full">
      <h4 class="font-semibold">Daily Sales</h4>
      <div id="daily_sales" style="width: 900px; height: 500px;"></div>
    </div>

    <div class="card-container">
      <div class="card card-square">
        <h4 class="font-semibold">Sales by Product Categories</h4>
        <div id="salesByProductCategories" style="width: 320px; height: 320px;"></div>
      </div>
      <div class="card card-square">
        <h4 class="font-semibold">Sales by Customers
          <div id="sales_by_customers" style="width: 320px; height: 320px;"></div>
        </h4>
      </div>
      <div class="card card-square">
        <h4 class="font-semibold">Sales by Employess</h4>
        <div id="sales_by_employees" style="width: 320px; height: 320px;"></div>
      </div>
    </div>
  </section>
</div>

<?php mysqli_close($conn) ?>
</body>
</html>

<script src="js/script.js"></script>