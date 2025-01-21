<?php 
  $stm = $pdo->prepare("SELECT * FROM `store_album` WHERE `store_id` = ?;");
  $stm->bindValue(1, $_GET['id']);
  $stm->execute();
  $store = $stm->fetch();
  $image;
  $price_nomal_amount60 = $store['price'] * 60;
  $price_medium_amount60 = $store['price'] * 60 + 200;
  $price_nomal_amount120 = $store['price'] * 120;
  $price_medium_amount120 = $store['price'] * 120 + 200;
  $cover = '';
  if($store['soft_cover'] == 1){
    $cover = "Soft cover";
  } else if ($store['hard_cover'] == 1) {
    $cover = "Hard cover";
  }
?>
  <!--================Single Product Area =================-->
	<div class="product_image_area">
		<div class="container">
			<div class="row s_product_inner">
				<div class="col-lg-6">
					<div class="owl-carousel owl-theme s_Product_carousel">
						<div class="single-prd-item">
							<img class="img-fluid" src="img/photobook/zz1.png" alt="">
						</div>
						<div class="single-prd-item">
							<img class="img-fluid" src="img/category/s-p1.jpg" alt="">
						</div>
						<div class="single-prd-item">
							<img class="img-fluid" src="img/category/s-p1.jpg" alt="">
						</div>
					</div>
                </div>
                
                <div class="col-lg-5 offset-lg-1">
                    <form id="formDetailItem" method="POST" onsubmit="AddToCart(); return false;">
                      <input type="hidden" name="mode" value="insert">
                      <input type="hidden" name="store_id" value="<?=$_GET['id']?>">
                        
                            <h3><?=$store['item_name']?></h3>
                            <p><?=$cover?></p>
                            <div class="row">
                              <div class="col-md-2">
                                  <select name="size" class="size" id="size">
                                    <option value='1'>8*8</option>
                                    <option value='2'>11*8.5</option>
                                  </select>
                              </div>
                              <div class="col-md-3">
                                  <select name="amountImages" class="amount-images" id="amountImages">
                                    <option value='60'>60 รูป (30 หน้า)</option>
                                    <option value='120'>120 รูป (60 หน้า)</option>
                                  </select>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                              <ul class="list" style="margin: 10px 0 10px 0;">
                                  <li><span>ขนาด 8*8 นิ้ว จำนวน 60 รูป ราคา <?=$price_nomal_amount60?> บาท</span></a></li>
                                  <li><span>ขนาด 11*8.5 นิ้ว จำนวน 60 รูป ราคา <?=$price_medium_amount60?> บาท</span></a></li>
                                  <li><span>ขนาด 8*8 นิ้ว จำนวน 120 รูป ราคา <?=$price_nomal_amount120?> บาท</span></a></li>
                                  <li><span>ขนาด 11*8.5 นิ้ว จำนวน 120 รูป ราคา <?=$price_medium_amount120?> บาท</span></a></li>
                              </ul>
                              </div>
                            </div>


                            <div class="product_count">
                                <label for="qty">จำนวน</label>
                
                                <input type="number" name="qty" id="sst" size="2" maxlength="12" value="1" title="Quantity:" class="input-text qty">
                                <label for="qty">เล่ม</label>
                                
                                <!-- <a class="button primary-btn" href="?page=cart.php">Add to Cart</a>                -->
                            </div>
                            <button type="submit" class="button" >Add to Cart</button>
                    </form>
                </div>
                
			</div>
		</div>
	</div>
	<!--================End Single Product Area =================-->


	<!--================ Start related Product area =================-->  
	<section class="related-product-area section-margin--small mt-0">
		<div class="container">
			<div class="section-intro pb-60px">
			<br />
        <h2>Top <span class="section-intro__style">Product</span></h2>
      </div>
			<div class="row mt-30">
        <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
          <div class="single-search-product-wrapper">
            <div class="single-search-product d-flex">
              <a href="#"><img src="img/photobook/sm1.png" alt=""></a>
              <div class="desc">
                  <a href="#" class="title">My Wedding</a>
                  
              </div>
            </div>
            <div class="single-search-product d-flex">
              <a href="#"><img src="img/photobook/sm2.png" alt=""></a>
              <div class="desc">
                <a href="#" class="title">Mom and Me</a>
                
              </div>
            </div>
            
          </div>
        </div>

        <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
          <div class="single-search-product-wrapper">
            <div class="single-search-product d-flex">
              <a href="#"><img src="img/photobook/sm3.png" alt=""></a>
              <div class="desc">
                  <a href="#" class="title">Christmas</a>
                  
              </div>
            </div>
            <div class="single-search-product d-flex">
              <a href="#"><img src="img/photobook/sm4.png" alt=""></a>
              <div class="desc">
                <a href="#" class="title">Valentine</a>
                
              </div>
            </div>
            
          </div>
        </div>

        <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
          <div class="single-search-product-wrapper">
            <div class="single-search-product d-flex">
              <a href="#"><img src="img/photobook/sm5.png" alt=""></a>
              <div class="desc">
                  <a href="#" class="title">Congratulations</a>
                  
              </div>
            </div>
            <div class="single-search-product d-flex">
              <a href="#"><img src="img/photobook/sm6.png" alt=""></a>
              <div class="desc">
                <a href="#" class="title">My Pets</a>
                
              </div>
            </div>
            
          </div>
        </div>

        <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
          <div class="single-search-product-wrapper">
            <div class="single-search-product d-flex">
              <a href="#"><img src="img/photobook/sm7.png" alt=""></a>
              <div class="desc">
                  <a href="#" class="title">My Family</a>
                  
              </div>
            </div>
            <div class="single-search-product d-flex">
              <a href="#"><img src="img/photobook/sm8.png" alt=""></a>
              <div class="desc">
                <a href="#" class="title">Travel</a>
                
              </div>
            </div>
            
          </div>
        </div>
      </div>
		</div>
	</section>
	<!--================ end related Product area =================-->  	

<script>

function AddToCart() {
    $.ajax({
        url:'config/perform_function.php?d=include&f=add-cart.php',
        type:'post',
        data: $('#formDetailItem').serialize(),
        dataType:"json"
    })
    .done(function( response ) {
        if(response[0].msg){
          alert(response[0].msg);
        } else if (response[0].success) {
            alert(response[0].success);
            window.location.href = "?page=cart";
        }
    });
        
}
</script>