/* 
 * By:
 * Devadas Mallya
 *
 */

/*   GRASS AND TRM   */
var unit_weight_of_water = 62.4;

var c1 = "", c2 = "", c3 = "", c4 = "", c5 = "", c6 = "", grass_cover_factor, soil_grain_roughness;	/* Constants and coefficients */                                                                                                                                                

var soil_classf, permissible_soil_shear_stress, pi, void_ratio, soilD, alpha = 0.026;

var grass_type, stem_height, grass_density, grass_roughness_coeff, manning_roughness;

var channel_geometry, left_slope, right_slope, bottom_width, long_slope, initial_water_depth, discharge;

var area_flow, wetted_perimeter, top_width, hyd_radius, final_discharge, avg_velocity, discharge_interation_check, final_depth, shear_stress, perm_soil_veg_shear_stress;

var compare_permissible_shear_stress, recommend;

var manningOverride = false;


/*     RIPRAP    */
var kinematic_viscosity = 0.00001217, specific_gravity_riprap = 2.65, unit_weight_of_water = 62.4, type1 = 1.2, type3 = 0.66;

var riprap_type, riprap_size, avg_flow_depth, shear_velocity, reynolds_number1, reynolds_number3, shields_parameter1, shields_parameter3, safety_factor1, safety_factor3;

var minimum_stable_d1, minimum_stable_d3, recommended_riprap1, recommended_riprap3;


function reset_coeffs()
{
    c1 = c2 = c3 = c4 = c5 = c6 = "";
}

function calculate_coeffs()
{
    reset_coeffs();

    calculate_c2();

    calculate_c1();
    
    if(pi == undefined || pi == "")
    {
        document.getElementById("c3_value").innerHTML = "";
        document.getElementById("c4_value").innerHTML = "";
        document.getElementById("c5_value").innerHTML = "";
        document.getElementById("c6_value").innerHTML = "";
        c3 = c4 = c5 = c6 = undefined;
    }
    else{
        calculate_c3();

        calculate_c4();

        calculate_c5();

        calculate_c6();        
    }
}

function get_pi()
{
    pi = document.getElementById("pi").value;
    calculate_coeffs();
    calculate_permissible_soil_shear_stress();
}

function get_soil_classf()
{
    var e = document.getElementById("soil_classf");
    soil_classf = e.options[e.selectedIndex].value;
    calculate_coeffs();
    calculate_permissible_soil_shear_stress();
}

function get_vr()
{
    void_ratio = document.getElementById("vr").value;
    calculate_coeffs();
    calculate_permissible_soil_shear_stress();
}

function get_soilD()
{
    soilD = document.getElementById("soilD").value;
    calculate_coeffs();
    calculate_permissible_soil_shear_stress();
    calculate_soil_grain_roughness();    
}

function get_grassType()
{
    var e;
    e = document.getElementById("grass_type");
    grass_type = e.options[e.selectedIndex].value;
    calculate_grass_roughness_coefficient();
    calculate_grass_cover_factor();
}

function get_stemHeight()
{
    var e;
    e = document.getElementById("stem_height");
    stem_height = e.options[e.selectedIndex].value;
    calculate_grass_roughness_coefficient();
    calculate_grass_cover_factor();
}

function get_grassDensity()
{
    var e;
    e = document.getElementById("grass_density");
    grass_density = e.options[e.selectedIndex].value;
    calculate_grass_roughness_coefficient();
    calculate_grass_cover_factor();
}

function calculate_grass_roughness_coefficient()
{
    grass_roughness_coeff = "";
    
    switch(grass_density)
    {
                    case "Excellent":
                            if(stem_height == "0.25")
                            {
                                    grass_roughness_coeff = 0.168;
                            }
                            else if(stem_height == "0.50")
                            {
                                    grass_roughness_coeff = 0.243;
                            }
                            else if(stem_height == "0.75")
                            {
                                    grass_roughness_coeff = 0.301;
                            }
                            else if(stem_height == "1.00")
                            {
                                    grass_roughness_coeff = 0.35;
                            }
                            break;

                    case "Poor":
                            if(stem_height == "0.25")
                            {
                                    grass_roughness_coeff = 0.111;
                            }
                            else if(stem_height == "0.50")
                            {
                                    grass_roughness_coeff = 0.159;
                            }
                            else if(stem_height == "0.75")
                            {
                                    grass_roughness_coeff = 0.197;
                            }
                            else if(stem_height == "1.00")
                            {
                                    grass_roughness_coeff = 0.23;
                            }
                            break;

                    case "Good":
                            if(stem_height == "0.25")
                            {
                                    grass_roughness_coeff = 0.142;
                            }
                            else if(stem_height == "0.50")
                            {
                                    grass_roughness_coeff = 0.205;
                            }
                            else if(stem_height == "0.75")
                            {
                                    grass_roughness_coeff = 0.254;
                            }
                            else if(stem_height == "1.00")
                            {
                                    grass_roughness_coeff = 0.295;
                            }
                            break;
    }
    document.getElementById("grass_roughness_coeff").value = grass_roughness_coeff.toFixed(3);
    //calculate_grass_cover_factor();
}

function calculate_grass_cover_factor()
{
    grass_cover_factor = "";

    if(grass_type == undefined || grass_type == "" || grass_density == undefined || grass_density == "")
        return;
    
    if(grass_type == "Mixed" && grass_density == "Excellent")
    {
                    grass_cover_factor = 0.82;
    }
    else if(grass_type == "Mixed" && grass_density == "Good")
    {
                    grass_cover_factor = 0.75;
    }
    else if(grass_type == "Mixed" && grass_density == "Poor")
    {
                    grass_cover_factor = 0.62;
    }
    else if(grass_type == "Sod" && grass_density == "Excellent")
    {
                    grass_cover_factor = 0.98;
    }
    else if(grass_type == "Sod" && grass_density == "Good")
    {
                    grass_cover_factor = 0.9;
    }
    else if(grass_type == "Sod" && grass_density == "Poor")
    {
                    grass_cover_factor = 0.75;
    }
    else if(grass_type == "Bunch" && grass_density == "Excellent")
    {
                    grass_cover_factor = 0.55;
    }
    else if(grass_type == "Bunch" && grass_density == "Good")
    {
                    grass_cover_factor = 0.5;
    }
    else if(grass_type == "Bunch" && grass_density == "Poor")
    {
                    grass_cover_factor = 0.41;
    }

    //document.getElementById("cf_value").innerHTML = grass_cover_factor;
}

function calculate_soil_grain_roughness()
{
    soil_grain_roughness = "";
    
    if(soilD >= 0.05)
    {
            soil_grain_roughness = 0.026 * Math.pow(soilD, (1/6))
    }
    else
    {
            soil_grain_roughness = 0.016;
    }

    //document.getElementById("ns_value").innerHTML = soil_grain_roughness.toFixed(6);
}

function calculate_permissible_soil_shear_stress()
{ 
        if(void_ratio == undefined || void_ratio == "")
            return;

        if(soilD == undefined || soilD == "")
            return;


        if(soil_classf.substr(0, 2) == "SW" || soil_classf.substr(0, 2) == "SP" || soil_classf.substr(0, 2) == "SM" || soil_classf.substr(0, 2) == "SC" || soil_classf.substr(0, 2) == "ML" || soil_classf.substr(0, 2) == "CL")
        {
            if( (soil_classf.substr(0, 2) == "SW" || soil_classf.substr(0, 2) == "SP") && (pi < 10 && soilD >= 0.05 && soilD <= 2) )
                permissible_soil_shear_stress =  alpha * soilD;            
            else if(pi < 10 && soilD < 0.05)
                permissible_soil_shear_stress = 0.02
            else if(pi >= 10 && pi < 20)
                permissible_soil_shear_stress = 0.06;
            else if(pi >= 20)
                permissible_soil_shear_stress = 0.085;
        }
        else if(soil_classf.substr(0, 2) == "MH" && pi >= 20)
        {
            permissible_soil_shear_stress = 0.085;
        }
        else if(soil_classf.substr(0, 2) == "CH" && pi >= 20)
        {
            permissible_soil_shear_stress = 0.12;
        }
        else if(soil_classf.substr(0, 2) == "GC")
        {
            if(pi >= 10 && pi < 20)
                permissible_soil_shear_stress = 0.125;
            else if(pi >= 20)
                permissible_soil_shear_stress = 0.15;
        }
        else if( (soil_classf.substr(0, 2) == "GW" || soil_classf.substr(0, 2) == "GP") && (pi < 10) && (soilD >= 0.05 && soilD <= 2) )
        {
            permissible_soil_shear_stress = alpha * soilD;
        }
        else
        {
            if(c1 != "" && c2 != "" && c3 != "" && c4 != "" && c5 != "" && c6 != "")
                permissible_soil_shear_stress = 1.0 * ( (c1 * Math.pow(pi, 2)) + (c2 * pi) + c3 ) * Math.pow((c4 + c5 * void_ratio), 2) * c6;
            else
                permissible_soil_shear_stress = 0.0;
        }

        //document.getElementById("permissible_soil_shear_stress").value = permissible_soil_shear_stress.toFixed(4);

        if (permissible_soil_shear_stress.toFixed) //if browser supports toFixed() method
        {
            document.getElementById("permissible_soil_shear_stress").value = permissible_soil_shear_stress.toFixed(4);
        }
        else{
            document.getElementById("permissible_soil_shear_stress").value = permissible_soil_shear_stress;
        }
}

function setManningOverride()
{
    manningOverride = true;
}

function unsetManningOverride()
{
    manningOverride = false;
}

function overrideManning()
{
    manning_roughness = 1.0 * document.getElementById("manning_override").value;
}

function calculate_manning_roughness()
{
    if(!manningOverride)
    {
        manning_roughness = 0.213 * grass_roughness_coeff * Math.pow((unit_weight_of_water * long_slope * initial_water_depth),-0.4);
    }
    

    document.getElementById("m_roughness").value = manning_roughness.toFixed(3);
}

function slopes()
{
        var e;

        e = document.getElementById("channel_geometry");
        channel_geometry = e.options[e.selectedIndex].value;

        switch(channel_geometry)
        {
            case "Trapezoidal":
                    document.getElementById("left_slope").readOnly=false;
                    document.getElementById("right_slope").readOnly=false;                        
                    break;


            case "Triangular":
                    document.getElementById("left_slope").readOnly=false;
                    document.getElementById("right_slope").readOnly=false;                        
                    break;

            case "Rectangular":
                    document.getElementById("left_slope").readOnly=true;
                    document.getElementById("right_slope").readOnly=true;                                              
                    break;

            case "Parabolic":
                    document.getElementById("left_slope").readOnly=true;
                    document.getElementById("right_slope").readOnly=true;                        
                    break;
        }
}

function get_leftSlope()
{
    left_slope = document.getElementById("left_slope").value;
}

function get_rightSlope()
{
    right_slope = document.getElementById("right_slope").value;
}

function get_bottomWidth()
{
    bottom_width = document.getElementById("bottom_width").value;
}

function get_longSlope()
{
    long_slope = document.getElementById("long_slope").value;
}

function get_water_depth()
{
    initial_water_depth = document.getElementById("initial_water_depth").value;
}

function get_discharge()
{
    discharge = document.getElementById("discharge").value;
}

function set_water_depth()
{
    document.getElementById("initial_water_depth").value = initial_water_depth.toFixed(3);
}

function calculate_c1()
{
        switch(soil_classf.substr(0, 2))
        {
                case "CH":
                        c1 = 0.0;
                        break;

                case "GC":
                        c1 = 0.0477;
                        break;

                case "GM":
                case "SM":
                case "SC":
                case "ML":
                case "CL":
                        c1 = 1.07;
                        break;

                default:
                        if(c2 > 0)
                        {
                            c1 = 0.0477;
                        }
                        else
                        {
                            c1 = "";
                        }
        }

        /*if(c1 != undefined)
        {
            document.getElementById("c1_value").innerHTML = c1;
        }*/
}

function calculate_c2()
{
    switch(soil_classf.substr(0, 2))
    {
            case "GC":
                    c2 = 2.86;
                    break;

            case "GM":
                    c2 = 14.3;
                    break;

            case "SM":
                    c2=7.15;
                    break;

            case "SC":
                    c2=14.3
                    break;

            case "ML":
                    c2=7.15;
                    break;

            case "CL":
                    c2 = 14.3;
                    break;

            case "CH":
                    c2 = 0;
                    break;

            case "MH":
                    c2=1.43;
                    break;

            default:
                c2="";
    }
    /*if(c2 != undefined)
    {
        document.getElementById("c2_value").innerHTML = c2;
    }*/
}

function calculate_c3()
{
        if(pi >= 20)
        {
                switch(soil_classf.substr(0, 2))
                {
                        case "GM":
                                c3 = 0.076;
                                break;

                        case "GC":
                                c3 = 0.119; 
                                break;

                        case "SM":
                                c3 = 0.058;
                                break;

                        case "SC":
                                c3 = 0.076;
                                break;

                        case "ML":
                                c3 = 0.058;
                                break;

                        case "CL":
                                c3 = 0.076;
                                break;

                        case "MH":
                                c3 = 0.058;
                                break;

                        case "CH":
                                c3 = 0.097;
                }
        }
        else
        {
                switch(soil_classf.substr(0, 2))
                {
                        case "GM":
                                c3 = 47.7;
                                break;

                        case "GC":
                                c3 = 42.9;  
                                break;

                        case "SM":
                                c3 = 11.9;
                                break;

                        case "SC":
                                c3 = 47.7;
                                break;

                        case "ML":
                                c3 = 11.9;
                                break;

                        case "CL":
                                c3 = 47.7;
                                break;

                        case "MH":
                                c3 = 10.7;
                                break;

                        default:
                }

        }

        /*if(c3 != undefined)
        {
            document.getElementById("c3_value").innerHTML = c3;         
        }*/
}

function calculate_c4()
{
        if(pi >= 20)
        {
                switch(soil_classf.substr(0, 2))
                {
                        case "GM":
                                c4 = 1.42;
                                break;

                        case "GC":
                                c4 = 1.42;  
                                break;

                        case "SM":
                                c4 = 1.42;
                                break;

                        case "SC":
                                c4 = 1.42;
                                break;

                        case "ML":
                                c4 = 1.48;
                                break;

                        case "CL":
                                c4 = 1.48;
                                break;

                        case "MH":
                                c4 = 1.38;
                                break;

                        case "CH":
                                c4 = 1.38;
                }
        }
        else
        {
                switch(soil_classf.substr(0, 2))
                {
                        case "GM":
                                c4 = 1.42;
                                break;

                        case "GC":
                                c4 = 1.42;  
                                break;

                        case "SM":
                                c4 = 1.42;
                                break;

                        case "SC":
                                c4 = 1.42;
                                break;

                        case "ML":
                                c4 = 1.48;
                                break;

                        case "CL":
                                c4 = 1.48;
                                break;

                        case "MH":
                                c4 = 1.38;
                                break;
                }
        }

        /*if(c4 != undefined)
        {
            document.getElementById("c4_value").innerHTML = c4;
        }*/
}

function calculate_c5()
{
        if(pi >= 20)
        {
                switch(soil_classf.substr(0, 2))
                {
                        case "GM":
                                c5 = -0.61;
                                break;

                        case "GC":
                                c5 = -0.61; 
                                break;

                        case "SM":
                                c5 = -0.61;
                                break;

                        case "SC":
                                c5 = -0.61;
                                break;

                        case "ML":
                                c5 = -0.57;
                                break;

                        case "CL":
                                c5 = -0.57;
                                break;

                        case "MH":
                                c5 = -0.373;
                                break;

                        case "CH":
                                c5 = -0.373;
                }
        }
        else
        {
                switch(soil_classf.substr(0, 2))
                {
                        case "GM":
                                c5 = -0.61;
                                break;

                        case "GC":
                                c5 = -0.61; 
                                break;

                        case "SM":
                                c5 = -0.61;
                                break;

                        case "SC":
                                c5 = -0.61;
                                break;

                        case "ML":
                                c5 = -0.57;
                                break;

                        case "CL":
                                c5 = -0.57;
                                break;

                        case "MH":
                                c5 = -0.373;
                                break;
                }
        }

        /*if(c5 != undefined)
        {
            document.getElementById("c5_value").innerHTML = c5;
        }*/
}

function calculate_c6()
{
        if(pi >= 20)
        {
                switch(soil_classf.substr(0, 2))
                {
                        case "GM":
                                c6 = 1;
                                break;

                        case "GC":
                                c6 = 1; 
                                break;

                        case "SM":
                                c6 = 1;
                                break;

                        case "SC":
                                c6 = 1;
                                break;

                        case "ML":
                                c6 = 1;
                                break;

                        case "CL":
                                c6 = 1;
                                break;

                        case "MH":
                                c6 = 1;
                                break;

                        case "CH":
                                c6 = 1;
                }
        }
        else
        {
                switch(soil_classf.substr(0, 2))
                {
                        case "GM":
                                c6 = 0.0001;
                                break;

                        case "GC":
                                c6 = 0.001; 
                                break;

                        case "SM":
                                c6 = 0.0001;
                                break;

                        case "SC":
                                c6 = 0.0001;
                                break;

                        case "ML":
                                c6 = 0.0001;
                                break;

                        case "CL":
                                c6 = 0.0001;
                                break;

                        case "MH":
                                c6 = 0.001;
                                break;
                }
        }
}

function calculate_all()
{
    /*  GRASS AND TRM  */

    if((grass_roughness_coeff != undefined) && (long_slope != undefined) && (initial_water_depth != undefined) && (grass_roughness_coeff != "") && (long_slope != "") && (initial_water_depth != ""))
    {
        calculate_manning_roughness();
    }
    else
    {
        document.getElementById("m_roughness").value = "";
    }

    calculate_area_of_flow();

    calculate_wetted_perimeter();

    calculate_top_width();

    calculate_hydraulic_radius();

    calculate_final_discharge();

    calculate_avg_velocity();
    
    if( (discharge != undefined) && (discharge != "") ){
        calculate_discharge_interation_check();
    }
    
    calculate_final_depth();

    calculate_shear_stress();

    calculate_perm_soil_veg_shear_stress();

    calculate_compare_permissible_shear_stress();

    calculate_recommend();

    /* Iterate */

    doIteration();

    /*  RIPRAP  */

    calculate_shear_velocity();

    calculate_reynolds_number();

    calculate_shields_parameter();

    calculate_safety_factor();

    calculate_minimum_stable_d();

    calculate_recommended_riprap();
}

function calculate_area_of_flow()
{
    switch(channel_geometry)
    {
            case "Trapezoidal":
                    area_flow = (bottom_width * initial_water_depth) + 0.5 * left_slope * Math.pow(initial_water_depth, 2) + 0.5 * right_slope * Math.pow(initial_water_depth, 2);
                    break;

            case "Rectangular":
                    area_flow = 1.0 * bottom_width * initial_water_depth;
                    break;

            case "Triangular":
                    area_flow = 0.5 * left_slope * Math.pow(initial_water_depth, 2) + 0.5 * right_slope * Math.pow(initial_water_depth, 2);
                    break;

            case "Parabolic":
                    area_flow = 0.6666667 * bottom_width * initial_water_depth;
                    break;
    }

    document.getElementById("area_flow").value = area_flow.toFixed(2);
}

function calculate_wetted_perimeter()
{
    wetted_perimeter = "";

    switch(channel_geometry)
    {
            case "Trapezoidal":
                    wetted_perimeter = 1.0 * bottom_width+initial_water_depth * Math.pow( (Math.pow(left_slope, 2) + 1), 0.5) + initial_water_depth * Math.pow( (Math.pow(right_slope, 2) + 1), 0.5);
                    break;

            case "Rectangular":
                    wetted_perimeter = 1.0 * bottom_width + (2 * initial_water_depth);
                    break;

            case "Triangular":
                    wetted_perimeter = 1.0 * initial_water_depth * Math.pow( Math.pow(left_slope, 2) + 1, 0.5 ) + initial_water_depth * Math.pow(Math.pow(right_slope, 2) + 1, 0.5);
                    break;

            case "Parabolic":
                    wetted_perimeter = 0.5 * Math.pow( (16 * Math.pow(initial_water_depth, 2) + Math.pow(bottom_width, 2) ), 0.5) + Math.pow(bottom_width, 2) / (8 * initial_water_depth) * Math.log( (4 * initial_water_depth + Math.pow(( 16 * Math.pow(initial_water_depth, 2) + Math.pow(bottom_width, 2)), 0.5) ) / bottom_width );
                    break;
    }
    document.getElementById("wetted_perimeter").value = wetted_perimeter.toFixed(2);
}

function calculate_top_width()
{
    top_width = "";

    switch(channel_geometry)
    {
            case "Trapezoidal":
                    top_width = 1.0 * bottom_width + left_slope * initial_water_depth + right_slope * initial_water_depth;
                    break;

            case "Rectangular":
                    top_width = 1.0 * bottom_width;
                    break;

            case "Triangular":
                    top_width = 1.0 * initial_water_depth * left_slope + initial_water_depth * right_slope;
                    break;

            case "Parabolic":
                    top_width = 1.0 * bottom_width;
                    break;
    }
    
    document.getElementById("top_width").value = top_width.toFixed(2);
    //calculate_hydraulic_radius();
}

function calculate_hydraulic_radius()
{
    hyd_radius = area_flow / wetted_perimeter;

    /*var str = hyd_radius.toFixed(10);

    str = str.substring(0, str.length - 7);

    hyd_radius = str;*/
  
    document.getElementById("hyd_radius").value = hyd_radius.toFixed(2);
    //calculate_final_discharge();
}

function calculate_final_discharge()
{
        final_discharge = 1.0 * (1.49 / manning_roughness) * area_flow * Math.pow(hyd_radius, 0.6667) * Math.pow(long_slope, 0.5);

        var str = final_discharge.toFixed(10);

        str = str.substring(0, str.length - 9);

        final_discharge = str;

        document.getElementById("final_discharge").value = final_discharge;

        //calculate_avg_velocity();
}

function calculate_avg_velocity()
{
        avg_velocity = final_discharge / area_flow;

        document.getElementById("avg_velocity").value = avg_velocity.toFixed(1);
}

function calculate_discharge_interation_check()
{
        discharge_interation_check = 1.0 * discharge - final_discharge;

        document.getElementById("discharge_interation_check").value = discharge_interation_check.toFixed(1);

        //calculate_final_depth();
}

function calculate_final_depth()
{
    final_depth = 1.0 * initial_water_depth;

    document.getElementById("final_depth").value = final_depth.toFixed(2);

    //calculate_shear_stress();
}

function calculate_shear_stress()
{
        shear_stress = 1.0 * initial_water_depth * long_slope * unit_weight_of_water;

        document.getElementById("shear_stress").value = shear_stress.toFixed(2);

        //calculate_perm_soil_veg_shear_stress();
}

function calculate_perm_soil_veg_shear_stress()
{
    perm_soil_veg_shear_stress = 1.0 * (permissible_soil_shear_stress / (1 - grass_cover_factor)) * Math.pow( (manning_roughness / soil_grain_roughness), 2 );

    document.getElementById("perm_soil_veg_shear_stress").value = perm_soil_veg_shear_stress.toFixed(2);
}

function calculate_compare_permissible_shear_stress()
{
        if( shear_stress < perm_soil_veg_shear_stress )
        {
                compare_permissible_shear_stress = "Grass only is acceptable";
        }
        else
        {
                compare_permissible_shear_stress = "Grass only is NOT acceptable";
        }

        //document.getElementById("comp_2_perm_shear_stress").innerHTML = compare_permissible_shear_stress;
        
        document.getElementById("comp_2_perm_shear_stress").value = compare_permissible_shear_stress;

        //calculate_recommend();
}

function calculate_recommend()
{
        if(shear_stress  < 2)
        {
                recommend = "Use TRM Type 1 or Higher";
        }
        else if(shear_stress >= 2 && shear_stress < 4)
        {
                recommend = "Use TRM Type 2 or Higher";
        }
        else if(shear_stress >=4 && shear_stress < 6)
        {
                recommend = "Use TRM Type 3 or Higher";
        }
        else if(shear_stress >= 6 && shear_stress < 8)
        {
                recommend = "Use TRM Type 4 or Higher";
        }
        else if(shear_stress >= 8 && shear_stress < 10)
        {
                recommend = "Use TRM Type 5 or Higher";
        }
        else if(shear_stress >= 10 && shear_stress < 12)
        {
                recommend = "Use TRM  Type 6";
        }
        else if(shear_stress >= 12)
        {
                recommend = "Check Riprap or Concrete";
        }
        document.getElementById("recco_trm_category").value = recommend;
}

function doIteration()
{
    var flag = new Boolean(false);
    var ctr = 0;
    var diff;
    
    if(discharge_interation_check.toFixed(1) == 0.0){
        return;
    }
    
    while(flag == false)
    {    
        if(discharge_interation_check > 0){            
            initial_water_depth = 1.0 * initial_water_depth + 0.0001;            
        }
        else
            if(discharge_interation_check < 0){
            initial_water_depth -= 0.0001;         
        }
        
        calculate_manning_roughness();
        
        calculate_area_of_flow();
        
        calculate_wetted_perimeter();
        
        calculate_top_width();
        
        calculate_hydraulic_radius();
        
        calculate_final_discharge();
        
        calculate_avg_velocity();
        
        calculate_discharge_interation_check();
        
        if( discharge_interation_check == 0 || discharge_interation_check.toFixed(1) == 0.0 )
        {
            flag = true;
            
            calculate_manning_roughness();
        
            calculate_area_of_flow();

            calculate_wetted_perimeter();

            calculate_top_width();

            calculate_hydraulic_radius();

            calculate_final_discharge();

            calculate_avg_velocity();
            
            calculate_discharge_interation_check();
            
            calculate_final_depth();
            
            calculate_shear_stress();
            
            calculate_perm_soil_veg_shear_stress();
            
            calculate_compare_permissible_shear_stress();
            
            calculate_recommend();
            
            set_water_depth();
        
        }        
        else
        {
            if(Math.abs(discharge_interation_check) > 100)
            {
                if(discharge_interation_check > 0){            
                    initial_water_depth = 1.0 * initial_water_depth + 0.01;            
                }
                else
                    if(discharge_interation_check < 0){
                    initial_water_depth -= 0.01;
                }
            }
        }
    } 
}

/*    RIPRAP    */

function calculate_shear_velocity()
{
    shear_velocity = Math.pow((32.2 * initial_water_depth * long_slope), 0.5);
}

function calculate_reynolds_number()
{
    reynolds_number1 = shear_velocity * type1 / kinematic_viscosity;
    reynolds_number3 = shear_velocity * type3 / kinematic_viscosity;
}

function calculate_shields_parameter()
{
    //Shields Parameter 1
    if( (reynolds_number1 > 40000) && (reynolds_number1 < 200000) )
    {
        shields_parameter1 = (reynolds_number1 - 40000)/(200000-40000) * (0.15 - 0.047) + 0.047;
    }
    else if(reynolds_number1 < 40000)
    {reynolds_number1
        shields_parameter1 = 0.047;
    }
    else if(reynolds_number1 >= 200000 )
    {
        shields_parameter1 = 0.15;
    }

    //Shields Parameter 3
    if( (reynolds_number3 > 40000) && (reynolds_number3 < 200000) )
    {
        shields_parameter3 = (reynolds_number3 - 40000)/(200000-40000) * (0.15 - 0.047) + 0.047;
    }
    else if(reynolds_number3 < 40000)
    {
        shields_parameter3 = 0.047;
    }
    else if(reynolds_number3 >= 200000 )
    {
        shields_parameter3 = 0.15;
    }
}

function calculate_safety_factor()
{
    //Safety Factor 1
    if( (reynolds_number1 > 40000) && (reynolds_number1 < 200000) )
    {
        safety_factor1 = (reynolds_number1 - 40000)/(200000-40000) * (1.5 - 1) + 1;
    }
    else if(reynolds_number1 < 40000)
    {
        safety_factor1 = 1;
    }
    else if(reynolds_number1 >= 200000 )
    {
        safety_factor1 = 1.5;
    }

    //Safety Factor 3
    if( (reynolds_number3 > 40000) && (reynolds_number3 < 200000) )
    {
        safety_factor3 = (reynolds_number3 - 40000)/(200000-40000) * (1.5 - 1) + 1;
    }
    else if(reynolds_number3 < 40000)
    {
        safety_factor3 = 1;
    }
    else if(reynolds_number3 >= 200000 )
    {
        safety_factor3 = 1.5;
    }
}

function calculate_minimum_stable_d()
{
    minimum_stable_d1 = (safety_factor1 * final_depth * long_slope)/(shields_parameter1 * (specific_gravity_riprap - 1))
    minimum_stable_d3 = (safety_factor3 * final_depth * long_slope)/(shields_parameter3 * (specific_gravity_riprap - 1))
    
    document.getElementById("minimum_stable_d1").value = minimum_stable_d1.toFixed(2);
    document.getElementById("minimum_stable_d3").value = minimum_stable_d3.toFixed(2);
}

function calculate_recommended_riprap()
{
    var output1, output3;

    if(minimum_stable_d1 <= type1)
        output1 = "STABLE";
    else
        output1 = "UNSTABLE";

    if(minimum_stable_d3 <= type3)
        output3 = "STABLE";
    else
        output3 = "UNSTABLE";

    /*
    //Type 1
    if(minimum_stable_d > 1.2)
        output = "Concrete Lining Required";
    else if(riprap_type == "Type3" && minimum_stable_d <= 0.66)
        output = "Riprap Type 3 is acceptable Lining";
    else if(riprap_type == "Type1" && calculate_minimum_stable_d <= 1.2 && calculate_minimum_stable_d > 0.66)
        output = "Riprap Type 1 is acceptable Lining";
    else
        output = "false";

    //Type 3
    if(minimum_stable_d > 1.2)
        output = "Concrete Lining Required";
    else if(riprap_type == "Type3" && minimum_stable_d <= 0.66)
        output = "Riprap Type 3 is acceptable Lining";
    else if(riprap_type == "Type1" && calculate_minimum_stable_d <= 1.2 && calculate_minimum_stable_d > 0.66)
        output = "Riprap Type 1 is acceptable Lining";
    else
        output = "false"; */

    document.getElementById("recommended_riprap1").value = output1;
    document.getElementById("recommended_riprap3").value = output3;
}