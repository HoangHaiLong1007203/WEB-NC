<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <?php require('inc/links.php') ?>
    <?php
    $searchTerm = isset($_GET['search_query']) ? $_GET['search_query'] : '';
    ?>
    <title>Search for "<?php echo $searchTerm ?>"</title>
<style>
        .availability-form{
            margin-top: -50px;
            z-index: 2;
            position: relative;
        }
        .highlight {
            background-color: yellow; /* Màu nền highlight */
            font-weight: bold; /* In đậm chữ */
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

    <!-- out rooms-->
    
    <h2 class="mt-5 pt-4 mb-4 fw-bold h-font container">
        Search result for "<?php echo htmlspecialchars($searchTerm); ?>"
    </h2>

    <div class="container">
        <div class="row">
            <?php
            // Hàm để highlight từ khóa tìm kiếm
                function highlightSearchTerm($text, $searchTerm) {
                    $highlightedText = preg_replace("/" . preg_quote($searchTerm, '/') . "/i", '<span class="highlight">$0</span>', $text);
                    return $highlightedText;
                }
                $room_res = select("SELECT DISTINCT r.* FROM rooms r
                LEFT JOIN room_features rf ON r.id = rf.room_id
                LEFT JOIN features f ON rf.features_id = f.id
                LEFT JOIN room_facilities rfac ON r.id = rfac.room_id
                LEFT JOIN facilities fac ON rfac.facilities_id = fac.id
                WHERE r.`status`=? AND r.`removed`=? AND (r.name LIKE CONCAT('%', ?, '%')
                OR f.name LIKE CONCAT('%', ?, '%')
                OR fac.name LIKE CONCAT('%', ?, '%'))
                ORDER BY r.`id` DESC LIMIT 30", [1, 0, $searchTerm, $searchTerm, $searchTerm], 'iisss');
                // Kiểm tra số lượng hàng trả về
                if(mysqli_num_rows($room_res) > 0) {
                    // Có phòng được tìm thấy, hiển thị thông tin phòng
                    while($room_data = mysqli_fetch_assoc($room_res))
                    {
                        // Highlight tên phòng
                        $room_name_highlighted = highlightSearchTerm($room_data['name'], $searchTerm);

                        //Lấy đặc tính của phòng

                        $fea_q = mysqli_query($con, "SELECT f.name FROM `features` f 
                        INNER JOIN `room_features` rfea ON f.id = rfea.features_id
                        WHERE rfea.room_id = '$room_data[id]'");

                        // Highlight đặc tính
                        $features_data = "";
                        while($fea_row = mysqli_fetch_assoc($fea_q)){
                            $features_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>" .
                                            highlightSearchTerm($fea_row['name'], $searchTerm) .
                                            "</span>";
                        }

                        //Lấy tiện nghi của phòng

                        $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f 
                        INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id
                        WHERE rfac.room_id = '$room_data[id]'");

                        // Highlight tiện nghi
                        $facilities_data = "";
                        while($fac_row = mysqli_fetch_assoc($fac_q)){
                            $facilities_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>" .
                                                highlightSearchTerm($fac_row['name'], $searchTerm) .
                                                "</span>";
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
                                        <h5 class="mb-3">$room_name_highlighted</h5>
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
                } else {
                    // Không có phòng nào được tìm thấy, hiển thị thông báo
                    echo '<div class="d-flex justify-content-center align-items-center" style="height: 20vh;">';
                    echo '<h2 class="text-center h-font fs-5">No results are found!</h2>';
                    echo '</div>';
                }
            ?>

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