<?php 

$cover_type = '';
$value = $_REQUEST['value'];
$status_id = $_REQUEST['status'];
$status = '';
$arrs = array();
if ($status_id){
    $status = "AND S.status = '".$status_id."'";
}

$stm = $pdo->prepare("  SELECT S.*,SS.status,U.Username,OA.qty,OA.amount,OA.cover_size,OA.price,S.status AS status_id,
                            CONCAT(SB.item_name,' album:',OA.qty,' x',OA.amount,' ',CS.size,' ',OA.price,'฿') AS detail, OA.date_time,
                            CONCAT(SA.Firstname,' ',SA.Lastname,' ',SA.Address,' ',SA.Province,' ',SA.Zipcode,' ',SA.email,' ',SA.Phone) AS address,
                            SA.another, SA.another_address
                        FROM `shipping` S
                        INNER JOIN user U ON (U.user_id=S.user_id)
                        INNER JOIN shipping_address SA ON (S.address_id=SA.id)
                        INNER JOIN shipping_status SS ON (S.status=SS.id)
                        INNER JOIN order_album_history OA ON (OA.ship_id=S.ship_id)
                        INNER JOIN store_album SB ON (OA.store_id=SB.store_id)
                        INNER JOIN cover_size CS ON (CS.cover_id=OA.cover_size)
                        WHERE (U.`Username` LIKE '%".$value."%' OR S.`reference_order_id` LIKE '%".$value."%')  ".$status." ORDER BY S.ship_id ASC");

$stm->execute();
$arr_itemName = array();
$arrs_itemName = array();
$arr_ship = array();
$old_ship_id = '';
$i=0;
$j=0;
while($listItem = $stm->fetch()){
    $ship_id = $listItem['ship_id'];
    $username = $listItem['Username'];
    $detail = $listItem['detail'];
    $premise = $listItem['premise'];
    $qty = $listItem['qty'];
    $amount = $listItem['amount'];
    $cover_size = $listItem['cover_size'];
    $price = $listItem['price'];
    $status = $listItem['status'];
    $status_id = $listItem['status_id'];
    $address = $listItem['address'];
    $another = $listItem['another'];
    $another_address = $listItem['another_address'];
    $date_time = $listItem['date_time'];
    $reference_order_id = $listItem['reference_order_id'];

    if ($ship_id != $old_ship_id) {
        $i=0;
        $j++;
    } else {
        $i++;
    }

    $val[$j]['detail'][$i] =  $detail;
    $val[$j]['ship_id'] =  $ship_id;
    $val[$j]['premise'] = $premise;
    $val[$j]['username'] = $username;
    $val[$j]['qty'] = $qty;
    $val[$j]['amount'] = $amount;
    $val[$j]['cover_size'] = $cover_size;
    $val[$j]['price'] = $price;
    $val[$j]['status'] = $status;
    $val[$j]['status_id'] = $status_id;
    $val[$j]['address'] = $address;
    $val[$j]['another'] = $another;
    $val[$j]['another_address'] = $another_address;
    $val[$j]['date_time'] = $date_time;
    $val[$j]['reference_order_id'] = $reference_order_id;
    $old_ship_id = $listItem['ship_id'];

}
$val['count'] = $j;
array_push($arrs, $val);
echo json_encode($arrs);