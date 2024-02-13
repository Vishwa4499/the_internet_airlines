<?php
  session_start();
	include_once("includes/db_connect.php"); 
	if(!$_SESSION['login'])
	{
		$_SESSION['route_id'] = $_REQUEST['route_id'];
		$_SESSION['request'] = $_REQUEST;
		header("Location: login.php");
		exit();
	}
	include_once("includes/header.php"); 
	if($_SESSION['route_id'])
	{
		$_REQUEST = $_SESSION['request'];
		$_SESSION['route_id'] = "";
		$_SESSION['request'] = "";
	}
	$SQL="SELECT * FROM `route`, `company`, `airlines`,`city` WHERE route_from_city = city_id AND route_airlines_id = airlines_id AND airlines_company_id = company_id AND route_id = ".$_REQUEST['route_id'];
	$rs=mysqli_query($con,$SQL) or die(mysqli_error($con));
	$data = mysqli_fetch_assoc($rs);
	$SQL = "SELECT * FROM city WHERE city_id = ".$data['route_to_city'];
	$rs1 = mysqli_query($con,$SQL) or die(mysqli_error($con));
	$data1 = mysqli_fetch_assoc($rs1);
?>
<script>
function delete_airlines(airlines_id)
{
	if(confirm("Do you want to delete the airlines?"))
	{
		this.document.frm_airlines.airlines_id.value=airlines_id;
		this.document.frm_airlines.act.value="delete_airlines";
		this.document.frm_airlines.submit();
	}
}
</script>
<style>
.static tr td {
    padding: 5px;
    border: #e9e9e9 solid 0px;
    font-size:15px;
}
.myrow {
	width:17%; 
	font-size:15px; 
	font-weight:bold; 
	text-align:center;
}
input {
	width:150px;
	height:20px;
}
</style>
	<div class="crumb">
    </div>
    <div class="clear"></div>
	<div id="content_sec">
		<div class="col1">
		<div class="contact">
			<h4 class="heading colr">Book Your Ticket</h4>
			<?php
			if($_REQUEST['msg']) { 
			?>
				<div class="msg"><?=$_REQUEST['msg']?></div>
			<?php
			}
			?>
			<form name="frm_airlines" action="lib/booking.php" method="post">
					<table style="width:100%; border-bottom:1px solid #ccc">
					  <tr>
						<td style="width:16%"><img src="uploads/<?=$data['company_image']?>" style="height:100px;"></td>
						<td class="myrow">
							<u>Airlines No</u><br>
							<?=$data[airlines_no]?>
						</td>
						<td class="myrow">
							<u><?=$data1[city_name]?></u><br>
							<?=$data[route_from_arrival]?>
						</td>
						<td class="myrow">
							<u><?=$data[city_name]?></u><br>
							<?=$data[route_from_departure]?>
						</td>
						<td class="myrow">
							<u>Fare</u><br>
							<?=$data[route_economy_fare]?>
						</td>
						<td class="myrow">
							<u>Duration</u><br>
							<?=$data[route_duration]?>
						</td>
						</tr>
					  </table>
				</div>
				<!-- Passenger Details -->
				<div style="margin-bottom:10px">&nbsp;</div>
				<h4 class="heading colr">Adult Passenger Details</h4>
				<div class="static">
					<table style="width:70%">
					  <tbody>
					  <tr class="tablehead bold">
						<td scope="col">Sr. No.</td></td>
						<td scope="col">Name</td>
						<td scope="col">Gender</td>
						<td scope="col">Age</td>
					  </tr>
					<?php 
					for($i=1; $i<=$_REQUEST['adult']; $i++)
					{
						
					?>
					  <tr>
						<td style="text-align:center">Adult <?=$i?></td>
						<td style="text-align:center"><input type="text" name="adult_name[]" style="width:150px"></td>
						<td style="text-align:center">
							<select style="width:150px; height:25px;" required name="adult_gender[]">
								<option value="0">Gender</option>
								<option value="Male">Male</option>
								<option value="Female">Female</option>
							</select>
						</td>
						<td style="text-align:center"><input type="text" name="adult_age[]" style="width:120px">&nbsp;<b>Year</b></td>
						</td>
					  </tr>
					<?php } ?>
					</tbody>
					</table>
				</div>
			   <!-- Passenger Details -->
			   <?php if($_REQUEST['child']) { ?>
			   <div style="margin-bottom:10px">&nbsp;</div>
				<h4 class="heading colr">Child Passenger Details</h4>
				<div class="static">
					<table style="width:70%">
					  <tbody>
					  <tr class="tablehead bold">
						<td scope="col">Sr. No.</td></td>
						<td scope="col">Name</td>
						<td scope="col">Gender</td>
						<td scope="col">Age</td>
					  </tr>
					<?php 
					for($i=1; $i<=$_REQUEST['child']; $i++)
					{
						
					?>
					  <tr>
						<td style="text-align:center">Child <?=$i?></td>
						<td style="text-align:center"><input type="text" name="child_name[]" style="width:150px"></td>
						<td style="text-align:center">
						<select style="width:150px; height:25px;" required name="child_gender[]">
							<option value="0">Gender</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
						</select>
						</td>
						<td style="text-align:center"><input type="text" name="child_age[]" style="width:120px">&nbsp;<b>Year</b></td>
						</td>
					  </tr>
					<?php } ?>
					</tbody>
					</table>
				</div>
			  <?php } ?>
			  <!-- Passenger Details -->
			  <?php if($_REQUEST['infant']) { ?>
			  <div style="margin-bottom:10px">&nbsp;</div>
				<h4 class="heading colr">Infant Passenger Details</h4>
				<div class="static">
					<table style="width:70%">
					  <tbody>
					  <tr class="tablehead bold">
						<td scope="col">Sr. No.</td></td>
						<td scope="col">Name</td>
						<td scope="col">Gender</td>
						<td scope="col">Age</td>
					  </tr>
					<?php 
					for($i=1; $i<=$_REQUEST['infant']; $i++)
					{
						
					?>
					  <tr>
						<td style="text-align:center">Infant <?=$i?></td>
						<td style="text-align:center"><input type="text" name="infant_name[]" style="width:150px"></td>
						<td style="text-align:center">
						<select style="width:150px; height:25px;" required name="infant_gender[]">
							<option value="0">Gender</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
						</select>
						</td>
						<td style="text-align:center"><input type="text" name="infant_age[]" style="width:120px">&nbsp;<b>Year</b></td>
						</td>
					  </tr>
					<?php } ?>
					</tbody>
					</table>
				</div>
				
				<?php } ?>
				<div style="margin-bottom:10px">&nbsp;</div>
				<div style="margin:20px 0; text-align:center; border:1px solid; padding:10px;"><input type="submit" value="Continue to Payment" class="simplebtn" style="height:40px; font-weight:bold;"></div>
				<input type="hidden" value="<?=$_REQUEST['route_id']?>" name="route_id">
				<input type="hidden" name="book_date" value="<?=$_REQUEST['book_date']?>"/>
				<input type="hidden" name="class" value="<?=$_REQUEST['class']?>"/>
			</form>
		</div>
		<div class="col2">
			<?php include_once("includes/sidebar.php"); ?> 
		</div>
		</div>
	</div>
<?php include_once("includes/footer.php"); ?> 
