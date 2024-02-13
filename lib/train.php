<?php
	include_once("../includes/db_connect.php");
	include_once("../includes/functions.php");
	if($_REQUEST[act]=="save_train")
	{
		save_train();
		exit;
	}
	if($_REQUEST[act]=="delete_train")
	{
		delete_train();
		exit;
	}
	
	###Code for save train#####
	function save_train()
	{
		global $con;
		$R=$_REQUEST;						
		if($R[train_id])
		{
			$statement = "UPDATE `train` SET";
			$cond = "WHERE `train_id` = '$R[train_id]'";
			$msg = "Data Updated Successfully.";
		}
		else
		{
			$statement = "INSERT INTO `train` SET";
			$cond = "";
			$msg="Data saved successfully.";
		}
		$SQL=   $statement." 
				`train_tt_id` = '$R[train_tt_id]', 
				`train_name` = '$R[train_name]', 
				`train_no` = '$R[train_no]', 
				`train_from` = '$R[train_from]', 
				`train_deaprture` = '$R[train_deaprture]', 
				`train_to` = '$R[train_to]', 
				`train_arrival` = '$R[train_arrival]', 
				`train_travel_time` = '$R[train_travel_time]', 
				`train_total_distance` = '$R[train_total_distance]'". 
				 $cond;
		$rs = mysqli_query($con,$SQL) or die(mysqli_error($con));
		header("Location:../train-report.php?msg=$msg");
	}
#########Function for delete train##########3
function delete_train()
{	
	global $con;
	/////////Delete the record//////////
	$SQL="DELETE FROM train WHERE train_id = $_REQUEST[train_id]";
	mysqli_query($con,$SQL) or die(mysqli_error($con));
	header("Location:../train-report.php?msg=Deleted Successfully.");
}
?>
