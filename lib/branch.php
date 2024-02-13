<?php
	include_once("../includes/db_connect.php");
	include_once("../includes/functions.php");
	if($_REQUEST[act]=="save_branch")
	{
		save_branch();
		exit;
	}
	if($_REQUEST[act]=="delete_branch")
	{
		delete_branch();
		exit;
	}
	
	###Code for save branch#####
	function save_branch()
	{
		global $con;
		$R=$_REQUEST;
		
		$facility_id = implode(",",$R['branch_facility_id']);
		if($R[branch_id])
		{
			$statement = "UPDATE `branch` SET";
			$cond = "WHERE `branch_id` = '$R[branch_id]'";
			$msg = "Data Updated Successfully.";
		}
		else
		{
			$statement = "INSERT INTO `branch` SET";
			$cond = "";
			$msg="Data saved successfully.";
		}
		
		$SQL=   $statement." 
				`branch_name` = '$R[branch_name]', 
				`branch_address` = '$R[branch_address]', 
				`branch_contact` = '$R[branch_contact]', 
				`branch_manager` = '$R[branch_manager]', 
				`branch_ifsc` = '$R[branch_ifsc]', 
				`branch_email` = '$R[branch_email]', 
				`branch_city` = '$R[branch_city]', 
				`branch_state` = '$R[branch_state]', 
				`branch_country` = '$R[branch_country]'
				". 
				 $cond;
		$rs = mysqli_query($con,$SQL) or die(mysqli_error($con));
		header("Location:../branch-report.php?msg=$msg");
	}
#########Function for delete branch##########3
function delete_branch()
{	
	global $con;
	/////////Delete the record//////////
	$SQL="DELETE FROM branch WHERE branch_id = $_REQUEST[branch_id]";
	mysqli_query($con,$SQL) or die(mysqli_error($con));
	header("Location:../branch-report.php?msg=Deleted Successfully.");
}
?>