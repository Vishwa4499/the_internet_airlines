<?php 
	include_once("includes/header.php"); 
	include_once("includes/db_connect.php"); 
	$SQL="SELECT * FROM `user`,`route`, `company`, `airlines`,`city`, `booking` WHERE booking_user_id = user_id and booking_route_id = route_id AND route_from_city = city_id AND route_airlines_id = airlines_id AND airlines_company_id = company_id AND booking_id = ".$_REQUEST['booking_id'];
	$rs=mysqli_query($con,$SQL) or die(mysqli_error($con));
	$data = mysqli_fetch_assoc($rs);
	$SQL = "SELECT * FROM city WHERE city_id = ".$data['route_to_city'];
	$rs1 = mysqli_query($con,$SQL) or die(mysqli_error($con));
	$data1 = mysqli_fetch_assoc($rs1);
?>
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
			<h4 class="heading colr">Your Booking was successfull <b style="color:#ff0000">(Booking Reference Number : <?=$data['booking_id']?>)</b></h4>
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
							<u>Flight No</u><br>
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
				<!-- Customer Details -->
				<h4 class="heading colr">Customer Details</h4>
				<div class="static">
					<table style="width:70%">
					  <tbody>
					  <tr class="tablehead bold">
						<td scope="col">Name</td>
						<td scope="col">Email</td>
						<td scope="col">Contact Number</td>
					  </tr>
					  <tr>
						<td style="text-align:center"><?=$data['user_name']?></td>
						<td style="text-align:center"><?=$data['user_email']?></td>
						<td style="text-align:center"><?=$data['user_mobile']?></td>
					  </tr>
					</tbody>
					</table>
				</div>
				<!-- Adult Passengar Details -->
				<?php
					$SQL="SELECT * FROM `booking`, `passengar` WHERE passengar_booking_id = booking_id AND passengar_type = 'adult' AND booking_id = ".$_REQUEST['booking_id'];
					$rs=mysqli_query($con,$SQL) or die(mysqli_error($con));
					if(mysqli_num_rows($rs))
					{
				?>
				<div style="margin-bottom:10px">&nbsp;</div>
				<h4 class="heading colr">Adult Passengar Details</h4>
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
					$sr_no=1; 
					while($data = mysqli_fetch_assoc($rs))
					{
					?>
					  <tr>
						<td style="text-align:center">Adult <?=$sr_no++?></td>
						<td style="text-align:center"><?=$data['passengar_name']?></td>
						<td style="text-align:center"><?=$data['passengar_gender']?></td>
						<td style="text-align:center"><?=$data['passengar_age']?>&nbsp;<b>Year</b></td>
					  </tr>
					<?php } ?>
					</tbody>
					</table>
				</div>
				<?php } ?>
			   <!-- Child Passengar Details -->
			   <?php
					$SQL="SELECT * FROM `booking`, `passengar` WHERE passengar_booking_id = booking_id AND passengar_type = 'child' AND booking_id = ".$_REQUEST['booking_id'];
					$rs=mysqli_query($con,$SQL) or die(mysqli_error($con));
					if(mysqli_num_rows($rs))
					{
				?>
			   <div style="margin-bottom:10px">&nbsp;</div>
				<h4 class="heading colr">Child Passengar Details</h4>
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
					$sr_no=1; 
					while($data = mysqli_fetch_assoc($rs)) {
					?>
					  <tr>
						<td style="text-align:center">Child <?=$sr_no++?></td>
						<td style="text-align:center"><?=$data['passengar_name']?></td>
						<td style="text-align:center"><?=$data['passengar_gender']?></td>
						<td style="text-align:center"><?=$data['passengar_age']?>&nbsp;<b>Year</b></td>
					  </tr>
					<?php } ?>
					</tbody>
					</table>
				</div>
			  <?php } ?>
			  <!-- Infant Passengar Details -->
			  <?php
					$SQL="SELECT * FROM `booking`, `passengar` WHERE passengar_booking_id = booking_id AND passengar_type = 'infant' AND booking_id = ".$_REQUEST['booking_id'];
					$rs=mysqli_query($con,$SQL) or die(mysqli_error($con));
					if(mysqli_num_rows($rs))
					{
				?>
			  <div style="margin-bottom:10px">&nbsp;</div>
				<h4 class="heading colr">Infant Passengar Details</h4>
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
					$sr_no=1; 
					while($data = mysqli_fetch_assoc($rs)) {
					?>
					  <tr>
						<td style="text-align:center">Infant <?=$sr_no++?></td>
						<td style="text-align:center"><?=$data['passengar_name']?></td>
						<td style="text-align:center"><?=$data['passengar_gender']?></td>
						<td style="text-align:center"><?=$data['passengar_age']?>&nbsp;<b>Year</b></td>
					  </tr>
					<?php } ?>
					</tbody>
					</table>
				</div>
				<?php } ?>
				<div style="margin-bottom:10px">&nbsp;</div>
				<div style="margin:20px 0; text-align:center; border:1px solid; padding:10px;"><input type="button" value="Print Ticket" class="simplebtn" style="height:40px; font-weight:bold;" onClick="window.print()"></div>
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
