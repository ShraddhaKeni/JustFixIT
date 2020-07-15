<div class="content">
	<div class="container">
		<div class="row">
			<?php $this->load->view('user/home/provider_sidemenu');?>
			<div class="col-xl-9 col-md-8">
				<div class="row">
                    
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="card">
							<div class="card-body">
								<h4 class="card-title">Wallet</h4>

								<div class="wallet-details">
									<span>Wallet Balance</span>
									<h3><?=$wallet['currency'].''.$wallet['wallet_amt'];?></h3>

									<div class="d-flex justify-content-between my-4">
                                        <?php
                                    $total_cr=0;
                                    $total_dr=0;

                                    if(!empty($wallet_history)){
                                     foreach ($wallet_history as $key => $value) {
                                      $total_cr +=(int)$value['credit_wallet'];
                                      $total_dr +=(int)abs($value['debit_wallet']);
                                     }
                                    }
                                    ?>
										<div>
											<p class="mb-1">Total Credit</p>
											<h4><?=$wallet["currency"].''.$total_cr;?></h4>
										</div>
										<div>
											<p class="mb-1">Total Debit</p>
											<h4><?=$wallet["currency"].''.$total_dr;?></h4>
										</div>
									</div>
									<div class="wallet-progress-chart">
										<div class="d-flex justify-content-between">
											<span><?=$wallet['currency'].''.abs($wallet['total_debit']);?></span>
											<?php
											if(!empty($wallet['total_credit'])){
												$wallet['total_credit']=$wallet['total_credit'];
											}else{
												$wallet['total_credit']=0;
											}
											?>
											<span><?=$wallet['currency'].''.number_format($wallet['total_credit'],2);?></span>
										</div>
										
										<?php
										$total_per=0;
										if(!empty($wallet['total_debit']) && !empty($wallet['total_credit'])){
											$total_per=($wallet['total_debit']/$wallet['total_credit'])*100;
										}
										?>
										<div class="progress mt-1">
											<div class="progress-bar bg-theme" role="progressbar" aria-valuenow="41" aria-valuemin="0" aria-valuemax="100" style="width:<?=round($total_per);?>%">
												<?=number_format(abs($total_per),2);?>%
											</div>
										</div>                                     
									</div> 
								</div>
							</div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="card">
							<div class="card-body">
								<h4 class="card-title">Withdraw</h4>
								<form action="#">
									<div class="form-group">
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<label class="input-group-text display-5"><?=$wallet['currency'];?></label>
											</div>
											<input type="text" maxlength="4"  class="form-control isNumber" name="wallet_withdraw_amt" id="wallet_withdraw_amt" placeholder="00.00">
										</div>
									</div>
								</form>
								<div class="text-center mb-3">
									<h5 class="mb-3">OR</h5>                                       
									<ul class="list-inline mb-0">
										<li class="line-inline-item mb-0 d-inline-block">
											<a href="javascript:;" data-amount="50" class="updatebtn withdraw_wallet_value"><?=$wallet['currency'];?>50</a>
										</li>
										<li class="line-inline-item mb-0 d-inline-block">
											<a href="javascript:;" data-amount="100" class="updatebtn withdraw_wallet_value"><?=$wallet['currency'];?>100</a>
										</li>
										<li class="line-inline-item mb-0 d-inline-block">
											<a href="javascript:;" data-amount="150" class="updatebtn withdraw_wallet_value"><?=$wallet['currency'];?>150</a>
										</li>
									</ul>
								</div>
								<a href="javascript:void(0);" id="stripe_withdraw_wallet" class="btn btn-primary btn-block withdraw-btn">Withdraw</a>
								<div id="card_form_div" >
									<div class="payment-card">
										<span>Withdraw Amount is</span>
										<h3 class="mb-3">$<span id="remember_withdraw_wallet"></span></h3>
										<h5 class="mb-3">Please Fill Debit Card Detail</h5>
										<div id="card-element">
											<!-- Stripe Element will be inserted here -->
										</div>

										<!-- Used to display form errors. -->
										<div id="card-errors" role="alert"></div>
										<div class="text-center"><div id="load_div"></div></div>
										<hr>
										<div class="text-center">
											<button class="btn btn-success" id="pay_btn">Withdraw</button>
											<button class="btn btn-secondary" id="cancel_card_btn">Cancel</button>
										</div>
									</div>
								</div>
							</div>
                        </div>
                    </div>
                </div>
				
				<h4 class="mb-4">Recent Transactions</h4>
				<div class="card transaction-table mb-0">
					<div class="card-body">
						<div class="table-responsive">
							<?php if(!empty($wallet_history)){ ?>
							<table id="order-summary" class="table table-center mb-0">
								<?php }else{?>
									<table class="table table-center mb-0">
								<?php }?>
								<thead>
									<tr>
									<th>S.No</th>
									<th>Date</th>
									<th>Wallet</th>
									<th>Credit</th>
									<th>Debit</th>
									<th>Available</th>
									<th>Reason</th>
									<th>Status</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$total_cr=0;
									$total_dr=0;
									if(!empty($wallet_history)){

									foreach ($wallet_history as $key => $value) {
									if(!empty($value['credit_wallet'])){
										$color='success';
										$message='Credit';
									}else{
										$color='danger';
										$message='Debit';
									}
									$total_cr+=(int)$value['credit_wallet'];
									$total_dr+=(int)abs($value['debit_wallet']);
									echo '<tr>
									<td>'.($key+1).'</td>
									<td>'.date("d M Y",strtotime($value["created_at"])).'</td>
									<td>'.$wallet["currency"].''.$value["current_wallet"].'</td>
									<td>'.$wallet["currency"].''.$value["credit_wallet"].'</td>
									<td>'.$wallet["currency"].''.$value["debit_wallet"].'</td>
									<td>'.$wallet["currency"].''.$value["avail_wallet"].'</td>
									<td><lable>'.$value["reason"].'</lable></td>
									<td><span class="badge bg-'.$color.'-light">'.$message.'</span></td> 
									</tr>';
									}

									}else{
										echo '<tr> <td colspan="8"> <div class="text-center">No data found</div></td> </tr>'; 
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


		 <?php 
		  $query = $this->db->query("select * from system_settings WHERE status = 1");
		  $result = $query->result_array();
		  $stripe_option='1';
		  $publishable_key='';
		  $live_publishable_key='';
		  $logo_front='';
			foreach ($result as $res) {
			  if($res['key'] == 'stripe_option'){
			  $stripe_option = $res['value'];
			  } 
			  if($res['key'] == 'publishable_key'){
			  $publishable_key = $res['value'];
			  } 
			   if($res['key'] == 'live_publishable_key'){
			  $live_publishable_key = $res['value'];
			  } 

			  if($res['key'] == 'logo_front'){
			  $logo_front = $res['value'];
			  }
			  
			}

			if($stripe_option==1){
			  $stripe_key= $publishable_key;
			}else{
			  $stripe_key= $live_publishable_key;
			}

			if(!empty($logo_front)){
			  $web_log=base_url().$logo_front;
			}else{
			  $web_log=base_url().'assets/img/logo.png';
			}
		  
		  ?>
		  
		<input type="hidden" id="stripe_key" value="<?=$stripe_key;?>">
		<input type="hidden" id="logo_front" value="<?=$web_log;?>">
		<input type="hidden" id="token" value="<?=$this->session->userdata('chat_token');?>">


