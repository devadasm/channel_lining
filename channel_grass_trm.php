<!DOCTYPE html>
<html>
  <head>
    <title>Channel Lining</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="calculations_all.js"></script>
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
      .subheadings{
        color: #333;
        display: block;
        font-size: 24.5px;
        line-height: 40px;
        border-bottom: 1px solid #EEE;
        text-align: center;
      }
      .text{
        font-size: 17px;
      }
      .main-form{
        padding-bottom: 19px;
      }
      .indent{
        margin-left: 30px;
      }
    </style>
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
              <li class="active">
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
    		<h1 style="font-size: 55px; margin-top: 30px; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;">New Channel Lining Project</h1>
    		<p class="lead">Grass, TRM and Riprap</p>
    	</div>
    </header>

    <br>



    <!-- ------------------------------   BODY   ----------------------------------  -->
    <div class="container">
      <form class="main-form form-horizontal" name="Lining" action="put.php" method="POST" onsubmit="return validateForm()">

        <h1 class="headings">Project & Channel</h1>

        <br>


        <!--------  PROJECT DATA   -------->
        <h3 class="subheadings">Project Data</h3>
        <div class="row">
          <div class="span6">
            <div class="control-group">
              <label class="control-label text">Project Number</label>
              <div class="controls"><input type="text" name="project_number"></div>
            </div>
            <div class="control-group">
              <label class="control-label text">Channel Location</label>
              <div class="controls">
                <select name="channel_location">
                  <option value=" "> </option>
                  <option value="Right">Right</option>
                  <option value="Center">Center</option>
                  <option value="Left">Left</option>
                </select>
              </div>
            </div>
          </div>
          <div class="span6">            
            <div class="control-group">
              <label class="control-label text">Lower Station Limit</label>
              <div class="controls"><input type="text" name="lo_station_limit"></div>
            </div>
            <div class="control-group">
              <label class="control-label text">Upper Station Limit</label>
              <div class="controls"><input type="text" name="up_station_limit"></div>
            </div>
          </div>
        </div>


        <!--------  CHANNEL DIMENSIONS   -------->
        <h3 class="subheadings">Channel Dimensions</h3>        
        <div class="row">
          <div class="span6">
            <div class="control-group">
              <label class="control-label text">Channel geometery</label>
              <div class="controls">
                <select id="channel_geometry" onchange="slopes()" name="channel_geometry">
                  <option value=" "> </option>
                  <option value="Trapezoidal">Trapezoidal</option>
                  <option value="Rectangular">Rectangular</option>
                  <option value="Triangular">Triangular</option>
                  <option value="Parabolic">Parabolic</option>
                </select> 
              </div>
            </div>
            <div class="control-group">
              <label class="control-label text">Side slope</label>
              <div class="controls">
                <div class="input-prepend input-append">
                  <span class="add-on">L</span>
                  <input type="text" name="left_slope" id="left_slope" onchange="get_leftSlope()">
                  <span class="add-on">ft/ft</span>
                </div>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label text">Side slope</label>
              <div class="controls">
                <div class="input-prepend input-append">
                  <span class="add-on">R</span>
                  <input type="text" name="right_slope" id="right_slope" onchange="get_rightSlope()">
                  <span class="add-on">ft/ft</span>
                </div>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label text">Channel bottom width</label>
              <div class="controls">
                <div class="input-append">
                  <input type="text" name="bottom_width" id="bottom_width" onchange="get_bottomWidth()">
                  <span class="add-on">ft</span>
                </div>
              </div>
            </div>              
          </div>
          <div class="span6">
            <div class="control-group">
              <label class="control-label text">Longitudinal slope</label>
              <div class="controls">
                <div class="input-append">
                  <input type="text" name="long_slope" id="long_slope" onchange="get_longSlope()">
                  <span class="add-on">ft/ft</span>
                </div>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label text">Initial water depth estimate</label>
              <div class="controls">
                <div class="input-append">
                  <input type="text" name="initial_water_depth" id="initial_water_depth" onchange="get_water_depth()">
                  <span class="add-on">ft</span>
                </div>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label text">Discharge (Q)</label>
              <div class="controls">
                <div class="input-append">
                  <input type="text" name="discharge" id="discharge" onchange="get_discharge()">
                  <span class="add-on">ft<sup>3</sup>/s</span>
                </div>
              </div>
            </div>           
          </div>
        </div>


        <h1 class="headings">Grass & TRM</h1>
        <br>


        <!--------  SOIL AND SHEAR STRESS   -------->
        <h3 class="subheadings">Soil Inputs And Shear Stress</h3>
        <div class="row">
          <div class="span6">
            <div class="control-group">
              <label class="control-label text">Soil Classification (USCS)</label>
              <div class="controls">
                <select onchange="get_soil_classf()" id="soil_classf" name="soil_class">
                  <option value=" "> </option>
                  <option value="GW (Well graded gravel)">GW (Well graded gravel)</option>
                  <option value="GP (Poorly graded gravel)">GP (Poorly graded gravel)</option>
                  <option value="GM (Silty gravel)">GM (Silty gravel)</option>
                  <option value="GC (Clayey gravel)">GC (Clayey gravel)</option>
                  <option value="SW (Well graded sand)">SW (Well graded sand)</option>
                  <option value="SP (Poorly graded sand)">SP (Poorly graded sand)</option>
                  <option value="SM (Silty Sand)">SM (Silty sand)</option>
                  <option value="SC (Clayey Sand)">SC (Clayey sand)</option>
                  <option value="ML (Low plasticity Silt)">ML (Low plasticity silt)</option>
                  <option value="CL (Low plasticity Clay)">CL (Low plasticity clay)</option>
                  <option value="MH (High plasticity Silt)">MH (High plasticity silt)</option>
                  <option value="CH (High plasticity Clay)">CH (High plasticity clay)</option>        
                </select>
              </div>
            </div>
            <h4>For Plastic Soils</h4>
            <div class="control-group">
              <label class="control-label text">Plasticity Index (PI)</label>
              <div class="controls"><input type="text" name="pi" id="pi" onchange="get_pi()"></div>
            </div>
            <!--div class="control-group">
              <label class="control-label text">Void Ratio (e)</label>
              <div class="controls"><input type="text" name="vr" id="vr" onchange="get_vr()"></div>
            </div-->
            <h4>For Non-Plastic Soils</h4>
            <div class="control-group">
              <label class="control-label text">Soil D<sub>75</sub></label>
              <div class="controls">
                <div class="input-append">
                  <input type="text" name="soilD" id="soilD" onchange="get_soilD()">
                  <span class="add-on">in</span>         
                </div>
              </div>
            </div>
          </div>
          <div class="span6">            
            <div class="control-group">
              <label class="control-label text">Permissible soil shear stress</label>
              <div class="controls">
                <div class="input-append">
                  <input type="text" name="pss" id="permissible_soil_shear_stress" readonly="readonly">
                  <span class="add-on">(lb/ft<sup>2</sup>)</span>                  
                </div>
              </div>
            </div>            
          </div>
        </div>



        <!--------  GRASS & ROUGHNESS   -------->
        <h3 class="subheadings">Grass And Roughness Characteristics</h3>
        <div class="row">
          <div class="span6">
            <div class="control-group">
              <label class="control-label text">Grass type</label>              
              <div class="controls">
                <select id="grass_type" onchange="get_grassType()" name="grass_type">
                  <option value=" "> </option>
                  <option value="sod">Sod</option>
                  <option value="bunch">Bunch</option>
                  <option value="mixed">Mixed</option>
                </select>
                <a href="#" rel="tooltip" title="Sod: Spreading grass, such as Bermuda or Kentucky bluegrass

Bunch: Limited spreading, such as Tall Fescue

Mixed: Combined sod and bunch grasses"><img src="questionMark.gif"></a>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label text">Density of grass cover</label>
              <div class="controls">
                <select id="grass_density" onchange="get_grassDensity()" name="grass_density">
                  <option value=" "> </option>
                  <option value="Excellent">Excellent >= 95%</option>
                  <option value="Good">Good 75-95%</option>
                  <option value="Poor">Poor < 75%</option>
                </select>
                <a href="#" rel="tooltip" title="Excellent: 500 stems/sq-ft

Good: 300 stems/sq-ft

Poor: 100 stems/sq-ft"><img src="questionMark.gif"></a>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label text">Manning Roughness</label>
              <div class="controls">
                <input type="text" name="manning_override" id="manning_override" readonly="readonly" onchange="overrideManning()">
              </div>
            </div>

          </div>
          <div class="span6">
            <div class="control-group">
              <label class="control-label text">Stem height (ft)</label>
              <div class="controls">
                <select id="stem_height" onchange="get_stemHeight()" name="stem_height">
                  <option value=" "> </option>
                  <option value="0.25">0.25</option>
                  <option value="0.50">0.50</option>
                  <option value="0.75">0.75</option>
                  <option value="1.00">1.00</option>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label text">Grass Roughness Coefficient</label>
              <div class="controls"><input type="text" name="grass_roughness_coeff" id="grass_roughness_coeff" readonly="readonly"></div>
            </div>

            <div class="control-group" style="margin-left: 20px;">
              <label class="radio">
                <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                Use calculated Manning Roughness
              </label>
              <label class="radio">
                <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                Enter Manning Roughness Manually
              </label>
            </div>
          </div>
        </div>

        
        

        <br>

        <button class="btn btn-primary" type="button" onclick="calculate_all()">Calculate Channel Parameters & Lining Acceptability</button>

        <hr>

        <h1 class="headings">Calculated Grass & TRM Parameters</h1>
        <br>

        <br>


        <!--------  GRASS, TRM OUTPUT   -------->
        <div style="background-color: #EEEEEE;">  
          <br>
          <div class="row">
            <div class="span6">
              <div class="control-group">
                <label class="control-label text">Area of flow (A) </label>
                <div class="controls">
                  <div class="input-append">
                    <input type="text" name="area_flow" readonly="readonly" id="area_flow">
                    <span class="add-on">ft<sup>2</sup></span>
                  </div>
              </div>
              </div>
              <div class="control-group">
                <label class="control-label text">Wetted perimeter (P) </label>
                <div class="controls">
                  <div class="input-append">
                    <input type="text" name="wetted_perimeter" readonly="readonly" id="wetted_perimeter">
                    <span class="add-on">ft</span>
                  </div>
                </div>
              </div>
              
              <div class="control-group">
                <label class="control-label text">Hydraulic Radius (R)</label>
                <div class="controls">
                  <input type="text" name="hyd_radius" readonly="readonly" id="hyd_radius">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label text">Average Velocity</label>
                <div class="controls">
                  <div class="input-append">
                    <input type="text" name="avg_velocity" readonly="readonly" id="avg_velocity">
                    <span class="add-on">ft/s</span>
                  </div>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label text">Manning Roughness (n)</label>
                <div class="controls">
                  <div class="input-append">
                    <input type="text" name="m_roughness" id="m_roughness" readonly="readonly">
                    <span class="add-on">ft<sup>2</sup></span>
                  </div>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label text">Maximum shear stress on channel bottom</label>
                <div class="controls">
                  <div class="input-append">
                    <input type="text" name="shear_stress" readonly="readonly" id="shear_stress">
                    <span class="add-on">lb/ft<sup>2</sup></span>
                  </div>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label text">Compare to permissible shear stress</label>
                <div class="controls">
                  <input type="text" id="comp_2_perm_shear_stress" name="comp_2_perm_shear_stress" readonly="readonly">
                </div>
              </div>

            </div>

            <div class="span6">
              <div class="control-group">
                <label class="control-label text">Final Depth</label>
                <div class="controls">
                  <div class="input-append">
                    <input type="text" name="final_depth" readonly="readonly" id="final_depth">
                    <span class="add-on">ft</span>
                  </div>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label text">Top width</label>
                <div class="controls">
                  <div class="input-append">
                    <input type="text" name="top_width" readonly="readonly" id="top_width">
                    <span class="add-on">ft</span>
                  </div>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label text">Final Discharge (Q)</label>
                <div class="controls">
                  <div class="input-append">
                    <input type="text" name="final_discharge" readonly="readonly" id="final_discharge">
                    <span class="add-on">ft<sup>3</sup>/s</span>
                  </div>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label text">Discharge Internation Check</label>
                <div class="controls">
                  <input type="text" name="discharge_interation_check" readonly="readonly" id="discharge_interation_check">
                </div>
              </div>

              <br>
              <br>              
              
              <div class="control-group">
                <label class="control-label text">Permissible soil/vegetation shear stress</label>
                <div class="controls">
                  <div class="input-append">
                    <input type="text" name="perm_soil_veg_shear_stress" id="perm_soil_veg_shear_stress" readonly="readonly">
                    <span class="add-on">lb/ft<sup>2</sup></span>
                  </div>
                </div>
              </div>
              
              <div class="control-group">
                <label class="control-label text">Recommended TRM category</label>
                <div class="controls">
                  <input type="text" id="recco_trm_category" name="recco_trm_category" readonly="readonly">
                </div>
              </div>
            </div>

          </div>

          <!-- div style="margin-left: 25px;">
            <button class="btn" type="button" onclick="doIteration()">Check Acceptability</button>
          </div-->

          <br>
          <br>
        </div>


        <br>
        <h1 class="headings">Calculated Riprap</h1>
        <br>


        <!--------  RIPRAP OUTPUT   -------->
        <div style="background-color: #EEEEEE;">
          <br>
          <div class="row">
            <div class="span6">
              <h4 style="margin-left: 25px;">Riprap Type 1</h4>
              <br>
              <div class="control-group">
                  <label class="control-label text">Minimum Stable D<sub>50</sub></label>
                  <div class="controls">
                    <div class="input-append">
                      <input type="text" name="minimum_stable_d1" readonly="readonly" id="minimum_stable_d1">
                      <span class="add-on">ft</span>
                    </div>
                  </div>
              </div>
              <div class="control-group">
                <label class="control-label text">Riprap</label>
                <div class="controls">
                  <input type="text" id="recommended_riprap1" name="recommended_riprap1" readonly="readonly">
                </div>
              </div>
            </div>
            <div class="span6">
              <div class="control-group">
                <h4 style="margin-left: 25px;">Riprap Type 3</h4>
                <br>
                <div class="control-group">
                  <label class="control-label text">Minimum Stable D<sub>50</sub></label>
                  <div class="controls">
                    <div class="input-append">
                      <input type="text" name="minimum_stable_d3" readonly="readonly" id="minimum_stable_d3">
                      <span class="add-on">ft</span>
                    </div>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label text">Riprap</label>
                  <div class="controls">
                    <input type="text" id="recommended_riprap3" name="recommended_riprap3" readonly="readonly">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <br>

        <div style="border-top: 1px solid #EEE;"></div>

        <br>

        <!----------  BUTTONS  ---------->
        <div style="width: 25%; margin: 0px auto;">
          <button type="submit" class="btn">Submit</button>
          <button type="reset" class="btn" style="margin-left: 20px;">Reset</button>
        </div>


      </form>
    </div>

  	<script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script type="text/javascript">
      $('#optionsRadios2').change(function() {
        $('#manning_override').attr("readonly", false);
        setManningOverride();
      });
      $('#optionsRadios1').change(function() {
        $('#manning_override').val("");
        $('#manning_override').attr("readonly", true);
        unsetManningOverride();
      });
    </script>
    
    <!--script type="text/javascript">
      $(function() {
        $('[rel=tooltip]').tooltip();
      });
    </script-->
  </body>
</html>
