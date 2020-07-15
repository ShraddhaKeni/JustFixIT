<div class="content">
	<div class="container">
		<div class="row">
			 <?php $this->load->view('user/home/user_sidemenu');?>
		 
			<div class="col-xl-9 col-md-8">
			
				<h4 class="widget-title">Payment History</h4>
				<div class="card transaction-table mb-0">
					<div class="card-body">
						<div class="table-responsive">
							<?php
									if(count($services)>0){?>
							<table class="table mb-0" id="order-summary">
								<?php } else{?>
									<table class="table mb-0" >
								<?php }?>
								<thead>
									<tr>
										<th>Service</th>
										<th>Provider</th>
										<th>Date</th>
										<th>Amount</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>

									<?php
									if(count($services)>0){
										$service_images='';
									 foreach($services as $row){ 
									   $amount_refund=''; 
									 	if(!empty($row['reject_paid_token'])){
									 	if($row['admin_reject_comment']=="This service amount favour for User"){
									 		$amount_refund="Amount refund to User";
									 	}else{
                                          $amount_refund="Amount refund to Provider";
									 	}
									 }

									 	if(!empty($row['service_image'])){

									 		
						 $service_image=$this->db->where('service_id',$row['service_id'])->get('services_image')->row_array();
						 if(!empty($service_image['service_image'])){
						 	 $service_images=$service_image['service_image'];
						 	}else{
						 		$service_images="";
						 	}
						 
									 	
									 	}

									 	?>
									
									<tr>
										<td>
											<a href="javascript:void(0);">
												<img src="<?php echo base_url().$service_images;?>" class="pro-avatar" alt=""> <?=$row['service_title'];?>
											</a>
										</td>
										<td>
											<img class="avatar-xs rounded-circle" src="<?php echo base_url().$row['profile_img'];?>" alt=""> <?=$row['name'];?>
										</td>
										<td><?=date('d M Y H:i',strtotime($row['service_date']));?></td>
										<td><strong><?=currency_conversion(settings('currency')).$row['amount'];?></strong></td>
										<td>
											<?php if(!empty($row['reject_paid_token'])){ ?>
												<span class="badge bg-success-light"><?=$amount_refund;?></span>

										<?php } if($row['booking_status']==6){?>
											<span class="badge bg-success-light">Payment Completed</span>
										<?php }else if($row['booking_status']==5&&empty($row['reject_paid_token'])){?>
											<span class="badge bg-danger-light">User Rejected</span>
										<?php }else if($row['booking_status']==7&&empty($row['reject_paid_token'])){?>
                                            <span class="badge bg-danger-light">Provider Cancelled</span>
										<?php }?>
										</td>
									</tr>
								<?php } }else{?>
									<tr> <td colspan="5"> <div class="text-center text-muted">No data found</div></td> </tr>
								<?php }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>			
			</div>
		</div>
	</div>
</div>