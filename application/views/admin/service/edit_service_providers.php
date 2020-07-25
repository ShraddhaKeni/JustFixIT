<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="row">
			<div class="col-xl-8 offset-xl-2">
			<!-- Page Header -->
			  <div class="page-header">
					<div class="row">
						<div class="col-sm-12">
							<h3 class="page-title">Edit Service Provider</h3>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<div class="card">
					<div class="card-body">
					<form action="<?php echo base_url().'update_provider/'.$provider[0]->id; ?>" method='post' id="new_third_page">
							<div class="form-group">
								<label>Category</label>
								<div class="row">
									<div class="col-6 pr-0">
										<select name="category" id="categoryId" class="form-control countryCode final_provider_c_code">
											<option>Select Category</option>
											<?php
											foreach ($categories as $key => $category) { ?>
												<option value="<?php echo $category->id; ?>" <?php if($provider[0]->category==$category->id){ echo "selected"; }  ?> ><?php echo $category->category_name;?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-6">
										<input type="hidden" id='subcategorySelect' value='<?php echo $provider[0]->subcategory;  ?>'>
										<select name="subcategory" id="subcategoryId" class="form-control countryCode final_provider_c_code">
											<option>Select Subcategory</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Name</label>
								<input type="text" class="form-control" name="name" id='userName'  value='<?php echo $provider[0]->name;  ?>'>
								<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="text" class="form-control" name="email" id='userEmail' value='<?php echo $provider[0]->email;  ?>'>
							</div>
							<div class="form-group">
								<label>Mobile Number</label>
								<div class="row">
									<div class="col-4 pr-0">
										<select name="country_code" id="countryCode" class="form-control countryCode final_provider_c_code">
											<?php
											foreach ($countries as $key => $country) { ?>
												<option value="<?php echo $country->country_id; ?>" <?php if($provider[0]->country_code==$country->country_id) { echo "selected"; } ?>><?php echo $country->country_name;?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-8">
										<input type="text" class="form-control form-control-lg provider_final_no user_mobile" placeholder="Enter Mobile No" name="mobileno" id='userMobile' value='<?php echo $provider[0]->mobileno;  ?>'>
									</div>
								</div>
							</div>
							<div class="form-group">
								<button class="btn btn-primary" value="submit" type="submit">Save Changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>	