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
								<form id="search_form" method="post" enctype="multipart/form-data">
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
									<button class="btn btn-primary pl-5 pr-5 btn-block get_subcategory" type="button">Search</button>
								</form>	
							</div>
						</div>
					</div>
					<div class="col-lg-9">
					
						<div class="row align-items-center mb-4">
							<div class="col-md-6 col">
								<h4><span id="subcategory_count"><?php echo count($subcategory) ;?></span> Subcategories Found</h4>
							</div>
							<div class="col-md-6 col-auto">
								<div class="view-icons ">
									<a href="javascript:void(0);" class="grid-view active"><i class="fas fa-th-large"></i></a>
								</div>
								
							</div>
						</div>
						<div>
							<div class="row" id="sub_dataList">

								  <!-- loop start from here -->	
								  <?php 
								  if($subcategory){
								  foreach($subcategory as $subcategories) { ?>
								<div class="col-lg-4 col-md-6">
									<div class="service-widget">
										<div class="service-img">
											<a href="<?php echo base_url().'services/'.$subcategories['id']; ?>">
												<img class="img-fluid serv-img" alt="Service Image" src="<?php echo $subcategories['subcategory_image']; ?>">
											</a>
										</div>
										<div class="service-content">
											<h3 class="title">
												<a href="<?php echo base_url().'services/'.$subcategories['id']; ?>"><?php echo $subcategories['subcategory_name']; ?></a>
											</h3>
										</div>
									</div>

								</div>
							<?php }} 
							else { 
							
								echo '<div class="col-lg-12">
									<p class="mb-0">
										No Services Found
									</p>
								</div>';
							 }  ?>
							</div>
							<div class="pagination" style='width:200px; margin: 0 auto'>
							<?php
							 $divided = $subcount/12;
							 for($j=1; $j<=ceil($divided); $j++){  ?>  <ul><li class="paginate count_<?php echo $j; ?>" data-val='<?php echo $j; ?>' style='display: inline; cursor: pointer;'><a><?php echo $j; ?></a></li> </ul> <?php }
							?></div>
						</div>
						
					</div>					
				</div>
			</div>
	</div>

