
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="admin_csrf" />
<input type="hidden" id="base_url" value="<?php echo $base_url; ?>">
</div>
<script src="<?php echo $base_url; ?>assets/js/jquery-3.5.0.min.js"></script>
<script src="<?php echo $base_url; ?>assets/js/popper.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo $base_url; ?>assets/js/moment.min.js"></script>
<script src="<?php echo $base_url; ?>assets/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/owlcarousel/owl.carousel.min.js"></script>

<!-- Slimscroll JS -->
<script src="<?php echo $base_url; ?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<?php $page = $this->uri->segment(1); ?>
<script src="<?php echo $base_url; ?>assets/js/bootstrapValidator.min.js"></script>

<!-- Datatables JS -->
<script src="<?php echo $base_url; ?>assets/plugins/datatables/datatables.min.js"></script>

<!-- Jvector map JS -->
<script src="<?php echo $base_url; ?>assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js"></script>
<script src="<?php echo $base_url; ?>assets/plugins/jvectormap/jquery-jvectormap-world-mill.js"></script>

<script src="<?php echo $base_url; ?>assets/js/bootstrap-notify.min.js"></script>

<!-- Select2 JS -->
<script src="<?php echo $base_url; ?>assets/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/sweetalert.min.js"></script>

<script  src="<?php echo $base_url; ?>assets/js/admin.js"></script>

<input type="hidden" id="page" value="<?php echo  $this->uri->segment(1);?>">
<input type="hidden" id="provider_list_url" value="<?php echo site_url('provider_list')?>">
<input type="hidden" id="requests_list_url" value="<?php echo site_url('request_list')?>">
<input type="hidden" id="user_list_url" value="<?php echo site_url('users_list')?>">


<?php if($page == 'admin-profile'){ ?>
	<script src="<?php echo $base_url; ?>assets/js/cropper_profile.js"></script>
	<script src="<?php echo $base_url; ?>assets/js/cropper.min.js"></script>
<?php } ?>


<script src="<?php echo $base_url; ?>assets/js/admin_functions.js"></script>

<!--External js Start-->
<?php if($this->uri->segment(1)=="reject-payment"){ ?>
	<script src="<?php echo base_url();?>assets/js/edit_reject_booking_view.js"></script>
<?php }?>
<?php if($this->uri->segment(2)=="emailsettings"){ ?>
	<script src="<?php echo base_url();?>assets/js/admin_emailsettings.js"></script>
<?php }?>
<?php if($this->uri->segment(2)=="stripe_payment_gateway"){ ?>
	<script src="<?php echo base_url();?>assets/js/stripe_payment_gateway.js"></script>
<?php }?>
<!--External js end-->

</body>
</html>