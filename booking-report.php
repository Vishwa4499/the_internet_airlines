<?php 
	include_once("includes/header.php"); 
	include_once("includes/db_connect.php"); 
	if($_REQUEST['user_id'])
		$SQL="SELECT * FROM `user`,`route`, `company`, `airlines`,`city`, `booking` WHERE booking_user_id = user_id and booking_route_id = route_id AND route_from_city = city_id AND route_airlines_id = airlines_id AND airlines_company_id = company_id AND user_id = ".$_REQUEST['user_id'];
	else
		$SQL="SELECT * FROM `user`,`route`, `company`, `airlines`,`city`, `booking` WHERE booking_user_id = user_id and booking_route_id = route_id AND route_from_city = city_id AND route_airlines_id = airlines_id AND airlines_company_id = company_id;";
	$rs=mysqli_query($con,$SQL) or die(mysqli_error($con));
?>
<script>
function delete_booking(booking_id)
{
	if(confirm("Do you want to delete the booking?"))
	{
		this.document.frm_booking.booking_id.value=booking_id;
		this.document.frm_booking.act.value="delete_booking";
		this.document.frm_booking.submit();
	}
}
</script>
	<div class="crumb">
    </div>
    <div class="clear"></div>
	<div id="content_sec">
		<div class="col1" style="width:100%">
		<div class="contact">
			<h4 class="heading colr"> Booking Report</h4>
			<?php
			if($_REQUEST['msg']) { 
			?>
				<div class="msg"><?=$_REQUEST['msg']?></div>
			<?php
			}
			?>
			<form name="frm_booking" action="lib/bookings.php" method="post">
				<div class="static">
					<table style="width:100%">
					  <tbody>
					  <tr class="tablehead bold">
						<td scope="col">Booking ID</td>
						<td scope="col">Name</td>
						<td scope="col">Contact</td>
						<td scope="col">Flight No.</td>
						<td scope="col">From City</td>
						<td scope="col">To City</td>
						<td scope="col">Journey Date</td>	
						<td scope="col">Total Fare</td>							
						<td scope="col">Action</td>
					  </tr>
					<?php 
					$sr_no=1;
					while($data = mysqli_fetch_assoc($rs))
					{
						$SQL = "SELECT * FROM city WHERE city_id = ".$data['route_to_city'];
						$rs1 = mysqli_query($con,$SQL) or die(mysqli_error($con));
						$data1 = mysqli_fetch_assoc($rs1);
					?>
					  <tr>
						<td><?=$data[booking_id]?></td>
						<td><?=$data[user_name]?></td>
						<td><?=$data[user_mobile]?></td>
						<td><?=$data[airlines_no]?></td>
						<td><?=$data[city_name]?></td>
						<td><?=$data1[city_name]?></td>
						<td><?=$data[booking_journey_date]?></td>
						<td><?=$data[booking_total_fare]?></td>
						<td style="text-align:center">
							<a style="color:#FF0000; font-weight:bold; text-decoration:underline" href="booking-confirmation.php?booking_id=<?php echo $data[booking_id] ?>">View Details</a>
						</td>
						</td>
					  </tr>
					<?php } ?>
					</tbody>
					</table>
				</div>
				<input type="hidden" name="act" />
				<input type="hidden" name="booking_id" />
			</form>
		</div>
		</div>
	</div>
<?php include_once("includes/footer.php"); ?> 
