<header class="header_area">
    <div class="main_menu">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
          <a class="navbar-brand logo_h" href="index.html"><img src="img/logo.png" alt=""></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
            <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
              <li class="nav-item active"><a class="nav-link" href="/aroma">หน้าแรก</a></li>
              <li class="nav-item"><a class="nav-link" href="/aroma/profile.php">ข้อมูลพื้นฐาน</a></li>
              <li class="nav-item"><a class="nav-link" href="#">สถานะการสั่งทำ</a></li>
              <li class="nav-item"><a class="nav-link" href="#">สถานะคลังวัสดุ</a></li>
              <li class="nav-item"><a class="nav-link" href="#">สถานะการจัดส่ง</a></li>
              
              <li class="nav-item"><a class="nav-link" href="#">ออกรายงาน</a></li>
            </ul>
            
            <ul class="nav-shop">
              <?php if ( !isset($_SESSION['id_user']) or !$_SESSION['id_user'] ) { ?>
              <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
              <li class="nav-item"><a class="button button-header" href="login.php">Login</a></li>
              <?php } else { ?>
              <li class="nav-item"><a class="button button-header" href="logout.php">Logout</a></li>
              <?php } ?>
            </ul>

          </div>
        </div>
      </nav>
    </div>
  </header>