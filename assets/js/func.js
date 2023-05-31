(function($)
{
    
   // var BASE_URL=$('#base_url').val();
    $( document ).ready(function()
    {
        $("#generic").on('change',function(){
            var generic_id = $('#generic').val();
            var base_url=$('#base_url').val();   //#base_url same as id in view
            if(generic_id != ''){
                var url = base_url + 'welcome/get_category';
                $.ajax({
                    url : url,
                    method : 'POST', 
                    data:{'gen_id':generic_id},
                success : function(data)
                {
                    //$('#category').html(data1);
                    alert(data);
                },
                error : function(data){
                    alert(data);
                }

            });
        }
    });
        
    });
})(jQuery);