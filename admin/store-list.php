
<style>
  @media (min-width: 1200px){
    .container {
        max-width: 1400px;
    }
  }
  .item{  
    display:none;
  }
  .nice-select{
    width:100%;
  }
</style>
  <!-- ================ category section start ================= -->      
  <section class="section-margin--small mb-5">
    <div class="container">
      <div class="row">
        <div class="col-md-2 form-group"></div>
        <div class="col-md-10 form-group">
          <form action="include/update_product_store.php" method="post"  id="itemForm"  enctype="multipart/form-data">
            <div class="row">
              <input type="hidden" name="mode" value="save">
              <input type="hidden" name="store_id" id="store_id" value="">
              <div class="col-md-3 form-group item">
                  <input type="text" class="form-control" id="itemName" name="itemName"
                      placeholder="name" value="" required>
              </div>
              <div class="col-md-2  item">
                <select name="coverType" class="cover-type" id="coverTypeItem">
                <?php 
                  $stm = $pdo->prepare("SELECT * FROM `album_cover`");
                  $stm->execute();
                  while($list = $stm->fetch()){
                    echo "<option value='".$list['id_Album_Cover']."'>".$list['Cover_Type']."</option>";
                  }
                ?>
                </select>
              </div>
              <div class="col-md-2 item">
                <select name="cover" class="cover" id="cover">
                  <option value='1'>Soft Cover</option>
                  <option value='2'>Hard Cover</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2 form-group item">
                  <input type="number" min="0" max="10000" class="form-control" id="amount" name="amount"
                      placeholder="amount" value="" required>
              </div>
              <div class="col-md-2 form-group item">
                  <input type="text" min="0.00" max="10000.00" class="form-control" id="price" name="price" 
                      placeholder="price" value="" required>
              </div>
              <div class="col-md-3 form-group item">
                  <input type="file" name="fileToUpload" id="fileToUpload" value="">
              </div>
              <div class="col-md-3 form-group item" style="text-align: right;">
                <button type="submit" class="button" onclick="">Save</button>
              </div>
              <div class="col-md-2" style="text-align: right;">
                <button type="button" class="button" onclick="productItem();">Add Item</button>
              </div>
          </div>
          </form>
        </div>
        
      </div>
      <div class="row">
        <div class="col-xl-2 col-lg-4 col-md-5">
          <div class="sidebar-categories">
            <div class="head">Welcome</div>
            <ul class="main-categories">
              <aside class="single_sidebar_widget author_widget">
                          <img class="author_img rounded-circle" src="<?=$_SESSION['image']?>" alt="">
                        <h4>Username : <?=$_SESSION["username"]?></h4>
                          <p>Email : <?=$_SESSION["email"]?><br ></p>
                          <div class="br"></div>
                      </aside>
            </ul>
          </div>
          
        </div>
      <div class="col-xl-10 col-lg-8 col-md-7">

          <!-- Start Filter Bar -->
          <div class="filter-bar d-flex flex-wrap align-items-center">
            <div class="sorting">
              <select id="coverType" onchange="getListAlbum();">
              <option value="0">All type</option>
              <?php 
                $stm = $pdo->prepare("SELECT * FROM `album_cover`");
                $stm->execute();
                while($list = $stm->fetch()){
                  echo "<option value='".$list['id_Album_Cover']."'>".$list['Cover_Type']."</option>";
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
           <table class="table" >
              <thead>
                  <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Cover Type</th>
                    <th scope="col">Cover</th>
                    <th scope="col">Price</th>
                    <th scope="col">Amount</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
            <div class="row" id="album-item"></div>
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
        console.log("response",response)
        if(response.length > 0){
          for (let index = 0; index < response.length; index++) {
            var element = response[index];
            var image = element.images;
            var cover="";
            var color = '';
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
            if (element.amount <= 5) {
              color = 'background-color: #fe9d262e;';
            }
              
              htmlItem += '<tr style="'+color+'"><td>'+
                                  '<div class="media">'+
                                      '<div class="d-flex">'+
                                          '<img src="'+image+'" alt="" style="width:100px;height:100px;">'+
                                      '</div>'+
                                      '<div class="media-body">'+
                                          '<p style="margin:15px;">'+element.item_name+'</p>'+
                                      '</div>'+
                                  '</div>'+
                              '</td>'+
                              '<td>'+
                                  '<p>'+element.Cover_Type+'</p>'+
                              '</td>'+
                              '<td>'+
                                  '<p>'+cover+'</p>'+
                              '</td>'+
                              '<td>'+
                                  '<p>'+element.price+'฿</p>'+
                              '</td>'+
                              '<td>'+
                                  '<div class="product_count">'+
                                      '<p>'+element.amount+'</p>'+
                                  '</div>'+
                              '</td>'+
                              '<td>'+
                                  '<button class="icon-edit" onclick="productItem('+element.store_id+');"><i class="ti-pencil-alt"></i></button>'+//ti-pencil-alt
                              '</td>'+
                              '<td>'+
                                  '<button class="icon-edit" onclick="deleteItem('+element.store_id+');"><span class="delete">x</span></button>'+//ti-pencil-alt
                              '</td>'+
                          '</tr>';  
          }
        }
        $('.table tbody').html(htmlItem);
        
      });
    }

    function productItem(id=''){
      $('.item').css('display','block');
      if (id) {
        $.ajax({
          url: "config/perform_function.php?d=include&f=update_product_store.php", 
          method: "POST",
          data: { id: id,
                  mode: "get",
              },
          dataType:"json"
        })
        .done(function( response ) {
          if(response.length > 0){
            var index = response[0];
            var cover = '';
            $('#itemName').val(index.item_name);
            $('#coverTypeItem').val(index.id_Album_Cover);
            $(".cover-type .current").html(index.Cover_Type);
            $('#amount').val(index.amount);
            $('#price').val(index.price);
            $('#store_id').val(index.store_id);
            if(index.soft_cover == 1){
              cover_id = index.soft_cover;
              cover = "Soft cover";
            } else if (index.hard_cover == 1) {
              cover_id = index.hard_cover;
              cover = "Hard cover";
            }
            $('#cover').val(cover_id);
            $(".cover .current").html(cover);
          }
        });
      } else {
        $('#itemName').val('');
        $('#amount').val('');
        $('#price').val('');
        $('#store_id').val('');
      }
    }
    function deleteItem(id=''){
      var boolean = confirm('Are you sure delete your product?');
      if(boolean){
        $.ajax({
          url: "config/perform_function.php?d=include&f=update_product_store.php", 
          method: "POST",
          data: { id: id,
                  mode: "delete",
              },
          dataType:"json"
        })
        .done(function( response ) {
          if(response.length > 0){
            alert(response[0].success);
            window.location.href = "?page=store-list";
          }
        });
      }
    }
  </script>