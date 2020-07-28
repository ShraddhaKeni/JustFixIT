<?php 
$service_details  = $this->service->get_service_id($this->uri->segment('2'));

$stripe_option='1';
    $publishable_key='';
    $secret_key='';
    $live_secret_key='';
    $live_publishable_key='';
    $logo_front='';
    foreach ($system_info as $res) {
      if($res['key'] == 'stripe_option'){
      $stripe_option = $res['value'];
      } 
      if($res['key'] == 'publishable_key'){
      $publishable_key = $res['value'];
      }
      if($res['key'] == 'secret_key'){
      $secret_key = $res['value'];
      } 
       if($res['key'] == 'live_publishable_key'){
      $live_publishable_key = $res['value'];
      }
      if($res['key'] == 'live_secret_key'){
      $live_secret_key = $res['value'];
      } 

      if($res['key'] == 'logo_front'){
      $logo_front = $res['value'];
      }
    }

    if($stripe_option==1){
      $stripe_key= $publishable_key;
      $secretKey = $secret_key;
    }else{
      $stripe_key= $live_publishable_key;
      $secretKey = $live_secret_key;
    }

    if(!empty($logo_front)){
      $web_log=base_url().$logo_front;
    }else{
      $web_log=base_url().'assets/img/logo.png';
    }


?>
<div class="content">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">		
				<div class="section-header text-center">
					<h2>Book Service</h2>
				</div>

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
								
					</div>
				</div>

				</div>


				<input type="hidden" name="secretKey" id='secretKey' value="<?php echo $secretKey;  ?>"/>
				<form method="post" action="https://test.cashfree.com/billpay/checkout/post/submit" id="book_services" >
          			<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<div class="text-center">
									<div id="load_div"></div>
								</div>
								<label>Service amount</label>
								<input class="form-control" type="text" name="orderAmount" id="service_amount" value="<?php echo $service_details['service_amount'] ?>" readonly="">
								<label>Notes</label>
								<textarea class="form-control" name="orderNote" id="notes" rows="5"></textarea>
								<input type="hidden" name="orderCurrency" id='id_orderCurrency_ser' value="INR"/>
								<input type="hidden" name="customerName" id='id_customerName_ser' value="<?php echo $this->session->userdata('name');  ?>"/>
									<input type="hidden" name="customerEmail" id='id_customerEmail_ser' value="<?php echo $this->session->userdata('email');  ?>"/>
									<input type="hidden" name="customerPhone" id='id_customerPhone_ser' value="<?php echo $this->session->userdata('mobileno');  ?>"/>
								<input type="hidden" id='app_id_ser' name="appId" value="<?php echo $stripe_key;  ?>"/>
								<input type="hidden" id='order_id_ser' name="orderId" placeholder="value" value="<?php echo rand(100000,999999);  ?>"/>
								<input type="hidden" id='id_returnUrl_ser' name="returnUrl" value="<?php  echo base_url().'booking_service_submit'; ?>"/>
								<input type="hidden" id='id_notifyUrl_ser' name="notifyUrl" value="<?php  echo base_url().'booking_service_submit'; ?>"/>

								<input type="hidden" name="signature" id="signature">
							</div>
						</div>
					</div>
					<div class="submit-section">
						<?php if($wallet_amt[0]->wallet_amt >= $service_details['service_amount']) { ?>
							<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#myModal">Continue to Book</button>
						<?php }else{ ?>
							<button class="btn btn-primary submit-btn submit_service_book" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing Order" data-id="<?php echo $service_details['id']; ?>" data-provider="<?php echo $service_details['user_id']?>" data-amount="<?php echo $service_details['service_amount']; ?>" type="submit">Continue to Book</button>
						<?php } ?>
					</div>

			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Choose Pay Option</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <center><a href="<?php echo base_url().'user-wallet'; ?>" class="btn btn-primary submit-btn">Wallet</a></center>
			        <center>OR</center>
			        <center><button class="btn btn-primary submit-btn submit_service_book" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing Order" data-id="<?php echo $service_details['id']; ?>" data-provider="<?php echo $service_details['user_id']?>" data-amount="<?php echo $service_details['service_amount']; ?>" type="submit">Card/UPI</button><center>
			      </div>
			      <div class="modal-footer">
			        
			      </div>
			    </div>
			  </div>
			</div>


				</form>
			</div>
		</div>
	</div>
</div>
