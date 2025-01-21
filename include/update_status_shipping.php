<?php 
$dateNow = date("Y-m-d H:i:s");
$arrs = array();
$mode = $_POST['mode'];
if($mode == 'get'){
    $get = $pdo->prepare("  SELECT S.ship_id, S.status AS status_id ,SS.status
                            FROM `shipping` S
                            INNER JOIN shipping_status SS ON (S.status=SS.id)
                            WHERE S.`ship_id`=?");
    $get->bindValue(1, $_POST['id']);
    $get->execute();
    $fetch = $get->fetch();
    array_push($arrs, $fetch);
    echo json_encode($arrs);
} else if($mode == 'save') {
    include( "../config/connection.php");
    session_start();
    
    $stm = $pdo->prepare("UPDATE `shipping` SET `status`=? WHERE `ship_id`= ".$_POST['ship_id'].";");
    $stm->bindValue(1, $_POST['status']);
    $stm->execute();

    header("Location: /aroma?page=order-product-list");
}
