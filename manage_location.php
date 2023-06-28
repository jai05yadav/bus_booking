<?php
include('db_connect.php');
if(isset($_GET['id']) && !empty($_GET['id']) ){
	$qry = $conn->query("SELECT * FROM location where id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $val){
		$meta[$k] =  $val;
	}
}
?>
<div class="container-fluid">
	<form id="manage_location">
		<div class="col-md-12">
			<div class="form-group mb-2">
				<label for="terminal_name" class="control-label">Terminal Name</label>
				<input type="hidden" class="form-control" id="id" name="id" value='<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>' required="">
				<input type="text" class="form-control" id="terminal_name" name="terminal_name" required="" value="<?php echo isset($meta['terminal_name']) ? $meta['terminal_name'] : '' ?>">
			</div>
			<div class="form-group mb-2">
				<label for="city" class="control-label">City</label>
				<input type="text" class="form-control" id="city" name="city" required="" value="<?php echo isset($meta['city']) ? $meta['city'] : '' ?>">
			</div>
			<div class="form-group mb-2">
				<label for="state" class="control-label">Province</label>
				<input type="text" class="form-control" id="state" name="state" required="" value="<?php echo isset($meta['state']) ? $meta['state'] : '' ?>">
			</div>
		</div>
	</form>
</div>
<script>
	$('#manage_location').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'./save_location.php',
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
    				load_location()
				}
			}
		})
	})
</script>