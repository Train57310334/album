<?php 

$dateNow = date("Y-m-d H:i:s");
$arrs = array();
$mode = $_POST['mode'];
if($mode == "insert"){
    if(isset($_POST['store_id'])){
        $amountStore = calItemStore($pdo, $_POST['store_id'], $_POST['qty']);
        if($amountStore){
            $stm = $pdo->prepare("INSERT INTO `order_album` SET `store_id`=?, `user_id`=?, cover_size=?, `amount`=?, `qty`=?, `date_time`=?");
            $stm->bindValue(1, $_POST['store_id']);
            $stm->bindValue(2, $_SESSION['id_user']);
            $stm->bindValue(3, $_POST['size']);
            $stm->bindValue(4, $_POST['amountImages']);
            $stm->bindValue(5, $_POST['qty']);
            $stm->bindValue(6, $dateNow);
            $stm->execute();
            $data['success'] = "Already add to your cart.";
        } else {
            $data['msg'] = "Amount product not enough.";
        }
        
    }
} else if($mode == 'update'){
    $stm = $pdo->prepare("SELECT * FROM `order_album` OA 
                          INNER JOIN store_album SA ON (SA.store_id=OA.store_id)
                          WHERE OA.`user_id` = ?;");
    $stm->bindValue(1, $_SESSION['id_user']);
    $stm->execute();
    $item_list = array();
    $old_item = '';
    while($order = $stm->fetch()){
        $qty = $_POST['qty'][$order['order_id']];
        if($qty != $order['qty']){
            $amountStore = calItemStore($pdo, $order['store_id'], $qty);
            if($amountStore){
                $update = $pdo->prepare("UPDATE `order_album` SET `qty`=".$qty.", `date_time`='".$dateNow."' WHERE `order_id`=".$order['order_id'].";");
                $update->execute();
            } else {
                if($order['store_id'] != $old_item){
                    array_push($item_list,$order['item_name']);
                    $old_item = $order['store_id'];
                }
                
            }
        }
    }
    $data['success'] = "Product list with payment.";
    if(!empty($item_list)){
        $data['msg'] = "Amount product:".implode(",",$item_list)." not enough.";
    }
} else if ($mode == 'delete') {
    $get = $pdo->prepare('  SELECT SA.amount,OA.store_id
                            FROM order_album OA
                            INNER JOIN store_album SA ON (OA.store_id=SA.store_id)
                            WHERE order_id=?');
    $get->bindValue(1, $_POST['id']);
    $get->execute();
    $order = $get->fetch();
    
    $total = $order['amount'] + $_POST['qty'];

    $update = $pdo->prepare('UPDATE store_album SET `amount`=? WHERE store_id=?');
    $update->bindValue(1, $total);
    $update->bindValue(2, $order['store_id']);
    $update->execute();
    
    $del = $pdo->prepare('DELETE FROM order_album WHERE order_id=?');
    $del->bindValue(1, $_POST['id']);
    $del->execute();
    $data['success'] = 'Deleted';
}
function calItemStore($pdo, $store_id, $amount){
    $get = $pdo->prepare("SELECT * FROM `store_album` WHERE `store_id`=?");
    $get->bindValue(1, $store_id);
    $get->execute();
    $store = $get->fetch();
    $boolean = false;
    if($store['amount'] > 0){
        $result = $store['amount'] - $amount;
        if($result >= 0){
            $update = $pdo->prepare("UPDATE `store_album` SET `amount`=".$result." WHERE `store_id`=".$store_id."");
            $update->execute();
            $boolean = true;
        }
    }
    return $boolean;
}

array_push($arrs, $data);
echo json_encode($arrs);