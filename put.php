<!DOCTYPE html>
<html>
  <head>
    <title>Confirmation Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
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

    <br>
    <br>
    <br>

    <div class="container">

      <?php

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

        $project_number = $_POST['project_number'];
        $upper_station_limit = $_POST['up_station_limit'];
        $lower_station_limit = $_POST['lo_station_limit'];
        $channel_location = $_POST['channel_location'];
        $soil_classf = $_POST['soil_class'];
        $pi = $_POST['pi'];
        $vr = $_POST['vr'];
        $soilD = $_POST['soilD'];
        $pss = $_POST['pss'];
        $grass_type = $_POST['grass_type'];
        $stem_height = $_POST['stem_height'];
        $grass_density = $_POST['grass_density'];
        $grass_roughness_coeff = $_POST['grass_roughness_coeff'];
        $m_roughness = $_POST['m_roughness'];
        $channel_geometry = $_POST['channel_geometry'];
        $left_slope = $_POST['left_slope'];
        $right_slope = $_POST['right_slope'];
        $bottom_width = $_POST['bottom_width'];
        $long_slope = $_POST['long_slope'];
        $initial_water_depth = $_POST['initial_water_depth'];
        $discharge = $_POST['discharge'];
        $area_flow = $_POST['area_flow'];
        $wetted_perimeter = $_POST['wetted_perimeter'];
        $top_width = $_POST['top_width'];
        $hyd_radius = $_POST['hyd_radius'];
        $final_discharge = $_POST['final_discharge'];
        $avg_velocity = $_POST['avg_velocity'];
        $discharge_interation_check = $_POST['discharge_interation_check'];
        $final_depth = $_POST['final_depth'];
        $shear_stress = $_POST['shear_stress'];
        $perm_soil_veg_shear_stress = $_POST['perm_soil_veg_shear_stress'];
        $comp_2_perm_shear_stress = $_POST['comp_2_perm_shear_stress'];
        $recco_trm_category = $_POST['recco_trm_category'];
        $minimum_d50_1 = $_POST['minimum_stable_d1'];
        $minimum_d50_3 = $_POST['minimum_stable_d3'];
        $stable_riprap1 = $_POST['recommended_riprap1'];
        $stable_riprap3 = $_POST['recommended_riprap3'];

        $sql = "INSERT INTO CHANNEL_LINING (project_number, upper_station_limit, lower_station_limit, channel_location, soil_classf, pi, vr, soil_d, perm_soil_shear_stress, grass_type, stem_height, grass_density, grass_roughness_coeff, manning_roughness, chann_geom, left_slope, right_slope, bottom_width, long_slope, init_water_depth, discharge, area_flow, wetted_peri, top_width, hyd_rad, final_discharge, avg_velocity, dis_int_chk, final_depth, shear_stress, perm_soil_stress, compare_stress, recommend, minimum_d50_1, minimum_d50_3, stable_riprap1, stable_riprap3) 
                VALUES ('$project_number', '$upper_station_limit', '$lower_station_limit', '$channel_location', '$soil_classf', '$pi', '$vr', '$soilD', '$pss', '$grass_type', '$stem_height', '$grass_density', '$grass_roughness_coeff', '$m_roughness', '$channel_geometry', '$left_slope', '$right_slope', '$bottom_width', '$long_slope', '$initial_water_depth', '$discharge', '$area_flow', '$wetted_perimeter', '$top_width', '$hyd_radius', '$final_discharge', '$avg_velocity', '$discharge_interation_check', '$final_depth', '$shear_stress', '$perm_soil_veg_shear_stress', '$comp_2_perm_shear_stress', '$recco_trm_category', '$minimum_d50_1', '$minimum_d50_3', '$stable_riprap1', '$stable_riprap3')";

        if (!mysql_query($sql, $con))
        {
            die('Error: ' . mysql_error());
        }

        /*$sql = "SELECT MAX(id) FROM CHANNEL_LINING";
        $result = mysql_query($sql);
        if(($ans = mysql_fetch_assoc($result)))
        $id = $ans['id'];*/
       
        mysql_close($con);

      ?>
      <div class="page-header">
        <h1>Data Submitted Successfully <small></small></h1>
      </div>
      <a href="./channel_grass_trm.php"><< Go Back</a>
    </div>

    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>