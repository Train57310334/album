<?php 

$cover_type = '';
$limit = $_REQUEST['limit_row'];
$value = $_REQUEST['value'];
$arrs = array();
if ($_REQUEST['coverType']){
    $cover_type = "AND AC.id_Album_Cover = '".$_REQUEST['coverType']."'";
}
$stm = $pdo->prepare("  SELECT SA.*,AC.Cover_Type
                        FROM `store_album` SA
                        INNER JOIN album_cover AC ON (AC.id_Album_Cover=SA.id_Album_Cover)
                        WHERE `item_name` LIKE '%".$value."%' ".$cover_type." LIMIT 0,".$limit."");
                        
$stm->execute();
while($listItem = $stm->fetch()){
    array_push($arrs, $listItem);
}

echo json_encode($arrs);