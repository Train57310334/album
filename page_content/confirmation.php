<?php
  if(isset($_GET['id'])){
    $ship = $pdo->prepare("SELECT * 
                          FROM `shipping` S
                          INNER JOIN user U ON (U.user_id=S.user_id)
                          INNER JOIN shipping_address SA ON (SA.id=S.address_id)
                          WHERE S.`user_id`= ? AND S.`ship_id`=?");
    $ship->bindValue(1, $_SESSION['id_user']);
    $ship->bindValue(2, $_GET['id']);
    $ship->execute();
    $ship = $ship->fetch();
    $another = '';
    if($ship['another'] == 1){
      $another = $ship['another_address'];
    }
    
    $product = $pdo->prepare("SELECT OH.amount,OH.qty,OH.price,OH.date_time,OH.cover_size,
                                    SA.item_name,SA.soft_cover,SA.hard_cover,CS.size
                              FROM `shipping` S
                              INNER JOIN order_album_history OH ON (OH.ship_id=S.ship_id)
                              INNER JOIN store_album SA ON (SA.store_id=OH.store_id)
                              INNER JOIN cover_size CS ON (CS.cover_id=OH.cover_size)
                              WHERE S.`user_id`= ? AND S.`ship_id`=?");
    $product->bindValue(1, $_SESSION['id_user']);
    $product->bindValue(2, $_GET['id']);
    $product->execute();

    $summary = 0;
  }
?>

<!-- ================ start banner area ================= -->	
<section class="blog-banner-area" id="category">
		<div class="container h-100">
			<div class="blog-banner">
				<div class="text-center">
					<h1>Order Confirmation</h1>
					<nav aria-label="breadcrumb" class="banner-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Shop Category</li>
            </ol>
          </nav>
				</div>
			</div>
    </div>
	</section>
	<!-- ================ end banner area ================= -->
  
  <!--================Order Details Area =================-->
  <section class="order_details section-margin--small">
    <div class="container">
      <p class="text-center billing-alert">Thank you. Your order has been received.</p>
      <div class="row mb-5">
        <div class="col-md-6 col-xl-4 mb-4 mb-xl-0">
          <div class="confirmation-card">
            <h3 class="billing-title">Order Info</h3>
            <table class="order-rable">
              <tr>
                <td>Order number</td>
                <td>: <?=$ship['reference_order_id']?></td>
              </tr>
              <tr>
                <td>Date</td>
                <td>: <?=date('Y-m-d')?></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="col-md-6 col-xl-4 mb-4 mb-xl-0">
          <div class="confirmation-card">
            <h3 class="billing-title">Shipping Address</h3>
            <table class="order-rable">
              <tr>
                <td>Username</td>
                <td>: <?=$ship['Firstname'].' '.$ship['Lastname']?></td>
              </tr>
              <tr>
                <td>Street</td>
                <td>: <?=$ship['Address']?></td>
              </tr>
              <tr>
                <td>Province</td>
                <td>: <?=$ship['Province']?></td>
              </tr>
              <tr>
                <td>Postcode</td>
                <td>: <?=$ship['Zipcode']?></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="col-md-6 col-xl-4 mb-4 mb-xl-0">
          <div class="confirmation-card">
            <h3 class="billing-title">Another Address</h3>
            <table class="order-rable">
              <tr>
                <td style="padding:0;"><?=$another?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="order_details_table">
        <h2>Order Details</h2>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Product</th>
                <th scope="col">Amount</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php while($list= $product->fetch()){
                $cover = '';
                $total = '';
                if($list['soft_cover'] == 1){
                  $cover = "Soft cover";
                } else if ($list['hard_cover'] == 1) {
                  $cover = "Hard cover";
                }
                if($list['cover_size'] == 1){
                  $total = ($list['price'] * $list['amount']) * $list['qty']; // 8*8 
                } else {
                  $total = (($list['price'] * $list['amount']) * $list['qty']) + 200; // 11*8.5
                }
                $summary = $summary + $total;
                  echo  '<tr>
                        <td>
                          <p>'.$list['item_name'].' '.$cover.' '.$list['size'].'</p>
                        </td>
                        <td>
                          <h5>'.$list['amount'].'</h5>
                        </td>
                        <td>
                          <h5>x '.$list['qty'].'</h5>
                        </td>
                        <td>
                          <p>$'.$list['price'].'</p>
                        </td>
                        <td>
                          <p>$'.$total.'</p>
                        </td>
                      </tr>';
               } ?>

              <tr>
                <td>
                  <h4>Subtotal</h4>
                </td>
                <td>
                  <h5></h5>
                </td>
                <td>
                  <h5></h5>
                </td>
                <td>
                  <h5></h5>
                </td>
                <td>
                  <p>$<?=$summary?></p>
                </td>
              </tr>
              <tr>
                <td>
                  <h4>Shipping</h4>
                </td>
                <td>
                  <h5></h5>
                </td>
                <td>
                  <h5></h5>
                </td>
                <td>
                  <h5></h5>
                </td>
                <td>
                  <p>Flat rate: $00.00</p>
                </td>
              </tr>
              <tr>
                <td>
                  <h4>Total</h4>
                </td>
                <td>
                  <h5></h5>
                </td>
                <td>
                  <h5></h5>
                </td>
                <td>
                  <h5></h5>
                </td>
                <td>
                  <h4>$<?=$summary?></h4>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
  <!--================End Order Details Area =================-->