<?php
    $stripe_option='1';
    $publishable_key='';
    $secret_key='';
    $live_secret_key='';
    $live_publishable_key='';
    $logo_front='';
    foreach ($system_info as $res) {
      if($res['key'] == 'stripe_option'){
      $stripe_option = $res['value'];
      } 
      if($res['key'] == 'publishable_key'){
      $publishable_key = $res['value'];
      }
      if($res['key'] == 'secret_key'){
      $secret_key = $res['value'];
      } 
       if($res['key'] == 'live_publishable_key'){
      $live_publishable_key = $res['value'];
      }
      if($res['key'] == 'live_secret_key'){
      $live_secret_key = $res['value'];
      } 

      if($res['key'] == 'logo_front'){
      $logo_front = $res['value'];
      }
    }

    if($stripe_option==1){
      $stripe_key= $publishable_key;
      $secretKey = $secret_key;
    }else{
      $stripe_key= $live_publishable_key;
      $secretKey = $live_secret_key;
    }

    if(!empty($logo_front)){
      $web_log=base_url().$logo_front;
    }else{
      $web_log=base_url().'assets/img/logo.png';
    }
    

$subscription = $this
    ->home
    ->get_subscription();
$my_subscribe = $this
    ->home
    ->get_my_subscription();
$my_subscribe_list = $this
    ->home
    ->get_my_subscription_list();
if (!empty($my_subscribe))
{
    $subscription_name = $this
        ->db
        ->where('id', $my_subscribe['subscription_id'])->get('subscription_fee')
        ->row_array();
}
else
{
    $subscription_name['subscription_name'] = '';
}
?><div class="content"><div class="container"><div class="row"><?php $this
    ->load
    ->view('user/home/provider_sidemenu'); ?><div class="col-xl-9 col-md-8"><?php
if (!empty($my_subscribe['expiry_date_time']))
{
    if (date('Y-m-d', strtotime($my_subscribe['expiry_date_time'])) < date('Y-m-d'))
    { ?><div class="alert alert-warning"><div class="pricing-alert flex-wrap flex-md-nowrap"><div class="alert-desc"><p class="mb-0">Your subscription has expired on <?php echo date('d-m-Y', strtotime($my_subscribe['expiry_date_time'])); ?>.</p></div><div class="alert-btn mt-3 mb-1 my-md-0"><a href="javascript:void(0);" class="btn btn-sm btn-warning">Renew</a></div></div></div><?php
    }
}
?><?php
if (!empty($my_subscribe['expiry_date_time']))
{
    $before_days = date('Y-m-d', strtotime('-10 days', strtotime($my_subscribe['expiry_date_time'])));
    $start = strtotime(date('Y-m-d'));
    $end = strtotime($my_subscribe['expiry_date_time']);
    $days = ceil(abs($end - $start) / 86400);

    if (date('Y-m-d') >= $before_days && date('Y-m-d') <= $my_subscribe['expiry_date_time'])
    { ?><div class="alert alert-info"><?php if (!empty($days))
        { ?> 
					Your subscription expires in <?=$days; ?> Days.
					<?php
        }
        else
        { ?>
					Your subscription expires Today.
					<?php
        } ?></div><?php
    }
} ?><div class="row pricing-box"><?php foreach ($subscription as $list)
{      
    if($suscriptionLog){ 

    if ((date('Y-m-d') > date('Y-m-d', strtotime($suscriptionLog[0]->expiry_date_time))) && ($suscriptionLog[0]->free_service == 'yes'))
    {
        if ($list['discount'] == 100){}
        else{
            if (!empty($my_subscribe['subscription_id']))
            {
                if ($list['id'] == $my_subscribe['subscription_id'])
                {
                    if (date('Y-m-d', strtotime($my_subscribe['expiry_date_time'])) >= date('Y-m-d'))
                    {
                        $class = "pricing-selected";
                    }
                }
                else
                {
                    $class = '';
                }
            }else{
                $class = '';
            }if (!isset($class)){
                $class = '';
            }?>
            <div class="col-xl-4 col-md-6 <?php echo $class; ?>">
						<div class="card">
							<div class="card-body">
                                <div class="pricing-header"><h2><?php echo $list['subscription_name'] ?></h2><p>Monthly Price</p>
                                    </div><?php 
                            if ($list['discount'] == 0){ ?>
                                <div class="pricing-card-price">
                                    <h5 class="heading4 price">₹<?php echo $list['fee'] ?></h5><p>Duration: <span><?php echo $list['duration'] ?> Months</span></p>
                                </div>
                            <?php }else{ ?>
                <div class="pricing-card-price">
                    <h5 class="heading4 price"><del>₹<?php echo $list['actual_amount'] ?></del></h5>
                    <p>₹<?php echo $list['discount']; ?> % Off </p><h3 class="heading2 price">₹<?php echo $list['fee'] ?></h3><p>Duration: <span><?php echo $list['duration'] ?> Months</span></p></div>
            <?php } ?><ul class="pricing-options"><li><i class="far fa-check-circle"></i> One listing submission</li><li><i class="far fa-check-circle"></i><?=$list['duration'] * 30; ?> days expiration</li></ul>
            <?php if (empty($subscription_name['subscription_name'])) { ?>
                <a href="javascript:void(0);" class="btn btn-primary btn-block callStripe" data-id="<?php echo $list['id']; ?>" data-amount="<?php echo $list['fee']; ?>" >Select Plan</a>
					<?php } if (!empty($my_subscribe['subscription_id'])) {
                if ($list['id'] == $my_subscribe['subscription_id'] && date('Y-m-d', strtotime($my_subscribe['expiry_date_time'])) > date('Y-m-d')){ ?>
                    <a href="javascript:void(0);" class="btn btn-primary btn-block">Subscribed</a>
                <?php } else {
                    $subscription_fee = $this
                        ->db
                        ->where('id', $my_subscribe['subscription_id'])->get('subscription_fee')
                        ->row_array();
                    if (!empty($subscription_fee)){
                        if ((int)$list['fee'] > (int)$subscription_fee['fee']){
                            if (date('Y-m-d') > date('Y-m-d', strtotime($my_subscribe['expiry_date_time']))){ 
                                if($wallet['wallet_amt'] >= $list['fee']){ ?>
                            			<a href="javascript:void(0);" class="btn btn-primary btn-block callStripe" data-id="<?php echo $list['id']; ?>" data-amount="<?php echo $list['fee'] ?>" data-amount="<?php echo $list['fee']; ?>" data-target="#myModal" data-toggle="modal">Select Plans</a>

                            <?php }else{ ?>
                                <a href="javascript:void(0);" class="btn btn-primary btn-block directweb" data-id="<?php echo $list['id']; ?>" data-amount="<?php echo $list['fee'] ?>" data-amount="<?php echo $list['fee']; ?>" data-target="#myModal" data-toggle="modal">Select Pland</a>
                            <?php } ?>            
                                        <!-- The Modal -->
                                  <div class="modal fade  myModal_<?php echo $list['id']; ?>">
                                    <div class="modal-dialog modal-sm">
                                      <div class="modal-content">
                                      <!-- Modal Header -->
                                        <div class="modal-header">
                                          <h4 class="modal-title">Pay ₹<?php echo $list['fee'] ?></h4>
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <p>
                                          <a href='<?php echo base_url().'provider-wallet' ?>' class="btn btn-primary btn-block">Wallet</a></p>
                                          <center>OR</center>
                                           <p>
                                            <input type="hidden" name="secretKey" id="secretKey_sub_<?php echo $list['id']; ?>" value="<?php echo $secretKey; ?>"/>
                                            <input type="hidden" name="planId" id="planId_<?php echo $list['id']; ?>" value="<?php echo $list['id']; ?>"/>
                                <form id="redirectForm_sub_<?php echo $list['id']; ?>" method="post" action="https://test.cashfree.com/billpay/checkout/post/submit">
                                    <input type="hidden" name="orderCurrency" id='orderCurrency_sub_<?php echo $list['id']; ?>' value="INR"/>
                                    <input type="hidden" name="orderNote" id='orderNote_sub_<?php echo $list['id']; ?>' value="test"/>
                                    <input type="hidden" name="customerName" id='customerName_sub_<?php echo $list['id']; ?>' value="<?php echo $this->session->userdata('name'); ?>"/>
                                    <input type="hidden" name="customerEmail" id='customerEmail_sub_<?php echo $list['id']; ?>' value="<?php echo $this->session->userdata('email'); ?>"/>
                                    <input type="hidden" name="customerPhone" id='customerPhone_sub_<?php echo $list['id']; ?>' value="<?php echo $this->session->userdata('mobileno'); ?>"/>
                                    <input type="hidden" id="appid_sub_<?php echo $list['id']; ?>" name="appId" value="<?php echo $stripe_key;  ?>"/>
                                    <input type="hidden" id='order_sub_<?php echo $list['id']; ?>' name="orderId" placeholder="value" value="<?php echo rand(100000,999999);  ?>"/>
                                    <input type="hidden" id='order_amount_sub_<?php echo $list['id']; ?>' name="orderAmount" placeholder="amount" value="<?php echo $list['fee']; ?>"/>
                                    <input type="hidden" id='returnUrl_sub_<?php echo $list['id']; ?>' name="returnUrl" value="<?php echo base_url().'provider_subscription_submit'; ?>"/>
                                    <input type="hidden" id='notifyUrl_sub_<?php echo $list['id']; ?>' name="notifyUrl" value="<?php echo base_url().'provider_subscription_submit'; ?>"/>
                                    <input type="hidden" id="signature_sub_<?php echo $list['id']; ?>" name="signature" value=""/>
                                    <input type="button" value='Card/UPI' class="btn btn-primary btn-block provider_sub_<?php echo $list['id']; ?>">
                                 </form>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                        <?php } else { ?><?php }
                        } else {
                            if (date('Y-m-d', strtotime($my_subscribe['expiry_date_time'])) >= date('Y-m-d'))
                            { ?>
								  	<a data-toggle="tooltip" title="Your Not Choose This Plan ..!" href="javascript:void(0);"  class="btn btn-primary btn-block plan_notification" >Select Plan</a><?php
                            }
                            else
                            { ?>
								  		<a href="javascript:void(0);" class="btn btn-primary btn-block callStripe" data-id="<?php echo $list['id']; ?>" data-amount="<?php echo $list['fee']; ?>" >Select Plan</a>
								  	<?php
                            }
                        }
                    }
?><?php
                }
            }
?></div>
								</div>
								</div>
<?php
        }
    }
    else
    {
        if (!empty($my_subscribe['subscription_id']))
        {
            if ($list['id'] == $my_subscribe['subscription_id'])
            {
                if (date('Y-m-d', strtotime($my_subscribe['expiry_date_time'])) >= date('Y-m-d'))
                {
                    $class = "pricing-selected";
                }
            }
            else
            {
                $class = '';
            }
        }
        else
        {
            $class = '';
        }
        if (!isset($class))
        {
            $class = '';
        }
?><div class="col-xl-4 col-md-6 <?php echo $class; ?>">
						<div class="card">
							<div class="card-body"><div class="pricing-header"><h2><?php echo $list['subscription_name'] ?></h2><p>Monthly Price</p></div>
							<?php if ($list['discount'] == 0)
        { ?>
								<div class="pricing-card-price"><h5 class="heading4 price">₹<?php echo $list['fee'] ?></h5><p>Duration: <span><?php echo $list['duration'] ?> Months</span></p></div><?php
        }
        else
        { ?>
									<div class="pricing-card-price">
										<h5 class="heading4 price"><del>₹<?php echo $list['actual_amount'] ?></del></h5>
										<p>₹<?php echo $list['discount']; ?> % Off </p>
										<h3 class="heading2 price">₹<?php echo $list['fee'] ?></h3>
										<p>Duration: <span><?php echo $list['duration'] ?> Months</span></p>
										</div><?php
        } ?>
										<ul class="pricing-options">
											<li><i class="far fa-check-circle"></i> One listing submission</li>
											<li><i class="far fa-check-circle"></i><?=$list['duration'] * 30; ?> days expiration</li>
											</ul>
											<?php if (empty($subscription_name['subscription_name']))
        { ?>
												<a href="javascript:void(0);" class="btn btn-primary btn-block callStripe" data-id="<?php echo $list['id']; ?>" data-amount="<?php echo $list['fee']; ?>" >Select Plan</a><?php
        }
        if (!empty($my_subscribe['subscription_id']))
        {
            if ($list['id'] == $my_subscribe['subscription_id'] && date('Y-m-d', strtotime($my_subscribe['expiry_date_time'])) > date('Y-m-d'))
            { ?>
									<a href="javascript:void(0);" class="btn btn-primary btn-block">Subscribed</a><?php
            }
            else
            {
                $subscription_fee = $this
                    ->db
                    ->where('id', $my_subscribe['subscription_id'])->get('subscription_fee')
                    ->row_array();
                if (!empty($subscription_fee))
                {
                    if ((int)$list['fee'] > (int)$subscription_fee['fee'])
                    {
                        if (date('Y-m-d') > date('Y-m-d', strtotime($my_subscribe['expiry_date_time'])))
                        { ?>
										<a href="javascript:void(0);" class="btn btn-primary btn-block callStripe" data-id="<?php echo $list['id']; ?>" data-amount="<?php echo $list['fee']; ?>" >Select Plan</a><?php
                        }
                        else
                        { ?><?php
                        }
                    }
                    else
                    {
                        if (date('Y-m-d', strtotime($my_subscribe['expiry_date_time'])) >= date('Y-m-d'))
                        {
?>
								  <a data-toggle="tooltip" title="Your Not Choose This Plan ..!" href="javascript:void(0);"  class="btn btn-primary btn-block plan_notification" >Select Plan</a>
								<?php
                        }
                        else
                        { ?><a href="javascript:void(0);" class="btn btn-primary btn-block callStripe" data-id="<?php echo $list['id']; ?>" data-amount="<?php echo $list['fee']; ?>" >Select Plan</a><?php
                        }
                    }
                }
?><?php
            }
        }
?></div>
								</div>
								</div><?php
    }} else{ 

if (!empty($my_subscribe['subscription_id']))
        {
            if ($list['id'] == $my_subscribe['subscription_id'])
            {
                if (date('Y-m-d', strtotime($my_subscribe['expiry_date_time'])) >= date('Y-m-d'))
                {
                    $class = "pricing-selected";
                }
            }
            else
            {
                $class = '';
            }
        }
        else
        {
            $class = '';
        }
        if (!isset($class))
        {
            $class = '';
        }
?><div class="col-xl-4 col-md-6 <?php echo $class; ?>">
                        <div class="card">
                            <div class="card-body"><div class="pricing-header"><h2><?php echo $list['subscription_name'] ?></h2><p>Monthly Price</p></div>
                            <?php if ($list['discount'] == 0)
        { ?>
                                <div class="pricing-card-price"><h5 class="heading4 price">₹<?php echo $list['fee'] ?></h5><p>Duration: <span><?php echo $list['duration'] ?> Months</span></p></div><?php
        }
        else
        { ?>
                                    <div class="pricing-card-price">
                                        <h5 class="heading4 price"><del>₹<?php echo $list['actual_amount'] ?></del></h5>
                                        <p>₹<?php echo $list['discount']; ?> % Off </p>
                                        <h3 class="heading2 price">₹<?php echo $list['fee'] ?></h3>
                                        <p>Duration: <span><?php echo $list['duration'] ?> Months</span></p>
                                        </div><?php
        } ?>
                                        <ul class="pricing-options">
                                            <li><i class="far fa-check-circle"></i> One listing submission</li>
                                            <li><i class="far fa-check-circle"></i><?=$list['duration'] * 30; ?> days expiration</li>
                                            </ul>
                                            <?php if (empty($subscription_name['subscription_name']))
        { ?>
                                                <a href="javascript:void(0);" class="btn btn-primary btn-block callStripe" data-id="<?php echo $list['id']; ?>" data-amount="<?php echo $list['fee']; ?>" >Select Plan</a><?php
        }
        if (!empty($my_subscribe['subscription_id']))
        {
            if ($list['id'] == $my_subscribe['subscription_id'] && date('Y-m-d', strtotime($my_subscribe['expiry_date_time'])) > date('Y-m-d'))
            { ?>
                                    <a href="javascript:void(0);" class="btn btn-primary btn-block">Subscribed</a><?php
            }
            else
            {
                $subscription_fee = $this
                    ->db
                    ->where('id', $my_subscribe['subscription_id'])->get('subscription_fee')
                    ->row_array();
                if (!empty($subscription_fee))
                {
                    if ((int)$list['fee'] > (int)$subscription_fee['fee'])
                    {
                        if (date('Y-m-d') > date('Y-m-d', strtotime($my_subscribe['expiry_date_time'])))
                        { ?>
                                        <a href="javascript:void(0);" class="btn btn-primary btn-block callStripe" data-id="<?php echo $list['id']; ?>" data-amount="<?php echo $list['fee']; ?>" >Select Plan</a><?php
                        }
                        else
                        { ?><?php
                        }
                    }
                    else
                    {
                        if (date('Y-m-d', strtotime($my_subscribe['expiry_date_time'])) >= date('Y-m-d'))
                        {
?>
                                  <a data-toggle="tooltip" title="Your Not Choose This Plan ..!" href="javascript:void(0);"  class="btn btn-primary btn-block plan_notification" >Select Plan</a>
                                <?php
                        }
                        else
                        { ?><a href="javascript:void(0);" class="btn btn-primary btn-block callStripe" data-id="<?php echo $list['id']; ?>" data-amount="<?php echo $list['fee']; ?>" >Select Plan</a><?php
                        }
                    }
                }
?><?php
            }
        }
?></div>
                                </div>
                                </div>






    <?php } }  ?>
								</div><?php if (!empty($my_subscribe))
{ ?>
									<div class="card"><div class="card-body"><div class="plan-det"><h6 class="title">Plan Details</h6><ul class="row"><li class="col-sm-4"><p><span class="text-muted">Started On</span><?php if (!empty($my_subscribe['subscription_date']))
    {
        echo date('d M Y', strtotime($my_subscribe['subscription_date']));
    } ?></p></li><li class="col-sm-4"><p><span class="text-muted">Price</span> $<?php if (!empty($subscription_name['fee']))
    {
        echo $subscription_name['fee'];
    }
?></p></li><li class="col-sm-4"><p><span class="text-muted">Expired On</span><?php
    if (!empty($my_subscribe['expiry_date_time']))
    {
        echo date('d M Y', strtotime($my_subscribe['expiry_date_time']));
    } ?></p></li></ul><h6 class="title">Last Payment</h6><ul class="row"><li class="col-sm-4"><p>Paid at <?php if (!empty($my_subscribe['expiry_date_time']))
    {
        echo date('d M Y', strtotime($my_subscribe['subscription_date']));
    } ?></p></li><li class="col-sm-4"><p><span class="amount">$<?php if (!empty($subscription_name['fee']))
    {
        echo $subscription_name['fee'];
    } ?></span><span class="badge bg-success-light">Paid</span></p></li></ul></div></div></div><h5 class="mb-4">Subscribed Details</h5><div class="card transaction-table mb-0"><div class="card-body"><div class="table-responsive"><table class="table table-center mb-0 no-footer"><thead><tr><th>Plan</th><th>Start Date</th><th>End Date</th><th>Amount</th><th>Status</th></tr></thead><tbody><?php foreach ($my_subscribe_list as $row)
    { ?><tr role="row"><td><?=$row['subscription_name']; ?></td><td><?=date('d-m-Y', strtotime($row['subscription_date'])); ?></td><td><?=date('d-m-Y', strtotime($row['expiry_date_time'])); ?></td><td><?=$row['fee']; ?></td><td><span class="badge bg-success-light">Paid</span></td></tr><?php
    } ?></tbody></table></div></div></div><?php
} ?></div></div></div></div>
<input type="hidden" id="stripe_key" value="<?=$stripe_key; ?>"><input type="hidden" id="logo_front" value="<?=$web_log; ?>"><button id="my_stripe_payyment">Purchase</button>
