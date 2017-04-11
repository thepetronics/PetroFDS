<?php 
	session_start();
	
	unset($_SESSION['LOGIN_USER_ID']);
	unset($_SESSION['LOGIN_USER_FULLNAME']);
	unset($_SESSION['LOGIN_USER_FIRSTNAME']);
	unset($_SESSION['LOGIN_USER_LASTNAME']);
	unset($_SESSION['COUPON_CODE']);
	unset($_SESSION['COUPON_CODE_PRICE']);
	
	header('Location:../../index');
?>