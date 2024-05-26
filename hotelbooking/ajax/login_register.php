<?php 
    require('../admin/inc/db_config.php');
    require('../admin/inc/esentials.php');
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    
    if(isset($_POST['register'])){
        $data = filteration($_POST);

        //Khớp trường mật khẩu và xác nhận mật khẩu
        if(trim($data['pass']) != trim($data['cpass'])){
            echo 0;
            exit;
        }

        //kiem tra xem tai khoan co ton tai khong
        $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? OR `phonenum`=? LIMIT 1", 
        [$data['email'], $data['phonenum']], "ss");

        if(mysqli_num_rows($u_exist) != 0){
            $u_exist_fetch = mysqli_fetch_assoc($u_exist);
            echo ($u_exist_fetch['email'] == $data['email']) ? 3 : 4;
            exit;
        }
        
        $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);

        $query = "INSERT INTO `user_cred`(`name`, `email`, `address`, `phonenum`, `password`) VALUES (?,?,?,?,?)";

        $values =[$data['name'],$data['email'],$data['address'],$data['phonenum'], $enc_pass];
        if (insert($query, $values, 'sssss')){
            echo 1;
        }
        else{
            echo 'ins_failed: ';
        }
    }

    if(isset($_POST['login'])){
        $data  = filteration($_POST);

        $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? OR `phonenum`=? LIMIT 1", 
        [$data['email_mob'], $data['email_mob']], "ss");

        if(mysqli_num_rows($u_exist) == 0){
            echo 0;
            exit;
        }
        else
        {
            $u_fetch = mysqli_fetch_assoc($u_exist);
            if($u_fetch['status'] ==0){
                echo 2;
            }
            else{
                if(!password_verify($data['pass'], $u_fetch['password'])){
                    echo 3;
                }
                else{
                    session_start();
                    $_SESSION['login'] = true;
                    $_SESSION['uId'] = $u_fetch['id'];
                    $_SESSION['uName'] = $u_fetch['name'];
                    $_SESSION['uPhone'] = $u_fetch['phonenum'];
                    echo 1;
                }
            }
        }
       
    }

    if (isset($_POST['forgot_pass'])) {
    // Lấy dữ liệu từ form và kiểm tra hợp lệ
    $data = filteration($_POST);

    // Kiểm tra xem số điện thoại có tồn tại trong cơ sở dữ liệu hay không
    $u_exist = select("SELECT * FROM `user_cred` WHERE `phonenum`=? LIMIT 1", [$data['phonenum']], "s");

    if (mysqli_num_rows($u_exist) == 0) {
        // Số điện thoại không hợp lệ
        echo 0;
    } else {
        // Mật khẩu mới
        $new_password = $data['pass'];

        // Mã hóa mật khẩu mới
        $enc_new_password = password_hash($new_password, PASSWORD_BCRYPT);

        // Câu lệnh SQL cập nhật mật khẩu
        $query = "UPDATE `user_cred` SET `password`=? WHERE `phonenum`=?";
        
        // Giá trị sử dụng trong câu lệnh SQL
        $values = [$enc_new_password, $data['phonenum']];

        // Thực hiện cập nhật mật khẩu
        $update_result = update($query, $values, 'ss');

        if ($update_result) {
            // Cập nhật mật khẩu thành công
            echo 1;
        } else {
            // Cập nhật mật khẩu không thành công
            echo 2;
        }
    }
}


//THANH TOAN
    if(isset($_POST['pay_form'])){
        $data= filteration($_POST);
        if($data['stk'] == '123456'){
            echo 1;
        }
        else{
            echo 0;
        }
    }
    
?>