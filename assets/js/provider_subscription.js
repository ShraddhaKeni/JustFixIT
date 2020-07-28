(function($) {
	"use strict";
	
	var base_url=$('#base_url').val();
	var BASE_URL=$('#base_url').val();
	var csrf_token=$('#csrf_token').val();
	var csrfName=$('#csrfName').val();
	var csrfHash=$('#csrfHash').val();

	var stripe_key=$("#stripe_key").val();
	var web_logo=$("#logo_front").val();
	$( document ).ready(function() {
		$('#my_stripe_payyment').hide();
		$('.callStripe').on('click',function(){
			var id = $(this).attr('data-id');
			var amount = $(this).attr('data-amount');
			$("#order_amount_sub_"+id).val(amount);
			$('.myModal_'+id).modal('show');
			$(".provider_sub_"+id).on('click',function(){
				var planid = $("#planId_"+id).val();
				var secretKey = $("#secretKey_sub_"+id).val();
			    var appId = $("#appid_sub_"+id).val();
			    var orderId = $("#order_sub_"+id).val();
			    var orderAmount = $("#order_amount_sub_"+id).val();
			    var returnUrl = $("#returnUrl_sub_"+id).val();
			    var notifyUrl = $("#notifyUrl_sub_"+id).val();
			    var orderCurrency = $("#orderCurrency_sub_"+id).val();
			    var orderNote = $("#orderNote_sub_"+id).val();
			    var customerName = $("#customerName_sub_"+id).val();
			    var customerPhone = $("#customerPhone_sub_"+id).val();
			    var customerEmail = $("#customerEmail_sub_"+id).val();
			    $.ajax({
			      url : base_url+"provider_subscription_submit",
			      type : 'get',
			      data : {'secretKey':secretKey,'appId':appId,'orderId':orderId,'orderAmount':orderAmount,'returnUrl':returnUrl,
			      'notifyUrl':notifyUrl,'orderCurrency':orderCurrency,'orderNote':orderNote,'customerName':customerName,
			      'customerPhone':customerPhone,'customerEmail':customerEmail,'planid':planid},
			      success: function(data){
			        var jsonData = JSON.parse(data);
			        console.log(jsonData);
			        $("#signature_sub_"+id).val(jsonData);
			        $("#redirectForm_sub_"+id).submit();
			      },
			      error:function(data){
			        console.log(data);
			      }
			    });
			  });
			}); 


			
			$(".provider_sub").on('click',function(){
				var id = $(this).attr('data-id');
				var amount = $(this).attr('data-amount');
				$("#order_amount_sub_"+id).val(amount);
				var planid = $("#planId_"+id).val();
				var secretKey = $("#secretKey_sub_"+id).val();
			    var appId = $("#appid_sub_"+id).val();
			    var orderId = $("#order_sub_"+id).val();
			    var orderAmount = $("#order_amount_sub_"+id).val();
			    var returnUrl = $("#returnUrl_sub_"+id).val();
			    var notifyUrl = $("#notifyUrl_sub_"+id).val();
			    var orderCurrency = $("#orderCurrency_sub_"+id).val();
			    var orderNote = $("#orderNote_sub_"+id).val();
			    var customerName = $("#customerName_sub_"+id).val();
			    var customerPhone = $("#customerPhone_sub_"+id).val();
			    var customerEmail = $("#customerEmail_sub_"+id).val();
			    $.ajax({
			      url : base_url+"provider_subscription_submit",
			      type : 'get',
			      data : {'secretKey':secretKey,'appId':appId,'orderId':orderId,'orderAmount':orderAmount,'returnUrl':returnUrl,
			      'notifyUrl':notifyUrl,'orderCurrency':orderCurrency,'orderNote':orderNote,'customerName':customerName,
			      'customerPhone':customerPhone,'customerEmail':customerEmail,'planid':planid},
			      success: function(data){
			        var jsonData = JSON.parse(data);
			        console.log(jsonData);
			        $("#signature_sub_"+id).val(jsonData);
			        $("#redirectForm_sub_"+id).submit();
			      },
			      error:function(data){
			        console.log(data);
			      }
			    });
			  });
		// $('.plan_notification').on('click',function(){
		// 	plan_notification();
		// }); 
	});

	$('.directweb').on('click',function(){
		var id = $(this).attr('data-id');
		var amount = $(this).attr('data-amount');
		$("#order_amount_sub_"+id).val(amount);
		var planid = $("#planId_"+id).val();
		var secretKey = $("#secretKey_sub_"+id).val();
	    var appId = $("#appid_sub_"+id).val();
	    var orderId = $("#order_sub_"+id).val();
	    var orderAmount = $("#order_amount_sub_"+id).val();
	    var returnUrl = $("#returnUrl_sub_"+id).val();
	    var notifyUrl = $("#notifyUrl_sub_"+id).val();
	    var orderCurrency = $("#orderCurrency_sub_"+id).val();
	    var orderNote = $("#orderNote_sub_"+id).val();
	    var customerName = $("#customerName_sub_"+id).val();
	    var customerPhone = $("#customerPhone_sub_"+id).val();
	    var customerEmail = $("#customerEmail_sub_"+id).val();
	    $.ajax({
	      url : base_url+"provider_subscription_submit",
	      type : 'get',
	      data : {'secretKey':secretKey,'appId':appId,'orderId':orderId,'orderAmount':orderAmount,'returnUrl':returnUrl,
	      'notifyUrl':notifyUrl,'orderCurrency':orderCurrency,'orderNote':orderNote,'customerName':customerName,
	      'customerPhone':customerPhone,'customerEmail':customerEmail,'planid':planid},
	      success: function(data){
	        var jsonData = JSON.parse(data);
	        console.log(jsonData);
	        $("#signature_sub_"+id).val(jsonData);
	        $("#redirectForm_sub_"+id).submit();
	      },
	      error:function(data){
	        console.log(data);
	      }
	    });
	});

	var final_gig_amount = 1;
	var sub_id = '';
	var striep_currency ='';

	var final_gig_amount1 = 1;
	var service_id = '';
	var provider_id = '';
	var booking_date = '';
	var booking_time = '';
	var service_location = '';
	var service_latitude = '';
	var service_longitude = '';
	var notes = '';

	function plan_notification(){

		swal({
			title: " Plan warning..!",
			text: "Already buyed high range so choose higher plan....!",
			icon: "error",
			button: "okay",
			closeOnEsc: false,
			closeOnClickOutside: false
		});
	}
	function callStripe(e) {
		sub_id = $(e).attr('data-id');
		//console.log('id here',sub_id);
		final_gig_amount = $(e).attr('data-amount');
		//console.log('amount Here',final_gig_amount);
		if(parseInt(final_gig_amount)==0.00) {
			//console.log('work here');
			free_subscription();
		}
		else {
			$('#my_stripe_payyment').click();
		}
	}

	function free_subscription() {
		$.ajax({
			url: base_url+'user/subscription/stripe_payments/',
			data: {sub_id:sub_id,final_gig_amount:final_gig_amount,csrf_token_name:csrf_token},
			type: 'POST',
			dataType: 'JSON',
			beforeSend: function(){
				$('.loading').show();
			},
			success: function(response){
				$('.loading').fadeOut("slow");
				window.location.href = base_url+'provider-subscription';
			},
			error: function(error){
				console.log(error);
			}
		});
	}



// 	var handler = StripeCheckout.configure({
// 		key: stripe_key,
// 		image: web_logo,
// 		locale: 'auto',
// 		token: function(token,args) {
// 		// You can access the token ID with `token.id`.
// 		$('#access_token').val(token.id);
// 		var tokenid = token.id;
// 		$.ajax({
// 			url: base_url+'user/subscription/stripe_payment/',
// 			data: {sub_id:sub_id,final_gig_amount:final_gig_amount,tokenid:tokenid,det:token,csrf_token_name:csrf_token},
// 			type: 'POST',
// 			dataType: 'JSON',
// 			success: function(response){
// 				window.location.href = base_url+'provider-subscription';
// 			},
// 			error: function(error){
// 				console.log(error);
// 			}
// 		});
// 	}
// });
	$('#my_stripe_payyment').on('click', function(e) {
	final_gig_amount = (final_gig_amount * 100); //  dollar to cent
	striep_currency = 'USD';	
	// Open Checkout with further options:
	handler.open({
		name: base_url,
		description: 'Subscribe',
		amount: final_gig_amount,
		currency:striep_currency
	});
	e.preventDefault();
});



	function callStripe_booking(e) {
		service_id = $(e).attr('data-id');
		provider_id = $(e).attr('data-provider');
		final_gig_amount1 = $(e).attr('data-amount');
		booking_date = $("#booking_date").val();
		booking_time = $("#from_time").val();
		service_location = $("#service_location").val();
		service_latitude = $("#service_latitude").val();
		service_longitude = $("#service_longitude").val();
		notes = $("#notes").val();

		if(parseInt(final_gig_amount1)==0) {
			alert('Service amount cannot be empty');
		}
		else {
			var booking_date1 = $("#booking_date").val();
			var booking_time1 = $("#from_time").val();
			var service_location1 = $("#service_location").val();

			if(booking_date1 == '') {
				$('.error_date').show();
				return false;
			}
			else if(booking_time1 == '' || booking_time == null) {
				$('.error_time').show();
				return false;
			}
			else if(service_location1 ==  '') {
				$('.error_date').hide();
				$('.error_loc').show();
				return false;
			}
			$('#stripe_booking').click();
		}
	}

	$("#getSelectplan").on('click',function(){
		alert('hello');
	});

	

})(jQuery);