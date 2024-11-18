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