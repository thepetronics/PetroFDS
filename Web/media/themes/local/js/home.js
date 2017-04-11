$(document).ready(function(){

	$('#container').addClass('home_page_tel');

	$('body').addClass('home_page_body');
	
	$('#pay_by_card_row').hide();

	$('#loyal_id').click(function(){

		var id = document.getElementById('loyal_id').innerHTML;

		document.getElementById('code').value = id;			

	});
	
});

jQuery(document).ready(function(){    

	jQuery('#home_fech #home_bot').each(function(index){

	jQuery(this).attr('class','home_bot_'+index);

	});

});

function roundNumber(number, decimals) {

    var newnumber = new Number(number+'').toFixed(parseInt(decimals));

    return parseFloat(newnumber); 

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

function CouponCode(elem,currency_sign){

	if(elem == ''){

		alert('Please Enter Code');

	}else{

		var url = 'admin/setups/check_code.php?code='+elem;

		petrojs.GET(url, function(data){

			if(data!=''){

				var spl = data.split("=");

				var total = document.getElementById('total_all').value;

				if(spl[0] == 'coupon'){

					if(spl[1]=='exp'){

						alert('Your Coupon Code is Expired.');

					}else if(spl[1]=='false'){

						alert('May be Your Coupon is not activated yet or something wrong please contact support.');

					}else{

						$('#coupon').show();

						$petrojs('#coupon_price').html(currency_sign+spl[1]);

						var set_total = (total)-(spl[1]);

						document.getElementById('total').innerHTML=currency_sign+roundNumber(set_total,12);

						alert('Your Coupon Code is Added to the Total');

					}

				}else if(spl[0] == 'loyalty'){

					$("#loyalty_modal").modal();

				}else{

					alert('Please Check Your Code');

				}

			}else{

				alert('Something Wrong!');

			}

		});

	}

}



function Remove_loyalty(elem,total_loyalty,currency_sign){

	var total = document.getElementById('total_all').value;

	if(elem!=''){

		if(total<roundNumber(elem)){

			alert('Your Entered Loyalty Point is greater than Total Amount. Please enter the correct one.');

		}else{

			$('#loyalty').show();

			$petrojs('#loyalty_percent').html(currency_sign+elem);

			var set_total = (total) - (elem);

			document.getElementById('total').innerHTML=currency_sign+roundNumber(set_total,12);

			document.getElementById('total_all').value=roundNumber(set_total,12);

			document.getElementById('point_loyalty').innerHTML=currency_sign+Math.abs((elem)-(total_loyalty));

			document.getElementById('remain_loyalty').value=Math.abs((elem)-(total_loyalty));

			alert('Loyalty Point is Added to the Total');

		}

	}

}

function ForgotModal(){
	$("#forgot_password").modal();
}

function resetpass(email){
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
	if (filter.test(email)){
		var url = 'setups/files/reset_pass.php?email='+email+'';
		petrojs.GET(url, function(data){
			if(data!=''){
				alert(data);
			}else{
				alert('Something Went Wrong!');
			}
		});
	}else{
		alert("Please input a valid email address!");
	}
}

function CheckCount() {



var NewCount = 0



	if (document.getElementById('paypal_check').checked)




	{NewCount = NewCount + 1}

	

	if (document.getElementById('cash_check').checked)

	{NewCount = NewCount + 1}

	

	if (NewCount == 2)

	{

		document.form; return false;

	}

} 



function validatemethod(currency,charges) {
	var total = document.getElementById("total_all").value;
	if(document.getElementById('home.home').checked){

		var total_set = parseFloat(charges)+parseFloat(total);
		
		document.getElementById("total_all").value = total_set;
		
		document.getElementById("total").innerHTML = currency+total_set.toFixed(2);

		document.getElementById("payment_method").value = 'Home Delivery';
		
		$('#dev_chrg').show();

	}else if(document.getElementById('collect.collect').checked){

		var total_set = Math.abs(parseFloat(charges)-parseFloat(total));
		
		document.getElementById("total_all").value = total_set;

		document.getElementById("total").innerHTML = currency+total_set.toFixed(2);

		document.getElementById("payment_method").value = 'Collect From Store';
		
		$('#dev_chrg').hide();

	}else{

		$petrojs('#payment_method').value('none');

	}
}

function validateCoupon()

{

var x=document.forms["form_code"]["code"].value;

if (x==null || x=="")

  {

  alert("Please First Enter Coupon code.");

  return false;

  }

}

function validateLogin()

{

var x=document.forms["form_login"]["email"].value;

if (x==null || x=="")

  {

  alert("Please enter Email to login.");

  return false;

  }

var x=document.forms["form_login"]["password"].value;

if (x==null || x=="")

  {

  alert("Please enter Password to login.");

  return false;

  }

}

function validateCheckoutLogin()

{

var email=document.getElementById("login_email").value;

var password=document.getElementById("login_password").value;

	if(email==null || email==""){

		alert("Please Enter Email Address");

	}

	else if (password==null || password==""){

		alert("Please Enter Password");

	}else{

		petrojs.POST('setups/files/login.php',{

		data:"email="+email+"&password="+password+"&login=checkout"

		}, function(data){

			if(data=='Success'){

				window.location.href = "?login=success";

			}else{

				window.location.href = "?login=error";

			}

		});

	}

}

function validateForm()

{

var x=document.forms["form"]["firstname"].value;

if (x==null || x=="")

  {

  alert("Please Enter your Firstname");

  return false;

  }

var x=document.forms["form"]["lastname"].value;

if (x==null || x=="")

  {

  alert("Please Enter your Lastname");

  return false;

  }

var x=document.forms["form"]["email"].value;

if (x==null || x=="")

{

	alert("Please Enter your Email Address");

	return false;

}else{

	if(document.getElementById('valid_user').innerHTML == 'User with this email already exists.'){

		alert("User with this email already exists.");

		return false;

	}

}

var x=document.forms["form"]["contact_no"].value;

if (x==null || x=="")

  {

  alert("Please Enter your Contact number");

  return false;

  }

var x=document.forms["form"]["password"].value;

if (x==null || x=="")

  {

  alert("Please Enter your Password");

  return false;

  }

var x=document.forms["form"]["password_con"].value;

if (x==null || x=="")

  {

  alert("Please Enter your Confirm Password");

  return false;

  }

var x=document.forms["form"]["password"].value;

var y=document.forms["form"]["password_con"].value;

if (x!=null || x!="" || y!=null || y!="")

  {

	if(x!=y){	  

	  alert("Your Entered Password didn't Match.");

	  return false;

	}

  }

var x=document.forms["form"]["add_1"].value;

if (x==null || x=="")

  {

  alert("Please Enter your Address1");

  return false;

  }

var x=document.forms["form"]["add_2"].value;

if (x==null || x=="")

  {

  alert("Please Enter your Address2");

  return false;

  }

var x=document.forms["form"]["city"].value;

if (x==null || x=="")

  {

  alert("Please Enter your City");

  return false;

  }

var x=document.forms["form"]["post_code"].value;

if (x==null || x=="")

  {

  alert("Please Enter Postcode");

  return false;

  }

var x=document.forms["form"]["paypal_check"];

var y=document.forms["form"]["cash_check"];

  if (x.checked==false && y.checked==false)

  {

	  alert("Please Select One Payment method");

	  return false;

  }else{

	  return true;

  }

}

function validateFormEdit()

{

var x=document.forms["form"]["firstname"].value;

if (x==null || x=="")

  {

  alert("Please Enter your Firstname");

  return false;

  }

var x=document.forms["form"]["lastname"].value;

if (x==null || x=="")

  {

  alert("Please Enter your Lastname");

  return false;

  }

var x=document.forms["form"]["email"].value;

if (x==null || x=="")

{

  alert("Please Enter your Email Address");

  return false;

}else{

	if(document.getElementById('valid_user').innerHTML == 'User with this email already exists.'){

		alert("User with this email already exists.");

		return false;

	}

}

var x=document.forms["form"]["contact_no"].value;

if (x==null || x=="")

  {

  alert("Please Enter your Contact number");

  return false;

  }

var x=document.forms["form"]["password"].value;

var y=document.forms["form"]["password_con"].value;

if (x!=null || x!="" || y!=null || y!="")

  {

	if(x!=y){	  

	  alert("Your Entered Password didn't Match.");

	  return false;

	}

  }

var x=document.forms["form"]["add_1"].value;

if (x==null || x=="")

  {

  alert("Please Enter your Address1");

  return false;

  }

var x=document.forms["form"]["add_2"].value;

if (x==null || x=="")

  {

  alert("Please Enter your Address2");

  return false;

  }

var x=document.forms["form"]["city"].value;

if (x==null || x=="")

  {

  alert("Please Enter your City");

  return false;

  }

var x=document.forms["form"]["post_code"].value;

if (x==null || x=="")

  {

  alert("Please Enter Postcode");

  return false;

  }

var x=document.forms["form"]["paypal_check"];

var y=document.forms["form"]["cash_check"];

  if (x.checked==false && y.checked==false)

  {

	  alert("Please Select One Payment method");

	  return false;

  }else{

	  return true;

  }

}

$petrojs('#submit_check').onchange(function(){

	if(document.getElementById("submit_check").checked){

		$petrojs('#btn_sub').removeClass('black');

	}else{

		$petrojs('#btn_sub').addClass('black');

	}

});

function Checkemail(val,id){

	var url = 'setups/files/valid_user.php?email='+val+'&id='+id;

	petrojs.GET(url, function(data){

		if(data=='available'){

			$petrojs('#valid_user').html('User with this email already exists.');

		}else{

			$petrojs('#valid_user').html('');

		}

	});

}

function CheckPostcode(postcode){

	var url = "setups/files/postcode.php?postcode="+postcode+"";

	petrojs.GET(url, function(data){

		if(data==postcode){

			document.getElementById("valid_postcode").innerHTML = '';

		}else if(data=='NotFound'){

			document.getElementById("valid_postcode").innerHTML = "We don't deliver to this area please call us at: 01389 711 797";

		}else if(data=='Failed'){

			document.getElementById("valid_postcode").innerHTML = 'Entered Postcode is Incorrect.';

		}

	});

}