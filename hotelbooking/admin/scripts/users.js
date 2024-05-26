
function get_users() {
    // Tạo một đối tượng XMLHttpRequest mới
    let xhr = new XMLHttpRequest();

    // Cấu hình yêu cầu: Phương thức POST, URL đích "ajax/settings_crud.php", không đồng bộ
    xhr.open("POST", "ajax/users.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


    // Hàm gọi lại để xử lý phản hồi khi nó được nhận
    xhr.onload = function () {
        document.getElementById('users-data').innerHTML = this.responseText;
    }
    // Gửi yêu cầu với dữ liệu
    xhr.send('get_users');
}

function toggle_status(id, val) {
    // Tạo một đối tượng XMLHttpRequest mới
    let xhr = new XMLHttpRequest();

    // Cấu hình yêu cầu: Phương thức POST, URL đích "ajax/settings_crud.php", không đồng bộ
    xhr.open("POST", "ajax/users.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


    // Hàm gọi lại để xử lý phản hồi khi nó được nhận
    xhr.onload = function () {
        if (this.responseText == 1) {
            alert('success', 'Status toggled!');
            get_users();
        }
        else {
            alert('error', 'Server Down');
        }
    }
    // Gửi yêu cầu với dữ liệu
    xhr.send('toggle_status=' + id + '&value=' + val);
}

function remove_user(user_id) {
    if (confirm("Are you sure, you want to delete this user?")) {
        let data = new FormData();
        data.append('user_id', user_id);
        data.append('remove_user', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/users.php", true);

        xhr.onload = function () {
            if (this.responseText == 1) {
                alert('success', 'User Removed!');
                get_users();
            }
            else {
                alert('error', 'User Removed failed!');
            }
        };
        xhr.send(data);
    }
}

function search_user_auto(username) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users.php", true);

    xhr.onload = function () {
        document.getElementById('users-data').innerHTML = this.responseText;
    };

    if (xhr.status >= 200 && xhr.status < 300) {
        // Xử lý phản hồi ở đây nếu cần.
    }

    if (username.trim() === "") {
        // Nếu ô tìm kiếm rỗng, thực hiện truy vấn để lấy tất cả dữ liệu
        xhr.send('get_all_users');
    } else {
        // Nếu ô tìm kiếm không rỗng, thực hiện tìm kiếm theo tên
        xhr.send('search_user&name=' + username);
    }
}

// Thêm sự kiện input để gọi hàm tìm kiếm khi người dùng nhập vào ô input
document.getElementById('search-input').addEventListener('input', function () {
    search_user_auto(this.value);
});
window.onload = function () {
    get_users();
}