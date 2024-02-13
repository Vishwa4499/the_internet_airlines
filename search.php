<?php 
	include_once("includes/header.php"); 
	if($_REQUEST[train_id])
	{
		$SQL="SELECT * FROM train WHERE train_id = $_REQUEST[airlines_id]";
		$rs=mysqli_query($con,$SQL) or die(mysqli_error($con));
		$data=mysqli_fetch_assoc($rs);
	}
?> 
<script>
jQuery(function() {
	jQuery( "#book_date" ).datepicker({
	  changeMonth: true,
	  changeYear: true,
	   yearRange: "+0:+1",
	   dateFormat: 'd MM,yy'
	});
});
</script>
	<div class="crumb">
    </div>
    <div class="clear"></div>
	<div id="content_sec">
		<div class="col1">
			<div class="contact">
				<h4 class="heading colr"><?=$heading?>Book Your Airlines Ticket</h4>
				<?php
				if($_REQUEST['msg']) { 
				?>
				<div class="msg"><?=$_REQUEST['msg']?></div>
				<?php
				}
				?>
				<form action="search-list.php" enctype="multipart/form-data" method="post" name="frm_train">
					<ul class="forms">
						<li class="txt">From City</li>
						<li class="inputfield">
							<select name="train_from" class="bar" required/>
								<?php echo get_new_optionlist("city","city_id","city_name",$data[train_from]); ?>
							</select>
						</li>
					</ul>
					<ul class="forms">
						<li class="txt">To City</li>
						<li class="inputfield">
							<select name="train_to" class="bar" required/>
								<?php echo get_new_optionlist("city","city_id","city_name",$data[train_to]); ?>
							</select>
						</li>
					</ul>
					<ul class="forms">
						<li class="txt">Date</li>
						<li class="inputfield"><input name="book_date" id="book_date" type="text" class="bar" required/></li>
					</ul>
					<ul class="forms">
						<li class="txt">Passengar</li>
						<li class="inputfield">
							<select name="adult" class="bar" required style="width:80px"/>
									<option value="">Adult</option>
								<?php for($i=1; $i<=5; $i++) { ?>
									<option value="<?=$i?>"><?=$i?></option>
								<?php } ?>
							</select>
							<select name="child" class="bar" style="width:80px"/>
								<option value="">Child</option>
								<?php for($i=1; $i<=5; $i++) { ?>
									<option value="<?=$i?>"><?=$i?></option>
								<?php } ?>
							</select>
							<select name="infant" class="bar" style="width:80px"/>
								<option value="">Infants</option>
								<?php for($i=1; $i<=5; $i++) { ?>
									<option value="<?=$i?>"><?=$i?></option>
								<?php } ?>
							</select>						
						</li>
					</ul>
					<ul class="forms">
						<li class="txt">Class</li>
						<li class="inputfield">
							<table>
								<tr>
									<td><input name="class" id="class" type="radio" class="bar" style="width:30px; height:15px;" value="Economy"  required/></td>
									<td>Premium</td>
									<td><input name="class" id="class" type="radio" class="bar" style="width:30px; height:15px;" value="Business" required/></td>
									<td>Economy</td>
								</tr>
							</table>
						</li>
					</ul>
					<div style="clear:both"></div>
					<ul class="forms">
						<li class="txt">&nbsp;</li>
						<li class="textfield"><input type="submit" value="Submit" class="simplebtn"></li>
						<li class="textfield"><input type="reset" value="Reset" class="resetbtn"></li>
					</ul>
					<input type="hidden" name="act" value="save_train">
					<input type="hidden" name="airlines_id" value="<?=$data[airlines_id]?>">
				</form>
			</div>
		</div>
		<div class="col2">
			<?php include_once("includes/sidebar.php"); ?> 
		</div>
	</div>
<?php include_once("includes/footer.php"); ?> 
