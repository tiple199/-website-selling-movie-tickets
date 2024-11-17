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

//Categories-film
function selectTab(selectedTab) {
    // Remove active class from all tabs
    document.querySelectorAll('.tab-option').forEach(tab => {
        tab.classList.remove('active');
    });

    // Add active class to the selected tab
    selectedTab.classList.add('active');

    // Move the underline
    const underline = document.querySelector('.underline');
    underline.style.width = `${selectedTab.offsetWidth}px`;
    underline.style.left = `${selectedTab.offsetLeft}px`;
}

// Initialize underline position on load
window.onload = () => {
    const activeTab = document.querySelector('.tab-option.active');
    const underline = document.querySelector('.underline');
    underline.style.width = `${activeTab.offsetWidth}px`;
    underline.style.left = `${activeTab.offsetLeft}px`;
};
document.addEventListener("DOMContentLoaded", function() {
    // Kiểm tra nếu không có 'catfilm' trong URL thì thêm 'active' cho thẻ 'Tất cả'
    const urlParams = new URLSearchParams(window.location.search);
    const catfilm = urlParams.get('catfilm');
    
    if (!catfilm) {
        document.getElementById('tab-tatca').classList.add('active');
    }
});


// phần hành động
document.addEventListener("DOMContentLoaded", function() {
    // Select all action buttons
    const actionButtons = document.querySelectorAll(".action-button");

    actionButtons.forEach(button => {
        button.addEventListener("click", function(event) {
            // Toggle the visibility of the dropdown menu
            const dropdown = this.nextElementSibling;
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";

            // Close other open dropdowns
            closeOtherDropdowns(dropdown);

            // Prevent event from bubbling up (for closing when clicking outside)
            event.stopPropagation();
        });
    });

    // Close all dropdowns when clicking outside
    document.addEventListener("click", function() {
        closeAllDropdowns();
    });

    // Function to close all dropdowns
    function closeAllDropdowns() {
        document.querySelectorAll(".action-dropdown").forEach(dropdown => {
            dropdown.style.display = "none";
        });
    }

    // Function to close other open dropdowns except the current one
    function closeOtherDropdowns(currentDropdown) {
        document.querySelectorAll(".action-dropdown").forEach(dropdown => {
            if (dropdown !== currentDropdown) {
                dropdown.style.display = "none";
            }
        });
    }
});