<div class="content">
	<div class="container">
		<div class="row">
		 
			 <?php $this->load->view('user/home/user_sidemenu');?>
		 
            <div class="col-xl-9 col-md-8">
				<div class="row align-items-center mb-4">
					<div class="col">
						<h4 class="widget-title mb-0">My Bookings</h4>
					</div>
					<div class="col-auto">
						<div class="sort-by">
							<select class="form-control-sm custom-select searchFilter" id="status">
								<option value=''>All</option>
								<option value="1">Pending</option>
								<option value="2">Inprogress</option>
								<option value="3">Complete Request</option>
								<option value="5">Rejected</option>
								<option value="7">Cancelled</option>
								<option value="6">Completed</option>
							</select>
						</div>
					</div>
				</div>
			<div id="dataList">
				


				<?php
				if (!empty($all_bookings)) {
					foreach ($all_bookings as $bookings) {
						$this->db->select("service_image");
						$this->db->from('services_image');
						$this->db->where("service_id",$bookings['service_id']);
						$this->db->where("status",1);
						$image = $this->db->get()->result_array();
						$serv_image = array();
						foreach ($image as $key => $i) {
							$serv_image[] = $i['service_image'];
						}
						$rating=$this->db->where('user_id',$this->session->userdata('id'))->where('booking_id',$bookings['id'])->get('rating_review')->row_array();
							
					?>
				
				<div class="bookings">
					<div class="booking-list">
						<div class="booking-widget">
							<a href="<?php echo base_url().'service-preview/'.str_replace(' ', '-', $bookings['service_title']).'?sid='.md5($bookings['service_id']);?>" class="booking-img">
								<img src="<?php echo base_url().$serv_image[0]?>" alt="User Image">
							</a>
							<div class="booking-det-info">

								<?php
								$badge='';$class='';
								if ($bookings['status']==1) {
									$badge='Pending';
									$class='bg-warning';
								}
								if ($bookings['status']==2) {
									$badge='Inprogress';
									$class='bg-primary';	
								}
								if ($bookings['status']==3) {
									$badge='Complete Request sent by Provider';
									$class='bg-success';
								}
								if ($bookings['status']==4) {
									$badge='Accepted';
									$class='bg-success';
								}
								if ($bookings['status']==5) {
									$badge='Rejected by User';
									$class='bg-danger';
								} 
								if ($bookings['status']==6) {
									$badge='Completed Accepted';
									$class='bg-success';
								}
								if ($bookings['status']==7) {
									$badge='Cancelled by Provider';
									$class='bg-danger';
								}
								?>
								<h3>
									<a href="<?php echo base_url().'service-preview/'.str_replace(' ', '-', $bookings['service_title']).'?sid='.md5($bookings['service_id']);?>">
										<?php echo $bookings['service_title']?>
									</a>
								</h3>
								<?php
								if(!empty($bookings['user_id'])){
									$provider_info=$this->db->select('*')->
									from('providers')->
									where('id',(int)$bookings['provider_id'])->
									get()->row_array();
								}
								if(!empty($provider_info['profile_img'])){
									$image=base_url().$provider_info['profile_img'];
								}else{
									$image=base_url().'assets/img/user.jpg';
								}
								?>
								<ul class="booking-details">
									<li>
										<span>Booking Date</span> <?=date('d M Y',strtotime($bookings['service_date']));?> 
										<span class="badge badge-pill badge-prof <?php echo $class; ?>"><?=$badge;?></span>
									</li>
									<li><span>Booking time</span> <?=$bookings['from_time']?> - <?=$bookings['to_time']?></li>
									<li><span>Amount</span> ₹<?=$bookings['amount']?></li>
									<li><span>Payment Mode</span> <?php echo $bookings['pay_mode']?></li>
									<li><span>Payment Status</span> <?php 
									if($bookings['payment_status']=='1'){
										echo "Pending";
									}
									if($bookings['payment_status']=='2'){
										echo "In Progress";
									}
									if($bookings['payment_status']=='3'){
										echo "Failed";
									}
									if($bookings['payment_status']=='4'){
										echo "Paid";
									}
									?></li>
									<li><span>Location</span> <?php echo $bookings['location']?></li>
									
									<li><span>Phone</span> <?php echo $provider_info['mobileno']?></li>
									<li>
										<span>Provider</span>
										<div class="avatar avatar-xs mr-1">
											<img class="avatar-img rounded-circle" alt="User Image" src="<?php echo $image;?>">
										</div> <?=!empty($provider_info['name'])?$provider_info['name']:'-';?>
									</li>
								</ul>
							</div>
						</div>
					
						<div class="booking-action">
							<?php $pending=0;?>
								<?php if ($bookings['status']==2) {?>
								<a href="<?php echo base_url()?>user-chat/booking-new-chat?book_id=<?php echo $bookings['id']?>" class="btn btn-sm bg-info-light">
									<i class="far fa-eye"></i> Chat
								</a>
								<a href="javascript:;" class="btn btn-sm bg-danger-light myCancel" data-toggle="modal" data-target="#myCancel" data-id="<?php echo $bookings['id']?>" data-providerid="<?php echo $bookings['provider_id']?>" data-userid="<?php echo $bookings['user_id']?>" data-serviceid="<?php echo $bookings['service_id']?>"> 
											<i class="fas fa-times"></i> Cancel the Service
										</a>
							<?php }elseif($bookings['status']==1){?>
								<a href="javascript:;" class="btn btn-sm bg-danger-light myCancel" data-toggle="modal" data-target="#myCancel" data-id="<?php echo $bookings['id']?>" data-providerid="<?php echo $bookings['provider_id']?>" data-userid="<?php echo $bookings['user_id']?>" data-serviceid="<?php echo $bookings['service_id']?>"> 
											<i class="fas fa-times"></i> Cancel the Service
										</a>
							<?php }elseif($bookings['status']==3){?>
								<a href="<?php echo base_url()?>user-chat/booking-new-chat?book_id=<?php echo $bookings['id']?>" class="btn btn-sm bg-info-light">
									<i class="far fa-eye"></i> Chat
								</a> 
									<a href="javascript:;" class="btn btn-sm bg-success-light update_user_booking_status" data-id="<?=$bookings['id'];?>" data-status="6" data-rowid="<?=$pending;?>" data-review="2" >
									<i class="fas fa-check"></i>Compete Request Accept
								</a>
								
								<a href="javascript:;" class="btn btn-sm bg-danger-light myCancel" data-toggle="modal" data-target="#myCancel" data-id="<?php echo $bookings['id']?>" data-providerid="<?php echo $bookings['provider_id']?>" data-userid="<?php echo $bookings['user_id']?>" data-serviceid="<?php echo $bookings['service_id']?>"> 
											<i class="fas fa-times"></i> Cancel the Service
										</a>
							<?php }?>

							<?php if ($bookings['status']==6  && empty($rating)) {?>
							<a href="javascript:void(0);" class="btn btn-sm bg-success-light myReview" data-toggle="modal" data-target="#myReview" data-id="<?php echo $bookings['id']?>" data-providerid="<?php echo $bookings['provider_id']?>" data-userid="<?php echo $bookings['user_id']?>" data-serviceid="<?php echo $bookings['service_id']?>"> 
								<i class="fas fa-plus"></i> review
							</a>
							<?php }?>
							
							<?php if ($bookings['status']==7 || $bookings['status']==5  ) {?>
							<button type="button" data-id="<?php echo $bookings['id']?>" class="btn btn-sm bg-default-light reason_modal">
								<i class="fas fa-info-circle"></i> Reason
							</button>
							<input type="hidden" id="reason_<?=$bookings['id'];?>" value="<?=$bookings['reason'];?>">
							<?php }?>
							</div>
					</div>
				</div>
				<?php } } else { ?>
				<p>No records found</p>
				<?php } ?>
				<?php 
				
						echo $this->ajax_pagination->create_links();
					?>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>
