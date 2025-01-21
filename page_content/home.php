<?php 
$stm = $pdo->prepare("SELECT * FROM `album_cover`;");
$stm->execute();
?>

<main class="site-main">
    
    
    <!--================ Hero Carousel start =================-->
    <section class="section-margin mt-0">
      <div class="owl-carousel owl-theme hero-carousel">
        <div class="hero-carousel__slide">
          <img src="img/photobook/pt3.png" alt="" class="img-fluid">
        </div>

        <div class="hero-carousel__slide">
          <img src="img/photobook/pt4.png" alt="" class="img-fluid">
        </div>

        <div class="hero-carousel__slide">
          <img src="img/photobook/pt5.png" alt="" class="img-fluid">
        </div>
      </div>
    </section>
    <!--================ Hero Carousel end =================-->

    <!-- ================ trending product section start ================= -->  
    <section class="section-margin calc-60px">
      <div class="container">
        <div class="section-intro pb-60px">
          <h2>ระบบการจัดการร้านโฟโต้บุคออนไลน์ <span class="section-intro__style"></span></h2>
        </div>
        <div class="row">

        <?php while( $cover = $stm->fetch() ) { ?>
          <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card text-center card-product">
              <div class="card-product__img">
                <img class="card-img" src="<?= $cover['photobook'] ?>" alt="">
              </div>
              <div class="card-body">
                <h4><?= $cover['Cover_Type'] ?></h4>
                <a class="button button--active mt-3 mt-xl-4" href="?page=product-list&id=<?=$cover['id_Album_Cover'] ?>">SHOP NOW</a>
              </div>
            </div>
          </div>
          <?php } ?>

        </div>
      </div>
    </section>
    <!-- ================ trending product section end ================= -->  

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

    
    

  </main>