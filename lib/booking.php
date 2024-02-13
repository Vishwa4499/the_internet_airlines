<?php
	include_once("../includes/db_connect.php");
	include_once("../includes/functions.php");
	$R = $_REQUEST;
	$count = 0;
	global $con;
	//// Get the fare details //////
	$SQL = "SELECT * FROM route WHERE route_id = $R[route_id]";
	$rs = mysqli_query($con,$SQL) or die(mysqli_error($con));
	$data = mysqli_fetch_assoc($rs);
	if($R['class'] == 'Economy')
		$fare = $data['route_economy_fare'];
	if($R['class'] == 'Business')
		$fare = $data['route_business_fare'];
	///Save Adult Details ////
	if(count($R['adult_name']))
	{
		for($i=0; $i<count($R['adult_name']); $i++)
		{
			$passengar_name[$count] =  $R['adult_name'][$i];
			$passengar_gender[$count] =  $R['adult_gender'][$i]; 
			$passengar_age[$count] =  $R['adult_age'][$i];
			$passengar_type[$count] = 'adult';
			$count++; 
		}
	}
	///Save Child Details ////
	if(count($R['child_name']))
	{
		for($i=0; $i<count($R['child_name']); $i++)
		{
			$passengar_name[$count] =  $R['child_name'][$i];
			$passengar_gender[$count] =  $R['child_gender'][$i]; 
			$passengar_age[$count] =  $R['child_age'][$i];
			$passengar_type[$count] = 'child';
			$count++; 
		}
	}
	///Save Infant Details ////
	if(count($R['infant_name']))
	{
		for($i=0; $i<count($R['infant_name']); $i++)
		{
			$passengar_name[$count] =  $R['infant_name'][$i];
			$passengar_gender[$count] =  $R['infant_gender'][$i]; 
			$passengar_age[$count] =  $R['infant_age'][$i];
			$passengar_type[$count] = 'infant';
			$count++; 
		}
	}
	//// Save details into booking /////
	$total_fare = $fare*(count($R['adult_name']) + count($R['child_name'])) + (($fare/4)*count($R['infant_name']));
	$statement = "INSERT INTO `booking` SET";
	$cond = "";
	$msg="Data saved successfully.";
	$today_date = date('d F, Y');
	$SQL=   $statement." 
		`booking_user_id` = '".$_SESSION['user_details']['user_id']."', 
		`booking_route_id` = '$R[route_id]', 
		`booking_date` = '$today_date', 
		`booking_total_fare` = '$total_fare', 
		`booking_journey_date` = '$R[book_date]', 
		`booking_seat_type` = '$R[class]'
		". 
		 $cond;
	$rs = mysqli_query($con,$SQL) or die(mysqli_error($con));
	$bookingId = mysqli_insert_id($con);
	///Insert Passengar details into table ////
	for($i=0; $i<count($passengar_name); $i++) {
		$SQL = "INSERT INTO `passengar` (`passengar_booking_id`, `passengar_type`, `passengar_name`, `passengar_gender`, `passengar_age`, `passengar_seat_no`) VALUES ('$bookingId', '$passengar_type[$i]', '$passengar_name[$i]', '$passengar_gender[$i]', '$passengar_age[$i]', '1234');";
		$rs = mysqli_query($con,$SQL) or die(mysqli_error($con));
	}
	header("Location:../make_payment.php?booking_id=$bookingId");
?>
