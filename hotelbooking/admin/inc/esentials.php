<?php

//froned purpose data
    define('SITE_URL','http://127.0.0.1/hotelbooking/');
    define('ABOUT_IMG_PATH', SITE_URL.'images/about/');
    define('CAROUSEL_IMG_PATH', SITE_URL.'images/carousel/');
    define('FACILITIES_IMG_PATH', SITE_URL.'images/facilities/');
    define('ROOMS_IMG_PATH', SITE_URL.'images/rooms/');
    define('MONEY_IMG_PATH', SITE_URL.'images/Money/');

    

//backend upload process needs this data

    define('UPLOAD_IMAGE_PATH',$_SERVER['DOCUMENT_ROOT'].'/hotelbooking/images/');
    define('ABOUT_FOLDER', 'about/');
    define('CAROUSEL_FOLDER', 'carousel/');
    define('FACILITIES_FOLDER', 'facilities/');
    define('ROOMS_FOLDER', 'rooms/');
    define('MONEY_FOLDER', 'Money/');




    function adminLogin(){
        session_start();
        if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)){
            echo"<script>
                window.location.href='index.php';
            </script>";
            exit;
        }
    }


    function redirect($url){
        echo"<script>
            window.location.href='$url';
        </script>";
        exit;
    }


    function alert($type, $msg){
        $bs_class = ($type == "success") ? "alert-success" : "alert-danger";
        echo <<<alert
            <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
                <strong class="me-3">$msg</strong> 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        alert;
    }

    function uploadImage($image, $folder)
    {
        $valid_mine = ['image/jpeg', 'image/png', 'image/webp'];
        $img_mine = $image['type'];

        if(!in_array($img_mine,$valid_mine)){
            return 'inv_img';
        }else if(($image['size']/(1024*1024)) > 2){
            return 'inv_size';
        }else{
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $rname = 'IMG_'.random_int(11111,99999).".$ext";

            $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
            if (move_uploaded_file($image['tmp_name'], $img_path)) {
                return $rname;
            } else {
                $error = error_get_last();
                return 'upd_failed: ' . $error['message'];
            }
            
        }
    }

    function deleteImage($image, $folder){
        if(unlink(UPLOAD_IMAGE_PATH.$folder.$image)){
            return true;
        }
        else{
            return false;
        }
    }

    function uploadSVGImage($image, $folder)
    {
        $valid_mine = ['image/svg+xml'];
        $img_mine = $image['type'];

        if(!in_array($img_mine,$valid_mine)){
            return 'inv_img';
        }else if(($image['size']/(1024*1024)) > 1){
            return 'inv_size';
        }else{
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $rname = 'IMG_'.random_int(11111,99999).".$ext";

            $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
            if (move_uploaded_file($image['tmp_name'], $img_path)) {
                return $rname;
            } else {
                $error = error_get_last();
                return 'upd_failed';
            }
            
        }
    }

?>