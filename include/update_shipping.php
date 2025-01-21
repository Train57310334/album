<?php 
$dateNow = date("Y-m-d H:i:s");
$arrs = array();
$mode = $_POST['mode'];
if($mode == 'address'){
    $get = $pdo->prepare("SELECT * FROM `shipping_address` WHERE `user_id`=?");
    $get->bindValue(1, $_SESSION['id_user']);
    $get->execute();
    $mode = "INSERT INTO";
    $another = 1;
    $where = '';
    if(empty($_POST['another'])){
        $another = 0;
    }
    if($get->rowCount()){
        $mode = "UPDATE";
        $where = " WHERE `user_id`= ".$_SESSION['id_user'].";";
    } 
                    
    $stm = $pdo->prepare("".$mode." `shipping_address` SET `Firstname`=?, `Lastname`=?, `Address`=?, 
                            `Province`=?,`Zipcode`=?,`Phone`=?,`email`=?, `another`=?,`another_address`=?, `user_id`=? ".$where."");
    $stm->bindValue(1, $_POST['first']);
    $stm->bindValue(2, $_POST['last']);
    $stm->bindValue(3, $_POST['Address']);
    $stm->bindValue(4, $_POST['province']);
    $stm->bindValue(5, $_POST['zipcode']);
    $stm->bindValue(6, $_POST['phone']);
    $stm->bindValue(7, $_POST['email']);
    $stm->bindValue(8, $another);
    $stm->bindValue(9, $_POST['another_address']);
    $stm->bindValue(10, $_SESSION['id_user']);
    $stm->execute();

    $data['success'] = "Success.";
    array_push($arrs, $data);
    echo json_encode($arrs);
} else if ($mode == 'payment') {
    include( "../config/connection.php");
    session_start();
    $status = 1; //Not paid
    $confirm = 1;
    $dateNow = date("Y-m-d H:i:s");
    if(empty($_POST['confirm'])){
        $confirm = 0;
    }
    $uploadOk = 0;
    if(!empty($_FILES["fileToUpload"]["name"])){
        $target_dir = "../uploads/premise/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $file = ",`premise`='".$_FILES["fileToUpload"]["name"]."'";
        if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
            $uploadOk = 1;
        }
    }
    
    if($uploadOk){
        $get = $pdo->prepare("SELECT * FROM `shipping_address` WHERE `user_id`=?");
        $get->bindValue(1, $_SESSION['id_user']);
        $get->execute();
        if($get->rowCount()){
            $fetch = $get->fetch();
            $refOrderId = "ID".$_SESSION['id_user'].generateRandomString();
            $shipping = $pdo->prepare("INSERT INTO `shipping` SET `user_id`=?, `address_id`=?, `status`=?, `another`=?, `reference_order_id`=? ".$file."");
            $shipping->bindValue(1, $_SESSION['id_user']);
            $shipping->bindValue(2, $fetch['id']);
            $shipping->bindValue(3, $status);
            $shipping->bindValue(4, $fetch['another']);
            $shipping->bindValue(5, $refOrderId);
            $shipping->execute();
            $lastID = $pdo->lastInsertId();

            if(count($_POST['store_id']) > 0) {
                for ($i=0; $i < count($_POST['store_id']); $i++) { 
                    $stm = $pdo->prepare("INSERT INTO `order_album_history` SET `store_id`=?, `user_id`=?, `amount`=?,`qty`=?, `date_time`=?, `ship_id`=?, `price`=?, `cover_size`=?  ");
                    $stm->bindValue(1, $_POST['store_id'][$i]);
                    $stm->bindValue(2, $_SESSION['id_user']);
                    $stm->bindValue(3, $_POST['amount'][$i]);
                    $stm->bindValue(4, $_POST['qty'][$i]);
                    $stm->bindValue(5, $dateNow);
                    $stm->bindValue(6, $lastID);
                    $stm->bindValue(7, $_POST['price'][$i]);
                    $stm->bindValue(8, $_POST['cover_size'][$i]);
                    $stm->execute();

                    $stm = $pdo->prepare("DELETE FROM `order_album` WHERE `order_id`=?");
                    $stm->bindValue(1, $_POST['order_id'][$i]);
                    $stm->execute();
                }
            }
            header("Location: /aroma?page=confirmation&id=".$lastID."");
        } else {
            header("Location: /aroma?page=checkout&reject=1");
        }
    }
    
}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}



