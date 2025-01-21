<?php 

$arrs = array();
$group_id = 2; //customer
if ( isset($_POST['password']) && isset($_POST['confirmPassword']) && 
		$_POST['password'] != $_POST['confirmPassword']  ) {

	$data['msg'] = "Password does not match";

} else if ( isset($_POST['password']) && isset($_POST['confirmPassword']) ) {
	$duplicate = $pdo->prepare("SELECT * From user Where Username=? OR email=?");
	$duplicate->bindValue(1, $_POST['username']);
	$duplicate->bindValue(2, $_POST['email']);
	$duplicate->execute();
	if ($duplicate->rowCount()) { 
		$data['msg'] = "Someone is already using this username and email";
	} else {
		$stm = $pdo->prepare("INSERT INTO `user` (`Username`, `Password`, `User_Group_id_User_Group`, email) VALUE (?, ?, ?, ?);");
		$stm->bindValue(1, $_POST['username']);
		$stm->bindValue(2, md5($_POST['password']));
		$stm->bindValue(3, $group_id);
		$stm->bindValue(4, $_POST['email']);
		$stm->execute();
		
		$_SESSION['id_user'] = $pdo->lastInsertId();
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['usergroup'] = $group_id;
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['image'] = "img/blog/author.png"; //default image
		$data['success'] = "Register success.";
	}
	
}

array_push($arrs, $data);
echo json_encode($arrs);