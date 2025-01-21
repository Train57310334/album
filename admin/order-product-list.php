
<style>
  @media (min-width: 1200px){
    .container {
        max-width: 1400px;
    }
  }
  .icon-edit{
    padding: 0;
    border: 0;
    background: transparent;
    position: relative;
  }
  .item{  
    display:none;
  }
  .nice-select{
    width:100%;
  }
  .delete{
    color: red;
    font-size: 15px;
    font-weight: 800;
  }
</style>
  <!-- ================ category section start ================= -->      
  <section class="section-margin--small mb-5">
    <div class="container">
      <div class="row">
        <div class="col-md-2 form-group"></div>
        <div class="col-md-10 form-group">
          <form action="include/update_status_shipping.php" method="post"  id="itemForm"  enctype="multipart/form-data">
            <div class="row">
              <input type="hidden" name="mode" value="save">
              <input type="hidden" name="ship_id" id="ship_id" value="">
              <div class="col-md-8 item"></div>
              <div class="col-md-2 item">
                <select name="status" class="status" id="status">
                <?php 
                  $stm = $pdo->prepare("SELECT * FROM `shipping_status`");
                  $stm->execute();
                  while($list = $stm->fetch()){
                    echo "<option value='".$list['id']."'>".$list['status']."</option>";
                  }
                ?>
                </select>
              </div>
              <div class="col-md-2 form-group item" style="text-align: right;">
                <button type="submit" class="button" onclick="">Save</button>
              </div>

            </div>
          </form>
        </div>
        
      </div>
      <div class="row">
        
      <div class="col-xl-12 col-lg-8 col-md-7">

          <!-- Start Filter Bar -->
          <div class="filter-bar d-flex flex-wrap align-items-center">
            <div class="sorting">
              <select id="status_id" onchange="getListOrderStatus();">
              <option value="0">All type</option>
              <?php 
                $stm = $pdo->prepare("SELECT * FROM `shipping_status`");
                $stm->execute();
                while($list = $stm->fetch()){
                  echo "<option value='".$list['id']."'>".$list['status']."</option>";
                }
              ?>
              </select>
            </div>
            <!-- <div class="sorting mr-auto">
              <select id="limit-row" onchange="getListOrderStatus();">
                <option value="10">show 10</option>
                <option value="20">show 20</option>
                <option value="30">Show 30</option>
              </select>
            </div> -->
            <div>
              <div class="input-group filter-bar-search">
                <input type="text" placeholder="Search" id="search" value="" onkeyup="getListOrderStatus($(this).val());">
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
                    <th scope="col">Premise</th>
                    <th scope="col">Total</th>
                    <th scope="col">Address</th>
                    <th scope="col">User</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date Time</th>
                    <th scope="col">Reference order id</th>
                    <th scope="col"></th>
                    <!-- <th scope="col"></th> -->
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
    getListOrderStatus();
    function getListOrderStatus(value=''){
      var status = $('#status_id').val();
      var limit_row = $('#limit-row').val();
      $.ajax({
        url: "config/perform_function.php?d=include&f=get-list-order-shipping.php", 
        method: "POST",
        data: { value: value,
                status: status,
                limit_row: limit_row
             },
        dataType:"json"
      })
      .done(function( response ) {
        // console.log(response);
        var htmlItem = '';
        if(response.length > 0){
          for (let index = 1; index <= response[0].count; index++) {
            var detail = '';
            for(var j=0; j < response[0][index].detail.length; j++){
              detail += response[0][index].detail[j]+'<br>';
            }
            var element = response[0][index];
            var image = element.premise;
            var address = '';
            var total = '';
            if(image == null || image == ''){
              image = "img/home/hero-banner.png";
            } else {
              image = "uploads/premise/"+image;
            }
            address = element.address;
            if (element.another == 1) {
              address = element.another_address
            }
            if(element.cover_size == 1){
              total = (element.price * element.amount) * element.qty; // 8*8 
            } else {
              total = ((element.price * element.amount) * element.qty) + 200; // 11*8.5
            }
              htmlItem += '<tr><td>'+
                                  '<div class="media">'+
                                      '<div class="d-flex">'+
                                          '<img src="'+image+'" alt="" style="width:100px;height:100px;">'+
                                      '</div>'+
                                      '<div class="media-body" style="width:240px;">'+
                                          '<p style="margin:15px;">'+detail+'</p>'+
                                      '</div>'+
                                  '</div>'+
                              '</td>'+
                              '<td>'+
                                  '<p>'+total+'฿</p>'+
                              '</td>'+
                              '<td>'+
                                  '<p>'+address+'</p>'+
                              '</td>'+
                              '<td>'+
                                  '<p>'+element.username+'</p>'+
                              '</td>'+
                              '<td>'+
                                  '<p>'+element.status+'</p>'+
                              '</td>'+
                              '<td>'+
                                  '<p>'+element.date_time+'</p>'+
                              '</td>'+
                              '<td>'+
                                  '<div class="product_count">'+
                                      '<p>'+element.reference_order_id+'</p>'+
                                  '</div>'+
                              '</td>'+
                              '<td>'+
                                  '<button class="icon-edit" onclick="getStatus('+element.ship_id+');"><i class="ti-pencil-alt"></i></button>'+//ti-pencil-alt
                              '</td>'+
                          '</tr>';  
          }
        }
        $('.table tbody').html(htmlItem);
      });
    }

    function getStatus(id=''){
      $('.item').css('display','block');
      if (id) {
        $.ajax({
          url: "config/perform_function.php?d=include&f=update_status_shipping.php", 
          method: "POST",
          data: { id: id,
                  mode: "get",
              },
          dataType:"json"
        })
        .done(function( response ) {
          console.log(response)
          if(response.length > 0){
            $('#status').val(response[0].status_id);
            $(".status .current").html(response[0].status);
            $('#ship_id').val(response[0].ship_id);
          }
        });
      }
    }
  </script>