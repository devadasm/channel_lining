<?php

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=data.csv');

	session_start();

	if( isset($_SESSION['query']) )
	{
		$query = $_SESSION['query'];
	}
	else
	{
		die("Sorry could not find data");
	}

	$output = fopen('php://output', 'w');
	fputcsv($output, array('Project Number', 'Upper Limit', 'Lower Limit', 'Channel Location', 'Soil Classification', 'Plasticity Index', 'Soil D75', 
						   'Permissible Soil Shear Stress', 'Grass Type', 'Stem Height', 'Density of Grass Cover', 'Grass Roughness Coefficient', 'Channel Geometery',
						   'Side Slope (Left)', 'Side Slope (Right)', 'Channel Bottom Width', 'Longitudinal Slope', 'Initial Water Depth Estimate', 'Discharge',
						   'Area of Flow', 'Wetted Perimeter', 'Top Width', 'Hydraulic Radius', 'Manning Roughness', 'Final Discharge', 'Average Velocity',
						   'Discharge Internation Check', 'Final Depth', 'Shear Stress', 'Permissible Soil', 'Compare to Permissible Shear Stress', 'Recommend TRM Category',
						   'ID','Minimum Stable D50 (Type 1)', 'Minimum Stable D50 (Type 3)', 'Riprap Type 1', 'Riprap Type 3'));

	require 'config.inc.php';
    require 'db.inc.php';
    $con = dbConnect();

	/*
	$con = mysql_connect('localhost', 'gdot', 'gdot');
	mysql_select_db("GDOT", $con);
	*/

	$rows = mysql_query($query, $con);
	while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);
	session_destroy();
	mysql_close($con);
?>