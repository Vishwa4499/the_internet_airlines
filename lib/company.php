<?php
	session_start();
	include_once("../includes/db_connect.php");
	include_once("../includes/functions.php");
	if($_REQUEST[act]=="save_company")
	{
		save_company();
		exit;
	}
	if($_REQUEST[act]=="delete_company")
	{
		delete_company();
		exit;
	}
	if($_REQUEST[act]=="get_report")
	{
		get_report();
		exit;
	}
	###Code for save company#####
	function save_company()
	{
		global $con;
		$R=$_REQUEST;
		/////////////////////////////////////
		$image_name = $_FILES[company_image][name];
		$location = $_FILES[company_image][tmp_name];
		if($image_name!="")
		{
			move_uploaded_file($location,"../uploads/".$image_name);
		}
		else
		{
			$image_name = $R[avail_image];
		}
		if($R[company_id])
		{
			$statement = "UPDATE `company` SET";
			$cond = "WHERE `company_id` = '$R[company_id]'";
			$msg = "Data Updated Successfully.";
			$condQuery = "";
		}
		else
		{
			$statement = "INSERT INTO `company` SET";
			$condQuery = "`company_companyname` = '$R[company_companyname]', 
						  `company_password` = '$R[company_password]',"; 
			$cond = "";
			$msg="Data saved successfully.";
		}
		$SQL=   $statement." 
				`company_name` = '$R[company_name]', 
				`company_description` = '$R[company_description]', 
				`company_image` = '$image_name'". 
				 $cond;
		$rs = mysqli_query($con,$SQL) or die(mysqli_error($con));
		
		header("Location:../company-report.php?msg=$msg");
	}
#########Function for delete company##########3
function delete_company()
{
	global $con;
	$SQL="SELECT * FROM company WHERE company_id = $_REQUEST[company_id]";
	$rs=mysqli_query($con,$SQL);
	$data=mysqli_fetch_assoc($rs);
	
	/////////Delete the record//////////
	$SQL="DELETE FROM company WHERE company_id = $_REQUEST[company_id]";
	mysqli_query($con,$SQL) or die(mysqli_error($con));
	
	//////////Delete the image///////////
	if($data[company_image])
	{
		unlink("../uploads/".$data[company_image]);
	}
	header("Location:../company-report.php?msg=Deleted Successfully.");
}
?>
