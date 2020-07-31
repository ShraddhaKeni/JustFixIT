(function($) {
  "use strict";
	var base_url=$('#base_url').val();
  var BASE_URL=$('#base_url').val();
  var csrf_token=$('#csrf_token').val();
  var csrfName=$('#csrfName').val();
  var csrfHash=$('#csrfHash').val();
  var modules=$('#modules_page').val();
   $( document ).ready(function() {
    $('.get_subcategory').on('click',function(){
      get_subcategory();
    });

    $('.paginate').on('click',function(){
      var page = $(this).attr('data-val');
      if(page==null){
      var startVal = 1;
      var lastVal = 12;
      }else{
          $('.active').removeClass('active');
          $('.count_'+page).addClass('active'); 
          
      var lastVal = page*12;
      var startVal = lastVal-12;
    }
      showAllSubCategory(startVal,lastVal);
    });
    

  });

  function showAllSubCategory(startVal,lastVal){
   $('#sub_dataList').empty();
   $.ajax({
      url:base_url+'home/showAllSubcategoryJson',
      type : 'post',
      data:{'start':startVal,'end':lastVal,csrf_token_name:csrf_token},
      success:function(data){
        var obj = JSON.parse(data);
        console.log(obj);
        var divData = '';
        for (var i = 0; i < obj.length; i++) {
             var text = obj[i];
             divData+= '<div class="col-lg-4 col-md-6">'+
                  '<div class="service-widget">'+
                    '<div class="service-img">'+
                      '<a href="'+base_url+'services/'+text['id'] +'">'+
                        '<img class="img-fluid serv-img" alt="Service Image" src="'+ text['subcategory_image'] +'">'+
                      '</a>'+
                    '</div>'+
                    '<div class="service-content">'+
                      '<h3 class="title">'+
                        '<a href="'+base_url+'services/'+ text['id'] +'"> '+ text['subcategory_name'] +' </a></h3></div></div></div>';
              }


       $('#subcategory_count').html(obj.length);
       $('#sub_dataList').html(divData);


      },
      error:function(data){
        console.log(data);
      }

    });
  } 

function get_subcategory() { 
   var price_range=$('#price_range').val();
   var min_price = $('#min_price').html();
   var max_price = $('#max_price').html();
   var sort_by=$('#sort_by').val();
   var common_search=$('#common_search').val();
   var categories=$('#categories').val();
   var service_latitude=$('#service_latitude').val();
   var service_longitude=$('#service_longitude').val();
   var user_address=$('#service_location').val();
   var subcategories = $("#subcategories").val();
   if(user_address==''){
    var service_latitude='';
   var service_longitude='';
   }
   $('#sub_dataList').html('<div class="page-loading">'+
  '<div class="preloader-inner">'+
    '<div class="preloader-square-swapping">'+
      '<div class="cssload-square-part cssload-square-green"></div>'+
      '<div class="cssload-square-part cssload-square-pink"></div>'+
      '<div class="cssload-square-blend"></div>'+
    '</div>'+
  '</div>'+
  
'</div>');
$('#sub_dataList').empty();
$('.pagination').empty();
   // $.post(base_url+'home/showService/'+subcategories,{subcategories:subcategories,min_price:min_price,max_price:max_price,sort_by:sort_by,common_search:common_search,categories:categories,service_latitude:service_latitude,service_longitude:service_longitude,csrf_token_name:csrf_token,user_address:user_address},function(data){
   //   var obj=jQuery.parseJSON(data);
   //   console.log(obj);
   //   var divData = '';
   //   for (var i = 0; i < obj.length; i++) {
   //           var text = obj[i];
   //           var splite = text['service_title'].split(' ');
   //           var mainurl = splite[0]+'-'+splite[1];
   //           var txturl = mainurl.toLowerCase();
   //           divData+= '<div class="col-lg-4 col-md-6">'+
   //                '<div class="service-widget">'+
   //                  '<div class="service-img">'+
   //                    '<a href="'+base_url+'service-preview/'+txturl+'?sid='+text['sid'] +'">'+
   //                      '<img class="img-fluid serv-img" alt="Service Image" src="'+ text['thumb_image'] +'">'+
   //                    '</a>'+
   //                  '</div>'+
   //                  '<div class="service-content">'+
   //                    '<h3 class="title">'+
   //                      '<a href="'+base_url+'service-preview/'+txturl+'?sid='+ text['sid'] +'"> '+ text['service_title'] +' </a></h3></div></div></div>';
   //            }

$.post(base_url+'home/subcategoryById/'+subcategories,{subcategories:subcategories,min_price:min_price,max_price:max_price,sort_by:sort_by,common_search:common_search,categories:categories,service_latitude:service_latitude,service_longitude:service_longitude,csrf_token_name:csrf_token,user_address:user_address},function(data){
     var obj=jQuery.parseJSON(data);
     console.log(obj);
     var divData = '';
     for (var i = 0; i < obj.length; i++) {
             var text = obj[i];
             divData+= '<div class="col-lg-4 col-md-6">'+
                  '<div class="service-widget">'+
                    '<div class="service-img">'+
                      '<a href="'+base_url+'services/'+text['id'] +'">'+
                        '<img class="img-fluid serv-img" alt="Service Image" src="'+ text['subcategory_image'] +'">'+
                      '</a>'+
                    '</div>'+
                    '<div class="service-content">'+
                      '<h3 class="title">'+
                        '<a href="'+base_url+'services/'+ text['id'] +'"> '+ text['subcategory_name'] +' </a></h3></div></div></div>';
              }


       $('#subcategory_count').html(obj.length);
       $('#sub_dataList').html(divData);
   })

}



// jquery ui range - price range

var $priceFrom = $('.price-ranges .from'),
$priceTo = $('.price-ranges .to');
var min_price = $('#min_price').html();
var max_price = $('#max_price').html();

$(".price-range").slider({
	range: true,
	min: 1,
	max: 100000,
	values: [min_price, max_price],
	slide: function (event, ui) {
		$priceFrom.text(ui.values[0]);
		$priceTo.text(ui.values[1]);
	}
});
})(jQuery);