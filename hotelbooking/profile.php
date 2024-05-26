<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php') ?>
    <title><?php echo $settings_r['site_title'] ?> - PROFILE</title>
</head>

<body class="bg-light">
    <?php require('inc/header.php') ?>

    <?php
    if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
        redirect('index.php');
    }
    $u_exist = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], 's');
    if (mysqli_num_rows($u_exist) == 0) {
        redirect('index.php');
    }
    $u_fetch = mysqli_fetch_assoc($u_exist);

    ?>

    <div class="container">
        <div class="row">

            <div class="my-5 px-4">
                <h2 class="fw-bold">Profile</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">Home</a>
                    <span class="text-secondary"> > </span>
                    <a href="#" class="text-secondary text-decoration-none">Profile</a>
                </div>
            </div>
            <div class="col-12 mb-5 px-4">
                <div class="bg-white p-3 p-m-4 rounded shadow-sm">
                    <form id="infor-form">
                        <h5 class="mb-3 fw-bold">Basic Information</h5>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Name</label>
                                <input name="name" type="text" value="<?php echo $u_fetch['name'] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Email</label>
                                <input name="email" type="text" value="<?php echo $u_fetch['email'] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input name="phonenum" type="number" value="<?php echo $u_fetch['phonenum'] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Password</label>
                                <input name="password" type="password" value="<?php echo $u_fetch['password'] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control shadow-none" rows="1" required><?php echo $u_fetch['address'] ?></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn text-white custom-bg shadow-none">Save Changes</button>
                    </form>
                </div>

            </div>

            <h5 class="mb-3">Reviews and ratings</h5>
            <div>
                <div class="d-flex align-items-center mb-2">
                    <img src="./images//facilities/star.png" width="30px">
                    <h6 class="m-2 ms-2">Tran Tien Hung</h6>
                </div>
                <p>
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                    Fugit consequatur omnis repellat quam. Delectus quos magnam, consequatur at error,
                    ducimus soluta dignissimos itaque a molestias est nemo, iste nisi porro.
                </p>
                <div class="rating">
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                </div>
            </div>





        </div>


    </div>
    <?php require('inc/footer.php'); ?>
    <script>
        let infor_form = document.getElementById('infor-form');
        infor_form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    let data = new FormData();
                    data.append('infor_form', '');
                    data.append('name', infor_form.elements['name'].value);
                    data.append('email', infor_form.elements['email'].value);
                    data.append('phonenum', infor_form.elements['phonenum'].value);
                    data.append('password', infor_form.elements['password'].value);
                    data.append('address', infor_form.elements['address'].value);

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "ajax/profile.php", true);

                    xhr.onload = function() {
                        if (this.responseText == 'phone_already') {
                            alert('error',"Phone number is already registerd");
                           
                        }
                        else if(this.responseText==0){
                            alert('error',"No changes made");
                        }
                        else{
                            alert('success',"Changes saved");
                        }


                    }
                    xhr.send(data);
                })
    </script>


</body>

</html>