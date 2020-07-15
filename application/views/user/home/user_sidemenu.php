<div class="col-xl-3 col-md-4">
				
		   		<?php $user=$this->db->where('id',$this->session->userdata('id'))->get('users')->row();
		   		if(!empty($user->profile_img)){
		   			$profile_img=$user->profile_img;
		   		}else{
		   			$profile_img="assets/img/user.jpg";
		   		}
		   		?>
				<div class="mb-4">
					<div class="d-sm-flex flex-row flex-wrap text-center text-sm-left align-items-center">
						<img alt="profile image"  src="<?php echo base_url().$profile_img; ?>"   class="avatar-lg rounded-circle">
						<div class="ml-sm-3 ml-md-0 ml-lg-3 mt-2 mt-sm-0 mt-md-2 mt-lg-0">
							<h6 class="mb-0"><?php echo $this->session->userdata('name'); ?></h6>
							<p class="text-muted mb-0">Member Since <?php echo date('M Y',strtotime($user->created_at));?></p>
						</div>
					</div>
				</div>
				<div class="widget settings-menu">
					<ul role="tablist" class="nav nav-tabs">	
						<li class="nav-item current">
							<a href="<?php echo base_url()?>user-dashboard" class="nav-link <?= ($this->uri->segment(1)=="user-dashboard")?'active':'';?>">
								<i class="fas fa-chart-line"></i>
								<span>Dashboard</span>
							</a>
						</li>
						<li class="nav-item current">
							<a href="<?php echo base_url()?>user-bookings" class="nav-link <?= ($this->uri->segment(1)=="user-bookings")?'active':'';?>">
								<i class="far fa-calendar-check"></i>
								<span>My Bookings</span>
							</a>
						</li>					
						<li class="nav-item">
							<a href="<?php echo base_url()?>user-settings" class="nav-link <?= ($this->uri->segment(1)=="user-settings")?'active':'';?>">
								<i class="far fa-user"></i>
								<span>Profile Settings</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url()?>user-wallet" class="nav-link <?= ($this->uri->segment(1)=="user-wallet")?'active':'';?>">
								<i class="far fa-money-bill-alt"></i>
								<span>Wallet</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url()?>user-reviews" class="nav-link <?= ($this->uri->segment(1)=="user-reviews")?'active':'';?>">
								<i class="far fa-star"></i>
								<span>Reviews</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url()?>user-payment" class="nav-link <?= ($this->uri->segment(1)=="user-payment")?'active':'';?>">
								<i class="fas fa-hashtag"></i>
								<span>Payment</span>
							</a>
						</li>
					</ul>
				</div>
			</div>