
  <!--================Cart Area =================-->
  <section class="cart_area">
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
                  <li class="nav-item"><a class="nav-link" href="#">สถานะคำสั่งซื้อ</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">แจ้งชำระเงิน</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">สถานะการชำระเงิน</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">สถานะสินค้า</a></li>
                  <li class="nav-item"><a class="nav-link" href="?page=contact">ติดต่อเรา</a></li>
                </ul>
              </form>
            </div>
           
            <div class="common-filter">
              <div class="price-range-area">
              <a class="button button--active mt-3 mt-xl-4" href="?page=logout">ออกจากระบบ</a>
                
              </div>
            </div>
          </div>
        </div>
      <div class="col-xl-9 col-lg-8 col-md-7">
      <div class="container">
          <div class="cart_inner">
              <div class="table-responsive">
                <form id="formCart" method="POST" onsubmit="updateToCart(); return false;">
                  <input type="hidden" name="mode" value="update">
                  <table class="table">
                      <thead>
                          <tr>
                              <th scope="col">สินค้า</th>
                              <th scope="col">ราคา</th>
                              <th scope="col">จำนวน</th>
                              <th scope="col">รวม</th>
                              <th scope="col"></th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php 
                            $i=0;
                            $summary = 0;
                            while($cover = $stm->fetch()){
                              $i++;
                              $image = (empty($cover['image']) ? "img/photobook/ct1.png" : $cover['image']);
                              if($cover['cover_size'] == 1){
                                $total = ($cover['price'] * $cover['amount']) * $cover['qty']; // 8*8 
                              } else {
                                $total = (($cover['price'] * $cover['amount']) * $cover['qty']) + 200; // 11*8.5
                              }
                              
                              $summary = $summary + $total; 
                              $cover_type = '';
                              if($cover['soft_cover'] == 1){
                                $cover_type = "Soft cover";
                              } else if ($cover['hard_cover'] == 1) {
                                $cover_type = "Hard cover";
                              }
                          ?>
                          <tr>
                              <td>
                                  <div class="media">
                                      <div class="d-flex">
                                          <img src="<?=$image?>" alt="<?$cover['item_name']?>" style="width: 100px;">
                                          <!-- <img src="img/photobook/ct1.png" alt=""> -->
                                      </div>
                                      <div class="media-body">
                                          <h6><?=$cover['item_name']?></h6>
                                          <p><?=$cover_type?> ขนาด <?=$cover['size']?> นิ้ว จำนวน <?=$cover['amount']?> รูป (<?=$cover['amount']/2?> หน้า)</p>
                                      </div>
                                  </div>
                              </td>
                              <td>
                                  <h5><?=$cover['price']?>฿</h5>
                                  <input type="hidden" id="price<?=$i?>" value="<?=$total?>">
                              </td>
                              <td>
                                  <div class="product_count">
                                      <input type="number" name="qty[<?=$cover['order_id']?>]" id="sst<?=$i?>" min="0" value="<?= $cover['qty']?>" title="Quantity:"
                                          class="input-text qty" onchange="calPrice('<?=$i?>',$(this).val());">
                                      <button onclick="plus('<?=$i?>');"
                                          class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                                      <button onclick="minus('<?=$i?>');"
                                          class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                                  </div>
                              </td>
                              <td>
                                  <h5 id="totalAmount<?=$i?>"><?=$total?>฿</h5>
                                  <input type="hidden" class="total" id="total<?=$i?>" value="<?=$total?>">
                              </td>
                              <td>
                                <button type="button" class="icon-edit" onclick="deleteItem('<?=$cover['order_id']?>','<?=$cover['qty']?>');"><span class="delete">x</span></button>
                              </td>
                          </tr>
                            <?php } ?>
                          <tr>
                              <td>

                              </td>
                              <td>

                              </td>
                              <td>
                                  <h5>ยอดรวม</h5>
                              </td>
                              <td>
                                  <h5 id="summary"><?=$summary?>฿</h5>
                              </td>
                          </tr>
                          <tr class="shipping_area">
                              <td class="d-none d-md-block">

                              </td>
                              <td>

                              </td>
                              <td>
                                  <h5>ค่าจัดส่ง</h5>
                              </td>
                              <td>
                                  <div class="shipping_box">
                                      <ul class="list">
                                          
                                          <li><a>จัดส่งฟรี</a></li>
                                          
                                      </ul>
                                  
                                  </div>
                              </td>
                          </tr>
                          <tr class="out_button_area">
                              <td class="d-none-l">

                              </td>
                              <td class="">

                              </td>
                              <td>
                              </td>
                              <td>
                                  <div class="checkout_btn_inner d-flex align-items-center">
                                      <a class="gray_btn" href="?page=product-list">เลือกสินค้าเพิ่ม</a>
                                      <button type="submit" class="button" >ชำระเงิน</button>
                                  </div>
                              </td>
                          </tr>
                      </tbody>
                  </table>
                </form>
              </div>
          </div>
      </div>
  </section>
  <!--================End Cart Area =================-->
<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    /* display: none; <- Crashes Chrome on hover */
    -webkit-appearance: none;
    margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
}

input[type=number] {
    -moz-appearance:textfield; /* Firefox */
}
.cart_inner .table tbody tr.shipping_area .shipping_box .list li a:before {
  background-color: #08cd08;
}
</style>
<script>
  function plus(id){
    var result = document.getElementById('sst'+id); 
    var sst = result.value; 
    if( !isNaN( sst )) result.value++;
      calPrice(id,result.value);
  }

  function minus(id){
    var result = document.getElementById('sst'+id); 
    var sst = result.value; if( !isNaN( sst ) && sst > 0 ) result.value--;
    calPrice(id, result.value);
  }

  function calPrice(id, qty){
    var price = $("#price"+id).val();
    var total = price * qty;
    $("#total"+id).val(total);
    $("#totalAmount"+id).html(total+"฿");

    var summary = '';
    $('.total').each(function(i) {
      i = i+1;
      var totalPrice = $("#total"+i).val();
      summary = Math.floor(summary + parseFloat(totalPrice));
    });
    $("#summary").html(summary+"฿");
  }

  function updateToCart() {
      $.ajax({
          url:'config/perform_function.php?d=include&f=add-cart.php',
          type:'post',
          data: $('#formCart').serialize(),
          dataType:"json"
      })
      .done(function( response ) {
          if(response[0].msg){
            alert(response[0].msg);
          } else if (response[0].success) {
              alert(response[0].success);
              window.location.href = "?page=checkout";
          }
      });
          
  }
  function deleteItem(id='',qty=''){
      var boolean = confirm('Are you sure delete your order product?');
      if(boolean){
        $.ajax({
          url: "config/perform_function.php?d=include&f=add-cart.php", 
          method: "POST",
          data: { id: id,
                  qty: qty,
                  mode: "delete",
              },
          dataType:"json"
        })
        .done(function( response ) {
          if(response.length > 0){
            alert(response[0].success);
            window.location.href = "?page=cart";
          }
        });
      }
    }
</script>