<?php
$country_list=$this->db->where('status',1)->order_by('country_name',"ASC")->get('country_table')->result_array();
?>
<!-- Review Modal -->
<div class="modal fade" id="myReview">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">	
				<h5 class="modal-title">Write a review</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="form-group">
					<label>Review</label>
					<div class="star-rating rate">
						<input class="rates" id="star5" type="radio" name="rates" value="5">
						<label for="star5" title="5 stars">
							<i class="active fas fa-star"></i>
						</label>
						<input class="rates" id="star4" type="radio" name="rates" value="4">
						<label for="star4" title="4 stars">
							<i class="active fas fa-star"></i>
						</label>
						<input class="rates" id="star3" type="radio" name="rates" value="3">
						<label for="star3" title="3 stars">
							<i class="active fas fa-star"></i>
						</label>
						<input class="rates" id="star2" type="radio" name="rates" value="2">
						<label for="star2" title="2 stars">
							<i class="active fas fa-star"></i>
						</label>
						<input class="rates" id="star1" type="radio" name="rates" value="1">
						<label for="star1" title="1 star">
							<i class="active fas fa-star"></i>
						</label>
					</div>
				</div>
				<p class="error_rating error" >Rating is required</p>
				<input type="hidden" id="myInput">
				<input type="hidden" id="booking_id">
				<input type="hidden" id="provider_id">
				<input type="hidden" id="user_id">
				<input type="hidden" id="service_id">
				
				<?php $rating_type = $this->db->where('status',1)->get('rating_type')->result_array(); ?>
				<div class="form-group">
					<label>Title of your review</label>
					<select name="type" id="type" class="form-control">
						<?php foreach ($rating_type as $type) 
						{
							?>
							<option value="<?=$type['id']?>"><?php echo $type['name']?></option>
						<?php } ?>
					</select>
					<p class="error_type error" >Rating type is required</p>
				</div>
				<div class="form-group">
					<label>Your review</label>
					<textarea class="form-control" rows="4" id="review"></textarea>
					<p class="error_review error">Review is required</p>
				</div>
				<div class="text-center">
					<button type="button" class="btn btn-theme py-2 px-4 text-white mx-auto" id="rate_booking" >SUBMIT</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /Review Modal -->

<!-- Cancel Modal -->
<div class="modal fade" id="myCancel">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Reason for Cancel</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="cancel_myInput">
				<input type="hidden" id="cancel_booking_id">
				<input type="hidden" id="cancel_provider_id">
				<input type="hidden" id="cancel_user_id">
				<input type="hidden" id="cancel_service_id">
				
				<div class="form-group">
					<label>Reason</label>
					<textarea class="form-control" rows="5" id="cancel_review"></textarea>
					<p class="error_cancel error" >Reason is required</p>
				</div>
				<div class="text-center">
					<?php if($this->session->userdata('type')=="user"){?>
						<button type="button" class="btn btn-theme py-2 px-4 text-white mx-auto" id="cancel_booking" >SUBMIT</button>
					<?php }else{?>
						<button type="button" class="btn btn-theme py-2 px-4 text-white mx-auto" id="provider_cancel_booking">SUBMIT</button>
					<?php }?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /Cancel Modal -->

<!-- Alert Modal -->
<div class="modal" id="account_alert">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Alert</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<p>Please Enter Profile informations.</p>
					<button type="button" class="btn btn-primary" id="go_user_settings">Ok</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /Alert Modal -->

<!-- Account Alert Modal -->
<div class="modal" id="account_alert_provider">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Alert</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<p>Please Fill Account Informations.</p>
					<button type="button" class="btn btn-primary go_provider_availability">Ok</button>
				</div>
			</div>

		</div>
	</div>
</div>
<!-- /Account Alert Modal -->

<!-- Account Alert Modal -->
<div class="modal" id="account_alert_provider_sub">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Alert</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<p>Please Subscripe your Plan...</p>
					<button type="button" class="btn btn-primary go_provider_availability" >Ok</button>
				</div>
			</div>

		</div>
	</div>
</div>
<!-- /Account Alert Modal -->

<div class="modal" id="account_alert_provider_avail">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Alert</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">

				<div class="form-group">
					<p>Please Fill Availability time.</p>

					<button type="button" class="btn btn-primary go_provider_availability" >Ok</button>
				</div>
			</div>

		</div>
	</div>
</div>

<form class="modal account-modal fade multi-step" id="modal-wizard" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header d-block p-0 border-0 overflow-hidden">
				<div class="m-progress">
					<div class="m-progress-bar-wrapper">
						<div class="m-progress-bar">
						</div>
					</div>
					<div class="m-progress-stats">
						<span class="m-progress-current">
						</span>
						/
						<span class="m-progress-total">
						</span>
					</div>
					<div class="m-progress-complete">
					</div>
				</div>
				<button type="button" class="close close_login m-0 position-absolute r-0" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body step-1" data-step="1">
				<div class="account-content">
					<div class="account-box">
						<div class="login-right">
							<div class="login-header">
								<h3>Join as a Professional</h3>
								<p class="text-muted">Registration for Provider</p>
							</div>
						</div>
						<label>What Service do you Provide?</label>                
						<select class="form-control" title="Category" name="categorys" id="categorys">
							<option value='' >Select your service here...</option>
						</select>
						<span class="category_error"></span>
					</div>
				</div>
			</div>

			<div class="modal-body step-2" data-step="2">
				<div class="account-content">
					<div class="account-box">
						<div class="login-right">
							<div class="login-header">
								<h3>Join as a Professional</h3>
								<p class="text-muted">Registration for Provider</p>
							</div>
						</div>
						<form id="new_second_page">
							<label>Choose the Sub Category</label>
							<select class="form-control" title="Sub Category" name="subcategorys" id="subcategorys">
								<option value=''>Enter your sub category...</option>
							</select>
						</form>
					</div>
				</div>
			</div>

			<div class="modal-body step-3" data-step="3">
				<div class="account-content">
					<div class="account-box">
						<div class="login-right">
							<div class="login-header">
								<h3>Join as a Professional</h3>
								<p class="text-muted">Registration for Provider</p>
							</div>
						</div>
						<form action="" method='post' id="new_third_page">
							<div class="form-group">
								<label>Name</label>
								<input type="text" class="form-control" name="userName" id='userName'>
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="text" class="form-control" name="userEmail" id='userEmail'>
							</div>
							<div class="form-group">
								<label>Mobile Number</label>
								<div class="row">
									<div class="col-4 pr-0">
										<select name="countryCode" id="countryCode" class="form-control countryCode final_provider_c_code">
											<?php
											foreach ($country_list as $key => $country) { 
												if($country['country_id']=='91'){$select='selected';}else{ $select='';} ?>
												<option <?=$select;?> data-countryCode="<?=$country['country_code'];?>" value="<?=$country['country_id'];?>"><?=$country['country_name'];?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-8">
										<input type="text" class="form-control form-control-lg provider_final_no user_mobile" placeholder="Enter Mobile No" name="userMobile" id='userMobile' >
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="custom-control custom-control-xs custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="agreeCheckbox" id="agree_checkbox" value="1">
									<label class="custom-control-label" for="agree_checkbox">I agree to <?=settingValue('website_name')?></label> <a tabindex="-1" href="javascript:void(0);">Privacy Policy</a> &amp; <a tabindex="-1" href="javascript:void(0);"> Terms.</a>
								</div>
							</div>
							<div class="form-group">
								<button id="registration_submit" type="submit" class="btn login-btn">Register</button>
							</div>
							<div class="account-footer text-center">
								Already have an account? <a href="javascript:void(0);" data-dismiss="modal" data-toggle="modal" data-target="#tab_login_modal">Login</a>
							</div>
						</form> 
					</div>
				</div>
			</div>

			<div class="modal-body step-4" data-step="4">
				<div class="login-header">
					<h3>OTP</h3>
					<p class="text-muted">Verification your account</p>
				</div>
				<form action="<?php echo base_url()?>user/login/send_otp_request" method='post' id="new_fourth_page">
					<div class="form-group">
						<input type="hidden" class="form-control form-control-lg" placeholder="Mobile Number" name='enteredMobile' id='enteredMobile'>
					</div>
					<?php if(($_SERVER['HTTP_HOST']=='https://') || ($_SERVER['HTTP_HOST']=='http://')){
			        //$api_key = "3824a23a-c828-11ea-9fa5-0200cd936042";
			        $api_key = "523977b1-cfcd-11ea-9fa5-0200cd936042";
			          
			      }else{
			        $api_key = 'default_otp';
			      }
					if(settingValue($api_key)==1){ ?>
					<div class="alert alert-danger text-center" role="alert">
						We have used default otp for demo purpose.<br> <strong>Default OTP 1234</strong>
					</div>
				<?php }else{?>
					<div class="alert alert-success text-center" role="alert">
						<strong>We Have Send SMS Via OTP</strong>
						<strong>Please Check Your Registered Mobile Number </strong>
					</div>
				<?php } ?>
					<div class="form-group">
						<input  type="text" class="form-control form-control-lg no_only" maxlength="4" autocomplete="off" minlength="4" placeholder=" Enter OTP Here...." name="otp_number" id='otp_number'>
						<span for='otp_number' id='otp_error_msg'></span>
					</div>
					<p class="resend-otp">Didn't receive the OTP? <a href="#" id="re_send_otp_provider" > Resend OTP</a></p>
					<div>
						<button id='registration_final_old' type="submit" class="login-btn" >Finish</button>
					</div>
					<div>
						<button id='registration_resend_new' type="button" class="invisible login-btn" >Resend</button>
					</div>
				</form> 
			</div>

			<div class="modal-footer mx-auto">
				<button type="button" class="btn btn-theme text-white px-5 py-2 mt-0 mb-4 step step-1" disabled="disabled" id='step1_footer' data-step="3">Continue</button>
				<button type="button" class="btn btn-theme text-white px-5 py-2 mt-0 mb-4 step step-2"  id='step3_footer' data-step="1" >Back</button>
				<button type="button" class="btn btn-theme text-white px-5 py-2 mt-0 mb-4 step step-2"  disabled="disabled" id='step2_footer' data-step="2" >Continue</button>
			</div>
		</div>
	</div>
</form>

<div class="modal account-modal fade multi-step" id="modal-wizard1" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header p-0 border-0">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="header-content-blk text-center">
				<div class="alert alert-success text-center" id="flash_succ_message2" ></div>
			</div> 
			<div class="modal-body step-1" data-step="1">

				<div class="account-content">
					<div class="account-box">
						<div class="login-right">
							<div class="login-header">
								<h3>Join as a User</h3>
								<p class="text-muted">Registration for Customer</p>
							</div> 

							<form method='post' id="new_third_page_user">
								<div class="form-group">
									<label>Name</label>
									<input type="text" class="form-control" name="userName" id='user_name'>
								</div>
								<div class="form-group">
									<label>Email</label>
									<input type="email" class="form-control" name="userEmail" id='user_email'>
								</div>
								<div class="form-group">
									<label>Mobile Number</label>
									<div class="row">
										<div class="col-4 pr-0">
											<select name="countryCode" id="country_code" class="form-control countryCode final_country_code">
												<?php
												foreach ($country_list as $key => $country) { 
													if($country['country_id']=='91'){$select='selected';}else{ $select='';} ?>
													<option <?=$select;?> data-countryCode="<?=$country['country_code'];?>" value="<?=$country['country_id'];?>"><?=$country['country_name'];?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-8">
											<input type="text" class="form-control user_final_no user_mobile" placeholder="Enter Mobile No" name="userMobile" id='user_mobile'>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="custom-control custom-control-xs custom-checkbox">
										<input type="checkbox" class="custom-control-input" name="agreeCheckboxUser" id="agree_checkbox_user" value="1">
										<label class="custom-control-label" for="agree_checkbox_user">I agree to <?=settingValue('website_name')?></label> <a tabindex="-1" href="javascript:void(0);">Privacy Policy</a> &amp; <a tabindex="-1" href="javascript:void(0);"> Terms.</a>
									</div>
								</div>
								<div class="form-group">
									<button id="registration_submit_user" type="submit" class="login-btn btn">Register</button>
								</div>
								<div class="account-footer text-center">
									Already have an account? <a href="javascript:void(0);" data-dismiss="modal" data-toggle="modal" data-target="#tab_login_modal">Login</a>
								</div>
							</form> 
						</div>
					</div>
				</div>
			</div>
			
			<div class="modal-body step-2" data-step="2">
				<div class="login-header">
					<h3>OTP</h3>
					<p class="text-muted">Verification your account</p>
				</div>
				<form action="<?php echo base_url()?>user/login/send_otp_request_user" method='post' id="new_fourth_page_user">
					<div class="form-group">
						<input type="hidden" class="form-control form-control-lg" placeholder="Mobile Number" name='enteredMobile' id='enteredMobiles'>
					</div>
					<div class="form-group">
						<?php if(($_SERVER['HTTP_HOST']=='https://') || ($_SERVER['HTTP_HOST']=='http://')){
					        $api_key = "523977b1-cfcd-11ea-9fa5-0200cd936042";  
					      }else{
					        $api_key = 'default_otp';
					      }
						if(settingValue($api_key)==1){ ?>
						<div class="alert alert-danger text-center" role="alert">
							We have used default otp for demo purpose.<br> <strong>Default OTP 1234</strong>
						</div>
					<?php }else{?>
						<div class="alert alert-success text-center" role="alert">
							<strong>We Have Send SMS Via OTP</strong>
							<strong>Please Check Your Registered Mobile Number </strong>
						</div>
					<?php } ?>
						<input type="text" class="form-control form-control-lg no_only" autocomplete="off" maxlength="4" minlength="4" placeholder="Enter OTP Here.." name="otp_number" id='otp_number_user'>
						<span for='otp_number' id='otp_error_msg'></span>
					</div>
					
					<p class="resend-otp">Didn't receive the OTP? <a href="#" id="re_send_otp_user"> Resend OTP</a></p>
					<div>
						<button id='registration_final' type="submit" class="login-btn" >Enter</button>
					</div>
					<div>
						<button id='registration_resend' type="button" class="invisible login-btn" >Resend</button>
					</div>
				</form> 
			</div>
		</div>
	</div>
</div>

<footer class="footer">
	<?php 
	$query = $this->db->query("select * from system_settings WHERE status = 1");
	$result = $query->result_array();
	$stripe_option='1';
	$publishable_key='';
	$live_publishable_key='';
	$logo_front='';
	foreach ($result as $res) {
		if($res['key'] == 'stripe_option'){
			$stripe_option = $res['value'];
		} 
		if($res['key'] == 'publishable_key'){
			$publishable_key = $res['value'];
		} 
		if($res['key'] == 'live_publishable_key'){
			$live_publishable_key = $res['value'];
		} 

		if($res['key'] == 'logo_front'){
			$logo_front = $res['value'];
		}

	}

	if($stripe_option==1){
		$stripe_key= $publishable_key;
	}else{
		$stripe_key= $live_publishable_key;
	}

	if(!empty($logo_front)){
		$web_log=base_url().$logo_front;
	}else{
		$web_log=base_url().'assets/img/logo.png';
	}

	?>

	<input type="hidden" id="stripe_key" value="<?=$stripe_key;?>">
	<input type="hidden" id="logo_front" value="<?=$web_log;?>">

	<!-- Footer Top -->
	<div class="footer-top">
		<div class="container">
			<div class="row">

				<div class="col-lg-3 col-md-6">
					
					<!-- Footer Widget -->
					<div class="footer-widget footer-menu">
						<h2 class="footer-title">Quick Links  </h2>
						<ul>
							<li><a href="<?php echo base_url()?>faq">Faq</a></li>
							<li><a href="<?php echo base_url()?>help">Help</a></li>
							<?php
							if(empty($this->session->userdata('id'))){ ?>
								<li><a href="javascript:void(0);" data-toggle="modal" data-target="#modal-wizard">Create Account</a></li>
							<?php }
							?> 
							<li><a href="<?php echo base_url()?>contact">Contact Us</a></li>
						</ul>
					</div>
					<!-- /Footer Widget -->

				</div>

				<div class="col-lg-3 col-md-6">
					
					<!-- Footer Widget -->
					<div class="footer-widget footer-menu">
						<h2 class="footer-title">Categories</h2>
						<?php 

						$this->db->select('*');
						$this->db->from('categories');
						$this->db->where('status',1);
						$this->db->order_by('id','DESC');
						$this->db->limit(5);
						$result = $this->db->get()->result_array();

						?>
						<ul>
							<?php foreach ($result as $res) { ?>
								<li><a href="<?php echo base_url();?>subcategory/<?php echo $res['id'];?>"><?php echo ucfirst($res['category_name']); ?></a></li>
							<?php } ?>
						</ul>
					</div>
					<!-- /Footer Widget -->

				</div>

				<div class="col-lg-3 col-md-6">
					
					<!-- Footer Widget -->
					<div class="footer-widget footer-contact">
						<h2 class="footer-title">Contact Us</h2>
						<div class="footer-contact-info">
							<div class="footer-address">
								<span><i class="far fa-building"></i></span>
								<p>
									<?php $query = $this->db->query("select * from system_settings WHERE status = 1");
									$result = $query->result_array();

									foreach ($result as $res) {
										if($res['key'] == 'contact_details'){
											$contact_details = $res['value'];
											echo ''.$contact_details.'';
										} }?>
									</p>
								</div>
								<p>
									<i class="fas fa-headphones"></i>
									<?php $query = $this->db->query("select * from system_settings WHERE status = 1");
									$result = $query->result_array();

									foreach ($result as $res) {
										if($res['key'] == 'mobile_number'){
											$mobile_number = $res['value'];
											echo ''.$mobile_number.'';
										} }?>
									</p>
									<p class="mb-0">
										<i class="fas fa-envelope"></i>
										<?php $query = $this->db->query("select * from system_settings WHERE status = 1");
										$result = $query->result_array();

										foreach ($result as $res) {
											if($res['key'] == 'email_address'){
												$email_address = $res['value'];
												echo ''.$email_address.'';
											} }?>
										</p>
									</div>
								</div>
								<!-- /Footer Widget -->

							</div>
							<div class="col-lg-3 col-md-6">

								<!-- Footer Widget -->
								<div class="footer-widget">
									<h2 class="footer-title">Follow Us</h2>
									<div class="social-icon">
										<ul>
											<li>
												<a href="#" target="_blank"><i class="fab fa-facebook-f"></i> </a>
											</li>
											<li>
												<a href="#" target="_blank"><i class="fab fa-twitter"></i> </a>
											</li>
											<li>
												<a href="#" target="_blank"><i class="fab fa-youtube"></i></a>
											</li>
											<li>
												<a href="#" target="_blank"><i class="fab fa-google"></i></a>
											</li>
										</ul>
									</div>
								</div>
								<!-- /Footer Widget -->

							</div>

						</div>
					</div>
				</div>
				<!-- /Footer Top -->

				<!-- Footer Bottom -->
				<div class="footer-bottom">
					<div class="container">

						<!-- Copyright -->
						<div class="copyright">
							<div class="row">
								<div class="col-md-6 col-lg-6">
									<div class="copyright-text">
										<p class="mb-0">&copy; <?php echo date('Y').' '.$this->website_name;?></p>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">

									<!-- Copyright Menu -->
									<div class="copyright-menu">
										<ul class="policy-menu">
											<li><a href="<?php echo base_url()?>terms-conditions">Terms and Conditions</a></li>
											<li><a href="<?php echo base_url()?>privacy">Privacy</a></li>
										</ul>
									</div>
									<!-- /Copyright Menu -->

								</div>
							</div>
						</div>
						<!-- /Copyright -->

					</div>
				</div>
				<!-- /Footer Bottom -->

			</footer>
		</div>
		<input type="hidden" id="base_url" value="<?php echo $base_url; ?>">
		<input type="hidden" id="csrf_token" value="<?php echo $this->security->get_csrf_hash(); ?>">
		<input type="hidden" id="csrfName" value="<?php echo $this->security->get_csrf_token_name(); ?>">
		<input type="hidden" id="csrfHash" value="<?php echo $this->security->get_csrf_hash(); ?>">
		<input type='hidden' id='userLoginId' value="<?php echo $this->session->userdata('id'); ?>">
		<input type='hidden' id='chatToken' value="<?php echo $this->session->userdata('chat_token'); ?>">
		
		<script src="<?php echo $base_url; ?>assets/js/moment.min.js"></script>
		<script src="<?php echo $base_url; ?>assets/js/bootstrap-datetimepicker.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/popper.min.js"></script>

		<script src="<?php echo base_url();?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/sweetalert.min.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/datatables/datatables.min.js"></script>
		<script src="<?php echo $base_url; ?>assets/js/cropper_profile_provider.js"></script>
		<script src="<?php echo base_url();?>assets/js/cropper.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/script_crop.js"></script>
		<script src="<?php echo base_url();?>assets/js/bootstrapValidator.min.js"></script>
		<!-- Sticky Sidebar JS -->
		<script src="<?php echo base_url();?>assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>
		<!-- Toaster -->
		<script src="<?php echo base_url();?>assets/plugins/toaster/toastr.min.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/owlcarousel/owl.carousel.min.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAlkFoFDrBXGkL2uvusBEVAa5yPtoiFNHY&v=3.exp&libraries=places"></script>
		
		<input type="hidden" id="modules_page" value="<?php echo $module;?>">
		<input type="hidden" id="current_page" value="<?php echo $this->uri->segment(1);?>">
	
		<?php
		$edit_service=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		if($this->uri->segment(1)!='add-service'|| $edit_service!='user/service/edit_service'&&$this->uri->segment(1)!='update_booking'&&$this->uri->segment(1)!='update_booking'){?>
			<input type="hidden" id="service_location" class="asf">
	   <?php		
		}
	?>
			
	
			
		<?php if($module=='service' || $module == 'chat' || $module == 'terms' || $module == 'privacy'){ ?>
			
			<script src="<?php echo base_url();?>assets/js/bootstrap-select.min.js"></script>
			<script src="<?php echo base_url();?>assets/js/tagsinput.js"></script>
		
			<script src="<?php echo base_url();?>assets/js/service.js"></script>
		<?php } ?>

		<?php
		if($module=='home'){?>
			<?php if(!empty($this->uri->segment(1))){ ?>
				<input type='hidden' id='user_address'>
			<?php }?>
			<input type="hidden" id="user_address_values" value="<?=$this->session->userdata('user_address');?>">
			<input type="hidden" id="user_latitude_values" value="<?=$this->session->userdata('user_latitude');?>">
			<input type="hidden" id="user_longitude_values" value="<?=$this->session->userdata('user_longitude');?>">
			
			<script src="<?php echo base_url();?>assets/js/place.js"></script>
		<?php } ?>

		<script src="<?php echo base_url();?>assets/js/multi-step-modal.js"></script>
		<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/jquery-confirm/jquery-confirm.min.css">
		<script src="<?php echo base_url();?>assets/plugins/jquery-confirm/jquery-confirm.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/functions.js"></script>
		<input type="hidden" id="user_type" value="<?= $this->session->userdata('usertype'); ?>">
		
		<!-- login -->
		<?php if(empty($this->session->userdata('id'))){?>
			<script src="<?php echo $base_url; ?>assets/js/login.js"></script>
		<?php }?>

		<script src="<?php echo base_url();?>assets/js/script.js"></script>

		<!-- External js-->
		<?php if($this->uri->segment(1)=="user-chat"){ ?>
			<script src="<?php echo $base_url; ?>assets/js/user_chats.js"></script>
		<?php }?>
		<?php if($this->uri->segment(1)=="provider-availability"){ ?>
			<script src="<?php echo base_url(); ?>assets/js/provider_availability.js"></script>
		<?php }?>
		<?php if($this->uri->segment(1)=="provider-bookings"){ ?>
			<script src="<?php echo $base_url; ?>assets/js/provider_bookings.js"></script>
		<?php }?>
		<?php if($this->uri->segment(1)=="provider-settings"){ ?>
			<script src="<?php echo base_url(); ?>assets/js/provider_settings.js"></script>
		<?php }?>
		<?php if($this->uri->segment(1)=="provider-subscription"){ ?>
			<script src="<?php echo base_url(); ?>assets/js/provider_subscription.js"></script>
		<?php }?>
		<?php if($this->uri->segment(1)=="provider-wallet"){ ?>
			<script src="<?php echo base_url(); ?>assets/js/provider_wallet.js"></script>
		<?php }?>
		<?php if($this->uri->segment(1)=="user-bookings"){ ?>
			<script src="<?php echo $base_url; ?>assets/js/user_bookings.js"></script>
		<?php }?>
		<?php if($this->uri->segment(1)=="user-settings"){ ?>
			<script src="<?php echo base_url(); ?>assets/js/user_settings.js"></script>
		<?php }?>
		<?php if($this->uri->segment(1)=="user-wallet"){ ?>
			<script src="<?php echo base_url(); ?>assets/js/user_wallet.js"></script>
		<?php }?>
		<?php if($this->uri->segment(1)=="edit_service"){ ?>
			<script src="<?php echo $base_url; ?>assets/js/edit_service.js"></script>
		<?php }?>	
		<?php if($this->uri->segment(1)=="all-services" ||$this->uri->segment(1)=="search"){ ?>
			<script src="<?php echo base_url(); ?>assets/js/service_search.js"></script>
		<?php }?>
		<?php if($this->uri->segment(1)=="book-service"){ ?>
		 <script src="<?php echo base_url(); ?>assets/js/book_service.js"></script>
		<?php }?>
		<?php if($this->uri->segment(1)=="subcategories"){ ?>
		 <script src="<?php echo base_url(); ?>assets/js/subcategory.js"></script>
		<?php }?>
		<!---External js end-->

		<div class="modal account-modal fade" id="tab_login_modal">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header p-0 border-0">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger text-center"  id="flash_error_message1" ></div>
						<div id="login_form_div">
							<div class="account-content">
								<div class="account-box">
									<div class="login-right">
										<div class="login-header">
											<h3>Login</h3>
											<p class="text-muted">Access to Axzora</p>
										</div>
										<div class="form-group">
											<label>Mobile Number</label>
											<div class="row">
												<div class="col-4 pr-0">
													<input type="hidden" name="login_mode" id="login_mode" value="1">
													<input type="hidden" name="csrf_token_name" value="<?php echo $this->security->get_csrf_hash(); ?>" id="login_csrf">
													<select name="countryCode" id="login_country_code" class="form-control login_country_code">
														<?php
														foreach ($country_list as $key => $country) { 
															if($country['country_id']=='91'){$select='selected';}else{ $select='';} ?>
															<option <?=$select;?> data-countryCode="<?=$country['country_code'];?>" value="<?=$country['country_id'];?>"><?=$country['country_name'];?></option>
														<?php } ?>
													</select>
												</div>
												<div class="col-8">
													<input class="form-control login_mobile" type="text" name="login_mobile" id="login_mobile" placeholder="Enter Mobile No" min="10" max="10">
													<span id="mobile_no_error"></span>
												</div>
											</div>
										</div>
										<button class="login-btn" id="login_submit" type="submit">Login</button>
									</div>
								</div>
							</div>
						</div>

						<div class="step-2" data-step="2" id="otp_final_div" >
							<div class="login-header">
								<h3>OTP</h3>
								<p class="text-muted">Verification your account</p>
							</div>
							<div class="form-group">
								<input type="hidden" name="" id="login_country_code_hide">
								<input type="hidden" name="" id="login_mobile_hide">
								<input type="hidden" name="" id="login_mode_hide">
							</div>
							<div class="form-group">
								<?php
								if(($_SERVER['HTTP_HOST']=='https://') || ($_SERVER['HTTP_HOST']=='http://')){
							        $api_key = "523977b1-cfcd-11ea-9fa5-0200cd936042";  
							      }else{
							        $api_key = 'default_otp';
							      }
								 if(settingValue($api_key)==1){ ?>
								<div class="alert alert-danger text-center" role="alert">
									We have used default otp for demo purpose.<br> <strong>Default OTP 1234</strong>
								</div>
							<?php }else{ ?>
								<div class="alert alert-success text-center" role="alert">
									<strong>We Have Send SMS Via OTP</strong>
									<strong>Please Check Your Registered Mobile Number </strong>
								</div>
							<?php }?>
								<input type="text" class="form-control form-control-lg no_only" autocomplete="off" maxlength="4" minlength="4" placeholder="Enter OTP Here.." name="otp_numbers" id='login_otp'>
								<span for='otp_number' id='otp_error_msg_login'></span>
							</div>
							<p class="resend-otp">Didn't receive the OTP? <a href="#" id="login_resend_otp"> Resend OTP</a></p>
							<div>
								<button id='registration_finals' type="button" class="login-btn" >Enter</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Cancel Modal -->
		<div id="cancelModal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Cancelation Reason</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p class="cancel_reason"></p>
					</div>
				</div>
			</div>
		</div>
		<!-- Cancel Modal -->
		<span id="success_message"><?php echo $this->session->flashdata('success_message');?></span>
		<span id="error_message"><?php echo $this->session->flashdata('error_message');?></span>
	<?php
	if(!empty($this->session->flashdata('success_message'))){ ?>
			<script src="<?php echo base_url();?>assets/js/success_toaster.js"></script>
	<?php } ?>

	<?php
	if(!empty($this->session->flashdata('error_message'))){ ?>
		<script src="<?php echo base_url();?>assets/js/error_toaster.js"></script>
	<?php } 
	$this->session->unset_userdata('error_message');
	$this->session->unset_userdata('success_message');
	?>
	</body>

	</html>