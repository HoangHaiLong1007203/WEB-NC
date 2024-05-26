
let general_data;
let contacts_data;

let general_s_form =document.getElementById('general_s_form');
let site_title_inp = document.getElementById('site_title_inp');
let site_about_inp = document.getElementById('site_about_inp');

let contacts_s_form =document.getElementById('contacts_s_form');

let team_s_form =document.getElementById('team_s_form');
let member_name_inp =document.getElementById('member_name_inp');
let member_picture_inp =document.getElementById('member_picture_inp');

function get_general(){
    // Lấy các phần tử có ID là 'site_title' và 'site_about'
    let site_title = document.getElementById('site_title');
    let site_about = document.getElementById('site_about');

    let shutdown_toggle =document.getElementById('shutdown-toggle');

    // Tạo một đối tượng XMLHttpRequest mới
    let xhr = new XMLHttpRequest();

    // Cấu hình yêu cầu: Phương thức POST, URL đích "ajax/settings_crud.php", không đồng bộ
    xhr.open("POST", "ajax/settings_crud.php", true);

    // Đặt tiêu đề yêu cầu để xác định loại nội dung
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Hàm gọi lại để xử lý phản hồi khi nó được nhận
    xhr.onload = function(){
        // Phân tích văn bản phản hồi (giả sử là JSON) và lưu trữ vào general_data
        general_data = JSON.parse(this.responseText);

        // Cập nhật nội dung của các phần tử với dữ liệu đã nhận
        site_title.innerText = general_data.site_title;
        site_about.innerText = general_data.site_about;

        site_title_inp.value =general_data.site_title;
        site_about_inp.value =general_data.site_about;

        if(general_data.shutdown == 0){
            shutdown_toggle.ariaChecked =false;
            shutdown_toggle.value = 0;
        }
        else{
            shutdown_toggle.ariaChecked = true;
            shutdown_toggle.value = 1;
        }
    }

    xhr.send('get_general');
}

general_s_form.addEventListener('submit', function(e){
    e.preventDefault();
    upd_general(site_title_inp.value, site_about_inp.value);
});

function upd_general(site_title_val, site_about_val){
    // Tạo một đối tượng XMLHttpRequest mới
    let xhr = new XMLHttpRequest();

    // Cấu hình yêu cầu: Phương thức POST, URL đích "ajax/settings_crud.php", không đồng bộ
    xhr.open("POST", "ajax/settings_crud.php", true);

    // Đặt tiêu đề yêu cầu để xác định loại nội dung
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Hàm gọi lại để xử lý phản hồi khi nó được nhận
    xhr.onload = function(){

        var myModal = document.getElementById('general-s')
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if(this.responseText == 1){
            alert('success', 'Đã lưu thay đổi!');
            get_general();
        }
        else{
            alert('error', 'Không có thay đổi!');
        }
    }

    // Gửi yêu cầu với dữ liệu "getn_general"
    xhr.send('site_title='+site_title_val+'&site_about='+site_about_val+'&upd_general');
}

function upd_shutdown(val){
    // Tạo một đối tượng XMLHttpRequest mới
    let xhr = new XMLHttpRequest();

    // Cấu hình yêu cầu: Phương thức POST, URL đích "ajax/settings_crud.php", không đồng bộ
    xhr.open("POST", "ajax/settings_crud.php", true);

    // Đặt tiêu đề yêu cầu để xác định loại nội dung
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Hàm gọi lại để xử lý phản hồi khi nó được nhận
    xhr.onload = function(){
        if(this.responseText == 1 && general_data.shutdown==0){
            alert('success', 'Site has been shutdown!');
        }
        else{
            alert('success', 'Shutdown mode off!');
        }
        get_general();
    }

    // Gửi yêu cầu với dữ liệu "getn_general"
    xhr.send('upd_shutdown='+val);           
}

function get_contacts(){
    let contacts_p_id = ['address', 'gmap', 'pn1', 'pn2', 'email', 'fb', 'tw', 'tt'];
    let iframe = document.getElementById('iframe');

    // Tạo một đối tượng XMLHttpRequest mới
    let xhr = new XMLHttpRequest();

    // Cấu hình yêu cầu: Phương thức POST, URL đích "ajax/settings_crud.php", không đồng bộ
    xhr.open("POST", "ajax/settings_crud.php", true);

    // Đặt tiêu đề yêu cầu để xác định loại nội dung
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Hàm gọi lại để xử lý phản hồi khi nó được nhận
    xhr.onload = function(){
        // Phân tích văn bản phản hồi (giả sử là JSON) và lưu trữ vào general_data
        contacts_data = JSON.parse(this.responseText);
        contacts_data = Object.values(contacts_data);
        for(i=0; i<contacts_p_id.length; i++){
            document.getElementById(contacts_p_id[i]).innerText =contacts_data[i+1];
        }

        iframe.src =contacts_data[9];
        contacts_inp(contacts_data);
    }

    xhr.send('get_contacts');
}

function contacts_inp(data){
    let contacts_inp_id = ['address_inp', 'gmap_inp', 'pn1_inp', 'pn2_inp', 'email_inp', 'fb_inp', 'tw_inp', 'tt_inp', 'iframe_inp'];

    for(i=0; i<contacts_inp_id.length; i++){
        document.getElementById(contacts_inp_id[i]).value = data[i+1];
    }
}

contacts_s_form.addEventListener('submit', function(e){
    e.preventDefault();
    upd_contacts();
});

function upd_contacts(){
    let index = ['address', 'gmap','pn1','pn2','email', 'fb', 'tw', 'tt', 'iframe'];
    let contacts_inp_id = ['address_inp', 'gmap_inp','pn1_inp','pn2_inp','email_inp', 'fb_inp', 'tw_inp', 'tt_inp', 'iframe_inp'];
    let data_str = "";

    for(i=0;i<index.length;i++){
        data_str += index[i] + "=" + document.getElementById(contacts_inp_id[i]).value + '&';
    }
    data_str += "upd_contacts";
    // Tạo một đối tượng XMLHttpRequest mới
    let xhr = new XMLHttpRequest();

    // Cấu hình yêu cầu: Phương thức POST, URL đích "ajax/settings_crud.php", không đồng bộ
    xhr.open("POST", "ajax/settings_crud.php", true);

    // Đặt tiêu đề yêu cầu để xác định loại nội dung
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){         
        var myModal = document.getElementById('contacts-s')
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if((this.responseText.trim() === '1')){
            alert('success', 'Changes saved!');
            get_contacts();
        }
        else{
            alert('error', 'No Changes saved!');
        }
    }

    xhr.send(data_str);
}

team_s_form.addEventListener('submit', function(e){
    e.preventDefault();
    add_member();
});

function add_member(){
    let data = new FormData();
    data.append('name', member_name_inp.value);
    data.append('picture', member_picture_inp.files[0]);
    data.append('add_member', '');

    // Tạo một đối tượng XMLHttpRequest mới
    let xhr = new XMLHttpRequest();

    // Cấu hình yêu cầu: Phương thức POST, URL đích "ajax/settings_crud.php", không đồng bộ
    xhr.open("POST", "ajax/settings_crud.php", true);

    // Hàm gọi lại để xử lý phản hồi khi nó được nhận
    xhr.onload = function(){

        var myModal = document.getElementById('team-s')
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
            alert('success', 'New member added!');
            member_name_inp.value = '';
            member_picture_inp.value = '';
            get_members();

        }
    }
    // Gửi yêu cầu với dữ liệu
    xhr.send(data);
}

function get_members(){
    let xhr = new XMLHttpRequest();

    // Cấu hình yêu cầu: Phương thức POST, URL đích "ajax/settings_crud.php", không đồng bộ
    xhr.open("POST", "ajax/settings_crud.php", true);

    // Đặt tiêu đề yêu cầu để xác định loại nội dung
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Hàm gọi lại để xử lý phản hồi khi nó được nhận
    xhr.onload = function(){
        document.getElementById('team-data').innerHTML = this.responseText;
    }

    xhr.send('get_members');
}

function rem_member(val){
let xhr = new XMLHttpRequest();

// Cấu hình yêu cầu: Phương thức POST, URL đích "ajax/settings_crud.php", không đồng bộ
xhr.open("POST", "ajax/settings_crud.php", true);

// Đặt tiêu đề yêu cầu để xác định loại nội dung
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

// Hàm gọi lại để xử lý phản hồi khi nó được nhận
xhr.onload = function(){
    if(this.responseText==1){
        alert('success', 'Member removed');
        get_members();
    }
    else{
        alert('error', 'Server down');
    }
}

xhr.send('rem_member='+val);
}


window.onload = function () {
    // Gọi hàm get_general khi cửa sổ đã tải hoàn toàn
    get_general();
    get_contacts();
    get_members();
}


