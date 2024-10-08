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
