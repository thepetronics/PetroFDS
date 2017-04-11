<?php

session_start();

include_once '../../app/themes/lib/system.lib.php';

PetroFDS::SetTimeZone();



$date = date('Y-m-d');

$time = PetroFDS::ftime(PetroFDS::get_today_times('website_close'),12);



$now = new DateTime();

$future_date = new DateTime($date.' '.$time);



$interval = $future_date->diff($now);



if(PetroFDS::getWebsiteStatus() == 'Success'){

	echo $interval->format("%h hours, %i minutes, %s seconds");

}else{

	echo "Store is Closed Now.";

}