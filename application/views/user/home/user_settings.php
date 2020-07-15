<?php 
$get_details = $this->db->where('id',$this->session->userdata('id'))->get('users')->row_array();
?>
<div class="content">
	<div class="container">
		<div class="row">
		 	<?php
			if(!empty($_GET['tbs'])){
				$val=$_GET['tbs'];
			}else{
				$val=1;
			}
			?>
			<input type="hidden" name="tab_ctrl" id="tab_ctrl" value="<?=$val;?>">
			<?php $this->load->view('user/home/user_sidemenu');?>
		 
            <div class="col-xl-9 col-md-8">
				<div class="tab-content pt-0">
					<div class="tab-pane show active" id="user_profile_settings" >
						<div class="widget">
							<h4 class="widget-title">Profile Settings</h4>
							<form id="update_user" action="<?php echo base_url()?>user/dashboard/update_user" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
   
								<div class="row">
									<div class="col-xl-12">
										<h5 class="form-title">Basic Information</h5>
									</div>
									<div class="form-group col-xl-12">
										<div class="media align-items-center mb-3">
											<?php if($get_details['profile_img'] != '') { ?>
											<img class="user-image" src="<?php echo base_url().$get_details['profile_img']?>" alt="">
											<?php } else { ?>
											<img class="user-image" src="<?php echo base_url();?>assets/img/user.jpg" alt="">
											<?php } ?>
											<div class="media-body">
												<h5 class="mb-0"><?php echo $this->session->userdata('name');?></h5>
												<p>Max file size is 20mb</p>
												<div class="jstinput">
													<a href="javascript:void(0);"  class="avatar-view-btn browsephoto openfile">Browse</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-xl-6">
										<label class="mr-sm-2">Name</label>
										<input class="form-control" type="text" value="<?php echo $get_details['name']?>" readonly>
									</div>
									<div class="form-group col-xl-6">
										<label class="mr-sm-2">Email</label>
										<input class="form-control" type="email" value="<?php echo $get_details['email']?>" readonly>
									</div>
									<div class="form-group col-xl-6">
										<label class="mr-sm-2">Country Code</label>
										<input class="form-control" type="text" value="<?php echo $get_details['country_code']?>" readonly>
									</div>
									<div class="form-group col-xl-6">
										<label class="mr-sm-2">Mobile Number</label>
										<input class="form-control no_only" type="text"  value="<?php echo $get_details['mobileno']?>" name="mobileno" readonly required>
									</div>
									<div class="form-group col-xl-6">
										<label class="mr-sm-2">Date of birth</label>
										<input type="text" class="form-control datepicker" autocomplete="off" name="dob" value="<?php echo (!empty($get_details['dob']))?date('d-m-Y',strtotime($get_details['dob'])):'';?>">
									</div>
									
									<div class="col-xl-12">
										<h5 class="form-title">Address</h5>
									</div>
									<div class="form-group col-xl-12">
										<label class="mr-sm-2">Address</label>
										<input type="text" class="form-control" name="address" value="<?= (!empty($user_address['address']))?$user_address['address']:'';?>">
									</div>
									<div class="form-group col-xl-6">
										<label class="mr-sm-2">Country</label>
										<select class="form-control" name="country_id" id="country_id">
											<option value=''>Select Country</option>
											<?php foreach($country as $row){?>
											<option value='<?php echo $row['id'];?>' <?php  if(!empty($user_address['state_id'])){echo ($row['id']==$user_address['country_id'])?'selected':'';}?>><?php echo $row['country_name'];?></option> 
											<?php } ?>
										</select>
									</div>
									<div class="form-group col-xl-6">
										<label class="mr-sm-2">State</label>
										<select class="form-control" name="state_id" id="state_id" >
										</select>
									</div>
									<div class="form-group col-xl-6">
										<label class="mr-sm-2">City</label>
										<select class="form-control" name="city_id" id="city_id" >
										</select>
									</div>
									<div class="form-group col-xl-6">
										<label class="mr-sm-2">Postal Code</label>
										<input type="text" class="form-control" name="pincode" value="<?= (!empty($user_address['pincode']))?$user_address['pincode']:'';?>" >
									</div>	
									<div class="form-group col-xl-12">
										<button name="form_submit" id="form_submit" class="btn btn-primary pl-5 pr-5" type="submit">Update</button>
									</div>
									<input type="hidden" id="country_id_value" value="<?= $user_address['country_id'];?>">
						<input type="hidden" id="state_id_value" value="<?= $user_address['state_id'];?>">
						<input type="hidden" id="city_id_value" value="<?= $user_address['city_id'];?>">
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="avatar-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Upload Image</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php $curprofile_img = (!empty($profile['profile_img']))?$profile['profile_img']:''; ?>
				<form class="avatar-form" action="<?php echo base_url()?>user/dashboard/profile_cropping" enctype="multipart/form-data" method="post">
					<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
					<div class="avatar-body">
						<div class="avatar-upload">
							<input class="avatar-src" name="avatar_src" type="hidden">
							<input class="avatar-data" name="avatar_data" type="hidden">
							<label for="avatarInput">Select Image</label>
							<input type="file" accept="image/*" class="avatar-input ad_pd_file" id="avatarInput" name="profile_img">
							
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="avatar-wrapper"></div>
							</div>
						</div>
						<div class="row avatar-btns">
							<div class="col-md-12">
								<input type="hidden" name="table_name" value="users">
								<input type="hidden" name="redirect" value="user-settings">
								<button class="btn btn-primary avatar-save pull-right" type="submit">Save Changes</button>
							</div>
						</div>
						
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


