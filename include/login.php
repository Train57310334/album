<?php 
$arrs = array();
if ($_POST['password'] && $_POST['username']) {
	$mypassword = md5($_POST['password']);
	$stm = $pdo->prepare("SELECT * 
							From user 
							LEFT JOIN profile ON User_id_User = user_id 
							Where Username=? AND Password=?;");
	$stm->bindValue(1, $_POST['username']);
	$stm->bindValue(2, $mypassword);
	$stm->execute();
	$user = $stm->fetch();
	$dbpassword = $user['Password'];
	if ($mypassword == $dbpassword) {
		$data['usergroup'] = $user['User_Group_id_User_Group'];
		$_SESSION['usergroup'] = $user['User_Group_id_User_Group'];
		$_SESSION['id_user'] = $user['user_id'];
		$_SESSION['username'] = $user['Username'];
		$_SESSION['email'] = $user['email'];
		$_SESSION['image'] = "uploads/".$user['image'];
		
	} else {
		$data['error'] = "Invalid username or password, please try again.";
	}
}
array_push($arrs, $data);
echo json_encode($arrs);
// echo $data;


