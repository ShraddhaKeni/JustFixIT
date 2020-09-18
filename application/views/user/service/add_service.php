<div class="content">
	<div class="container">

		<div class="row justify-content-center">
			<div class="col-lg-10">
				<div class="section-header text-center">
					<h2>Add Services</h2>
				</div>
			
				<input type="hidden" name="" value='<?php echo $provider[0]['category']; ?>' id='categoryId'>
			<input type="hidden" name="" id='subcategoryId' value='<?php echo $provider[0]['subcategory']; ?>'>
				
				<form method="post" enctype="multipart/form-data" autocomplete="off" id="add_service">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

					<div class="service-fields mb-3">
						<h3 class="heading-2">Service Information</h3>
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<label>Business Title <span class="text-danger">*</span></label>
									<input class="form-control" type="text" name="service_title" id="service_title" 
									placeholder="Enter your name or business name" required>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Service Price <span class="text-danger">*</span></label>
									<input class="form-control" type="text" name="service_amount" id="service_amount" 
									placeholder="Enter your fees" required>
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
						</div>
					</div>
					<div class="service-fields mb-3">
						<h3 class="heading-2">Service Category</h3>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Category <span class="text-danger">*</span></label>
									<select class="form-control select" title="Category" name="category" id="category"   required></select>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Subcategory <span class="text-danger">*</span></label>
									<select class="form-control select" title="Select Your SubCategory" name="subcategory" id="subcategory"  required></select>
								</div>
							</div>
						</div>
					</div>
					<div class="service-fields mb-3">						
						<div class="membership-info">
							<div class="row form-row membership-cont">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Service / Services Offered <span class="text-danger">*</span></label>
										<input class="form-control" type="text" name="service_offered[]" id="field1" class="" required="">
									</div> 
								</div>
							</div>
						</div>
						<div class="add-more form-group">
							<a href="javascript:void(0);" class="add-membership"><i class="fas fa-plus-circle"></i> Add More</a>
						</div>
					</div>
					<div class="service-fields mb-3">
						<h3 class="heading-2">Detailed Information</h3>
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<label>Description <span class="text-danger">*</span></label>
									<textarea id="about" class="form-control service-desc" name="about" required></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="service-fields mb-3">
						<h3 class="heading-2">Service Gallery</h3>
						<div class="row">
							<div class="col-lg-12">
								<div class="service-upload">
									<i class="fas fa-cloud-upload-alt"></i>
									<span>Upload good quality images of your service  *</span>
									<input type="file" name="images[]" id="images" multiple accept="image/jpeg, image/png, image/gif,">
								</div>
								<div id="uploadPreview"></div>
							</div>
						</div>
					</div>
					<div class="submit-section">
						<button class="btn btn-primary submit-btn" type="submit" name="form_submit" value="submit">Submit</button>
					</div>
				</form>
				
			</div>
		</div>
	</div>
</div>