<div class="breadcrumb-bar">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="breadcrumb-title">
					<h2>Subcategories</h2>
				</div>
			</div>
			<div class="col-auto float-right ml-auto breadcrumb-menu">
				<nav aria-label="breadcrumb" class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">Subcategories</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<div class="content">
	<div class="container">
		<div class="">
			<?php 
			$pagination=explode('|',$this->ajax_pagination->create_links());
			?>
		</div>					
		<div class="catsec">
			<div class="row" id="dataList">

			<?php
			if(!empty($subcategory)) {
				foreach ($subcategory as $subcategories) {
					$category_name=strtolower($subcategories['subcategory_name']);
				?>
			<div class="col-lg-4 col-md-6">
				<a href="<?php echo base_url();?>services/<?php echo str_replace(' ', '-', $category_name).'.'.$subcategories['id']; ?>">
					<div class="cate-widget">
						<img src="<?php echo base_url().$subcategories['subcategory_image'];?>" alt="">
						<div class="cate-title">
							<h3><span><i class="fas fa-circle"></i> <?php echo ucfirst($subcategories['subcategory_name']);?></span></h3>
						</div>
						<div class="cate-count">
							<i class="fas fa-clone"></i> <?php//echo $subcategories['category_count'];?>
						</div>
					</div>
				</a>
			</div>
			<?php } }
			else { 

			echo '<div class="col-lg-12">
			<div class="category">
			No Categories Found
			</div>
			</div>';
			} 

			echo $this->ajax_pagination->create_links();
			?>
			</div>
		</div>
	</div>
</div>