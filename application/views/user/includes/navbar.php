<body>
	<div class="page-loading">
		<div class="preloader-inner">
			<div class="preloader-square-swapping">
				<div class="cssload-square-part cssload-square-green"></div>
				<div class="cssload-square-part cssload-square-pink"></div>
				<div class="cssload-square-blend"></div>
			</div>
		</div>
	</div>

	<div class="main-wrapper">

		<header class="header sticktop">
			<nav class="navbar navbar-expand-lg header-nav">
				<div class="navbar-header">
					<a id="mobile_btn" href="javascript:void(0);">
						<span class="bar-icon">
							<span></span>
							<span></span>
							<span></span>
						</span>
					</a>
					<a href="<?php echo base_url();?>" class="navbar-brand logo">
						<img src="<?php echo base_url().$this->website_logo_front; ?>" class="img-fluid" alt="Logo">
					</a>
					<a href="<?php echo base_url();?>" class="navbar-brand logo-small">
						<img src="<?php echo base_url();?>assets/img/logo-icon.png" class="img-fluid" alt="Logo">
					</a>
				</div>
				<div class="main-menu-wrapper">
					<div class="menu-header">
						<a href="<?php echo base_url();?>" class="menu-logo">
							<img src="<?php echo base_url().$this->website_logo_front; ?>" class="img-fluid" alt="Logo">
						</a>
						<a id="menu_close" class="menu-close" href="javascript:void(0);">
							<i class="fas fa-times"></i>
						</a>
					</div>
					<ul class="main-nav">
						<li><a href="<?php echo base_url();?>">Home</a></li>
						<li class="has-submenu">
							<?php
							$this->db->select('*');
							$this->db->from('categories');
							$this->db->where('status',1);
							$this->db->order_by('category_name','ASC');
							$result = $this->db->get()->result_array();
							?>
							<a href="<?php echo base_url();?>all-categories">Categories <i class="fas fa-chevron-down"></i></a>
							<ul class="submenu">
								<?php foreach ($result as $res) { ?>
								<li>
									<!-- <a href="<?php echo base_url();?>search/<?php echo str_replace(' ', '-',strtolower($res['category_name'])); ?>"><?php echo ucfirst($res['category_name']); echo $res['id']; ?></a> -->

									<a href="<?php echo base_url();?>subcategory/<?php echo str_replace(' ', '-', $res['category_name']).'.'.$res['id'];  ?>"><?php echo ucfirst($res['category_name']); ?></a>

								</li>
								<?php } ?>
							</ul>
						</li>
						<li><a href="<?php echo base_url();?>about-us">About Us</a></li>
						<li><a href="<?php echo base_url();?>contact">Contact Us</a></li>

						<?php if($this->session->userdata('id') == '') { ?>
						<li><a href="javascript:void(0);" data-toggle="modal" data-target="#modal-wizard">Become a Professional</a></li>
						<li><a href="javascript:void(0);" data-toggle="modal" data-target="#modal-wizard1">Become a User</a></li>
						<li><a href="javascript:void(0);" data-toggle="modal" data-target="#modal-wizard2">Become a Affiliate</a></li>
						<li class="login-link">
							<a href="javascript:void(0);" data-toggle="modal" data-target="#tab_login_modal">Login</a>
						</li>
						<?php }?>
						

					<?php if(($this->session->userdata('id') != '') && ($this->session->userdata('usertype') == 'provider')){

						$get_details = $this->db->where('id',$this->session->userdata('id'))->get('providers')->row_array();
						$get_availability = $this->db->where('provider_id',$this->session->userdata('id'))->get('business_hours')->row_array();
						if(!empty($get_availability['availability'])){
						$check_avail=strlen($get_availability['availability']);
						}else {
						$check_avail=2;
					}

					$get_subscriptions=$this->db->select('*')->from('subscription_details')->where('subscriber_id',$this->session->userdata('id'))->where('expiry_date_time >=',date('Y-m-d 00:00:59'))->get()->row_array();
					if(!isset($get_subscriptions)){
						$get_subscriptions['id']='';
					}
					if( !empty($get_availability) && !empty($get_subscriptions['id']) && $check_avail > 5) {
					?>
					<li class="mobile-list">
						<a href="<?php echo base_url();?>add-service">Post a Service </a>
					</li>
					<?php 
					}

					elseif ($get_subscriptions['id']=='') { ?>
					<li class="mobile-list">
						<a href="javascript:;" class="get_pro_subscription">Post a service</a>
					</li>
					<?php 
					} 
					elseif ($get_availability == '' || $get_availability['availability']=='' || $check_avail < 5) { ?>
					<li class="mobile-list">
						<a href="javascript:;" class="get_pro_availabilty"><span>Post a service</span></a>
					</li>
					<?php }
					}
					?>
					</ul>		 
				</div>		 
				<ul class="nav header-navbar-rht">
					<?php 
					if($this->session->userdata('id') == '') { ?>
						<li class="nav-item">
							<a class="nav-link header-login" href="javascript:void(0);" data-toggle="modal" data-target="#tab_login_modal">Login</a>
						</li>
					<?php }
					$wallet=0;
					$token='';
					if($this->session->userdata('id') != '') {
						if(!empty($token=$this->session->userdata('chat_token'))){
							$wallet_sql=$this->db->select('*')->from('wallet_table')->where('token',$this->session->userdata('chat_token'))->get()->row();
						if(!empty($wallet_sql)){
							$wallet=$wallet_sql->wallet_amt;
						}
					}

					if ($this->session->userdata('usertype') == 'provider') { ?>
					<li class="nav-item desc-list wallet-menu">
						<a href="<?=base_url().'provider-wallet'?>" class="nav-link header-login">
							<img src="<?php echo $base_url?>assets/img/wallet.png" alt="" class="mr-2 wallet-img"><span>Wallet:</span> ₹<?=$wallet;?>
						</a>
					</li>
					<?php 
					}else { ?>
					<li class="nav-item desc-list wallet-menu">
						<a href="<?=base_url().'user-wallet'?>" class="nav-link header-login">
							<img src="<?php echo $base_url?>assets/img/wallet.png" alt="" class="mr-2 wallet-img"><span>Wallet:</span> ₹<?=$wallet;?>
						</a>
					</li>
					<?php } } ?>

					<?php if(($this->session->userdata('id') != '') && ($this->session->userdata('usertype') == 'provider')){

						$get_details = $this->db->where('id',$this->session->userdata('id'))->get('providers')->row_array();
						$get_availability = $this->db->where('provider_id',$this->session->userdata('id'))->get('business_hours')->row_array();
						if(!empty($get_availability['availability'])){
						$check_avail=strlen($get_availability['availability']);
						}else {
						$check_avail=2;
					}

					$get_subscriptions=$this->db->select('*')->from('subscription_details')->where('subscriber_id',$this->session->userdata('id'))->where('expiry_date_time >=',date('Y-m-d 00:00:59'))->get()->row_array();
					if(!isset($get_subscriptions)){
						$get_subscriptions['id']='';
					}
					if( !empty($get_availability) && !empty($get_subscriptions['id']) && $check_avail > 5) {
					?>
					<li class="nav-item desc-list">
						<a href="<?php echo base_url();?>add-service" class="nav-link header-login"><i class="fas fa-plus-circle mr-1"></i> <span>Post a service</span></a>
					</li>
					<?php 
					}

					elseif ($get_subscriptions['id']=='') { ?>
					<li class="nav-item desc-list">
						<a href="javascript:;" class="nav-link header-login get_pro_subscription"><i class="fas fa-plus-circle mr-1"></i> <span>Post a service</span></a>
					</li>
					<?php 
					} 
					elseif ($get_availability == '' || $get_availability['availability']=='' || $check_avail < 5) { ?>
					<li class="nav-item desc-list">
					<a href="javascript:;" class="nav-link header-login get_pro_availabilty"><i class="fas fa-plus-circle mr-1"></i> <span>Post a service</span></a>
					</li>
					<?php }
					}
					?>
						
					<?php
					if($this->session->userdata('id')){
					if($this->session->userdata('usertype') == 'user') {
						$user_details = $this->db->where('id',$this->session->userdata('id'))->get('users')->row_array();
					}
					elseif($this->session->userdata('usertype') == 'provider') {
						$user_details = $this->db->where('id',$this->session->userdata('id'))->get('providers')->row_array();
					}
					?>
					<?php if($this->session->userdata('usertype') == 'provider') { ?>
					<!-- Notifications -->
					<li class="nav-item dropdown logged-item">
						<?php
						if(!empty($this->session->userdata('chat_token'))){
							$ses_token=$this->session->userdata('chat_token');
						} else{
							$ses_token='';
						}
						
						if(!empty($ses_token)){
							$ret=$this->db->select('*')->
							from('notification_table')->
							where('receiver',$ses_token)->
							where('status',1)->
							order_by('notification_id','DESC')->
							get()->result_array();
							
							$notification=[];
							if(!empty($ret)){
								foreach ($ret as $key => $value) {
									$user_table=$this->db->select('id,name,profile_img,token,type')->
									from('users')->
									where('token',$value['sender'])->
									get()->row();
									$provider_table=$this->db->select('id,name,profile_img,token,type')->
									from('providers')->
									where('token',$value['sender'])->
									get()->row();
									if(!empty($user_table)){
										$user_info= $user_table;
									}else{
										$user_info= $provider_table;
									}  
									$notification[$key]['name']= !empty($user_info->name)?$user_info->name:'';
									$notification[$key]['message']= !empty($value['message'])?$value['message']:'';
									$notification[$key]['profile_img']= !empty($user_info->profile_img)?$user_info->profile_img:'';
									$notification[$key]['utc_date_time']= !empty($value['utc_date_time'])?$value['utc_date_time']:'';
								}
							}
							$n_count=count($notification);
						}else{
							$n_count=0;
							$notification=[];
						}

						/* Notification Count */
						if(!empty($n_count) && $n_count !=0){
							$notify="<span class='badge badge-pill bg-yellow'>".$n_count."</span>";
						}else{
							$notify="";
						} ?>

						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
							<i class="fas fa-bell"></i> <?=$notify;?>
						</a>
						<div class="dropdown-menu dropdown-menu-right notifications">
							<div class="topnav-dropdown-header">
								<span class="notification-title">Notifications</span>
								<a href="javascript:void(0)" class="clear-noti noty_clear" data-token="<?php echo $this->session->userdata('chat_token');?>"> Clear All </a>
							</div>
							<div class="noti-content">
								<ul class="notification-list">
									<?php
									if(!empty($notification)){
									foreach ($notification as $key => $notify) {
									$full_date =date('Y-m-d H:i:s', strtotime($notify['utc_date_time']));
									$date=date('Y-m-d',strtotime($full_date));
									$date_f=date('d-m-Y',strtotime($full_date));
									$yes_date=date('Y-m-d',(strtotime ( '-1 day' , strtotime (date('Y-m-d')) ) ));
									$time=date('H:i',strtotime($full_date));
									$session = date('h:i A', strtotime($time));
									if($date == date('Y-m-d')){
										$timeBase ="Today ".$session;
									}elseif($date == $yes_date){
										$timeBase ="Yester day ".$session;
									}else{
										$timeBase =$date_f." ".$session;
									}
									$profile_img = $notify['profile_img'];
									if(empty($profile_img)){
										$profile_img ='assets/img/user.jpg';
									}
									?>
									<li class="notification-message">
										<a href="<?=base_url();?>notification-list">
											<div class="media">
												<span class="avatar avatar-sm">
													<img class="avatar-img rounded-circle" alt="User Image" src="<?=base_url().$profile_img;?>">
												</span>
												<div class="media-body">
													<p class="noti-details"> <span class="noti-title"><?=ucfirst($notify['message']);?></span></p>
													<p class="noti-time"><span class="notification-time"><?=$timeBase;?></span></p>
												</div>
											</div>
										</a>
									</li>
									<?php } } else { ?>
									<li class="notification-message">
										<p class="text-center text-danger mt-3">Empty</p>
									</li>
									<?php } ?>

								</ul>
							</div>
							<div class="topnav-dropdown-footer">
								<a href="<?=base_url();?>notification-list">View all notifications</a>
							</div>
						</div>
					</li>
					<!-- /Notifications -->
				
				<?php if(!empty($this->session->userdata('id'))){ ?>
					<!-- chat -->
					<?php $chat_token=$this->session->userdata('chat_token');
							if(!empty($chat_token)){
								$chat_detail=$this->db->where('receiver_token',$chat_token)->where('read_status=',0)->get('chat_table')->result_array();
							}


							 ?>
					<li class="nav-item dropdown logged-item">
						
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
							<i class="fa fa-comments" aria-hidden="true"></i>
							<?php if(count($chat_detail)!=0){?>
							<span class="badge badge-pill bg-yellow chat-bg-yellow"><?=count($chat_detail);?></span>
						<?php }?>
						</a>

						<div class="dropdown-menu dropdown-menu-right notifications">
							<div class="topnav-dropdown-header">
								<span class="notification-title">Chats</span>
								<a href="javascript:void(0)" class="clear-noti chat_clear_all" data-token="<?php echo $this->session->userdata('chat_token');?>" > Clear All </a>
							</div>
							
							<div class="noti-content">
								<ul class="chat-list notification-list">
									<?php 
									if(count($chat_detail)>0){
										$sender='';
									 foreach($chat_detail as $row){ 
									 	
									 	$user_table=$this->db->select('id,name,profile_img,token,type')->
									from('users')->
									where('token',$row['sender_token'])->
									get()->row();
									$provider_table=$this->db->select('id,name,profile_img,token,type')->
									from('providers')->
									where('token',$row['sender_token'])->
									get()->row();
									if(!empty($user_table)){
										$user_info= $user_table;
									}else{
										$user_info= $provider_table;
									}  									
									 	$full_date =date('Y-m-d H:i:s', strtotime($row['utc_date_time']));
										$date=date('Y-m-d',strtotime($full_date));
										$date_f=date('d-m-Y',strtotime($full_date));
										$yes_date=date('Y-m-d',(strtotime ( '-1 day' , strtotime (date('Y-m-d')) ) ));
										$time=date('H:i',strtotime($full_date));
										$session = date('h:i A', strtotime($time));
										if($date == date('Y-m-d')){
											$timeBase ="Today ".$session;
										}elseif($date == $yes_date){
											$timeBase ="Yester day ".$session;
										}else{
											$timeBase =$date_f." ".$session;
										}
										$profile_img = $user_info->profile_img;
										if(empty($profile_img)){
											$profile_img ='assets/img/user.jpg';
										} ?>
									<li class="notification-message">
										<a href="<?=base_url();?>user-chat">
											<div class="media">
												<span class="avatar avatar-sm">

													<img class="avatar-img rounded-circle" alt="User Image" src="<?=base_url().$profile_img;?>">
												</span>
												<div class="media-body">
													<p class="noti-details"> <span class="noti-title"><?=$user_info->name. " send a message as ".$row['message'];?></span></p>
													<p class="noti-time"><span class="notification-time"><?=$timeBase;?></span></p>
												</div>
											</div>
										</a>
									</li>
									<?php } }
									if(count($chat_detail)==0){
									?>

									<li class="notification-message">
										<p class="text-center text-danger mt-3">Empty</p>
									</li>
								<?php }?>

								</ul>
							</div>
							<div class="topnav-dropdown-footer">
								<a href="<?=base_url();?>user-chat">View all Chats</a>
							</div>
						</div>
					</li>
					<!-- /chat -->
				<?php } ?>
					<!-- User Menu -->
					<li class="nav-item dropdown has-arrow logged-item">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
							<span class="user-img">
								<?php if($user_details['profile_img'] != '') { ?>
								<img class="rounded-circle" src="<?php echo $base_url.$user_details['profile_img'] ?>" width="31" alt="">
								<?php } else { ?>
								<img class="rounded-circle" src="<?php echo $base_url?>assets/img/user.jpg" alt="">
								<?php } ?>
							</span>
						</a>
						<div class="dropdown-menu dropdown-menu-right">
							<div class="user-header">
								<div class="avatar avatar-sm">
									<?php if($user_details['profile_img'] != '') { ?>
									<img class="avatar-img rounded-circle" src="<?php echo $base_url.$user_details['profile_img'] ?>" alt="">
									<?php } else { ?>
									<img class="avatar-img rounded-circle" src="<?php echo $base_url?>assets/img/user.jpg" alt="">
									<?php } ?>
								</div>
								<div class="user-text">
									<h6><?php echo $user_details['name']; ?></h6>
									<p class="text-muted mb-0">Provider</p>
								</div>
							</div>
							<a class="dropdown-item" href="<?php echo base_url();?>provider-dashboard">Dashboard</a>
							<a class="dropdown-item" href="<?php echo base_url();?>my-services">My Services</a>
							<a class="dropdown-item" href="<?php echo base_url();?>provider-bookings">Booking List</a>
							<a class="dropdown-item" href="<?php echo base_url();?>provider-settings">Profile Settings</a>
							<a class="dropdown-item" href="<?php echo base_url();?>provider-wallet">Wallet</a>
							<a class="dropdown-item" href="<?php echo base_url()?>provider-subscription">Subscription</a>
							<a class="dropdown-item" href="<?php echo base_url()?>provider-availability">Availability</a>
							<a class="dropdown-item" href="<?php echo base_url()?>user-chat">Chat</a>
							<a class="dropdown-item" href="<?php echo base_url()?>logout">Logout</a>
						</div>
					</li>
					<!-- /User Menu -->

					<?php } elseif($this->session->userdata('usertype') == 'user') { ?>
					<!-- Notifications -->
					<li class="nav-item dropdown logged-item">
						<?php
						if(!empty($this->session->userdata('chat_token'))){
							$ses_token=$this->session->userdata('chat_token');
						}else{
							$ses_token='';
						}
						if(!empty($ses_token)){
							$ret=$this->db->select('*')->
							from('notification_table')->
							where('receiver',$ses_token)->
							where('status',1)->
							order_by('notification_id','DESC')->
							get()->result_array();
							$notification=[];
							if(!empty($ret)){
								foreach ($ret as $key => $value) {
									$user_table=$this->db->select('id,name,profile_img,token,type')->
									from('users')->
									where('token',$value['sender'])->
									get()->row();
									$provider_table=$this->db->select('id,name,profile_img,token,type')->
									from('providers')->
									where('token',$value['sender'])->
									get()->row();
									if(!empty($user_table)){
										$user_info= $user_table;
									}else{
										$user_info= $provider_table;
									}  
									$notification[$key]['name']= !empty($user_info->name)?$user_info->name:'';
									$notification[$key]['message']= !empty($value['message'])?$value['message']:'';
									$notification[$key]['profile_img']= !empty($user_info->profile_img)?$user_info->profile_img:'';
									$notification[$key]['utc_date_time']= !empty($value['utc_date_time'])?$value['utc_date_time']:'';
								}
							}
							$n_count=count($notification);
						}else{
							$n_count=0;
							$notification=[];
						}
						
						/*notification Count*/
						if(!empty($n_count) && $n_count !=0){
							$notify="<span class='badge badge-pill bg-yellow'>".$n_count."</span>";
						}else{
							$notify="";
						} ?>

						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
							<i class="fas fa-bell"></i> <?=$notify;?>
						</a>
						<div class="dropdown-menu dropdown-menu-right notifications">
							<div class="topnav-dropdown-header">
								<span class="notification-title">Notifications</span>
								<a href="javascript:void(0)" class="clear-noti noty_clear" data-token="<?php echo $this->session->userdata('chat_token');?>" > Clear All </a>
							</div>
							<div class="noti-content">
								<ul class="notification-list">
									<?php
									if(!empty($notification)){
										foreach ($notification as $key => $notify) {
										$full_date =date('Y-m-d H:i:s', strtotime($notify['utc_date_time']));
										$date=date('Y-m-d',strtotime($full_date));
										$date_f=date('d-m-Y',strtotime($full_date));
										$yes_date=date('Y-m-d',(strtotime ( '-1 day' , strtotime (date('Y-m-d')) ) ));
										$time=date('H:i',strtotime($full_date));
										$session = date('h:i A', strtotime($time));
										if($date == date('Y-m-d')){
											$timeBase ="Today ".$session;
										}elseif($date == $yes_date){
											$timeBase ="Yester day ".$session;
										}else{
											$timeBase =$date_f." ".$session;
										}
										$profile_img = $notify['profile_img'];
										if(empty($profile_img)){
											$profile_img ='assets/img/user.jpg';
										}
									?>

									<li class="notification-message">
									<a href="<?=base_url();?>notification-list">
										<div class="media">
											<span class="avatar avatar-sm">
												<img class="avatar-img rounded-circle" alt="User Image" src="<?=base_url().$profile_img;?>">
											</span>
											<div class="media-body">
												<p class="noti-details"> <span class="noti-title"><?=ucfirst($notify['message']);?></span></p>
												<p class="noti-time"><span class="notification-time"><?=$timeBase;?></span></p>
											</div>
										</div>
										</a>
									</li>
									<?php } }else{ ?>
									<li class="notification-message">
										<p class="text-center text-danger mt-3">Empty</p>
									</li>
									<?php } ?>
								</ul>
							</div>
							<div class="topnav-dropdown-footer">
								<a href="<?=base_url();?>notification-list">View all notifications</a>
							</div>
						</div>
					</li>
					<!-- /Notifications -->

				<?php if(!empty($this->session->userdata('id'))){ ?>
					<!-- chat -->
					<?php $chat_token=$this->session->userdata('chat_token');
							if(!empty($chat_token)){
								$chat_detail=$this->db->where('receiver_token',$chat_token)->where('read_status=',0)->get('chat_table')->result_array();
							}
							 ?>
					<li class="nav-item dropdown logged-item">
						
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
							<i class="fa fa-comments" aria-hidden="true"></i>
							<?php if(count($chat_detail)!=0){?>
							<span class="badge badge-pill bg-yellow chat-bg-yellow"><?=count($chat_detail);?></span>
								<?php }?>
						</a>

						<div class="dropdown-menu dropdown-menu-right notifications">
							<div class="topnav-dropdown-header">
								<span class="notification-title">Chats</span>
								<a href="javascript:void(0)" class="clear-noti chat_clear_all" data-token="<?php echo $this->session->userdata('chat_token');?>" > Clear All </a>
							</div>
							
							<div class="noti-content">
								<ul class="chat-list notification-list">
									<?php 
									if(count($chat_detail)>0){
										$sender='';
									 foreach($chat_detail as $row){ 
									 	
									 	$user_table=$this->db->select('id,name,profile_img,token,type')->
									from('users')->
									where('token',$row['sender_token'])->
									get()->row();
									$provider_table=$this->db->select('id,name,profile_img,token,type')->
									from('providers')->
									where('token',$row['sender_token'])->
									get()->row();
									if(!empty($user_table)){
										$user_info= $user_table;
									}else{
										$user_info= $provider_table;
									}  
									
									 	$full_date =date('Y-m-d H:i:s', strtotime($row['utc_date_time']));
										$date=date('Y-m-d',strtotime($full_date));
										$date_f=date('d-m-Y',strtotime($full_date));
										$yes_date=date('Y-m-d',(strtotime ( '-1 day' , strtotime (date('Y-m-d')) ) ));
										$time=date('H:i',strtotime($full_date));
										$session = date('h:i A', strtotime($time));
										if($date == date('Y-m-d')){
											$timeBase ="Today ".$session;
										}elseif($date == $yes_date){
											$timeBase ="Yester day ".$session;
										}else{
											$timeBase =$date_f." ".$session;
										}
										$profile_img = $user_info->profile_img;
										if(empty($profile_img)){
											$profile_img ='assets/img/user.jpg';
										}
									 	?>

									<li class="notification-message">
										<a href="<?=base_url();?>user-chat">
											<div class="media">
												<span class="avatar avatar-sm">

													<img class="avatar-img rounded-circle" alt="User Image" src="<?=base_url().$profile_img;?>">
												</span>
												<div class="media-body">
													<p class="noti-details"> <span class="noti-title"><?=$user_info->name. " send a message as ".$row['message'];?></span></p>
													<p class="noti-time"><span class="notification-time"><?=$timeBase;?></span></p>
												</div>
											</div>
										</a>
									</li>
									<?php } }
									if(count($chat_detail)==0){
									?>

									<li class="notification-message">
										<p class="text-center text-danger mt-3">Empty</p>
									</li>
								<?php }?>

								</ul>
							</div>
							<div class="topnav-dropdown-footer">
								<a href="<?=base_url();?>user-chat">View all Chats</a>
							</div>
						</div>
					</li>
					<!-- /chat -->
				<?php } ?>
					<li class="nav-item dropdown has-arrow logged-item">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
							<span class="user-img">
								<?php if($user_details['profile_img'] != '') { ?>
								<img class="rounded-circle" src="<?php echo $base_url.$user_details['profile_img'] ?>" alt="">
								<?php } else { ?>
								<img class="rounded-circle" src="<?php echo $base_url?>assets/img/user.jpg" alt="">
								<?php } ?>
							</span>
						</a>
						<div class="dropdown-menu dropdown-menu-right">
							<div class="user-header">
								<div class="avatar avatar-sm">
									<?php if($user_details['profile_img'] != '') { ?>
									<img class="avatar-img rounded-circle" src="<?php echo $base_url.$user_details['profile_img'] ?>" alt="">
									<?php } else { ?>
									<img class="avatar-img rounded-circle" src="<?php echo $base_url?>assets/img/user.jpg" alt="">
									<?php } ?>
								</div>
								<div class="user-text">
									<h6><?php echo $user_details['name']; ?></h6>
									<p class="text-muted mb-0">User</p>
								</div>
							</div>
							<a class="dropdown-item" href="<?php echo base_url();?>user-dashboard">Dashboard</a>
							<a class="dropdown-item" href="<?php echo base_url();?>user-bookings">My Bookings</a>
							<a class="dropdown-item" href="<?php echo base_url();?>user-settings">Profile Settings</a>
							<a class="dropdown-item" href="<?php echo base_url()?>all-services">Book Services</a>
							<a class="dropdown-item" href="<?php echo base_url()?>user-chat">Chat</a>
							<a class="dropdown-item" href="<?php echo base_url()?>logout">Logout</a>
						</div>
					</li>
					<?php } } ?>
				</ul>
			</nav>
		</header>
		