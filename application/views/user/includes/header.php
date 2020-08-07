<!DOCTYPE html>
<html lang="en">
<?php
    $query = $this->db->query("select * from system_settings WHERE status = 1");
    $result = $query->result_array();
    $this->website_name = '';
    $this->website_logo_front ='assets/img/logo.png';
     $fav=base_url().'assets/img/favicon.png';
    if(!empty($result))
    {
    foreach($result as $data){
    if($data['key'] == 'website_name'){
    $this->website_name = $data['value'];
    }
        if($data['key'] == 'favicon'){
             $favicon = $data['value'];
    }
    if($data['key'] == 'logo_front'){
         $this->website_logo_front =  $data['value'];
    }
    }
    }
    if(!empty($favicon))
    {
		$fav = base_url().'uploads/logo/'.$favicon;
    }


    $lang = (!empty($this->session->userdata('lang')))?$this->session->userdata('lang'):'en';
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>AXZORA | One-stop destination for expert local services</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="AXZORA is Goa's best, One-stop destination for expert local services like Beauty, Repair, Cleaning, Grooming, Painting, Spa & More Services by Expert Professionals in Goa. Get dozens of trusted professionals near you to take care of all your home and beauty needs.">
	<meta name="keywords" content="Beauty, Repair, Cleaning, Grooming, Painting, Car Serices, Salon at Home ">
	<meta name="author" content="Axzora Private Limited">
	<!-- SEO Related -->
	    <meta name="robots" content="index, follow" />
        <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
        <meta name="bingbot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
        <link rel="canonical" href="http://www.axzora.com" />

        <meta property="og:locale" content="en_US" />
            <meta property="og:type" content="website" />
            <meta property="og:title" content="Beauty, Repair, Cleaning, Grooming, Painting, Car Serices, Salon at Home" />
            <meta property="og:description" content="AXZORA is Goa's best, One-stop destination for expert local services like Beauty, Repair, Cleaning, Grooming, Painting, Spa & More Services by Expert Professionals in Goa. Get dozens of trusted professionals near you to take care of all your home and beauty needs." />
            <meta property="og:url" content="http://www.axzora.com/" />
            <meta property="og:site_name" content="Axzora" />
            <meta property="article:publisher" content="https://www.facebook.com/axzora/" />
            <meta property="article:modified_time" content="2020-06-16T04:30:08+00:00" />
            <meta property="og:image" content="http://axzora.com/uploads/logo/1593695521_logo.png" />
            <meta name="twitter:card" content="summary_large_image" />
            <meta name="twitter:creator" content="@axzora" />
            <meta name="twitter:site" content="@axzora" />

<!-- Google Analytics -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-174907248-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-174907248-1');
</script>


    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $fav;?>">
	
	<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/datatables/datatables.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/animate.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/cropper.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/avatar.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/owlcarousel/owl.carousel.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/owlcarousel/owl.theme.default.min.css">

	<?php if($module=='home' || $module=='services'){ ?>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/jquery-ui/jquery-ui.min.css">
	<?php } ?>

	<?php if($module=='service'){ ?>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tagsinput.css">
	<?php } ?>    

	<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/toaster/toastr.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
	<?php if($this->uri->segment(1)=="book-service"){ ?>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/jquery-ui/jquery-ui.min.css">
		<?php }?>
	
	 <script src="<?php echo $base_url; ?>assets/js/jquery-3.5.0.min.js"></script>
	<script src="https://checkout.stripe.com/checkout.js"></script>
	<script src="https://js.stripe.com/v3/"></script>
</head>



