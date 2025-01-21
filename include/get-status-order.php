<?php 

$value = $_REQUEST['value'];
$arrs = array();

$stm = $pdo->prepare("  SELECT status AS status_id
                        FROM `shipping` 
                        WHERE `reference_order_id` LIKE '".$value."' ");
$stm->bindValue(1, $value);
$stm->execute();
while($listItem = $stm->fetch()){
    array_push($arrs, $listItem);
}

echo json_encode($arrs);