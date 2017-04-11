function get(){
	var countdown = document.getElementById("countdown");
	
	setInterval(function () {

		var url = 'setups/files/get_time.php';

		petrojs.GET(url, function(data){

			countdown.innerHTML = data;

		});	  

	}, 1000);
}

get();