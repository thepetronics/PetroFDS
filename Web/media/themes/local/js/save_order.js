petrojs.onload(function(){

	addtocart(null,null,null,null);
	
	var mob_total = document.getElementById("total_cart_price");
			
	if(typeof(mob_total) != 'undefined' && mob_total != null){
		$('#price_mob').html(mob_total.innerHTML);	
	}else{
		$('#price_mob').html("0.00");
	}

},window.petrojs);

function addtocart(action,id,title,price){

	$('#info_product').hide();

	$('#loader').show();

	if(title!=null){

		if(price!=null){

			var order_url = 'setups/files/order.php?action='+action+'&id='+id+'&title='+title+'&price='+price+'';

		}else{

			var order_url = 'setups/files/order.php?action='+action+'&id='+id+'&title='+title+'';

		}

	}else if(price!=null){

		var order_url = 'setups/files/order.php?action='+action+'&id='+id+'&price='+price+'';

	}else{

		var order_url = 'setups/files/order.php?action='+action+'&id='+id+'';

	}

	petrojs.GET(order_url, function(data){

		$petrojs('#side_cart_open').html(data);

		$('#loader').hide();

		$('#info_product').show();
		
		var mob_total = document.getElementById("total_cart_price");
			
		if(typeof(mob_total) != 'undefined' && mob_total != null){
			$('#price_mob').html(mob_total.innerHTML);	
		}else{
			$('#price_mob').html("0.00");
		}
    });
}

function getCookie(cname) {

    var name = cname + "=";

    var ca = document.cookie.split(';');

    for(var i=0; i<ca.length; i++) {

        var c = ca[i];

        while (c.charAt(0)==' ') c = c.substring(1);

        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);

    }

    return "";

}

function addtocart_withoptions(action,id,title,count1,count2,count3,count4,req_options){

	var

	elem1,

	elem2,

	elem3,

	elem4,

	child1,

	child2,

	child3,

	child4,

	url,

	i,

	j,

	k,

	options_all1,

	options_all2,

	options_all3,

	options_all4;
	
	var currency = getCookie('currency');

	for( i = 1; i < count2; i++){

		elem1 = document.getElementById(id+'select_yesno'+i);

		child1 = elem1.options[elem1.selectedIndex].value;

		options_all1 += '&option_yesno_'+i+'='+child1+'';

	}

	for( j = 1; j < count3; j++){

		elem2 = document.getElementById(id+'select'+j);

		if(elem2.tagName === 'SELECT'){

			child2 = elem2.options[elem2.selectedIndex].value;

		}else if(elem2.tagName === 'INPUT'){
			child2 = elem2.value;
		}

		options_all2 += '&option_'+j+'='+child2+'';

	}

	for( k = 1; k < count4; k++){

		elem3 = document.getElementById(id+'option_notype'+k);

		child3 = elem3.options[elem3.selectedIndex].value;

		options_all3 += '&option_notype_'+k+'='+child3+'';

		elem4 = document.getElementById(id+'option_notype_title'+k);

		child4 = elem4.value;

		options_all4 += '&option_notype_title_'+k+'='+child4+'';

	}

	var price = document.getElementById("price"+id).innerHTML;
	
	if(req_options=='1'){
		for( var table = 1; table < count1; table++){
			if ($('#check'+table).filter(function(){  return $(this).find(':checked').length === 0 }).length > 0 ) {
				alert('Please Select all options');
				return;
			}
		}
		
		if(child1==='undefined' || child2==='undefined' || child3===''){
			alert('Please Select all options');
		}else if(child1==='undefined' || child2==='' || child3==='undefined'){
			alert('Please Select all options');
		}else if(child1==='' || child2==='undefined' || child3==='undefined'){
			alert('Please Select all options');
		}else{
			$('#info_product').hide();
	
			$('#loader').show();
			
			if(title!=null){
		
				url = 'setups/files/order.php?action='+action+'&id='+id+'&'+options_all1+'&'+options_all2+'&'+options_all3+'&'+options_all4+'&count1='+count1+'&count2='+count2+'&count3='+count3+'&count4='+count4+'&price='+price+'&title='+title+'';
		
			}else{
		
				url = 'setups/files/order.php?action='+action+'&id='+id+'&'+options_all1+'&'+options_all2+'&'+options_all3+'&'+options_all4+'&count1='+count1+'&count2='+count2+'&count3='+count3+'&count4='+count4+'&price='+price+'';
		
			}
		
			petrojs.GET(url, function(data){
		
				$petrojs('#side_cart_open').html(data);
		
				$('#loader').hide();
		
				$('#info_product').show();
				
				var mob_total = document.getElementById("total_cart_price");
				
				if(typeof(mob_total) != 'undefined' && mob_total != null){
					$('#price_mob').html(mob_total.innerHTML);	
				}else{
					$('#price_mob').html("0.00");
				}
			});
			$('#myModal'+id).modal('hide');
		}
	}else{
		$('#info_product').hide();
	
		$('#loader').show();
		
		if(title!=null){
	
			url = 'setups/files/order.php?action='+action+'&id='+id+'&'+options_all1+'&'+options_all2+'&'+options_all3+'&'+options_all4+'&count1='+count1+'&count2='+count2+'&count3='+count3+'&count4='+count4+'&price='+price+'&title='+title+'';
	
		}else{
	
			url = 'setups/files/order.php?action='+action+'&id='+id+'&'+options_all1+'&'+options_all2+'&'+options_all3+'&'+options_all4+'&count1='+count1+'&count2='+count2+'&count3='+count3+'&count4='+count4+'&price='+price+'';
	
		}
	
		petrojs.GET(url, function(data){
	
			$petrojs('#side_cart_open').html(data);
	
			$('#loader').hide();
	
			$('#info_product').show();
			
			var mob_total = document.getElementById("total_cart_price");
			
			if(typeof(mob_total) != 'undefined' && mob_total != null){
				$('#price_mob').html(mob_total.innerHTML);	
			}else{
				$('#price_mob').html("0.00");
			}
		});
		$('#myModal'+id).modal('hide');
	}
}



function session_Storage(product_id,price,option){

	var obj = JSON.parse(sessionStorage.getItem(product_id));

	var cart = {

		product_id: product_id,

		price: price,

		option: option,

		qty: 1

	};

	var jsonStr = JSON.stringify( cart );

	if(obj.product_id == product_id){

		alert(product_id);

	}else if(obj.product_id != product_id){

		sessionStorage.setItem( product_id, jsonStr );

	}

}

function getTimer(){

	var countdown = document.getElementById("countdown");
	
	setInterval(function () {

		var url = 'setups/files/get_time.php';

		

		petrojs.GET(url, function(data){

			countdown.innerHTML = data;

		});	  

	}, 1000);

}