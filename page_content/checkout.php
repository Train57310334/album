<?php
    $qty = 0;
    if(isset($_SESSION['id_user'])){
      $stm = $pdo->prepare("SELECT OA.*,SA.item_name,SA.price,SA.images
                            FROM `order_album` OA
                            INNER JOIN `store_album` SA ON (SA.store_id=OA.store_id)
                            WHERE OA.`user_id` = ?;");
      $stm->bindValue(1, $_SESSION['id_user']);
      $stm->execute();
      $count = $pdo->prepare("SELECT count(*) AS total FROM `order_album` OA WHERE OA.`user_id` = ?;");
      $count->bindValue(1, $_SESSION['id_user']);
      $count->execute();
      $count = $count->fetch();
      $qty = $count['total'];

      $shipping = $pdo->prepare("SELECT *
                            FROM `shipping_address` 
                            WHERE `user_id` = ?;");
      $shipping->bindValue(1, $_SESSION['id_user']);
      $shipping->execute();
      $shipping = $shipping->fetch();
    }
    if(isset($_GET['reject'])){
      echo "<script type='text/javascript'>alert('Please specify the delivery location.');</script>";
    }
  ?>
<script>
    var id = "<?=$shipping['id']?>";
    var another = "<?=$shipping['another']?>";
    if(another == '1'){   
        setTimeout(function(){ $("#another").prop("checked", true); 
        }, 100);
    }
    
    if(id == ''){
        setTimeout(function(){ editForm(); }, 100);
    }

    function updateShipping() {
      $.ajax({
          url:'config/perform_function.php?d=include&f=update_shipping.php',
          type:'post',
          data: $('#shippingForm').serialize(),
          dataType:"json"
      })
      .done(function( response ) {
          if(response[0].msg){
            alert(response[0].msg);
          }
          if (response[0].success) {
              alert(response[0].success);
              window.location.href = "?page=checkout";
          }
      });
  }

</script>
  <!--================Checkout Area =================-->
  <section class="checkout_area section-margin--small">
    <div class="container">
      <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-5">
          <div class="sidebar-categories">
            <div class="head">Welcome</div>
            <ul class="main-categories">
              <aside class="single_sidebar_widget author_widget">
                          <img class="author_img rounded-circle" src="<?=$_SESSION['image']?>" alt="" height="120" width="120">
                          <h4>Username : <?=$_SESSION['username']?></h4>
                          <p>Email : <?=$_SESSION['email']?><br ></p>
                          <div class="br"></div>
                      </aside>
            </ul>
          </div>
          <div class="sidebar-filter">
            <div class="top-filter-head">Photobook</div>
            <div class="common-filter">
              
              <form action="#">
                <ul>
                  <li class="nav-item"><a class="nav-link" href="?page=product-list">รายการสินค้า</a></li>
                  <li class="nav-item"><a class="nav-link" href="?page=thankyou">สถานะสินค้า</a></li>
                  <li class="nav-item"><a class="nav-link" href="?page=contact">ติดต่อเรา</a></li>
                </ul>
              </form>
            </div>
           
            <div class="common-filter">
              <div class="price-range-area">
              <a class="button button--active mt-3 mt-xl-4" href="index.html">ออกจากระบบ</a>
                
              </div>
            </div>
          </div>
        </div>
      <div class="col-xl-9 col-lg-8 col-md-7">
        
        <div class="billing_details">
            <div class="row">
                <div class="col-lg-8">
                    <h2>ที่อยู่สำหรับจัดส่ง</h2>
                    <form  method="post" class="row contact_form" id="shippingForm" onsubmit="updateShipping(); return false;">
                        <input type="hidden" name="mode" value="address">
                        <div class="col-md-6 form-group p_star">
                            <label for="firstname">Firstname: </label>
                            <label class="info-form"><?=$shipping['Firstname']?></label>
                            <input type="text" class="form-control edit-form" id="first" name="first" value="<?=$shipping['Firstname']?>">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label for="Lastname">Lastname: </label>
                            <label class="info-form"><?=$shipping['Lastname']?></label>
                            <input type="text" class="form-control edit-form" id="last" name="last" value="<?=$shipping['Lastname']?>">
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <label for="Address">Address: </label>
                            <label class="info-form"><?=$shipping['Address']?></label>
                            <textarea name="Address" id="address" cols="30" rows="10" class="form-control edit-form"><?=$shipping['Address']?></textarea>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label for="phone">Phone: </label>
                            <label class="info-form"><?=$shipping['Phone']?></label>
                            <input type="text" class="form-control edit-form" id="phone" name="phone" value="<?=$shipping['Phone']?>">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label for="email">Email: </label>
                            <label class="info-form"><?=$shipping['email']?></label>
                            <input type="email" class="form-control edit-form" id="email" name="email" value="<?=$shipping['email']?>">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label for="province">Province: </label>
                            <label class="info-form"><?=$shipping['Province']?></label>
                            <input type="text" class="form-control edit-form" id="province" name="province" value="<?=$shipping['Province']?>" >
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label for="zipcode">Zipcode: </label>
                            <label class="info-form"><?=$shipping['Zipcode']?></label>
                            <input type="text" class="form-control edit-form" id="zipcode" name="zipcode" value="<?=$shipping['Zipcode']?>">
                        </div>  
                        <div class="col-md-12 form-group mb-0">
                            <div class="creat_account">
                                <h3>รายละเอียดการส่งสินค้า</h3>
                                <input type="checkbox" id="another" name="another" disabled="disabled">
                                <label for="f-option3">จัดส่งไปยังที่อยู่อื่น?</label>
                            </div>
                            <textarea class="form-control" name="another_address" id="another_address" rows="1" placeholder="ที่อยู่อื่นสำหรับการจัดส่ง" disabled="disabled"><?=$shipping['another_address']?></textarea>
                        </div>
                        <div class="common-filter">
                                <div class="price-range-area">
                                    <input type="submit" name="save" id="save"
                                        class="button button--active mt-3 mt-xl-4 edit-form" value="Save">
                                    <input type="button" name="edit" id="edit-form" class="button button--active mt-3 mt-xl-4 info-form" value="Edit" onclick="editForm();">
                                </div>
                            </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <div class="order_box">
                    <form action="include/update_shipping.php" method="post"  id="shippingFormPayment"  enctype="multipart/form-data">
                      <input type="hidden" name="mode" value="payment">
                        <h2>สินค้าของคุณ</h2>
                        <ul class="list">
                            <li><a href="#"><h4>สินค้า <span>รวม</span></h4></a></li>
                            <?php
                                $summary = 0;
                                while($item = $stm->fetch()){
                                    echo "<input type='hidden' name='order_id[]' value='".$item['order_id']."'>
                                          <input type='hidden' name='store_id[]' value='".$item['store_id']."'>
                                          <input type='hidden' name='amount[]' value='".$item['amount']."'>
                                          <input type='hidden' name='qty[]' value='".$item['qty']."'>
                                          <input type='hidden' name='price[]' value='".$item['price']."'>
                                          <input type='hidden' name='cover_size[]' value='".$item['cover_size']."'>";
                                    if($item['cover_size'] == 1){
                                      $total = ($item['price'] * $item['amount']) * $item['qty']; // 8*8 
                                    } else {
                                      $total = (($item['price'] * $item['amount']) * $item['qty'] ) + 200; // 11*8.5
                                    }
                                    $summary = $summary + $total;
                                    echo '<li><a href="#">'.$item['item_name'].'<span class="middle" style="margin-left:30px;">x'.$item['qty'].'</span> <span class="last">'.$total.'฿</span></a></li>';
                                }
                            ?>
                        </ul>
                        <ul class="list list_2">
                            <li><a href="#">ยอดรวม <span><?=$summary?>฿</span></a></li>
                            <li><a href="#">จัดส่งฟรี <span>00.00฿</span></a></li>
                            <li><a href="#">รวม <span><?=$summary?>฿</span></a></li>
                        </ul>
                        <div class="payment_item">
                            <div class="radion_btn">
                                <input type="radio" id="transfer" name="transfer" value="transfer">
                                <label for="transfer">โอนเข้าบัญชีธนาคาร</label>
                                <div class="check"></div>
                            </div>
                            <p>ชื่อบัญชี: ธฤดี อภิชาตวาณิช <br >
                            พร้อมเพย์ 081-903-6712</p>
                        </div>
                        
                        <div class="creat_account">
                            <label for="file" style="padding:0;">โปรดแนบไฟล์ประกอบการชำระเงิน</label>
                            <input type="file" name="fileToUpload" id="fileToUpload" style="font-size:12px;padding-bottom:10px;">
                            <input type="checkbox" id="confirm" name="confirm" required>
                            <label for="confirm">ฉันได้อ่านและยอมรับ </label>
                            <a href="#">ข้อกำหนดและเงื่อนไข</a>
                        </div>
                        <div class="text-center">
                        <input type="submit" name="payment" id="payment" class="button button--active mt-3 mt-xl-4" value="Payment">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>
  <!--================End Checkout Area =================-->
