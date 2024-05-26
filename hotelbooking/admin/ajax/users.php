<?php 
    require('../inc/db_config.php');
    require('../inc/esentials.php');
    adminLogin();

    if(isset($_POST['get_users'])){
        $res = selectAll('user_cred');
        $i = 1;

        $data = "";

        while($row = mysqli_fetch_assoc($res))
        {

            $del_btn ="<button type='button' onclick='remove_user($row[id])' class='btn btn-danger shadow-none btn-sm' >
                        <i class='bi bi-trash'></i>
                    </button>";

            $status ="<button onclick='toggle_status($row[id],0)' class='btn btn-dark btn-sm shadow-none'>
                active
                </button>";

            if(!$row['status']){
                $status ="<button onclick='toggle_status($row[id],1)' class='btn btn-danger btn-sm shadow-none'>
                inactive
                </button>";
            }

            $date = date("d-n-Y", strtotime($row['datentime']));

            $data.="
                <tr class='align-middle'>
                    <td>$i</td>
                    <td>$row[name]</td>
                    <td>$row[email]</td>
                    <td>$row[phonenum]</td>
                    <td>$row[address]</td>
                    <td>$status</td>
                    <td>$date</td>
                    <td>$del_btn</td>
                </tr>
            ";
            $i++;
        }
        echo $data;
    }

    if(isset($_POST['toggle_status'])){
        $frm_data = filteration($_POST);

        $q = "UPDATE `user_cred` SET `status`=? WHERE `id`=?";
        $v = [$frm_data['value'],$frm_data['toggle_status']];

        if(update($q,$v,'ii')){
            echo 1;
        }
        else{
            echo 0;
        }
    }


    if(isset($_POST['remove_user']))
    {
        $frm_data = filteration($_POST);
        
        $res = delete("DELETE FROM `user_cred`  WHERE `id`=?",[$frm_data['user_id']], 'i');

        if ($res){
            echo 1;
        }
        else {
            echo 0;
        }
    }

// Thêm kiểm tra tồn tại để đảm bảo rằng dữ liệu chỉ được trả về khi có yêu cầu tìm kiếm
if (isset($frm_data['search_user'])) {
    $query = "SELECT * FROM `user_cred` WHERE `name` LIKE ?";
    $res = select($query, ["%" . mysqli_real_escape_string($connection, $frm_data['name']) . "%"], 's');
    $i = 1;
    $data = "";

    while ($row = mysqli_fetch_assoc($res)) {
        $del_btn ="<button type='button' onclick='remove_user($row[id])' class='btn btn-danger shadow-none btn-sm' >
                        <i class='bi bi-trash'></i>
                    </button>";

            $status ="<button onclick='toggle_status($row[id],0)' class='btn btn-dark btn-sm shadow-none'>
                active
                </button>";

            if(!$row['status']){
                $status ="<button onclick='toggle_status($row[id],1)' class='btn btn-danger btn-sm shadow-none'>
                inactive
                </button>";
            }

            $date = date("d-n-Y", strtotime($row['datentime']));

            $data.="
                <tr class='align-middle'>
                    <td>$i</td>
                    <td>$row[name]</td>
                    <td>$row[email]</td>
                    <td>$row[phonenum]</td>
                    <td>$row[address]</td>
                    <td>$status</td>
                    <td>$date</td>
                    <td>$del_btn</td>
                </tr>
            ";
            $i++;
    }

    echo $data;
} elseif (isset($frm_data['get_all_users'])) {
    // Nếu có yêu cầu lấy tất cả dữ liệu, thực hiện truy vấn và trả về kết quả
    $query = "SELECT * FROM `user_cred`";
    $res = selectAll($query);

    $i = 1;
    $data = "";

    while ($row = mysqli_fetch_assoc($res)) {
        $del_btn ="<button type='button' onclick='remove_user($row[id])' class='btn btn-danger shadow-none btn-sm' >
                        <i class='bi bi-trash'></i>
                    </button>";

            $status ="<button onclick='toggle_status($row[id],0)' class='btn btn-dark btn-sm shadow-none'>
                active
                </button>";

            if(!$row['status']){
                $status ="<button onclick='toggle_status($row[id],1)' class='btn btn-danger btn-sm shadow-none'>
                inactive
                </button>";
            }

            $date = date("d-n-Y", strtotime($row['datentime']));

            $data.="
                <tr class='align-middle'>
                    <td>$i</td>
                    <td>$row[name]</td>
                    <td>$row[email]</td>
                    <td>$row[phonenum]</td>
                    <td>$row[address]</td>
                    <td>$status</td>
                    <td>$date</td>
                    <td>$del_btn</td>
                </tr>
            ";
            $i++;
    }

    echo $data;
}

?>
