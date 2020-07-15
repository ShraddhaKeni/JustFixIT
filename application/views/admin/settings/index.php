<div class="page-wrapper">
	<div class="content container-fluid">
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col-12">
					<h3 class="page-title">General Settings</h3>
				</div>
			</div>
		</div>
		<!-- /Page Header -->
					
		<ul class="nav nav-tabs menu-tabs">
			<li class="nav-item active">
				<a class="nav-link" href="<?php echo base_url().'admin/settings'; ?>">General Settings</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url().'admin/emailsettings';?>">Email Settings</a>
			</li>
			<li class="nav-item">
				 <a class="nav-link" href="<?php echo base_url().'admin/stripe_payment_gateway'; ?>">Payment Gateway</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url().'admin/sms-settings'; ?>">SMS Gateway</a>
			</li>
		</ul>
		
		
		
		<div class="row">
			<div class="col-xl-3 col-lg-4 col-md-4 settings-tab">
				<div class="card">
					<div class="card-body">
						<div class="nav flex-column">
							<a class="nav-link active" data-toggle="tab"href="#general">General</a>
							
							<a class="nav-link" data-toggle="tab" href="#push_notification">Push Notification</a>
							<a class="nav-link" data-toggle="tab" href="#terms">Terms & Conditions</a> 
							<a class="nav-link mb-0" data-toggle="tab" href="#privacy">Privacy</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-9 col-lg-8 col-md-8">
			
				<div class="card">
					<div class="card-body p-0">
						<form accept-charset="utf-8" action="" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>">
							<div class="tab-content pt-0">

								<!-- General Settings -->
								<div id="general" class="tab-pane active">
									<div class="card mb-0">
										<div class="card-header">
											<h4 class="card-title">General Settings</h4>
										</div>
										<div class="card-body">
											<div class="form-group">
												<label>Website Name</label>
												<input type="text" required="" class="form-control" id="website_name" name="website_name" placeholder="Dreamguy's Technologies" value="<?php if (isset($website_name)) echo $website_name;?>" pattern="^[a-zA-Z0-9@]+$">
											</div>
											<div class="form-group">
												<label>Contact Details</label>
												<input type="text" class="form-control" id="contact_details" name="contact_details" value="<?php if (isset($contact_details)) echo $contact_details;?>" required="" pattern="^[a-zA-Z0-9@,]+$">
											</div>
											<div class="form-group">
												<label>Mobile Number</label>
												<input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php if (isset($mobile_number)) echo $mobile_number;?>" required="">
											</div>
											<div class="form-group">
												<label>Currency</label>
												<?php 
												$services_total = $this->db->count_all_results('services');
												$currency_option = (!empty($currency_option))?$currency_option:'USD';
												$currencies=$this->db->get('currency')->result_array();
												if($services_total == 0 ){     
												?>
												<select class="form-control" name="currency_option" id="currency_option" required>
													<?php foreach ($currencies as $crows) { ?>
													<option value="<?php echo $crows['currency_code'];?>" <?php if($crows['currency_code']==$currency_option) echo 'selected';?>><?php echo $crows['currency_name'];?> (<?php echo $crows['currency_code'];?>)
													</option>
													<?php } ?>
												</select>
												<?php }else{ ?>
												<p><strong><?php echo $currency_option.' '.currency_conversion($currency_option) ?> </strong></p>
												<?php } ?>
											</div> 
											
											<div class="form-group">
												<label>Website Logo</label>
												<div class="uploader"><input type="file" id="site_logo" multiple="true"  class="form-control" name="site_logo" placeholder="Select file"></div>
												<p class="form-text text-muted small mb-0">Recommended image size is <b>150px x 150px</b></p>
												<div id="img_upload_error" class="text-danger"  ><b>Please upload valid image file.</b></div>
												<?php if (!empty($logo_front)){ ?><img src="<?php echo base_url().$logo_front?>" class="site-logo"><?php } ?>
											</div>

											<div class="form-group">
												<label>Favicon</label>
												<div class="uploader"><input type="file"  multiple="true"  class="form-control" id="favicon" name="favicon" placeholder="Select file"></div>
												<p class="form-text text-muted small mb-0">Recommended image size is <b>16px x 16px</b> or <b>32px x 32px</b></p>
												<p class="form-text text-muted small mb-1">Accepted formats: only png and ico</p>
												<div id="img_upload_errors" class="text-danger" >Please upload valid image file.</div>
												<?php if (!empty($favicon)){ ?><img src="<?php echo base_url().'uploads/logo/'.$favicon?>" class="fav-icon"><?php } ?>
											</div>
										</div>
									</div>
								</div>
								<!-- /General Settings -->
								
								<!-- Push Notification -->
								<div id="push_notification" class="tab-pane">
									<div class="card mb-0">
										<div class="card-header">
											<h4 class="card-title">Push Notification</h4>
										</div>
										<div class="card-body">
											<div class="form-group">
												<label>Firebase Server Key</label>
												<input type="text" class="form-control" id="firebase_server_key" name="firebase_server_key" value="<?php if (isset($firebase_server_key)) echo $firebase_server_key;?>">
											</div>
											<div class="form-group">
												<label>APNS Key</label>
												<input type="text" class="form-control" id="apns_server_key" name="apns_server_key" value="<?php if (isset($apns_server_key)) echo $apns_server_key;?>">
											</div>
										</div>
									</div>
								</div>
								<!-- /Push Notification -->
								
								<!-- Terms & Conditions -->
								<div id="terms" class="tab-pane">
									<div class="card mb-0">
										<div class="card-header">
											<h4 class="card-title">Terms & Conditions</h4>
										</div>
										<div class="card-body">
											<div class="form-group">
												<label>Page Content</label>
												<textarea class="form-control content-textarea" name="terms" id="summernote"><?php if (isset($terms)) echo $terms;?></textarea>
											</div>
										</div>
									</div>
								</div>
								<!-- /Terms & Conditions -->

								<!-- Privacy Policy -->
								<div id="privacy" class="tab-pane pt-0">
									<div class="card mb-0 shadow-none">
										<div class="card-header">
											<h4 class="card-title">Privacy</h4>
										</div>
										<div class="card-body">
											<div class="form-group">
												<label>Page Content</label>
												<textarea class="form-control content-textarea" name="privacy" id="privacy_note"><?php if (isset($privacy)) echo $privacy;?></textarea>
											</div>
										</div>
									</div>
								</div>
								<!-- /Privacy Policy -->
								<div class="card-body pt-0">
									<?php if($user_role==1){?>
									<button name="form_submit" type="submit" class="btn btn-primary" value="true">Save Changes</button>
									 <?php }?>

								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>