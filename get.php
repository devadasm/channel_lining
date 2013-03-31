<!DOCTYPE html>
<html>
  <head>
    <title>Data</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <style type="text/css">
      .jumbotron{
        background: -moz-linear-gradient(45deg, #F3BA1D 0%, #FFDA77 100%) repeat scroll 0 0 transparent; /* #020031 #6D3353 #dc5c2a #ffb60b*/
        background: -webkit-linear-gradient(45deg, #F3BA1D 0%, #FFDA77 100%);
        box-shadow: 0 3px 7px rgba(0, 0, 0, 0.2) inset, 0 -3px 7px rgba(0, 0, 0, 0.2) inset;
        color: #FFFFFF;
        padding: 40px 0;
        position: relative;
      }
      .headings{
        color: #5A5A5A;
        font-size: 38.5px;
        line-height: 40px;
        display: block;
        padding-top: 30px;
      }
    </style>
    <script type="text/javascript">
      function getCSV()
      {
        window.location = "./csv.php"
        /*alert("Hi");
        $('#mybutton').live('click', function() {
            $.get('csv.php');
            return false;
        });*/
      }
    </script>
  </head>

  <body>

    <!-- ------------------------------   NAVBAR   ----------------------------------  -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="./index.html">Lining Design Application</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="">
                <a href="./index.html">Home</a>
              </li>
              <li class="">
                <a href="./channel_grass_trm.php">Channel Lining</a>
              </li>              
              <li class="">
                <a href="./generate_report.html">Generate Report</a>
              </li>
              <li>
                <a href="#">Download Calculations</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- ------------------------------   MASTHEAD   ----------------------------------  -->
    <header class="jumbotron">
      <div class="container">
        <h1 style="font-size: 55px; margin-top: 30px; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;">Project Report</h1>
        <p class="lead"></p>
      </div>
    </header>

    <!-- ------------------------------   BODY   ----------------------------------  -->

    <div class="container" style="width: 75%;">

      <h1 class="headings">Project <?php echo $_GET['project_number'] ?></h1>
      <br>

      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Upper Station Limit</th>
            <th>Lower Station Limit</th>
            <th>Channel Location</th>
            <th>Permissible Shear Stress</th>
            <th>TRM</th>
            <th>Riprap 1</th>
            <th>Riprap 3</th>
          </tr>
        </thead>
      <?php
          session_start();

          require 'config.inc.php';
          require 'db.inc.php';

          $con = dbConnect();

          /*
          $con = mysql_connect("localhost","gdot","gdot");

          if(!con)
          {
              die('Could not connect: '.mysql_error());
          }

          mysql_select_db("GDOT", $con);
          */

          $project_number = $_GET['project_number'];
          $upper_station_limit = $_GET['upper_limit'];
          $lower_station_limit = $_GET['lower_limit'];

          if($upper_station_limit == '' && $lower_station_limit == ''){
              $query = "SELECT * FROM CHANNEL_LINING where project_number='$project_number'";
              $result = mysql_query($query);
              $_SESSION['query'] = $query;
          }
          else if($upper_station_limit != '' && $lower_station_limit != ''){
              $query = "SELECT * FROM CHANNEL_LINING where project_number='$project_number' AND upper_station_limit='$upper_station_limit' AND lower_station_limit='$lower_station_limit'";
              $result = mysql_query($query);
              $_SESSION['query'] = $query;
          }
          else if($upper_station_limit == '' && $lower_station_limit != ''){
              $query = "SELECT * FROM CHANNEL_LINING where project_number='$project_number' AND lower_station_limit='$lower_station_limit'";
              $result = mysql_query($query);
              $_SESSION['query'] = $query;
          }
          else if($upper_station_limit != '' && $lower_station_limit == ''){
              $query = "SELECT * FROM CHANNEL_LINING where project_number='$project_number' AND upper_station_limit='$upper_station_limit'";
              $result = mysql_query($query);
              $_SESSION['query'] = $query;
          }
          while ($row = mysql_fetch_assoc($result))
          {
            $upper_limit = $row["upper_station_limit"];
            $lower_limit = $row["lower_station_limit"];
            $channel_location = $row["channel_location"];
            $compare_stress = $row["compare_stress"];
            $recommend = $row["recommend"];
            $riprap1 = $row["stable_riprap1"];
            $riprap3 = $row["stable_riprap3"]
      ?>
        <tr>
          <td><?php echo $upper_limit;?></td>
          <td><?php echo $lower_limit;?></td>
          <td><?php echo $channel_location;?></td>
          <td><?php echo $compare_stress;?></td>
          <td><?php echo $recommend;?></td>
          <td><?php echo $riprap1;?></td>
          <td><?php echo $riprap3;?></td>
        </tr>
      <?php
          }
          mysql_close($con);
      ?>
      </table>

      <a class="btn btn-primary" href="./csv.php">Download Report</a>

      <!-- button class="btn btn-primary" id="mybutton" onclick=getCSV()></button -->
    </div>

    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>

</html>