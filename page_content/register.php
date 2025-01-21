
    <!--================Login Box Area =================-->
    <section class="login_box_area section-margin">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login_box_img">
                        <div class="hover">
                            <h4>You already have an account?</h4>

                            <a class="button button-account" href="?page=login">Login</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="login_form_inner register_form_inner">
                        <h3>Register</h3>
                        <form class="row login_form" action="" method="POST" id="register_form" onsubmit="registerForm(); return false;">
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" id="name" name="username" placeholder="Username"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Email Address" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Email Address'" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Password'" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                                    placeholder="Confirm Password" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Confirm Password'" required>
                                <div id="txtConfirmPassword" style="padding:10px;color: #c5322d;"></div>
                            </div>
                            <div class="col-md-12 form-group">
                                <button type="submit" value="submit" class="button button-register w-100">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Login Box Area =================-->
<script>

function registerForm() {
    $.ajax({
        url:'config/perform_function.php?d=include&f=register.php',
        type:'post',
        data: $('#register_form').serialize(),
        dataType:"json"
    })
    .done(function( response ) {
        if (response[0].msg) {
            $('#txtConfirmPassword').html(response[0].msg);
        } else {
            alert(response[0].success);
            window.location.href = "?page=profile";
        }
    });
        
}


</script>