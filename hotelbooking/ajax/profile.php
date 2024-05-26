<?php 
    require('../admin/inc/db_config.php');
    require('../admin/inc/esentials.php');
    date_default_timezone_set("Asia/Ho_Chi_Minh");

    if(isset($_POST['infor_form'])){
        $frm_data= filteration($_POST);
        session_start();
        $u_exist = select("SELECT * FROM `user_cred` WHERE `phonenum`=? AND `id`!=? LIMIT 1", 
        [$data['phonenum'], $_SESSION['uId']], "ss");
        if(mysqli_num_rows($u_exist)!=0){

           echo 'phone_already';
            exit;
        }
        $query="UPDATE `user_cred` SET `name`=?,`email`=?,`address`=?,`phonenum`=?,`password`=? WHERE `id`=?";
        $values= [$frm_data['name'],$frm_data['email'],$frm_data['adress'],$frm_data['phonenum'],$frm_data['password'],$_SESSION['uId']];
        if(update($query,$values,'ssssss')){
            $_SESSION['uName']=$frm_data['name'];

            echo 1;

        }
        else{
               echo 0;

        }


    }
?>
