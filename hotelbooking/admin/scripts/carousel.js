let contacts_s_form =document.getElementById('contacts_s_form');

let carousel_s_form =document.getElementById('carousel_s_form');
let carousel_picture_inp =document.getElementById('carousel_picture_inp');


carousel_s_form.addEventListener('submit', function(e){
    e.preventDefault();
    add_image();
});

function add_image(){
    let data = new FormData();
    data.append('picture', carousel_picture_inp.files[0]);
    data.append('add_image', '');

    // Tạo một đối tượng XMLHttpRequest mới
    let xhr = new XMLHttpRequest();

    // Cấu hình yêu cầu: Phương thức POST, URL đích "ajax/settings_crud.php", không đồng bộ
    xhr.open("POST", "ajax/carousel_crud.php", true);

    // Hàm gọi lại để xử lý phản hồi khi nó được nhận
    xhr.onload = function(){

        var myModal = document.getElementById('carousel-s')
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if(this.responseText == 'inv_img'){
            alert('error', 'Only JPG and PNG images are allowed');
        }
        else if(this.responseText == 'inv_size'){
            alert('error', 'Image should be less than 2MB!');
        }
        else if(this.responseText == 'upd_failed'){
            alert('error', 'Image upload failed!');
        }
        else{
            alert('success', 'New Image added!');
            carousel_picture_inp.value = '';
            get_carousel();

        }
    }
    // Gửi yêu cầu với dữ liệu
    xhr.send(data);
}

function get_carousel(){
    let xhr = new XMLHttpRequest();

    // Cấu hình yêu cầu: Phương thức POST, URL đích "ajax/settings_crud.php", không đồng bộ
    xhr.open("POST", "ajax/carousel_crud.php", true);

    // Đặt tiêu đề yêu cầu để xác định loại nội dung
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Hàm gọi lại để xử lý phản hồi khi nó được nhận
    xhr.onload = function(){
        document.getElementById('carousel-data').innerHTML = this.responseText;
    }

    xhr.send('get_carousel');
}

function rem_image(val){
let xhr = new XMLHttpRequest();

// Cấu hình yêu cầu: Phương thức POST, URL đích "ajax/settings_crud.php", không đồng bộ
xhr.open("POST", "ajax/carousel_crud.php", true);

// Đặt tiêu đề yêu cầu để xác định loại nội dung
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

// Hàm gọi lại để xử lý phản hồi khi nó được nhận
xhr.onload = function(){
    if(this.responseText==1){
        alert('success', 'Image removed');
        get_carousel();
    }
    else{
        alert('error', 'Server down');
    }
}

xhr.send('rem_image='+val);
}


window.onload = function () {
    get_carousel();
}


