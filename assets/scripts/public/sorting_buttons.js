$(function(){
	//AJAX POST REQUEST FOR /SEARCH FILTERS,ORDER_BY AND PAGINATION
	var base_url = config.base_url;
	         function getProducts(page,order_by){
                
            var data = {};
            data['filter_products'] = true;
            data['page'] = page;
            data['order_by'] = order_by;

            $('.filters input').each(function(){
                 if($(this).is(':checkbox')){
                    if($(this).is(':checked')){
                     data[$(this).attr('name')] = $(this).val();
                    }
                 } else {
                    data[$(this).attr('name')] = $(this).val();
                 }
            });

            $.ajax({
                method: "POST",
                url: base_url+"/index/ajaxproducts/"+page,
                data: data,
                success: function(data){
                    $('.product_list').html(data);
                }
            });
        }
	//ORDER PRODUCTS BY A SELECTED PROPERTY(PRICE/RATING...)
function order_products(order_element,order_by){
$(order_element).on('click',function(){
	$(this).siblings('a').removeClass('asc desc');
	if($(this).hasClass('asc')){
	 getProducts(0,order_by+'_asc');
	  $(this).removeClass('asc').addClass('desc');
	} else {
		 getProducts(0,order_by+'_desc');
	 $(this).removeClass('desc').addClass('asc');
	}
});
}

//LOAD AND ORDER PRODUCTS BY RATING ON PAGE LOAD
getProducts(0,'rating_desc');

//LOAD DATA WHEN ANY INPUT IN FILTERS CHANGES
$('.filters input').on('change input',function(){
	getProducts(0,'rating_desc');
});

//BIND EVENTS FOR ORDERING PRODUCTS TO PRICE AND RATING BUTTONS
order_products("#price_order","price");
order_products("#rating_order","rating");
});


