<?php 
$service_details  = $this->service->get_service_id($this->uri->segment('2')); 
?>
<div class="content">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">		
				<div class="section-header text-center">
					<h2>Book Service</h2>
				</div>
				<form action="https://test.cashfree.com/billpay/checkout/post/submit" method="post" enctype="multipart/form-data" autocomplete="off" id="book_services" >
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
    
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Date <span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="booking_date" id="booking_date" />
								
								<input type="hidden" name="provider_id" id="provider_id" value="<?php echo $service_details['user_id']?>">
								<input type="hidden" name="service_id" id="service_id" value="<?php echo $service_details['id']?>">
							</div>
						</div>

						<div class="col-lg-6">
							<div class="form-group">
								<label>Service amount</label>
								<input class="form-control" type="text" name="service_amount" id="service_amount" value="<?php echo $service_details['service_amount'] ?>" readonly="">
							</div>
						</div>

						<div class="col-lg-6">
							<div class="form-group">
								<label>Time slot <span class="text-danger">*</span></label>
								<select class="form-control from_time" name="from_time" id="from_time" required>
								</select>
								
							</div>
						</div>
					 
						<div class="col-lg-6">
							<div class="form-group">
								<label>Service Location <span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="service_location" id="service_location" required>
								
								<input type="hidden" name="service_latitude" id="service_latitude">
								<input type="hidden" name="service_longitude" id="service_longitude">
							</div>
						</div>

						<div class="col-lg-12">
							<div class="form-group">
								<div class="text-center">
									<div id="load_div"></div>
								</div>
								<label>Notes</label>
								<textarea class="form-control" name="notes" id="notes" rows="5"></textarea>
								<input type="text" name="signature" id='signature'>
							</div>
						</div>
					</div>
					<div class="submit-section">
						<?php if($wallet_amt[0]->wallet_amt >= $service_details['service_amount']) { ?>
							<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#myModal">Continue to Book</button>
						<?php }else{ ?>
							<button class="btn btn-primary submit-btn submit_service_book" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing Order" data-id="<?php echo $service_details['id']; ?>" data-provider="<?php echo $service_details['user_id']?>" data-amount="<?php echo $service_details['service_amount']; ?>" type="submit" id="submit">Continue to Book</button>
						<?php } ?>
					</div>

					<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Choose Pay Option</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
        <p><a href="<?php echo base_url().'user-wallet' ?>" class="btn btn-primary">Wallet</a></p>
        	<center>OR</center>
        <p><button class="btn btn-primary submit-btn submit_service_book" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing Order" data-id="<?php echo $service_details['id']; ?>" data-provider="<?php echo $service_details['user_id']?>" data-amount="<?php echo $service_details['service_amount']; ?>" type="submit" id="submit">CASH/UPI</button></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
					
				</form>
			</div>
		</div>
	</div>
</div>
