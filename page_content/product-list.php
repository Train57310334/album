
  <!-- ================ category section start ================= -->      
  <section class="section-margin--small mb-5">
    <div class="container">
      <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-5">
          <div class="sidebar-categories">
            <div class="head">Welcome</div>
            <ul class="main-categories">
              <aside class="single_sidebar_widget author_widget">
                          <img class="author_img rounded-circle" src="<?=$_SESSION['image']?>" alt="" height="120" width="120">
                        <h4>Username : <?=$_SESSION["username"]?></h4>
                          <p>Email : <?=$_SESSION["email"]?><br ></p>
                          <div class="br"></div>
                      </aside>
            </ul>
          </div>
          <div class="sidebar-filter">
            <div class="top-filter-head">Photobook</div>
            <div class="common-filter">
              
              <form action="#">
                <ul>
                  <!-- <li class="nav-item"><a class="nav-link" href="#">สถานะคำสั่งซื้อ</a></li> -->
                  <li class="nav-item"><a class="nav-link" href="?page=checkout">แจ้งชำระเงิน</a></li>
                  <!-- <li class="nav-item"><a class="nav-link" href="#">สถานะการชำระเงิน</a></li> -->
                  <li class="nav-item"><a class="nav-link" href="?page=thankyou">สถานะสินค้า</a></li>
                  <li class="nav-item"><a class="nav-link" href="?page=contact">ติดต่อเรา</a></li>
                  <!-- <li class="nav-item"><a class="nav-link" href="#">ออกรายงาน</a></li> -->
                </ul>
              </form>
            </div>
           
            <div class="common-filter">
              <div class="price-range-area">
              <!-- <a class="button button--active mt-3 mt-xl-4" href="index.html">ออกจากระบบ</a> -->
                
              </div>
            </div>
          </div>
        </div>
      <div class="col-xl-9 col-lg-8 col-md-7">

          <!-- Start Filter Bar -->
          <div class="filter-bar d-flex flex-wrap align-items-center">
            <div class="sorting">
              <select id="coverType" onchange="getListAlbum();">
              <option value="0">All type</option>
              <?php 
                $stm = $pdo->prepare("SELECT * FROM `album_cover`");
                $stm->execute();
                while($list = $stm->fetch()){
                  $select = '';
                  if($_GET['id'] == $list['id_Album_Cover']){
                    $select = "selected";
                  }
                  echo "<option value='".$list['id_Album_Cover']."' ".$select.">".$list['Cover_Type']."</option>";
                }
              ?>
              </select>
            </div>
            <div class="sorting mr-auto">
              <select id="limit-row" onchange="getListAlbum();">
                <option value="10">show 10</option>
                <option value="20">show 20</option>
                <option value="30">Show 30</option>
              </select>
            </div>
            <div>
              <div class="input-group filter-bar-search">
                <input type="text" placeholder="Search" id="search" value="" onkeyup="getListAlbum($(this).val());">
                <div class="input-group-append">
                  <button type="button"><i class="ti-search"></i></button>
                </div>
              </div>
            </div>
          </div>
          
          <!-- End Filter Bar -->
          <!-- Start Best Seller -->
           <section class="lattest-product-area pb-40 category-list">
            <div class="row" id="album-item">
            </div>
          </section>
          <!-- End Best Seller -->
        </div>
      </div>
    </div>
  </section>
  <!-- ================ category section end ================= -->		  

  <script>
    getListAlbum();
    function getListAlbum(value=''){
      var coverType = $('#coverType').val();
      var limit_row = $('#limit-row').val();
      $.ajax({
        url: "config/perform_function.php?d=include&f=get-list-order.php", 
        method: "POST",
        data: { value: value,
                coverType: coverType,
                limit_row: limit_row
             },
        dataType:"json"
      })
      .done(function( response ) {
        var htmlItem = '';
        console.log(response);
        if(response.length > 0){
          for (let index = 0; index < response.length; index++) {
            var element = response[index];
            var image = element.images;
            if(image == null || image == ''){
              image = "img/home/hero-banner.png";
            } else {
              image = "uploads/store-item/"+image;
            }
            if(element.soft_cover == 1){
              cover = "Soft cover";
            } else if (element.hard_cover == 1) {
              cover = "Hard cover";
            }
            htmlItem += '<div class="col-md-6 col-lg-4">'+
                '<div class="card text-center card-product">'+
                  '<div class="card-product__img">'+
                    '<img class="card-img" src="'+image+'" alt="'+image+'" width="200" height="200">'+
                    '<ul class="card-product__imgOverlay">'+
                      '<li><button><i class="ti-search"></i></button></li>'+
                      '<li><button><a href="?page=product-detail&id='+element.store_id+'"><i class="ti-shopping-cart"></i></a></button></li>'+
                      '<li><button><i class="ti-heart"></i></button></li>'+
                    '</ul>'+
                  '</div>'+
                  '<div class="card-body">'+
                      '<h4>'+element.item_name+'</h4>'+
                      '<p>'+cover+'</p>'+
                      '<a class="button button--active mt-3 mt-xl-4" href="?page=product-detail&id='+element.store_id+'">SHOP NOW</a>'+
                  '</div>'+
                '</div>'+
              '</div>';
          }
        }
        $('#album-item').html(htmlItem);
        
      });
    }
  </script>