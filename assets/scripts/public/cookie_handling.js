	$(function(){

		$(".row_share .quantity input[name='quantity']").val(1);
		price_total();
		//ADD A PRODUCT TO THE CART
		$(".to_cart").on('click',function(e){
			e.preventDefault();

		$product_id = $(this).children("input[name='id']").val();
		cart = Cookies.getJSON("cart");
		in_cart = false;
		quantity_cart = 0;
		$cart_badge = $("#cart_badge").text();
		// MANAGE QUANTITY OF A PRODUCT IN /PRODUCT/? PAGE
		detail_quantity = $(this).parents('.order_box').find("input[name='quantity']").val();
		input_quantity = detail_quantity > 0 ? detail_quantity : 1;
		input_quantity = parseInt(input_quantity);
		cart_total = parseInt($cart_badge)+parseInt(input_quantity);
		$("#cart_badge").text(cart_total);

		if(cart == null){
			var cart = [];
		} else { //CHECKS WHETHER A SELECTED PRODUCT IS ALREADY IN THE CART/COOKIES
			$.each(cart,function(index, product){
				if(product.id == $product_id){
				
					product.quantity += input_quantity;

					in_cart = true;
				}
				quantity_cart += product.quantity;
			});
		}

		if(!in_cart){
			new_product = {id: $product_id, quantity: input_quantity, order: cart.length};
			cart.push(new_product);
			quantity_cart += input_quantity;
		}
		Cookies.set('cart',cart, { expires: 7, domain: config.domain });
		Cookies.set('quantity_cart',parseInt(quantity_cart),{ expires: 7, domain: config.domain });

	});
	//REMOVE SELECTED PRODUCT FROM THE CART
	$(".remove-from-cart").on('click',function(){

		id = $(this).parent().siblings("input[name='id']").val();
		$(this).parents('.cart_row').fadeOut(300,function(){
			cart = Cookies.getJSON("cart");
			$.each(cart,function(index,product){
				if(product.id == id){
					quantity_cart = Cookies.getJSON("quantity_cart");
					quantity_cart -= product.quantity;
					$("#cart_badge").text(quantity_cart);
					Cookies.set('quantity_cart',quantity_cart,{ expires: 7, domain: config.domain });
					cart.splice(index,1);
					Cookies.set('cart',cart, { expires: 7, domain: config.domain });
					return false;
				}
			});
			$(this).remove();
			price_total();
		});
	});

	//SUM UP TOTAL PRICES OF INDIVIDUAL PRODUCTS
	$(document).on('focusin', 'input', function(){

		if($(this).is($("input[name='quantity']"))){
			$(this).data('cart_input', false);
			orig_items_num = $(this).val();
	    //CHECK IF NUMBER INPUT IS IN A CART OR PRODUCT/? PAGE
	    $price_in_product = $(this).parents('.row_share').siblings('.row_buy').find('.price p');

	    $price_in_cart = $(this).parent().siblings('.price');
	    if($price_in_cart.length > 0){
	    	total_price = parseFloat($price_in_cart.text().replace(/\,/g,''));
	    	$(this).data('cart_input', true);
	    	quantity_cart = Cookies.getJSON("quantity_cart");
	    	 $(this).data('quantity_cart', quantity_cart);
	    } else {
	    	total_price = parseFloat($price_in_product.text());
	    	$(this).data('cart_input', false);
	    }
	    
	    price_per_item = total_price / orig_items_num;
	    
	    $(this).data('per_item', price_per_item);
	    $(this).data('orig_items', orig_items_num);
	}
}).on('change','input', function(){
	if($(this).is($("input[name='quantity']"))){
		check_quantity($(this));
		//cart_input data is bool, depends on where the number input is changed
		cart_input = $(this).data('cart_input');
		price_per_item = $(this).data('per_item');
		items_num = parseInt($(this).val());
		orig_items = parseInt($(this).data('orig_items'));
		if(cart_input){
	//CHANGE THE BADGE NUMBER AND ALSO A TOTAL NUMBER OF ITEMS IN COOKIES

	quantity_cart = parseInt($(this).data('quantity_cart'));
	cur_items = quantity_cart - orig_items + items_num;
	$("#cart_badge").text(cur_items);

	Cookies.set('quantity_cart',cur_items,{ expires: 7, domain: config.domain });
	//CHANGE QUANTITY OF A SINGLE PRODUCT IN COOKIES
	id = $(this).parent().siblings("input[name='id']").val();
	cart = Cookies.getJSON("cart");
	$.each(cart,function(index,product){
		if(product.id == id){
			product.quantity = items_num;
			Cookies.set('cart',cart, { expires: 7, domain: config.domain });
			return false;
		}
	});

	//CHANGE TOTAL PRICE OF A SINGLE PRODUCT
	$(this).parent().siblings('.price').find('p').text((items_num*price_per_item).toFixed(2));
	    //CHANGE TOTAL PRICE
	    price_total();
	}
}
});

		//GET SUM OF ALL PRODUCT PRICES AND DISPLAY TOTAL PRICE
		function price_total(){
			total = 0;
			$(".cart_row .price p").each(function(index){
				total += parseFloat($(this).text().replace(/\,/g,''));
			});
			$("#price_total").text("Total " + total.toFixed(2) +"$");
		}

		//CHECK QUANTITY INPUT
		function check_quantity(quantity_input){
			quantity = quantity_input.val();
			if(isNaN(quantity) || quantity < 1 || quantity > 100 ||
				Math.floor(quantity) != quantity)
			{
				quantity_input.val(1);}
			}

		});