<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="row">
			<div class="col-xl-8 offset-xl-2">
			<!-- Page Header -->
			  <div class="page-header">
					<div class="row">
						<div class="col-sm-12">
							<h3 class="page-title">Add Service Provider</h3>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<div class="card">
					<div class="card-body">
					<form action="<?php echo base_url().'save_provider'; ?>" method='post' id="add_providerId">
							<div class="form-group">
								<label>Category</label>
								<div class="row">
									<div class="col-6 pr-0">
										<select name="category" id="categoryId" class="form-control countryCode final_provider_c_code">
											<option value="">Select Category</option>
											<?php
											foreach ($categories as $key => $category) { ?>
												<option value="<?php echo $category->id; ?>"><?php echo $category->category_name;?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-6">
										<select name="subcategory" id="subcategoryId" class="form-control countryCode final_provider_c_code">
											<option value="">Select Subcategory</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Name</label>
								<input type="text" class="form-control" name="name" id='userName'>
								<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="text" class="form-control" name="email" id='userEmail'>
								<div id='email_error' style="color: red"></div>
							</div>
							<div class="form-group">
								<label>Mobile Number</label>
								<div class="row">
									<div class="col-4 pr-0">
										<select name="country_code" id="countryCode" class="form-control countryCode final_provider_c_code">
											<?php
											foreach ($countries as $key => $country) { ?>
												<option value="<?php echo $country->country_id; ?>"><?php echo $country->country_name;?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-8">
										<input type="text" class="form-control form-control-lg provider_final_no user_mobile" placeholder="Enter Mobile No" name="mobileno" id='userMobile' >
										<div id='mobile_error' style="color: red"></div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<button class="btn btn-primary" id="registration_submit" value="submit" type="submit">Register</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>	