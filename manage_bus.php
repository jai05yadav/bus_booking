<?php
include('db_connect.php');
if(isset($_GET['id']) && !empty($_GET['id']) ){
	$qry = $conn->query("SELECT * FROM bus where id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $val){
		$meta[$k] =  $val;
	}
}
?>
<div class="container-fluid">
	<form id="manage_bus">
		<div class="col-md-12">
			<div class="form-group mb-2">
				<label for="name" class="control-label">Bus Name</label>
				<input type="hidden" class="form-control" id="id" name="id" value='<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>' required="">
				<input type="text" class="form-control" id="name" name="name" required="" value="<?php echo isset($meta['name']) ? $meta['name'] : '' ?>">
			</div>
			<div class="form-group mb-2">
				<label for="bus_number" class="control-label">Bus Number</label>
				<input type="number" class="form-control" id="bus_number" name="bus_number" required value="<?php echo isset($meta['bus_number']) ? $meta['bus_number'] : '' ?>">
			</div>
		</div>
	</form>
</div>
<script>
	$('#manage_bus').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'./save_bus.php',
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
    				load_bus()
				}
			}
		})
	})
</script>