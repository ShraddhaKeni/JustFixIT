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
					
				<div class="row">
					
					<div class="col-xl-6 col-lg-6 col-md-6">
						<div class="card">
							<div class="card-body">
								<h4 class="card-title">Wallet</h4>

								<div class="wallet-details">
									<span>Wallet Balance</span>
									<h3><?=$wallet['currency'].''.$wallet['wallet_amt'];?></h3>
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
									if(!empty($value["fee_amt"]) && $value["fee_amt"] >1){
										$txt_amt=number_format($value["fee_amt"]/100,2);
									}else{
										$txt_amt=0;
									}
									$total_cr+=$value['credit_wallet'];
									$total_dr+=abs($value['debit_wallet']);
								}
							}
									?>
									<div class="d-flex justify-content-between my-4">
										<div>
											<p class="mb-1">Total Credit</p>
											<h4><?=$wallet["currency"].''.number_format($total_cr,2);?></h4>
										</div>
										<div>
											<p class="mb-1">Total Debit</p>
											<h4><?=$wallet["currency"].''.number_format($total_dr,2);?></h4>
										</div>
									</div>
									
									<div class="wallet-progress-chart">
										<div class="d-flex justify-content-between">
											<span><?=$wallet['currency'].''.abs($wallet['total_debit']);?></span>
											<?php
											if(isset($wallet['total_credit'])&&!empty($wallet['total_credit'])){
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
								<h4 class="card-title">Add Wallet</h4>
								<form action="#">
									<div class="form-group">
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<label class="input-group-text display-5"><?=$wallet['currency'];?></label>
											</div>
											<input type="text"  maxlength="4" class="form-control isNumber" name="orderAmount" id="orderAmount" placeholder="00.00">
										</div>
									</div>
								</form>
								<div class="text-center mb-3">
									<h5 class="mb-3">OR</h5>
									
									
									<ul class="list-inline mb-0">
										<li class="line-inline-item mb-0 d-inline-block">
											<a href="javascript:;" data-amount="50" class="updatebtn add_wallet_value"><?=$wallet['currency'];?>50</a>
										</li>
										<li class="line-inline-item mb-0 d-inline-block">
											<a href="javascript:;" data-amount="100" class="updatebtn add_wallet_value"><?=$wallet['currency'];?>100</a>
										</li>
										<li class="line-inline-item mb-0 d-inline-block">
											<a href="javascript:;" data-amount="150" class="updatebtn add_wallet_value"><?=$wallet['currency'];?>150</a>
										</li>
									</ul>
								</div>
								<a href="javascript:void(0);"id="stripe_wallet" class="btn btn-primary btn-block withdraw-btn">Add to Wallet</a>


									<input type="hidden" name="orderCurrency" id='orderCurrency_wallet' value="INR"/>
									<input type="hidden" name="orderNote" id='orderNote_wallet' value="test"/>
									<input type="hidden" name="customerName" id='customerName_wallet' value="<?php echo $this->session->userdata('name'); ?>"/>
									<input type="hidden" name="customerEmail" id='customerEmail_wallet' value="<?php echo $this->session->userdata('email'); ?>"/>
									<input type="hidden" name="customerPhone" id='customerPhone_wallet' value="<?php echo $this->session->userdata('mobileno'); ?>"/>
    								  <input type="hidden" name="appId" id='appId_wallet' value="22541e2b76162c7d85ddf06af14522"/>
									    <input type="hidden" name="orderId" id='orderId_wallet' class="form-control isNumber" placeholder="value" value="<?php echo rand(100000,999999);  ?>" />
									    <input type="hidden" name="returnUrl" id='returnUrl_wallet' value="<?php echo base_url().'user_wallet_submit'; ?>"/>
									    <input type="hidden" name="notifyUrl" id='notifyUrl_wallet' value="<?php echo base_url().'user_wallet_submit'; ?>"/>
									    <hr>
								
								<form id="redirect_userForm" method="post" action="https://test.cashfree.com/billpay/checkout/post/submit">
									<input type="hidden" name="orderCurrency" id='id_orderCurrency_wallet' value="INR"/>
									<input type="hidden" name="orderNote" id='id_orderNote_wallet' value="test"/>
									<input type="hidden" name="customerName" id='id_customerName_wallet' value=""/>
									<input type="hidden" name="customerEmail" id='id_customerEmail_wallet' value=""/>
									<input type="hidden" name="customerPhone" id='id_customerPhone_wallet' value=""/>
								<input type="hidden" id='app_id_wallet' name="appId" value=""/>
								<input type="hidden" id='order_id_wallet' name="orderId" placeholder="value" value=""/>
								<input type="hidden" id='order_amount_wallet' name="orderAmount" placeholder="amount" value=""/>
								<input type="hidden" id='id_returnUrl_wallet' name="returnUrl" value=""/>
								<input type="hidden" id='id_notifyUrl_wallet' name="notifyUrl" value=""/>
								<input type="hidden" id="id_signature_wallet" name="signature" value=""/>
								</form>
							</div>
						</div>
					</div>
				</div>
		
				<h4 class="mb-4">Wallet Transactions</h4>
				<div class="card transaction-table mb-0">
					<div class="card-body">
						<div class="table-responsive">
							<?php if(!empty($wallet_history)){?>
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
										<th>Txt amt</th>
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
									if(!empty($value["fee_amt"]) && $value["fee_amt"] >1){
										$txt_amt=number_format($value["fee_amt"]/100,2);
									}else{
										$txt_amt=0;
									}
									$total_cr+=$value['credit_wallet'];
									$total_dr+=abs($value['debit_wallet']);
									echo '<tr>
									<td>'.($key+1).'</td>
									<td>'.date("d M Y",strtotime($value["created_at"])).'</td>
									<td>'.$wallet["currency"].''.$value["current_wallet"].'</td>
									<td>'.$wallet["currency"].''.$value["credit_wallet"].'</td>
									<td>'.$wallet["currency"].''.$value["debit_wallet"].'</td>
									<td>'.$wallet["currency"].''.$txt_amt.'</td>
									<td>'.$wallet["currency"].''.$value["avail_wallet"].'</td>
									<td><lable>'.$value["reason"].'</lable></td>
									<td><span class="badge bg-'.$color.'-light">'.$message.'</span></td> 
									</tr>';
									}

									}else{
										echo '<tr> <td colspan="8"> <div class="text-center text-muted">No data found</div></td> </tr>'; 
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


	<footer class="footer">
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
		<input type="hidden" id="tokens" value="<?=$this->session->userdata('chat_token');?>">
		</footer>

		
<button id="stripe_booking" >Purchase book</button>


