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
	$('#stripe_wallet').on('click', function() {
		//var token_id = $("#token_id_wallet").val();
	    var appId = $("#appId_wallet").val();
	    var orderId = $("#orderId_wallet").val();
	    var returnUrl = $("#returnUrl_wallet").val();
	    var notifyUrl = $("#notifyUrl_wallet").val();
	    var orderCurrency = $("#orderCurrency_wallet").val();
	    var orderNote = $("#orderNote_wallet").val();
	    var customerName = $("#customerName_wallet").val();
	    var customerPhone = $("#customerPhone_wallet").val();
	    var customerEmail = $("#customerEmail_wallet").val();
		var orderAmount=$("#orderAmount").val();
		if(orderAmount =='' || orderAmount < 1){
			swal({
				title: "Empty amount",
				text: "Wallet field was empty please fill it...",
				icon: "error",
				button: "okay",
				closeOnEsc: false,
				closeOnClickOutside: false
			});
			$("#orderAmount").select();
			return false;
		}else{
			$.ajax({
		      url : base_url+"user_wallet_submit",
		      type : 'get',
		      data : {'appId':appId,'orderId':orderId,'orderAmount':orderAmount,'returnUrl':returnUrl,
		      'notifyUrl':notifyUrl,'orderCurrency':orderCurrency,'orderNote':orderNote,'customerName':customerName,
		      'customerPhone':customerPhone,'customerEmail':customerEmail,
		      },
		      success: function(data){
		        var jsonData = JSON.parse(data);
		        console.log(jsonData);
		        //$("#id_token_wallet").val(token_id);
		        $("#app_id_wallet").val(appId);
		        $("#order_id_wallet").val(orderId);
		        $("#order_amount_wallet").val(orderAmount);
		        $("#id_returnUrl_wallet").val(returnUrl);
		        $("#id_notifyUrl_wallet").val(notifyUrl);
		        $("#id_orderCurrency_wallet").val(orderCurrency);
		        $("#id_orderNote_wallet").val(orderNote);
		        $("#id_customerName_wallet").val(customerName);
		        $("#id_customerEmail_wallet").val(customerEmail);
		        $("#id_customerPhone_wallet").val(customerPhone);
		        $("#id_signature_wallet").val(jsonData);
		        $("#redirect_userForm").submit();
		      },
		      error:function(data){
		        console.log(data);
		      }
		    });
		}
});
});

function add_wallet_value(input){
  $("#orderAmount").val(input);
}   
})(jQuery);