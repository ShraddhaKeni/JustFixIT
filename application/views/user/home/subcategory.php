<div class="breadcrumb-bar">
		<div class="container-fluid">
			<div class="row">
				<div class="col">
					<div class="breadcrumb-title">
						<h2>Subcategory</h2>
					</div>
				</div>
				<div class="col-auto float-right ml-auto breadcrumb-menu">
					<nav aria-label="breadcrumb" class="page-breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">Subcategory</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<div class="content">
	<div class="container">
		<p> <b><?php  echo count($subcategory); ?> Subcategories Found</b></p>
		<div class="">
			<?php 
			$pagination=explode('|',$this->ajax_pagination->create_links());
			?>
		</div>					
		<div class="catsec">
			<div class="row" id="dataList">
<?php

	  if($subcategory){
	  foreach($subcategory as $subcategories) { ?>
	<div class="col-lg-4 col-md-6">
		<div class="service-widget">
			<div class="service-img">
				<a href="<?php echo base_url().'services/'.$subcategories['id']; ?>">
					<img class="img-fluid serv-img" alt="Service Image" src="<?php echo base_url().$subcategories['subcategory_image']; ?>">
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
		</div>
	</div>
</div>

