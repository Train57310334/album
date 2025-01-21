<?php 
  
  $stm = $pdo->prepare("SELECT * FROM `profile` WHERE `User_id_User`= ?;");
  $stm->bindValue(1, $_SESSION['id_user']);
  $stm->execute();
  $profile = $stm->fetch();
?>
  <style>
        .card-product__imgOverlay{
            position: relative;
            bottom: 0;
            left: 30px;
            top: -75px;
            width: 50px;
            padding: 5px;
        }
    </style>
<script>
    var profile = "<?=$profile['profile_id']?>";
    if(profile == ''){
        console.log("profile",profile)
        setTimeout(function(){ editForm(); }, 100);
    }
</script>
        <!-- ================ category section start ================= -->
        <section class="section-margin--small mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-5">
                        <div class="sidebar-categories">
                            <div class="head">User</div>
                            <ul class="main-categories">
                                <aside class="single_sidebar_widget author_widget card-product">
                                <img class="author_img rounded-circle" src="<?=$_SESSION['image']?>" alt="" style="width:120px;height:120px;">
                                <ul class="card-product__imgOverlay">
                                    
                                    <li><button><i class="ti-import" onClick="$('#fileToUpload').click();"></i></button></li>
                                </ul>
                                    <h4>Username : <?= $_SESSION['username'] ?></h4>
                                    <p>Email : <?= $_SESSION['email']; ?></p>
                                    <div class="br"></div>
                                </aside>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-9 col-lg-8 col-md-7">
                        <form name="profile" action="include/update_profile.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="<?=$_SESSION['id_user']?>">
                        <input type="file" name="fileToUpload" id="fileToUpload" style="display:none;">
                            <h3>
                                <center>ข้อมูลสมาชิก</center>
                            </h3><br>

                            <div class="col-md-12 form-group">
                                <label for="username">Username: </label>
                                <label class="info-form"><?=$_SESSION['username']?></label>
                                <input type="text" class="form-control edit-form" id="username" name="username"
                                    placeholder="Username" value="<?=$_SESSION['username']?>" disabled>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6" style="float:left">
                                    <label for="firstname">Firstname: </label>
                                    <label class="info-form"><?= $profile['Firstname']; ?></label>
                                    <input type="text" class="form-control edit-form" id="firstname" name="Firstname"
                                        placeholder="ชื่อ" value="<?= $profile['Firstname']; ?>" required>
                                </div>
                                <div class="col-md-6" style="float:left">
                                    <label for="lastname">Lastname: </label>
                                    <label for="lastname"><?= $profile['Lastname']; ?></label>
                                    <input type="text" class="form-control edit-form" id="lastname" name="Lastname"
                                        placeholder="Surname" value="<?= $profile['Lastname']; ?>" required>
                                </div>
                                <div style="clear:both"></div>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="address">Address: </label>
                                <label class="info-form"><?= $profile['Address']; ?></label>
                                <textarea name="Address" id="address" cols="30" rows="10" class="form-control edit-form"><?= $profile['Address']; ?></textarea>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6" style="float:left">
                                    <label for="province">province: </label>
                                    <label class="info-form"><?= $profile['Province']; ?></label>
                                    <input type="text" class="form-control edit-form" id="province" name="Province"
                                        placeholder="จังหวัด" value="<?= $profile['Province']; ?>" >
                                </div>
                                <div class="col-md-6" style="float:left">
                                    <label for="zipcode">Zipcode: </label>
                                    <label class="info-form"><?= $profile['Zipcode']; ?></label>
                                    <input type="text" class="form-control edit-form" id="zipcode" name="Zipcode"
                                        placeholder="zipcode" value="<?= $profile['Zipcode']; ?>">
                                </div>
                                <div style="clear:both"></div>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="Phone">Phone: </label>
                                <label class="info-form"><?= $profile['Phone']; ?></label>
                                <input name="Phone" type="text" id="Phone" class="form-control edit-form"
                                    placeholder="Phone"  value="<?= $profile['Phone']; ?>" required>
                            </div>

                            <!-- <div class="col-md-12 form-group">
                                <label for="email">Email</label>
                                <input name="Email" type="email" id="email" class="form-control" placeholder="email"
                                value="<?= $_SESSION['email']; ?>"required>
                            </div> -->

                            <div class="common-filter">
                                <div class="price-range-area">
                                    <input type="submit" name="save" id="save"
                                        class="button button--active mt-3 mt-xl-4 edit-form" value="Save">
                                    <input type="button" name="edit" id="edit-form" class="button button--active mt-3 mt-xl-4 info-form" value="Edit" onclick="editForm();">
                                </div>
                            </div>

                            <!-- <tr>
                                <td align="center">&nbsp;</td>
                                <td colspan="3" align="left">
                                </td>
                            </tr> -->
                        </form>
                    </div>
                </div>


        </section>
        <!-- ================ category section end ================= -->