
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
  .date{
    border: 1px solid #eee;
    font-size: 14px;
    color: #999999;
    padding: 5px 15px;
  }
</style>
  <!-- ================ category section start ================= -->      
  <section class="section-margin--small mb-5">
    <div class="container">
      <div class="row">
      <div class="col-xl-12 col-lg-8 col-md-7">
        <form>
          <!-- Start Filter Bar -->
          <div class="filter-bar d-flex flex-wrap align-items-center">
            <div class="sorting">
                <select name="report" class="report" id="report" required>
                  <option value='1'>รายงานการขาย</option>
                  <option value='2'>รายงานสินค้าพร้อมส่ง</option>
                </select>
            </div>
            <div class="sorting">
              <input type="date" name="from" class="input-group date" id="from" value="" required>
            </div>
            <div class="sorting mr-auto">
              <input type="date" name="to" class="input-group date" id="to" value="" required>
            </div>
            <div>
              <div class="input-group">
                <button type="submit" class="button" onclick="getListOrderStatus(); return false;">Generate</button>
              </div>
            </div>
          </div>
          <!-- End Filter Bar -->
          </form>
          <!-- Start Best Seller -->
           <section class="lattest-product-area pb-40 category-list">
           <table class="table" >
              <thead>
                  
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

    function getListOrderStatus(){
      var report = $('#report').val();
      var from = $('#from').val();
      var to = $('#to').val();
      $.ajax({
        url: "config/perform_function.php?d=include&f=get-report.php", 
        method: "POST",
        data: { report: report,
                from: from,
                to: to
             },
        dataType:"json"
      })
      .done(function( response ) {
        if(response.length > 0){
          if (report == 1) {
            reportSales(response);
          } else if (report == 2) {
            reportProductReadySend(response);
          }
         
        }
      });
    }
    function reportSales(response) { 
      var thead = '';
      var tbody = '';
      for (var index = 0; index < response.length; index++) {
        var element = response[index];
        var cover="";
        var total = '';
        if(element.cover_size == 1){
          total = (element.price * element.amount) * element.qty; // 8*8 
        } else {
          total = ((element.price * element.amount) * element.qty) + 200; // 11*8.5
        }
        if(element.soft_cover == 1){
          cover = "Soft cover";
        } else if (element.hard_cover == 1) {
          cover = "Hard cover";
        }

        thead = '<tr>'+
              '<th scope="col">Date</th>'+
              '<th scope="col">User</th>'+
              '<th scope="col">Product</th>'+
              '<th scope="col">Amount</th>'+
              '<th scope="col">Price</th>'+
              '<th scope="col">QTY</th>'+
              '<th scope="col">Total</th>'+
            '</tr>';
        tbody += '<tr><td>'+
                      '<p>'+element.date_time+'</p>'+
                  '</td>'+
                  '<td>'+
                      '<p>'+element.Username+'</p>'+
                  '</td>'+
                  '<td>'+
                      '<p>'+element.item_name+' '+cover+' '+element.size+'</p>'+
                  '</td>'+
                  '<td>'+
                      '<p>'+element.amount+'</p>'+
                  '</td>'+
                  '<td>'+
                      '<p>'+element.price+'</p>'+
                  '</td>'+
                  '<td>'+
                      '<p>'+element.qty+'</p>'+
                  '</td>'+
                  '<td>'+
                      '<div class="product_count">'+
                          '<p>'+total+'฿</p>'+
                      '</div>'+
                  '</td>'+
              '</tr>';
      }
      $('.table thead').html(thead);
      $('.table tbody').html(tbody);
    }

    function reportProductReadySend(response){
      var thead = '';
      var tbody = '';
      var detail = '';
      for (let index = 1; index <= response[0].count; index++) {
        for(var j=0; j < response[0][index].detail.length; j++){
          detail += response[0][index].detail[j]+'<br>';
        }
        var element = response[0][index];
        var total = '';
        var address = '';
        if(element.cover_size == 1){
          total = (element.price * element.amount) * element.qty; // 8*8 
        } else {
          total = ((element.price * element.amount) * element.qty) + 200; // 11*8.5
        }

        address = element.address;
        if (element.another == 1) {
          address = element.another_address
        }
        thead = '<tr>'+
                '<th scope="col">Date</th>'+
                '<th scope="col">User</th>'+
                '<th scope="col">Product</th>'+
                '<th scope="col">Total</th>'+
                '<th scope="col">Address</th>'+
                '<th scope="col">Status</th>'+
                '<th scope="col">Reference order id</th>'+
              '</tr>';
        tbody += '<tr><td>'+
                    '<p>'+element.date_time+'</p>'+
                '</td>'+
                '<td>'+
                    '<p>'+element.username+'</p>'+
                '</td>'+
                '<td>'+
                    '<p>'+detail+'</p>'+
                '</td>'+
                '<td>'+
                    '<p>'+total+'</p>'+
                '</td>'+
                '<td>'+
                    '<p>'+address+'</p>'+
                '</td>'+
                '<td>'+
                    '<p>'+element.status+'</p>'+
                '</td>'+
                '<td>'+
                    '<p>'+element.reference_order_id+'฿</p>'+
                '</td>'+
            '</tr>';
      }

      $('.table thead').html(thead);
      $('.table tbody').html(tbody);
    }
  </script>