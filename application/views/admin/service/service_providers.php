<?php
   $user_details = $this->db->get('providers')->result_array();
?>
<div class="page-wrapper">
	<div class="content container-fluid">
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col">
					<h3 class="page-title">Service Providers</h3>
				</div>
				<div class="col-auto text-right">
					<a class="btn btn-white filter-btn mr-3" href="javascript:void(0);" id="filter_search">
						<i class="fas fa-filter"></i>
					</a>
					<a class="btn btn-white filter-btn mr-3" href="<?php echo base_url().'add-service-providers'  ?>" id="add-service-providers">
						<i class="fas fa-user"></i>
					</a>
				</div>
			</div>
		</div>
		<!-- /Page Header -->
		
		<!-- Search Filter -->
		<form action="<?php echo base_url()?>admin/service/provider_list" method="post" id="filter_inputs">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
			<div class="card filter-card">
				<div class="card-body pb-0">
					<div class="row filter-row">
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label>Provider Name</label>
								<select class="form-control" name="username">
									<option value="">Select provider name</option>
									<?php foreach ($user_details as $user) { ?>
									<option value="<?=$user['name']?>"><?php echo $user['name']?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label>Email</label>
								<select class="form-control" name="email">
									<option value="">Select email</option>
									<?php foreach ($user_details as $user) { ?>
									<option value="<?=$user['email']?>"><?php echo $user['email']?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label>Status</label>
								<select class="form-control" name="status">
									<option value="">Select status</option>
									<option value="0">Verified</option>
									<option value="1">Not Verified</option>
								</select>
							</div>
						</div>
						<!--<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label>Sub Category</label>
								<select class="form-control" name="subcategory">
									<option value="">Select Category</option>
									<?php foreach ($subcategory as $sub_category) { ?>
									<option value="<?=$sub_category['id']?>"><?php echo $sub_category['subcategory_name']?>
									</option>
									<?php } ?>
								</select>
							</div>
						</div>-->
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label>From Date</label>
								<div class="cal-icon">
									<input class="form-control datetimepicker" type="text" name="from">
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label>To Date</label>
								<div class="cal-icon">
									<input class="form-control datetimepicker" type="text" name="to">
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<button class="btn btn-primary btn-block" name="form_submit" value="submit" type="submit">Submit</button>
							</div>
						</div>
					</div>

				</div>
			</div>
		</form>
		<!-- /Search Filter -->
		
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table mb-0 w-100" id="providers_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Provider Name</th>
                                        <th>Contact No</th>
                                        <th>Email</th>
                                        <th>Reg Date</th>
                                        <th>Subscription</th>
										<th>Verified</th>
										<th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php
									if(!empty($lists)) {
									$i=1;
									foreach ($lists as $rows) {
										if($rows['status']==1) {
											$val='checked';
										}
										else {
											$val='';
										}
										$profile_img = $rows['profile_img'];
										if(empty($profile_img)){
											$profile_img ='assets/img/user.jpg';
										}
										if(!empty($rows['created_at'])){
                                            $date=date('d-m-Y',strtotime($rows['created_at']));
										}else{
                                            $date='-';
										}
										if ($rows['is_verified']==0) {
											$verifyed='Verified';
										}
										else{
											$verifyed='Not Verified';
										}
										echo'<tr>
											<td>'.$i++.'</td>
											<td>
												<h2 class="table-avatar">
													<a href="#" class="avatar avatar-sm mr-2"> <img class="avatar-img rounded-circle" src="'.base_url().$profile_img.'"></a>
													<a href="'.base_url().'user-details/'.$rows['id'].'">'.str_replace('-', ' ', $rows['name']).'</a>
												</h2>
											</td>
											<td>'.$rows['mobileno'].'</td>
											<td>'.$rows['email'].'</td>
											<td>'.$date.'</td>
											<td>'.$rows['subscription_name'].'</td>
											<td>'.$verifyed.'</td>
											<td>
												<a href="'.base_url().'edit-service-providers/'.$rows['id'].'" class="btn btn-sm bg-success-light" title="Edit" data-id="'.$rows['id'].'"><i class="far fa-edit mr-1"></i> Edit</a>
          										<a href="javascript:void(0)" data-id="'.$rows['id'].'" class="btn btn-sm bg-danger-light delete_provider" title="Delete" data-id="'.$rows['id'].'"><i class="far fa-trash mr-1"></i> Delete</a>
          									</td>
										</tr>';
									}
                                    }
                                    else {
                                      echo '<tr><td colspan="6"><div class="text-center text-muted">No records found</div></td></tr>';
                                    }
									?>
                                </tbody>
                            </table>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>