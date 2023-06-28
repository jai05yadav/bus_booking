 <section id="bg-bus" class="d-flex align-items-center">
<main id="main">
	<div class="container-fluid">
		<div class="col-lg-12">
			<?php  if(isset($_SESSION['login_id'])): ?>
			<div class="row">
				<div class="col-md-12">
					<button class="float-right btn btn-primary btn-sm" type="button" id="new_schedule">Add New <i class="fa fa-plus"></i></button>
				</div>
			</div>
		<?php endif; ?>
			<div class="row">
				&nbsp;
			</div>
			<div class="row">
				<div class="card col-md-12">
					
					<div class="card-body">
						<table class="table table-striped table-bordered" id="schedule-field">
							<colgroup>
								<col width="5%">
								<col width="10%">
								<col width="15%">
								<col width="20%">
								<col width="10%">
								<col width="10%">
								<col width="10%">
								<col width="10%">
								<col width="10%">
							</colgroup>
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Date</th>
									<th class="text-center">Bus</th>
									<th class="text-center">Location</th>
									<th class="text-center">Departure</th>
									<th class="text-center">ETA</th>
									<th class="text-center">Availability</th>
									<th class="text-center">Price</th>
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
	$('#new_schedule').click(function(){
		uni_modal('Add New Schedule','manage_schedule.php')
	})
	window.load_schedule = function(){
		$('#schedule-field').dataTable().fnDestroy();
		$('#schedule-field tbody').html('<tr><td colspan="7" class="text-center">Please wait...</td></tr>')
		$.ajax({
			url:'load_schedule2.php',
			method:'POST',
			data:{id:'<?php echo $_GET['id'] ?>',from_location:'<?php echo $_GET['from_location'] ?>',to_location:'<?php echo $_GET['to_location'] ?>',departure_time:'<?php echo $_GET['departure_time'] ?>'},
			error:err=>{
				console.log(err)
				alert_toast('An error occured.','danger');
			},
			success:function(resp){
				if(resp){
					if(typeof(resp) != undefined){
						resp = JSON.parse(resp)
							if(Object.keys(resp).length > 0){
								$('#schedule-field tbody').html('')
								var i = 1 ;
								Object.keys(resp).map(k=>{
									var tr = $('<tr></tr>');
									tr.append('<td class="text-center">'+(i++)+'</td>')
									tr.append('<td class="">'+resp[k].date+'</td>')
									tr.append('<td class="">'+resp[k].bus+'</td>')
									tr.append('<td class="">'+resp[k].from_location+' - '+resp[k].to_location+'</td>')
									tr.append('<td>'+resp[k].time+'</td>')
									tr.append('<td>'+resp[k].eta+'</td>')
									tr.append('<td>'+resp[k].availability+'</td>')
									tr.append('<td>'+resp[k].price+'</td>')
									
										tr.append('<td><center><button class="btn btn-sm btn-primary mr-2 text-white book_now" data-id="'+resp[k].id+'"><strong>Book Now</strong></button></center></td>')
									$('#schedule-field tbody').append(tr)

								})

							}else{
								$('#schedule-field tbody').html('<tr><td colspan="7" class="text-center">No data.</td></tr>')
							}
					}
				}
			},
			complete:function(){
				$('#schedule-field').dataTable()
				$('.book_now').click(function(){
					uni_modal('Book Details','customer_book.php?id='+$(this).attr('data-id'),1)
				})
			}
		})
	}
	
	$(document).ready(function(){
		load_schedule()
	})
</script>