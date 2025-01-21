<?php 

include( "../config/connection.php");
session_start();
$stm = $pdo->prepare("SELECT * FROM `profile` WHERE `User_id_User`= ?;");
$stm->bindValue(1, $_POST['user_id']);
$stm->execute();
$profile = $stm->fetch();
$file= '';
$_SESSION['image'] = "img/blog/author.png"; //default image
if(!empty($_FILES["fileToUpload"]["name"])){
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $file = ",image='".$_FILES["fileToUpload"]["name"]."'";
    $_SESSION['image'] = "uploads/".$_FILES["fileToUpload"]["name"];
    if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file));
}

    $mode = "INSERT INTO";
    $where = '';
    if( $stm->rowCount() ){
        $mode = "UPDATE";
        $where = " WHERE `User_id_User`= ".$_POST['user_id'].";";
        
    }

    $stm = $pdo->prepare("".$mode." `profile` 
                            SET `Firstname`=?,`Lastname`=?,`Address`=?,`Province`=?,`Zipcode`=?,`Phone`=? , User_id_User = ? ".$file.$where."");
    $isUpdate = false;
    $stm->bindValue(1, $_POST['Firstname']);
    $stm->bindValue(2, $_POST['Lastname']);
    $stm->bindValue(3, $_POST['Address']);
    $stm->bindValue(4, $_POST['Province']);
    $stm->bindValue(5, $_POST['Zipcode']);
    $stm->bindValue(6, $_POST['Phone']);
    $stm->bindValue(7, $_POST['user_id']);
    $stm->execute();

    header("Location: /aroma?page=profile");