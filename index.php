<?php 
include( "config/connection.php");
ob_start();
session_start();
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL); 

$page_arr = array(
	'home',
	'product-list',
	'login',
	'logout',
	'register',
	'profile',
	'product-detail',
	'cart',
	'checkout',
	'contact',
	'confirmation',
	'thankyou'
);

$allow_page = array(
	'store-list',
	'order-product-list',
	'report'
);

$page_NoLogin = array(
	'home',
	'register',
	'login',
	'contact'
);

$usergroup = 2; // default customer
if (isset($_SESSION['usergroup'])) {
	$usergroup = $_SESSION['usergroup'];
}
// Include header
include_once("page_content/header.php");

include_once("page_content/menu.php");
if(isset($_GET['page'])) {
  if(in_array($_GET['page'],$page_arr)) { // customer
	  if(isset($_SESSION['id_user'])) {
		  $page_content = $_GET['page'];
	  } else {
		$page_content = 'login';
		if (in_array($_GET['page'], $page_NoLogin)){
			$page_content = $_GET['page'];
		}
	  }
  } else if ($usergroup == 1 && in_array($_GET['page'],$allow_page)) { // admin
	$page_content = $_GET['page'];
  } else { //author
    $page_content = 'home';
  }
} else {
  $page_content = 'home';
}

$folder_page = 'page_content';
if ($usergroup == 1 && in_array($_GET['page'],$allow_page)	) { //admin
	$folder_page = 'admin';
}

$page_content_inc = $folder_page.'/'.$page_content;


// include body
if(file_exists($page_content_inc.'.php')){
  include_once($page_content_inc.".php");
}
  
// include footer
include_once("page_content/footer.php");

?>