(function($) {
	"use strict";

	var base_url=$('#base_url').val();
	var BASE_URL=$('#base_url').val();
	var csrf_token=$('#csrf_token').val();
	var csrfName=$('#csrfName').val();
	var csrfHash=$('#csrfHash').val();

	var tokens=$('#tokens').val();
	var stripe_key=$("#stripe_key").val();
	var web_logo=$("#logo_front").val();
	
	var stripe_amt=1;
	var stripe_key=$("#stripe_key").val();
	var web_logo=$("#logo_front").val();
	var final_gig_amount=0;
	$( document ).ready(function() {
		$('#stripe_booking').hide();
		$('.add_wallet_value').on('click',function(){
			var id=$(this).attr('data-amount');
			add_wallet_value(id);
		}); 
		$('.isNumber').on('keypress',function(e){ 
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				return false;
			}
		});
	
	

	var user_handler = StripeCheckout.configure({
		key: stripe_key,
		image: web_logo,
		locale: 'auto',
		token: function(token,args) {
			var tokens=$('#tokens').val();
			var stripe_amt=$("#wallet_amt").val();
			var tokenid = token.id;
			var data="Token="+tokens+"&amount="+stripe_amt+"&tokenid="+tokenid;

			$.ajax({
				url: base_url+'api/add-user-wallet',
				data:data,
				type: 'POST',
				dataType: 'JSON',
				success: function(response){
					console.log(response);
					window.location.reload();
				},
				error: function(error){
					console.log(error);
				}
			});
		}
	});
	$('#stripe_wallet').on('click', function(e) {
		var stripe_amt=$("#wallet_amt").val();
		if(stripe_amt =='' || stripe_amt < 1){
			swal({
				title: "Empty amount",
				text: "Wallet field was empty please fill it...",
				icon: "error",
				button: "okay",
				closeOnEsc: false,
				closeOnClickOutside: false
			});
			$("#wallet_amt").select();
			return false;
		}

	final_gig_amount = (stripe_amt * 100); //  dollar to cent
	var striep_currency = 'USD';
	// Open Checkout with further options:
	user_handler.open({
		name: base_url,
		description: 'Wallet Recharge',
		amount: final_gig_amount,
		currency:striep_currency
	});
	e.preventDefault();
});
});

function add_wallet_value(input){
  $("#wallet_amt").val(input);
}   
})(jQuery);