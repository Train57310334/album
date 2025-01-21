<?php
  $stm = $pdo->prepare("SELECT * FROM `shipping` WHERE `user_id`= ? AND status != '4'");
  $stm->bindValue(1, $_SESSION['id_user']);
  $stm->execute();
  
?>
  
	<!-- ================ start banner area ================= -->	
	<section class="blog-banner-area" id="category">
		<div class="container h-100">
			<div class="blog-banner">
				<div class="text-center">
					<h1>Thank you for your order</h1>
					<nav aria-label="breadcrumb" class="banner-breadcrumb">
          <?php while($order = $stm->fetch()){?>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Your order id</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?=$order['reference_order_id']?></li>
            </ol>
            <?php } ?>
          </nav>
				</div>
			</div>
    </div>
	</section>
	<!-- ================ end banner area ================= -->
  
  
  <!--================Tracking Box Area =================-->
  <section class="tracking_box_area section-margin--small">
      <div class="container">
          <div class="tracking_box_inner">
              <p>To track your order please enter your Order ID in the box below and press the "Track" button. This
                  was given to you on your receipt and in the confirmation email you should have received.</p>
              <form class="row tracking_form" action="#" method="post" novalidate="novalidate">
                  <div class="col-md-12 form-group">
                      <input type="text" class="form-control" id="order" name="order" placeholder="Order ID" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Order ID'">
                  </div>
                  <div class="col-md-12 form-group status" hidden id="status"></div>
                  <!-- <div class="col-md-12 form-group">
                      <input type="email" class="form-control" id="email" name="email" placeholder="Billing Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Billing Email Address'">
                  </div> -->
                  <div class="col-md-12 form-group">
                      <button type="button" class="button button-tracking" onclick="getStatusOrder($('#order').val());">Track Order</button>
                  </div>
              </form>
          </div>
      </div>
  </section>
  <!--================End Tracking Box Area =================-->



  <!--================Instagram Area =================-->
  <section class="instagram_area">
    <div class="container box_1620">
      <div class="instagram_image row m0">
        <a href="#"><img src="img/instagram/ins-1.jpg" alt=""></a>
        <a href="#"><img src="img/instagram/ins-2.jpg" alt=""></a>
        <a href="#"><img src="img/instagram/ins-3.jpg" alt=""></a>
        <a href="#"><img src="img/instagram/ins-4.jpg" alt=""></a>
        <a href="#"><img src="img/instagram/ins-5.jpg" alt=""></a>
        <a href="#"><img src="img/instagram/ins-6.jpg" alt=""></a>
      </div>
    </div>
  </section>
  <!--================End Instagram Area =================-->
<script>
  function getStatusOrder(value=''){
    var text = '';
      $.ajax({
        url: "config/perform_function.php?d=include&f=get-status-order.php", 
        method: "POST",
        data: { value: value
             },
        dataType:"json"
      })
      .done(function( response ) {
        if(response.length > 0){
          console.log("response[0].status_id",response[0].status_id);
          if(response[0].status_id == '1'){
            text = "Admin กำลังตรวจสอบหลักฐานการชำระเงินของท่านคะ";
          } else if(response[0].status_id == '2'){
            text = 'Admin ยืนยันท่านได้ชำระเงินแล้ว ขณะนี้กำลังทำการจัดส่งสินค้าให้คะ จะได้รับสินค้าภายใน 1 ถึง 2 วันคะ';
          } else if(response[0].status_id == '3'){
            text = 'Admin ยืนยันสินค้าถูกส่งให้ลูกค้าตามที่อยู่ที่ได้แจ้งไว้เรียบร้อยคะ';
          } else if(response[0].status_id == '4'){
            text = 'ลูกค้าได้รับสินค้าเรียบร้อย';
          } else if(response[0].status_id == '5'){
            text = 'สินค้ามีปัญหา ลูกค้าขอเงินคืน';
          }
        } else {
          text = 'Order id not found'
        }
        $("#status").removeAttr("hidden");
        $('#status').html('<p style="text-align:center; color: #ffff;margin:0;">'+text+'</p>');
        
      });
  }
</script>
<style>
  .status{
    background: #555555;
    border-radius: 40px;
    padding: 10px;
  }
</style>