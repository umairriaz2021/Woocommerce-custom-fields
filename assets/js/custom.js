//Custom JS
jQuery(document).ready(function($){
// jQuery(document).on('change','input[name=quantity]',function(){
//     localStorage.setItem('qty',parseInt($(this).val()));
// 	//console.log($(this).val());
// 	//$('input[name=quantity]').attr('data-val',$(this).val());
// })
$(document).on('click','.table-add-cart',function(){
 		
	    var id = $(this).attr('data-id');
		//var qty = localStorage.getItem('qty');
		var qty =  jQuery(this).prev().val();
		if(!qty)
		{
			$(this).prev().css({'border':'1px solid red'});
			$(this).focus();
		}
		var data = {
			action: 'library',
            product_id: id,
            quantity: qty,
			param: 'add-to-cart'
		}
		
		 	$.ajax({
            type: 'post',
            url: pineaseAjaxUrl,
            data: data,
            beforeSend: function (response) {
                $(this).removeClass('added').addClass('loading');
            
			},
            complete: function (response) {
                $(this).addClass('added').removeClass('loading');
            	
			},
            success: function (response) {
				//var response = $.parseJSON(res);
				//console.log(response);
				if(response.status==200)
				{
					setTimeout(function(){
						window.location.href = response.cart_url;
					},500);
				
				}
				else if(response.status==401)
				{
					console.log(response);
					$(this).prev().attr('data-final','yellow');
				}
                else if(response.status == 400)
				{
					return;
				}
            },
        });

        //return false;
	
	
		
})
	
	$('input[name=boxes]').each(function(){
    $(this).on('click',function(){
		$('#parent_cat').prop('checked',false);
        var cat_id = $(this).attr('data-id');
		var param = 'get_cat_products';
		var action = 'library';
		$.ajax({
			url:pineaseAjaxUrl,
			type:'POST',
			data:{cat_id:cat_id,param:param,action:action},
			success:function(res)
			{
				console.log(res);
				if(res.status == 200)
				{
					$('#productData').html(res.output);
				}
				
			}
		})
    })
});

	$('#parent_cat').on('click',function(){
		$('input[name=boxes]').prop('checked',false);
		var cat_id = $(this).attr('data-id');
		var param = 'get_cat_by_parent_id';
		var action = 'library';
		$.ajax({
			url:pineaseAjaxUrl,
			type:'POST',
			data:{cat_id:cat_id,param:param,action:action},
			success:function(res)
			{
				//console.log(res);
				if(res.status == 200)
				{
					$('#productData').html(res.output);
				}
			}
		})
	})
	
	$(document).on('click','.remove_cart',function(){
			var id = $(this).attr('data-id');
			var action = 'library';
			var param = 'remove_cart_item';
			var selector = $(this);
		$.ajax({
				
				url:pineaseAjaxUrl,
				type:'POST',
				data:{id:id,action:action,param:param},
				
				success:function(res)
				{
					if(res.status == 200)
					{
						setTimeout(function(){
							location.reload();
						},500);
					}
					else if(res.status==400)
						{
							console.log(res.message);
						}
				}
			
			})
	})
	
});



	
