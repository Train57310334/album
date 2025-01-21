  <!--================ Start Header Menu Area =================-->
  <?php
    $qty = 0;
    if(isset($_SESSION['id_user'])){
      $stm = $pdo->prepare("SELECT OA.*,SA.item_name,SA.price,SA.images,SA.soft_cover,SA.hard_cover,CS.size
                            FROM `order_album` OA
                            INNER JOIN `store_album` SA ON (SA.store_id=OA.store_id)
                            INNER JOIN `cover_size` CS ON (CS.cover_id=OA.cover_size)
                            WHERE OA.`user_id` = ?;");
      $stm->bindValue(1, $_SESSION['id_user']);
      $stm->execute();

      $count = $pdo->prepare("SELECT count(*) AS total FROM `order_album` OA WHERE OA.`user_id` = ?;");
      $count->bindValue(1, $_SESSION['id_user']);
      $count->execute();
      $count = $count->fetch();
      $qty = $count['total'];
    }
    $page = 'home'; 
    if (isset($_GET['page'])) {
      $page = $_GET['page'];
    }
    
    
  ?>
  <header class="header_area">
    <div class="main_menu">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
          <a class="navbar-brand logo_h" href="?page=home"><img src="img/logo.png" alt=""></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
            <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
              <li class="nav-item" page-content="home"><a class="nav-link" href="?page=home">หน้าแรก</a></li>
              <li class="nav-item" page-content="profile"><a class="nav-link" href="?page=profile">ข้อมูลพื้นฐาน</a></li>
              <li class="nav-item" page-content="product-list"><a class="nav-link" href="?page=product-list">รายการสินค้า</a></li>
              <li class="nav-item" page-content="checkout"><a class="nav-link" href="?page=checkout">แจ้งชำระเงิน</a></li>
              <!-- <li class="nav-item"><a class="nav-link" href="#">สถานะการชำระเงิน</a></li> -->
              <li class="nav-item" page-content="thankyou"><a class="nav-link" href="?page=thankyou">สถานะสินค้า</a></li>
              <li class="nav-item" page-content="contact"><a class="nav-link" href="?page=contact">ติดต่อเรา</a></li>
            
            <?php if ($usergroup ==  1) { // admin?>
              <li class="nav-item submenu dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">Admin</a>
                <ul class="dropdown-menu">
                  <li class="nav-item" page-content="store-list"><a class="nav-link" href="?page=store-list">ผลิตภัณฑ์</a></li>
                  <li class="nav-item" page-content="order-product-list"><a class="nav-link" href="?page=order-product-list">สถานะรายการสินค้า</a></li>
                  <li class="nav-item" page-content="report"><a class="nav-link" href="?page=report">ออกรายงาน</a></li>
                </ul>
							</li>
            <?php } ?>
            </ul>
            <ul class="nav-shop">
              <!-- <li class="nav-item"><button><i class="ti-search"></i></button></li> -->
              <li class="nav-item"><button ><i class="ti-shopping-cart" onclick="window.location.href = '?page=cart'"></i><span class="nav-shop__circle"><?=$qty?></span></button> </li>
            </ul>
            <ul class="nav-shop">
              <?php if ( !isset($_SESSION['id_user']) or !$_SESSION['id_user'] ) { ?>
              <li class="nav-item"><a class="nav-link" href="?page=register">Register</a></li>
              <li class="nav-item"><a class="button button-header" href="?page=login">Login</a></li>
              <?php } else { ?>
              <li class="nav-item"><a class="button button-header" href="?page=logout">Logout</a></li>
              <?php } ?>
            </ul>

          </div>
        </div>
      </nav>
    </div>
  </header>
	<!--================ End Header Menu Area =================-->
    <script>

      var page = "<?=$page?>";
      $('.menu_nav').find('li').each(function(e) {
        if($(this).attr('page-content').indexOf(page) == 0) {
          $(this).addClass('active');
        }
      });
        function editForm(){
            $(".edit-form").css("display","block");
            $(".info-form").css("display","none");

            $('#another').prop('disabled', false);
            $('#another_address').prop('disabled', false);
        }
    </script>
    <style>
      .edit-form{
            display: none;
        }
        .delete{
        color: red;
        font-size: 15px;
        font-weight: 800;
      }
      .icon-edit{
        padding: 0;
        border: 0;
        background: transparent;
        position: relative;
      }
    </style>