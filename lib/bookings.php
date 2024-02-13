<?php
	session_start();
	include_once("../includes/db_connect.php");
	include_once("../includes/functions.php");
	if($_REQUEST[act]=="save_booking")
	{
		save_booking();
		exit;
	}
	if($_REQUEST[act]=="delete_booking")
	{
		delete_booking();
		exit;
	}
	if($_REQUEST[act]=="get_report")
	{
		get_report();
		exit;
	}
	###Code for save booking#####
	function save_booking()
	{
		global $con;
		$R=$_REQUEST;
		/////////////////////////////////////
		$image_name = $_FILES[booking_image][name];
		$location = $_FILES[booking_image][tmp_name];
		if($image_name!="")
		{
			move_uploaded_file($location,"../uploads/".$image_name);
		}
		else
		{
			$image_name = $R[avail_image];
		}
		if($R[booking_id])
		{
			$statement = "UPDATE `booking` SET";
			$cond = "WHERE `booking_id` = '$R[booking_id]'";
			$msg = "Data Updated Successfully.";
			$condQuery = "";
		}
		else
		{
			$statement = "INSERT INTO `booking` SET";
			$condQuery = "`booking_bookingname` = '$R[booking_bookingname]', 
						  `booking_password` = '$R[booking_password]',"; 
			$cond = "";
			$msg="Data saved successfully.";
		}
		$SQL=   $statement." 
				`booking_name` = '$R[booking_name]', 
				`booking_description` = '$R[booking_description]', 
				`booking_image` = '$image_name'". 
				 $cond;
		$rs = mysqli_query($con,$SQL) or die(mysqli_error($con));
		
		header("Location:../booking-report.php?msg=$msg");
	}
#########Function for delete booking##########3
function delete_booking()
{
	global $con;
	$SQL="SELECT * FROM booking WHERE booking_id = $_REQUEST[booking_id]";
	$rs=mysqli_query($con,$SQL);
	$data=mysqli_fetch_assoc($rs);
	
	/////////Delete the record//////////
	$SQL="DELETE FROM booking WHERE booking_id = $_REQUEST[booking_id]";
	mysqli_query($con,$SQL) or die(mysqli_error($con));
	
	//////////Delete the Passegars///////////
	$SQL="DELETE FROM passengar WHERE passengar_booking_id = $_REQUEST[booking_id]";
	mysqli_query($con,$SQL) or die(mysqli_error($con));
	
	
	header("Location:../booking-report.php?msg=Deleted Successfully.");
}
?>
