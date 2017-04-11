$(function () {
		// Radialize the colors
		Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
			return {
				radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
				stops: [
					[0, color],
					[1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
				]
			};
		});
		$(document).ready(function () {
			// Build the chart
			sales1();
			SalesByDate();
			function SalesByDate(){
				petrojs.GET('sales_by_date.php', function(get){
					obj = JSON.parse(get);
					var data = [];
					var pos,
					jansum,
					febsum,
					marsum,
					aprsum,
					maysum,
					junsum,
					julsum,
					augsum,
					sepsum,
					octsum,
					novsum,
					decsum,
					sum;
					pos = obj.posts;
					for(var i=0; i<pos.length; i++){
						jan = parseFloat(pos[i].cnt1);
						feb = parseFloat(pos[i].cnt2);
						mar = parseFloat(pos[i].cnt3);
						apr = parseFloat(pos[i].cnt4);
						may = parseFloat(pos[i].cnt5);
						jun = parseFloat(pos[i].cnt6);
						jul = parseFloat(pos[i].cnt7);
						aug = parseFloat(pos[i].cnt8);
						sep = parseFloat(pos[i].cnt9);
						oct = parseFloat(pos[i].cnt10);
						nov = parseFloat(pos[i].cnt11);
						dec = parseFloat(pos[i].cnt12);
						jansum = [jan];
						data.push(jansum);
						febsum = [feb];
						data.push(febsum);
						marsum = [mar];
						data.push(marsum);
						aprsum = [apr];
						data.push(aprsum);
						maysum = [may];
						data.push(maysum);
						junsum = [jun];
						data.push(junsum);
						julsum = [jul];
						data.push(julsum);
						augsum = [aug];
						data.push(augsum);
						sepsum = [sep];
						data.push(sepsum);
						octsum = [oct];
						data.push(octsum);
						novsum = [nov];
						data.push(novsum);
						decsum = [dec];
						data.push(decsum);
					}
					$('#sales_by_date').highcharts({
						title: {
							text: 'This Year Sales Record By Months',
							x: -20 //center
						},
						colors: ['#8dc100', '#8dc100', '#8dc100'],
						subtitle: {
							text: 'Source: <a href="http://fds.thepetronics.com" target="_blank">ThePetronics</a>',
							x: -20
						},
						xAxis: {
							categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
								'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
						},
						yAxis: {
							title: {
								text: 'Total(Count)'
							},
							plotLines: [{
								value: 0,
								width: 1,
								color: '#8dc100'
							}]
						},
						plotOptions: {
							line: {
								dataLabels: {
									enabled: true
								},
								enableMouseTracking: false
							}
						},
						tooltip: {
							valueSuffix: ''
						},
						legend: {
							layout: 'vertical',
							align: 'right',
							verticalAlign: 'middle',
							borderWidth: 0
						},
						series: [{
							name: 'Total(Count)',
							data: data
						}]
					});
				});
			}
			function sales1(){
				petrojs.GET('sales_count.php', function(get){
					obj = JSON.parse(get);
					var data = [];
					var pos,
					this_month,
					last_month,
					this_year,
					last_year,
					sum1,
					sum2,
					sum3,
					sum4;
					pos = obj.posts;
					for(var i=0; i<pos.length; i++){
						this_month = parseInt(pos[i].this_month);
						last_month = parseInt(pos[i].last_month);
						this_year = parseInt(pos[i].this_year);
						last_year = parseInt(pos[i].last_year);
						var sum1 = ['THIS MONTH',this_month];
						data.push(sum1);
						var sum2 = ['LAST MONTH',last_month];
						data.push(sum2);
						var sum3 = ['THIS YEAR',this_year]; 
						data.push(sum3);
						var sum4 = ['LAST YEAR',last_year];
						data.push(sum4);
					}
					$('#sales_chart').highcharts({
						chart: {
							type: 'column'
						},						
						title: {
							text: 'Sales Record Chart'
						},
						subtitle: {
							text: 'Source: <a href="http://fds.thepetronics.com" target="_blank">ThePetronics</a>'
						},
						colors: [
								'#8dc100'
							],
						xAxis: {
							type: 'category',
							labels: {
								rotation: -45,
								style: {
									fontSize: '10px',
									fontFamily: 'Verdana, sans-serif'
								}
							}
						},
						yAxis: {
							min: 0,
							title: {
								text: 'Counts (Total)'
							}
						},
						legend: {
							enabled: false
						},
						series: [{
							name: 'Total Count',
							data: data,
							dataLabels: {
								enabled: true,
								rotation: -90,
								color: '#FFFFFF',
								align: 'right',
								y: 10, // 10 pixels down from the top
								style: {
									fontSize: '10px',
									fontFamily: 'Verdana, sans-serif'
								}
							}
						}]
					});
				});
			}
			function sales2(){
				petrojs.GET('user_info_count.php', function(get){
					obj = JSON.parse(get);
					var data = [];
					var pos,
					user_name,
					user_total,
					sum;
					pos = obj.posts;
					for(var i=0; i<pos.length; i++){
						user_name = pos[i].name;
						user_total = parseInt(pos[i].total);
						sum = [user_name, user_total];
						data.push(sum);
					}
					// Build the chart
					$('#sales_chart').highcharts({
						chart: {
							plotBackgroundColor: null,
							plotBorderWidth: null,
							plotShadow: false
						},
						title: {
							text: 'Users\'s Information By Count'
						},
						subtitle: {
							text: 'Source: <a href="http://fds.thepetronics.com" target="_blank">ThePetronics</a>'
						},
						tooltip: {
							pointFormat: '{series.name}: <b>{point.y:f}</b>'
						},
						credits: {
							enabled: true
						},
						plotOptions: {
							pie: {
								allowPointSelect: true,
								cursor: 'pointer',
								dataLabels: {
									enabled: true,
									format: '<b>{point.name}</b>: {point.y:f}',
									style: {
										color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
										fontSize:'7.5px'
									},
								},
								showInLegend: {
									enabled: true,
									style: {
										color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
										fontSize:'7.5px'
									},
								},
							}
						},
						series: [{
							type: 'pie',
							name: 'Total Order\'s',
							data: data,
						}]
					});	
				});	
			}

			intervalManager_bardata(true, 15000);
			intervalManager_sales(true, 15000);
			document.getElementById('interval_bar').addEventListener("click", function(){
				if(this.value == 'Start'){
					intervalManager_bardata(true, 15000);
					this.value = 'Stop';
				}else{
					intervalManager_bardata(false); 
					this.value = 'Start';
				}
			});
			function intervalManager_bardata(flag, time) {
			   var intervalFunctions = [ sales2, sales1 ];
			   var intervalIndex = 0;
			   if(flag)
				 intervalID =  setInterval(function(){
					intervalFunctions[intervalIndex++ % intervalFunctions.length]();
				 }, time);
			   else
				 clearInterval(intervalID);
			}
			function intervalManager_sales(flag, time) {
			   var intervalFunctions = [ SalesByDate, SalesByDate ];
			   var intervalIndex = 0;
			   if(flag)
				 intervalID =  setInterval(function(){
					intervalFunctions[intervalIndex++ % intervalFunctions.length]();
				 }, time);
			   else
				 clearInterval(intervalID);
			}
		});
	});