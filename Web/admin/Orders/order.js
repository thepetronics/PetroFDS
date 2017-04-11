function sendOrderStatus(id){
	var status_id = document.getElementById("status");
	var status = status_id.options[status_id.selectedIndex].value;
	var ordertime_id = document.getElementById("order_time");
	var ordertime = ordertime_id.options[ordertime_id.selectedIndex].value;
	var declinereason = document.getElementById("decline_reason").value;
	if(status=='1'){
		if(ordertime!=''){
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					window.location = "index";					   
				}
			};
			xhttp.open("GET", "../../api/get_orders_status.php?id="+id+"&status="+status+"&time="+ordertime+"", true);
			xhttp.send();
		}else{
			alert('Please select order delivery time');
		}
	}else if(status='3'){
		if(declinereason!=''){
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					window.location = "index";	   
				}
			};
			xhttp.open("GET", "../../api/get_orders_status.php?id="+id+"&status="+status+"&reason="+declinereason+"", true);
			xhttp.send();
		}else{
			alert('Please enter decline reason');
		}
	}else{
		alert('Please select status');
	}
}