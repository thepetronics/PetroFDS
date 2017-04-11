$(function() {

	'use strict';
	
	$('a[href*=#]:not([href=#])').click(function() {
	
	  if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
	
		var target = $(this.hash);
	
		target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
	
		if (target.length) {
	
		  $('html,body').animate({
	
			scrollTop: target.offset().top - 70
	
		  }, 1000);
	
		  return false;
	
		}
	
	  }
	
	});

	$('#cat_mob_display .nav-2').hide();
	
});

$(window).scroll(function () {

    var $this = $(this),

        $head = $('#head');

    if ($this.scrollTop() > 120) {

       $("#cat-overflow").css("overflow-y", "scroll");

    } else {

       $("#cat-overflow").css("overflow-y", "");

    }

});

$(function(){       
	var 
		$online = $('.online'),
		$offline = $('.offline');
	Offline.on('confirmed-down', function () {
		$online.fadeOut(function () {
			$offline.fadeIn();
		});
	});
	Offline.on('confirmed-up', function () {
		$offline.fadeOut(function () {
			$online.fadeIn();
		});
	});
});

var myHeader = $('#nav_mob_display');
myHeader.data( 'position', myHeader.position() );
$(window).scroll(function(){
    var scroll = getScroll();
    if ( scroll.top > 800){
        myHeader.addClass('fixed');
    }
    else {
        myHeader.removeClass('fixed');
    }
});

function getScroll () {
var b = document.body;
var e = document.documentElement;
return {
	left: parseFloat( window.pageXOffset || b.scrollLeft || e.scrollLeft ),
	top: parseFloat( window.pageYOffset || b.scrollTop || e.scrollTop )
	};
}
function CategoryNav(elem){
	document.getElementById("cat_mob_display_name").innerHTML = elem.innerHTML;
	document.getElementById('cat_mob_display').style.display='none'
}

function showDialog(id,title,price)
{

	if(title!=''){

		if(price!=''){

			var option_url = "app/themes/local/options.php?id="+id+"&title="+title+"&price="+price+"";

		}else{

			var option_url = "app/themes/local/options.php?id="+id+"&title="+title+"";

		}

	}else{

		var option_url = "app/themes/local/options.php?id="+id+"";

	}

	petrojs.GET(option_url, function(data){

		if(data){

			$petrojs('#body'+id).html(data);

			$('.selectpicker').selectpicker('refresh');

			var elem_add_order = document.getElementById('add_crt');

			var div_id = document.getElementById('get_id').innerHTML;

		    var div_count = document.getElementById('count').innerHTML;

			elem_add_order.removeAttribute('onClick');

			elem_add_order.setAttribute('onClick','addtocart_withoptions("add",'+div_id+','+div_count+')');

		}else{

			alert('Someting Went Wrong Your response data is not working');

		}

	});

}

function AjaxSelect(element,i,get){

	var id = parseInt(i)+1;

	var child = element.options[element.selectedIndex].value;

	var option_url = "../../../admin/setups/Ajax/get_option.php?child_id="+child+"";

	petrojs.GET(option_url, function(data){

		if(data){

			document.getElementById(get+'second_select'+id).innerHTML = data;

			$('.selectpicker').selectpicker('refresh');

		}else{

			alert('Someting Went Wrong Your response data is not working');

		}

	});

}

function roundNumber(number, decimals) {

    var newnumber = new Number(number+'').toFixed(parseInt(decimals));

    return parseFloat(Math.round(newnumber * 100) / 100).toFixed(2); 

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

function set_price_yes_no(elem,currency_sign,new_price,menu_id){

	var pr = document.getElementById("price"+menu_id).innerHTML;

	var price = pr;

	var ide = elem.getAttribute("ide");

	if((ide == "not_added")){

		var $result = (+price)+(+new_price);

		document.getElementById("price"+menu_id).innerHTML=roundNumber($result,12);

		document.getElementById("extra"+menu_id).innerHTML=' (Includes a '+ currency_sign + new_price + ' fee for changes)';

		elem.setAttribute("ide","added");

	}else if((ide == "added") && (elem.value="0")){

		var $result = (price)-(new_price);

		document.getElementById("price"+menu_id).innerHTML=roundNumber($result,12);
		
		document.getElementById("extra"+menu_id).innerHTML='';

		elem.setAttribute("ide","not_added");

	}

}

function set_price_normal_options(elem,currency_sign,menu_id){

	var price = document.getElementById("price"+menu_id).innerHTML;

	var ide = elem.getAttribute("ide");

	if(elem.tagName === 'SELECT'){

		var new_price = elem.options[elem.selectedIndex].getAttribute("price");

	}else if(elem.tagName === 'INPUT'){

		var new_price = elem.getAttribute("price");

	}

	if(new_price!=null){

		if((ide == "not_added") && (new_price!='0.00')){

			var $result = (+price)+(+new_price);

			document.getElementById("price"+menu_id).innerHTML=roundNumber($result,12);

			document.getElementById("extra"+menu_id).innerHTML=' (Includes a '+ currency_sign + new_price + ' fee for changes)';

			elem.setAttribute("ide",new_price);

		}else if((ide == new_price) && (new_price!='0.00')){

			elem.setAttribute("ide",new_price);

		}else if((ide != new_price) && (new_price!='0.00')){

			var $result = (price)-(ide);

			var $new_result_price = (+$result)+(+new_price)

			document.getElementById("price"+menu_id).innerHTML=roundNumber($new_result_price,12);

			document.getElementById("extra"+menu_id).innerHTML=' (Includes a '+ currency_sign + new_price + ' fee for changes)';

			elem.setAttribute("ide",new_price);

		}else if((new_price=='0.00')){

			if(ide == "not_added"){



				document.getElementById("price"+menu_id).innerHTML=roundNumber($price,12);

				document.getElementById("extra"+menu_id).innerHTML='';

			}else{

				elem.setAttribute("ide","not_added");

				var $result_price = (price)-(ide)

				document.getElementById("price"+menu_id).innerHTML=roundNumber($result_price,12);

				document.getElementById("extra"+menu_id).innerHTML='';

			}

		}

	}

}

function Postcode(id){
	var postcode = document.getElementById("postcode_menu"+id).value;
	var option_url = "setups/files/postcode.php?postcode="+postcode+"";
	petrojs.GET(option_url, function(data){
		if(data=='Success'){
			location.reload();
		}else if(data=='NotFound'){
			alert("We don't deliver to this area please call at: 000011114444");
		}else if(data=='Failed'){
			alert('Entered Postcode is Incorrect.');
		}
	});
}
function setCheckbox(elem,id,num,option_id,currency_sign,price){

	if(elem.value=="1"){

		document.getElementById(id+'select'+num).setAttribute('price','0.00');	

	}else if(elem.value=="0"){

		document.getElementById(id+'select'+num).setAttribute('price',price);

	}

	if(elem.checked){

		elem.value="1";

		document.getElementById(id+'select'+num).value=option_id;	

		set_price_normal_options(document.getElementById(id+'select'+num),currency_sign,id);

	}else{

		elem.value="0";

		document.getElementById(id+'select'+num).value='0';

		set_price_normal_options(document.getElementById(id+'select'+num),currency_sign,id);

	}

}