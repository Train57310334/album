<?php 
include( "config/connection.php");
session_start();

if ( !isset($_SESSION['id_user']) && !$_SESSION['id_user']>0 ) {
	header( "location: /aroma/login.php" );
}

$stm = $pdo->prepare("SELECT * FROM `profile` WHERE `User_id_User`= ?;");
$stm->bindValue(1, $_SESSION['id_user']);
$stm->execute();
$profile = $stm->fetch();

$stm = $pdo->prepare("UPDATE `profile` 
SET `Firstname`=?,`Lastname`=?,`Address`=?,`Province`=?,`Zipcode`=?,`Phone`=?,`Email`=? 
WHERE `User_id_User`= ?;");
$isUpdate = false;
if ( isset($_POST['Firstname']) ) {
  $stm->bindValue(1, $_POST['Firstname']);
  $isUpdate = true;
} else {
  $stm->bindValue(1, $profile['Firstname']);
}

if ( isset($_POST['Lastname']) ) {
  $stm->bindValue(2, $_POST['Lastname']);
  $isUpdate = true;
} else {
  $stm->bindValue(2, $profile['Lastname']);
}

if ( isset($_POST['Address']) ) {
  $stm->bindValue(3, $_POST['Address']);
  $isUpdate = true;
} else {
  $stm->bindValue(3, $profile['Address']);
}

if ( isset($_POST['Province']) ) {
  $stm->bindValue(4, $_POST['Province']);
  $isUpdate = true;
} else {
  $stm->bindValue(4, $profile['Province']);
}

if ( isset($_POST['Zipcode']) ) {
  $stm->bindValue(5, $_POST['Zipcode']);
  $isUpdate = true;
} else {
  $stm->bindValue(5, $profile['Zipcode']);
}

if ( isset($_POST['Phone']) ) {
  $stm->bindValue(6, $_POST['Phone']);
  $isUpdate = true;
} else {
  $stm->bindValue(6, $profile['Phone']);
}

if ( isset($_POST['Email']) ) {
  $stm->bindValue(7, $_POST['Email']);
  $isUpdate = true;
} else {
  $stm->bindValue(7, $profile['Email']);
}
$stm->bindValue(8, $_SESSION['id_user']);

if ($isUpdate){
  $stm->execute();
  
  $stm = $pdo->prepare("SELECT * FROM `profile` WHERE `User_id_User`= ?;");
  $stm->bindValue(1, $_SESSION['id_user']);
  $stm->execute();
  $profile = $stm->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">

<!--================ Start Header Menu Area =================-->
<?php include("layout/menu-admin.php") ?>

  <main class="site-main">
	<!--================ End Header Menu Area =================-->

<body>
    <!--================ Start Header Menu Area =================-->
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Aroma Shop - Admin</title>
        <link rel="icon" href="img/Fevicon.png" type="image/png">
        <link rel="stylesheet" href="vendors/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="vendors/fontawesome/css/all.min.css">
        <link rel="stylesheet" href="vendors/themify-icons/themify-icons.css">
        <link rel="stylesheet" href="vendors/nice-select/nice-select.css">
        <link rel="stylesheet" href="vendors/owl-carousel/owl.theme.default.min.css">
        <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css">

        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
       

        <!-- ================ category section start ================= -->
        <section class="section-margin--small mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-5">
                        <div class="sidebar-categories">
                            <div class="head">Admin</div>
                            <ul class="main-categories">
                                <aside class="single_sidebar_widget author_widget">

                                    <h4>Username : <?= $_SESSION['username'] ?></h4>
                                    <p>Email : <?= $profile['Email']; ?></p>
                                    <div class="br"></div>
                                </aside>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-9 col-lg-8 col-md-7">
                        <form action="" method="post">
                            <h3>
                                <center>ข้อมูลสมาชิก</center>
                            </h3><br>

                            <div class="col-md-12 form-group">
                                <label for="username">username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Username" value="<?=$_SESSION['username']?>" disabled>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6" style="float:left">
                                    <label for="firstname">ชื่อ</label>
                                    <input type="text" class="form-control" id="firstname" name="Firstname"
                                        placeholder="ชื่อ" value="<?= $profile['Firstname']; ?>" >
                                </div>
                                <div class="col-md-6" style="float:left">
                                    <label for="lastname">นามสกุล</label>
                                    <input type="text" class="form-control" id="lastname" name="Lastname"
                                        placeholder="นามสกุล" value="<?= $profile['Lastname']; ?>" >
                                </div>
                                <div style="clear:both"></div>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="address">ที่อยู่</label>
                                <textarea name="Address" id="address" cols="30" rows="10" class="form-control"><?= $profile['Address']; ?></textarea>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6" style="float:left">
                                    <label for="province">จังหวัด</label>
                                    <input type="text" class="form-control" id="province" name="Province"
                                        placeholder="จังหวัด" value="<?= $profile['Province']; ?>" >
                                </div>
                                <div class="col-md-6" style="float:left">
                                    <label for="zipcode">รหัสไปรษณีย์</label>
                                    <input type="text" class="form-control" id="zipcode" name="Zipcode"
                                        placeholder="รหัสไปรษณีย์" value="<?= $profile['Zipcode']; ?>">
                                </div>
                                <div style="clear:both"></div>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="Phone">เบอร์โทรศัพท์</label>
                                <input name="Phone" type="text" id="Phone" class="form-control"
                                    placeholder="เบอร์โทรศัพท์"  value="<?= $profile['Phone']; ?>"required>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="email">Email</label>
                                <input name="Email" type="email" id="email" class="form-control" placeholder="email"
                                value="<?= $profile['Email']; ?>"required>
                            </div>

                            <div class="common-filter">
                                <div class="price-range-area">
                                    <input type="submit" name="save" id="save"
                                        class="button button--active mt-3 mt-xl-4" value="บันทึกข้อมูล">
                                </div>
                            </div>

                            <tr>
                                <td align="center">&nbsp;</td>
                                <td colspan="3" align="left">
                                </td>
                            </tr>
                        </form>
                    </div>
                </div>


        </section>
        <!-- ================ category section end ================= -->



        <!--================ Start footer Area  =================-->
        <footer class="footer">
            <div class="footer-area">
                <div class="container">
                    <div class="row section_gap">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="single-footer-widget tp_widgets">
                                <h4 class="footer_title large_title">PHOTOBOOK</h4>
                                <p>
                                    เก็บรักษาความทรงจำแสนสุขของคุณด้วยกระดาษคุณภาพเยี่ยมหลากหลายชนิดของเรา
                                    เพื่อความคงทนของรูปภาพสุดพิเศษที่คุณตั้งใจเลือกมาเป็นอย่างดี
                                </p>
                            </div>
                        </div>
                        <div class="offset-lg-1 col-lg-2 col-md-6 col-sm-6">
                            <div class="single-footer-widget tp_widgets">
                                <h4 class="footer_title">Quick Links</h4>
                                <ul class="list">
                                    <li><a href="user-home.html">หน้าแรก</a></li>
                                    <li><a href="#">ข้อมูลพื้นฐาน</a></li>
                                    <li><a href="#">สถานะการสั่งซื้อ</a></li>
                                    <li><a href="#">แจ้งชำระเงิน</a></li>
                                    <li><a href="#">สถานะการชำระเงิน</a></li>
                                    <li><a href="#">สถานะสินค้า</a></li>
                                    <li><a href="#">ออกรายงาน</a></li>

                                </ul>
                            </div>
                        </div>

                        <div class="offset-lg-1 col-lg-3 col-md-6 col-sm-6">
                            <div class="single-footer-widget tp_widgets">
                                <h4 class="footer_title">Contact Us</h4>
                                <div class="ml-40">
                                    <p class="sm-head">
                                        <span class="fa fa-location-arrow"></span>
                                        Head Office
                                    </p>
                                    <p>123, Main Street, Your City</p>

                                    <p class="sm-head">
                                        <span class="fa fa-phone"></span>
                                        Phone Number
                                    </p>
                                    <p>
                                        +123 456 7890 <br>
                                        +123 456 7890
                                    </p>

                                    <p class="sm-head">
                                        <span class="fa fa-envelope"></span>
                                        Email
                                    </p>
                                    <p>
                                        free@infoexample.com <br>
                                        www.infoexample.com
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </footer>
        <!--================ End footer Area  =================-->



        <script src="vendors/jquery/jquery-3.2.1.min.js"></script>
        <script src="vendors/bootstrap/bootstrap.bundle.min.js"></script>
        <script src="vendors/skrollr.min.js"></script>
        <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
        <script src="vendors/nice-select/jquery.nice-select.min.js"></script>
        <script src="vendors/nouislider/nouislider.min.js"></script>
        <script src="vendors/jquery.ajaxchimp.min.js"></script>
        <script src="vendors/mail-script.js"></script>
        <script src="js/main.js"></script>
    </body>

    </html>
    