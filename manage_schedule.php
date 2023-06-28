<?php
include('db_connect.php');
if(isset($_GET['id']) && !empty($_GET['id']) ){
	$qry = $conn->query("SELECT * FROM schedule_list where id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $val){
		$meta[$k] =  $val;
	}
}
$bus = $conn->query("SELECT * FROM bus where status = 1");
$location = $conn->query("SELECT id,Concat(terminal_name,', ',city,', ',state) as location FROM location where status = 1");
?>
<div class="container-fluid">
	<form id="manage_schedule">
		<div class="col-md-12">
			<div class="form-group mb-2">
				<label for="bus_id" class="control-label">Bus Name</label>
				<input type="hidden" class="form-control" id="id" name="id" value='<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>' required="">
				<select name="bus_id" id="bus_id" class="form-control" required>
					<option value="" <?php echo isset($meta['bus_id']) && $meta['bus_id'] > 0 ? '' : 'selected'  ?> disabled="">Select Here</option>
					<?php while($row = $bus->fetch_assoc()){ ?>
						<option value="<?php echo $row['id'] ?>" <?php echo isset($meta['bus_id']) && $meta['bus_id'] == $row['id'] ? 'selected' : ''  ?>><?php echo $row['bus_number'] . ' | '.$row['name'] ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group mb-2">
				<label for="from_location" class="control-label">From</label>
				<select name="from_location" id="from_location" class="form-control" required>
					<option value="" <?php echo isset($meta['to_location']) && $meta['from_location'] > 0 ? '' : 'selected'  ?> disabled="">Select Here</option>
					<?php while($row = $location->fetch_assoc()){ ?>
						<option value="<?php echo $row['id'] ?>" <?php echo isset($meta['from_location']) && $meta['from_location'] == $row['id'] ? 'selected' : ''  ?>><?php echo $row['location']  ?></option>
					<?php } ?>
				</select>
			</div>
			<?php 
				$location = $conn->query("SELECT id,Concat(terminal_name,', ',city,', ',state) as location FROM location where status = 1");
			?>
			<div class="form-group mb-2">
				<label for="to_location" class="control-label">To</label>
				<select name="to_location" id="to_location" class="form-control" required>
					<option value="" <?php echo isset($meta['to_location']) && $meta['to_location'] > 0 ? '' : 'selected'  ?>  disabled="">Select Here</option>
					<?php while($row2 = $location->fetch_assoc()){ ?>
						<option value="<?php echo $row2['id'] ?>" <?php echo isset($meta['to_location']) && $meta['to_location'] == $row['id'] ? 'selected' : ''  ?>><?php echo $row2['location']  ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group mb-2">
				<label for="departure_time" class="control-label">Departure Time</label>
				<input type="text" class="datetimepicker form-control" id="departure_time" name="departure_time" value="<?php echo isset($meta['departure_time']) ? date('Y/m/d H:i',strtotime($meta['departure_time'])) : '' ?>">
			</div>
			<div class="form-group mb-2">
				<label for="eta" class="control-label">Estimated Arrival Time</label>
				<input type="text" class="datetimepicker form-control" id="eta" name="eta" value="<?php echo isset($meta['eta']) ? date('Y/m/d H:i',strtotime($meta['eta'])) : '' ?>">
			</div>
			<div class="form-group mb-2">
				<label for="availability" class="control-label">Availabilty</label>
				<input type="number" maxlength="4" class="form-control text-right" id="availability" name="availability" value="<?php echo isset($meta['availability']) ? $meta['availability'] : '' ?>">
			</div>
			<div class="form-group mb-2">
				<label for="price" class="control-label">Price</label>
				<input type="number" maxlength="20" class="form-control text-right" id="price" name="price" value="<?php echo isset($meta['price']) ? $meta['price'] : '' ?>">
			</div>
		</div>
	</form>
</div>
<script>
	$('#manage_schedule').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'./save_schedule.php',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
    			end_load()
    			alert_toast('An error occured','danger');
			},
			success:function(resp){
				if(resp == 1){
    				end_load()
    				$('.modal').modal('hide')
    				alert_toast('Data successfully saved','success');
    				load_schedule()
				}
			}
		})
	})
	$('.datetimepicker').datetimepicker({
	    format:'Y/m/d H:i',
	    startDate: '+3d'
	});
</script>