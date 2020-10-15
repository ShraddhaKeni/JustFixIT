(function($) {

	"use strict";
	
	var csrf_token=$('#admin_csrf').val();
	var base_url=$('#base_url').val();
	var page=$('#page').val();
	var provider_list_url=$('#provider_list_url').val();
	var requests_list_url=$('#requests_list_url').val();
	var user_list_url=$('#user_list_url').val();
	
	$( document ).ready(function() {
		$('#img_upload_error').hide();
		$('#img_upload_errors').hide();
		setTimeout(function(){ $('#flash_success_message').hide(); }, 5000);
		setTimeout(function(){ $('#flash_succ_message').hide(); }, 5000);
		setTimeout(function(){ $('#flash_error_message').hide(); }, 5000);
		$('.change_Status_Service').on('click',function(){
			var id=$(this).attr('data-id');
      		change_Status_Service(id);
    	});

    	$('.delete_review_comment').on('click',function(){
			var id=$(this).attr('data-id');
      		delete_review_comment(id);
    	});

    	$('.change_Status_rating').on('click',function(){
			var id=$(this).attr('data-id');
      		change_Status_rating(id);
    	});

    	$('.delete_service_provider').on('click',function(){
			var id=$(this).attr('data-id');
      		delete_service_provider(id);
    	});

    	$('.update_language').on('click',function(){
			var lang_key=$(this).attr('data-lang-key');
			var lang=$(this).attr('data-lang');
			var page=$(this).attr('data-page');
	      	update_language(lang_key,lang,page);
    	});

	    $('#reject_payment_submit').on('submit',function(){
	     	var result=reject_payment_submit();
	     	return result;
	    });

    	getSubcategorySelect();
    
    	function getSubcategorySelect(){
    		var id = $("#categoryId").val();
    		var subid = $("#subcategorySelect").val();
    		var csrf_token=$('#csrf_token').val();
     		$.ajax({
    			url : base_url+"/getSubcategory/"+id,
    			type : "GET",
    			data : '',
    			success : function(data){
    				var jsonData = JSON.parse(data);
    				var count = jsonData.length;
    				var subcategoryList = '';
    				for(var i=0; i<count; i++){
    					if(subid==jsonData[i]['id']){
    						subcategoryList+='<option value="'+jsonData[i]['id']+'">'+jsonData[i]['subcategory_name']+'</option>';
    					}
    					$('#subcategoryId').html(subcategoryList);
    				}
    			},
    				error : function(data){
    				console.log(data);	
    			}
    		});
		} 

   		$("#registration_submit").on('click',function(){
   			//e.preventDefault();
	   		var categoryId = $('#categoryId').val();
	   		var subcategoryId = $('#subcategoryId').val();
	   		var userName = $('#userName').val();
	   		var userEmail = $('#userEmail').val();
	   		var countryCode = $('#countryCode').val();
	   		var userMobile = $('#userMobile').val();
	   		if((categoryId=='') && (subcategoryId=='') && (userName=='') && (userEmail=='') && (countryCode=='') && (userMobile='')) {
	   			$("#registration_submit").attr('disabled',true);
	   			//$("#add_providerId").submit();
	   		}else{
	   			$("#registration_submit").attr('disabled',false);
	   		}
		});	

    	$("#categoryId").on('change',function(){
    		var id = $(this).val();
    		var csrf_token=$('#csrf_token').val();
    	
	   		$.ajax({
    			url : base_url+"/getSubcategory/"+id,
    			type : "GET",
    			data : '',
    			success : function(data){
    				var jsonData = JSON.parse(data);
    				var count = jsonData.length;
    				var subcategoryList = '';
    				for(var i=0; i<count; i++){
    					subcategoryList+='<option value="'+jsonData[i]['id']+'">'+jsonData[i]['subcategory_name']+'</option>';
    					$('#subcategoryId').html(subcategoryList);
    				}
    			},
    			error : function(data){
    				console.log(data);	
    			}
    		});
		});
   
    	$("#userEmail").on('keyup',function(){
    		var email = $(this).val();
    		$.ajax({
    			url: base_url + 'user/login/email_chk',
    			type:'post',
    			data:{'userEmail':email},
    			success : function(data){
    				var dataSplit = data.split(':');
    				var result = dataSplit[1];
    				var results = result.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-')
    				if(results=='false'){
    					$("#email_error").text('this email is already exists');
    					$("#registration_submit").attr('disabled',true);
    				}
    				else{
    					$("#registration_submit").attr('disabled',false);
    					$("#email_error").text('');
    				}
    			},
    			error : function(data){
    				console.log(data);
    			}
    		});
    	});

    	$("#userMobile").on('keyup',function(){
    		var mobile = $(this).val();
    		var countryCode = $("#countryCode").val();
    		$.ajax({
    			url: base_url + 'user/login/mobileCheck',
    			type:'post',
    			data:{'userMobile':mobile,'countryCode':countryCode},
    			success : function(data){
    				var dataSplit = data.split(':');
    				var result = dataSplit[1];
    				var results = result.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-')
    				if(results=='true'){
    					$("#mobile_error").text('this mobile is already exists');
    					$("#registration_submit").attr('disabled',true);
    				}else{
    					$("#registration_submit").attr('disabled',false);
    					$("#mobile_error").text('');
    				}
    			},
    			error : function(data){
    				console.log(data);
    			}
    		});
    	});

    	$("#add_discount_per").on('keyup',function(){
    		var percent = $(this).val();
    		var subscription_amount = $("#add_subscription_amount").val();
    		if((percent==0)|| (percent=='')){
    			var actual_amount = subscription_amount;
    		}
    		else{
    			var pers = (percent / 100) * subscription_amount;
    			var actual_amount = subscription_amount-pers;
    		}
	    	$("#add_amount").val(actual_amount);
    	});

    	var path = window.location.href;
		var suffix = path.match(/\d+/); 
		var curedit = base_url+"edit-subscription/"+suffix[0];
		var curadd = base_url+"add-subscription";	
    	if((path == curedit) || (path == curadd)){
    		var percent = $('#discount_per').val();
	    	var subscription_amount = $("#subscription_amount").val();
	    	if((percent==0)|| (percent==''))  {
	    		var actual_amount = subscription_amount;
	    	}
	    	else{
	    		var pers = (percent / 100) * subscription_amount;
	    		var actual_amount = subscription_amount-pers;
	    	}
			$("#amount").val(actual_amount);
    	}

    	$("#discount_per").on('keyup',function(){
    		var percent = $(this).val();
    		var subscription_amount = $("#subscription_amount").val();
    		if((percent==0)|| (percent=='')){
    			var actual_amount = subscription_amount;
    		}
    		else{
    			var pers = (percent / 100) * subscription_amount;
    			var actual_amount = subscription_amount-pers;
    		}
	    	$("#amount").val(actual_amount);
    	});
	});

	$(document).on('click', '.verified_change', function(e)
	{ 
    	try{
        	var id=$(this).attr('data-id');
			var stat= $('#status_'+id).prop('checked');
			if(stat==true) {
				var status=1;
			}
			else{
				var status=0;
			}
			$.post(base_url+'admin/service/change_verified',{is_verified:status,provider_id:id,csrf_token_name:csrf_token},function(data){
		})
    }
    catch(err){alert(err);}
    });
	var account_holder_name = '';
	var account_number = '';
	var account_iban = '';
	var bank_name = '';
	var bank_address = '';
	var sort_code = '';
	var routing_number = '';
	var account_ifsc = '';
	var transaction_id = '';
	var booking_id = '';

	$('#admin_payment').bootstrapValidator({
		fields: {
			transaction_id: {
				validators: {
					notEmpty: {
						message: 'Please enter transaction ID'
					}
				}
			}
		}
	}).on('success.form.bv', function(e){
		e.preventDefault();
		var	account_holder_name = $("#account_holder_name").val();
		var	account_number = $("#account_number").val();
		var	account_iban = $("#account_iban").val();
		var	bank_name = $("#bank_name").val();
		var	bank_address = $("#bank_address").val();
		var	sort_code = $("#sort_code").val();
		var	routing_number = $("#routing_number").val();
		var	account_ifsc = $("#account_ifsc").val();
		var	transaction_id = $("#transaction_id").val();
		var	booking_id = $("#booking_id").val();
		$.ajax({
			url: base_url+'admin/payments/add_payment/',
			data: {csrf_token_name:csrf_token,account_holder_name:account_holder_name,account_number:account_number,account_iban:account_iban,bank_name:bank_name,bank_address:bank_address,sort_code:sort_code,routing_number:routing_number,account_ifsc:account_ifsc,transaction_id:transaction_id,booking_id:booking_id},
			type: 'POST',
			dataType: 'JSON',
			success: function(response){
				window.location.href = base_url+'payment_list';
			},
			error: function(error){
				console.log(error);
			}
		});
	});

	var timeout = 3000; // in miliseconds (3*1000)
	$('#flash_succ_message').delay(timeout).fadeOut(500);
	$('#flash_error_message').delay(timeout).fadeOut(500);

	if($('#world-map-markers').length > 0 ){
		var map_list=[];
		$.ajax({
			url: base_url+'map_lists',
			data: {'tets':'test','csrf_token_name':csrf_token},
			type: 'POST',
			dataType: 'JSON',
			success: function(response){
				map_list=response;
				$('#world-map-markers').vectorMap({
					map: 'world_mill',
					scaleColors: ['#C8EEFF', '#0071A4'],
					normalizeFunction: 'polynomial',
					hoverOpacity: 1,
					hoverColor: false,
					markerStyle: {
						initial: {
							fill: '#ff0080',
							stroke: '#ff0080'
						}
					},
					regionStyle: {
						initial: {
							fill: '#ccc'
						},
						selected: {
							fill: '#ccc'
						}
					},
					backgroundColor: '#ffffff',
					markers:map_list
				});
			}
		})
	}

	if(page == 'service-providers' ||page == 'stripe_payment_gateway' || page == 'service-list' ||page == 'users'||page == 'provider_list' ||page == 'provider-details')
	{
		var providers_table = $('#providers_table').on('init.dt', function () {
			$(document).on('click','.delete_provider',function() {
    			var dataId = $(this).attr('data-id');
    			if(confirm("Are You Sure you want to delete this provider?"))
    			{
    				$.ajax({
    					url : base_url+"delete-service-providers/"+dataId,
    					type : "post",
    					data : {'csrf_token_name':csrf_token},
    					success : function (data){
    						if(data==1){
    							swal({
                                	title: "Provider Delete",
                                 	text: "Provider SuccessFully Delete",
                                 	icon: "success",
                                 	button: "okay",
                               	 	closeOnEsc: false,
								 	closeOnClickOutside: false
                           		}).then(function(){
                     				window.location.reload();
								});
    						}
    					},
    					error : function (data){
    						swal({
                            	title: "Provider Delete",
                            	text: "Something happen provider not delete",
                            	icon: "success",
                            	button: "okay",
                            	closeOnEsc: false,
								closeOnClickOutside: false
                        	}).then(function(){
                    			window.location.reload();
							});
    					}
    				});
    			}
    			return false;
    		});
		}).DataTable({
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.
			"ordering": false,
			"ajax": {
				"url":provider_list_url,
				"type": "POST",
				"data": {csrf_token_name:csrf_token},
			},
			"columnDefs":[{
            	"targets": [ 5 ], //first column / numbering column
            	"orderable": false, //set not orderable
        	},]
    	});
	}

	if(page == 'service-requests'){
		requests_table = $('#requests_table').DataTable({
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.
			"ajax":{
				"url":requests_list_url,
				"type": "POST",
				"data": function ( data ) {}
			},
			"columnDefs": [{
				"targets": [ 7 ], //first column / numbering column
				"orderable": false, //set not orderable
			},],
		});
	}

	if(page == 'users'){
		var users_table = $('#users_table').DataTable({
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.
			"ordering": false,
			"ajax": {
				"url":user_list_url,
				"type": "POST",
				"data":{csrf_token_name:csrf_token}
			},
			"columnDefs":[{
				"targets": [ 0 ], //first column / numbering column
				"orderable": false, //set not orderable
			},]
		});
	}

	function reject_payment_submit(){
		var type=true;
		var r = confirm("Are you Sure About This process");
		if (r == true) {
			type=true;
		}else{
			type=false;
		}
		return type;
	}

	var successClick = function(){
		$.notify({
			title: '<strong>Success</strong>',
			message: "<br>"+success_message,
			icon: 'glyphicon glyphicon-ok',
			target: '_blank'
		},
		{
			element: 'body',
			type: "success",
			showProgressbar: false,
			placement: {
				from: "top",
				align: "right"
			},
			offset: 20,
			spacing: 10,
			z_index: 1031,
			delay: 3300,
			timer: 1000,
			mouse_over: null,
			animate: {
				enter: 'animated fadeInDown',
				exit: 'animated fadeOutRight'
			},
			onShow: null,
			onShown: null,
			onClose: null,
			onClosed: null,
			icon_type: 'class',
		});
	}

	var infoClick = function(){
		$.notify({
			title: '<strong>Info</strong>',
			message: "<br>Lorem ipsum Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum.",
			icon: 'glyphicon glyphicon-info-sign',
		},
		{
			element: 'body',
			position: null,
			type: "info",
			allow_dismiss: true,
			newest_on_top: false,
			showProgressbar: false,
			placement: {
				from: "top",
				align: "right"
			},
			offset: 20,
			spacing: 10,
			z_index: 1031,
			delay: 3300,
			timer: 1000,
			mouse_over: null,
			animate: {
				enter: 'animated bounceInDown',
				exit: 'animated bounceOutUp'
			},
			onShow: null,
			onShown: null,
			onClose: null,
			onClosed: null,
			icon_type: 'class',
		});
	}

	var warningClick = function(){
		$.notify({
			title: '<strong>Warning</strong>',
			message: "<br>Lorem ipsum Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum.",
			icon: 'glyphicon glyphicon-warning-sign',
		},
		{
			element: 'body',
			position: null,
			type: "warning",
			allow_dismiss: true,
			newest_on_top: false,
			showProgressbar: false,
			placement: {
				from: "top",
				align: "right"
			},
			offset: 20,
			spacing: 10,
			z_index: 1031,
			delay: 3300,
			timer: 1000,
			mouse_over: null,
			animate: {
				enter: 'animated bounceIn',
				exit: 'animated bounceOut'
			},
			onShow: null,
			onShown: null,
			onClose: null,
			onClosed: null,
			icon_type: 'class',
		});
	}

	var dangerClick = function(){
		$.notify({
			title: '<strong>Danger</strong>',
			message: "<br>"+error_message,
			icon: 'glyphicon glyphicon-remove-sign',
		},
		{
			element: 'body',
			position: null,
			type: "danger",
			allow_dismiss: true,
			newest_on_top: false,
			showProgressbar: false,
			placement: {
				from: "top",
				align: "right"
			},
			offset: 20,
			spacing: 10,
			z_index: 1031,
			delay: 3300,
			timer: 1000,
			mouse_over: null,
			animate: {
				enter: 'animated flipInY',
				exit: 'animated flipOutX'
			},
			onShow: null,
			onShown: null,
			onClose: null,
			onClosed: null,
			icon_type: 'class',
		});
	}

	var primaryClick = function(){
		$.notify({
			title: '<strong>Primary</strong>',
			message: "<br>Lorem ipsum Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum.",
			icon: 'glyphicon glyphicon-ruble',
		},
		{
			element: 'body',
			position: null,
			type: "success",
			allow_dismiss: true,
			newest_on_top: false,
			showProgressbar: false,
			placement: {
				from: "top",
				align: "right"
			},
			offset: 20,
			spacing: 10,
			z_index: 1031,
			delay: 3300,
			timer: 1000,
			mouse_over: null,
			animate: {
				enter: 'animated lightSpeedIn',
				exit: 'animated lightSpeedOut'
			},
			onShow: null,
			onShown: null,
			onClose: null,
			onClosed: null,
			icon_type: 'class',
		});
	}

	var defaultClick = function(){
		$.notify({
			title: '<strong>Default</strong>',
			message: "<br>Lorem ipsum Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum.",
			icon: 'glyphicon glyphicon-ok-circle',
		},
		{
			element: 'body',
			position: null,
			type: "warning",
			allow_dismiss: true,
			newest_on_top: false,
			showProgressbar: false,
			placement: {
				from: "top",
				align: "right"
			},
			offset: 20,
			spacing: 10,
			z_index: 1031,
			delay: 3300,
			timer: 1000,
			mouse_over: null,
			animate: {
				enter: 'animated rollIn',
				exit: 'animated rollOut'
			},
			onShow: null,
			onShown: null,
			onClose: null,
			onClosed: null,
			icon_type: 'class',
		});
	}

	var linkClick = function(){
		$.notify({
			title: '<strong>Link</strong>',
			message: "<br>Lorem ipsum Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum.",
			icon: 'glyphicon glyphicon-search',
		},
		{
			element: 'body',
			position: null,
			type: "danger",
			allow_dismiss: true,
			newest_on_top: false,
			showProgressbar: false,
			placement: {
				from: "top",
				align: "right"
			},
			offset: 20,
			spacing: 10,
			z_index: 1031,
			delay: 3300,
			timer: 1000,
			mouse_over: null,
			animate: {
				enter: 'animated zoomInDown',
				exit: 'animated zoomOutUp'
			},
			onShow: null,
			onShown: null,
			onClose: null,
			onClosed: null,
			icon_type: 'class',
		});
	}

	function change_Status_rating(id) { 
		var stat= $('#status_'+id).prop('checked');
		if(stat==true) {
			var status=1;
		}
		else {
			var status=0;
		}
		$.post(base_url+'admin/dashboard/change_rating',{id:id,status:status,csrf_token_name:csrf_token},function(data){
		 	swal({
         		title: "Rating",
         		text: "Rating Status Change SuccessFully....!",
         		icon: "success",
         		button: "okay",
         		closeOnEsc: false,
         		closeOnClickOutside: false
       		});
		});
	}

	function change_Status_subcategory(id) {
		var stat= $('#status_'+id).prop('checked');
		if(stat==true) {
			var status=1;
		}
		else {
			var status=2;
		}
		$.post(base_url+'admin/dashboard/change_subcategory',{id:id,status:status},function(data){
			console.log(data);
		});
	}

	function change_Status_category(id) {
		var stat= $('#status_'+id).prop('checked');
		if(stat==true) {
			var status=1;
		}
		else{
			var status=2;
		}
		$.post(base_url+'admin/dashboard/change_category',{id:id,status:status},function(data){
			console.log(data);
		});
	}

	function change_Status_user(id) {
		var stat= $('#status_'+id).prop('checked');
		if(stat==true) {
			var status=1;
		}
		else{
			var status=2;
		}
		$.post(base_url+'admin/dashboard/change_Status',{id:id,status:status},function(data){
			console.log(data);
		});
	}

	function change_Status_users(id) {
		var stat= $('#status_'+id).prop('checked');
		if(stat==true) {
			var status=1;
		}
		else{
			var status=2;
		}
		$.post(base_url+'admin/dashboard/change_Statuss',{id:id,status:status},function(data){
			console.log(data);
		});
	}

	function delete_review_comment(id) {
		if(confirm("Are you sure you want to delete this Comment...!?")){
			$.post(base_url+'admin/Ratingstype/delete_comment',{id:id,csrf_token_name:csrf_token},function(result){
				if(result) {
					window.location.reload();
				}
			});
		}   
	}  

	function delete_service_provider(id) {
		if(confirm("Are you sure you want to delete this provider?")){
			$.post(base_url+'admin/service/delete_provider',{id:id},function(result){
				if(result) {
					window.location.reload();
				}
			});
		}   
	}

	function delete_service(id) {
		$('#delete_service').modal('show');
		$('#service_id').val(id);
	}

	if(page == 'service-providers' ||page == 'stripe_payment_gateway' || page == 'service-list' ||page == 'users'||page == 'provider_list' ||page == 'provider-details')
	{ 
		/*service list Active And De Active*/
		function change_Status_Service(service_id){
			var stat= $('#status_'+service_id).prop('checked');
			if(stat==true) {
				var status=1;
			}
			else{
				var status=0;
			}
			$.post(base_url+'admin/service/change_Status_service_list',{id:service_id,status:status,csrf_token_name:csrf_token},function(data){
				if(data==1){
					alert("Sorry That Service Was Booked Some One\n So You Can't Inactive The Service");
					$(".check_status").attr('checked', $(this).attr('checked'));
					$('#status_'+service_id).attr('data-on',"Active");
					$('.check_status').addClass('toggle-on');
				}
				console.log(data);
				if(data=="success"){
				 	swal({
         				title: "Service",
         				text: "Service Status Change SuccessFully....!",
         				icon: "success",
         				button: "okay",
         				closeOnEsc: false,
         				closeOnClickOutside: false
       				});
				}
			});
		}

		function change_Status(id) {
			var stat= $('#status_'+id).prop('checked');
			if(stat==true) {
				var status=1;
			}
			else{
				var status=0;
			}
			$.post(base_url+'admin/service/change_Status',{id:id,status:status},function(data){
			});
		}

		function change_Status_provider(id) {
			var stat= $('#status_'+id).prop('checked');
			if(stat==true) {
				var status=1;
			}
			else{
				var status=2;
			}
			$.post(base_url+'admin/service/change_Status',{id:id,status:status},function(data){
			});
		}
	}
})(jQuery);