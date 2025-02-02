<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <?php require('inc/links.php') ?>
    <title><?php echo $settings_r['site_title'] ?> - HOME</title>
<style>
        .availability-form{
            margin-top: -50px;
            z-index: 2;
            position: relative;
        }

        @media screen and (max-width: 575px){
            .availability-form{
                margin-top: 25px;
                padding: 0 35px;
            }
        }
</style>
</head>
<body class="bg-light">
    <?php require('inc/header.php') ?>

    <!--Carousel-->
    <div class="container-fluid px-lg-4 mt-4">
        <div class="swiper-container Swiper">
            <div class="swiper-wrapper">
                <?php
                    $res = selectAll('carousel');

                    while($row = mysqli_fetch_assoc($res)){
                        $path = CAROUSEL_IMG_PATH;
                        echo <<<data
                            <div class="swiper-slide">
                                <img src="$path$row[image]" class="w-100 d-block" />
                            </div>
                        data;
                    }
                ?>
            </div>
        </div>
    </div>

    <!-- check availability form-->
    <div class="container availability-form">
        <div class="row">
            <div class="col-lg-12 bg-white shadow p-4 rounded">
                <h5 class="mb-4">Check Booking Avaibility</h5>
                <form >
                    <div class="row align-items-end">
                        <div class="col-lg-3 mb-3">
                            <label for="form-lable" style="font-weight: 500">Check-in</label>
                            <input type="date" class="form-control shadow-none mt-3">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label for="form-lable" style="font-weight: 500">Check-out</label>
                            <input type="date" class="form-control shadow-none mt-3">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label for="form-lable" style="font-weight: 500">Adults</label>
                            <select class="form-select shadow-none mt-3">
                                <option selected>0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                        <div class="col-lg-2 mb-3">
                            <label for="form-lable" style="font-weight: 500">Childrens</label>
                            <select class="form-select shadow-none mt-3">
                                <option selected>0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                        <div class="col-lg-1 mb-lg-3 mb-2">
                            <button type="submit" class="btn text-white shadow-none custom-bg">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- out rooms-->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">ROOM SELECTION</h2>

    <div class="container">
        <div class="row">

                <?php
                    $room_res = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=? ORDER BY `id` DESC LIMIT 3", [1,0], 'ii');
                    while($room_data = mysqli_fetch_assoc($room_res))
                    {
                        //Lấy đặc tính của phòng

                        $fea_q = mysqli_query($con, "SELECT f.name FROM `features` f 
                        INNER JOIN `room_features` rfea ON f.id = rfea.features_id
                        WHERE rfea.room_id = '$room_data[id]'");


                        $features_data = "";
                        while($fea_row = mysqli_fetch_assoc($fea_q)){
                            $features_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                                       $fea_row[name]
                                    </span>";
                        }

                        //Lấy tiện nghi của phòng

                        $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f 
                        INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id
                        WHERE rfac.room_id = '$room_data[id]'");


                            $facilities_data = "";
                            while($fac_row = mysqli_fetch_assoc($fac_q)){
                            $facilities_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                                       $fac_row[name]
                                    </span>";
                        }

                        //Lấy hình thu nhỏ hoặc hình ảnh

                        $room_thumb = ROOMS_IMG_PATH."1.jpg";
                        $thumb_q = mysqli_query($con, "SELECT * FROM `room_images`
                        WHERE `room_id`='$room_data[id]' AND `thumb`='1'");

                        if (mysqli_num_rows($thumb_q) > 0){
                            $thumb_res = mysqli_fetch_assoc($thumb_q);
                            $room_thumb = ROOMS_IMG_PATH.$thumb_res['image'];
                        }

                        $book_btn ="";
                        if ( !$settings_r['shutdown']){
                            $login=0;
                            if(isset($_SESSION['login']) && $_SESSION['login'] == true)
                            {
                                $login=1;
                            }

                            $book_btn ="<button onclick='checkLoginToBook($login,$room_data[id])' class='btn btn-sm w-100 text-white custom-bg shadow-none mb-2'>Booking Room</button>";
                        }

                        //In thẻ phòng
                        echo <<<data
                            <div class="card mb-4 border-0 shadow">
                                <div class="row g-0 p-3 align-items-center">
                                    <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                                        <img src="$room_thumb" class="img-fluid rounded">
                                    </div>
                                    <div class="col-md-5 px-lg-3 px-md-3 px-0">
                                        <h5 class="mb-3">$room_data[name]</h5>
                                        <div class="features mb-3">
                                                <h6 class="mb-1">Features</h6>
                                               $features_data 
                                        </div>
                                        <div class="facilities mb-3">
                                            <h6 class="mb-1">Facilities</h6>
                                            $facilities_data
                                        </div>
                                        <div class="guests">
                                            <h6 class="mb-1">Quantity</h6>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                $room_data[adult] Adults
                                            </span>
                                            <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                $room_data[children] Childrens
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
                                        <h6>$room_data[price]/Day</h6>
                                        $book_btn
                                        <a href="room_details.php?id=$room_data[id]" class="btn btn-sm w-100 btn-outline-dark shadow-none">More details</a>
                                    </div>
                                </div>
                            </div>
                        data;

                    }
                ?>
        </div>
        <div class="col-lg-12 text-center mt-5">
            <a href="Rooms.php" class="btn btn-sm btn-outline-dark  rounded-0 fw-bold shadow-none">ADD >>>></a>
        </div>
    </div>

    <!--OUT FACILITIES-->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">FACILITIES</h2>
    <div class="container">
        <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">

                <?php
                    $res = mysqli_query($con, "SELECT * FROM `facilities` ORDER BY `id` DESC LIMIT 5");
                    $path = FACILITIES_IMG_PATH;

                    while($row = mysqli_fetch_assoc($res)){
                        echo<<<data
                            <div class="col-lg-4 col-md-6 mb-5 px-4">
                                <div class="bg-white rounded shadow p-4 border-top border-4 border-dank pop">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="$path$row[icon]" width="40px">
                                        <h5 class="m-0 ms-3">$row[name]</h5>
                                    </div>
                                </div>
                            </div>
                        data;
                    }
                ?>
                <div class="col-lg-12 text-center mt-5">
                    <a href="Facilities.php" class="btn btn-sm btn-outline-dark  rounded-0 fw-bold shadow-none">ADD >>>></a>
                </div>
            
        </div>
    </div>

    <!--Testimonials-->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">CERTIFIED BY</h2>
    <div class="container mt-5">
        <div class="swiper-testimonials swiper">
        <div class="swiper-wrapper mb-5">
            <div class="swiper-slide bg-white p-4">
                <div class="profile d-flex align-items-center mb-3">
                    <img src="./images//facilities/star.png" width="30px">
                    <h6 class="m-0 ms-2">Hoang Hai Long</h6>
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
            <div class="swiper-slide bg-white p-4">
                <div class="profile d-flex align-items-center mb-3">
                    <img src="./images//facilities/star.png" width="30px">
                    <h6 class="m-0 ms-2">Tran Tien Hung</h6>
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
            <div class="swiper-slide bg-white p-4">
                <div class="profile d-flex align-items-center mb-3">
                    <img src="./images//facilities/star.png" width="30px">
                    <h6 class="m-0 ms-2">Tran Tien Hung</h6>
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
            <div class="swiper-slide bg-white p-4">
                <div class="profile d-flex align-items-center mb-3">
                    <img src="./images//facilities/star.png" width="30px">
                    <h6 class="m-0 ms-2">Vu Minh Ngoc</h6>
                </div>
                <p>
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                     Fugit consequatur omnis repellat quam. Delectus quos magnam, consequatur at error.
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
        <div class="swiper-pagination"></div>
        </div>
        <div class="col-lg-12 text-center mt-5">
            <a href="About.php" class="btn btn-sm btn-outline-dark  rounded-0 fw-bold shadow-none">Add >>>></a>
        </div>
    </div>

    <!--Reach us-->


    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Location</h2>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
            <iframe class="w-100 rounded" height="320" src="<?php echo $contact_r['iframe'] ?>" loading="lazy" ></iframe>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="bg-white p-4 rounded mb-4">
                    <h5>Contact Us</h5>
                    <a href="tel: +<?php echo $contact_r['pn1'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> +<?php echo $contact_r['pn1'] ?>
                    </a>
                    <br>
                    <?php  
                        if($contact_r['pn2']!=''){
                            echo<<<data
                                <a href="tel: +$contact_r[pn2]" class="d-inline-block text-decoration-none text-dark">
                                    <i class="bi bi-telephone-fill"></i>+$contact_r[pn2]
                                </a>
                            data;
                        }
                    
                    ?>
                </div>
                <div class="bg-white p-4 rounded mb-4">
                    <h5>Links</h5>
                    <?php  
                        if($contact_r['fb']!=''){
                            echo<<<data
                                <a href="#" class="d-inline-block mb-3">
                                    <span class="badge bg-white text-dark fs-6 p-2">
                                        <i class="bi bi-facebook me-1"></i>Facebook
                                    </span>
                                </a>
                                <br>
                            data;
                        }
                    
                    ?>

                    <a href="<?php echo $contact_r['tw'] ?>" class="d-inline-block mb-3">
                        <span class="badge bg-white text-dark fs-6 p-2">
                            <i class="bi bi-twitter me-1"></i>Twitter
                        </span>
                    </a>
                    <br>
                    <a href="<?php echo $contact_r['tt'] ?>" class="d-inline-block mb-3">
                        <span class="badge bg-white text-dark fs-6 p-2">
                            <i class="bi bi-tiktok me-1"></i>Tiktok
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <?php require('inc/footer.php') ?>

    
   
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
      var swiper = new Swiper(".swiper-container", {
        spaceBetween: 30,
        effect: "fade",
        loop: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction:false,
        }
      });

      var swiper = new Swiper(".swiper-testimonials", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        slidesPerView: "3",
        loop:true,
        coverflowEffect: {
          rotate: 50,
          stretch: 0,
          depth: 100,
          modifier: 1,
          slideShadows: false,
        },
        pagination: {
          el: ".swiper-pagination",
        },
        breakpoints:{
            320:{
                slidesPerView: 1,
            },
            640:{
                slidesPerView: 1,
            },
            768:{
                slidesPerView: 2,
            }, 
            1024:{
                slidesPerView: 3,
            },
        }
      });

      
    </script>

</body>
</html>