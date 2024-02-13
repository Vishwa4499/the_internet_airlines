<?php
	include_once("../includes/db_connect.php");
	include_once("../includes/functions.php");
	if($_REQUEST[act]=="save_route")
	{
		save_route();
		exit;
	}
	if($_REQUEST[act]=="delete_route")
	{
		delete_route();
		exit;
	}
	
	###Code for save route#####
	function save_route()
	{
		global $con;
		$R=$_REQUEST;						
		if($R[route_id])
		{
			$statement = "UPDATE `route` SET";
			$cond = "WHERE `route_id` = '$R[route_id]'";
			$msg = "Data Updated Successfully.";
		}
		else
		{
			$statement = "INSERT INTO `route` SET";
			$cond = "";
			$msg="Data saved successfully.";
		}
		$SQL=   $statement." 
				`route_train_id` = '$R[route_train_id]', 
				`route_from_city` = '$R[route_from_city]', 
				`route_from_arrival` = '$R[route_from_arrival]', 
				`route_from_departure` = '$R[route_from_departure]', 
				`route_to_city` = '$R[route_to_city]', 
				`route_economy_fare` = '$R[route_economy_fare]', 
				`route_business_fare` = '$R[route_business_fare]'". 
				 $cond;
		$rs = mysqli_query($con,$SQL) or die(mysqli_error($con));
		header("Location:../route-report.php?msg=$msg");
	}
#########Function for delete route##########3
function delete_route()
{	
	global $con;
	/////////Delete the record//////////
	$SQL="DELETE FROM route WHERE route_id = $_REQUEST[route_id]";
	mysqli_query($con,$SQL) or die(mysqli_error($con));
	header("Location:../route-report.php?msg=Deleted Successfully.");
}
?>
