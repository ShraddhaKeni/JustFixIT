(function($) {
	"use strict";
    var base_url=$('#base_url').val();
  var BASE_URL=$('#base_url').val();
  var csrf_token=$('#csrf_token').val();
  var csrfName=$('#csrfName').val();
  var csrfHash=$('#csrfHash').val();
 $( document ).ready(function() {
   $('.withdraw_wallet_value').on('click',function(){
    var id=$(this).attr('data-amount');
      withdraw_wallet_value(id);
    });
    $('.isNumber').on('keypress',function(e){ 
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
               return false;
    }
    });
 });
var stripe_key=$("#stripe_key").val();
  // Create a Stripe client.
var stripe = Stripe(stripe_key);

// Create an instance of Elements.
var elements = stripe.elements();
$('#card_form_div').hide();
// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

function withdraw_wallet_value(input){
  $("#wallet_withdraw_amt").val(input);
}  

// Create an instance of the card Element.
var card = elements.create('card', {style: style, hidePostalCode : true, });
// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');
// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
  $('#card-errors').css('color','red');
});


// var elements1 = stripe.elements();
// $('#add_wallet_div').hide();
// // Custom styling can be passed to options when creating an Element.
// // (Note that this demo uses a wider set of styles than the guide below.)
// var style = {
//   base: {
//     color: '#32325d',
//     fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
//     fontSmoothing: 'antialiased',
//     fontSize: '16px',
//     '::placeholder': {
//       color: '#aab7c4'
//     }
//   },
//   invalid: {
//     color: '#fa755a',
//     iconColor: '#fa755a'
//   }
// };

// function add_wallet_amt(input){
//   $("#add_wallet_amt").val(input);
// }  
// // Create an instance of the card Element.
// var card1 = elements1.create('card', {style: style, hidePostalCode : true, });
// // Add an instance of the card Element into the `card-element` <div>.
// card1.mount('#card-element1');
// // Handle real-time validation errors from the card Element.
// card1.addEventListener('change', function(event) {
//   var displayError1 = document.getElementById('card-errors1');
//   if (event.error) {
//     displayError1.textContent = event.error.message;
//   } else {
//     displayError1.textContent = '';
//   }
//   $('#card-errors1').css('color','red');
// });

// Handle form submission.
var sub_btn = document.getElementById('pay_btn');

sub_btn.addEventListener('click', function(event) {

  stripe.createToken(card,{'currency': 'USD'}).then(function(result) {
    if (result.error) {
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      var token=$('#token').val();
 $('#load_div').html('<img src="'+base_url+'assets/img/loader.gif" alt="" />');
           var tokens=token;
           var stripe_amt=$("#wallet_withdraw_amt").val();
           
           var tokenid = result.token.id;
           var data="Token="+tokens+"&amount="+stripe_amt+"&tokenid="+tokenid+"&csrf_token_name="+csrf_token;
           $.ajax({
           url: base_url+'api/withdraw-provider',
           data:data,
           type: 'POST',
           dataType: 'JSON',
           success: function(response){
            
           console.log(response);
           if(response.response.response_code==200 || response.response.response_code=='200'){
                        swal({
                                 title: "Wallet Amount Transferred...",
                                 text: "Wallet amount was Credit to your card releated by bank ...!",
                                 icon: "success",
                                 button: "okay",
                                               closeOnEsc: false,
              closeOnClickOutside: false
                           }).then(function(){
                            $("#load_div").hide();
                     window.location.reload();

                           });
           }else{
                      swal({
                                 title: "Wallet Amount Not Succeed...",
                                 text: response.response.response_message,
                                 icon: "error",
                                 button: "okay",
                                               closeOnEsc: false,
              closeOnClickOutside: false
                           }).then(function(){
                            $("#load_div").hide();
                     window.location.reload();

                           });
           }
           },
           error: function(error){
           console.log(error);
                          swal({
                                 title: "Wallet Amount Not Succeed...",
                                 text: "Wallet amount was not transferred ...!",
                                 icon: "error",
                                 button: "okay",
                                               closeOnEsc: false,
              closeOnClickOutside: false
                           }).then(function(){
                            $("#load_div").hide();
           window.location.reload();
                            
                           });

           }
           });
    }
  });
});
	$('#stripe_withdraw_wallet').on('click', function(e) {
        var stripe_amt=$("#wallet_withdraw_amt").val();
          if(stripe_amt =='' || stripe_amt < 1){

                    swal({
                           title: "Empty amount",
                           text: "Wallet field was empty please fill it...",
                           icon: "error",
                           button: "okay",
                                         closeOnEsc: false,
              closeOnClickOutside: false
                       });

                    $("#wallet_withdraw_amt").select();
                    return false;
                  }

          var token=$('#token').val();
        var tokens=token;

        var data="token="+tokens;

        $.ajax({
               url: base_url+'api/get-wallet',
               data:{token:tokens,csrf_token_name:csrf_token},
               type: 'POST',
               dataType: 'JSON',
               success: function(response){
                console.log(response.data.wallet_info);
                var wallet_amt=response.data.wallet_info.wallet_amt;
                   if(Number(wallet_amt) < Number(stripe_amt)){
                          swal({
                                 title: "Exceeding Wallet amount",
                                 text: "Enter the amount less than wallet amount...!",
                                 icon: "error",
                                 button: "okay",
                                               closeOnEsc: false,
              closeOnClickOutside: false
                           });
                           $("#wallet_withdraw_amt").select();
                           return false;

                    }else{
                   var stripe_amts=$("#wallet_withdraw_amt").val();

                      $("#card_form_div").show();
                      $("#check_wallet_div").hide();
                      $("#remember_withdraw_wallet").text(stripe_amts);
                    }
                 }
             })

   });

  // $("#stripe_add_wallet").on('click',function(){
  //   var add_amt = $("#add_wallet_amt").val();
  //   if((add_amt==0) || (add_amt=='')){
  //     swal({
  //          title: "Empty amount",
  //          text: "Wallet field was empty please anter amount",
  //          icon: "error",
  //          button: "okay",
  //          closeOnEsc: false,
  //          closeOnClickOutside: false
  //      });
  //   }else{
  //    $("#add_wallet_div").show();
  //    $("#remember_add_wallet").text(add_amt);  
  //   }
  // });
  // $('#add_btn').on('click',function(){
  //   var id=$('#userLoginId').val();
  //   var amt = $("#add_wallet_amt").val();
  //   var chatToken = $("#chatToken").val();
  //   $.ajax({
  //     url : base_url+"api/add-provider-wallet",
  //     type : 'post',
  //     data : {'id':id,'type':'1','amt':amt,'token':chatToken},
  //     success: function(data){
  //       console.log(data);
  //     },
  //     error:function(data){
  //       console.log(data);
  //     }
  //   });
  // });

	$('#cancel_card_btn').on('click', function() {
		$("#card_form_div").hide();
		$("#check_wallet_div").show();
   });
  
})(jQuery);