<div class="breadcrumb-bar">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="breadcrumb-title">
					<h2>Contact Us</h2>
				</div>
			</div>
			<div class="col-auto float-right ml-auto breadcrumb-menu">
				<nav aria-label="breadcrumb" class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">Contact Us</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>

<div class="content">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="contact-blk-content">
					<p>
						<b>Have any queries? We are always happy to help!<br>
						Give us a ring on 9262626262<br>
						Or drop us a mail at teamaxzora@gmail.com</b>
					</p>
                    <hr>
                    <div class="col-md-12">
						<div class='col-md-4' style="display: inline-block; vertical-align: top;"><b> GOA </b><br>
							Y-11, 5th Floor, Building No. 1-A,<br>
							Jairam Complex, Neugi Nagar,<br>
							Panaji - Goa, 403 001<br>
						</div>
						<div class='col-md-7'style="display: inline-block;">
							<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d7689.830437970604!2d73.83503612509779!3d15.488991846173468!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sY-11%2C%205th%20Floor%2C%20Building%20No.%202%20Jairam%20Complex%2C%20Neugi%20Nagar%20Panaji%20-%20Goa%2C%20403%20001!5e0!3m2!1sen!2sin!4v1596614219529!5m2!1sen!2sin" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
						</div>
					</div>
					<hr>
					<div class="col-md-12">					
						<div class="col-md-4" style="display: inline-block; vertical-align: top"><b>HYDERABAD</b><br>
							2nd Floor, Maa Residency,<br>
							New Nagole Colony,<br>
							Kothapet, Hyderabad,<br>
							Secunderabad, 500 035<br>
						</div>
						<div class="col-md-4" style="display: inline-block">
							<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d1903.8874873380637!2d78.55225315811437!3d17.37455775685093!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1s2nd%20Floor%2C%20Maa%20Residency%2C%20New%20Nagole%20Colony%2C%20Kothapet%2C%20Hyderabad%2C%20Secunderabad%2C%20500%20035!5e0!3m2!1sen!2sin!4v1596614750917!5m2!1sen!2sin" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
						</div>
					</div>	
						<hr>
					<form method="post" action="<?php echo base_url().'submitcontact'; ?>" autocomplete="off" id="contact_form">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					<div class="service-fields mb-3">
						<h3 class="heading-2">Contact Form</h3>
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<label>Name <span class="text-danger">*</span></label>
									<input class="form-control" type="text" name="name" id="service_title" placeholder="Your name please!" 
									required>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Contact No. <span class="text-danger">*</span></label>
									<input class="form-control" type="text" name="mobile" id="service_amount" placeholder="Your contact no. please"
									required>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Email <span class="text-danger">*</span></label>
									<input class="form-control" type="text" name="email" id="service_location" placeholder="Your Email ID"
									required>
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group">
									<label>Tell us how we can help you? <span class="text-danger">*</span></label>
									<textarea class="form-control" name='description' placeholder="Tell us how we can help you?"></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="submit-section">
						<button class="btn btn-primary submit-btn" type="submit" value="submit">Submit</button>
					</div>
				</form>

				</div>
			</div>
		</div>


	</div>
</div>
