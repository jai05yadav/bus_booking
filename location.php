 <section id="bg-bus" class="d-flex align-items-center">
<main id="main">
	<div class="container">
		<div class="col-lg-12">
			<?php  if(isset($_SESSION['login_id'])): ?>
			<div class="row">
				<div class="col-md-12">
					<button class="float-right btn btn-primary btn-sm" type="button" id="new_location">Add New <i class="fa fa-plus"></i></button>
				</div>
			</div>
		<?php endif; ?>
			<div class="row">
				&nbsp;
			</div>
			<div class="row">
				<div class="card col-md-12">
					<div class="card-header">
						<div class="card-title">Location List</div>
					</div>
					<div class="card-body">
						<table class="table table-striped table-bordered" id="location-field">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Terminal</th>
									<th class="text-center">City</th>
									<th class="text-center">Province/ State</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</main>
</section>
<script>
	$('#new_location').click(function(){
		uni_modal('Add New Location','manage_location.php')
	})
	window.load_location = function(){
		$('#location-field').dataTable().fnDestroy();
		$('#location-field tbody').html('<tr><td colspan="5" class="text-center">Please wait...</td></tr>')
		$.ajax({
			url:'load_location.php',
			error:err=>{
				console.log(err)
				alert_toast('An error occured.','danger');
			},
			success:function(resp){
				if(resp){
					if(typeof(resp) != undefined){
						resp = JSON.parse(resp)
							if(Object.keys(resp).length > 0){
								$('#location-field tbody').html('')
								var i = 1 ;
								Object.keys(resp).map(k=>{
									var tr = $('<tr></tr>');
									tr.append('<td class="text-center">'+(i++)+'</td>')
									tr.append('<td class="text-center">'+resp[k].terminal_name+'</td>')
									tr.append('<td>'+resp[k].city+'</td>')
									tr.append('<td>'+resp[k].state+'</td>')
									if('<?php echo isset($_SESSION['login_id']) ? 1 : 0 ?>' == 1){
										tr.append('<td><center><button class="btn btn-sm btn-primary edit_location mr-2" data-id="'+resp[k].id+'">Edit</button><button class="btn btn-sm btn-danger remove_location" data-id="'+resp[k].id+'">Delete</button></center></td>')
									}else{
										tr.append('<td><center><a class="btn btn-sm btn-primary mr-2 text-white" href="#"><strong>Book Now</strong></a></center></td>')
									}
									$('#location-field tbody').append(tr)

								})

							}else{
								$('#location-field tbody').html('<tr><td colspan="5" class="text-center">No data.</td></tr>')
							}
					}
				}
			},
			complete:function(){
				$('#location-field').dataTable()
				manage();
			}
		})
	}
	function manage(){
		$('.edit_location').click(function(){
		uni_modal('Edit New Location','manage_location.php?id='+$(this).attr('data-id'))

		})
		$('.remove_location').click(function(){
		_conf('Are you sure to delete this data?','remove_location',[$(this).attr('data-id')])

		})
	}
	function remove_location($id=''){
		start_load()
		$.ajax({
			url:'delete_location.php',
			method:'POST',
			data:{id:$id},
			error:err=>{
				console.log(err)
				alert_toast("An error occured","danger");
				end_load()
			},
			success:function(resp){
				if(resp== 1){
					alert_toast("Data succesfully deleted","success");
					end_load()
					$('.modal').modal('hide')
					load_location()
				}
			}
		})
	}
	$(document).ready(function(){
		load_location()
	})
</script>