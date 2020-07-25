<div class="page-wrapper">
	<div class="content container-fluid">
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col">
					<h3 class="page-title">Subscriptions</h3>
				</div>
				<div class="col-auto text-right">
					<a href="<?php echo $base_url; ?>add-subscription" class="btn btn-primary add-button">
						<i class="fas fa-plus"></i>
					</a>
				</div>
			</div>
		</div>
		<!-- /Page Header -->
		<div class="row pricing-box">
		<?php
		if(!empty($list)){
			foreach ($list as $subscription) {
		?>
			<div class="col-md-6 col-lg-4 col-xl-3">
				<div class="card">
					<div class="card-body">
						<div class="pricing-header">
							<h2><?php echo $subscription['subscription_name']; ?></h2>
							<p>Monthly Price</p>
						</div>
						<?php  if($subscription['discount']==0) { ?>
							<div class="pricing-card-price">
							<h5 class="heading4 price">₹<?php echo $subscription['fee']; ?></h5>
						</div>
						<?php }else{ ?>              
						<div class="pricing-card-price">
							<h5 class="heading4 price"><del>₹<?php echo $subscription['actual_amount']; ?></del></h5>
							<p><?php echo $subscription['discount']; ?>% OFF</p>
							<h3 class="heading2 price">₹<?php echo $subscription['fee']; ?></h3>
							<p>Duration: <span><?php echo $subscription['fee_description']; ?></span></p>
						</div>
					<?php } ?>
						<ul class="pricing-options">
							<li><i class="far fa-check-circle"></i> Unlimited listing submission</li>
							<li><i class="far fa-check-circle"></i> <?php echo $subscription['fee_description']; ?> expiration</li>
						</ul>
						
						<a href="<?php echo $base_url.'edit-subscription/'.$subscription['id']; ?>" class="btn btn-primary btn-block">Edit</a>
					
					</div>
				</div>
			</div>
		  <?php } } ?>
		</div>
	</div>
</div>