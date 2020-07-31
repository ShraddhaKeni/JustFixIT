<?php

$this->db->select_min('service_amount');
$this->db->from('services');
$min_price = $this->db->get()->row_array();

$this->db->select_max('service_amount');
$this->db->from('services');
$max_price = $this->db->get()->row_array();

$currency = currency_conversion(settings('currency'));


  $query = $this->db->query("select * from system_settings WHERE status = 1");
          $result = $query->result_array();
          if(!empty($result))
          {
              foreach($result as $data){
                if($data['key'] == 'currency_option'){
                $currency_option = $data['value'];
                }
                
              }
          }
?>

	<div class="breadcrumb-bar">
		<div class="container-fluid">
			<div class="row">
				<div class="col">
					<div class="breadcrumb-title">
						<h2>Find a Professional</h2>
					</div>
				</div>
				<div class="col-auto float-right ml-auto breadcrumb-menu">
					<nav aria-label="breadcrumb" class="page-breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">Find a Professional</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>

	<div class="content">
			<div class="container-fluid">
				<div class="row">
                	<div class="col-lg-3 theiaStickySidebar">
						<div class="card filter-card">
							<div class="card-body">
								<h4 class="card-title mb-4">Search Filter</h4>
								<form id="search_form" method="post"><input type="hidden" id="tokenid" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

										<input type="hidden" id="tokenid" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

										<div class="filter-widget">
											<div class="filter-list">
												<h4 class="filter-title">Keyword</h4>
												<input type="text" id="common_search" value="<?php if(isset($_POST["common_search"]) && !empty($_POST["common_search"])) echo $_POST["common_search"];?>" class="form-control common_search" placeholder="What are you looking for?" />
											</div>
											<div class="filter-list">
												<h4 class="filter-title">Sort By</h4>
												<select id="sort_by" class="form-control selectbox select">
													<option value="">Sort By</option>
													<option value="1">Price Low to High</option>
													<option value="2">Price High to Low</option>
													<option value="3">Newest</option>
												</select>
											</div>
											<div class="filter-list">
												<h4 class="filter-title">Categories</h4>
												<select id="categories" class="form-control form-control selectbox select">
													<option value="">All Categories</option>
													<?php foreach ($category as $crows) {
														$selected='';
														if(isset($category_id) && !empty($category_id))
														{
															if($crows['id']==$category_id)
															{
																$selected='selected';
															}
														}
													echo'<option value="'.$crows['id'].'" '.$selected.'>'.$crows['category_name'].'</option>';	
													}?>
												</select>
											</div>

											<div class="filter-list">
												<h4 class="filter-title">SubCategories</h4>
												<select id="subcategories" class="form-control form-control selectbox select">
												</select>
											</div>

											<div class="filter-list">
												<h4 class="filter-title">Location</h4>
												<input class="form-control" type="text" id="service_location" value="<?php if(isset($_POST["user_address"]) && !empty($_POST["user_address"])) echo $_POST["user_address"];?>" placeholder="Search Location" name="user_address" >
												<input type="hidden" value="<?php if(isset($_POST["user_latitude"]) && !empty($_POST["user_latitude"])) echo $_POST["user_latitude"];?>" id="service_latitude">
												<input type="hidden" value="<?php if(isset($_POST["user_longitude"]) && !empty($_POST["user_longitude"])) echo $_POST["user_longitude"];?>" id="service_longitude">
											</div>
											<div class="filter-list">
												<h4 class="filter-title">Price Range</h4>
												<div class="price-ranges">
													₹<span class="from d-inline-block" id="min_price"><?php echo $min_price['service_amount']?></span> -
													₹<span class="to d-inline-block" id="max_price"><?php echo  $max_price['service_amount']?></span>
												</div>	
												<div class="range-slider price-range"></div>										
											</div>
										</div>
									<button class="btn btn-primary pl-5 pr-5 btn-block get_services" type="button">Search</button>
								</form>	
							</div>
						</div>
					</div>
					<div class="col-lg-9">
					
						<div class="row align-items-center mb-4">
							<div class="col-md-6 col">
								<h4><span id="service_count"><?php echo $count;?></span> Services Found</h4>
							</div>
							<div class="col-md-6 col-auto">
								<div class="view-icons ">
									<a href="javascript:void(0);" class="grid-view active"><i class="fas fa-th-large"></i></a>
								</div>
								
							</div>
						</div>
						<div>
							<div class="row" id="dataList">

								 <?php
								if(!empty($service))
								{

									foreach ($service as $srows) {
										 $serviceimage=explode(',', $srows['service_image']);
											
										$serviceimages=$this->db->where('service_id',$srows['id'])->get('services_image')->row_array();

										$provider_details = $this->db->where('id',$srows['user_id'])->get('providers')->row_array();

										$this->db->select('AVG(rating)');
										$this->db->where(array('service_id'=>$srows['id'],'status'=>1));
										$this->db->from('rating_review');
										$rating = $this->db->get()->row_array();
										$avg_rating = round($rating['AVG(rating)'],1);		
										

								        	$service_amount = $srows['service_amount'];
										
										?>
								<div class="col-lg-4 col-md-6">
									<div class="service-widget">
										<div class="service-img">
											<a href="<?php echo base_url().'service-preview/'.str_replace(' ', '-', strtolower($srows['service_title'])).'?sid='.md5($srows['id']);?>">
												<?php if(!empty($serviceimages['service_image'])){ ?>
												<img class="img-fluid serv-img" alt="Service Image" src="<?php echo base_url().$serviceimages['service_image'];?>">
											<?php }else{?>
												<img class="img-fluid serv-img" alt="Service Image" src="">
											<?php } ?>
											</a>
											<div class="item-info">
												<div class="service-user">
													<a href="#">
														<?php if($provider_details['profile_img'] == '') { ?>
														<img src="<?php echo base_url();?>assets/img/user.jpg">
														<?php } else { ?>
														<img src="<?php echo base_url().$provider_details['profile_img']?>">
														<?php } ?>
													</a>
													<span class="service-price"><?php echo currency_conversion(settings('currency')).$service_amount;?></span>
												</div>
												<div class="cate-list"> <a class="bg-yellow" href="<?php echo base_url().'search/'.str_replace(' ', '-', strtolower($srows['category_name']));?>"><?php echo ucfirst($srows['category_name']);?></a></div>
											</div>
										</div>
										<div class="service-content">
											<h3 class="title">
												<a href="<?php echo base_url().'service-preview/'.str_replace(' ', '-', strtolower($srows['service_title'])).'?sid='.md5($srows['id']);?>"><?php echo ucfirst($srows['service_title']);?></a>
											</h3>
											<div class="rating">
														<?php 
													 for($x=1;$x<=$avg_rating;$x++) {
													        echo '<i class="fas fa-star filled"></i>';
													    }
													    if (strpos($avg_rating,'.')) {
													        echo '<i class="fas fa-star"></i>';
													        $x++;
													    }
													    while ($x<=5) {
													         echo '<i class="fas fa-star"></i>';
													        $x++;
													    }

													  ?>
												<span class="d-inline-block average-rating">(<?php echo $avg_rating?>)</span>
											</div>
											<div class="user-info">
											
												<div class="row">
												<?php if($this->session->userdata('id') != '')
												{ ?>
												<span class="col ser-contact"><i class="fas fa-phone mr-1"></i> <span>xxxxxxxx<?=rand(00,99)?></span></span>
												<?php } else { ?>
												<span class="col ser-contact"><i class="fas fa-phone mr-1"></i> <span>xxxxxxxx<?=rand(00,99)?></span></span>
                                            	<?php } ?>
												
												<span class="col ser-location"><span><?php echo ucfirst($srows['service_location']);?></span> <i class="fas fa-map-marker-alt ml-1"></i></span>
												</div>
												<hr>
													<div class="">
														<div class="social-icon">
															<center>
															<ul>
																<li style="display: inline;padding-left: 10px; padding-right: 10px; ">
																	<a href="http://www.facebook.com/sharer.php?u=<?php echo base_url().$srows['service_title'];?>" target="_blank"><i class="fab fa-facebook-f"></i> </a>
																</li>
																<li style="display: inline; padding-left: 10px; padding-right: 10px;">
																	<a href="http://twitter.com/share?text=<?php echo $srows['service_title']; ?>&url=<?php echo base_url().$srows['service_title'];?>" target="_blank"><i class="fab fa-twitter"></i> </a>
																</li>
																<li style="display: inline; padding-left: 10px; padding-right: 10px;">
																	<a href="https://plus.google.com/share?url=<?php echo base_url().$srows['service_title'];?>" target="_blank"><i class="fab fa-google"></i></a>
																</li>

																<li style="display: inline; padding-left: 10px; padding-right: 10px;">
																	<a href="http://www.linkedin.com/shareArticle?mini=true&url==<?php echo base_url().$srows['service_title'];?>
																	" target="_blank"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
																</li>
															</ul></center>
														</div>
													</div>
											</div>
										</div>
									</div>

								</div>
								<?php } }
							else { 
							
								echo '<div class="col-lg-12">
									<p class="mb-0">
										No Services Found
									</p>
								</div>';
							 } 

							echo $this->ajax_pagination->create_links();
							  ?>

								
								
							</div>
						</div>
						
					</div>					
				</div>
			</div>
	</div>

