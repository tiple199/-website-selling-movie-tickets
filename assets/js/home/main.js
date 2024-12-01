window.onload = function() {
    // Kiểm tra nếu URL chứa hash (phần sau dấu #)
    var hash = window.location.hash;

    if (hash) {
        // Tìm phần tử có id trùng với giá trị hash
        var element = document.querySelector(hash);
        if (element) {
            // Cuộn đến phần tử đó một cách mượt mà
            element.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
};

//kiểm tra đã nhập các trường khi đăng nhập chưa
function check() {
    if (f.txtusername.value == "") {
        alert("Bạn chưa nhập Username");
        f.txtusername.focus();
        return false;
    }
    else if (f.txtpassword.value == "") {
        alert("Bạn chưa nhập Password");
        f.txtpassword.focus();
        return false;
    }
}

// Lấy các phần tử từ DOM
const loginBtn = document.getElementById('loginBtn');
const overlay = document.getElementById('overlay');
const loginModal = document.getElementById('loginModal');
const registerModal = document.getElementById('registerModal');
const closeBtns = document.querySelectorAll('.close');
const showRegisterBtn = document.getElementById('showRegister');
const showLoginBtn = document.getElementById('showLogin');


// Khi người dùng click vào nút Đăng nhập để hiển thị form đăng nhập
loginBtn.onclick = function() {
    overlay.style.display = 'block';
    loginModal.style.display = 'block';
    registerModal.style.display = 'none';
}

// Khi người dùng click vào nút X để đóng các form
closeBtns.forEach(closeBtn => {
    closeBtn.onclick = function() {
        overlay.style.display = 'none';
        loginModal.style.display = 'none';
        registerModal.style.display = 'none';
    }
});

// Khi người dùng click ra ngoài lớp phủ để đóng form
overlay.onclick = function() {
    overlay.style.display = 'none';
    loginModal.style.display = 'none';
    registerModal.style.display = 'none';
    
}

// Khi người dùng click vào nút Đăng ký trong form đăng nhập
showRegisterBtn.onclick = function() {
    loginModal.style.display = 'none';
    registerModal.style.display = 'block';
}

// Khi người dùng click vào nút Quay lại Đăng nhập trong form đăng ký
showLoginBtn.onclick = function() {
    registerModal.style.display = 'none';
    loginModal.style.display = 'block';
}


// sidebar
document.addEventListener("DOMContentLoaded", function () {
    const menuItems = document.querySelectorAll(".menu-item");

    menuItems.forEach(item => {
        item.addEventListener("click", function () {
            // Remove 'active' class from all menu items
            menuItems.forEach(el => el.classList.remove("active"));

            // Add 'active' class to the clicked menu item
            this.classList.add("active");
        });
    });
});

    // Show trailer
    function show_trailer(movie_id){
        const hidden_trailer = document.querySelectorAll(".show_trailer");
        const show_trailer = document.getElementById(`show_trailer_${movie_id}`);
        hidden_trailer.forEach(trailer => {
        trailer.style.display = "none";
        });
    
        if (show_trailer) {
            overlay.style.display = "block";
            show_trailer.style.display = "block";
        }
    
        overlay.onclick = function() {
        overlay.style.display = 'none';
        const iframe = document.getElementById(`show_trailer_${movie_id}`);
        if (iframe) {
            iframe.src = iframe.src; // Dừng video bằng cách làm mới src
            iframe.style.display = "none";
            overlay.onclick = function() {
                overlay.style.display = 'none';
                loginModal.style.display = 'none';
                registerModal.style.display = 'none';
            }
        }
    };
    }
