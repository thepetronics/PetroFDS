function form_submit()
{

	var lastname = document.getElementById("lastname").value;
	var mobile = document.getElementById("mobile").value;
	var email = document.getElementById("email").value;

	if (lastname == "")
	{
		alert("Please enter the Last Name");
	}
	else if (mobile == "")
	{
		alert("Please enter Mobile number for SMS alert");
	}

	else if (email == "")
	{
		alert("Please enter valid Email for Notification");
	}
	else if ( /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email) === false ){ 
		alert("Invalid E-mail Address! Please re-enter."); 
		//return false; 
	} 
	else if(isNaN(mobile))
	 {
		 alert("Enter the valid Mobile Number(Like : 03141234567)");
	 }

	else
	{
		
		document.f1.save.disabled=true;	
		document.f1.submit();

	}
	
}