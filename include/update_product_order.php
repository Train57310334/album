<?php 
$dateNow = date("Y-m-d H:i:s");
$arrs = array();
$mode = $_POST['mode'];
if($mode == 'get'){
    $get = $pdo->prepare("  SELECT SA.* , AC.Cover_Type, CS.* 
                            FROM `store_album` SA
                            INNER JOIN album_cover AC ON (AC.id_Album_Cover=SA.id_Album_Cover)
                            INNER JOIN cover_size CS ON (CS.cover_id=SA.cover_size)
                            WHERE SA.`store_id`=?");
    $get->bindValue(1, $_POST['id']);
    $get->execute();
    $fetch = $get->fetch();
    array_push($arrs, $fetch);
    echo json_encode($arrs);
} else if ($mode == 'delete') {
    $del = $pdo->prepare('DELETE FROM store_album WHERE store_id=?');
    $del->bindValue(1, $_POST['id']);
    $del->execute();
    $data['success'] = 'Deleted';
    array_push($arrs, $data);
    echo json_encode($arrs);
} else if($mode == 'save') {
    include( "../config/connection.php");
    session_start();
    if(!empty($_FILES["fileToUpload"]["name"])){
        $target_dir = "../uploads/store-item/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $file = ",`images`='".$_FILES["fileToUpload"]["name"]."'";
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    }

    $get = $pdo->prepare("SELECT * FROM `store_album` WHERE `store_id`=?");
    $get->bindValue(1, $_POST['store_id']);
    $get->execute();
    $sqlMode = "INSERT INTO";
    $where = '';
    $cover = $_POST['cover'];
    $softCover = 0;
    $hardCover = 0;
    if ($cover == 1) {
        $softCover = 1;
    } else if ($cover == 2) {
        $hardCover = 1;
    }
    if($get->rowCount()){
        $sqlMode = "UPDATE";
        $where = " WHERE `store_id`= ".$_POST['store_id'].";";
    }
    $stm = $pdo->prepare("".$sqlMode." `store_album` SET `item_name`=?, `id_Album_Cover`=?, `soft_cover`=?, 
                        `hard_cover`=?,`cover_size`=?,`amount`=?,`price`=? ".$file.$where."");
    $stm->bindValue(1, $_POST['itemName']);
    $stm->bindValue(2, $_POST['coverType']);
    $stm->bindValue(3, $softCover);
    $stm->bindValue(4, $hardCover);
    $stm->bindValue(5, $_POST['size']);
    $stm->bindValue(6, $_POST['amount']);
    $stm->bindValue(7, $_POST['price']);
    $stm->execute();

    header("Location: /aroma?page=product-list");
}
