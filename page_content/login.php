
  <!-- ================ start banner area ================= -->	
	<section class="blog-banner-area" id="category">
		<div class="container h-100">
			<div class="blog-banner">
				<div class="text-center">
					<h1>Login / Register</h1>
					<nav aria-label="breadcrumb" class="banner-breadcrumb"></nav>
				</div>
			</div>
    </div>
	</section>
	<!-- ================ end banner area ================= -->
  
  <!--================Login Box Area =================-->
	<section class="login_box_area section-margin">
		<div class="container">
				<div class="row">
					<div class="login_form_inner">
						<h3>Login User</h3>
						<form class="row login_form"  method="POST" id="contactForm" action="" onsubmit="validateLogIn(); return false;">
							<input type="hidden" name="validate" id="validate" value="1">
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="username" name="username" placeholder="Username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'" required>
							</div>
							<div class="col-md-12 form-group">
								<input type="password" class="form-control" id="password" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" required>
							</div>
							<div class="col-md-12 form-group">
								<div class="creat_account">
									<input type="checkbox" id="f-option2" name="selector">
									<label for="f-option2">remember</label>
								</div>
							</div>
							<div class="col-md-12 form-group">
								<button type="submit" class="button" >Login</button>
								<!-- <a href="#">ลืมรหัสผ่าน?</a> -->
							</div>
						</form>
					</div>
			</div>
		</div>
	</section>

	<!--================End Login Box Area =================-->



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

  <script>

	function validateLogIn() {
		$.ajax({
			url:'config/perform_function.php?d=include&f=login.php',
			type:'post',
			data: $('#contactForm').serialize(),
			dataType:"json"
		})
		.done(function( response ) {
			if (response[0].error) {
				alert(response[0].error)
			} else {
				if (response[0].usergroup == '1') { // admin
					window.location.href = "?page=store-list";
				} else {
					window.location.href = "?page=profile";
				}
			}
		});
			
	}
  
 
  </script>