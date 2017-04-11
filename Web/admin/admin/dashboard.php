<?php
	$stmt_order = $conn->prepare("SELECT * FROM order_details ORDER BY ID DESC LIMIT 5");

	$stmt_order->execute();
	
	$rows_order = $stmt_order->fetchAll(PDO::FETCH_ASSOC);
	
	$stmt_menu = $conn->prepare("SELECT * FROM menus ORDER BY ID DESC LIMIT 1");

	$stmt_menu->execute();
	
	$rows_menu = $stmt_menu->fetchAll(PDO::FETCH_ASSOC);
	
	$lstyear = date('Y', strtotime("-1 year"));

	$thismonthfrom = date('Y-m-01');
	$thismonthto = date('Y-m-d', mktime(0, 0, 0, date('m')+1, 0, date('Y')));
	$lastmonthfrom = date("Y-n-j", strtotime("first day of previous month"));
	$lastmonthto = date("Y-n-j", strtotime("last day of previous month"));
	$thisyearfrom = date('Y-01-01');
	$thisyearto = date('Y-12-d', mktime(0, 0, 0, date('12')+1, 0, date('Y')));
	$lastyearfrom = date('Y-01-01', strtotime("-1 year"));
	$lastyearto = date($lstyear.'-m-d', mktime(0, 0, 0, date('12')+1, 0, date('Y')));
	
	$sql_sales = 'SELECT od.date_created, od.id as order_detail_id,
	(SELECT COUNT(id) FROM `order_details` WHERE date_created BETWEEN "'.$thismonthfrom.'" AND "'.$thismonthto.'") as total_thismonth,
	(SELECT COUNT(id) FROM `order_details` WHERE date_created BETWEEN "'.$lastmonthfrom.'" AND "'.$lastmonthto.'") as total_lastmonth,
	(SELECT COUNT(id) FROM `order_details` WHERE date_created BETWEEN "'.$thisyearfrom.'"  AND  "'.$thisyearto.'") as total_thisyear,
	(SELECT COUNT(id) FROM `order_details` WHERE date_created BETWEEN "'.$lastyearfrom.'"  AND  "'.$lastyearto.'") as total_lastyear
	FROM `order_details` od
	';
	
	$stmt_sales = $conn->prepare($sql_sales);			  
	
	$stmt_sales->execute();
	
	$rows_sales = $stmt_sales->fetchAll(PDO::FETCH_ASSOC);
	if($rows_sales){
		foreach($rows_sales as $row_sales){
			$this_month = $row_sales['total_thismonth'];
			$last_month = $row_sales['total_lastmonth'];
			$this_year  = $row_sales['total_thisyear'];
			$last_year  = $row_sales['total_lastyear'];
		}
	}
	
	$sql_sales_pr = '
	SELECT date_created, id FROM `order_details` 
	WHERE date_created BETWEEN "'.$thismonthfrom.'" 
	AND "'.$thismonthto.'" ORDER BY id DESC LIMIT 5
	';
	
	$stmt_sales_pr = $conn->prepare($sql_sales_pr);			  
	
	$stmt_sales_pr->execute();
	
	$rows_sales_pr = $stmt_sales_pr->fetchAll(PDO::FETCH_ASSOC);
	
	if($rows_sales_pr){
		$id_detail='';
		foreach($rows_sales_pr as $row_sales_pr){
			$id_detail .= $row_sales_pr['id'].',';
			$order_detail_id = substr($id_detail,0,strlen($id_detail)-1);
		}
	
	$id_product = array($order_detail_id);
	
	$result = array_count_values($id_product);
	asort($result);
	end($result);
	$product_id = key($result);
	
	$sql_sales2 = 'SELECT * FROM `menus` WHERE id IN ('.$product_id.')';
	
	$stmt_sales2 = $conn->prepare($sql_sales2);			  
	
	$stmt_sales2->execute();
	
	$rows_sales2 = $stmt_sales2->fetchAll(PDO::FETCH_ASSOC);
	}
	
	$sql_detail_id_sales = '
	SELECT id FROM `order_details`
	';
	
	$stmt_detail_id_sales = $conn->prepare($sql_detail_id_sales);			  
	
	$stmt_detail_id_sales->execute();
	
	$rows_detail_id_sales = $stmt_detail_id_sales->fetchAll(PDO::FETCH_ASSOC);
	
	if($rows_detail_id_sales){
		$id_detail_sales='';
		foreach($rows_detail_id_sales as $row_detail_id_sales){
			$id_detail_sales .= $row_detail_id_sales['id'].',';
			$order_detail_id_sales = substr($id_detail_sales,0,strlen($id_detail_sales)-1);
		}
	}
	
	if(isset($order_detail_id_sales)){
	$id_product_sales = array($order_detail_id_sales);
	$result_sales = array_count_values($id_product_sales);
	asort($result_sales);
	end($result_sales);
	$product_id_sales = key($result_sales);
	}
	
	$total_sales='';
	$cnt=0;
	if(isset($product_id_sales)){
	$sql_total_sales = 'SELECT DISTINCT order_detail_id, price_all FROM `orders` WHERE order_detail_id IN ('.$product_id_sales.') GROUP BY order_detail_id';
	
	$stmt_total_sales = $conn->prepare($sql_total_sales);			  
	
	$stmt_total_sales->execute();
	
	$rows_total_sales = $stmt_total_sales->fetchAll(PDO::FETCH_ASSOC);
	
	if($rows_total_sales){
		foreach($rows_total_sales as $row_total_sales){
			$total_sales += $row_total_sales['price_all'];
			$cnt++;
		}
	}else{
		$total_sales=0;
	}
	}else{
		$total_sales=0;	
	}
	$sql_avg_sales = 'SELECT AVG(price_all) as avg_sales FROM `orders`';
	
	$stmt_avg_sales = $conn->prepare($sql_avg_sales);			  
	
	$stmt_avg_sales->execute();
	
	$rows_avg_sales = $stmt_avg_sales->fetchAll(PDO::FETCH_ASSOC);
	
	if($rows_avg_sales){
		foreach($rows_avg_sales as $row_avg_sales){
			$avg_sales = $row_avg_sales['avg_sales'];
		}
	}
	if($rows_sales_pr){
	$sql_top_customer = '
	SELECT * FROM `order_details` WHERE id IN ('.$product_id.') 
	AND date_created BETWEEN "'.$thismonthfrom.'" AND "'.$thismonthto.'" 
	ORDER BY id DESC LIMIT 5
	';
	
	$stmt_top_customer = $conn->prepare($sql_top_customer);			  
	
	$stmt_top_customer->execute();
	
	$rows_top_customer = $stmt_top_customer->fetchAll(PDO::FETCH_ASSOC);
	}

?>        
        <link href="../css/inettuts.css" rel="stylesheet" type="text/css" />
        
    <div id="columns">
        <ul id="column1" class="column">
            <li class="widget color-green" id="intro">
                <div class="widget-head">
                    <h3>Welcome - <?php echo $FullAdminName ?></h3>
                </div>
                <div class="widget-content">
                <?php
				if(isset($_SESSION['LAST_LOGIN_TIME']) && $_SESSION['LAST_LOGIN_TIME']!=''){
				?>
                    <p>Last Login Date/Time: <?php echo $_SESSION['LAST_LOGIN_TIME'] ?></p>
                <?php
				}else{
				?>
                	<p>No Data Available</p>
                <?php
				}
				if(isset($_SESSION['LAST_LOGIN_IP']) && $_SESSION['LAST_LOGIN_IP']!=''){
				?>
                    <p>Last Login From IP: <?php echo $_SESSION['LAST_LOGIN_IP'] ?></p>
                <?php
				}else{
				?>
                	<p>No Data Available</p>
                <?php
				}
				?>
                    <p>Current IP: <?php echo $_SESSION['USER_IP'] ?></p>
                </div>
            </li>
            <li class="widget color-blue">
                <div class="widget-head">
                    <h3>Top 5 Customer Of The Month</h3>
                </div>
                <div class="widget-content">
                <?php
				if(isset($rows_top_customer)){
					foreach($rows_top_customer as $row_top_customer){
						$sql_customer = '
						SELECT * FROM `users` WHERE id='.$row_top_customer['user_id'].'
						';
						
						$stmt_customer = $conn->prepare($sql_customer);			  
						
						$stmt_customer->execute();
						
						$rows_customer = $stmt_customer->fetchAll(PDO::FETCH_ASSOC);
						
						if($rows_customer){
							foreach($rows_customer as $row_customer){
				?>
                    		<p><?php echo $row_customer['firstname'].' '.$row_customer['lastname'] ?></p>
                <?php
							}
						}
					}
				}else{
				?>
                	<p>No Data Available</p>
                <?php
				}
				?>
                </div>
            </li>
            <li class="widget color-orange">  
                <div class="widget-head">
                    <h3>Last Entered Product Information</h3>
                </div>
                <div class="widget-content">
                <?php
				if($rows_menu){
					foreach($rows_menu as $row_menu){
				?>
                    <p>Name: <?php echo $row_menu['name'] ?></p>                    
	                <p>Description: <?php echo $row_menu['description'] ?></p>
                    <?php
					$stmt_cat = $conn->prepare("SELECT * FROM category WHERE id=:id");

					$stmt_cat->execute(array(
						':id' => $row_menu['category_id'] 

					));
	
					$rows_cat = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);
					
					if($rows_cat){
						foreach($rows_cat as $cat){
					?>
                    	<p>Category: <?php echo $cat['name'] ?></p> 
                    <?php
						}
					}
					
					$stmt_user_cat = $conn->prepare("SELECT * FROM admin WHERE id=:id");

					$stmt_user_cat->execute(array(
						':id' => $row_menu['created_by'] 
					));
	
					$rows_user_cat = $stmt_user_cat->fetchAll(PDO::FETCH_ASSOC);
					
					if($rows_user_cat){
						foreach($rows_user_cat as $row_user_cat){
					?>
                    		<p>Created By: <?php echo $row_user_cat['firstname'].' '.$row_user_cat['lastname'] ?></p>
                    <?php
						}
					}
					?>                                  
                <?php
					}
				}else{
				?>
                	<p>No Data Available</p> 
                <?php
				}
				?>
                </div>
            </li>
        </ul>
        <ul id="column2" class="column">
            <li class="widget color-red">
                <div class="widget-head">
                    <h3>Lifetime Total Sales</h3>
                </div>
                <div class="widget-content" style="background:#FFF;">
                    <p class="dashboard-single-text"><?php echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($total_sales); ?></p>
                </div>
            </li>
            <li class="widget color-green">  
                <div class="widget-head">
                    <h3>Charts</h3>
                </div>
                <div class="widget-content" style="background:#FFF;">
                	<input type="button" class="form-submit" id="interval_bar" style="margin-top:5px;" value="STOP">
                    <label style="float:right; font-weight:bold; color:#F00;">Options<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#8595; </label>
                    <div id="sales_chart" style="min-width: 300px; height: 400px;"></div>
                </div>
            </li>
        </ul>

        <ul id="column3" class="column">
            <li class="widget color-red">
                <div class="widget-head">
                    <h3>Best 5 Sale Product Of The Month</h3>
                </div>
                <div class="widget-content">
                <?php
				if(isset($rows_sales2)){
					foreach($rows_sales2 as $row_sales2){
				?>
                    <p><?php echo $row_sales2['name']; ?></p>
                <?php
					}
				}else{
				?>
                	<p>No Data Available</p>
                <?php
				}
				?>
                </div>
            </li>
            <li class="widget color-white">
                <div class="widget-head">
                    <h3>Average Sales</h3>
                </div>
                <div class="widget-content" style="background:#FFF;">
                <?php
				if($cnt==0 || $total_sales==0){
				?>
                	<p class="dashboard-single-text"><?php echo PetroFDS::get_currency().'0.00'; ?></p>
                <?php
				}else{
				?>
                    <p class="dashboard-single-text"><?php echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($total_sales/$cnt); ?></p>
                <?php
				}
				?>
                </div>
            </li>
            <li class="widget color-yellow">  
                <div class="widget-head">
                    <h3>Last 5 Orders Information</h3>
                </div>
                <div class="dashboardTable" style="color:#FFF;">
                
                <table >
                    <tr>
                        <td style="text-align:left;">
                            Customer Name
                        </td>
                        <td>
                            Grand Total
                        </td>
                        <td>
                            Status
                        </td>
                    </tr>
                <?php
				if(isset($rows_order)){
					foreach($rows_order as $order){
				?>
            		<tr>
                	<?php
					$stmt_user = $conn->prepare("SELECT * FROM users WHERE id=:id");

					$stmt_user->execute(array(
						':id' => $order['user_id'] 
					));
	
					$rows_user = $stmt_user->fetchAll(PDO::FETCH_ASSOC);
					
					if($rows_user){
						foreach($rows_user as $row_user){
					?>
                    
                        <td >
                            <?php echo $row_user['firstname'].''.$row_user['lastname'] ?>
                        </td>
                    <?php
						}
					}
					$stmt_price = $conn->prepare("SELECT DISTINCT order_detail_id, price_all FROM `orders` WHERE order_detail_id=:id");

					$stmt_price->execute(array(

						':id' => $order['id'] 
					));
	
					$rows_price = $stmt_price->fetchAll(PDO::FETCH_ASSOC);
					
					if($rows_price){
						$gr_total='';
						foreach($rows_price as $row_price){
						$gr_total += $row_price['price_all'];	
					?>                    
	                <td>
						<?php echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($gr_total) ?>                    
                    </td>
                    <?php
						}
					}
					?>
                    <td>
					<?php 
					if($order['status']==0){
						echo '<span>Pending</span>';
					}else if($order['status']==1){
						echo '<span>Accepted</span>';
					}else if($order['status']==2){
						echo '<span>Delivered</span>';
					}else if($order['status']==3){
						echo '<span>Decline</span>';
					} 
					?>
                    </td> 

                <?php
					}
				}else{
				?>
                	<p>No Data Available</p> 
                <?php
				}
				?>
                </tr>
                </table>
            </div>
            </li>
        </ul>
    </div>
    <div id="columns">
    	<ul id="column2" class="column_full">
        <li class="widget color-red">
            <div class="widget-head">
                <h3>Sales By Date</h3>
            </div>
            <div class="widget-content" style="background:#FFF;">
            	<label style="float:right; font-weight:bold; color:#F00;">Options<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#8595; </label>
                <div id="sales_by_date"></div>
            </div>
        </li>
        </ul>
    </div>
    
    <script type="text/javascript" src="../js/jquery-1.2.6.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui-personalized-1.6rc2.min.js"></script>
    <script type="text/javascript" src="../js/inettuts.js"></script>
    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/petrojs-1.0.0.min.js"></script>
    <script type="text/javascript" src="../chart_js/highcharts.js"></script>
	<script type="text/javascript" src="../chart_js/modules/exporting.js"></script>
	<script type="text/javascript" src="dashboard.js"></script>